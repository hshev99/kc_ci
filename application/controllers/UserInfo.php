<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class UserInfo extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->uid=$this->input->get('uid');
	}

	public function get_all_activity(){
		$this->load->model('User_activity_model');
		$arr=[
				'activity'=>$this->User_activity_model->get_user_activity()
		];
		exit(json_encode(parent::output($arr)));
	}

	public function set_user_activity(){
		$data=json_decode(parent::get_json(),true);
		$this->load->model('User_tag_activity_model');
		$this->User_tag_activity_model->update_user_tag_activity($this->uid,$data);
		$arr=[
			'msg'=>'修改成功'
		];
		exit(json_encode(parent::output($arr)));
	}
	public function get_user_activity(){

		$this->load->model('User_activity_model');
		$all_activity=$this->User_activity_model->get_user_activity();

		$this->load->model('User_tag_activity_model');
		$user_activity=$this->User_tag_activity_model->get_user_tag_activity($this->uid);
		$user_activity_id=[];
		if (!empty($user_activity)){
			foreach ($user_activity as $v){
				$user_activity_id[]=$v['activity_id'];
			}
		}

		$data=[];$i=0;
		foreach ($all_activity as $val){

			if (empty($user_activity_id)){
				$data[$i]=$val;
				$data[$i]['selected']="T";
			}else{
				if (!empty($user_activity_id) and in_array($val['id'],$user_activity_id)){
					$data[$i]=$val;
					$data[$i]['selected']="T";
				}else{
					$data[$i]=$val;
					$data[$i]['selected']="F";
				}
			}

			$i++;
		}
		$data=['activity'=>$data];
		exit(json_encode(parent::output($data)));

	}

	public function set_user_traffic(){
		$data=json_decode(parent::get_json(),true);
		$this->load->model('User_tag_traffic_model');
		$this->User_tag_traffic_model->update_user_tag_traffic($this->uid,$data);
		$arr=[
			'msg'=>'修改成功'
		];
		exit(json_encode(parent::output($arr)));
	}

	public function get_user_traffic(){

		$this->load->model('User_traffic_model');
		$all_traffic=$this->User_traffic_model->get_user_traffic();

		$this->load->model('User_tag_traffic_model');
		$user_traffic=$this->User_tag_traffic_model->get_user_tag_traffic($this->uid);
		$user_traffic_id=[];
		if (!empty($user_traffic)){
			foreach ($user_traffic as $v){
				$user_traffic_id[]=$v['traffic_id'];
			}
		}
		$data=[];$i=0;
		foreach ($all_traffic as $val){

			if (empty($user_traffic)){
				$data[$i]=$val;
				$data[$i]['selected']="T";
			}else{
				if (!empty($user_traffic_id) and in_array($val['id'],$user_traffic_id)){
					$data[$i]=$val;
					$data[$i]['selected']="T";
				}else{
					$data[$i]=$val;
					$data[$i]['selected']="F";
				}
			}

			$i++;
		}
		$data=['traffic'=>$data];
		exit(json_encode(parent::output($data)));

	}

	public function set_user_hotel(){
		$data=json_decode(parent::get_json(),true);
		$this->load->model('User_tag_hotel_model');
		$this->User_tag_hotel_model->update_user_tag_hotel($this->uid,$data);
		$arr=[
			'msg'=>'修改成功'
		];
		exit(json_encode(parent::output($arr)));
	}

	public function get_user_hotel(){

		$this->load->model('User_hotel_model');
		$all_hotel=$this->User_hotel_model->get_user_hotel();

		$this->load->model('User_tag_hotel_model');
		$user_hotel=$this->User_tag_hotel_model->get_user_tag_hotel($this->uid);
		$user_hotel_id=[];
		if (!empty($user_hotel)){
			foreach ($user_hotel as $v){
				$user_hotel_id[]=$v['hotel_id'];
			}
		}
		$data=[];$i=0;
		foreach ($all_hotel as $val){

			if (empty($user_hotel)){
				$data[$i]=$val;
				$data[$i]['selected']="T";
			}else{
				if (!empty($user_hotel_id) and in_array($val['id'],$user_hotel_id)){
					$data[$i]=$val;
					$data[$i]['selected']="T";
				}else{
					$data[$i]=$val;
					$data[$i]['selected']="F";
				}
			}

			$i++;
		}
		$data=['hotel'=>$data];
		exit(json_encode(parent::output($data)));

	}

	public function update_user_info_simple()
	{
		if (!$this->uid) $this->uid = 1;
		//保存基本信息
		$name = $this->input->post('name');
		$gender = $this->input->post('gender');
		$its = $this->input->post('its');

		$data = [
			'name' => $name,
			'gender' => $gender,
			'its' => $its,
		];

		$this->load->model('User_info_model');
		$arr = $this->User_info_model->update_user_info($this->uid, $data);
		$data=[
			'msg'=>'修改成功'
		];
		exit(json_encode(parent::output($data)));
	}
		//歌手主页
	public function update_user_info(){

//		$this->pr($_POST);
		if (!$this->uid) $this->uid=1;
		//保存基本信息
		$email=$this->input->post('email');
		$home=$this->input->post('home');
		$accompanying=$this->input->post('accompanying');
		$price=$this->input->post('price');
		$history_price=$this->input->post('history_price');
		$other=$this->input->post('other');
		$img=$this->input->post('img');
		$phone=$this->input->post('phone');

		$data=[
			'email'=>$email,
			'home'=>$home,
			'accompanying'=>$accompanying,
			'price'=>$price,
			'history_price'=>$history_price,
			'other'=>$other,
			'img'=>$img,
			'phone'=>$phone,
		];

		if ($_POST['name']) $data['name']=$this->input->post('name');

		$this->load->model('User_info_model');
		$arr=$this->User_info_model->update_user_info($this->uid,$data);

		//简介
		$introduction=$this->input->post('introduction');

		$data=[
			'introduction'=>$introduction
		];
		$this->load->model('User_works_baike_model');
		$arr=$this->User_works_baike_model->update_user_works_baike($this->uid,$data);

		//风格
		$style=$this->input->post('style');

		$data=[
			'style'=>$style
		];
		$this->load->model('User_tag_style_model');
		$arr=$this->User_tag_style_model->update_user_tag_style($this->uid,$data);


		//参加活动
		$activity=$this->input->post('activity');
		$data=[
			'activity'=>$activity
		];
		$this->load->model('User_tag_activity_model');
		$arr=$this->User_tag_activity_model->update_user_tag_activity($this->uid,$data);


		//餐标
		$meal=$this->input->post('meal');
		$data=[
			'meal'=>$meal
		];
		$this->load->model('User_tag_meal_model');
		$arr=$this->User_tag_meal_model->update_user_tag_meal($this->uid,$data);

		//住宿
		$hotel=$this->input->post('hotel');
		$data=[
			'hotel'=>$hotel
		];
		$this->load->model('User_tag_hotel_model');
		$arr=$this->User_tag_hotel_model->update_user_tag_hotel($this->uid,$data);

		//出行
		$traffic=$this->input->post('traffic');
		$data=[
			'traffic'=>$traffic
		];
		$this->load->model('User_tag_traffic_model');
		$arr=$this->User_tag_traffic_model->update_user_tag_traffic($this->uid,$data);

		if (isset($_POST['user_order_date'])){
			//档期
			$user_order_date=$this->input->post('user_order_date');
			$data=[];
			if (!empty($user_order_date)) {
				foreach ($user_order_date as $val) {
					$data[]['date_time'] = strtotime($val);
				}
			}
			$this->load->model('Order_date_model');
			$arr=$this->Order_date_model->set_order_date_arr($this->uid,$data);
		}

		exit(json_encode(parent::output($arr),true));
	}

	public function get_user_info(){
		$arr=[];
//		$this->pr($_POST);
		if (!$this->uid) $this->uid=1;


		$this->load->model('User_info_model');
		$arr['info']=$this->User_info_model->get_user_info($this->uid);
		unset($arr['info']['type']);
		unset($arr['info']['style']);
		//简介

		$this->load->model('User_works_baike_model');
		$arr['info']['introduction']=$this->User_works_baike_model->get_user_works_baike($this->uid);


		//风格
		$this->load->model('User_tag_style_model');
		$arr['style']=$this->User_tag_style_model->get_user_tag_style_selected($this->uid);

		//参加活动
		$this->load->model('User_tag_activity_model');
		$arr['activity']=$this->User_tag_activity_model->get_user_tag_activity_selected($this->uid);


		//餐标
		$this->load->model('User_tag_meal_model');
		$arr['meal']=$this->User_tag_meal_model->get_user_tag_meal_selected($this->uid);

		//住宿
		$this->load->model('User_tag_hotel_model');
		$arr['hotel']=$this->User_tag_hotel_model->get_user_tag_hotel_selected($this->uid);

		//出行
		$this->load->model('User_tag_traffic_model');
		$arr['traffic']=$this->User_tag_traffic_model->get_user_tag_traffic_selected($this->uid);

		//档期
		$this->load->model('Order_date_model');
		$arr['user_order_date']=$this->Order_date_model->get_order_date($this->uid);

		exit(json_encode(parent::output($arr),true));
	}

	public function get_user_meal(){
		if (!$this->uid) $this->uid=1;
		$this->load->model('User_tag_meal_model');
		$arr['meal']=$this->User_tag_meal_model->get_user_tag_meal_selected($this->uid);
		exit(json_encode(parent::output($arr)));
	}

	public function set_user_meal(){
		$data=json_decode(parent::get_json(),true);
		$this->load->model('User_tag_meal_model');
		$this->User_tag_meal_model->update_user_tag_meal($this->uid,$data);
		$arr=[
			'msg'=>'修改成功'
		];
		exit(json_encode(parent::output($arr)));
	}

	public function get_user_accompanying(){
		$this->load->model('User_info_model');
		$arr['info']=$this->User_info_model->get_user_accompanying($this->uid);
		exit(json_encode(parent::output($arr)));
	}



	public function set_user_accompanying(){
		$data=json_decode(parent::get_json(),true);
		if (!empty($data)){
			$this->load->model('User_info_model');
			$this->User_info_model->update_user_info($this->uid,$data);
		}
		
		$arr=[
			'msg'=>'修改成功'
		];
		exit(json_encode(parent::output($arr)));
	}

	public function get_user_banner(){
		$this->load->model('User_banner_model');
		$arr['banner']=$this->User_banner_model->get_user_banner($this->uid);
		exit(json_encode(parent::output($arr)));
	}

	public function set_user_banner(){
		$data=json_decode(parent::get_json(),true);
		if (!empty($data)){
			$this->load->model('User_banner_model');
			$this->User_banner_model->update_user_banner($this->uid,$data);
		}

		$arr=[
			'msg'=>'修改成功'
		];
		exit(json_encode(parent::output($arr)));
	}

	public function set_user_type(){
		$data=json_decode(parent::get_json(),true)['user_type'];
		if (!empty($data)){
			$this->load->model('User_info_model');
			$this->User_info_model->update_user_info($this->uid,$data);
		}

		$arr=[
			'msg'=>'修改成功'
		];
		exit(json_encode(parent::output($arr)));
	}

	public function set_user_type2(){
		$data['type']=$_POST['user_type'];
		if (!empty($data)){
			$this->load->model('User_info_model');
			$this->User_info_model->update_user_info($this->uid,$data);
		}

		$arr=[
			'msg'=>'修改成功'
		];
		exit(json_encode(parent::output($arr)));
	}
}