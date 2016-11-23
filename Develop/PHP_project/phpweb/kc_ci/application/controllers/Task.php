<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public $user_login;

	public $phone;
	public $code;


	public function __construct()
	{
		parent::__construct();
	}


	public function quitAdminUser(){

		$this->_redis->del($this->token);

		exit(json_encode(parent::output(['msg'=>'退出登录成功'])));
	}


}
