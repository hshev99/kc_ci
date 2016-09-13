<?php

/**
 * Created by PhpStorm.
 * User: hshev99
 * Date: 16/6/14
 * Time: 下午4:17
 */
class Verify_model extends CI_Model
{
    public function iosverify_save($data=[]){
        if($data['way']==4 || $data['way']==3){
            $name=$data['company_name'];
        }else if($data['way']==2 || $data['way']==1){
            $name=$data['name'];
        }
        $this->load->database('user');

        $where = "uid = ".$data['uid'];
        $arr=[
            'verify'=>2,
            'name'=>$name
        ];
        $this->db->update("user_info", $arr, $where);

        $query = $this->db->insert('user_verify',$data);

        return $query;
    }
    
    public function verify_save($data=[]){
        $this->load->database('user');

        $where = "uid = ".$data['uid'];
        $arr=[
            'verify'=>2,
        ];
        $this->db->update("user_info", $arr, $where);

        $query = $this->db->insert('user_verify',$data);

        return $query;
    }

    public function pcverify_save($data=[],$price){
        $this->load->database('user');

        $where = "uid = ".$data['uid'];
        $arr=[
            'verify'=>2,
            'price'=>$data['price'],
        ];
        $this->db->update("user_info", $arr, $where);

        $query = $this->db->insert('user_verify',$data);

        return $query;
    }


    public function info($uid=null){

        $this->load->database('user');
        $query = $this->db->query("select * from user_verify where uid=$uid ORDER BY id DESC ");
//        if (empty($_SESSION['user_img'][$uid])){
        $data=[];
        foreach ($query->result() as $row)
        {
            $data=[
                'uid'=>$row->uid,
                'way'=>$row->way,
                'status'=>$row->status,
                'name'=>is_null($row->name) ? '' :$row->name,
                'gender'=>$row->gender,
                'nick'=>is_null($row->nick) ? '' :$row->nick,
                'industry'=>is_null($row->industry) ? '' :$row->industry,
                'company_name'=>is_null($row->company_name) ? '' :$row->company_name,
                'law_name'=>is_null($row->law_name) ? '' : $row->law_name,
                'blr_number'=>is_null($row->blr_number) ? '' :$row->blr_number,
                'law_number'=>is_null($row->law_number) ? '' :$row->law_number,
                'phone'=>is_null($row->phone) ? '' :$row->phone,
                'verify_type'=>is_null($row->verify_type) ? '' :$row->verify_type,
                'email'=>is_null($row->email) ? '' :$row->email,
                'img_positive'=>is_null($row->img_positive) ? '' :$row->img_positive,
                'img_reverse'=>is_null($row->img_reverse) ? '':$row->img_reverse,
                'img_hand'=>is_null($row->img_hand) ? '':$row->img_hand,
            ];
        }
        $_SESSION['user_verify'][$uid]=$data;
//        }
        $data=$_SESSION['user_verify'][$uid];

        return $data;
    }

}