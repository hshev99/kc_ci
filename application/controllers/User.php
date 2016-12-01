<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	public $user_login;
	public $uid;

	public function __construct()
	{
		parent::__construct();

		//判断是否登录
		/*
		if (!empty($_SESSION['user_login'])){
			$this->user_login=@$_SESSION['user_login'];
			$this->uid=@$this->user_login['user_id'];
		}else{
			$this->uid=1;
		}
		*/

	}

	/*
	 * @content 发货列表
	 * @time 20160919
	 *
	 * */
	public function getUser(){

        $page=isset($data['page'])&&!empty($data['page']) ? (int)$data['page'] : 1;
        $l=isset($data['limit'])&&!empty($data['limit']) ? (int)$data['limit'] : 12;


        $search=[
            'user_id'=>isset($data['user_id'])&&!empty($data['user_id']) ? $data['user_id'] : false,
            'login_name'=>isset($data['login_name'])&&!empty($data['login_name']) ? $data['login_name'] : false,
            'user_name'=>isset($data['user_name'])&&!empty($data['user_name']) ? $data['user_name'] : false,
        ];

		$this->load->model('ReadUser_model');
		$result=$this->ReadUser_model->getUser($admin_id='',$page,$l,$search);

		if (!$result){
			parent::outPutEnd([],109,'暂无数据');
		}else{
			parent::outPutEnd($result);
		}
	}

	public function tt(){

	}
}
