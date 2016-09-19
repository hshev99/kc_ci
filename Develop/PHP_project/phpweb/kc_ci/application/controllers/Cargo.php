<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cargo extends CI_Controller {


	public $uid;
	public $lc=0;

	public $user_login;

	public $phone;
	public $code;


	public function __construct()
	{
		parent::__construct();

	}

	/*
	 * @content 发货列表
	 * @time 20160919
	 *
	 * */
	public function getCargoList(){


		$this->load->model('ReadCargo_model');
		$result=$this->ReadCargo_model->getCargo($user_id);

		if (!$result){
			parent::outPutEnd([],109,'暂无数据');
		}else{
			parent::outPutEnd($result);
		}
	}
}
