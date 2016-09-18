<?php
header("Content-type: text/html; charset=utf-8"); 
//载入ecd类
require_once('lib/Ecd.class.php');

//接口生产地址(应用上线后正式环境必须使用该地址)
const url = "http://www.etuocloud.com/gateway.action";
//接口测试地址（未上线前测试环境使用）
//const url = "http://www.etuocloud.com/gatetest.action";
const app_key = 'obRCJdwAdi60wPep2MWSfDCethz0kOKg';
const app_secret = 'MepzYlQsD3UfU9cNbNxljE0xtvaQPdQ0UnhPW8zvS3zH2k9HIWWH7g6DAt4AQruA';
const format = 'json';

//初始化
$ecd = new Ecd(url,app_key,app_secret,format);

//发送验证码短信
//echo $ecd->send_sms_code('接收验证码的手机号','验证码短信模板ID','验证码','商户订单号，可空');

//发送模板短信
//echo $ecd->send_sms_tpl('接收模板短信的手机号','模板短信模板ID','模板中的参数，以英文逗号分隔','商户订单号，可空');

//发送自定义短信
//echo $ecd->send_sms_custom('接收自定义短信的手机号','自定义短信内容','商户订单号，可空');

//发送语音验证码
//echo $ecd->send_voice_code('接收验证码语音的手机号','语音验证码模板ID','验证码','商户订单号，可空');

//发送语音通知
//echo $ecd->send_voice_notice('接收语音通知的手机号','语音通知模板ID','商户订单号，可空');

//获取流量产品列表
//echo $ecd->get_flow_product_list();

//流量充值
//echo $ecd->recharge_flow('被充值流量的手机号','流量产品编码','商户订单号，可空');




