<?php

/**
 * Created by PhpStorm.
 * User: hshev99
 * Date: 16/6/12
 * Time: 上午10:52
 */
class User_tag_hotel_model extends CI_Model
{


    public function __construct()
    {
        parent::__construct();
    }


    //更新用户信息
    public function update_user_tag_hotel($uid,$data=[]){
        $this->user=$this->load->database('user',true);

        $sql="delete from user_tag_hotel where uid=$uid";
        $this->user->query($sql);

        if (!empty($data['hotel'])){
            foreach ($data['hotel'] as $val){
                if ($val){
                    $da=[
                        'hotel_id'=>is_array($val)?$val['id']:$val,
                        'uid'=>$uid
                    ];
                    $this->user->insert('user_tag_hotel',$da);

                }
            }
        }

    }

    public function get_user_tag_hotel($uid){
        $this->user=$this->load->database('user',true);

        $sql="select * from user_tag_hotel where uid=$uid";
        $query=$this->user->query($sql);
        $data=[];
        if (!empty($query->result())){
            foreach ($query->result() as $row){
                $data[]['hotel_id']=$row->hotel_id;
            }
        }
        return $data;

    }

    public function get_user_tag_hotel_selected(){
        $this->load->model('User_hotel_model');
        $all_hotel=$this->User_hotel_model->get_user_hotel();

        $this->load->model('User_tag_hotel_model');
        $user_hotel=$this->User_tag_hotel_model->get_user_tag_hotel($this->uid);
        $user_hotel_id=[];
        if (!empty($user_hotel)){
            foreach ($user_hotel as $v){
                $user_hotel_id[]=$v['hotel_id'];
            }
        }
        $data=[];$i=0;
        foreach ($all_hotel as $val){

            if (empty($user_hotel)){
                $data[$i]=$val;
                $data[$i]['selected']="T";
            }else{
                if (!empty($user_hotel_id) and in_array($val['id'],$user_hotel_id)){
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