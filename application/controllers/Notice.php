<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notice extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	public $uid;
	public $lc=0;
	

	public function __construct()
	{
		parent::__construct();

		$this->phone=$this->input->get('phone');
		$this->lc=$this->input->get('lc');
	}

	//歌手认证通过通知
	public function verify_singer_through_notic(){
		exit(json_encode(parent::output(parent::verify_singer_through($this->phone))));
	}

	//经纪人认证通过
	public function verify_agent_through_notic(){
		exit(json_encode(parent::output(parent::verify_agent_through($this->phone))));
	}

	//公司认证通过
	public function verify_enterprise_through_notic(){
		exit(json_encode(parent::output(parent::verify_enterprise_through($this->phone))));
	}

	//认证失败
	public function verify_failure_notic(){
		$this->reason=$this->input->get('reason');
		exit(json_encode(parent::output(parent::verify_failure($this->phone,$this->reason))));
	}
}
