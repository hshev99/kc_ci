<?php 
class WeChat_model extends CI_Model
{
	public function __construct()
    {
        parent::__construct();
    }

    public function prepay($order_sn='',$total_fee){
        // var_dump($total_fee);die;
        $appid='wxab054e7123df6377';
        $attach='火了科技';
        $body='预约艺人';
        $device_info='WEB';
        $mch_id='1364523002';
        $nonce_str=md5(rand(0,999999));
        $notify_url='http://www.51huole.cn/WeChat/notify';
        $out_trade_no=$order_sn;
        $spbill_create_ip=$_SERVER["REMOTE_ADDR"];
        $total_fee=$total_fee*100;
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
        $url ="https://api.mch.weixin.qq.com/pay/unifiedorder";

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

        $arr['timeStamp']=time();
        return $arr;
    }
}
 ?>