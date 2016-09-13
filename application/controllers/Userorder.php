<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Userorder extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->uid=$this->input->get('uid');
		$this->status=isset($_GET['status']) ? $this->input->get('status') : '';
		$this->order_type=$this->input->get('order_type');

	}

	//预约我的
	public function UserOrderMy(){
		$this->load->model("User_order_model");
		exit(json_encode(parent::output($this->User_order_model->UserOrderMy($this->uid,$this->status))));
	}

	//我预约的
	public function UserOrder(){
		$this->load->model("User_order_model");
		exit(json_encode(parent::output($arr=$this->User_order_model->UserOrder($this->uid,$this->status))));
	}
	//预约我的
	public function index(){
		// var_dump($this->uid);die;
		$this->load->model("User_order_model");
		$orders=$this->User_order_model->info_Orders($this->uid);
		if(!empty($orders)){
			foreach ($orders as $key => $value) {
				$order_val=get_object_vars($value);
				$user=$this->User_order_model->info_user($this->uid);
				$user_val=get_object_vars($user[0]);
				$arr[]=array_merge($order_val,$user_val);
			}
			exit(json_encode(parent::output($arr),true));
		}else{
			exit(json_encode(parent::output([]),true));
		}
	}
	//接口输出
	public function order_outop($arr=[],$res='success',$error=0,$errorMsg=''){
		$arr=[
			'error'=>$error,
			'status'=>$res,
			'errorMsg'=>$errorMsg,
			'results'=>$arr
		];
		return $arr;
	}
}
 ?>