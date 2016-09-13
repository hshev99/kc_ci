<?php

/**
 * Created by PhpStorm.
 * User: hshev99
 * Date: 16/6/12
 * Time: 上午10:52
 */
class User_works_baike_model extends CI_Model
{


    public function __construct()
    {
        parent::__construct();
    }


    //更新用户信息
    public function update_user_works_baike($uid,$data=[]){
        $this->user=$this->load->database('user',true);

        $sql="select * from user_works_baike WHERE uid=$uid";
        $query=$this->user->query($sql);

        if (empty($query->result())){
            $sql="insert into user_works_baike SET uid={$uid},url='',introduction='{$data['introduction']}'";
            $this->user->query($sql);
        }else{
            $bool=$this->user->update('user_works_baike', $data, array('uid'=>$uid));
        }


    }

    public function get_user_works_baike($uid){
        $this->user=$this->load->database('user',true);
        $sql="select * from user_works_baike WHERE uid={$uid}";
        $query=$this->user->query($sql);
        $data='';
        if (!empty($query->result())){
            foreach ($query->result() as $row){
                $data=$row->introduction;
            }
        }
        return $data;
    }

}