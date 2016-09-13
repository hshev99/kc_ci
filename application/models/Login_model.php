<?php

/**
 * Created by PhpStorm.
 * User: hshev99
 * Date: 16/6/13
 * Time: 下午4:22
 */
class Login_model extends CI_Model
{
    public function save($data,$data_type){
        $type=[
                1=>'游客',
                2=>'注册未认证',
                3=>'注册已认证',
                4=>'企业认证',
                5=>'经纪人',
                6=>'经纪公司',
                7=>'歌手',
                8=>'线下歌手',
            ];
            $value=[];
        $this->user=$this->load->database('user',TRUE);
        $query=$this->user->query("SELECT id FROM user_login WHERE phone={$data['phone']}");
        if (!empty($query->result())){
            return '';
        }else{
            $result_user_login=$this->user->insert('user_login',$data);
            if ($result_user_login){
                $query=$this->user->query("SELECT id FROM user_login WHERE phone={$data['phone']}");
                foreach ($query->result() as $row){
                $id=get_object_vars($row);
                }
                $date=[
                    'uid'=>$id['id'],
                    'phone'=>$data['phone'],
                    'type'=>$data_type['type']
                ];

                $result_user_info=$this->user->insert('user_info',$date);
                if($result_user_info){
                    $query_info=$this->user->query("SELECT type,verify FROM user_info WHERE uid={$date['uid']}");
                    foreach ($query_info->result() as $val){
                        $value['verify']=$val->verify;
                        $value['type']=$val->type;
                        $value['type_name']=$type[$val->type];
                    }
                    // var_dump($value);die;
                    $arr=[
                        'uid'=>$date['uid'],
                        'phone'=>$data['phone'],
                        'type'=>$value['type'],
                        'type_name'=>$value['type_name'],
                        'verify'=>$value['verify']
                    ];
                    return $arr;
                }else{
                    return "注册失败";die;
                }
            }   
        }
    }

    public function third_lib_model($data){
        $type=[
                1=>'游客',
                2=>'注册未认证',
                3=>'注册已认证',
                4=>'企业认证',
                5=>'经纪人',
                6=>'经纪公司',
                7=>'歌手',
                8=>'线下歌手',
            ];
        $other_id=$data['other_id'];
        if(empty($other_id)){
            $arr=[
                    'error'=>202,
                    'msg'=>"网络故障"
                ];
                return $arr;
            }else{

        $login_data=[
            'is_other'=>$data['is_other'],
            'other'=>$data['other'],
            'other_id'=>$data['other_id'],
            'create_time'=>date("Y-m-d H:i:s")
        ];
        $this->user=$this->load->database('user',TRUE);
        $query=$this->user->query("SELECT id FROM user_login WHERE other_id='$other_id'");

        if(empty($query->result())){
            // echo 1;die;
            $add_sql = $this->user->insert('user_login',$login_data);
            if($add_sql){
                // echo 'insert';die;
                $info_query=$this->user->query("SELECT id FROM user_login WHERE other_id='$other_id'");
                foreach ($info_query->result() as $row){
                $id=get_object_vars($row);
                }
                $date=[
                    'uid'=>$id['id'],
                    'name'=>$data['name'],
                    'img'=>$data['img']
                ];

                $result_user_info=$this->user->insert('user_info',$date);

                $query_info=$this->user->query("SELECT type,verify FROM user_info WHERE uid={$date['uid']}");
                foreach ($query_info->result() as $val){
                    $value['type']=$val->type;
                    $value['type_name']=$type[$val->type];
                    $value['verify']=$val->verify;
                }
                $arr=[
                    'error'=>201,
                    'msg'=>"第三方登录成功",
                    'uid'=>$date['uid'],
                    'type'=>$value['type'],
                    'type_name'=>$value['type_name'],
                    'verify'=>$value['verify']
                ];
                return $arr;
            }else{
                // echo '网络故障';die;
                $arr=[
                    'error'=>202,
                    'msg'=>"网络故障"
                ];
                return $arr;
            }
        }else{
            // echo 2;die;
            $info_query=$this->user->query("SELECT id FROM user_login WHERE other_id='$other_id'");
                foreach ($info_query->result() as $row){
                    $id=get_object_vars($row);
                }
                $date=[
                    'uid'=>$id['id']
                ];

                $query_info=$this->user->query("SELECT type,verify FROM user_info WHERE uid={$date['uid']}");
                foreach ($query_info->result() as $val){
                    $value['type']=$val->type;
                    $value['type_name']=$type[$val->type];
                    $value['verify']=$val->verify;
                }
                $arr=[
                    'error'=>201,
                    'msg'=>"第三方登录成功",
                    'uid'=>$date['uid'],
                    'type'=>$value['type'],
                    'type_name'=>$value['type_name'],
                    'verify'=>$value['verify']
                ];
                return $arr;
        }
            }
    }

    public function save_code_msg($data){
        $this->load->database('conf');
        $query = $this->db->insert('code_error',$data);
    }

    public function login($data=[]){
        $phone=$data['phone'];
        $password=md5(md5($data['password'].'z'));
        $this->user = $this->load->database('user',TRUE);
        $sql="SELECT id FROM user_login WHERE phone='$phone' AND password='$password'";
        $query=$this->user->query($sql);
        if (!empty($query->result())){
            foreach ($query->result() as $arr){
                $uid=$arr->id;
            }
            $sq="SELECT * FROM user_info WHERE uid='$uid'";
            $info_query=$this->user->query($sq);
            $type=[
                1=>'游客',
                2=>'注册未认证',
                3=>'注册已认证',
                4=>'企业认证',
                5=>'经纪人',
                6=>'经纪公司',
                7=>'歌手',
                8=>'线下歌手',
            ];
            $data=[];$i=0;
            foreach ($info_query->result() as $row)
                {
                    $data[$i]['uid']=$row->uid;
                    $data[$i]['name']=$row->name;
                    $data[$i]['style']=empty($row->style)? [] : unserialize($row->style);
                    $data[$i]['price']=number_format($row->price/10000,1);

                    $data[$i]['company']=$row->company;
                    $data[$i]['type']=$row->type;
                    $data[$i]['type_name']=$type[$row->type];
                    $data[$i]['nick']=$row->nick;
                    $data[$i]['img']=$row->img;
                    $data[$i]['verify']=$row->verify;
                    $data[$i]['about_price']=is_null($row->about_price)? '' : $row->about_price;
                $i++;
            }
            return $data;die;
        }else{
            return false;die;
        }
    }

    public function back($data){
        $phone=$data['phone'];
        $password=$data['password'];
        $this->user = $this->load->database('user',TRUE);
        $phone_sql="SELECT * FROM user_login WHERE phone='$phone'";
        // var_dump($phone_sql);die;
        $query=$this->user->query($phone_sql);
        if(empty($query->result())){
            return '';
            //echo "该用户未注册";die;
        }else{
            $password_sql="UPDATE user_login SET `password` = '$password' WHERE phone = '$phone'";
            if($this->user->query($password_sql)){
                //     $arr=[
                //     'uid'=>(string)$this->db->insert_id(),
                //     'phone'=>$phone
                // ];
                    return $phone;
            }else{
                echo "网络故障,密码修改失败,请重新连接您的网络";die;
            }
        }
    }
    public function old_back($data){
        $uid=$data['uid'];
        $old_password=$data['old_password'];
        $new_password=$data['new_password'];
        $this->user = $this->load->database('user',TRUE);
        $phone_sql="SELECT password FROM user_login WHERE id='$uid'";
        $query=$this->user->query($phone_sql);
        foreach ($query->result() as $val) {
            $password=$val->password;
        }
        if($old_password!=$password){
            return '';
        }else{
            $password_sql="UPDATE user_login SET `password` = '$new_password' WHERE id = '$uid'";
            if($this->user->query($password_sql)){
                return $uid;
            }else{
                echo "网络故障,密码修改失败,请重新连接您的网络";die;
            }
        }
    }
    public function lasa($data){
        $uid=$data['uid'];
        $phone_email=$data['phone_email'];
        $content=$data['content'];
        $this->user = $this->load->database('user',TRUE);
        $sql="SELECT name FROM user_info WHERE uid='$uid'";
        $info_query=$this->user->query($sql);
        foreach ($info_query->result() as $val) {
            $name=$val->name;
        }
        $arr=array(
            'uid' => $uid,
            'name' => $name,
            'phone_email' => $phone_email,
            'content' => $content,
            );
        $this->conf = $this->load->database('conf',TRUE);
        $this->conf->insert('user_feedback',$arr);
        if($this->conf){
            return "感谢您的协助与支持并提供宝贵意见，我们将不断改善，为您提供优质的产品和服务！";die;
        }else{
            return "网络故障";die;
        }
    }
    //修改密码
    public function mod_password($data){
        $this->user = $this->load->database('user',TRUE);
        $uid=$data['uid'];
        $pwd_sql="SELECT password FROM user_login WHERE id='$uid'";
        $query=$this->user->query($pwd_sql);
        $pwd_query=$query->result();
        foreach ($pwd_query as $val) {
            $val_password=get_object_vars($val);
        }
        $password=$val_password['password'];
        // var_dump($password);
        $used_password=md5(md5($data['used_password'].'z'));
        $new_password=md5(md5($data['new_password'].'z'));
        // var_dump($used_password);
        // var_dump($data['used_password']);
        if($password==$used_password){
            $password_sql="UPDATE user_login SET `password` = '$new_password' WHERE id = '$uid'";
            if($this->user->query($password_sql)){
                return 1;die;
                echo '密码修改成功';die;
            }else{
                return "";die;
                echo "网络故障,密码修改失败,请重新连接您的网络";die;
            }
            //echo "修改密码";die;
        }else{
            return "请输入正确的密码";die;
        }
    }

    //管理歌手 添加新用户
    public function add_user($data){
        if (!empty($data)){
            $this->user=$this->load->database('user',true);
            $this->user->insert('user_login',$data);
            $result=$this->user->insert_id();
        }
        
        return $result;
    }

    //更新用户信息
    public function update_user($uid='',$data=[]){

        if (!$uid) return '';
        $where = "id = ".$uid;

        $this->user=$this->load->database('user',true);
        $this->user->update('user_login', $data, $where);
    }

    //修改个人信息 查询是否为旗下歌手
    public function user_singer_type($singer_uid){
        $this->user = $this->load->database('user',TRUE);
        $pwd_sql="SELECT uid,type FROM user_info WHERE uid='$singer_uid'";
        $info_query=$this->user->query($pwd_sql);
        if(!empty($info_query->result())){
            $pwd_query=$info_query->result();
            foreach ($pwd_query as $val) {
                $info_type=$val->type;
            }
            return $info_type;
        }
    }

    //查找手机号是否已存在
    public function phone($phone=''){

        if (!$phone) return false;
        $this->user = $this->load->database('user',TRUE);
        $sql="SELECT id FROM user_login WHERE phone='$phone'";
        $info_query=$this->user->query($sql);
        if(!empty($info_query->result())){
            return true;
        }else{
            return false;
        }


    }

    //查找REGISTRATION_ID
    public function REGISTRATION_ID($phone=''){
        if (!$phone) return '';

        $this->user = $this->load->database('user',TRUE);
        $sql="SELECT REGISTRATION_ID FROM user_info WHERE phone='$phone' and REGISTRATION_ID <> ''";
        $info_query=$this->user->query($sql);
        if(!empty($info_query->result())){
            foreach ($info_query->result() as $row){
                $REGISTRATION_ID=$row->REGISTRATION_ID;
            }
        }else{
            $sql="SELECT l.REGISTRATION_ID FROM user_login l,user_info i WHERE l.id=i.uid AND i.phone='$phone' and l.REGISTRATION_ID <> ''";
            $query=$this->user->query($sql);

            if(!empty($query->result())){
                foreach ($query->result() as $row){
                    $REGISTRATION_ID=$row->REGISTRATION_ID;
                }
                return $REGISTRATION_ID;
            }

            return '';
        }
        return $REGISTRATION_ID;

    }

    public function update_user_info($uid='',$data=[]){

        if (!$uid) return '';
        $where = "uid = ".$uid;

        $this->user=$this->load->database('user',true);
        $this->user->update('user_info', $data, $where);
    }
}