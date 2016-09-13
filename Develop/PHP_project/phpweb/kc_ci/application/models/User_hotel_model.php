<?php

/**
 * Created by PhpStorm.
 * User: hshev99
 * Date: 16/6/12
 * Time: 上午10:52
 */
class User_hotel_model extends CI_Model
{


    public function __construct()
    {
        parent::__construct();
    }


    public function get_user_hotel(){
        $this->user=$this->load->database('conf',true);

        $sql="select * from user_hotel";
        $query=$this->user->query($sql);
        $data=[];
        if (!empty($query->result())){
            $i=0;
            foreach ($query->result() as $row){
                $data[$i]['id']=$row->id;
                $data[$i]['name']=$row->name;
                $i++;
            }
        }
        return $data;

    }



}