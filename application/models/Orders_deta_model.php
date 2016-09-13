<?php 
class Orders_deta_model extends CI_Model
{
	public function __construct()
    {
        parent::__construct();
        // 
        
    }

    public function order_phone($order_sn=''){
        if ($order_sn =='') return '';

        $this->orders = $this->load->database('orders', TRUE);
        $this->orders->where('order_sn', $order_sn);
        $this->orders->select('phone,worker_name,status');
        $query = $this->orders->get('user_orders');
        if (!empty($query->result())){
            foreach ($query->result() as $row) {
                $arr = [
                    'phone' => $row->phone,
                    'worker_name' => $row->worker_name,
                    'status' => $row->status,
                ];
            }
        }

        return $arr;
    }

    public function order_detail($order_sn='')
    {
        $this->orders = $this->load->database('orders', TRUE);
        $this->orders->where('order_sn', $order_sn);
        $this->orders->select();
        $query = $this->orders->get('user_orders');
        if (!empty($query->result())){
            foreach ($query->result() as $row) {
                $arr = [
                    'order_sn' => $row->order_sn,
                    'status' => $row->status,
                    'boss_uid' => $row->boss_uid,
                    'worker_uid' => $row->worker_uid,
                    'worker_name' => $row->worker_name,
                    'performace_name' => $row->performace_name,
                    'start_time' => date("Y-m-d H:i",strtotime($row->start_time)),
                    'place' => $row->place,
                    'end_time' => date("Y-m-d H:i",strtotime($row->end_time)),
                    'scen' => $row->scen,
                    'per_menber' => $row->per_menber,
                    'meal' => $row->meal,
                    'live' => $row->live,
                    'travel' => $row->travel,
                    'insurance' => $row->insurance,
                    'pay_way' => $row->pay_way,
                    'pay_amount' => $row->pay_amount,
                    'pay_time' => $row->pay_time,
                    'pay_status' => $row->pay_status,
                    'create_time' => $row->create_time,
                    'cate' => $row->cate,
                    'ps' => $row->note,
                    'phone' => $row->phone,
                    'notice' => $row->notice,
                    'worker_phone' => $row->worker_phone,
                    'pay_time' => is_null($row->pay_time)? date("Y-m-d H:i:s"):$row->pay_time,
                    'accept_refused' => is_null($row->accept_refused)? date("Y-m-d H:i:s"):$row->accept_refused,
                    'shut_down' => is_null($row->shut_down) ? date("Y-m-d H:i:s"):$row->shut_down,
                    'confirm' => is_null($row->confirm) ? date("Y-m-d H:i:s"):$row->confirm,
                    'complete' => is_null($row->complete) ? date("Y-m-d H:i:s") :$row->complete,
                ];
            }
            $this->user=$this->load->database('user',true);
            $sql="select phone from user_info where uid={$arr['boss_uid']}";
            $query_sql=$this->user->query($sql);
            $phone='';
            if (!empty($query_sql->result())) foreach ($query_sql->result() as $row){
                $boss_phone=$row->phone;
            }
            $arr['boss_phone']=$boss_phone;
        }else{
            $arr=[];
        }

        return $arr;
    }
    //
    public function info_Orders($uid){
        $this->orders=$this->load->database('orders',TRUE);
        $this->orders->where('boss_uid',$uid);
        $this->orders->select('create_time,status,start_time,end_time,worker_uid');
        $query = $this->orders->get('user_orders');
        return $query->result();
    }
    public function info_User($uid){
        $this->user=$this->load->database('user',TRUE);
        $this->user->where('uid',$uid);
        $this->user->select('name,nick,img,about_price');
        $query = $this->user->get('user_info');
        return $query->result();
    }
}
 ?>