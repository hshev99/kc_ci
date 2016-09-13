<?php

/**
 * Created by PhpStorm.
 * User: hshev99
 * Date: 16/6/13
 * Time: 下午2:45
 */
class Index extends CI_Controller
{

    public $page;public $where;
    public function __construct()
    {
        parent::__construct();

        $this->uid=$this->input->get('uid');
        $this->lc=$this->input->get('lc');
        $this->page=$this->input->get('page');

        if (!$this->page) $this->page=1;
        //添加搜索条件
        $this->where=[];
        if (isset($_GET['style'])){
            $this->where['style']=$this->input->get('style');
        }

        if (isset($_GET['gender'])){
            $this->where['gender']=$this->input->get('gender');
        }

        if (isset($_GET['price']) && $_GET['price']> 0){
            $this->where['price']=$this->input->get('price');
        }

    }

    public function index(){
        $arr=[];

        if ($this->page < 2){
            $this->load->model('Style_model');
            $arr['style']=$this->Style_model->get_style_arr();

            $this->load->model('Index_model');
            $arr['banner']=$this->Index_model->banner();
        }

        $this->load->model('User_info_model');
        $arr['infos']=$this->User_info_model->get_user_info('',$this->page,'12',$this->where);
        $arr['total']=$this->User_info_model->get_user_info_total('',$this->page,'12',$this->where);
        exit(json_encode(parent::output($arr),true));
    }

    public function indexs(){
        $this->load->model('User_info_model');
        $arr=$this->User_info_model->get_user_info(null,$this->page,'12',$this->where);

        exit(json_encode(parent::output($arr),true));
    }
}