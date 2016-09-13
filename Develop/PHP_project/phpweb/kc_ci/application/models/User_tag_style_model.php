<?php

/**
 * Created by PhpStorm.
 * User: hshev99
 * Date: 16/6/12
 * Time: 上午10:52
 */
class User_tag_style_model extends CI_Model
{


    public function __construct()
    {
        parent::__construct();
    }


    //更新用户信息
    public function update_user_tag_style($uid,$data=[]){
        $this->user=$this->load->database('user',true);

        $sql="delete from user_tag_style where uid=$uid";
        $this->user->query($sql);

        if (!empty($data['style'])){
            foreach ($data['style'] as $val){
                if ($val){
                    $da=[
                        'style_id'=>$val,
                        'uid'=>$uid
                    ];
                    $this->user->insert('user_tag_style',$da);

                }
            }
        }

    }


    //更新用户信息
    public function get_user_tag_style($uid){
        $this->user=$this->load->database('user',true);

        $sql="select * from user_tag_style where uid=$uid";
        $query=$this->user->query($sql);
        $data=[];
        if (!empty($query->result())){
            foreach ($query->result() as $row){
                $data[]['style_id']=$row->style_id;
            }
        }
        return $data;
    }

    public function get_user_tag_style_selected(){
        $this->load->model('User_style_model');
        $all_style=$this->User_style_model->get_user_style();

        $this->load->model('User_tag_style_model');
        $user_style=$this->User_tag_style_model->get_user_tag_style($this->uid);
        $user_style_id=[];
        if (!empty($user_style)){
            foreach ($user_style as $v){
                $user_style_id[]=$v['style_id'];
            }
        }
        $data=[];$i=0;
        foreach ($all_style as $val){

            if (empty($user_style)){
                $data[$i]=$val;
                $data[$i]['selected']="T";
            }else{
                if (!empty($user_style_id) and in_array($val['id'],$user_style_id)){
                    $data[$i]=$val;
                    $data[$i]['selected']="T";
                }else{
                    $data[$i]=$val;
                    $data[$i]['selected']="F";
                }
            }

            $i++;
        }
        return $data;
    }
}