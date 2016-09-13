<?php

/**
 * Created by PhpStorm.
 * User: hshev99
 * Date: 16/6/13
 * Time: 下午2:52
 */
class Index_model extends CI_Model
{

    public function banner(){

        $this->conf=$this->load->database('conf',true);

        $query=$this->conf->query("select *  from hl_conf.banner");
        $data=[];$i=0;
        foreach ($query->result() as $row){
            $data[$i]['img']=$row->img;
            $data[$i]['img_pc']=$row->img_pc;
            $i++;
        }
        return $data;
    }
}