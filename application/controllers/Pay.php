<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pay extends CI_Controller {


	public $uid;
	public $lc=0;
	

	public function __construct()
	{
		parent::__construct();

		$this->uid=$this->input->get('uid');
		$this->lc=$this->input->get('lc');
	}

	public function index(){
		$get=json_encode($_GET);
		$post=json_encode($_POST);
		parent::log($get.$post);
		exit();
	}

	public function alipay_notic($data = '')
	{

	}

	public function alipay(){parent::log_alipay(json_encode($_POST));
		$order_sn=$this->input->post('out_trade_no');
		$price=$this->input->post('total_fee');

		if (!$order_sn){echo 'falie';exit();}
		$this->load->model('Orders_deta_model');
		$order_data=$this->Orders_deta_model->order_detail($order_sn);

		if ($order_data['notice'] ==0){
			if($order_data['phone']==$order_data['boss_phone']){
				$add_user_orders_phone="15901016380";
				parent::boos_worker_phone($add_user_orders_phone,$order_data['phone'],$order_data['worker_phone']);
				//订单提交成功发送提示信息
				parent::submit_boss_order_message($order_sn,$order_data['phone'],$order_data['boss_uid']);

				parent::submit_worker_order_message($order_sn,$order_data['worker_phone'],$order_data['worker_uid']);

			}else{
				$add_user_orders_phone="15901016380";
				parent::boos_worker_phone($add_user_orders_phone,$order_data['phone'],$order_data['worker_phone']);
				//订单提交成功发送提示信息
				parent::submit_boss_order_message($order_sn,$order_data['phone']);

				parent::submit_boss_order_message($order_sn,$order_data['boss_phone'],$order_data['boss_uid']);

				parent::submit_worker_order_message($order_sn,$order_data['worker_phone'],$order_data['worker_uid']);
			}
		}

		if ($order_data['status']){
			$data=[
				'status'=>2,
				'pay_status'=>2,
				'notice'=>1,
				'pay_amount'=>$price
			];
			$this->load->model("Order_pay_model");
			$this->Order_pay_model->update_order_pay($order_sn,$data);
		}

			//记录支付宝支付回调值

			$this->load->model('Order_alipay_model');
			$this->Order_alipay_model->set_order_alipay($_POST);

			parent::log(json_encode($_POST));
			exit();
	}


	public function check(){
		sleep(1);
		$this->order_sn=$this->input->get('order_sn');
		$this->load->model('Pay_model');

		exit(json_encode(parent::output($this->Pay_model->check($this->order_sn))));
	}

	public function refund_order_alipay(){
		$order_sn=$this->input->post('order_sn');

		$this->load->model('Order_alipay_model');
		$data=$this->Order_alipay_model->refund_order_alipay($order_sn);

		$url="https://openapi.alipay.com/gateway.do";
//		$url="http://123.57.56.133:88";
		$arr=parent::curl_post_json($url,json_encode($data));
		$this->pr($arr);
	}

}
