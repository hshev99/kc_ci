<?php 
class ReadCargo_model extends CI_Model
{
	public function __construct()
    {
        parent::__construct();

        $this->cargo = $this->load->database('cargo',TRUE);
    }

    public function getCargo($admin_id='',$status=1,$page=1,$l=12,$search){
        if (!$admin_id) return false;

        $this->load->model('ReadCargoPrice_model');

        $this->load->model('ReadPersonCompany_model');


        $where ='';
        if ($status == 0){

        }else{
            $where .=" and status in ({$status})";
        }


        $where .=" and shipper_id={$admin_id}";

        //搜索条件

        if ($search['cargo_sn']) $where .=" and cargo_sn='{$search['cargo_sn']}' ";

        if ($search['send_address']) $where .=" and send_address like '%{$search['send_address']}%'";
        if ($search['receive_address']) $where .=" and receive_address like '%{$search['receive_address']}%'";


        if ($search['start_time']) $where .=" and start_time > '{$search['start_time']}' ";
        if ($search['end_time']) $where .=" and end_time < '{$search['end_time']}' ";

        $limit='limit '.$l*($page-1).','.$l;

        $sql="SELECT * FROM hz_cargo WHERE 1 $where  $limit";
        $query=$this->cargo->query($sql);

        $sql_count="SELECT COUNT(1) as a FROM hz_cargo WHERE 1 $where ";
        $query_count=$this->cargo->query($sql_count);

        empty($query_count->result()) ? $pageCount=0 : $pageCount=ceil($query_count->result()[0]->a /$l);
        empty($query_count->result()) ? $totalCount=0 : $totalCount=ceil($query_count->result()[0]->a);
        $status_name=[
            0=>'异常',
            1=>'询价中',
            2=>'进行中',
            3=>'待付款',
            4=>'已完成',
            5=>'已取消',
            6=>'已过期'
        ];
        $result=[];
        $result['page']=[
            'curpage'=>$page,
            'limit'=>$l,
            'pageCount'=>$pageCount,
            'totalCount'=>$totalCount
        ];
        if(!empty($query->result())){
            foreach ($query->result() as $row) {
                $arr['cargo_sn']=$row->cargo_sn;

                $arr['send_address']=$row->send_address;
                $arr['receive_address']=$row->receive_address;

                $arr['start_time']=date("Y/m/d",strtotime($row->start_time));
                $arr['end_time']=date("Y/m/d",strtotime($row->end_time));

                $arr['cargo_detail']=$row->cargo_name.'/'.$row->cargo_weight.'吨';

                $arr['cargo_price_time'] = $this->ReadCargoPrice_model->getCargoPrice($row->id).'/次';

                $arr['status']=$row->status;
                $arr['status_name']=$status_name[$row->status];

                $arr['operate']=self::CargoOperate($row->status);

                if ($status == 2 || $status==3 || $status==4){
                    $cargo_price=$this->ReadCargoPrice_model->getCargoPricedetail($row->id);

                    if (empty($cargo_price)){
                        $arr['company']='---';
                        $arr['freight_price']='---';
                        $arr['freight_total_price']='---';
                    }else{
                        $arr['company']=$this->ReadPersonCompany_model->getPersonCompany($cargo_price['company_id']);
                        $arr['freight_price']=$cargo_price['expect_price'].'/吨';
                        $arr['freight_total_price']=number_format(($cargo_price['expect_price']*$cargo_price['ton_count']),2).'/吨';

                        $arr['progress'] = 0.45;
                    }

                }

                if ($status == 5) $arr['cancel_time']=$row->cancel_time;


                $result['result'][]=$arr;
            }
            return $result;
        }else{
            return '';
        }
    }

    public function CargoOperate($status=1){

        $arr=[];

        $arr[]=[
            'name'=>'货单详情',
            'url'=>'CargoDetail'
        ];

        $arr[]=[
            'name'=>'报价信息',
            'url'=>'CargoPriceList'
        ];

        if ($status ==1) $arr[]=[
            'name'=>'取消发货',
            'url'=>'CargoRemove'
        ];

        $arr[]=[
            'name'=>'再来一单',
            'url'=>'CargoAgain'
        ];

        return $arr;
    }

    public function getCargoDefault($uid=''){
        if (!$uid) return false;

        //调用默认货物类型
        $this->load->model('ReadGoodsType_model');
        $goods_type=$this->ReadGoodsType_model->getUserGoodsType($uid);

        $sql="SELECT * FROM hz_cargo WHERE shipper_id={$uid} ORDER BY id DESC limit 1";
        $query=$this->cargo->query($sql);

        $result=[];
        if(!empty($query->result())){
            foreach ($query->result() as $row) {
                $arr['send_user_mobile']=$row->send_user_mobile;
                $arr['send_user_name']=$row->send_user_name;
                $arr['send_address']=$row->send_address;


                $arr['receive_address']=$row->receive_address;
                $arr['receive_user_mobile']=$row->receive_user_mobile;
                $arr['receive_user_name']=$row->receive_user_name;

                $arr['goods_type_default']=$goods_type;
                $result=$arr;
            }
            return $result;
        }else{
            return '';
        }
    }

    /*
     * @content 货单详情
     * */
    public function getCargoDetail($cargo_sn=''){

        if (empty($cargo_sn)) return false ;

        $sql="SELECT * FROM hz_cargo WHERE cargo_sn='{$cargo_sn}' ";
        $query=$this->cargo->query($sql);

        $result =[];
        //

        $result['cargo_info']=[];
        $cargo_id=0;
        if (!empty($query->result())) foreach ($query->result() as $row){
            $arr=[
                'send_address'=>is_null($row->send_address) ? '' : $row->send_address,
                'send_user_name'=>is_null($row->send_user_name) ? '' : $row->send_user_name,
                'send_user_mobile'=>is_null($row->send_user_mobile) ? '' : $row->send_user_mobile,
                'send_time'=>$row->send_start_time .'至'. $row->send_end_time,

                'receive_address'=> is_null($row->receive_address) ? '' : $row->receive_address,
                'receive_user_name'=>is_null($row->receive_user_name) ? '' : $row->receive_user_name,
                'receive_user_mobile'=>is_null($row->receive_user_mobile) ? '' : $row->receive_user_mobile,

                'cargo_name'=>$row->cargo_name,
                'cargo_weight'=>$row->cargo_weight.'吨'
            ];

            $cargo_id=$row->id;
            $result['cargo_info'] = $arr;
        }

        //承运公司
        $result['transport_info']=[];
        if ($cargo_id){
            $this->load->model('ReadCargoPrice_model');
            $result['transport_info']=$this->ReadCargoPrice_model->getCaogoTransportInfo($cargo_id);
        }


        //送达信息
        $result['delivery_info']=[];

        $delivery_info=[
            'initial_weight'=>'1000吨',
            'accept_total_weight'=>'999.5吨',
            'order'=>[
                0=>[
                    'order_sn'=>'MJ1233123',
                    'end_time'=>'09-20 12:00:00',
                    'accept_weight'=>'399.5吨'
                ],
                1=>[
                    'order_sn'=>'MJ3213433',
                    'end_time'=>'09-21 12:22:12',
                    'accept_weight'=>'500吨'
                ]
            ]
        ];

        $result['delivery_info']=$delivery_info;


        //支付信息
        $result['pay_info']=[];
        $pay_info=[
            
        ];
        return $result;
    }

}
 ?>