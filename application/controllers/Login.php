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

		$phone=$this->input->post('phone');

		if (empty($phone)) exit(json_encode(parent::output([],103,'手机号码不能为空')));

		if (strlen($phone) != '11') exit(json_encode(parent::output([],104,'手机号码不合法')));

		$code=rand(1000,9999);
		$this->load->model('Ecd_model');

		$result=$this->Ecd_model->send_sms_code($phone,'1',$code);

		if (json_decode($result,true)['result'] == 0){

			exit(json_decode(parent::output(json_decode($result,true)['msg'])));
		}else{
			exit(json_decode(parent::output([],105,json_decode($result,true)['msg'])));
		}

		exit;
	}
}
