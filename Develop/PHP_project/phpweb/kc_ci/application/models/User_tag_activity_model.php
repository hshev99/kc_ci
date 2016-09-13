<?php

/**
 * Created by PhpStorm.
 * User: hshev99
 * Date: 16/6/12
 * Time: 上午10:52
 */
class User_tag_activity_model extends CI_Model
{


    public function __construct()
    {
        parent::__construct();
    }


    //更新用户信息
    public function update_user_tag_activity($uid,$data=[]){
        $this->user=$this->load->database('user',true);

        $sql="delete from user_tag_activity where uid=$uid";
        $this->user->query($sql);
        if (!empty($data['activity'])){
            foreach ($data['activity'] as $val){
                if ($val){
                    $da=[
                        'activity_id'=>is_array($val)?$val['id']:$val,
                        'uid'=>$uid
                    ];
                    $this->user->insert('user_tag_activity',$da);

                }
            }
        }

    }

    public function get_user_tag_activity($uid){
        $this->user=$this->load->database('user',true);

        $sql="select * from user_tag_activity where uid=$uid";
        $query=$this->user->query($sql);
        $data=[];
        if (!empty($query->result())){
            foreach ($query->result() as $row){
                $data[]['activity_id']=$row->activity_id;
            }
        }
        return $data;

    }

    public function get_user_tag_activity_selected($uid=''){
        $this->load->model('User_activity_model');
        $all_activity=$this->User_activity_model->get_user_activity();

        $this->load->model('User_tag_activity_model');
        $user_activity=$this->User_tag_activity_model->get_user_tag_activity($uid);
        $user_activity_id=[];
        if (!empty($user_activity)){
            foreach ($user_activity as $v){
                $user_activity_id[]=$v['activity_id'];
            }
        }
        $data=[];$i=0;
        foreach ($all_activity as $val){

            if (empty($user_activity)){
                $data[$i]=$val;
                $data[$i]['selected']="T";
            }else{
                if (!empty($user_activity_id) and in_array($val['id'],$user_activity_id)){
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