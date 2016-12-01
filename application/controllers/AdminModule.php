<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminModule extends CI_Controller {

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
	public function getAdminModule(){

        $data=json_decode(parent::get_json(),true);
        $search=[
            'parent_id'=>isset($data['parent_id'])&&!empty($data['parent_id']) ? $data['parent_id'] : 0,

        ];

		$this->load->model('ReadAdminModule_model');
		$result=$this->ReadAdminModule_model->getAdminModule($this->uid,$search);

		if (!$result){
			parent::outPutEnd([],109,'暂无数据');
		}else{
			parent::outPutEnd($result);
		}
	}

	public function tt(){

	}
}
