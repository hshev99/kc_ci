<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {


	public $uid;
	public $lc=0;
	

	public function __construct()
	{
		parent::__construct();
	}

	public function index(){
		echo '123';exit;
	}

	public function login(){
		$this->load->view("/Login/login.html");
	}

	public function getAdminUser(){
		$this->login_name=$this->input->post('login_name');
		$this->password=$this->input->post('password');

		if ($this->login_name=='' || $this->password=='') exit(json_encode(parent::output([],101,'用户名密码不能为空')));

		$data=[];
		$data['login_name']=$this->login_name;
		$data['password']=$this->password;

		$this->load->model('ReadAdminUser_model');
		$result=$this->ReadAdminUser_model->getAdminUser($data);

		if (empty($result)){
			exit(json_encode(parent::output([],102,'用户名或密码有误')));
		}

		exit(json_encode(parent::output($result)));

	}

	public function getSmsCode(){
		$this->Ecd=$this->load->model('Ecd_model');

		$this->pr($this->Ecd->send_sms_code('15301321671','1','2203'));
		$result=$this->Ecd->send_sms_code('15301321671','1','2203');
		$this->pr($result);
		parent::send_sms_code();
	}
}
