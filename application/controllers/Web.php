<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Web extends CI_Controller {

	public $css;public $type;

	//歌手
	public $user_type;
	public $uid;
	public function __construct()
	{
		parent::__construct();
		$this->css = $this->config->item('base_url');
	}
	//歌手认证通过
	public function add_singer(){
		$this->phone=$this->input->get('phone');
		// echo $this->phone;
		parent::verify_singer_through($this->phone);
	}
	//经纪人认证通过
	public function add_agent(){
		$this->phone=$this->input->get('phone');
		// echo $this->phone;
		parent::verify_agent_through($this->phone);
	}

	//公司认证通过
	public function add_enterprise(){
		$this->phone=$this->input->get('phone');
		// echo $this->phone;
		parent::verify_enterprise_through($this->phone);
	}

	//认证失败
	public function add_failure(){
		$phone=$this->input->get('phone');
		// $phone="13720996309";
		$kf_phone="15901016380";
		parent::verify_failure($phone,$kf_phone);
	}

	//提交订单客服跟随订单
	public function worker_singer_orders(){
		$add_user_orders_phone="15901016380";
		parent::confirm_to_attend_yiren($add_user_orders_phone);
	}

	public function css(){
		var_dump($this->css);
	}


	public function up(){

		parent::order_accept_message('歌手-苏发瑞','15301321671');
		$paremt=[
			'css'=>$this->css
		];
		$this->load->view('/Web/up',$paemrt);
	}
	//判断是否登录
	public function is_login(){

		if (empty($_SESSION['user_login']['uid'])) header("Location:login");

		return '';
	}

	//退出
	public function login_out(){
		unset($_SESSION['user_login']);
		header("Location:login");
	}
	public function login_md(){
		$this->phone=$this->input->post('phone');
        $this->password=md5('password='.$this->input->post('password'));
        // echo $password;die;
        $this->login();
	}

	public function login(){
		$paremt=[
			'css'=>$this->css
		];

		if (empty($_POST)){

			$this->load->view('/Web/login',$paremt);
		}else{
			$data=[
				'phone'=>$this->phone,
				'password'=>$this->password
			];
			$this->load->model('Login_model');
			$uid=$this->Login_model->login($data);

			if($uid==false){
				//登录失败
				header("Location:login");
			}else{
				//查询 用户详细信息
				$this->load->model('User_info_model');
				$user_info=$this->User_info_model->get_user_info($uid[0]['uid']);

				$_SESSION['user_login']=$user_info;

				//登录成功
				header("Location:index");			
			}
		}

	}
    //QQ第三方登录
    public function login_qq(){
        $_POST['appid']='101327073';
        $_POST['appkey']='f0f2ea344c7aa993fb0eeb027b5c4ed8';
        $_POST['callback']='http://www.51huole.cn';
        $arr_scope=array('get_user_info,add_share,list_album,add_album,upload_pic,add_topic,add_one_blog,add_weibo,check_page_fans,add_t,add_pic_t,del_t,get_repost_list,get_info,get_other_info,get_fanslist,get_idolist,add_idol,del_idol,get_tenpay_addr');
        $arr_errorReport='true';
        $_POST['scope'] = implode(",",$arr_scope);
        $_POST['errorReport'] = (boolean) $arr_errorReport;
        $_POST['storageType'] = "file";
        $_POST['host'] = "localhost";
        $_POST['user'] = "root";
        $_POST['password'] = "root";
        $_POST['database'] = "test";
        $setting = json_encode($_POST);
        $setting = str_replace("\/", "/",$setting);
        $incFile = fopen("inc.php","w+",TRUE) or die("请设置\Oauth\comm\inc.php的权限为777");
        if(fwrite($incFile, $setting)){

            $this->load->library('Qc',$setting);

            //拉起第三方
            $qc = new \QC();
            $qc->qq_login();
        }else{
            echo "Error";
        }
    }
    //微博登录
    public function login_lib(){
        $this->load->library('Lib');
    }
    public function Login_callback(){
        $this->load->library('Back');
    }

	//注册
	public function registered(){
		$paremt=[
			'css'=>$this->css
		];
		$this->load->view('/Web/registered',$paremt);
	}
	public function login_save_web_md(){
		$this->phone=$this->input->post('phone');
        $this->password=md5('password='.$this->input->post('password'));
		if(empty($this->input->post('type'))){
            $this->type=2;
        }else{
            $this->type=$this->input->post('type');
        }
        $this->login_save_web();
	}
    public function login_save_web(){
        $this->phone=$this->phone;
        $this->password=md5(md5($this->password.'z'));
        $this->web=1;
        $data=$this->save();
    }
    // h5 第三方
    public function add(){
        $this->phone=$_SESSION['token']['uid'];
        $this->password=md5(md5($_SESSION['token']['expires_in'].'z'));
        $this->back=1;
        $this->save();
    }
    public function save(){
        $data=[
            'phone'=>$this->phone,
            'password'=>$this->password,
            'create_time'=>date("Y-m-d H:i:s",time())
        ];
        $type=[
            'type'=>$this->type
        ];
        $this->load->model('Login_model');

        $arr=$this->Login_model->save($data,$type);

        if (empty($arr)){
            if ($this->web) {
                $arrq=[
                    'status'=>0,
                    'errorMsg'=>'',
                    'error'=>'102',
                    'msg'=>'手机号码已注册,<a href="http://www.51huole.cn">请登录</a>',
                    'results'=>[]
                ];

                $paremt=[
					'css'=>$this->css
				];
                $paremt=array_merge($arrq,$paremt);
				$this->load->view('/Web/registered',$paremt);
                //var_dump($arrq);die;
                //exit(json_encode($arrq));
            }else if($this->back) {
				$this->load->model('User_info_model');
            	$back_phone=$_SESSION['token']['uid'];
            	$this->uid=$this->User_info_model->get_user_back($back_phone);

				$user_info=$this->User_info_model->get_user_info($this->uid);

				$_SESSION['user_login']=$user_info;
				header("Location:index");
            }
        }else{
            if($this->web) {
                $arrq=[
                    'status'=>0,
                    'errorMsg'=>'',
                    'error'=>'0',
                    'msg'=>'注册成功',
                    'results'=>[$arr]
                ];

				//注册成功
				$this->uid=$arr['uid'];
				$this->load->model('User_info_model');
				$user_info=$this->User_info_model->get_user_info($this->uid);

				$_SESSION['user_login']=$user_info;
				header("Location:authentication");
            }

            if ($this->back) {
            	$this->load->model('User_info_model');
            	$back_phone=$_SESSION['token']['uid'];
            	$this->uid=$this->User_info_model->get_user_back($back_phone);

				$user_info=$this->User_info_model->get_user_info($this->uid);

				$_SESSION['user_login']=$user_info;
				header("Location:index");die;
                // echo '第三方用户注册 授权success';
                //$this->load->view('/Web/index',array('base_url'=>$this->base_url));die;
            }
        }
    }
    //忘记密码
    public function login_forget_web(){
    	$paremt=[
			'css'=>$this->css,
			'foot'=>'1'
		];

    	$this->load->view('/Web/login_forget.html');
    }
    public function login_back_web_md(){
    	$this->phone=$this->input->post('phone');
        $this->password=md5('password='.$this->input->post('password'));
        $this->login_back_web();
    }
    public function login_back_web(){
        $phone=$this->phone;
        $password=md5(md5($this->password.'z'));
        $data=[
            'phone'=>$phone,
            'password'=>$password
        ];

        $this->load->model('Login_model');

        $arr=$this->Login_model->back($data);

        if(empty($arr)){
        	$arrq=[
                    'status'=>0,
                    'errorMsg'=>'',
                    'error'=>'102',
                    'msg'=>'手机号码未注册,请先注册',
                    'results'=>[]
                ];
            exit(json_encode($arrq));
        }else{
        	$arrq=[
                    'status'=>0,
                    'errorMsg'=>'',
                    'error'=>'0',
                    'msg'=>'密码修改成功',
                    'results'=>[$arr]
                ];
        	exit(json_encode(parent::output($arrq)));
        }
    }
    //登录修改密码
    public function reset(){
		$paremt=[
			'css'=>$this->css,
			'foot'=>'1'
		];

    	if (empty($_SESSION['user_login']['uid'])) {
			$this->is_login();
		}else{
			$this->load->view('/Web/reset',$paremt);
		}
    }

    public function old_pwd(){
    	if (empty($_SESSION['user_login']['uid'])) {
			$this->is_login();
		}else{
			$uid=$_SESSION['user_login']['uid'];
			$old_password=md5(md5(md5('password='.$this->input->post('old_password')).'z'));
			$new_password=md5(md5(md5('password='.$this->input->post('new_password')).'z'));
			$data=[
				'uid'=>$uid,
				'old_password'=>$old_password,
				'new_password'=>$new_password
			];
			$this->load->model('Login_model');
			$old_new=$this->Login_model->old_back($data);
			if(empty($old_new)){
				echo "原密码输入错误";
			}else{
				echo $old_new;
			}
		}
    }

	//首页
	public function index(){
		$paremt=[
			'css'=>$this->css,
			'foot'=>'1'
		];

		if ($this->uid){
			$this->load->model('User_info_model');
			$user_info=$this->User_info_model->get_user_info($this->uid);
			$_SESSION['is_login']['uid']=$user_info['uid'];
			$_SESSION['is_login']['type']=$user_info['type'];
		}

		//调用首页数据
		$arr=[];
		$this->load->model('Index_model');
		$arr['banner']=$this->Index_model->banner();
		#banner
		$this->load->model('User_info_model');
		$arr['infos']=$this->User_info_model->get_user_info();

		$paremt=array_merge($arr,$paremt);
//		$this->load->view('/pay/alipay.wap.create.direct.pay.by.user-PHP-UTF-8/index',$paremt);
		$this->load->view('/Web/index',$paremt);
	}

	//提交订单
	public function submit(){
		if (empty($_SESSION['user_login']['uid'])) {
			$this->is_login();
		}else{
			$user_login=$_SESSION;
			$this->load->model('User_info_model');
			$verify=$this->User_info_model->user_login_uid($user_login);
				// var_dump($verify);die;
			if($verify!=1){
				header("Location:authentication");
	        }else{
				$this->uid=$_SESSION['user_login']['uid'];

				$paremt=['css'=>$this->css];
				$worker_uid=$this->input->get('worker_uid');
				
				$this->load->model('User_info_model');
				$arr=[];
				$arr['worker']=$this->User_info_model->get_user_info($worker_uid);
				$paremt=array_merge($paremt,$arr);
				if (!empty($_POST['performace_name'])) {
					$this->load->model('Orders_info_model');
					//保存订单信息
					$data=[];
					$data=$_POST;
					$data['place']=$data['place_1'].'-'.$data['place_2'].'-'.$data['place_3'];
					unset($data['place_1']);
					unset($data['place_2']);
					unset($data['place_3']);
					$data['order_sn']=parent::prod_order();

					//支付状态
					$data['status']=1;
					$data['pay_amount']=0.01;//预约价格
					$data['create_time']=date("Y-m-d H:i:s");
					$data['boss_uid']=$this->uid;
					if (empty($data['trading_time'])) $data['trading_time']=date("Y-m-d H:i:s");
					if (empty($data['start_time'])) $data['start_time']=date("Y-m-d H:i:s");
					if (empty($data['pay_time'])) $data['pay_time']=date("Y-m-d H:i:s");
					if (empty($data['end_time'])) $data['end_time']=date("Y-m-d H:i:s");
					$data['per_menber'] =(int)$data['per_menber'];

					$this->load->model('User_info_model');
					$user_info=$this->User_info_model->get_user_info($worker_uid);
					empty($data['worker_phone']) ? $data['worker_phone']=$user_info['phone']:'';

					// var_dump($data);die;
					$result=$this->Orders_info_model->save_Order($data);

					if (!$result) header("Location:submitFailure");
					//跳转成功 失败页面
					$this->Payment($data['order_sn']); return '';
				};

				//获取已预约日期
				$this->load->model('Order_date_model');
				$order_date=$this->Order_date_model->get_order_date1($worker_uid);

				if (!empty($order_date)){
					$paremt['order_date']=json_encode($order_date);
				}else{
					$paremt['order_date']='{"2016":{"7":[1,2]}}';
				}

				$this->load->view('/Web/submit',$paremt);
	        }
		}

	}

	//订单提交失败
	public function submitFailure(){
		if (empty($_SESSION['user_login']['uid'])) {
			$this->is_login();
		}else{
			$this->uid=$_SESSION['user_login']['uid'];
		}

		$paremt=['css'=>$this->css];
		$this->load->view('/Web/submitFailure',$paremt);
	}


	//支付成功
	public function Payment($order_sn=''){

		/*
		if (!$order_sn) $order_sn=$this->input->get('order_sn');
		$redis = new Redis();
		$redis->connect('123.57.56.133', 6379);
		$pay_info=[
			'order_sn'=>$order_sn,
			'name'=>'',
			'totl_price'=>'0.01',
			'url'=>'httl://',
			'desc'=>'商品描述'
		];
		$redis->setex($order_sn, '3600',json_encode($pay_info));

		header("Location:http://alipay-h5.51huole.cn?order_sn=".$order_sn);exit();
		*/
		$a=rand(0,1);

		$this->order_sn=$order_sn == '' ? $this->input->get('order_sn') : $order_sn;

		$this->load->model("Orders_deta_model");
		$order_detail=$this->Orders_deta_model->order_detail($this->order_sn);

		$params=[
			'order_sn'=>$this->order_sn,
			'name'=>'预约:'.$order_detail['worker_name'],
			'pay_amount'=>$order_detail['pay_amount']
		];
		$this->load->view('/Web/alipay.html',$params);
		/*
		 $paremt=[
			'css'=>$this->css,
			'order_sn'=>$this->order_sn
		];
		if ($a){
			//支付成功处理
			$this->load->model("Order_pay_model");

			$data=[
				'status'=>'2',
				'pay_time'=>date("y-m-d H:i:s")
			];

			$this->Order_pay_model->update_order_pay($this->order_sn,$data);


			$this->load->model('Orders_info_model');
			$order_uid_phone=$this->Orders_info_model->order_uid_phone($this->order_sn);

			if($order_uid_phone['add_user_phone']==$order_uid_phone['boss_phone']){
				parent::submit_boss_order_message($this->order_sn,$order_uid_phone['boss_phone']);

				//查询订单 boss_id worker_id

				parent::submit_worker_order_message($this->order_sn,$order_uid_phone['worker_phone']);

				
				$this->load->view('/Web/PaymentSuccess',$paremt);
			}else{
				parent::submit_boss_order_message($this->order_sn,$order_uid_phone['add_user_phone']);
				

				parent::submit_boss_order_message($this->order_sn,$order_uid_phone['boss_phone']);

				//查询订单 boss_id worker_id

				parent::submit_worker_order_message($this->order_sn,$order_uid_phone['worker_phone']);

				
				$this->load->view('/Web/PaymentSuccess',$paremt);
			}
		}else{
			//支付失败处理
			$this->load->model("Order_pay_model");

			$data=[
				'status'=>'1',
				'pay_time'=>date("Y-m-d H:i:s")
			];

			$this->Order_pay_model->update_order_pay($this->order_sn,$data);


			$this->load->view('/Web/PaymentFailure',$paremt);
		}
		*/
	}

	public function pay_deal(){
		$this->order_sn = $_GET['out_trade_no'];
		$paremt=[
			'css'=>$this->css,
			'order_sn'=>$this->order_sn
		];


		if ($_GET['is_success'] == 'T'){
			//支付成功处理
			$this->load->model("Orders_deta_model");
			$order_detail=$this->Orders_deta_model->order_detail($this->order_sn);
			if ($order_detail['notice'] == 0){
				$this->load->model("Order_pay_model");

				$data=[
					'status'=>'2',
					'pay_status'=>'2',
					'pay_time'=>date("Y-m-d H:i:s")
				];

				$this->Order_pay_model->update_order_pay($this->order_sn,$data);


				$this->load->model('Orders_info_model');
				$order_uid_phone=$this->Orders_info_model->order_uid_phone($this->order_sn);

				if($order_uid_phone['add_user_phone']==$order_uid_phone['boss_phone']){
					parent::submit_boss_order_message($this->order_sn,$order_uid_phone['boss_phone']);

					//查询订单 boss_id worker_id

					parent::submit_worker_order_message($this->order_sn,$order_uid_phone['worker_phone']);

					$add_user_orders_phone="15901016380";
					parent::boos_worker_phone($add_user_orders_phone,$order_uid_phone['boss_phone'],$order_uid_phone['worker_phone']);


				}else{
					parent::submit_boss_order_message($this->order_sn,$order_uid_phone['add_user_phone']);


					parent::submit_boss_order_message($this->order_sn,$order_uid_phone['boss_phone']);

					//查询订单 boss_id worker_id

					parent::submit_worker_order_message($this->order_sn,$order_uid_phone['worker_phone']);

					$add_user_orders_phone="15901016380";
					parent::boos_worker_phone($add_user_orders_phone,$order_uid_phone['add_user_phone'],$order_uid_phone['worker_phone']);


				}
			}
			$this->load->view('/Web/PaymentSuccess',$paremt);
		}else{
			//支付失败处理
			$this->load->model("Order_pay_model");

			$data=[
				'status'=>'1',
				'pay_time'=>date("Y-m-d H:i:s")
			];

			$this->Order_pay_model->update_order_pay($this->order_sn,$data);


			$this->load->view('/Web/PaymentFailure',$paremt);
		}
	}
	//删除订单
	public function del_order(){
		if (empty($_SESSION['user_login']['uid'])) {
			$this->is_login();
		}else{
			$this->uid=$_SESSION['user_login']['uid'];
		}

		$this->order_sn=$this->input->get('order_sn');

		$this->load->model("Order_pay_model");

		$data=[
			'del'=>'1',
		];

		$this->Order_pay_model->update_order_pay($this->order_sn,$data);


		header("Location:UserOrder");
	}

	//拒绝
	public function refused_order(){
		if (empty($_SESSION['user_login']['uid'])) {
			$this->is_login();
		}else{
			$this->uid=$_SESSION['user_login']['uid'];
		}

		$this->order_sn=$this->input->post('order_sn');
		$this->reason=$this->input->post('reason');
		$this->worker_name=$this->input->post('worker_name');

		$this->load->model("Order_pay_model");

		$data=[
			'status'=>'3',
			'reason'=>$this->reason
		];

		$this->Order_pay_model->update_order_pay($this->order_sn,$data);

		$this->load->model("Orders_deta_model");
		$arr=$this->Orders_deta_model->order_phone($this->order_sn);
		//短信提示
		parent::refused_order_message($this->worker_name,$arr['phone']);
		//短信提示

		header("Location:accept?order_sn={$this->order_sn}");
	}
	//接受
	public function agreed_order(){
		if (empty($_SESSION['user_login']['uid'])) {
			$this->is_login();
		}else{
			$this->uid=$_SESSION['user_login']['uid'];
		}

		$this->order_sn=$this->input->get('order_sn');

		$this->load->model("Order_pay_model");

		$data=[
			'status'=>'4',
		];

		$this->Order_pay_model->update_order_pay($this->order_sn,$data);

		$this->load->model("Orders_deta_model");
		$arr=$this->Orders_deta_model->order_phone($this->order_sn);
		//短信提示
		parent::accept_order_message($arr['worker_name'],$arr['phone']);
		//短信提示

		header("Location:accept?order_sn={$this->order_sn}");
	}

	public function cancel_order(){
		if (empty($_SESSION['user_login']['uid'])) {
			$this->is_login();
		}else{
			$this->uid=$_SESSION['user_login']['uid'];
		}

		$this->order_sn=$this->input->get('order_sn');

		$this->load->model("Order_pay_model");

		$data=[
			'status'=>'3',
		];

		$this->Order_pay_model->update_order_pay($this->order_sn,$data);


		//短信提示

		header("Location:UserOrder");
	}
	//支付成功 调到订单页面
	public function accept(){
		if (empty($_SESSION['user_login']['uid'])) {
			$this->is_login();
		}else{
			$this->uid=$_SESSION['user_login']['uid'];
		}

		$this->user_type=$_SESSION['user_login']['type'];
		$this->order_sn=$this->input->get('order_sn');
		//获取订单详情数据

		$this->load->model("User_order_model");
		$arr=$this->User_order_model->order_info($this->order_sn);

		$this->load->model("Orders_deta_model");
		$order_time=$this->Orders_deta_model->order_detail($this->order_sn);

		if (empty($arr)) exit('查看的订单不存在');
		empty($arr['status']) ? $this->status=1 : $this->status=$arr['status'];

		$params=['css'=>$this->css,'type'=>1,'user_type'=>$this->user_type];
		$params['l']=$arr;

		//用户信息
		$params['user_login']=$_SESSION['user_login'];
		
		$this->load->model("User_order_model");
		$inarray=$this->User_order_model->order_worker_uid($params['l']['worker_uid'],$params['user_login']['uid']);

		if ($params['l']['boss_uid'] == $params['user_login']['uid']){
			$params['pay']=true;
		}else{
			$params['pay']=false;
		}

		if ($params['l']['worker_uid'] == $params['user_login']['uid'] || $inarray=="success"){
			$params['agreed']=true;
		}else{
			$params['agreed']=false;
		}

		$time=7200 -(time()-strtotime($arr['create_time']));
		$time24=86400 -(time()-strtotime($arr['create_time']));
		switch ($this->status){
			//待付款
			case 1:
				$arr=[];
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

				$arr=[];
				$arr['status']['type']="1";
				$arr['status']['type_name']="商家方订单状态";
				$arr['status']['time']="{$time24}";
				$arr['status']['now']="等待接单";
				$arr['status']['line']=[
					0=>[
						"name"=>"已付款",
						"status"=>"T",
						"time"=>@date("m-d H:i",strtotime($order_time['pay_time']))
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
				$arr=[];
				$arr['status']['type']="1";
				$arr['status']['type_name']="商家方订单状态";
				$arr['status']['time']="";
				$arr['status']['now']="交易关闭";
				$arr['status']['line']=[
					0=>[
						"name"=>"已付款",
						"status"=>"T",
						"time"=>date("m-d H:i",strtotime($order_time['pay_time']))
					],
					1=>[
						"name"=>"交易关闭",
						"status"=>"T",
						"time"=>@date("m-d H:i",strtotime($order_time['shut_down']))
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

				$arr=[];
				$arr['status']['type']="1";
				$arr['status']['type_name']="商家方订单状态";
				$arr['status']['time']="";
				$arr['status']['now']="等待歌手到场";
				$arr['status']['line']=[
					0=>[
						"name"=>"已付款",
						"status"=>"T",
						"time"=>date("m-d H:i",strtotime($order_time['pay_time']))
					],
					1=>[
						"name"=>"已接单",
						"status"=>"T",
						"time"=>date("m-d H:i",strtotime($order_time['accept_refused']))
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

				$arr=[];
				$arr['status']['type']="1";
				$arr['status']['type_name']="商家方订单状态";
				$arr['status']['time']="";
				$arr['status']['now']="歌手到场";
				$arr['status']['line']=[
					0=>[
						"name"=>"已付款",
						"status"=>"T",
						"time"=>date("m-d H:i",strtotime($order_time['pay_time']))
					],
					1=>[
						"name"=>"已接单",
						"status"=>"T",
						"time"=>date("m-d H:i",strtotime($order_time['accept_refused']))
					],2=>[
						"name"=>"歌手到场",
						"status"=>"T",
						"time"=>date("m-d H:i",strtotime($order_time['confirm']))
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

				$arr=[];
				$arr['status']['type']="1";
				$arr['status']['type_name']="商家方订单状态";
				$arr['status']['time']="";
				$arr['status']['now']="交易完成";
				$arr['status']['line']=[
					0=>[
						"name"=>"已付款",
						"status"=>"T",
						"time"=>date("m-d H:i",strtotime($order_time['pay_time']))
					],
					1=>[
						"name"=>"已接单",
						"status"=>"T",
						"time"=>date("m-d H:i",strtotime($order_time['accept_refused']))
					],2=>[
						"name"=>"歌手到场",
						"status"=>"T",
						"time"=>date("m-d H:i",strtotime($order_time['confirm']))
					]
					,3=>[
						"name"=>"交易完成",
						"status"=>"T",
						"time"=>date("m-d H:i",strtotime($order_time['complete']))
					]
				];

				$params['type']=6;
				$params['status']=$arr;
				break;
		}

		$this->load->view('/Web/accept',$params);//$this->pr($params);
	}

	//确认歌手到场
	public function Confirm_singer(){

		if (empty($_SESSION['user_login']['uid'])) {
			$this->is_login();
		}else{
			$this->uid=$_SESSION['user_login']['uid'];
		}

		$this->order_sn=$this->input->get('order_sn');

		$this->load->model("Order_pay_model");
		$this->Order_pay_model->update_status($this->order_sn,'5');

		$this->load->model('Orders_info_model');
		$order_uid_phone=$this->Orders_info_model->order_uid_phone($this->order_sn);


		$this->load->model('Orders_info_model');
		$order_uid_phone=$this->Orders_info_model->order_uid_phone($this->order_sn);
		//parent::confirm_boss($order_uid_phone['boss_phone']);

		parent::confirm_to_attend($order_uid_phone['worker_phone']);

		header("Location:UserOrder");

	}
	//支付失败 取消
	public function comUserOrder(){
		$paremt=[
			'css'=>$this->css,
			'foot'=>'3'
		];

		$this->load->view('/Web/comUserOrder',$paremt);
	}

	//支付失败 继续支付
	public function WaitingList(){
		if (empty($_SESSION['user_login']['uid'])) {
			$this->is_login();
		}else{
			$this->uid=$_SESSION['user_login']['uid'];
		}

		$paremt=[
			'css'=>$this->css,
			'foot'=>'2',
			'user_login'=>$_SESSION['user_login']
		];

		$this->load->model("User_order_model");
		$arr['orders']=$this->User_order_model->UserOrder($this->uid);
		$paremt=array_merge($paremt,$arr);
		
		$this->load->view('/Web/WaitingList',$paremt);
	}

	//评论
	public function comment(){
		if (empty($_POST)){
			$this->load->view('/Web/comment',array('css'=>$this->css));
		}else{
			return $this->comUserOrder();
		}

	}

	########################歌手处理

	public function UserOrderMy(){
		if (empty($_SESSION['user_login']['uid'])) {
			$this->is_login();
		}else{
			$this->uid=$_SESSION['user_login']['uid'];
		}
		$this->UserOrder();
	}

	public function UserOrder(){
		if (empty($_SESSION['user_login']['uid'])) {
			$this->is_login();
		}else{
			$this->uid=$_SESSION['user_login']['uid'];

		$paremt=[
			'css'=>$this->css,
			'foot'=>'2',
			'user_login'=>$_SESSION['user_login']
		];

		$this->load->model("User_order_model");
		$arr['orders']=$this->User_order_model->UserOrder($this->uid);
		$paremt=array_merge($paremt,$arr);

		$this->load->view('/Web/UserOrder',$paremt);
		}
	}

	public function UserMy(){
		if (empty($_SESSION['user_login']['uid'])) {
			$this->is_login();
		}else{
			$this->uid=$_SESSION['user_login']['uid'];
		}

		$paremt=[
			'css'=>$this->css,
			'foot'=>'2',
			'user_login'=>$_SESSION['user_login']
		];
		$this->uid=$_SESSION['user_login']['uid'];
		$this->load->model("User_order_model");
		$arr=$this->User_order_model->UserOrderMy($this->uid);
		// var_dump($arr);die;
		$paremt=array_merge($paremt,$arr);
		$this->load->view('/Web/UserOrderMy',$paremt);

	}


	################### 个人主页
	public function singer(){
		if (empty($_SESSION['user_login']['uid'])) {
			$this->is_login();
		}else{
			$this->uid=$_SESSION['user_login']['uid'];
		}
		$paremt=[
			'css'=>$this->css,
			'foot'=>'3',
			'user_login'=>$_SESSION['user_login']
		];

		//调用数据
		$this->load->model('User_info_model');
		$arr['user']=$this->User_info_model->get_user_info($this->uid);
		$paremt=array_merge($paremt,$arr);
		// var_dump($paremt);die;
		$this->load->view('/Web/singer',$paremt);
	}

	//基本信息
	public function info(){
		if (empty($_SESSION['user_login']['uid'])) {
			$this->is_login();
		}else{
			$this->uid=$_SESSION['user_login']['uid'];
		}
		$paremt=[
			'css'=>$this->css,
			'foot'=>'3',
			'user_login'=>$_SESSION['user_login']
		];
		if (!empty($_POST)) {
			if($_SESSION['user_login']['type']==5){
				//保存经纪人基本信息
				$data=[
					'name'=>$_POST['name'],
					'phone'=>$_POST['phone'],
					'home'=>$_POST['home_1'].'-'.$_POST['home_2'].'-'.$_POST['home_3']
				];

				$this->load->model('User_info_model');
				$this->User_info_model->update_user_info($this->uid,$data);
				
				$this->load->model('User_singer_model');
				$paremt['user_info']=$this->User_singer_model->singer_info($this->uid);

				$this->load->view('/Web/info',$paremt);
			}else{
				//保存基本信息
				$data=[
					'name'=>$_POST['name'],
					'phone'=>$_POST['phone'],
					'history_price'=>$_POST['history_price'],
					'price'=>$_POST['price'],
					'special'=>$_POST['special'],
					'home'=>$_POST['home_1'].'-'.$_POST['home_2'].'-'.$_POST['home_3']
				];
				// $this->pr($data);
				$this->load->model('User_info_model');
				$this->User_info_model->update_user_info($this->uid,$data);

				$this->load->model('User_singer_model');
				$paremt['user_info']=$this->User_singer_model->singer_info($this->uid);
				// $this->pr($paremt);
				$this->load->view('/Web/info',$paremt);
			}
		}else{
			$this->load->model('User_singer_model');
			$paremt['user_info']=$this->User_singer_model->singer_info($this->uid);

			$this->load->view('/Web/info',$paremt);
		}

	}

	//认证
	public function authentication($v=''){
		$verify=$this->input->get('verify');
		if($verify==1 || $verify==2){
			header("Location:singer");
		}else if($verify==0){
			$paremt=[
				'css'=>$this->css,
				'foot'=>'3',
				'v'=>$v
			];
			$this->load->view('/Web/authentication',$paremt);
		}
	}
		//歌手认证
		public function singerAuthentication(){
			if (empty($_SESSION['user_login']['uid'])) {
				$this->is_login();
			}else{
				$this->uid=$_SESSION['user_login']['uid'];
			}
			if (empty($_POST)){
				$paremt=[
					'css'=>$this->css,
					'foot'=>'3'
				];
				$this->load->view('/Web/singerAuthentication',$paremt);
			}else{
				$arr=$_POST;
				$arr['uid']=$this->uid;
				$this->load->model('Verify_model');
				$query=$this->Verify_model->verify_save($arr);
				if($query){
					$phone='13720996309';
					parent::add_user_verify($phone);
					header("Location:singer");die;
				}
			}

		}
		public function success_singer(){
			parent::verify_singer_through($phone);
		}

		//企业认证
		public function enterprise(){
			if (empty($_SESSION['user_login']['uid'])) {
				$this->is_login();
			}else{
				$this->uid=$_SESSION['user_login']['uid'];
			}
			if (empty($_POST)){
				$paremt=[
					'css'=>$this->css,
					'foot'=>'3'
				];
				$this->load->view('/Web/enterprise',$paremt);
			}else{
				$arr=$_POST;
				$arr['uid']=$this->uid;
				$this->load->model('Verify_model');
				$query=$this->Verify_model->verify_save($arr);
				if($query){
					$phone='13720996309';
					parent::add_user_verify($phone);
					header("Location:singer");die;
				}
			}

		}

		//经纪人 经纪公司
		public function broker(){
			if (empty($_SESSION['user_login']['uid'])) {
				$this->is_login();
			}else{
				$this->uid=$_SESSION['user_login']['uid'];
			}

			if (empty($_POST)){
				$paremt=[
					'css'=>$this->css,
					'foot'=>'3'
				];
				$this->load->view('/Web/broker',$paremt);
			}else{
				//存 数据
				$arr=$_POST;
				$arr['uid']=$this->uid;
				$this->load->model('Verify_model');
				$query=$this->Verify_model->verify_save($arr);
				if($query){
					$phone='13720996309';
					parent::add_user_verify($phone);
					header("Location:singer");die;
				}
			}

		}

	//歌手风格
	public function styleLabel(){

		if (empty($_SESSION['user_login']['uid'])) {
			$this->is_login();
		}else{
			$this->uid=$_SESSION['user_login']['uid'];
		}

			$logo=$this->input->post('logo');

		if (empty($_POST)){
			$this->load->model("User_info_model");
			$arr=$this->User_info_model->get_user_info($this->uid);

			$logo=$arr['style'];
		}
			$this->load->model('Style_model');
			$logo_class=$this->Style_model->get_style();

			$data=[];
			$i=0;
			if (!empty($logo))foreach ($logo as $val){
				if ($val){
					$id=is_array($val) ? $val['id']:$val;
					$data[$i]['id']=$id;
					$data[$i]['name']=$logo_class[$id]['name'];
					$i++;
				}
			}
			if (!empty($_POST)){
				$this->Style_model->save_style($this->uid,serialize($data));
				header("Location:singer");
			}

		$data['style']=$data;
		$data['css']=$this->css;

		$this->load->model('Style_model');
		$logo_class=$this->Style_model->get_style();

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
		$data['uid']=$this->uid;
		$this->load->view('/Web/styleLabel',$data);
	}

	//特殊要求

	//消息
	public function message(){
		$data['css']=$this->base_url;
		$this->load->view('/Web/message',$data);
	}
	//消息详情
	public function message_detail(){
		$data['css']=$this->base_url;
		$this->load->view('/Web/message_detail',$data);
	}

	//我的收藏
	public function Mycollection(){
		$paremt['css']=$this->base_url;

		if (empty($_SESSION['user_login']['uid'])) {
			$this->is_login();
		}else{
			$this->uid=$_SESSION['user_login']['uid'];
		}
		//调用数据
		$this->load->model('User_focus_model');
		$arr['user']=$this->User_focus_model->Focus_index($this->uid);

		$paremt=array_merge($paremt,$arr);
		$this->load->view('/Web/Mycollection',$paremt);
	}

	//歌手主页
	public function SingerHome(){
		$paremt['css']=$this->base_url;
		$this->uid=$this->input->get('worker_uid');


		// if (empty($_SESSION['user_login']['uid'])) {
		// 	$this->is_login();
		// }else{
			// $this->login_uid=$_SESSION['user_login']['uid'];
			// $arr['login_uid']=$this->login_uid;
		// }
		if ($this->uid){
			$this->load->model('User_info_model');
			$arr['info']=$this->User_info_model->get_user_info($this->uid);
			$arr['img']=$this->User_info_model->get_user_img($this->uid);
			$arr['introduce']=$this->User_info_model->introduce($this->uid);
			$arr['on_date_defult']=$this->User_info_model->on_date_defult($this->uid);
			$arr['evaluation_defult']=$this->User_info_model->evaluation_defult($this->uid);

			// $this->load->model('User_focus_model');
			// if ($this->login_uid){
			// 	$arr['info']['collection']=$this->User_focus_model->see_fans($data=['uid'=>$this->login_uid,'fans'=>$this->uid]);
			// }else{
			// 	$arr['info']['collection']='L';
			// }

			$arr['info']['worker_uid']=$this->uid;
		}else{
			header("Location:index");
		}


		$paremt=array_merge($paremt,$arr);//$this->pr($paremt);
		$this->load->view('/Web/SingerHome',$paremt);
	}

	//经纪人歌手管理
	public function SingerManagement(){
		$paremt['css']=$this->base_url;

		if (empty($_SESSION['user_login']['uid'])) {
			$this->is_login();
		}else{
			$this->uid=$_SESSION['user_login']['uid'];
		}
		//调用数据
		$this->load->model('User_singer_model');
		$arr['singer']=$this->User_singer_model->index($this->uid);
		$paremt=array_merge($arr,$paremt);
		$this->load->view('/Web/SingerManagement',$paremt);
	}

	//添加歌手
	public function SingerManagementAdd(){
		$paremt['css']=$this->base_url;
		if (empty($_SESSION['user_login']['uid'])) {
			$this->is_login();
		}else{
			$this->uid=$_SESSION['user_login']['uid'];
		}
		
		if (empty($_POST)){
			$singer_uid=$this->input->get('singer_uid');
			if ($singer_uid){
				$this->load->model('User_info_model');
				$user_info['singer']=$this->User_info_model->get_user_info($singer_uid);
				if(empty($user_info['singer']['style'])){
					$paremt=array_merge($user_info,$paremt);
					$this->load->view('/Web/SingerManagementAdd',$paremt);
				}else{
					foreach ($user_info['singer']['style'] as $val) {
						$arr[]=$val['name'];
					}
					$user_info['singer']['style']=$arr;

					$paremt=array_merge($user_info,$paremt);
					$this->load->view('/Web/SingerManagementAdd',$paremt);
				}
			}else{
				$arr['phone']=$_SESSION['user_login']['phone'];
				$paremt=array_merge($arr,$paremt);
				$this->load->view('/Web/SingerManagementAdd',$paremt);
			}
		}else{
			$img=$this->input->post('img');
			$name=$this->input->post('name');
			$phone=$this->input->post('phone');
			$special=$this->input->post('special');
			$price=$this->input->post('price');
			$history_price=$this->input->post('history_price');
			$conf_style=$this->input->post('style');

			$this->load->model('User_info_model');
			$val_arr=$this->User_info_model->style_user_conf($conf_style);

			$uid=$this->input->post('uid');

			if ($uid){
				//更新信息
				$arr=[
					'img'=>$img,
					'name'=>$name,
					'phone'=>$phone,
					'special'=>$special,
					'price'=>$price,
					'history_price'=>$history_price,
					'style'=>serialize($val_arr)
				];
				$this->load->model('User_info_model');
				$this->User_info_model->update_user_info($uid,$arr);
			}else{
				//注册用户
				$data_logo=[
					'phone'=>'Q'.$this->uid.'X'.$phone,
					'email'=>'',
					'create_time'=>date("Y-m-d H:i:s")
				];
				$this->load->model('Login_model');
				$uid=$this->Login_model->add_user($data_logo);


				//添加用户基本信息
				$data_info=[
					'uid'=>$uid,
					'name'=>$name,
					'price'=>$price,
					'history_price'=>$history_price,
					'type'=>'8',
					'home'=>'',
					'img'=>$img,
					'phone'=>$phone,
					'email'=>'',
					'special'=>$special,
					'style'=>serialize($val_arr)

				];
				$this->load->model('User_info_model');
				$this->User_info_model->add_user_info($data_info);

				//建立关系
				$data_singer=[
					'uid'=>$this->uid,
					'singer_uid'=>$uid
				];
				$this->load->model('User_singer_model');
				$this->User_singer_model->add_user_singer($data_singer);
	
				$phone='13720996309';

				parent::add_user_verify($phone);

			}


			header("Location:SingerManagement");
		}

	}

	//查看歌手信息
	public function SingerManagementUpdate(){

	}
	//搜索
	public function search(){
		$paremt['css']=$this->base_url;

		if (empty($_GET['search_name'])){
			//调用热门搜索数据
			$this->load->model('Fixe_hot_model');
			$arr['hot']=$this->Fixe_hot_model->fixe_Hot();
			$paremt=array_merge($paremt,$arr);
			$this->load->view('/Web/search',$paremt);
		}else{
			$search_name=$this->input->get('search_name');
			$this->load->model('Hot_fixe_model');
			$name['search_user']=$this->Hot_fixe_model->hot_Fixe($search_name);

			$paremt=array_merge($paremt,$name);
			
			$this->load->view('/Web/searchList',$paremt);
		}

	}

	//添加歌手
	public function SingerManagementAdd_info(){
		if (empty($_SESSION['user_login']['uid'])) {
			$this->is_login();
		}else{
			$this->uid=$_SESSION['user_login']['uid'];
		}
		$paremt=[
			'css'=>$this->css,
			'foot'=>'3',
			'user_login'=>$_SESSION['user_login']
		];
		if (!empty($_POST)) {
			//保存基本信息
			$data=[
				'name'=>$_POST['name'],
				'phone'=>$_POST['phone'],
				'price'=>$_POST['price'],
				'special'=>$_POST['special'],
				'home'=>$_POST['home_1'].'-'.$_POST['home_2'].'-'.$_POST['home_3']
			];

			$this->load->model('User_info_model');
			$this->User_info_model->update_user_info($this->uid,$data);
			return $this->singer();
		}else{
			$this->load->model('User_singer_model');
			$paremt['user_info']=$this->User_singer_model->singer_info($this->uid);

			$this->load->view('/Web/info',$paremt);
		}
	}

	//用户意见反馈
	public function Feedback(){
		if (empty($_SESSION['user_login']['uid'])) {
			$this->is_login();
		}else{
			$this->uid=$_SESSION['user_login']['uid'];
		}

		if (empty($_POST)){
			$this->load->view('/Web/Feedback.html');
		}else{
			$arr=[
				'uid'=>$_SESSION['user_login']['uid'],
				'name'=>$_SESSION['user_login']['name'],
				'content'=>$_POST['content'],
				'phone_email'=>$_POST['phone_email'],
			];
			$this->load->model('Login_model');
			$this->Login_model->lasa($arr);
			header("Location:singer");
		}

	}

	public function music(){
		$this->load->view('/Web/music.html',['uid'=>$this->input->get('uid')]);
	}

	public function video(){
		
		$this->load->view('/Web/video.html',['uid'=>$this->input->get('uid')]);
	}

	public function date(){
		if (empty($_SESSION['user_login']['uid'])) {
			$this->is_login();
		}else{
			$this->uid=$_SESSION['user_login']['uid'];
		}

		$this->singer=$this->input->get('singer');

		$params=['uid'=>$this->uid,'singer'=>$this->singer];

		$this->load->model("Order_date_model");
		$arr=$this->Order_date_model->get_order_date2($this->singer);

		$params['data']=json_encode($arr);
		$this->load->view('/Web/date.html',$params);
	}

	public function noDate(){
		if (empty($_SESSION['user_login']['uid'])) {
			$this->is_login();
		}else{
			$this->uid=$_SESSION['user_login']['uid'];
		}

		$this->singer=$this->input->get('singer');

		$params=['uid'=>$this->uid,'singer'=>$this->singer];

		$this->load->model("Order_date_model");
		$arr=$this->Order_date_model->get_order_date2($this->singer);

		$params['data']=json_encode($arr);
		$this->load->view('/Web/noDate.html',$params);
	}

	public function Agreement(){
		$this->load->view('/Web/Agreement.html');
	}

	public function adout(){
		$this->load->view('/Web/adout.html');
	}

	public function del_singer(){
		
	}

	public function ajax(){
		$this->load->view('/Web/ajax.html');
	}

	public function mob(){
//		var_dump(parent::isMobile());exit();
		if (parent::isMobile()){
			echo '手机';exit();
		}else{
		echo '电脑';exit();
		}
	}

	public function alipay(){
		$order_sn=$this->input->get('order_sn');
		$params=[
			'order_sn'=>$order_sn,
			'name'=>'隔壁老王'
		];
		$this->load->view('/Web/alipay.html',$params);
	}
}
 ?>