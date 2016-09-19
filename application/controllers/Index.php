<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends CI_Controller {


	public function __construct()
	{
		parent::__construct();


	}

	public function index(){
//		$this->pr($this->user_login);
		$this->load->view("/Index/index.html");
	}

	

}
