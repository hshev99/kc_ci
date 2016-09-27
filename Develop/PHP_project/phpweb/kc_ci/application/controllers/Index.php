<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends CI_Controller {


	public function __construct()
	{
		parent::__construct();


		//判断是否登录
//		if (!empty($_SESSION['user_login'])){
//			$this->user_login=@$_SESSION['user_login'];
//		}else{
//			$this->user_login= false;
//			header("Location:/Login/index");
//		}

	}

	public function index(){



//		$this->pr($this->_redis->set('xx','5'));

//		$this->pr($this->_redis->setex('xxx','10','ddd'));


//		exit();
//		$this->load->view("/Index/index.html");
//		parent::outPutEnd([],404,'You requested does not exist');
	}

	

}
