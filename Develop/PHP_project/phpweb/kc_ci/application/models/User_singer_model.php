<?php

/**
 * Created by PhpStorm.
 * User: hshev99
 * Date: 16/6/12
 * Time: 上午10:52
 */
class User_singer_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }



    public function index($uid=''){
        if (!$uid) return '';


        $this->user=$this->load->database('user',true);

        $status_name=[
            0=>'未完成',
            1=>'审核中',
            2=>'审核通过'
        ];
        //用户音乐
        $query = $this->user->query("select * from user_singer where uid=$uid");
        $data=[];
        $i=0;
        foreach ($query->result() as $row){

            $sql="select * from user_info WHERE uid={$row->singer_uid}";
            $user_info=$this->user->query($sql);
            if (!empty($user_info))foreach ($user_info->result() as $val){
                $data[$i]['name']=$val->name;
                $data[$i]['nick']=$val->nick;
                $data[$i]['price']=$val->price;
                $data[$i]['history_price']=$val->history_price;
                $data[$i]['img']=is_null($val->img) ? '' :$val->img;
                $data[$i]['status']=$val->its;
                $data[$i]['status_name']=$status_name[$val->its];
            }

            $data[$i]['uid']=$row->singer_uid;
            $i++;
        }
        // var_dump($data);die;
        return $data;
    }
    //
    public function upload_its($date){
        $where = "uid = ".$date['uid'];
        $data=[
            'its'=>$date['its']
        ];
        $this->user=$this->load->database('user',true);

        $this->user->update('user_info', $data, $where);
    }
    //插入用户信息 添加歌手
    public function add_user_singer($data){
        if (!empty($data)){
            $this->user=$this->load->database('user',true);
            $this->user->insert('user_singer',$data);
        }

        return '';
    }

    //删除歌手
    public function del_user_singer($data){
        $res ='已删除';
        if (!empty($data)){
            $this->user=$this->load->database('user',true);

            $result=$this->user->delete('user_singer', $data);

            if ($result){
                $res='删除成功';
            }
        }

        return $res;
    }

    //获取歌手信息
    public function singer_info($uid=''){
        if (!$uid) return '';
        $this->user=$this->load->database('user',true);

        $query = $this->user->query("select uid,gender, price,history_price,`name`, home,special,img,verify, phone,its,email from user_info  where uid={$uid}");

        $data=[];
        $gender_name=[
            0=>'女歌手',
            1=>'男歌手',
            2=>'组合',
            3=>''
        ];
        foreach ($query->result() as $row){
            $data['uid']=$row->uid;
            $data['name']=$row->name;
            $data['gender']=$row->gender;
            $data['gender_name']=empty($gender_name[$row->gender]) ? '':$gender_name[$row->gender];
            $data['img']=$row->img;
            $data['verify']=$row->verify;
            $data['home']=$row->home;
            $data['special']=$row->special;
            $data['phone']=is_null($row->phone) ? '' : $row->phone;
            $data['email']=is_null($row->email) ? '' : $row->email;
            $data['price']=$row->price;
            $data['history_price']=$row->history_price;
            $data['its']=$row->its;

        }
        // var_dump($data);die;
        return $data;
    }
}