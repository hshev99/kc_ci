<?php

/**
 * 认证资料
 * Created by PhpStorm.
 * User: hshev99
 * Date: 16/6/14
 * Time: 下午3:59
 */
class Verify extends CI_Controller
{

    public $uid;
    public $way;
    public $name;
    public $company_name;
    public $law_name;
    public $phone;
    public $verify_type;
    public $email;
    public $img_positive;
    public $img_reverse;
    public $img_hand;


    public function verify_save(){
        $this->load->model('Verify_model');


        $arr=[
            'uid'=>$this->uid=$this->input->post('uid'),
            'way'=>$this->way=$this->input->post('way'),
            'name'=>$this->name=$this->input->post('name'),
            'nick'=>$this->nick=$this->input->post('nick'),
            'gender'=>$this->gender=$this->input->post('gender'),
            'company_name'=>$this->company_name=$this->input->post('company_name'),
            'law_name'=>$this->law_name=$this->input->post('law_name'),
            'blr_number'=>$this->blr_number=$this->input->post('blr_number'),
            'law_number'=>$this->law_number=$this->input->post('law_number'),
            'phone'=>$this->phone=$this->input->post('phone'),
            'verify_type'=>$this->verify_type=$this->input->post('verify_type'),
            'email'=>$this->email=$this->input->post('email'),
            'img_positive'=>$this->img_positive=$this->input->post('img_positive'),
            'img_reverse'=>$this->img_reverse=$this->input->post('img_reverse'),
            'img_hand'=>$this->img_hand=$this->input->post('img_hand'),
            'industry'=>$this->industry=$this->input->post('industry'),
            'price'=>$this->price=$this->input->post('price'),
        ];
        $way_name=[
            1=>'歌手',
            2=>'经纪人',
            3=>'经纪公司',
            4=>'企业'
        ];
        $data=[
            'msg'=>'已提交认证信息,请等待审核',
            'way'=>$arr['way'],
            'way_name'=>$way_name[$arr['way']]
        ];

        if($this->Verify_model->verify_save($arr)){
            $phone='15901016380';
            parent::add_user_verify($phone);
            $phone='18693256547';
            parent::add_user_verify($phone);
            $phone='18232576360';
            parent::add_user_verify($phone);
            $phone='13681241738';
            parent::add_user_verify($phone);
            $phone='13718077670';
            parent::add_user_verify($phone);
            exit(json_encode(parent::output($data)));
        }

    }

    public function info(){
        $this->uid=$this->input->get('uid');
        $this->load->model('Verify_model');
        $arr=$this->Verify_model->info($this->uid);

        exit(json_encode(parent::output($arr)));

    }

    //网页认证
    public function verify_web(){
        $data=[];
        $data['css']=$this->base_url;
        $this->load->view('/User/user_verfy',$data);
    }

}