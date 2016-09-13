<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Orderinfo extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->uid=$this->input->get('uid');
	}
	//我预约的
	public function index(){
		$this->load->model('Orders_deta_model');
		$orders=$this->Orders_deta_model->info_Orders($this->uid);
		if(!empty($orders)){
			$arr=[];
			foreach ($orders as $key => $val) {
				$order_val=array_merge(get_object_vars($val));
				$worker_uid=$order_val['worker_uid'];
				$user=$this->Orders_deta_model->info_User($worker_uid);
				foreach ($user as $key => $value) {
					$user_val=array_merge(get_object_vars($value));
					$arr[]=array_merge($order_val,$user_val);
				}
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