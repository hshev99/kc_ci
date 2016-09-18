<?php

class Ecd
{
	private $url;	//接口地址
    private $app_key;	//应用 app_key
    private $app_secret;	//应用 app_secret
    private $format;	//接口响应格式 json或xml

    /**
     *
	 * @param $url 接口地址
	 * @param $app_key 应用 app_key
	 * @param $app_secret 应用 app_secret
	 * @param $format 接口响应格式 json或xml
     */
    public function  __construct($url,$app_key,$app_secret,$format)
    {
		if(empty($url) || empty($app_key) || empty($app_secret)){
			 throw new Exception("非法参数");
		}
		$this->url = $url;
		$this->app_key = $app_key;
		$this->app_secret = $app_secret;
		$this->format = empty($format) ? 'xml' : $format;
	}
	
	/**
	 * 发送验证码短信
	 *
	 * @param $moblie 接收验证码的手机号
	 * @param $template 验证码短信模板ID
	 * @param $code 验证码
	 * @param $out_trade_no 商户订单号，可空
	 */
	public function send_sms_code($moblie,$template,$code,$out_trade_no){
		$post_data = array(
			'app_key'=>$this->app_key,
			'view'=>$this->format,
			'method'=>'cn.etuo.cloud.api.sms.simple',
			'out_trade_no'=>$out_trade_no,
			'to'=>$moblie,
			'template'=>$template,
			'smscode'=>$code
		);
		return $this->connection($this->url,$post_data);
	}
	
	/**
	 * 发送模板短信
	 *
	 * @param $moblie 接收模板短信的手机号
	 * @param $template 模板短信模板ID
	 * @param $params 模板中的参数，以英文逗号分隔
	 * @param $out_trade_no 商户订单号，可空
	 */
	public function send_sms_tpl($moblie,$template,$params,$out_trade_no){
		$post_data = array(
			'app_key'=>$this->app_key,
			'view'=>$this->format,
			'method'=>'cn.etuo.cloud.api.sms.template',
			'out_trade_no'=>$out_trade_no,
			'to'=>$moblie,
			'template'=>$template,
			'params'=>$params
		);
		return $this->connection($this->url,$post_data);
	}
	
	/**
	 * 发送自定义短信
	 *
	 * @param $moblie 接收自定义短信的手机号
	 * @param $content 自定义短信内容
	 * @param $out_trade_no 商户订单号，可空
	 */
	public function send_sms_custom($moblie,$content,$out_trade_no){
		$post_data = array(
			'app_key'=>$this->app_key,
			'view'=>$this->format,
			'method'=>'cn.etuo.cloud.api.sms.advance',
			'out_trade_no'=>$out_trade_no,
			'to'=>$moblie,
			'content'=>$content
		);
		return $this->connection($this->url,$post_data);
	}
	
	/**
	 * 发送验证码语音
	 *
	 * @param $moblie 接收验证码语音的手机号
	 * @param $template 语音验证码模板ID
	 * @param $code 验证码
	 * @param $out_trade_no 商户订单号，可空
	 */
	public function send_voice_code($moblie,$template,$code,$out_trade_no){
		$post_data = array(
			'app_key'=>$this->app_key,
			'view'=>$this->format,
			'method'=>'cn.etuo.cloud.api.voice.simple',
			'out_trade_no'=>$out_trade_no,
			'to'=>$moblie,
			'template'=>$template,
			'verifyCode'=>$code
		);
		return $this->connection($this->url,$post_data);
	}
	
	/**
	 * 发送语音通知
	 *
	 * @param $moblie 接收语音通知的手机号
	 * @param $template 语音通知模板ID
	 * @param $out_trade_no 商户订单号，可空
	 */
	public function send_voice_notice($moblie,$template,$out_trade_no){
		$post_data = array(
			'app_key'=>$this->app_key,
			'view'=>$this->format,
			'method'=>'cn.etuo.cloud.api.voice.message',
			'out_trade_no'=>$out_trade_no,
			'to'=>$moblie,
			'template'=>$template
		);
		return $this->connection($this->url,$post_data);
	}
	
	/**
	 * 获取流量产品列表
	 */
	public function get_flow_product_list(){
		$post_data = array(
			'app_key'=>$this->app_key,
			'view'=>$this->format,
			'method'=>'cn.etuo.cloud.api.flow.list'
		);
		return $this->connection($this->url,$post_data);
	}
	
	/**
	 * 流量充值
	 *
	 * @param $moblie 被充值流量的手机号
	 * @param $flow_code 流量产品编码
	 * @param $out_trade_no 商户订单号，可空
	 */
	public function recharge_flow($moblie,$flow_code,$out_trade_no){
		$post_data = array(
			'app_key'=>$this->app_key,
			'view'=>$this->format,
			'method'=>'cn.etuo.cloud.api.flow.charge',
			'out_trade_no'=>$out_trade_no,
			'mobile'=>$moblie,
			'flowcode'=>$flow_code
		);
		return $this->connection($this->url,$post_data);
	}
	
    /**
     * @param $url
     * @param $body  post数据
     * @param $method post或get
     * @return mixed|string
     */
    private function connection($url, $post_data){
		$sign = $this->genSign($post_data);
		$post_data['sign'] = $sign;
        $result = $this->send_http($url, $post_data, 'post');
		return $result;
    }
	
	 private function send_http($url, $body, $method){
		 if ($this->format == 'json') {
            $mine = 'application/json';
        } else {
            $mine = 'application/xml';
        }
        if (function_exists("curl_init")) {
             $header = array(
                //'Accept:' . $mine,
                //'Content-Type:' . $mine . ';charset=utf-8',
            );
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
			//curl_setopt($ch, CURLOPT_HTTPHEADER, 1);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			
            if($method == 'post'){
                curl_setopt($ch,CURLOPT_POST,1);
                curl_setopt($ch,CURLOPT_POSTFIELDS,$body);
            }
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
			
            $result = curl_exec($ch);
            curl_close($ch);
        } else {
            $opts = array();
            $opts['http'] = array();
            $headers = array(
                "method" => strtoupper($method),
            );
            
            if(!empty($body)) {
                $headers['header'][]= 'Content-Length:'.strlen($body);
                $headers['content']= $body;
            }

            $opts['http'] = $headers;
            $result = file_get_contents($url, false, stream_context_create($opts));
        }
        return $result;
    }
	
	//生成签名
	private function genSign($post_data){
		//根据键对关联数组进行升序排序
		ksort($post_data);
		$res = "";
		foreach ($post_data as $k=>$v) { 
			if(empty($v)){
				continue;
			}
			$res .= $k."=".$v."&";
		}
		$new_res = substr($res,0,strlen($res)-1);
		$new_res.= $this->app_secret;
		$md5_res = md5($new_res);
		return $md5_res;
	}
} 