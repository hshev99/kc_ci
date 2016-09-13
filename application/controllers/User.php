<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	public $uid;
	public $lc=0;
	

	public function __construct()
	{
		parent::__construct();

		$this->uid=$this->input->get('uid');
		$this->fans=$this->input->get('login_uid');
		$this->lc=$this->input->get('lc');
	}

	public function user_info_web(){
		$this->web=1;
		$data=$this->index();
		$data['base_url']=$this->base_url;
//		parent::pr($data);
		$this->load->view('/User/user_singer_info',$data);
	}

	public function user_info_logo_class_web(){
		$this->web=1;
		$data=$this->info();

		$data['css']=$this->base_url;

		$this->load->model('Style_model');
		$logo_class=$this->Style_model->get_logo_class();

		foreach ($logo_class as $key=>$val){
			if (!empty($data['style'])){
				foreach ($data['style'] as $v){
					if ($key == $v['id']) $logo_class[$key]['status']=1;
				}

				isset($logo_class[$key]['status']) ? '': $logo_class[$key]['status']=0;
			}else{
				$logo_class[$key]['status']=0;
			}

		}
		$data['style']=$logo_class;
		$this->load->view('/User/user_info_logo_class_web',$data);
	}

	//IOS风格标签保存接口
	public function save_user_style_ios(){

		$this->save_user_style(json_decode(parent::get_json(),true)['style']);

		exit(json_encode(parent::output(),true));
	}

	//修改用户基本信息
	public function update_user_info(){
		$this->load->model('User_info_model');

		$uid=$this->uid;
		$data=[];
		if (isset($_POST['special'])){
			empty($this->input->post('special')) ? $data['special']=''  : $data['special']=$this->input->post('special');
		}

		if (isset($_POST['price'])){
			empty($this->input->post('price')) ? $data['price']=0 : $data['price']=$this->input->post('price');
		}

		if (isset($_POST['history_price'])){
			empty($this->input->post('history_price')) ? $data['history_price']=0 : $data['history_price']=$this->input->post('history_price');
		}
		
		$this->User_info_model->update_user_info($uid,$data);

		exit(json_encode(parent::output()));
	}


	public function save_user_style($style=[]){

		if (!empty($style)){
			$logo=$style;
		}else{
			$logo=$this->input->post('style');
		}
		$this->load->model('Style_model');
		$logo_class=$this->Style_model->get_style();

		$data=[];
		$i=0;
		foreach ($logo as $val){
			if ($val){
				$id=is_array($val) ? $val['id']:$val;
				$data[$i]['id']=$id;
				$data[$i]['name']=$logo_class[$id]['name'];
				$i++;
			}
		}
		if (!empty($logo)){
			$this->Style_model->save_style($this->uid,serialize($data));
		}

		if (!empty($logo_ios)){
			return true;
		}
	}
	public function index()
	{
		// echo 1;die;
		$this->load->model('User_info_model');

		$arr['info']=$this->User_info_model->get_user_info($this->uid);

		$arr['img']=$this->User_info_model->get_user_img($this->uid);
		$arr['introduce']=$this->User_info_model->introduce($this->uid);
		$arr['on_date_defult']=$this->User_info_model->on_date_defult($this->uid);
		$arr['evaluation_defult']=$this->User_info_model->evaluation_defult($this->uid);

		$this->load->model('User_focus_model');
		if ($this->fans)$arr['info']['collection']=$this->User_focus_model->see_fans($data=['uid'=>$this->fans,'fans'=>$this->uid]);
		//参加活动
		$this->load->model('User_tag_activity_model');
		$arr['activity']=$this->User_tag_activity_model->get_user_tag_activity_selected($this->uid);
		$arr['info']['tel']='13070101292';
		//介绍
		$this->load->model('User_works_baike_model');
		$arr['info']['introduction']=$this->User_works_baike_model->get_user_works_baike($this->uid);
		if ($this->web) return $arr;
		exit(json_encode($this->output($arr),true));
	}

	//用户基本信息
	public function info(){
		$this->load->model('User_info_model');
		$arr=$this->User_info_model->get_user_info($this->uid);

		$this->load->model('User_focus_model');
		empty($this->fans) ? '' :$arr['collection']=$this->User_focus_model->see_fans($data=['uid'=>$this->uid,'fans'=>$this->fans]);
		if ($this->web) return $arr;
		exit(json_encode($this->output($arr),true));
	}

	//用户图片
	public function img(){
		$arr=[
				['url'=>"http://img3.imgtn.bdimg.com/it/u=4271053251,2424464488&fm=21&gp=0.jpg"],
				['url'=>"http://img3.imgtn.bdimg.com/it/u=4271053251,2424464488&fm=21&gp=0.jpg"],
				['url'=>"http://img3.imgtn.bdimg.com/it/u=4271053251,2424464488&fm=21&gp=0.jpg"],
		];

		$this->load->model('User_info_model');
		$arr=$this->User_info_model->get_user_img($this->uid);

		exit(json_encode($this->output($arr),true));
	}

	//用户作品
	public function introduce(){
		$this->load->model('User_info_model');
		$arr=$this->User_info_model->introduce($this->uid);
		exit(json_encode($this->output($arr),true));
	}

	//用户_音乐
	public function introduce_music(){
		$this->load->model('User_info_model');
		$arr=$this->User_info_model->introduce_music($this->uid);
		exit(json_encode($this->output($arr),true));
	}

	//用户_video
	public function introduce_video(){
		$this->load->model('User_info_model');
		$arr=$this->User_info_model->introduce_video($this->uid);
		exit(json_encode($this->output($arr),true));
	}

	//可预约档期
	public function on_date_defult(){
		$arr=[];
		for ($i=0;$i<7;$i++){
			$sdefaultDate = date("Y-m-d",time());
			if($i >0 ) $sdefaultDate=date('Y-m-d',strtotime("$sdefaultDate +$i days"));

			$f=rand(0,1) ==1 ? 'T':"F";
			$arr[]=[
				'week'=> mb_substr( "日一二三四五六",date("w",strtotime($sdefaultDate)),1,"utf-8" ),
				'status'=>$f,
				'date'=>strval((int)substr(date('Y-m-d',strtotime("$sdefaultDate")),-2,2))
			];
			//[$f]=date('Y-m-d',strtotime("$sdefaultDate"));
		}

		exit(json_encode($this->output($arr),true));
	}

	public function on_date_all(){

		$arr=[];
		for ($i=0;$i<20;$i++){
			$arr[]=['time'=>'2016-12-12','status'=>'T'];
		}

	}

	//评价
	public function evaluation_defult(){
		$this->page=$this->input->get('page');
		$this->load->model('User_info_model');
		$arr['other']=$this->User_info_model->evaluation_other($this->uid,$this->page);
		exit(json_encode($this->output($arr),true));
	}

	//接口输出
	public function output($arr=[],$res='success',$error=0,$errorMsg=''){
		$arr=[
			'error'=>$error,
			'status'=>$res,
			'errorMsg'=>$errorMsg,
			'results'=>$arr
		];
		return $arr;
	}
}
