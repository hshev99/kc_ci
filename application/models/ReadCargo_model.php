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

        $order_by =' order by id DESC ';

        $sql="SELECT * FROM hz_cargo WHERE 1 $where  $order_by $limit ";
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

                $arr['cargo_detail_name']=$row->cargo_name;
                $arr['cargo_detail_weight']=$row->cargo_weight.'吨';

                $arr['cargo_price_time'] = $this->ReadCargoPrice_model->getCargoPrice($row->id).'/次';

                $arr['status']=$row->status;
                $arr['status_name']=$status_name[$row->status];

                $arr['operate']=self::CargoOperate($row->status,$row->cargo_sn);

                if ($status == 2 || $status==3 || $status==4){
                    $cargo_price=$this->ReadCargoPrice_model->getCargoPricedetail($row->id);

                    if (empty($cargo_price)){
                        $arr['company']='---';
                        $arr['freight_price']='---';
                        $arr['freight_total_price']='---';
                        $arr['progress'] = (float)sprintf("%.2f",substr(sprintf("%.3f", (rand(0,100)/100)), 0, -2)) ;
                        $arr['progress_color'] = '#61C3E1';
                        $arr['progress_background'] = rand(0,1) == 1 ? '#eee' : '#FF6A67';

                        $arr['warning'] =0;
                        if ($arr['progress_background'] == '#FF6A67') $arr['warning'] =1;
                    }else{
                        $arr['company']=$this->ReadPersonCompany_model->getPersonCompany($cargo_price['company_id']);

                        $arr['company_arr'] ='';
                        foreach ($cargo_price['company_id_arr'] as $val){

                            $arr['company_arr'] .= @$this->ReadPersonCompany_model->getPersonCompany($val)['company_name'].'/';
//                            $arr['company_arr'] = $this->ReadPersonCompany_model->getPersonCompany($val).'/';
                        }
                        $arr['freight_price']=$cargo_price['expect_price'].'/吨';
                        $arr['freight_total_price']=number_format(($cargo_price['expect_price']*$cargo_price['ton_count']),2).'/吨';

                        $arr['progress'] = (float)sprintf("%.2f",substr(sprintf("%.3f", (rand(0,100)/100)), 0, -2));

                        $arr['progress_color'] = '#61C3E1';
                        $arr['progress_background'] = rand(0,1) == 1? '#eee' : '#FF6A67';

                        $arr['warning'] =0;
                        if ($arr['progress_background'] == '#FF6A67') $arr['warning'] =1;
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

    public function CargoOperate($status=1,$cargo_sn=''){

        $this->load->model('ReadCargoPrice_model');
        $arr=[];

        $arr[]=[
            'name'=>'货单详情',
            'url'=>'CargoDetail'
        ];

        $result=$this->ReadCargoPrice_model->getCargoPriceList('',$params=['cargo_sn'=>$cargo_sn]);
        if (!empty($result)){
            $arr[]=[
                'name'=>'报价信息',
                'url'=>'CargoPriceList'
            ];
        }


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

    public function getCargoDefault($uid='',$cargo_sn=''){
        if (!$uid) return false;

        //调用默认货物类型
        $this->load->model('ReadGoodsType_model');
        $goods_type=$this->ReadGoodsType_model->getUserGoodsType($uid);

        $where ='';
        if ($cargo_sn) $where .=" and cargo_sn='{$cargo_sn}' ";
        $sql="SELECT * FROM hz_cargo WHERE shipper_id={$uid} $where ORDER BY id DESC limit 1";
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
                $arr['cargo_weight']=$row->cargo_weight;
                $arr['expect_price']=$row->expect_price;
                $arr['cargo_name']=$row->cargo_name;

                $arr['goods_type_default']=$goods_type;


                $result=$arr;
            }
            return $result;
        }else{
//            return '';

            $arr=[];
            $arr['send_user_mobile']='';
            $arr['send_user_name']='';
            $arr['send_address']='';


            $arr['receive_address']='';
            $arr['receive_user_mobile']='';
            $arr['receive_user_name']='';

            $arr['goods_type_default']=$goods_type;
            $result=$arr;
            return $result;
        }
    }

    /*
     * @content 货单详情
     * */
    public function getCargoDetail($cargo_sn=''){

        $status_name=[
            0=>'异常',
            1=>'询价中',
            2=>'进行中',
            3=>'待付款',
            4=>'已完成',
            5=>'已取消',
            6=>'已过期'
        ];

        $deliver=[2,3,4,];

        $pay_status_name=[
            1=>'线下支付',
            2=>'线上支付'
        ];
        if (empty($cargo_sn)) return false ;

        $sql="SELECT * FROM hz_cargo WHERE cargo_sn='{$cargo_sn}' ";
        $query=$this->cargo->query($sql);

        $result =[];
        //
        $result['cargo_info']=[];
        $result['status_info']=[];
        $cargo_id=0;
        $status=0;
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
                'cargo_weight'=>$row->cargo_weight.'吨',
                'expect_price'=>$row->expect_price.'元/吨',
            ];

            $result['status_info']=[
                'status'=>(int)$row->status,
                'status_name'=>$status_name[$row->status]
            ];


            $cargo_id=$row->id;
            $result['cargo_info'] = $arr;

            //系统信息
            $this->load->model('ReadLog_model');
            $log=$this->ReadLog_model->getLog($cargo_id);
            $result['system']=[
                'cargo_sn'=>$row->cargo_sn,
                'log'=>$log
            ];

            $status=$row->status;


            //支付信息
            $result['pay_info']=[
                'pay_status'=>(int)$row->pay_status,
                'pay_status_name'=>$pay_status_name[$row->pay_status]
            ];



        }

        // 运输 信息
        $result['carriage_info']=[];

        //承运公司
        $transport_info=[];
        if ($cargo_id && in_array($status,$deliver)){
            $this->load->model('ReadCargoPrice_model');
            $transport_info=$this->ReadCargoPrice_model->getCaogoTransportInfo($cargo_id);
        }

        $this->caravans = $this->load->database('caravans',TRUE);
        $car=[];
        foreach ($transport_info as $val){
            #####################################################
            $car['transport_info'] = $val;

            //送达信息
            $car['delivery_info']=[];

            $delivery_info=[];
            if (in_array($status,$deliver)){
                $delivery_info['initial_weight']='';
                $delivery_info['accept_total_weight']='';
                $delivery_info['order']='';


                $accept_total_weight=0;

                //查询运输信息
                $sql="select id,ton_count from hz_cargo_price WHERE cargo_id={$cargo_id} AND status=2 ";
                $query_cargo_price= $query=$this->cargo->query($sql);
                if (!empty($query_cargo_price->result())){
                    foreach ($query_cargo_price->result() as $row){
                        $delivery_info['initial_weight']=$row->ton_count.'吨';
                        $cargo_price_id = $row->id;

                        $voucher_sql="
                        select * from tb_order_voucher where `trade_order_id` IN
                         (
                            select id from tb_trade_order where `contract_id` in 
                                (
                                    select id from `tb_contract` where `hz_cargo_price_id`={$cargo_price_id}
                                )
                         );";

                        $voucher_query = $this->caravans->query($voucher_sql);
                        $trade_order=[];
                        if (!empty($voucher_query ->result())) foreach ($voucher_query->result() as $row){
                            $trade_order_arr=[
                                'order_sn'=>$row->trade_order_id,
                                'end_time'=>$row->updated,
                                'former_weight'=>$row->send_weight,
                                'accept_weight'=>$row->receive_weight,
                                'platform_scale_url'=>$row->voucher_url
                            ];
                            $accept_total_weight +=$row->send_weight;
                            $trade_order[]=$trade_order_arr;
                        }

                        $delivery_info['order']=$trade_order;
                    }
                }

                $delivery_info['accept_total_weight']=$accept_total_weight.'/吨';
                /*
                $delivery_info=[
                    'initial_weight'=>'1000吨',
                    'accept_total_weight'=>'999.5吨',
                    'order'=>[
                        0=>[
                            'order_sn'=>'MJ1233123',
                            'end_time'=>'09-20 12:00:00',
                            'former_weight'=>'399.5吨',
                            'accept_weight'=>'399.5吨',
                            'platform_scale_url'=>'https://ss3.baidu.com/9fo3dSag_xI4khGko9WTAnF6hhy/image/h%3D200/sign=034b11e55e4e9258b93481eeac83d1d1/b7fd5266d0160924a1705b9adc0735fae7cd34dd.jpg'
                        ],
                        1=>[
                            'order_sn'=>'MJ3213433',
                            'end_time'=>'09-21 12:22:12',
                            'former_weight'=>'500吨',
                            'accept_weight'=>'500吨',
                            'platform_scale_url'=>'https://ss3.baidu.com/9fo3dSag_xI4khGko9WTAnF6hhy/image/h%3D200/sign=034b11e55e4e9258b93481eeac83d1d1/b7fd5266d0160924a1705b9adc0735fae7cd34dd.jpg'
                        ]
                    ]
                ];
*/
                $car['delivery_info']=$delivery_info;
            }


            $car['pay_info']=[
                'pay_status'=>'1',
                'pay_status_name'=>$pay_status_name[1]
            ];

            $result['carriage_info'][]=$car;
            #####################################################
        }






        return $result;
    }

    public function getCargoOrder($cargo_sn='',$cargo_price_id=''){


        $sql="SELECT * FROM hz_cargo WHERE cargo_sn='{$cargo_sn}' ";
        $query=$this->cargo->query($sql);

        $pay_status_name=[
            1=>'线下支付',
            2=>'线上支付'
        ];
        $result=[];

        $result['cargo_info']=[];
        $result['pay_info']=[];
        if(!empty($query->result())){
            foreach ($query->result() as $row) {
                $arr['cargo_sn']=$row->cargo_sn;

                $arr['send_user_mobile']=$row->send_user_mobile;
                $arr['send_user_name']=$row->send_user_name;
                $arr['send_address']=$row->send_address;


                $arr['send_time']=date("Y/m/d",strtotime($row->start_time)).date("Y/m/d",strtotime($row->end_time));

                $arr['receive_address']=$row->receive_address;
                $arr['receive_user_mobile']=$row->receive_user_mobile;
                $arr['receive_user_name']=$row->receive_user_name;

                $arr['cargo_name']=$row->cargo_name;
                $arr['cargo_weight']=$row->cargo_weight.'吨';

                $pay['pay_status_name']=$pay_status_name[$row->pay_status];
                $pay['total_expect_price']=number_format(($row->cargo_weight * $row->expect_price),2).'元';

            }
            $result['cargo_info']=$arr;
            $result['pay_info']=$pay;


        }

        $result['transport_info']=[];



        $sql="select * from hz_cargo_price WHERE id={$cargo_price_id}";
        $query=$this->cargo->query($sql);
        $this->load->model('ReadPersonCompany_model');

        if (!empty($query->result())) foreach ($query->result() as $row){

            $company_info=$this->ReadPersonCompany_model->getPersonCompany($row->company_id);

            $transport['cargo_price_id']=$row->id;
            $transport['expect_price']=$row->expect_price.'元/吨';
            $transport['ton_count']=$row->ton_count.'/吨';
            $transport['company_name']=$company_info['company_name'];

            $result['transport_info']=$transport;
        }


        return $result;
    }

    
}
 ?>