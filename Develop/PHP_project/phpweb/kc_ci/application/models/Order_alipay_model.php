<?php 
class Order_alipay_model extends CI_Model
{
	public function __construct()
    {
        parent::__construct();
    }

    /**
     * @contetn 回调信息录入
     */
    public function set_order_alipay($data=[]){
        if (empty($data)) return '';
    	$this->orders = $this->load->database('orders',true);
        $this->orders->insert('order_alipay',$data);

    }


    /**
     * @content 退款接口
     * @author Safari
     */
    public function refund_order_alipay($order_sn=''){

        if (!$order_sn){return $arr=['msg'=>"无订单号",'refund_status'=>"F"];}

        $this->orders = $this->load->database('orders',true);
        $sql="select * from order_alipay WHERE out_trade_no='{$order_sn}'";
        $query=$this->orders->query($sql);
        $arr=[];
        if (!empty($query->result())) foreach ($query->result() as $row){

            $arr['app_id']='2016071501622025';//支付宝分配给开发者的应用ID
            $arr['method']='alipay.trade.refund';//接口名称
            $arr['format']='JSON';//接口名称
            $arr['charset']='utf-8';//接口名称
            $arr['sign_type']='RSA';//接口名称
            $arr['sign']=$row->sign;//接口名称
            $arr['timestamp']=date("Y-m-d H:i:s");//接口名称
            $arr['version']='1.0';//接口名称
            $arr['app_auth_token']='1.0';//接口名称

            $arr['out_trade_no ']=$row->out_trade_no ;
            $arr['trade_no ']=$row->trade_no ;
            $arr['refund_amount']=$row->total_fee;
            $arr['refund_reason']='正常退款';

        }

        return $arr;
    }
}
 ?>