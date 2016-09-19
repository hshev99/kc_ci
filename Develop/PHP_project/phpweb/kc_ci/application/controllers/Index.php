<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends CI_Controller {


	public $uid;
	public $lc=0;
	

	public function __construct()
	{
		parent::__construct();

		$this->uid=$this->input->get('uid');
		$this->lc=$this->input->get('lc');
	}

	public function index(){
		$this->load->view("/Index/index.html");
	}



}
