<?php 
class Order_date_model extends CI_Model
{
	public function __construct()
    {
        parent::__construct();
    }

    public function get_order_date($uid=''){
        if (!$uid) return '';
    	$this->orders = $this->load->database('orders',true);
        $time=date('Y-m-d H:i:s',strtotime("-1 day"));
    	$sql="SELECT * FROM user_order_date WHERE uid={$uid} AND `date` > '{$time}'";

		$query=$this->orders->query($sql);
        $arr=[];$i=0;
        if (!empty($query))foreach ($query->result() as $row){
            $arr[$i]['date']=$row->date;
            $i++;
        };

        return $arr;
    }

    public function get_order_date2($uid=''){
        if (!$uid) return '';
        $this->orders = $this->load->database('orders',true);
        $time=date('Y-m-d H:i:s');
        $sql="SELECT * FROM user_order_date WHERE uid={$uid} AND `date` > '{$time}'";

        $query=$this->orders->query($sql);
        $arr=[];$i=0;
        if (!empty($query))foreach ($query->result() as $row){
            $arr[$i]='{holiday:'.date("Ymd",strtotime($row->date)).',lx:0}';
            $i++;
        }else
        {
            $arr=[];
        };
//$this->pr(json_encode($arr));
        return $arr;
    }
    
    public function get_order_date1($uid=''){
        if (!$uid) return '';
        $this->orders = $this->load->database('orders',true);
        $time=date('Y-m-d H:i:s');
        $sql="SELECT * FROM user_order_date WHERE uid={$uid} AND `date` > '{$time}'";

        $query=$this->orders->query($sql);
        $arr=[];
        if (!empty($query))foreach ($query->result() as $row){
            $arr[date("Y",strtotime($row->date))][(int)date("m",strtotime($row->date))][]=(int)date("d",strtotime($row->date));
        };
        
        return $arr;
    }

    public function set_order_date_arr($uid='',$data=[]){
        if (!$uid) return $arr=['operation'=>'F','msg'=>'无UID'];
        $this->orders = $this->load->database('orders',true);
        if (!empty($data)) {
            $i=0;
            $history=[];
            $sql="SELECT * FROM user_order_date WHERE uid={$uid}";
            $query_all = $this->orders->query($sql);
            if (!empty($query_all->result()))foreach ($query_all->result() as $row){
                $history[$row->date]=$row->id;
            }


            foreach ($data as $val) {
                $da = date("Y-m-d H:i:s", strtotime(date("Y-m-d", $val['date_time'])));
                $sql_get = "SELECT id FROM user_order_date WHERE uid={$uid} AND `date`='{$da}'";
                $query = $this->orders->query($sql_get);
                if (empty($query->result())) {
                    $sql_set = "insert into user_order_date SET uid={$uid},`date`='{$da}'";
                    $this->orders->query($sql_set);
                    $i++;
                }

                unset($history[$da]);
            }


            foreach ($history as $k=>$v){
                $sql_del="delete FROM user_order_date WHERE id={$v}";
                $this->orders->query($sql_del);
            }

            if ($i){
                $arr=[
                    'operation'=>'T',
                    'msg'=>'操作成功'
                ];
            }else{
                $arr=[
                    'operation'=>'F',
                    'msg'=>'操作成功'
                ];
            }

        }else{
            $sql="delete FROM user_order_date WHERE uid={$uid}";
            $this->orders->query($sql);

            $arr=[
                'operation'=>'F',
                'msg'=>'档期已清空'
            ];
        }

        return $arr;

    }
}
 ?>