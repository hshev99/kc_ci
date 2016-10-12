<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public $user_login;

	public $phone;
	public $code;


	public function __construct()
	{
		parent::__construct();

		$this->phone=empty($this->input->post('phone')) ? '1' : $this->input->post('phone');
		$this->user_login=@$_SESSION['user_login'];
		$this->code=isset($_SESSION['code']) ? $_SESSION['code'] : '';
	}

	public function index(){
		$this->load->view("/Login/login.html");
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
		$data=json_decode(parent::get_json(),true);

		$this->login_name=$data['login_name'];
		$this->password=$data['password'];

		//验证 sign
		$this->sign = $data['sign'];

		$sign= md5(md5(md5($this->login_name . 'tuodui2016').date("m-d")));

		if ($sign !=  substr($this->sign,10,32)) exit(json_encode(parent::output([],104,$sign)));

		if ($this->login_name=='' || $this->password=='') exit(json_encode(parent::output([],101,'用户名密码不能为空')));

		$data=[];
		$data['login_name']=$this->login_name;
		$data['password']=$this->password;

		$this->load->model('ReadAdminUser_model');
		$result=$this->ReadAdminUser_model->getAdminUser($data);




		if (empty($result)){
			exit(json_encode(parent::output([],102,'用户名或密码有误')));
		}

		$uid=$result['user_id'];
		$user_name = $result['user_name'];

		$result['token']=md5(md5($uid).date("YmdHis"));

		$this->_redis->setex($result['token'],'43200',json_encode($result));

//		$_SESSION['user_login']=$result;

		exit(json_encode(parent::output($result)));

	}

	public function quitAdminUser(){

		$this->_redis->del($this->token);

		exit(json_encode(parent::output(['msg'=>'退出登录成功'])));
	}

	public function sync(){

		exit(json_encode(parent::output(['data'=>date("Y-m-d H:i:s")])));
	}

	public function getSmsCode(){

		$data=json_decode(parent::get_json(),true);

		$this->phone=$data['phone'];
		$this->sign=$data['sign'];

		//验证 sign
		$sign= md5(md5(md5($this->phone . 'tuodui2016').date("m-d")));

		if ($sign !=  substr($this->sign,10,32)) exit(json_encode(parent::output([],104,$sign)));



		if (empty($this->phone)) exit(json_encode(parent::output([],103,'手机号码不能为空')));

		if (strlen($this->phone) != '11') exit(json_encode(parent::output([],104,'手机号码不合法')));

		$code=rand(1000,9999);

		$_SESSION['code'][$this->phone]=$code;
		$this->load->model('Ecd_model');

		$result=$this->Ecd_model->send_sms_code($this->phone,'1',$code);

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
		$data=json_decode(parent::get_json(),true);

		$this->phone=$data['phone'];
		$this->code_accept=$data['code'];
		$this->password=$data['password'];

		$this->sign=$data['sign'];

		$sign= md5(md5(md5($this->phone . 'tuodui2016').date("m-d")));

		if ($sign !=  substr($this->sign,10,32)) exit(json_encode(parent::output([],104,$sign)));


		if (empty($this->code[$this->phone])) parent::outPutEnd([],106,'验证码已过期');
		if ($this->code[$this->phone] != $this->code_accept) parent::outPutEnd([],107,'验证码不正确');
		if (empty($this->password) || empty($this->phone)) parent::outPutEnd([],108,'手机号码或密码不能为空');

		$arr=[
			'user_name'=>$this->phone,
			'login_name'=>$this->phone,
			'password'=>$this->password,
		];
		$this->load->model('WriteAdminUser_model');
		$result=$this->WriteAdminUser_model->upAdminUser($arr);

		if (!$result){
			parent::outPutEnd([],109,'改账户未注册');
		}else{
			parent::outPutEnd(['msg'=>'修改成功']);
		}
	}
}
