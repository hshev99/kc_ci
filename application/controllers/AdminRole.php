<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminRole extends CI_Controller {

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
	public function getAdminRole(){

        $data=json_decode(parent::get_json(),true);
        $search=[];

        isset($data['role_id'])&&!empty($data['role_id']) ? $search['role_id']=$data['role_id'] :'';

		$this->load->model('ReadAdminRole_model');
		$result=$this->ReadAdminRole_model->getAdminRole($this->uid,$search);

		if (!$result){
			parent::outPutEnd([],109,'暂无数据');
		}else{
			parent::outPutEnd($result);
		}
	}

	public function postAdminRole(){
        $data=json_decode(parent::get_json(),true);
        $search=[];
        isset($data['role_id'])&&!empty($data['role_id']) ? $search['role_id']=$data['role_id'] :'';
        isset($data['role_name'])&&!empty($data['role_name']) ? $search['role_name']=$data['role_name'] :'';
        isset($data['description'])&&!empty($data['description']) ? $search['description']=$data['description'] :'';

        $this->load->model('ReadAdminRole_model');
        $result=$this->ReadAdminRole_model->postAdminRole($this->uid,$search);
        if (!$result){
            parent::outPutEnd([],109,empty($data['role_id'])?'添加失败':'修改失败');
        }else{
            parent::outPutEnd([],0,empty($data['role_id'])?'添加成功':'修改成功');
        }

    }

    public function getAdminRoleModule(){
        $data=json_decode(parent::get_json(),true);
        $search=[];
        isset($data['role_id'])&&!empty($data['role_id']) ? $search['role_id']=$data['role_id'] :$search['role_id']=1;


        $this->load->model('ReadAdminRole_model');
        $result=$this->ReadAdminRole_model->getAdminRoleModule($this->uid,$search);

        $arr=[];
        foreach ($result as $val){
            $arr[]=$val['module_id'];
        }

        $this->load->model('ReadAdminModule_model');
        $result=$this->ReadAdminModule_model->getAdminModule($this->uid,$search=["child"=>"Y"],$arr);


        $this->pr($result);




        if (!$result){
            parent::outPutEnd([],109,'暂无数据');
        }else{
            parent::outPutEnd($result);
        }

    }

	public function tt(){

	}
}
