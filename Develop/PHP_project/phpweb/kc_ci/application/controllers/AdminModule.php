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
            'child'=>isset($data['child'])&&$data['child']=='N' ? 'N' : 'Y',

        ];

        isset($data['module_id'])&&!empty($data['module_id']) ? $search['module_id']=$data['module_id'] :'';

		$this->load->model('ReadAdminModule_model');
		$result=$this->ReadAdminModule_model->getAdminModule($this->uid,$search);

		if (!$result){
			parent::outPutEnd([],109,'暂无数据');
		}else{
			parent::outPutEnd($result);
		}
	}

	public function postAdminModule(){
        $data=json_decode(parent::get_json(),true);
        $search=[];
        isset($data['module_id'])&&!empty($data['module_id']) ? $search['module_id']=$data['module_id'] :'';
        isset($data['parent_id'])&&!empty($data['parent_id']) ? $search['parent_id']=$data['parent_id'] :'';
        isset($data['name'])&&!empty($data['name']) ? $search['name']=$data['name'] :'';
        isset($data['url'])&&!empty($data['url']) ? $search['url']=$data['url'] :'';
        isset($data['enabled'])&&!empty($data['enabled']) ? $search['enabled']=$data['enabled'] :'';
        isset($data['sort'])&&!empty($data['sort']) ? $search['sort']=$data['sort'] :'';

        $this->load->model('ReadAdminModule_model');
        $result=$this->ReadAdminModule_model->postAdminModule($this->uid,$search);
        if (!$result){
            parent::outPutEnd([],109,empty($data['module_id'])?'添加失败':'修改失败');
        }else{
            parent::outPutEnd([],0,empty($data['module_id'])?'添加成功':'修改成功');
        }

    }

	public function tt(){

	}
}
