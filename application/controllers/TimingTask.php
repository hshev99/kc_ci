<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class TimingTask extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}
	//订单完成 请求接口
	public function order_over(){
		$this->load->model('Timing_task_model');
		$this->Timing_task_model->order_over();

	}

	// 超过两小时未付款关闭订单
	public function order_shut(){
		$this->load->model('Timing_task_model');
		$this->Timing_task_model->order_shut();
	}

	// 超过时间歌手自动到场
	public function singer_present(){
		$this->load->model('Timing_task_model');
		$this->Timing_task_model->singer_present();
	}

	public function tt(){
		$this->load->model('User_reg_id_model');
		$arr = $this->User_reg_id_model->get_user_reg_id('15112345678');


		$this->pr($arr);
	}

	public function AES(){
		$this->load->model('User_reg_id_model');
		//$arr = $this->User_reg_id_model->get_user_reg_id('15112345678');

		$arr=[
			'name'=>"name",
			'pwd'=>'pwd'
		];

		$en=parent::encode(json_encode($arr));
		exit($en);
		$this->pr(parent::decode($en));
	}

	//客服通知数据
	public function order_notice(){
		$this->load->model('Timing_task_model');
		$this->Timing_task_model->order_notice();
	}
}
 ?>