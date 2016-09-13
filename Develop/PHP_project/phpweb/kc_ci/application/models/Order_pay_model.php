<?php

/**
 * Created by PhpStorm.
 * User: hshev99
 * Date: 16/6/12
 * Time: 上午10:52
 */
class Order_pay_model extends CI_Model
{
    public $orders_sn;

    public function __construct()
    {
        parent::__construct();
    }


    //更新用户信息
    public function update_order_pay($order_sn,$data=[]){
        $where = "order_sn = ".$order_sn;
        $this->orders=$this->load->database('orders',true);

        $this->orders->update('user_orders', $data, $where);
    }

    public function update_status($order_sn,$status){
        $where = "order_sn = ".$order_sn;
        $data=[
            'status'=>$status
        ];
        $this->orders=$this->load->database('orders',true);

        $this->orders->update('user_orders', $data, $where);
    }
    
}