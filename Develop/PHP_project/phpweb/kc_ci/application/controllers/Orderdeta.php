<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Orderdeta extends CI_Controller
{

	public $order_sn;public $uid;
	public function __construct()
	{
		parent::__construct();
		$this->order_sn=$this->input->get('order_sn');
		$this->uid=$this->input->get('uid');
	}

	//订单详情
	public function index(){
		$this->load->model('Orders_deta_model');
		$this->load->model('User_info_model');
		$arr=[];
		$order_info=$this->Orders_deta_model->order_detail($this->order_sn);
		$arr['order']=$order_info;
		$time=7200 -(time()-strtotime($order_info['create_time']));
		$time24=86400 -(time()-strtotime($order_info['create_time']));
		if ($time <0 ) $time=0;
		if ($time24 <0 ) $time24=0;

		$pay_status_name=[
			1=>'未支付',
			2=>'已支付',
			3=>'支付失败'
		];
		switch ($order_info['status']){
			//待付款
			case 1:
				$arr['status']['type']="1";
				$arr['status']['type_name']="商家方订单状态";
				$arr['status']['time']="{$time}";
				$arr['status']['now']="待付款";
				$arr['status']['line']=[
					0=>[
						"name"=>"待付款",
						"status"=>"F",
						"time"=>""
					],
					1=>[
						"name"=>"等待接单",
						"status"=>"F",
						"time"=>""
					],2=>[
						"name"=>"等待歌手到场",
						"status"=>"F",
						"time"=>""
					]
					,3=>[
						"name"=>"未完成",
						"status"=>"F",
						"time"=>""
					]
				];
				$params['type']=1;
				$params['status']=$arr;
				break;

			//已付款
			case 2:

				$arr['status']['type']="1";
				$arr['status']['type_name']="商家方订单状态";
				$arr['status']['time']="{$time24}";
				$arr['status']['now']="已付款";
				$arr['status']['line']=[
					0=>[
						"name"=>"已付款",
						"status"=>"T",
						"time"=>date("m-d H:i",strtotime($order_info['pay_time']))
					],
					1=>[
						"name"=>"等待接单",
						"status"=>"F",
						"time"=>""
					],2=>[
						"name"=>"等待歌手到场",
						"status"=>"F",
						"time"=>""
					]
					,3=>[
						"name"=>"未完成",
						"status"=>"F",
						"time"=>""
					]
				];
				$params['type']=2;
				$params['status']=$arr;
				break;

			//交易关闭
			case 3:
				$arr['status']['type']="1";
				$arr['status']['type_name']="商家方订单状态";
				$arr['status']['time']="";
				$arr['status']['now']="交易关闭";
				$arr['status']['line']=[
					0=>[
						"name"=>$pay_status_name[$order_info['pay_status']],
						"status"=>$order_info['pay_status'] == 2 ? "T" : "F",
						"time"=>$order_info['pay_status'] == 2 ? date("m-d H:i",strtotime($order_info['pay_time'])): '',
					],
					1=>[
						"name"=>"交易关闭",
						"status"=>"T",
						"time"=>date("m-d H:i",strtotime($order_info['shut_down']))
					],2=>[
						"name"=>"等待歌手到场",
						"status"=>"F",
						"time"=>""
					]
					,3=>[
						"name"=>"未完成",
						"status"=>"F",
						"time"=>""
					]
				];

				$params['type']=3;
				$params['status']=$arr;
				break;
			//已接单
			case 4:

				$arr['status']['type']="1";
				$arr['status']['type_name']="商家方订单状态";
				$arr['status']['time']="";
				$arr['status']['now']="等待歌手到场";
				$arr['status']['line']=[
					0=>[
						"name"=>"已付款",
						"status"=>"T",
						"time"=>date("m-d H:i",strtotime($order_info['pay_time']))
					],
					1=>[
						"name"=>"已接单",
						"status"=>"T",
						"time"=>date("m-d H:i",strtotime($order_info['accept_refused']))
					],2=>[
						"name"=>"等待歌手到场",
						"status"=>"F",
						"time"=>""
					]
					,3=>[
						"name"=>"未完成",
						"status"=>"F",
						"time"=>""
					]
				];

				$params['type']=4;
				$params['status']=$arr;
				break;

			//歌手到场
			case 5:

				$arr['status']['type']="1";
				$arr['status']['type_name']="商家方订单状态";
				$arr['status']['time']="";
				$arr['status']['now']="歌手到场";
				$arr['status']['line']=[
					0=>[
						"name"=>"已付款",
						"status"=>"T",
						"time"=>date("m-d H:i",strtotime($order_info['pay_time']))
					],
					1=>[
						"name"=>"已接单",
						"status"=>"T",
						"time"=>date("m-d H:i",strtotime($order_info['accept_refused']))
					],2=>[
						"name"=>"歌手到场",
						"status"=>"T",
						"time"=>date("m-d H:i",strtotime($order_info['confirm']))
					]
					,3=>[
						"name"=>"未完成",
						"status"=>"F",
						"time"=>""
					]
				];

				$params['type']=5;
				$params['status']=$arr;
				break;

			//交易完成
			case 6:

				$arr['status']['type']="1";
				$arr['status']['type_name']="商家方订单状态";
				$arr['status']['time']="";
				$arr['status']['now']="交易完成";
				$arr['status']['line']=[
					0=>[
						"name"=>"已付款",
						"status"=>"T",
						"time"=>date("m-d H:i",strtotime($order_info['pay_time']))
					],
					1=>[
						"name"=>"已接单",
						"status"=>"T",
						"time"=>date("m-d H:i",strtotime($order_info['accept_refused']))
					],2=>[
						"name"=>"歌手到场",
						"status"=>"T",
						"time"=>date("m-d H:i",strtotime($order_info['confirm']))
					]
					,3=>[
						"name"=>"交易完成",
						"status"=>"T",
						"time"=>date("m-d H:i",strtotime($order_info['complete']))
					]
				];

				$params['type']=6;
				$params['status']=$arr;
				break;
		}
		//预约方 与被预约方 区分

		$uid=$order_info['worker_uid'];
		//加载用户详细信息
		$arr['user_info']=$this->User_info_model->get_user_info($uid);



		if ($arr['order']['status'] ==1){
			// var_dump($arr['order']['pay_amount']);die;
			$arr['pay_params']=[];
			$this->load->model('WeChat_model');
			$arr['pay_params']=$this->WeChat_model->prepay($arr['order']['order_sn'],$arr['order']['pay_amount']);
		}



		unset($arr['user_info']['uid']);
		exit(json_encode(parent::output($arr),true));
	}
}