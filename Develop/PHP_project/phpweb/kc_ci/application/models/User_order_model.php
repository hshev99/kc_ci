<?php 
class User_order_model extends CI_Model
{
	public function __construct()
    {
        parent::__construct();
    	
    }

    public function info_Orders($uid){
    	$this->orders=$this->load->database('orders',TRUE);
        $this->orders->where('worker_uid',$uid);
        $this->orders->select('create_time,start_time,end_time,boss_uid');
        //$this->orders->order_by('id','DESC');
        $query = $this->orders->get('user_orders');
        // var_dump($query->result());die;
        return $query->result();
    }
    public function info_User($uid){
    	$this->user=$this->load->database('user',TRUE);
        $this->user->where('uid',$uid);
        $this->user->select('name,nick,img');
        $query = $this->user->get('user_info');
        return $query->result();
    }

    //预约我的
    public function UserOrderMy($uid='',$order_type=0){
        $status_conf=[
            1=>'待付款',
            2=>'已付款',
            3=>'交易关闭',
            4=>'已接单',
            5=>'歌手到场',
            6=>'交易完成',
            7=>'交易完成',
        ];

        $this->user=$this->load->database('user',TRUE);
        $query_user = $this->user->query("SELECT singer_uid FROM user_singer WHERE uid = {$uid}");
        $uid = '('.$uid;
        if (!empty($query_user)) foreach ($query_user->result() as $row){
            $uid .=','.$row->singer_uid;
        }
        $uid .=')';

        $this->orders=$this->load->database('orders',TRUE);

        $arr=[];
        //待处理 status 2
        $sql="SELECT order_sn,performace_name,status,worker_uid,start_time,end_time,trading_time,worker_img,worker_name,worker_nick,pay_amount,place
              FROM user_orders WHERE worker_uid IN $uid AND del=0 AND status IN (2) ORDER BY id DESC";
        $query = $this->orders->query($sql);
        $i=0;
        foreach ($query->result() as $row){
            $arr['waiting'][$i]['order_sn']=$row->order_sn;
            $arr['waiting'][$i]['status']=$row->status;
            $arr['waiting'][$i]['status_name']=$status_conf[$row->status];
            $arr['waiting'][$i]['performace_name']=$row->performace_name;
            $arr['waiting'][$i]['trading_time']=$row->trading_time;
            $arr['waiting'][$i]['worker_img']=$row->worker_img;
            $arr['waiting'][$i]['worker_name']=$row->worker_name;
            $arr['waiting'][$i]['worker_uid']=$row->worker_uid;
            $arr['waiting'][$i]['worker_nick']=$row->worker_nick;
            $arr['waiting'][$i]['start_time']=date("Y-m-d H:i",strtotime($row->start_time));
            $arr['waiting'][$i]['end_time']=date("Y-m-d H:i",strtotime($row->end_time));
            $arr['waiting'][$i]['about_price']=$row->pay_amount;
            $arr['waiting'][$i]['place']=is_null($row->place) ? '' : $row->place;
            $i++;
        }


        //交易关闭
        $sql="select order_sn,status,performace_name,worker_uid,start_time,end_time,trading_time,worker_img,worker_name,worker_nick,pay_amount,place
              from user_orders where worker_uid IN $uid AND del=0 AND status IN (3) ORDER BY id DESC";
        $query = $this->orders->query($sql);
        $i=0;
        foreach ($query->result() as $row){
            $arr['shutDown'][$i]['order_sn']=$row->order_sn;
            $arr['shutDown'][$i]['status']=$row->status;
            $arr['shutDown'][$i]['status_name']=$status_conf[$row->status];
            $arr['shutDown'][$i]['performace_name']=$row->performace_name;
            $arr['shutDown'][$i]['trading_time']=$row->trading_time;
            $arr['shutDown'][$i]['worker_img']=$row->worker_img;
            $arr['shutDown'][$i]['worker_name']=$row->worker_name;
            $arr['shutDown'][$i]['worker_uid']=$row->worker_uid;
            $arr['shutDown'][$i]['worker_nick']=$row->worker_nick;
            $arr['shutDown'][$i]['start_time']=date("Y-m-d H:i",strtotime($row->start_time));
            $arr['shutDown'][$i]['end_time']=date("Y-m-d H:i",strtotime($row->end_time));
            $arr['shutDown'][$i]['about_price']=$row->pay_amount;
            $arr['shutDown'][$i]['place']=is_null($row->place) ? '' : $row->place;
            $i++;
        }


        //进行中
        $sql="select order_sn,status,performace_name,worker_uid,start_time,end_time,trading_time,worker_img,worker_name,worker_nick,pay_amount,place
              from user_orders where worker_uid IN $uid AND del=0 AND status IN (4,5) ORDER BY id DESC";
        $query = $this->orders->query($sql);
        $i=0;
        foreach ($query->result() as $row){
            $arr['ongoing'][$i]['order_sn']=$row->order_sn;
            $arr['ongoing'][$i]['status']=$row->status;
            $arr['ongoing'][$i]['status_name']=$status_conf[$row->status];
            $arr['ongoing'][$i]['performace_name']=$row->performace_name;
            $arr['ongoing'][$i]['trading_time']=$row->trading_time;
            $arr['ongoing'][$i]['worker_img']=$row->worker_img;
            $arr['ongoing'][$i]['worker_uid']=$row->worker_uid;
            $arr['ongoing'][$i]['worker_name']=$row->worker_name;
            $arr['ongoing'][$i]['worker_nick']=$row->worker_nick;
            $arr['ongoing'][$i]['start_time']=date("Y-m-d H:i",strtotime($row->start_time));
            $arr['ongoing'][$i]['end_time']=date("Y-m-d H:i",strtotime($row->end_time));
            $arr['ongoing'][$i]['about_price']=$row->pay_amount;
            $arr['ongoing'][$i]['place']=is_null($row->place) ? '' : $row->place;
            $i++;
        }

        //完成
        $sql="select order_sn,performace_name,status,worker_uid,start_time,end_time,trading_time,worker_img,worker_name,worker_nick,pay_amount,place
              from user_orders where worker_uid IN $uid AND del=0 AND status IN (6) ORDER BY id DESC";
        $query = $this->orders->query($sql);
        $i=0;
        foreach ($query->result() as $row){
            $arr['complete'][$i]['order_sn']=$row->order_sn;
            $arr['complete'][$i]['status']=$row->status;
            $arr['complete'][$i]['status_name']=$status_conf[$row->status];
            $arr['complete'][$i]['performace_name']=$row->performace_name;
            $arr['complete'][$i]['trading_time']=$row->trading_time;
            $arr['complete'][$i]['worker_img']=$row->worker_img;
            $arr['complete'][$i]['worker_uid']=$row->worker_uid;
            $arr['complete'][$i]['worker_name']=$row->worker_name;
            $arr['complete'][$i]['worker_nick']=$row->worker_nick;
            $arr['complete'][$i]['start_time']=date("Y-m-d H:i",strtotime($row->start_time));
            $arr['complete'][$i]['end_time']=date("Y-m-d H:i",strtotime($row->end_time));
            $arr['complete'][$i]['about_price']=$row->pay_amount;
            $arr['complete'][$i]['place']=is_null($row->place) ? '' : $row->place;
            $i++;
        }

        return $arr;
    }

    //我预约的
    public function UserOrder($boss_uid='',$status=''){
        $this->orders=$this->load->database('orders',TRUE);
        $status_conf=[
            1=>'待付款',
            2=>'已付款',
            3=>'交易关闭',
            4=>'已接单',
            5=>'歌手到场',
            6=>'交易完成',
            7=>'交易完成',
        ];
        $arr=[];
        if ($status =='' or $status < 0){
            $statu = '(1,2,3,4,5,6,7)';
        }else{
            $statu = "($status)";
        }
        //完成
        $sql="SELECT order_sn,status,performace_name,worker_uid,start_time,end_time,trading_time,worker_img,worker_name,worker_nick,pay_amount,place
              FROM user_orders WHERE boss_uid=$boss_uid AND del=0 AND status IN {$statu} ORDER BY id DESC ";
        $query = $this->orders->query($sql);
        $i=0;
        foreach ($query->result() as $row){
            $arr[$i]['order_sn']=$row->order_sn;
            $arr[$i]['status']=$row->status;
            $arr[$i]['status_name']=$status_conf[$row->status];
            $arr[$i]['performace_name']=$row->performace_name;
            $arr[$i]['trading_time']=$row->trading_time;
            $arr[$i]['worker_img']=$row->worker_img;
            $arr[$i]['worker_uid']=$row->worker_uid;
            $arr[$i]['worker_name']=$row->worker_name;
            $arr[$i]['worker_nick']=$row->worker_nick;
            $arr[$i]['place']=is_null($row->place) ? '' : $row->place;
            $arr[$i]['start_time']=date("Y-m-d H:i",strtotime($row->start_time));
            $arr[$i]['end_time']=date("Y-m-d H:i",strtotime($row->end_time));
            $arr[$i]['about_price']=$row->pay_amount;
            $i++;
        }

        return $arr;
    }

    public function order_info($order_sn=''){
        if (!$order_sn) return '';

        $this->orders=$this->load->database('orders',TRUE);
        $arr=[];

        $sql="select *
              from user_orders where order_sn='$order_sn'";
        $query = $this->orders->query($sql);
        foreach ($query->result() as $row){
            $arr=get_object_vars($row);
        }
        return $arr;

    }

    public function order_worker_uid($worker_uid,$user_login_uid){
        $this->user=$this->load->database('user',TRUE);
        $sql="SELECT  singer_uid FROM user_singer WHERE uid='$user_login_uid'";
        $query = $this->user->query($sql);
        foreach ($query->result() as $val) {
            $arr[]=$val->singer_uid;
        }
        if(empty($arr)){
            return 'false';die;
        }else{
            if(in_array($worker_uid,$arr)){
                return 'success';die;
            }else{
                return 'false';die;
            }
        }
    }
}
 ?>