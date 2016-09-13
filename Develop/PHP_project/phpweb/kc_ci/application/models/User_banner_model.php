<?php

/**
 * Created by PhpStorm.
 * User: hshev99
 * Date: 16/6/12
 * Time: 上午10:52
 */
class User_banner_model extends CI_Model
{


    public function __construct()
    {
        parent::__construct();
    }


    public function get_user_banner($uid=''){
        $this->user=$this->load->database('user',true);

        $sql="select * from user_img WHERE uid={$uid} limit 5";
        $query=$this->user->query($sql);
        $data=[];
        if (!empty($query->result())){
            $i=0;
            foreach ($query->result() as $row){
                $data[$i]['img']=$row->img;
                $i++;
            }
        }
        return $data;

    }

    public function update_user_banner($uid='',$data=[]){
        if (empty($data['banner'])) return '';
        $this->user=$this->load->database('user',true);

        $sql="delete from user_img WHERE uid={$uid}";
        $this->user->query($sql);

        foreach ($data['banner'] as $val){
            if ($val['img']){
                $sql="insert into user_img SET uid={$uid},img='{$val['img']}'";
                $this->user->query($sql);
            }

        }
        return $data;

    }



}