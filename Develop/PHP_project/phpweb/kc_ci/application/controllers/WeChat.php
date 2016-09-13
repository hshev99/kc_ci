<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Wechat extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

	}

	public function index(){
		echo '123231231';exit;
		$this->pr($GLOBALS);
		exit('213');
	}

	public function unifiedorder($order_sn=''){

		$appid='wxab054e7123df6377';
		$attach='火了科技';
		$body='预约艺人';
		$device_info='WEB';
		$mch_id='1364523002';
		$nonce_str=md5(rand(0,999999));
		$notify_url='http://www.51huole.cn/WeChat/notify';
		$out_trade_no='123213213213123';
		$spbill_create_ip=$_SERVER["REMOTE_ADDR"];
		$total_fee=1;
		$trade_type='APP';

		$sign="appid={$appid}&attach={$attach}&body={$body}&device_info={$device_info}&mch_id={$mch_id}&nonce_str={$nonce_str}&notify_url={$notify_url}&out_trade_no={$out_trade_no}&spbill_create_ip={$spbill_create_ip}&total_fee={$total_fee}&trade_type={$trade_type}&key=fa838ca21758f9f89712caea93288481";
		$sign=parent::trimall($sign);
		$str=(string)$sign;
		$str=str_replace("\n\r","",$str);
		$sign=md5(stripcslashes($str));
		//
		$xmlData='<?xml version="1.0" encoding="utf-8"?>
<xml>
	<appid>'.$appid.'</appid>
	<attach>'.$attach.'</attach>
	<body>'.$body.'</body>
	<device_info>'.$device_info.'</device_info>
	<mch_id>'.$mch_id.'</mch_id>
	<nonce_str>'.$nonce_str.'</nonce_str>
	<notify_url>'.$notify_url.'</notify_url>
	<out_trade_no>'.$out_trade_no.'</out_trade_no>
	<spbill_create_ip>'.$spbill_create_ip.'</spbill_create_ip>
	<total_fee>'.$total_fee.'</total_fee>
	<trade_type>'.$trade_type.'</trade_type>
	<sign>'.$sign.'</sign>
</xml>
';
		$url ="http://www.51huole.cn/WeChat/notify";

		$header[]="Content-Type: text/xml; charset=utf-8";
//		$header[]="User-Agent: Apache/1.3.26 (Unix)";
//		$header[]="Host: 127.0.0.1";
		$header[]="Accept: text/html, image/gif, image/jpeg, *; q=.2, */*; q=.2";
		$header[]="Connection: keep-alive";
		$header[]="Content-Length: ".strlen($xmlData);
		//$url = "http://{$_SERVER['HTTP_HOST']}".dirname($_SERVER['PHP_SELF']).'/response.php';
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $xmlData);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		$res = curl_exec($ch);
		curl_close($ch);
		//header('Content-Type:text/xml; charset=utf-8');
		$arr=parent::xmlToArray($res);

		//$arr['timeStamp']=time();
//		return $arr;
		$this->pr($arr);
		exit();
	}

	public function notify(){
		$fileContent = file_get_contents("php://input");
		$arr=parent::xmlToArray($fileContent);
		parent::log_weichat(json_encode($arr));
		parent::log_weichat($fileContent);

		if ($arr['return_code'] == 'SUCCESS'){
			$price=number_format(($arr['total_fee']/100),2);
			$order_sn=$arr['out_trade_no'];

			//获取订单信息
			$this->load->model('Orders_deta_model');
			$order_data=$this->Orders_deta_model->order_detail($order_sn);
			if ($order_data['notice'] ==0){
				if($order_data['phone']==$order_data['boss_phone']){
					////订单提交成功发送提示信息
					parent::submit_boss_order_message($order_sn,$order_data['phone'],$order_data['boss_uid']);

					parent::submit_worker_order_message($order_sn,$order_data['worker_phone'],$order_data['worker_uid']);
				}else{
					////订单提交成功发送提示信息
					parent::submit_boss_order_message($order_sn,$order_data['phone']);

					parent::submit_boss_order_message($order_sn,$order_data['boss_phone'],$order_data['boss_uid']);

					parent::submit_worker_order_message($order_sn,$order_data['worker_phone'],$order_data['worker_uid']);
				}

			}
			if ($order_data['status'] == 1){
				$data=[
					'status'=>2,
					'pay_status'=>2,
					'notice'=>1,
					'pay_amount'=>$price
				];
				$this->load->model("Order_pay_model");
				$this->Order_pay_model->update_order_pay($order_sn,$data);
			}


		}


		$xmlData='<?xml version="1.0" encoding="utf-8"?>
<xml>
  <return_code><![CDATA[SUCCESS]]></return_code>
  <return_msg><![CDATA[OK]]></return_msg>
</xml>
';

		exit($xmlData);
	}
}
 ?>