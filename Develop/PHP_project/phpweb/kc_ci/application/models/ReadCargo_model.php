<?php 
class ReadCargo_model extends CI_Model
{
	public function __construct()
    {
        parent::__construct();

        $this->cargo = $this->load->database('cargo',TRUE);
    }

    public function getCargo($admin_id='',$status=1,$page=1,$l=12){
        if (!$admin_id) return false;

        $where ='';
        $where .=" and status in ({$status})";

        $where .=" and shipper_id={$admin_id}";
        $limit='limit '.$l*($page-1).','.$l;

        $sql="SELECT * FROM hz_cargo WHERE 1 $where  $limit";
        $query=$this->cargo->query($sql);

        $sql_count="SELECT COUNT(1) as a FROM hz_cargo WHERE 1 $where  $limit";
        $query_count=$this->cargo->query($sql_count);

        empty($query_count->result()) ? $totalCount=0 : $totalCount=ceil($query_count->result()[0]->a /$l);
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
            'totalCount'=>$totalCount
        ];
        if(!empty($query->result())){
            foreach ($query->result() as $row) {
                $arr['cargo_sn']=$row->cargo_sn;

                $arr['send_address']=$row->send_address;
                $arr['receive_address']=$row->receive_address;

                $arr['cargo_detail']=$row->cargo_name.'/'.$row->cargo_weight.'吨';

                $arr['status']=$row->status;
                $arr['status_name']=$status_name[$row->status];

                $arr['operate']=self::CargoOperate($row->status);


                $result['result'][]=$arr;
            }
            return $result;
        }else{
            return '';
        }
    }

    public function CargoOperate($status=1){

        $arr=[];
        if ($status == 1){
            $arr[]=[
                'name'=>'货单详情',
                'url'=>'CargoDetail'
            ];
        }elseif ($status ==2){
            $arr[]=[
                'name'=>'货单详情',
                'url'=>'CargoDetail'
            ];
        }

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

}
 ?>