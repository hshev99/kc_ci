<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
	public $base_url;
	public function index()
	{
		if ($this->is_mobile){
			header("Location:../Web/index");
			exit;
		}else{
			header("Location:../pc/index");
			exit;
		}
		$this->load->view('welcome_message');
	}

	public function tags(){
		$this->base_url = $this->config->item('base_url');
		$this->load->view('tags',['css'=>$this->base_url]);
	}
}
