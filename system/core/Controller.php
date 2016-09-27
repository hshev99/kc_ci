<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2016, British Columbia Institute of Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	CodeIgniter
 * @author	EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (https://ellislab.com/)
 * @copyright	Copyright (c) 2014 - 2016, British Columbia Institute of Technology (http://bcit.ca/)
 * @license	http://opensource.org/licenses/MIT	MIT License
 * @link	https://codeigniter.com
 * @since	Version 1.0.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Application Controller Class
 *
 * This class object is the super class that every library in
 * CodeIgniter will be assigned to.
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		EllisLab Dev Team
 * @link		https://codeigniter.com/user_guide/general/controllers.html
 */
class CI_Controller {

	public $web;public $base_url;
	/**
	 * Reference to the CI singleton
	 *
	 * @var	object
	 */
	private static $instance;
	private $_secret_key = 'key';
	public $uid;
	/**
	 * Class constructor
	 *
	 * @return	void
	 */
	public function __construct()
	{
		$this->_redis = new Redis();
		if (!$this->_redis->connect('123.57.56.133',6379,3)){
			self::outPutEnd([],123,'redis Not connected');
		}

		self::$instance =& $this;

		// Assign all the class objects that were instantiated by the
		// bootstrap file (CodeIgniter.php) to local class variables
		// so that CI can run as one big super object.
		foreach (is_loaded() as $var => $class)
		{
			$this->$var =& load_class($class);
		}

		$this->load =& load_class('Loader', 'core');
		$this->load->initialize();
		$this->load->library('session');
		log_message('info', 'Controller Class Initialized');
		$this->base_url = $this->config->item('base_url');

		//验证原子信息
		$data=json_decode(parent::get_json(),true);
		if (isset($data['token']) && $data['token'] != ''){

			$user_info = $this->_redis->get($data['token']);

			if (empty($user_info)) self::outPutEnd([],144,'登录过期,请重新登录');

			$user_info_arr = json_decode($user_info);

			$this->uid=@$user_info_arr['user_id'];
		}else{
			self::outPutEnd([],123,'Undetectable token');
		}

		//网站请求存入session

		//记录日志
		self::log('-|post>>-'.json_encode($_POST).'-|get>>-'.json_encode($_GET).'-|json>>-'.json_encode(self::get_json()));
	}

	// --------------------------------------------------------------------

	/**
	 * Get the CI singleton
	 *
	 * @static
	 * @return	object
	 */
	public static function &get_instance()
	{
		return self::$instance;
	}

	public function web_login_session($uid=''){
		if (!$uid) return '';
		if (isset($_SERVER['SERVER_NAME']) && explode('.',$_SERVER['SERVER_NAME'])[1]=='51huole'){
			$this->load->model('User_info_model');
			$user_info=$this->User_info_model->get_user_info($uid);

			$_SESSION['user_login']=$user_info;
		}

		return '';
	}
	//接口输出
	public function output($arr=[],$error=0,$errorMsg=''){
		$arr=[
			'error'=>$error,
			'errorMsg'=>$errorMsg,
			'results'=>$arr
		];
		return $arr;
	}

	public function outPutEnd($arr=[],$error=0,$errorMsg=''){
		$arr=[
			'error'=>$error,
			'errorMsg'=>$errorMsg,
			'results'=>$arr
		];
//		exit(json_encode($arr,JSON_UNESCAPED_UNICODE));
		exit(json_encode($arr));
	}

	//CURL get 请求
	public function curl_get($url=null){
		//初始化
		$ch = curl_init();

		//设置选项，包括URL
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);

		//执行并获取HTML文档内容
		$output = curl_exec($ch);

		//释放curl句柄
		curl_close($ch);

		//打印获得的数据
		return $output;
	}

	//CURL post
	public function curl_post($url='',$post_data=''){
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		// post数据
		curl_setopt($ch, CURLOPT_POST, 1);
		// post的变量
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);

		$output = curl_exec($ch);
		curl_close($ch);

		//打印获得的数据
		print_r($output);
	}

	//curl post json
	public function curl_post_json($url='',$json=''){
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS,$json);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'Content-Type: application/json',
				'Content-Length: ' . strlen($json))
		);

		$result = curl_exec($ch);

		return $result;
	}

	function xml_to_array($xml)
	{
		$reg = "/<(\\w+)[^>]*?>([\\x00-\\xFF]*?)<\\/\\1>/";
		if(preg_match_all($reg, $xml, $matches))
		{
			$count = count($matches[0]);
			$arr = array();
			for($i = 0; $i < $count; $i++)
			{
				$key= $matches[1][$i];
				$val = self::xml_to_array( $matches[2][$i] );  // 递归
				if(array_key_exists($key, $arr))
				{
					if(is_array($arr[$key]))
					{
						if(!array_key_exists(0,$arr[$key]))
						{
							$arr[$key] = array($arr[$key]);
						}
					}else{
						$arr[$key] = array($arr[$key]);
					}
					$arr[$key][] = $val;
				}else{
					$arr[$key] = $val;
				}
			}
			return $arr;
		}else{
			return $xml;
		}
	}
	function xmlToArray($xml)
	{
		//禁止引用外部xml实体
		libxml_disable_entity_loader(true);
		$values = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
		return $values;
	}

	public function log($data=''){
		$path="/fire/phpweb/kc_ci/application/logs/".date("Y-m-d").'/'.date("H");
		$path_date="/fire/phpweb/kc_ci/application/logs/".date("Y-m-d");

		if(!is_file($path_date)) @mkdir($path_date,0777);
		if(!is_file($path)) @mkdir($path,0777);

		$open=fopen($path."/".$_SERVER["REMOTE_ADDR"].".txt","a" );
		fwrite($open,$_SERVER["REMOTE_ADDR"].'---'.date("Y-m-d H:i:s").'---'.$GLOBALS['URI']->uri_string.'---'.$data."---\n");
		fclose($open);
	}

	public function log_alipay($data=''){
		$open=fopen("/fire/phpweb/fire/application/logs/log_alipay.txt","a" );
		fwrite($open,date("Y-m-d H:i:s").'---'.$GLOBALS['URI']->uri_string.'>>>'.$_SERVER['REQUEST_URI'].'---'.$data."---\n");
		fclose($open);
	}

	public function log_weichat($data=''){
		$open=fopen("/fire/phpweb/fire/application/logs/log_weichat.txt","a" );
		fwrite($open,date("Y-m-d H:i:s").'---'.$data."---\n");
		fclose($open);
	}

	public function log_api($data=''){
		$open=fopen("/fire/phpweb/kc_ci/application/logs/log_api.txt","a" );
		fwrite($open,date("Y-m-d H:i:s").'---'.$data."---\n");
		fclose($open);
	}

	function pr($data=[]){
		echo '<pre>';
		print_r($data);
		echo '</pre>';
		exit;
	}

	public function get_json(){
		if(empty($GLOBALS['HTTP_RAW_POST_DATA'])){
			$data=file_get_contents("php://input");
		}else{
			$data=$GLOBALS['HTTP_RAW_POST_DATA'];
		}
		return $data;
	}

	public function prod_order(){
		function getMillisecond() {
			list($t1, $t2) = explode(' ', microtime());
			return (float)sprintf('%.0f',(floatval($t1)+floatval($t2))*1000);
		}
		return getMillisecond().mt_rand(10000,99999);
	}

	/**
	 * @content 接受订单
	 * @author Safari
	 * @param $order_sn,$phone
	 */
	public function accept_order_message($order_sn='',$phone=''){
		 $params='';
		 $params .='&account=cf_huole';
		 $params .='&password=360e15816d63e2dd99cbf9a41c018fd5';
		 $params .="&mobile=$phone";
		 $r=$order_sn;
		$content="恭喜您:{$r}已接受您的订单，“火了演艺”客服将在15-30分钟内与您联系，请保持电话畅通。";
		 $params .="&content=".$content;
		 $url = "http://106.ihuyi.cn/webservice/sms.php?method=Submit$params";

		 $data=self::curl_get($url);
		 $gets=self::xml_to_array($data);

		self::curl_get('push.51huole.cn?content='.$content.'&ID='.self::get_REGISTRATION_ID($phone));
		return $gets['SubmitResult'];
	}

	/**
	 * @content 确认订单-预约方
	 * @author Safari
	 * @param $order_sn,$phone
	 */
	public function confirm_order_message($order_sn='',$phone=''){
		$params='';
		$params .='&account=cf_huole';
		$params .='&password=360e15816d63e2dd99cbf9a41c018fd5';
		$params .="&mobile=$phone";
		$r=$order_sn;
		$content="编号为{$r}的订单已确认，预约金将转至艺人的账户。";
		$params .="&content=".$content;
		$url = "http://106.ihuyi.cn/webservice/sms.php?method=Submit$params";

		$data=self::curl_get($url);
		$gets=self::xml_to_array($data);

		self::curl_get('push.51huole.cn?content='.$content.'&ID='.self::get_REGISTRATION_ID($phone));

		return $gets['SubmitResult'];
	}

	/**
	 * @content 确认订单-艺人
	 * @author Safari
	 * @param $order_sn $phone
	 */
	public function confirm_to_attend_yiren($phone=''){
		$params='';
		$params .='&account=cf_huole';
		$params .='&password=360e15816d63e2dd99cbf9a41c018fd5';
		$params .="&mobile=$phone";
		$content='已确认您到场，预约金将转至您的账户，请耐心等待。';
		$params .="&content=".$content;
		$url = "http://106.ihuyi.cn/webservice/sms.php?method=Submit$params";
		$data=self::curl_get($url);
		$gets=self::xml_to_array($data);
		self::curl_get('push.51huole.cn?content='.$content.'&ID='.self::get_REGISTRATION_ID($phone));
		return $gets['SubmitResult'];
	}

	/**
	 * @content 拒绝订单
	 * @author  Safari
	 * @param   user,phone
	 */
	public function refused_order_message($user='',$phone='',$reason=''){
		$params='';
		$params .='&account=cf_huole';
		$params .='&password=360e15816d63e2dd99cbf9a41c018fd5';
		$params .="&mobile=$phone";
		$r=$user;
		$content="非常抱歉，{$r}拒绝了您的订单，拒绝理由：{$reason}，预约金将在1~7个工作日内退还至您的账户。";
		$params .="&content=".$content;
		$url = "http://106.ihuyi.cn/webservice/sms.php?method=Submit$params";

		$data=self::curl_get($url);
		$gets=self::xml_to_array($data);

		self::curl_get('push.51huole.cn?content='.$content.'&ID='.self::get_REGISTRATION_ID($phone));

		return $gets['SubmitResult'];
	}

	/**
	 * @content 下单 老板接受短信
	 * @author Safari
	 * @param $order_sn $phone
	 */
	public function submit_boss_order_message($order_sn='',$phone='',$uid=''){
		$params='';
		$params .='&account=cf_huole';
		$params .='&password=360e15816d63e2dd99cbf9a41c018fd5';
		$params .="&mobile=$phone";
		$r=$order_sn;
		$content="尊敬的火了演艺用户，您的订单编号:{$r}已支付成功，请耐心等待艺人接单。";
		$params .="&content=".$content;
		$url = "http://106.ihuyi.cn/webservice/sms.php?method=Submit$params";

		$data=self::curl_get($url);
		$gets=self::xml_to_array($data);

		self::curl_get('push.51huole.cn?content='.$content.'&ID='.self::get_REGISTRATION_ID($phone));

		$title="付款成功";
		$da=[
			0=>["name"=>"尊敬的火了演艺用户,您的订单编号为:{$order_sn}已经付款成功"],
			1=>["nam"=>''],
			2=>["nam"=>''],
			3=>["nam"=>''],
		];
		self::Message_m($uid,$title,$da);
		return $gets['SubmitResult'];
	}

	/**
	 * @content 下单 老板接受短信
	 * @author Safari
	 * @param $order_sn $phone
	 */
	public function submit_worker_order_message($order_sn='',$phone='',$uid=''){
		$params='';
		$params .='&account=cf_huole';
		$params .='&password=360e15816d63e2dd99cbf9a41c018fd5';
		$params .="&mobile=$phone";
		$r=$order_sn;
		//$params .="&content=尊敬的火了演义用户，已接到订单:{$r}的预约，请尽快登录火了演义APP处理订单。";
		$content="尊敬的“火了演艺”用户，已接到订单:{$r}的预约，请尽快登录“火了演艺”客户端处理订单。";
		$params .="&content=".$content;
		$url = "http://106.ihuyi.cn/webservice/sms.php?method=Submit$params";

		$data=self::curl_get($url);
		$gets=self::xml_to_array($data);
		self::curl_get('push.51huole.cn?content='.$content.'&ID='.self::get_REGISTRATION_ID($phone));

		$title="预约信息";
		$da=[
			0=>["name"=>"尊敬的“火了演艺”用户，已接到订单:{$order_sn}的预约，请尽快登录“火了演艺”客户端处理订单。"],
			1=>["nam"=>''],
			2=>["nam"=>''],
			3=>["nam"=>''],
		];
		self::Message_m($uid,$title,$da);

		return $gets['SubmitResult'];
	}

	/**
	 * @content 确认订单
	 * @author Safari
	 * @param $order_sn $phone
	 */
	public function confirm_to_attend($phone='',$uid=''){
		$params='';
		$params .='&account=cf_huole';
		$params .='&password=360e15816d63e2dd99cbf9a41c018fd5';
		$params .="&mobile=$phone";
		$content='预约方已确认到场，您的款项将在3个工作日内转入您的账户内！';
		$params .="&content=".$content;
		$url = "http://106.ihuyi.cn/webservice/sms.php?method=Submit$params";
		$data=self::curl_get($url);
		$gets=self::xml_to_array($data);
		self::curl_get('push.51huole.cn?content='.$content.'&ID='.self::get_REGISTRATION_ID($phone));
		return $gets['SubmitResult'];
	}

	//歌手认证通过
	public function verify_singer_through($phone=''){
		if (!$phone) return '';

		$params='';
		$params .='&account=cf_huole';
		$params .='&password=360e15816d63e2dd99cbf9a41c018fd5';
		$params .="&mobile=$phone";
		$content='尊敬的用户，您的认证申请已经通过，请尽快登录火了演艺APP设置您的档期与价格。';
		$params .="&content=".$content;
		$url = "http://106.ihuyi.cn/webservice/sms.php?method=Submit$params";
		$data=self::curl_get($url);
		$gets=self::xml_to_array($data);
		self::curl_get('push.51huole.cn?content='.$content.'&ID='.self::get_REGISTRATION_ID($phone));
		return $gets['SubmitResult'];

	}

	//经纪人认证通过
	public function verify_agent_through($phone=''){
		if (!$phone) return '';

		$params='';
		$params .='&account=cf_huole';
		$params .='&password=360e15816d63e2dd99cbf9a41c018fd5';
		$params .="&mobile=$phone";
		$content='尊敬的火了演艺用户，你的认证申请已通过，请尽快登录火了演艺APP管理您的艺人。';
		$params .="&content=".$content;
		$url = "http://106.ihuyi.cn/webservice/sms.php?method=Submit$params";
		$data=self::curl_get($url);
		$gets=self::xml_to_array($data);
		self::curl_get('push.51huole.cn?content='.$content.'&ID='.self::get_REGISTRATION_ID($phone));
		return $gets['SubmitResult'];

	}

	//公司认证通过
	public function verify_enterprise_through($phone=''){
		if (!$phone) return '';

		$params='';
		$params .='&account=cf_huole';
		$params .='&password=360e15816d63e2dd99cbf9a41c018fd5';
		$params .="&mobile=$phone";
		$content='尊敬的火了演艺用户，您的认证申请已通过，赶快登录火了演艺APP去邀约艺人吧！';
		$params .="&content=".$content;
		$url = "http://106.ihuyi.cn/webservice/sms.php?method=Submit$params";
		$data=self::curl_get($url);
		$gets=self::xml_to_array($data);
		self::curl_get('push.51huole.cn?content='.$content.'&ID='.self::get_REGISTRATION_ID($phone));
		return $gets['SubmitResult'];

	}


	//认证失败
	public function verify_failure($phone='',$kf_phone='',$result=''){
		if (!$phone) return '';

		$params='';
		$params .='&account=cf_huole';
		$params .='&password=360e15816d63e2dd99cbf9a41c018fd5';
		$params .="&mobile=$phone";
		$content="	尊敬的用户，您提交的认证信息因{$result}原因未通过审核，请登陆“火了演艺”客户端进行信息修改。若有疑问，请致电咨询，{$kf_phone}。";
		$params .="&content=".$content;
		$url = "http://106.ihuyi.cn/webservice/sms.php?method=Submit$params";
		$data=self::curl_get($url);
		$gets=self::xml_to_array($data);
		self::curl_get('push.51huole.cn?content='.$content.'&ID='.self::get_REGISTRATION_ID($phone));
		return $gets['SubmitResult'];

	}

	//提交认证信息后台查收
	public function add_user_verify($phone){
		if (!$phone) return '';

		$params='';
		$params .='&account=cf_huole';
		$params .='&password=360e15816d63e2dd99cbf9a41c018fd5';
		$params .="&mobile=$phone";
		$content='尊敬的用户，已经有新用户提交认证信息，请登录火了演艺后台进行操作!';
		$params .="&content=".$content;
		$url = "http://106.ihuyi.cn/webservice/sms.php?method=Submit$params";
		$data=self::curl_get($url);
		$gets=self::xml_to_array($data);
		self::curl_get('push.51huole.cn?content='.$content.'&ID='.self::get_REGISTRATION_ID($phone));
		return $gets['SubmitResult'];
	}
	
	public function add_user_verify_rres($rres,$phone){
		if (!$phone) return '';

		$params='';
		$params .='&account=cf_huole';
		$params .='&password=360e15816d63e2dd99cbf9a41c018fd5';
		$params .="&mobile=$phone";
		$content="尊敬的用户，{$rres}已经有新用户提交认证信息，请登录火了演艺后台进行操作!";
		$params .="&content=".$content;
		$url = "http://106.ihuyi.cn/webservice/sms.php?method=Submit$params";
		$data=self::curl_get($url);
		$gets=self::xml_to_array($data);
		self::curl_get('push.51huole.cn?content='.$content.'&ID='.self::get_REGISTRATION_ID($phone));
		return $gets['SubmitResult'];
	}


	//提交订单客服跟随订单
	public function boos_worker_phone($phone,$boos_name,$worker_name){
		if (!$phone) return '';

		$params='';
		$params .='&account=cf_huole';
		$params .='&password=360e15816d63e2dd99cbf9a41c018fd5';
		$params .="&mobile=$phone";
		$content="尊敬的后台管理员，用户{$boos_name}预约艺人{$worker_name}的订单已支付成功，请尽快安排客服人员跟踪订单。";
		$params .="&content=".$content;
		$url = "http://106.ihuyi.cn/webservice/sms.php?method=Submit$params";
		$data=self::curl_get($url);
		$gets=self::xml_to_array($data);
		self::curl_get('push.51huole.cn?content='.$content.'&ID='.self::get_REGISTRATION_ID($phone));
		return $gets['SubmitResult'];
	}
	
	public function get_REGISTRATION_ID($phone=''){
		if (!$phone) return '';
		$this->load->model('User_reg_id_model');
		return $this->User_reg_id_model->get_user_reg_id($phone);
	}

	public function encode($data) {
		$td = mcrypt_module_open(MCRYPT_RIJNDAEL_256,'',MCRYPT_MODE_CBC,'');
		$iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td),MCRYPT_RAND);
		mcrypt_generic_init($td,$this->_secret_key,$iv);
		$encrypted = mcrypt_generic($td,$data);
		mcrypt_generic_deinit($td);

		return $iv . $encrypted;
	}

	public function decode($data) {
		$td = mcrypt_module_open(MCRYPT_RIJNDAEL_256,'',MCRYPT_MODE_CBC,'');
		$iv = mb_substr($data,0,32,'latin1');
		mcrypt_generic_init($td,$this->_secret_key,$iv);
		$data = mb_substr($data,32,mb_strlen($data,'latin1'),'latin1');
		$data = mdecrypt_generic($td,$data);
		mcrypt_generic_deinit($td);
		mcrypt_module_close($td);

		return trim($data);
	}

	public function Message_m($uid='',$title='',$data=[]){
		$this->load->model('Message_model');
		$this->Message_model->set_user_message($uid,$title,$data);
	}

}
