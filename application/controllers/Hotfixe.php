<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Hotfixe extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->name=$this->input->get('name');
	}
	//搜素
	public function index(){
		$this->load->model('Hot_fixe_model');
		if(!empty($this->name)){
			$name=$this->Hot_fixe_model->hot_Fixe($this->name);
			exit(json_encode(parent::output($name),true));
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