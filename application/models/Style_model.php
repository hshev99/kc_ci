<?php

/**
 * Created by PhpStorm.
 * User: hshev99
 * Date: 16/6/12
 * Time: 上午10:52
 */
class Style_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function get_style()
    {
            $this->conf=$this->load->database('conf',true);


            $sql="select * from hl_conf.user_style";


            $query = $this->conf->query($sql);

            $data=[];
            foreach ($query->result() as $key =>$row)
            {
                $data[(int)$row->id]['id']=$row->id;
                $data[(int)$row->id]['name']=$row->name;

            }

        return $data;
    }

    public function get_style_arr(){
        $this->conf=$this->load->database('conf',true);


        $sql="select * from hl_conf.user_style ORDER BY id ASC ";


        $query = $this->conf->query($sql);

        $data=[];$i=0;
        foreach ($query->result() as $key =>$row)
        {
            $data[$i]['id']=$row->id;
            $data[$i]['name']=$row->name;
            $i++;
        }

        return $data;
    }

    public function save_style($uid=0,$data=''){
        $this->load->database('user');

        $data=[
            'style'=>$data,
        ];
        $where="uid =$uid";
        $this->db->update("hl_user.user_info", $data, $where);
    }


}