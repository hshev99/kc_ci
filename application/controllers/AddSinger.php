<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AddSinger extends CI_Controller {


	public $uid;
	public $lc=0;
	

	public function __construct()
	{
		parent::__construct();

		$this->uid=$this->input->get('uid');
		$this->lc=$this->input->get('lc');
	}

	public function index(){
		$this->load->model('User_singer_model');
		exit(json_encode(parent::output($this->User_singer_model->index($this->uid))));
	}

	public function add_its(){
		$this->uid=$this->input->post('uid');
		$this->its=$this->input->post('its');
		$date=[
			'uid'=>$this->uid,
			'its'=>$this->its
		];
		$this->load->model('User_singer_model');
		$this->User_singer_model->upload_its($date);
        $phone='15901016380';
        $rres="app旗下歌手";
        parent::add_user_verify_rres($rres,$phone);
        $phone='13681241738';
        $rres="app旗下歌手";
        parent::add_user_verify_rres($rres,$phone);
        $phone='13718077670';
        $rres="app旗下歌手";
        parent::add_user_verify_rres($rres,$phone);
		$arr=['uid'=>$this->uid];
		exit(json_encode(parent::output($arr)));
	}

	//获取歌手基本信息
	public function singer_info(){
		$this->load->model('User_singer_model');
		exit(json_encode(parent::output($this->User_singer_model->singer_info($this->uid))));
	}

	//删除歌手
	public function del_singer(){

		$singer_uid=$this->input->post('singer_uid');
		$this->load->model('User_singer_model');

		//断开关系
		$data_singer=[
			'uid'=>$this->uid,
			'singer_uid'=>$singer_uid
		];

		//歌手下线
		$this->load->model("User_info_model");
		$this->User_info_model->update_user_info($singer_uid,['del'=>'1']);

		exit(json_encode(parent::output($arr=['msg'=>$this->User_singer_model->del_user_singer($data_singer)])));

	}
	//添加基本信息
	public function add_info(){
		//注册用户 获得一个uid

		$name=$this->input->post('name');
		$phone=$this->input->post('phone');
		$email=$this->input->post('email');
		$home=$this->input->post('home');
		$img=$this->input->post('img');
		$singer_uid=$this->input->post('singer_uid');
		$gender=$this->input->post('gender');
		$keep=$this->input->post('keep');

		//歌手组合转换

		if ($gender == '男歌手'){
			$gender =1;
		}elseif ($gender == '女歌手'){
			$gender=0;
		}elseif ($gender == '组合'){
			$gender=2;
		}

		if ($singer_uid ==''){
			//注册用户
			$data_logo=[
				'phone'=>'0',
				'email'=>'0',
				'create_time'=>date("Y-m-d H:i:s")
			];
			$this->load->model('Login_model');
			$uid=$this->Login_model->add_user($data_logo);


			//添加用户基本信息

			$data_info=[];
			$data_info['uid']=$uid;
			isset($_POST['name']) ? $data_info['name']=$name : '';
			isset($_POST['type']) ? $data_info['type']='8':'';
			isset($_POST['home']) ? $data_info['home']=$home : '';
			isset($_POST['img']) ? $data_info['img']=$img :'';
			isset($_POST['phone']) ? $data_info['phone']=$phone :'';
			isset($_POST['email']) ? $data_info['email']=$email :'';
			isset($_POST['gender']) ? $data_info['gender']=$gender:'';

			$this->load->model('User_info_model');
			$this->User_info_model->add_user_info($data_info);

			//建立关系
			$data_singer=[
				'uid'=>$this->uid,
				'singer_uid'=>$uid
			];
			$this->load->model('User_singer_model');
			$this->User_singer_model->add_user_singer($data_singer);
		}else{
			$this->load->model('Login_model');
			$info_type=$this->Login_model->user_singer_type($singer_uid);
			// var_dump($info_type);die;
			if($info_type==8){
				$data_logo=[
					'phone'=>$name,
					'email'=>$email
				];
				// var_dump($data_logo);die;
				$this->load->model('Login_model');
				$uid=$this->Login_model->update_user($singer_uid,$data_logo);

				//更新 用户信息
				$data_info=[
					'name'=>$name,
					'type'=>$info_type,
					'home'=>$home,
					'phone'=>$phone,
					'email'=>$email
				];
				if (isset($_POST['img']) && !empty($_POST['img'])){
					$data_info['img']=$img;
				}

				$this->load->model('User_info_model');
				$this->User_info_model->update_user_info($singer_uid,$data_info);

			}else{
				// $data_logo=[
				// 	'phone'=>$phone,
				// 	'email'=>$email
				// ];
				// $this->load->model('Login_model');
				// $uid=$this->Login_model->update_user($singer_uid,$data_logo);

				//更新 用户信息
				$data_info=[
					'name'=>$name,
					'type'=>$info_type,
					'home'=>$home,
					'phone'=>$phone,
					'email'=>$email,
				];
				if (isset($_POST['img']) && !empty($_POST['img'])){
					$data_info['img']=$img;
				}

				$this->load->model('User_info_model');
				$this->User_info_model->update_user_info($singer_uid,$data_info);
			}
		}




		$singer_uid == '' ? '' :$uid=$singer_uid;
		exit(json_encode(parent::output(['uid'=>"$uid"])));
	}


}
