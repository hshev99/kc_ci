<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Pc extends CI_Controller {

	public $params;
	public $uid;
	public function __construct()
	{
		parent::__construct();

		if (!empty($_SESSION['user_login'])){
			$params['user_login']=$_SESSION['user_login'];
			$this->params=$params;
		}
		$this->uid=$this->input->get('uid');;
	}

	public function index(){
		$this->load->view('/Pc/index.html',$this->params);
	}

	public function is_login(){
		if (empty($_SESSION['user_login'])){
			header("Location:login");
		}
	}
	public function logout(){
		unset($_SESSION['user_login']);
		header("Location:index");
	}
	public function artist(){
		$this->load->view('/Pc/artist.html',$this->params);
	}

	public function login(){
		$this->load->view('/Pc/login.html');
	}
    //微博登录
    public function login_lib(){
        $this->load->library('Lib');
    }
    public function Login_callback(){
        $this->load->library('Back');
    }

	public function artistHome(){
		$uid=$this->input->get('uid');
		$params=[
			'uid'=>$uid
		];
		$this->params['uid']=$uid;
		$this->load->view('/Pc/artistHome.html',$this->params);
	}

	public function singer(){
		self::is_login();

		//分类[1游客2注册未认证3注册已认证4企业认证5经纪人6经纪公司7歌手8旗下歌手]
//		agentHome  经纪人
//brokerageHome 经济公司
//companyHome 企业
//singerHome 歌手
//ordinaryHome 未认证用户
		$this->params['uid']=$this->params['user_login']['uid'];
		switch ($this->params['user_login']['type']){
			case 2:
				$this->load->view('/Pc/ordinaryHome.html',$this->params);
				break;

			case 4:
				$this->load->view('/Pc/companyHome.html',$this->params);
				break;

			case 5:
				$this->load->view('/Pc/agentHome.html',$this->params);
				break;

			//交易完成
			case 6:
				$this->load->view('/Pc/brokerageHome.html',$this->params);
				break;
			case 7:
				$this->load->view('/Pc/singerHome.html',$this->params);
				break;

		}
	}

	public function singerHome(){
		$uid=$this->input->get('uid');
		$params=[
			'uid'=>$uid
		];
		$this->params['uid']=$uid;
		$this->load->view('/Pc/singerHome.html',$this->params);
	}

	public function registered(){
		$this->load->view('/Pc/registered.html',$this->params);
	}

	public function collection(){
		$this->load->view('/Pc/collection.html',$this->params);
	}
	public function ordinaryHome(){
		$this->load->view('/Pc/ordinaryHome.html',$this->params);
	}
	public function agentHome(){
		$this->load->view('/Pc/agentHome.html',$this->params);
	}
	public function brokerageHome(){
		$this->load->view('/Pc/brokerageHome.html',$this->params);
	}
	public function companyHome(){
		$this->load->view('/Pc/companyHome.html',$this->params);
	}
	public function coll_info(){
		$this->load->view('/Pc/coll_info.html',$this->params);
	}
	public function about(){
		$this->load->view('/Pc/about.html',$this->params);
	}
	public function payment(){
		$uid=$this->input->get('uid');
		$order_sn=$this->input->get('order_sn');
		$params=[
			'uid'=>$uid,
			'order_sn'=>$order_sn,
		];

		$this->load->view('/Pc/payment.html',$params);
	}

	public function placeOrder(){
		self::is_login();
		$uid=$this->input->get('uid');
		$activity_id=$this->input->get('activity_id');
		$params=[
			'uid'=>$uid,
			'activity_id'=>$activity_id,
		];
		$this->params['uid']=$uid;
		$this->params['activity_id']=$activity_id;
		$this->load->view('/Pc/placeOrder.html',$this->params);
	}

	public function order(){
		self::is_login();
		$uid=$this->input->get('uid');
		$params=[
			'uid'=>$uid
		];
		$this->params['uid']=$uid;
		$this->load->view('/Pc/order.html',$this->params);
	}

	public function orderInfo(){
		$order_sn=$this->input->get('order_sn');
		$params=[
			'order_sn'=>$order_sn
		];
		$this->params['order_sn']=$order_sn;
		$this->load->view('/Pc/orderInfo.html',$this->params);
	}

	public function authenticate(){
		if(empty($_SESSION['user_login']['uid'])){
        	header("Location:login");
        }else{
			$this->load->view('/Pc/authenticate.html');
        }
	}

	public function cancel_order(){


		$this->order_sn=$this->input->get('order_sn');

		$this->load->model("Order_pay_model");

		$data=[
			'status'=>'3',
		];

		$this->Order_pay_model->update_order_pay($this->order_sn,$data);


		//短信提示

		header("Location:orderInfo?order_sn={$this->order_sn}");
	}

	//歌手认证提交信息
	public function authentication_singer(){
        $this->load->model('Verify_model');
        if(empty($_SESSION['user_login']['uid'])){
        	header("Location:login");
        }else{
        	$uid=$_SESSION['user_login']['uid'];
        }

		$arr=[
			'uid'=>$uid,
			'way'=>$this->way=$this->input->post('way'),
			'name'=>$this->name=$this->input->post('name_sing'),
			'phone'=>$this->phone=$this->input->post('phone_sing'),
			'verify_type'=>$this->verify_type=$this->input->post('certificates'),
			'gender'=>$this->gender=$this->input->post('sing_lei'),
			'law_number'=>$this->law_name=$this->input->post('id_sing'),
            'img_positive'=>$this->img_positive=$this->input->post('img_positive'),
            'img_reverse'=>$this->img_reverse=$this->input->post('img_reverse'),
			'price'=>$this->price=$this->input->post('pic_sing')
		];

        $way_name=[
            1=>'歌手',
            2=>'经纪人',
            3=>'经纪公司',
            4=>'企业'
        ];
        $data=[
            'msg'=>'已提交认证信息,请等待审核',
            'way'=>$arr['way'],
            'way_name'=>$way_name[$arr['way']]
        ];

        if($this->Verify_model->pcverify_save($arr)){
        	$this->load->view('/Pc/index.html');
        }else{
        	echo "false";die;
        }
	}
	//企业认证
	public function authentication_enterprise(){
        $this->load->model('Verify_model');
        if(empty($_SESSION['user_login']['uid'])){
        	header("Location:login");
        }else{
        	$uid=$_SESSION['user_login']['uid'];
        }

		$arr=[
			'uid'=>$uid,
			'way'=>$this->way=$this->input->post('way1'),
			'company_name'=>$this->company_name=$this->input->post('name_enter'),//企业名称
			'phone_enter'=>$this->phone_enter=$this->input->post('phone_enter'),//联系方式
			'blr_number'=>$this->blr_number=$this->input->post('license_enter'),//营业执照注册号
			'app_enter'=>$this->app_enter=$this->input->post('app_enter'),//联系地址
			'img_hand'=>$this->img_hand=$this->input->post('fileuploader2'),//营业执照上传
			'law_name'=>$this->law_name=$this->input->post('per_name_enter'),//法人姓名
			'phone'=>$this->phone=$this->input->post('per_phone_enter'),//联系方式
			'verify_type'=>$this->verify_type=$this->input->post('enter'),//证件类型
			'law_number'=>$this->law_number=$this->input->post('per_id_enter'),//证件号码
			'img_positive'=>$this->img_positive=$this->input->post('img_positive1'),//证件图片(正)
			'img_reverse'=>$this->img_reverse=$this->input->post('img_reverse1'),//证件图片(反)
		];
		// $this->pr($arr);
		$way_name=[
            1=>'歌手',
            2=>'经纪人',
            3=>'经纪公司',
            4=>'企业'
        ];
        $data=[
            'msg'=>'已提交认证信息,请等待审核',
            'way'=>$arr['way'],
            'way_name'=>$way_name[$arr['way']]
        ];

        if($this->Verify_model->verify_save($arr)){
        	$this->load->view('/Pc/index.html');
        }else{
        	echo "false";die;
        }

	}
	//经纪人认证
	public function authentication_broker(){
		 $this->load->model('Verify_model');
        if(empty($_SESSION['user_login']['uid'])){
        	header("Location:login");
        }else{
        	$uid=$_SESSION['user_login']['uid'];
        }

        $arr=[
			'uid'=>$uid,
			'way'=>$this->way=$this->input->post('way2'),
			'company_name'=>$this->company_name=$this->input->post('broker_name'),//经纪人名称
			'phone'=>$this->phone=$this->input->post('broker_phone'),//联系方式
			'verify_type'=>$this->verify_type=$this->input->post('broker'),//证件类型
			'blr_number'=>$this->blr_number=$this->input->post('broker_id'),//经纪人证件号码 
			'img_positive'=>$this->img_positive=$this->input->post('fileuploader5'),//证件图片(正)
			'img_reverse'=>$this->img_reverse=$this->input->post('fileuploader6'),//证件图片(反)
			'img_hand'=>$this->img_hand=$this->input->post('img_positive7'),//经纪人证上传
		];
		// $this->pr($arr);

		$way_name=[
            1=>'歌手',
            2=>'经纪人',
            3=>'经纪公司',
            4=>'企业'
        ];
        $data=[
            'msg'=>'已提交认证信息,请等待审核',
            'way'=>$arr['way'],
            'way_name'=>$way_name[$arr['way']]
        ];

        if($this->Verify_model->verify_save($arr)){
        	$this->load->view('/Pc/index.html');
        }else{
        	echo "false";die;
        }
	}
	//经纪公司认证
	public function authentication_broker_enterprise(){
		 $this->load->model('Verify_model');
        if(empty($_SESSION['user_login']['uid'])){
        	header("Location:login");
        }else{
        	$uid=$_SESSION['user_login']['uid'];
        }

		$arr=[
			'uid'=>$uid,
			'way'=>$this->way=$this->input->post('way3'),
			'company_name'=>$this->company_name=$this->input->post('name_agency'),//经纪公司名称
			'phone_enter'=>$this->phone_enter=$this->input->post('phone_agency'),//联系方式
			'blr_number'=>$this->blr_number=$this->input->post('license_agency'),//营业执照注册号
			'app_enter'=>$this->app_enter=$this->input->post('app_agency'),//联系地址
			'img_hand'=>$this->img_hand=$this->input->post('img_positive4'),//营业执照上传
			'law_name'=>$this->law_name=$this->input->post('per_name_agency'),//法人姓名
			'phone'=>$this->phone=$this->input->post('per_phone_agency'),//联系方式
			'verify_type'=>$this->verify_type=$this->input->post('agency'),//证件类型
			'law_number'=>$this->law_number=$this->input->post('per_id_agency'),//证件号码
			'img_positive'=>$this->img_positive=$this->input->post('img_positive3'),//证件图片(正)
			'img_reverse'=>$this->img_reverse=$this->input->post('img_reverse3'),//证件图片(反)
		];
		// $this->pr($arr);
		$way_name=[
            1=>'歌手',
            2=>'经纪人',
            3=>'经纪公司',
            4=>'企业'
        ];
        $data=[
            'msg'=>'已提交认证信息,请等待审核',
            'way'=>$arr['way'],
            'way_name'=>$way_name[$arr['way']]
        ];

        if($this->Verify_model->verify_save($arr)){
        	$this->load->view('/Pc/index.html');
        }else{
        	echo "false";die;
        }
	}
}
 ?>