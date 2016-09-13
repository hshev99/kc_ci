<?php

/**
 * Created by PhpStorm.
 * User: hshev99
 * Date: 16/6/12
 * Time: 上午10:52
 */
class User_tag_traffic_model extends CI_Model
{


    public function __construct()
    {
        parent::__construct();
    }


    //更新用户信息
    public function update_user_tag_traffic($uid,$data=[]){
        $this->user=$this->load->database('user',true);

        $sql="delete from user_tag_traffic where uid=$uid";
        $this->user->query($sql);

        if (!empty($data['traffic'])){
            foreach ($data['traffic'] as $val){
                if ($val){
                    $da=[
                        'traffic_id'=>is_array($val)?$val['id']:$val,
                        'uid'=>$uid
                    ];
                    $this->user->insert('user_tag_traffic',$da);

                }
            }
        }

    }

    public function get_user_tag_traffic($uid,$data=[]){
        $this->user=$this->load->database('user',true);

        $sql="select * from user_tag_traffic where uid=$uid";
        $query=$this->user->query($sql);
        $data=[];
        if (!empty($query->result())){
            foreach ($query->result() as $row){
                $data[]['traffic_id']=$row->traffic_id;
            }
        }
        return $data;

    }

    public function get_user_tag_traffic_selected(){
        $this->load->model('User_traffic_model');
        $all_traffic=$this->User_traffic_model->get_user_traffic();

        $this->load->model('User_tag_traffic_model');
        $user_traffic=$this->User_tag_traffic_model->get_user_tag_traffic($this->uid);
        $user_traffic_id=[];
        if (!empty($user_traffic)){
            foreach ($user_traffic as $v){
                $user_traffic_id[]=$v['traffic_id'];
            }
        }
        $data=[];$i=0;
        foreach ($all_traffic as $val){

            if (empty($user_traffic)){
                $data[$i]=$val;
                $data[$i]['selected']="T";
            }else{
                if (!empty($user_traffic_id) and in_array($val['id'],$user_traffic_id)){
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