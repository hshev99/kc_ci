<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {


	public $uid;
	public $lc=0;
	

	public function __construct()
	{
		parent::__construct();

		$this->uid=$this->input->get('uid');
		$this->lc=$this->input->get('lc');
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
		exit(json_encode(parent::output($this->ReadAdminUser_model->getAdminUser($data))));

	}
}
