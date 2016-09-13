<?php 
class Pay_model extends CI_Model
{
	public function __construct()
    {
        parent::__construct();
    }

    public function check($order_sn=''){
        $status_name=[
            1=>'未支付',
            2=>'已支付',
            3=>'支付失败',
        ];
        $this->orders=$this->load->database('orders',true);
        $sql="select id,pay_status from user_orders WHERE order_sn='{$order_sn}'";
        $query=$this->orders->query($sql);
        if (!empty($query->result())){
            foreach ($query->result() as $row){

                $arr=[
                    'pay_status'=>$row->pay_status,
                    'pay_status_name'=>$status_name[$row->pay_status]
                ];
            }
            return $arr;
        }else{
            $arr=[
                'pay_status'=>0,
                'pay_status_name'=>'无此订单'
            ];
        }
        return $arr;
    }
}
 ?>