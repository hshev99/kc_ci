<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tt extends CI_Controller {


	public $uid;
	public $lc=0;
	

	public function __construct()
	{
		parent::__construct();

		$this->uid=$this->input->get('uid');
		$this->lc=$this->input->get('lc');
	}

	public function index(){
		$str='
		{
			2015:[
{"date":"8月1日","name":"团队建立"},
{"date":"8月5日","name":"项目规划"}
],
2016:[
{"date":"8月1日","name":"网站上线"},
{"date":"8月8日","name":"APP上线"}
]
}';
		$a=[];
		$a['data']=[
			2015=>[
				0=>[
					"date"=>"8月1日",
					"name"=>"团队建立"
					],
				1=>[
					"date"=>"8月5日",
					"name"=>"项目规划"
				]
			],
			2016=>[
				0=>[
					"date"=>"9月1日",
					"name"=>"网站上线"
				],
				1=>[
					"date"=>"9月9日",
					"name"=>"APP上线"
				]
			]
		];
		exit(urldecode(json_encode($a,JSON_UNESCAPED_UNICODE)));
	}

	public function ste_message(){
//		parent::submit_boss_order_message('1163','付款成功',["name"=>"哈哈"]);
		parent::submit_boss_order_message('147350608469320839','18518448952','1163');
	}

}
