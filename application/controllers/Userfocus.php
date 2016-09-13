<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Userfocus extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->uid=$this->input->get('uid');
	}
	//歌手主页
	public function Index(){
		$this->load->model('User_focus_model');
		$arr=$this->User_focus_model->Focus_index($this->uid);
		exit(json_encode(parent::output($arr),true));
	}

	//添加用户收藏
	public function save_fans(){
		$this->load->model('User_focus_model');

		$this->fans=$this->input->post('fans');
		$data=[
			'uid'=>$this->uid,
			'fans'=>$this->fans
		];
		$arr=$this->User_focus_model->save_fans($data);
		exit(json_encode(parent::output($arr),true));
	}

	//取消收藏
	public function del_fans(){
		$this->load->model('User_focus_model');

		$this->fans=$this->input->post('fans');
		$data=[
			'uid'=>$this->uid,
			'fans'=>$this->fans
		];
		$arr=$this->User_focus_model->del_fans($data);
		exit(json_encode(parent::output($arr),true));
	}
}
 ?>