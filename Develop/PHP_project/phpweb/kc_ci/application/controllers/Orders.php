<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Orders extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Orders_info_model');

		$this->status_name=[
			0=>'已取消',
			1=>'待付款',
			2=>'已付款',
			3=>'交易关闭',
			4=>'已接单',
			5=>'歌手到场',
			6=>'交易完成',
			7=>'交易完成'
		];
	}

	//用户提交
	public function index()
	{
//		 $this->pr($_POST);die;




		$data=[]; 
		$data=$_POST;
		$data['order_sn']=parent::prod_order();

		empty($data['create_time'])? $data['create_time']=date("Y-m-d H:i:s") :'';
		empty($data['trading_time'])? $data['trading_time']=date("Y-m-d H:i:s") :'';
		empty($data['start_time'])? $data['start_time']=date("Y-m-d H:i:s") :'';
		empty($data['end_time'])? $data['end_time']=date("Y-m-d H:i:s") :'';
		empty($data['pay_time'])? $data['pay_time']=date("Y-m-d H:i:s") :'';
		$data['status']=1;



		//查询歌手信息
		$worker_uid=$this->input->post('worker_uid');
		$this->load->model('User_info_model');
		$user_info=$this->User_info_model->get_user_info($worker_uid);
		empty($data['worker_phone']) ? $data['worker_phone']=$user_info['phone']:'';
		// var_dump($user_info);die;
		$result=$this->Orders_info_model->save_Order($data);

		if ($result){
			$arr=[];
			$arr['order_sn']=$data['order_sn'];
			$arr['status']='1';
			$arr['status_name']='待支付';
			$arr['pay_way']=$data['pay_way'];
			$arr['pay_amount']=$data['pay_amount'];
			if ($data['pay_way'] ==1 ){
				$arr['pay_amount']=$data['pay_amount'];
			}elseif($data['pay_way'] ==2){
				$this->load->model('WeChat_model');
				$arr['prepay']=$this->WeChat_model->prepay($data['order_sn'],$arr['pay_amount']);
			}


			

			exit(json_encode(parent::output($arr),true));
		}else{
			exit(json_encode(parent::output(['msg'=>'提交失败']),true));
		}

	}
	//获取随机订单号
	public function order_sn(){
		$order_sn=date('Ymd'.rand(1111,9999));
		$this->db->where('order_sn',$order_sn);
		$this->db->select();
		$query = $this->db->get('user_orders');
		if(empty($query->result())){
			// exit();
			return $order_sn;
		}else{
			$this->order_sn();
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

	/**
	 * @content 取消订单
	 * @author Safari
	 * @param $order_sn,$phone
	 */
	public function cancel_order(){
		$this->order_sn=$this->input->post("order_sn");
		$this->uid=$this->input->get("uid");

		//效验
		$this->load->model("Orders_deta_model");
		$arr=$this->Orders_deta_model->order_phone($this->order_sn);
		if ($arr['status'] > 1){
			exit(json_encode(parent::output(['msg'=>"该处于{$this->status_name[$arr['status']]}状态,请执行其他操作"])));
		}elseif ($arr['status'] == 0){
			exit(json_encode(parent::output(['msg'=>'该订单已取消'])));
		}

		$this->load->model("Order_pay_model");

		$data=[
			'status'=>'0',
		];

		$this->Order_pay_model->update_order_pay($this->order_sn,$data);

		$this->load->model("Orders_deta_model");
		$arr=$this->Orders_deta_model->order_phone($this->order_sn);
		//短信提示
		//parent::accept_order_message($arr['worker_name'],$arr['phone']);

		if ($arr['status'] == 0){
			$out=[
				'msg'=>'取消订单成功'
			];
		}else{
			$out=[
				'msg'=>'取消订单失败'
			];
		}
		exit(json_encode(parent::output($out)));

	}

	/**
	 * @content 接受订单
	 * @author Safari
	 * @param $order_sn,$phone
	 */
	public function accept_order(){
		$this->order_sn=$this->input->post("order_sn");
		$this->uid=$this->input->get("uid");

		//效验
		$this->load->model("Orders_deta_model");
		$arr=$this->Orders_deta_model->order_phone($this->order_sn);
		if ($arr['status'] == 1){
			exit(json_encode(parent::output(['msg'=>'该订单还未付款,请先付款'])));
		}elseif ($arr['status'] == 4){
			exit(json_encode(parent::output(['msg'=>'该订单已被接受,请执行其他操作'])));
		}elseif ($arr['status'] > 4){
			exit(json_encode(parent::output(['msg'=>"该订单处于{$this->status_name[$arr['status']]},请执行其他操作"])));
		}

		$this->load->model("Order_pay_model");

		$data=[
			'status'=>'4',
			'accept_refused'=>date("Y-m-d H:i:s")
		];

		$this->Order_pay_model->update_order_pay($this->order_sn,$data);

		$this->load->model('Orders_info_model');
		$order_uid_phone=$this->Orders_info_model->order_uid_phone($this->order_sn);

		if($order_uid_phone['add_user_phone']==$order_uid_phone['boss_phone']){
			parent::accept_order_message($this->order_sn,$order_uid_phone['boss_phone']);

			//查询订单 boss_id worker_id

			//parent::accept_order_message($this->order_sn,$order_uid_phone['worker_phone']);

			$out=[
				'msg'=>'接受订单成功'
			];

			exit(json_encode(parent::output($out)));

		}else{
			parent::accept_order_message($this->order_sn,$order_uid_phone['add_user_phone']);


			parent::accept_order_message($this->order_sn,$order_uid_phone['boss_phone']);

			//查询订单 boss_id worker_id

			//parent::submit_worker_order_message($this->order_sn,$order_uid_phone['worker_phone']);

			
			$out=[
				'msg'=>'接受订单成功'
			];
			exit(json_encode(parent::output($out)));

		}


	}


	/**
	 * @content 确认歌手到场
	 * @author Safari
	 * @param $order_sn,$phone
	 */
	public function confirm_order(){

		$this->order_sn=$this->input->post("order_sn");
		$this->uid=$this->input->get("uid");

		//效验
		$this->load->model("Orders_deta_model");
		$arr=$this->Orders_deta_model->order_phone($this->order_sn);
		if ($arr['status'] == 1){
			exit(json_encode(parent::output(['msg'=>'该订单还未付款,请先付款'])));
		}elseif ($arr['status'] == 5){
			exit(json_encode(parent::output(['msg'=>'该订单已被接受确认,请执行其他操作'])));
		}elseif ($arr['status'] > 5){
			exit(json_encode(parent::output(['msg'=>"该订单处于{$this->status_name[$arr['status']]}状态,请执行其他操作"])));
		}

		$this->load->model("Order_pay_model");

		$data=[
			'status'=>'5',
			'confirm'=>date("Y-m-d H:i:s")
		];

		$this->Order_pay_model->update_order_pay($this->order_sn,$data);

		$this->load->model('Orders_info_model');
		$order_uid_phone=$this->Orders_info_model->order_uid_phone($this->order_sn);

		if($order_uid_phone['add_user_phone']==$order_uid_phone['boss_phone']){

			parent::confirm_to_attend_yiren($order_uid_phone['worker_phone']);

			parent::confirm_order_message($this->order_sn,$order_uid_phone['boss_phone']);

			$out=[
				'msg'=>'确认订单成功'
			];

			exit(json_encode(parent::output($out)));

		}else{

			parent::confirm_to_attend_yiren($order_uid_phone['worker_phone']);
			
			parent::confirm_order_message($this->order_sn,$order_uid_phone['add_user_phone']);


			parent::confirm_order_message($this->order_sn,$order_uid_phone['boss_phone']);
			
			$out=[
				'msg'=>'确认订单成功'
			];
			exit(json_encode(parent::output($out)));

		}
	}

	/**
	 * @content 拒绝订单
	 * @author  Safari
	 * @param   user,phone
	 */
	public function refused_order(){

		$this->order_sn=$this->input->post("order_sn");
		$this->reason=$this->input->post("reason");
		$this->uid=$this->input->get("uid");


		//效验
		$this->load->model("Orders_deta_model");
		$arr=$this->Orders_deta_model->order_phone($this->order_sn);
		if ($arr['status'] == 1){
			exit(json_encode(parent::output(['msg'=>'该订单还未付款,请先付款'])));
		}elseif ($arr['status'] == 3){
			exit(json_encode(parent::output(['msg'=>'拒绝订单成功'])));
		}elseif ($arr['status'] > 3){
			exit(json_encode(parent::output(['msg'=>"拒绝订单成功"])));
		}

		$this->load->model("Order_pay_model");

		$data=[
			'status'=>'3',
			'accept_refused'=>date("Y-m-d H:i:s"),
			'reason'=>$this->reason
		];

		$this->Order_pay_model->update_order_pay($this->order_sn,$data);

		$this->load->model('Orders_info_model');
		$order_uid_phone=$this->Orders_info_model->order_uid_phone($this->order_sn);

		if($order_uid_phone['add_user_phone']==$order_uid_phone['boss_phone']){
			parent::refused_order_message($order_uid_phone['worker_name'],$order_uid_phone['boss_phone'],$this->reason);

			$out=[
				'msg'=>'拒绝订单成功'
			];

			exit(json_encode(parent::output($out)));

		}else{
			parent::refused_order_message($order_uid_phone['worker_name'],$order_uid_phone['add_user_phone'],$this->reason);


			parent::refused_order_message($order_uid_phone['worker_name'],$order_uid_phone['boss_phone'],$this->reason);

			
			$out=[
				'msg'=>'拒绝订单成功'
			];
			exit(json_encode(parent::output($out)));

		}
	}
}
 ?>