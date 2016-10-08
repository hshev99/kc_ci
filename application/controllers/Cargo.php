<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cargo extends CI_Controller {

	public $user_login;
	public $uid;

	public function __construct()
	{
		parent::__construct();

		//判断是否登录
	}


	//发货操作
	public function setCargo(){
		//发货地址

		$data=json_decode(parent::get_json(),true);

		//添加 用户信息  订单号
		$data['shipper_id']=$this->uid;
		$data['cargo_sn']='MJ'.date("ymdHis").rand(1,9);

		$this->load->model('WriteCargo_model');

		if (isset($data['token'])) unset($data['token']);


		$result=$this->WriteCargo_model->setCargo($data,$this->user_name);

		if ($result){
			$arr=[
				'msg'=>'提交成功'
			];
			parent::outPutEnd($arr);
		}else{
			parent::outPutEnd([],201,'提交失败');
		}
	}
	/*
	 * @content 发货列表
	 * @time 20160919
	 *
	 * */
	public function getCargoList(){

		$data=json_decode(parent::get_json(),true);


		$status=isset($data['status'])&&!empty($data['status']) ? $data['status'] : 0;
		$page=isset($data['page'])&&!empty($data['page']) ? $data['page'] : 1;
		$l=isset($data['limit'])&&!empty($data['limit']) ? $data['limit'] : 12;

		$search=[
			'cargo_sn'=>isset($data['cargo_sn'])&&!empty($data['cargo_sn']) ? $data['cargo_sn'] : false,
			'send_address'=>isset($data['send_address'])&&!empty($data['send_address']) ? $data['send_address'] : false,
			'receive_address'=>isset($data['receive_address'])&&!empty($data['receive_address']) ? $data['receive_address'] : false,
			'start_time'=>isset($data['start_time'])&&!empty($data['start_time']) ? $data['start_time'] : false,
			'end_time'=>isset($data['end_time'])&&!empty($data['end_time']) ? $data['end_time'] : false,
		];

		$this->load->model('ReadCargo_model');
		$result=$this->ReadCargo_model->getCargo($this->uid,$status,$page,$l,$search);

		if (!$result){
			parent::outPutEnd([],109,'暂无数据');
		}else{
			parent::outPutEnd($result);
		}
	}


	/*
	 * @content 获取默认信息
	 * @time 20160920
	 *
	 * **/
	public function getCargoDefault(){

		$this->load->model('ReadCargo_model');
		$result=$this->ReadCargo_model->getCargoDefault($this->uid);

		if (!$result){
			parent::outPutEnd([],201,'暂无默认货物数据');
		}else{
			parent::outPutEnd($result);
		}
	}

	/*
	 * @content
	 * @time 20160921
	 * **/
	public function getCargoPriceList(){
		$this->load->model('ReadCargoPrice_model');
		$data=json_decode(parent::get_json(),true);

		$cargo_sn=isset($data['cargo_sn'])&&!empty($data['cargo_sn']) ? $data['cargo_sn'] : false;

		if (!$cargo_sn) parent::outPutEnd([],301,'cargo_sn无效');
		$page=isset($data['page'])&&!empty($data['page']) ? $data['page'] : 1;
		$l=isset($data['limit'])&&!empty($data['limit']) ? $data['limit'] : 12;

		$params=[
			'cargo_sn'=>$cargo_sn,
			'page'=>$page,
			'l'=>$l
		];
		$result=$this->ReadCargoPrice_model->getCargoPriceList($this->uid,$params);

		if (!$result){
			parent::outPutEnd([],302,'暂无物流信息');
		}else{
			parent::outPutEnd($result);
		}
	}

	/*
	 * @content 货单详情
	 * **/
	public function getCargoDetail(){
		$data=json_decode(parent::get_json(),true);
		$cargo_sn = isset($data['cargo_sn']) ? $data['cargo_sn'] : '';

		if (!$cargo_sn) parent::outPutEnd([],606,'未检测到sn');

		$this->load->model('ReadCargo_model');
		$result=$this->ReadCargo_model->getCargoDetail($cargo_sn);

		parent::outPutEnd($result);
		$this->pr($result);
	}

	/*
	 * @content 预下单信息
	 * @time 0926
	 * **/
	public function getCargoOrder(){
		$data=json_decode(parent::get_json(),true);
		$cargo_sn = isset($data['cargo_sn']) ? $data['cargo_sn'] : '';
		$cargo_price_id = isset($data['cargo_price_id']) ? $data['cargo_price_id'] : '';

		if (!$cargo_sn || !$cargo_price_id) parent::outPutEnd([],608,'参数不正确');

		$this->load->model('ReadCargo_model');
		$result=$this->ReadCargo_model->getCargoOrder($cargo_sn,$cargo_price_id);

		if (!$result){
			parent::outPutEnd([],302,'信息不正确');
		}else{
			parent::outPutEnd($result);
		}

	}

	public function agreeCargoOrder(){
		$data=json_decode(parent::get_json(),true);
		$cargo_sn = isset($data['cargo_sn']) ? $data['cargo_sn'] : '';
		$cargo_price_id = isset($data['cargo_price_id']) ? $data['cargo_price_id'] : '';

		$cargo_expect_price = isset($data['cargo_expect_price']) ? (float)$data['cargo_expect_price'] : '';
		$cargo_ton_count = isset($data['cargo_ton_count']) ? (float)$data['cargo_ton_count'] : '';

		if (!$cargo_sn || !$cargo_price_id) parent::outPutEnd([],608,'参数不正确');

		if ($cargo_expect_price || $cargo_ton_count){

			$this->load->model('WriteCargo_model');
			$result=$this->WriteCargo_model->agreeCargoOrder($cargo_sn,$cargo_price_id);


			$this->load->model('WriteCargoPrice_model');
			$result=$this->WriteCargoPrice_model->agreeCargoPriceOrder($cargo_price_id,$cargo_expect_price,$cargo_ton_count);

			if (!$result){
				parent::outPutEnd([],302,'信息不正确');
			}else{
				parent::outPutEnd(['msg'=>'操作成功,等待物流确认','cargo_sn'=>$cargo_sn]);
			}

		}else{


			$this->load->model('WriteCargo_model');
			$result=$this->WriteCargo_model->agreeCargoOrder($cargo_sn,$cargo_price_id);

			$this->load->model('WriteCargoPrice_model');
			$result=$this->WriteCargoPrice_model->agreeCargoPriceOrder($cargo_price_id,$cargo_expect_price,$cargo_ton_count);

			if (!$result){
				parent::outPutEnd([],302,'信息不正确');
			}else{
				parent::outPutEnd(['msg'=>'操作成功','cargo_sn'=>$cargo_sn]);
			}

		}



	}



	public function cancelCargoOrder()
	{
		$data = json_decode(parent::get_json(), true);
		$cargo_sn = isset($data['cargo_sn']) ? $data['cargo_sn'] : '';

		if (!$cargo_sn ) parent::outPutEnd([], 608, '参数不正确');

		$this->load->model('WriteCargo_model');
		$result=$this->WriteCargo_model->cancelCargoOrder($cargo_sn);

		if (!$result){
			parent::outPutEnd([],402,'信息不正确');
		}else{
			parent::outPutEnd(['msg'=>'取消发货操作成功']);
		}

	}
}
