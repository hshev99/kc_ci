<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cargo extends CI_Controller {

	public $user_login;
	public $uid;

	public function __construct()
	{
		parent::__construct();

		//判断是否登录
		if (!empty($_SESSION['user_login'])){
			$this->user_login=@$_SESSION['user_login'];
			$this->uid=$this->user_login['user_id'];
		}else{
			$this->uid=1;
//			$this->user_login= false;
//			header("Location:/Login/index");
		}

	}

	/*
	 * @content 发货列表
	 * @time 20160919
	 *
	 * */
	public function getCargoList(){


		$this->load->model('ReadCargo_model');
		$result=$this->ReadCargo_model->getCargo($this->uid);

		if (!$result){
			parent::outPutEnd([],109,'暂无数据');
		}else{
			parent::outPutEnd($result);
		}
	}
}
