<?php

/**
 * Created by PhpStorm.
 * User: hshev99
 * Date: 16/6/12
 * Time: 上午10:52
 */
class User_tag_meal_model extends CI_Model
{


    public function __construct()
    {
        parent::__construct();
    }


    //更新用户信息
    public function update_user_tag_meal($uid,$data=[]){
        $this->user=$this->load->database('user',true);

        $sql="delete from user_tag_meal where uid=$uid";
        $this->user->query($sql);

        if (!empty($data['meal'])){
            foreach ($data['meal'] as $val){
                if ($val){
                    $da=[
                        'meal_id'=>is_array($val)?$val['id']:$val,
                        'uid'=>$uid
                    ];
                    $this->user->insert('user_tag_meal',$da);

                }
            }
        }

    }

    public function get_user_tag_meal($uid,$data=[]){
        $this->user=$this->load->database('user',true);

        $sql="select * from user_tag_meal where uid=$uid";
        $query=$this->user->query($sql);
        $data=[];
        if (!empty($query->result())){
            foreach ($query->result() as $row){
                $data[]['meal_id']=$row->meal_id;
            }
        }
        return $data;
    }

    public function get_user_tag_meal_selected(){
        $this->load->model('User_meal_model');
        $all_meal=$this->User_meal_model->get_user_meal();

        $this->load->model('User_tag_meal_model');
        $user_meal=$this->User_tag_meal_model->get_user_tag_meal($this->uid);
        $user_meal_id=[];
        if (!empty($user_meal)){
            foreach ($user_meal as $v){
                $user_meal_id[]=$v['meal_id'];
            }
        }
        $data=[];$i=0;
        foreach ($all_meal as $val){

            if (empty($user_meal)){
                $data[$i]=$val;
                $data[$i]['selected']="T";
            }else{
                if (!empty($user_meal_id) and in_array($val['id'],$user_meal_id)){
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