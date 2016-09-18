<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {


	public $uid;
	public $lc=0;

	public $user_login;

	public $phone;
	public $code;


	public function __construct()
	{
		parent::__construct();

		$this->phone=empty($this->input->post('phone')) ? '1' : $this->input->post('phone');
		$this->user_login=@$_SESSION['user_login'];
		$this->code=isset($_SESSION['code'][$this->phone]) ? $_SESSION['code'][$this->phone] : '';
	}

	public function index(){
		echo '123';exit;
	}

	public function login(){
		$this->load->view("/Login/login.html");
	}

	public function forget(){
		$this->load->view("/Login/forget.html");
	}

	public function registered(){
		$this->load->view("/Login/registered.html");
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

		$_SESSION[$this->phone]['code']=$code;
		$this->load->model('Ecd_model');

		$result=$this->Ecd_model->send_sms_code($phone,'1',$code);

		if (json_decode($result,true)['result'] == 0){

			$arr=[
				'msg'=>json_decode($result,true)['msg']
			];
			parent::outPutEnd($arr);

		}else{

			parent::outPutEnd([],105,json_decode($result,true)['msg']);
		}

		exit;
	}

	public function setUserPassword(){

		$code=$this->input->post('code');
		$phone=$this->input->post('phone');
		$password=$this->input->post('password');

		if (empty($this->code)) parent::outPutEnd([],106,'验证码已过期');
		if ($this->code != $code) parent::outPutEnd([],107,'验证码不正确');
		if (empty($password) || empty($phone)) parent::outPutEnd([],108,'手机号码或密码不能为空');

		$data=[
			'user_name'=>$phone,
			'login_name'=>$phone,
			'password'=>$password,
		];
		$this->load->model('WriteAdminUser_model');
		$result=$this->WriteAdminUser_model->upAdminUser($data);

		if (!$result){
			parent::outPutEnd([],109,'改账户未注册');
		}else{
			parent::outPutEnd(['msg'=>'修改成功']);
		}
	}
}
