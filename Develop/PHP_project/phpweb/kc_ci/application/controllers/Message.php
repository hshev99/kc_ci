<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Message extends CI_Controller {

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
		$this->lc=$this->input->get('lc');
	}

	/*
	 * @author Safari
	 * @content 获取用户通知信息
	 * */
	public function get_user_message(){
		$this->load->model("Message_model");
		$data=$this->Message_model->get_user_message($this->uid);
		exit(json_encode(parent::output($data)));

	}
	public function index(){
		//预约我的
		$this->load->model("User_order_model");
		$UserOrderMy=$this->User_order_model->UserOrderMy($this->uid);
		if(empty($UserOrderMy)){
			$order_arr_UserOrderMyVal = array();
		}

		foreach ($UserOrderMy as $val) {
			foreach ($val as $UserOrderMyVal) {
				$order_arr_UserOrderMyVal[]=$UserOrderMyVal;
			}
		}
		// foreach ($order_arr_UserOrderMyVal as $value) {
		// 	$Valueorder_arr_UserOrderMyVal[]=$value;
		// }

		$arrorder_arr_UserOrderMyVal=[];
		$y=0;
		foreach ($order_arr_UserOrderMyVal as $key => $val) {
			if($val['status']==0){
				$pay_content="尊敬的火了演艺用户，编号为:{$val['order_sn']}的订单已取消。";
			}else if($val['status']==1){
				$pay_content="尊敬的火了演艺用户，编号为:{$val['order_sn']}的订单未付款。";
			}else if($val['status']==2){
				$pay_content="尊敬的火了演艺用户，订单编号:{$val['order_sn']}已支付成功，等待您的接单。";
			}else if($val['status']==3){
				$pay_content="尊敬的{$val['worker_name']}用户，您已经拒绝了{$val['order_sn']}订单，订单已经关闭。";
			}else if($val['status']==4){
				$pay_content="尊敬的火了演艺用户，您已经接受{$val['worker_name']}的订单，请保持电话畅通。";
			}else if($val['status']==5){
				$pay_content="尊敬的火了演艺用户，编号为:{$val['order_sn']}的订单已确认您到场。";
			}else if($val['status']==6){
				$pay_content="尊敬的火了演艺用户，编号为:{$val['order_sn']}的订单已完成。";
			}else if($val['status']==7){
				$pay_content="尊敬的火了演艺用户，编号为:{$val['order_sn']}的订单已完成。";
			}
            $arrorder_arr_UserOrderMyVal[$y]['date']=$val['trading_time'];
            $arrorder_arr_UserOrderMyVal[$y]['pay_message']=$val['status_name'];
            $arrorder_arr_UserOrderMyVal[$y]['pay_content']=$pay_content;
            $arrorder_arr_UserOrderMyVal[$y]['about_price']=$val['about_price'];
            $arrorder_arr_UserOrderMyVal[$y]['worker_name']=$val['worker_name'];
            $arrorder_arr_UserOrderMyVal[$y]['order_detail']=$val['performace_name'];
            $arrorder_arr_UserOrderMyVal[$y]['order_sn']=$val['order_sn'];
            $y++;
		}
		// var_dump($arrorder_arr_UserOrderMyVal);die;
		//我预约的
		$this->load->model('User_order_model');
		$UserOrder=$this->User_order_model->UserOrder($this->uid);
		if(empty($UserOrder)){
			$order_arr_UserOrder = array();
		}
		foreach ($UserOrder as $value) {
			$order_arr_UserOrder[]=$value;
		}

		$arr=[];
		$i=0;
		foreach ($order_arr_UserOrder as $key => $val) {
			if($val['status']==0){
				$pay_content="尊敬的火了演艺用户，您编号为:{$val['order_sn']}的订单已取消。";
			}else if($val['status']==1){
				$pay_content="尊敬的火了演艺用户，您编号为:{$val['order_sn']}的订单未付款。";
			}else if($val['status']==2){
				$pay_content="尊敬的火了演艺用户，您的订单编号:{$val['order_sn']}已支付成功，请耐心等待艺人接单。";
			}else if($val['status']==3){
				$pay_content="非常抱歉，{$val['worker_name']}拒绝了订单，预约金将在1~7个工作日之内退还至您的账户，请耐心等待。";
			}else if($val['status']==4){
				$pay_content="恭喜您:{$val['worker_name']}已接受您的订单，我方经纪人将在30min内与您联系，请保持电话畅通。";
			}else if($val['status']==5){
				$pay_content="尊敬的火了演艺用户，您编号为:{$val['order_sn']}的订单已确认歌手到场。";
			}else if($val['status']==6){
				$pay_content="尊敬的火了演艺用户，您编号为:{$val['order_sn']}的订单已完成。";
			}else if($val['status']==7){
				$pay_content="尊敬的火了演艺用户，您编号为:{$val['order_sn']}的订单已完成。";
			}
            $arr[$i]['date']=$val['trading_time'];
            $arr[$i]['pay_message']=$val['status_name'];
            $arr[$i]['pay_content']=$pay_content;
            $arr[$i]['about_price']=$val['about_price'];
            $arr[$i]['worker_name']=$val['worker_name'];
            $arr[$i]['order_detail']=$val['performace_name'];
            $arr[$i]['order_sn']=$val['order_sn'];
            $i++;
		}
		$order_arr=array_merge($arrorder_arr_UserOrderMyVal,$arr);	

		$sort = array(  
        'direction' => 'SORT_DESC', //排序顺序标志 SORT_DESC 降序；SORT_ASC 升序  
        'field'     => 'date',       //排序字段  
		);
		$arrSort = array();
		foreach($order_arr AS $uniqid => $row){  
		    foreach($row AS $key=>$value){  
		        $arrSort[$key][$uniqid] = $value;  
		    }  
		}  
		if($sort['direction']){  
		    array_multisort($arrSort[$sort['field']], constant($sort['direction']), $order_arr);  
		}
		// var_dump($order_arr);die;
		// $this->pr($order_arr);
		// $this->pr($arr);
		// if ($a){
			// $time=date("Y-m-d H:i:s");
			// $a=[
			// 	"date"=>$time,
			// 	"pay_message"=>"付款成功通知",
			// 	"pay_content"=>"您的订单已成功后面多加几句,让他尽量能到第二行,不知道能不能到第三行",
			// 	"about_price"=>"预定金:2000",
			// 	"order_detail"=>"订单详情:活动名称",
			// 	"order_sn"=>"订单编号:1231231231"
			// ];


			// $arr['message'][]=$a;
			// $arr['message'][]=$a;
		// }else{
		// 	$arr=[
		// 		'message'=>[]
		// 	];
		// }

		exit(json_encode(parent::output($order_arr)));
	}



	//确认订单
	###编号为【变量】的订单已确认，款项将在24小时内转至您的账户，请耐心等候。
	/**
	 * @content 确认订单
	 * @author Safari
	 * @param $order_sn,$phone
	 */
	public function confirm_order(){
		$order_sn=$this->input->post('order_sn');
		$phone=$this->input->post('phone');

		exit(json_encode(parent::output(['msg'=>parent::confirm_order_message($order_sn,$phone)])));
	}
	//接受订单
	###恭喜您:【变量】已接受您的订单，我方经纪人将在30min内与您联系，请保持电话畅通。
	/**
	 * @content 接受订单
	 * @author Safari
	 * @param $order_sn,$phone
	 */
	public function accept_order(){
		$order_sn=$this->input->post('order_sn');
		$phone=$this->input->post('phone');

		exit(json_encode(parent::output(['msg'=>parent::accept_order_message($order_sn,$phone)])));
	}

	//拒绝订单
	###非常抱歉，【变量】拒绝了订单，预约金将在24小时之内退还至您的账户，请耐心等待。
	/**
	 * @content 拒绝订单
	 * @author  Safari
	 * @param   user,phone
	 */
	public function refused_order(){
		$user=$this->input->post('user');
		$phone=$this->input->post('phone');

		exit(json_encode(parent::output(['msg'=>parent::refused_order_message($user,$phone)])));
	}

	public function message(){
		parent::submit_worker_order_message('123123','18611696067');
	}
}
