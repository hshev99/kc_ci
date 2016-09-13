<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class OrderDate extends CI_Controller {

	public $uid;
	public $lc=0;
	

	public function __construct()
	{
		parent::__construct();

		$this->uid=$this->input->get('uid');
		$this->lc=$this->input->get('lc');
	}



	public function get_order_date(){

		$this->load->model("Order_date_model");

		exit(json_encode(parent::output($this->Order_date_model->get_order_date($this->uid))));
	}

	public function get_order_date2(){

		$this->load->model("Order_date_model");

		$arr=$this->Order_date_model->get_order_date2($this->uid);
		exit(json_encode(parent::output($arr)));
	}


	public function set_order_date(){
		$data=json_decode(parent::get_json(),true)['schedule'];
		$this->load->model("Order_date_model");
		if (!empty($data)){
			exit(json_encode(parent::output($this->Order_date_model->set_order_date_arr($this->uid,$data))));
		}else{
			$arr=[
				"operation"=> "F",
    			"msg"=>"操作成功"
			];
			exit(json_encode(parent::output($arr)));
		}

	}

	public function set_order_date2(){
		$data=json_decode(parent::get_json(),true);
		$arr=[];
		foreach ($data as $val){

			$arr[]['date_time']=strtotime(substr($val,9,8));
		}

		$this->uid=$this->input->get('uid');
		$this->load->model("Order_date_model");
		exit(json_encode(parent::output($this->Order_date_model->set_order_date_arr($this->uid,$arr))));
	}
	
}
