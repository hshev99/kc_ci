<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Fixehot extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}
	//热门搜索
	public function index(){
		$this->load->model('Fixe_hot_model');
		$fixe=$this->Fixe_hot_model->fixe_Hot();
		// var_dump($fixe);die;
		if(!empty($fixe)){
			exit(json_encode(parent::output($fixe),TRUE));
		}else{
			exit(json_encode(parent::output([]),TRUE));
		}
	}

	//添加活动记录
	public function activipy(){
		$data['uid']=$this->input->get('uid');
		$data['activity_time']=$this->input->post('activity_time');
		$data['activity_site']=$this->input->post('activity_site');
		$this->load->model('Fixe_hot_model');
		$add_activity=$this->Fixe_hot_model->activity($data);
		if($add_activity==1){
                $arrq=[
                    'status'=>0,
                    'errorMsg'=>'',
                    'error'=>'1',
                    'msg'=>'活动添加成功',
                ];
                exit(json_encode($arrq));
		}else if($add_activity==2){
                $arrq=[
                    'status'=>0,
                    'errorMsg'=>'',
                    'error'=>'2',
                    'msg'=>'网络忙，活动修改失败',
                ];
                exit(json_encode($arrq));
		}else if($add_activity==3){
                $arrq=[
                    'status'=>0,
                    'errorMsg'=>'',
                    'error'=>'3',
                    'msg'=>'无需重复添加当日活动',
                ];
                exit(json_encode($arrq));
		}
	}

	//修改活动记录
	public function upload_activipy(){
		$data['uid']=$this->input->get('uid');
		$data['activity_time']=$this->input->post('activity_time');
		$data['activity_site']=$this->input->post('activity_site');
		$data['new_activity_time']=$this->input->post('new_activity_time');
		$data['new_activity_site']=$this->input->post('new_activity_site');
		$this->load->model('Fixe_hot_model');
		$upload_activipy=$this->Fixe_hot_model->upload_activipy($data);

		if($upload_activipy==1){
                $arrq=[
                    'status'=>0,
                    'errorMsg'=>'',
                    'error'=>'1',
                    'msg'=>'活动修改成功',
                ];
                exit(json_encode($arrq));
		}else if($upload_activipy==2){
                $arrq=[
                    'status'=>0,
                    'errorMsg'=>'',
                    'error'=>'2',
                    'msg'=>'网络错误，活动修改失败，请重新修改！',
                ];
                exit(json_encode($arrq));
		}else if($upload_activipy==3){
                $arrq=[
                    'status'=>0,
                    'errorMsg'=>'',
                    'error'=>'3',
                    'msg'=>'修改活动信息错误',
                ];
                exit(json_encode($arrq));
		}
	}

	//删除活动记录
	public function del_activipy(){
		$data['uid']=$this->input->get('uid');
		$data['activity_time']=$this->input->post('activity_time');
		$data['activity_site']=$this->input->post('activity_site');
		$this->load->model('Fixe_hot_model');
		$del_activity=$this->Fixe_hot_model->del_activity($data);
		if($del_activity==1){
                $arrq=[
                    'status'=>0,
                    'errorMsg'=>'',
                    'error'=>'1',
                    'msg'=>'活动删除成功',
                ];
                exit(json_encode($arrq));
		}else if($del_activity==2){
                $arrq=[
                    'status'=>0,
                    'errorMsg'=>'',
                    'error'=>'2',
                    'msg'=>'没有此活动或日期不对',
                ];
                exit(json_encode($arrq));
		}else if($del_activity==3){
                $arrq=[
                    'status'=>0,
                    'errorMsg'=>'',
                    'error'=>'3',
                    'msg'=>'网络忙，活动删除失败',
                ];
                exit(json_encode($arrq));
		}
	}
	//查询活动记录
	public function select_activipy(){
		$data['uid']=$this->input->get('uid');
		$this->load->model('Fixe_hot_model');
		$select_activipy=$this->Fixe_hot_model->select_activipy($data);
		// var_dump($select_activipy);die;
		if(!empty($select_activipy)){
			exit(json_encode(parent::output($select_activipy),TRUE));
		}else{
			exit(json_encode(parent::output([]),TRUE));
		}
	}
	//接口输出
	public function order_outop($arr=[],$res='success',$error=0,$errorMsg=''){
		$arr=[
			'error'=>$error,
			'status'=>$res,
			'errorMsg'=>$errorMsg,
			'results'=>$arr
		];
		return $arr;
	}
}
 ?>