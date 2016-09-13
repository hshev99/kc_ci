<?php 
class Timing_task_model extends CI_Model
{
	public function __construct()
    {
        parent::__construct();
    }

    public function order_over(){
    	$this->orders = $this->load->database('orders',true);
    	$sql="select id from user_orders where `status`=5 and end_time < now() limit 10";
		$query=$this->orders->query($sql);
        if(!empty($query->result())){
            foreach ($query->result() as  $row) {

                $sql_over="update user_orders set status=6 WHERE id={$row->id}";
                $this->orders->query($sql_over);
            }
        }
    }

    public function singer_present(){
        $this->orders = $this->load->database('orders',true);
        $sql="select id from user_orders where `status`=4 and now() > start_time  limit 10";
        $query=$this->orders->query($sql);
        if(!empty($query->result())){
            foreach ($query->result() as  $row) {

                $sql_over="update user_orders set status=5 WHERE id={$row->id}";
                $this->orders->query($sql_over);
            }
        }
    }

    //超时未支付关闭订单
    public function order_shut(){
        $this->orders = $this->load->database('orders',true);
        $sql="select id,create_time from user_orders where `status`=1 and create_time<FROM_UNIXTIME(UNIX_TIMESTAMP(now())-7200) order by id ASC limit 10 ";
        $query=$this->orders->query($sql);
        if(!empty($query->result())){
            foreach ($query->result() as  $row) {

                $sql_over="update user_orders set status=3 WHERE id={$row->id}";
                $this->orders->query($sql_over);
            }
        }

        $sql="select id,create_time from user_orders where `status`=2 and create_time<FROM_UNIXTIME(UNIX_TIMESTAMP(now())-86400) order by id ASC limit 10 ";
        $query=$this->orders->query($sql);
        if(!empty($query->result())){
            foreach ($query->result() as  $row) {

                $sql_over="update user_orders set status=3 WHERE id={$row->id}";
                $this->orders->query($sql_over);
            }
        }
    }

    /*
     *
     * 1支付未成功（预约方） 2艺人一小时内未接单（艺人） 3艺人接单（预约方、艺人）4艺人拒绝订单（预约方）
     * */
    //客服系统 通知
    public function order_notice(){
        $this->orders = $this->load->database('orders',true);
        $this->user = $this->load->database('user',true);

        //1支付未成功（预约方）
        $sql="select id,boss_uid,worker_uid,phone,create_time 
	from user_orders 
where
 	`pay_status`=1 
 	and create_time>FROM_UNIXTIME(UNIX_TIMESTAMP(now())-86400) 
	and id NOT IN ( select order_id  from `order_notice` where `type`=1 and create_time>FROM_UNIXTIME(UNIX_TIMESTAMP(now())-86400) )";
        $query=$this->orders->query($sql);

        if(!empty($query->result())){
            foreach ($query->result() as  $row) {

               $order_id=$row->id;
               $boss_uid=$row->boss_uid;
               $worker_uid=$row->worker_uid;
               $phone=$row->phone;

                $boss_phone_sql="select phone from user_info WHERE uid={$boss_uid}";
                $boss_phone_sql_query=$this->user->query($boss_phone_sql);
                $boss_phone='';
                if (!empty($boss_phone_sql_query))
                    foreach ($boss_phone_sql_query->result() as $boss_row){
                        $boss_phone=$boss_row->phone;
                    }

                $worker_phone_sql="select phone from user_info WHERE uid={$worker_uid}";
                $worker_phone_sql_query=$this->user->query($worker_phone_sql);
                $worker_phone='';
                if (!empty($worker_phone_sql_query))
                    foreach ($worker_phone_sql_query->result() as $worker_row){
                        $worker_phone=$worker_row->phone;
                    }

                $sql_notice="insert into `order_notice` SET
                        `order_id`={$order_id},
                        `boss_uid`={$boss_uid},
                        `worker_uid`={$worker_uid},
                        `order_phone`='{$phone}',
                        `boss_phone`='{$boss_phone}',
                        `woker_phone`='{$worker_phone}',
                        `type`=1,
                        `content`='支付未成功,通知:预约方'
                        ";
                $this->orders->query($sql_notice);
            }
        }



        //2艺人一小时内未接单（艺人）
        $sql="select id,boss_uid,worker_uid,phone,create_time 
	from user_orders 
where
 	`pay_status`=2
 	AND `status`=2
 	and create_time>FROM_UNIXTIME(UNIX_TIMESTAMP(now())-3600) 
	and id NOT IN ( select order_id  from `order_notice` where `type`=2 and create_time>FROM_UNIXTIME(UNIX_TIMESTAMP(now())-86400) )";
        $query=$this->orders->query($sql);

        if(!empty($query->result())){
            foreach ($query->result() as  $row) {

                $order_id=$row->id;
                $boss_uid=$row->boss_uid;
                $worker_uid=$row->worker_uid;
                $phone=$row->phone;

                $boss_phone_sql="select phone from user_info WHERE uid={$boss_uid}";
                $boss_phone_sql_query=$this->user->query($boss_phone_sql);
                $boss_phone='';
                if (!empty($boss_phone_sql_query))
                    foreach ($boss_phone_sql_query->result() as $boss_row){
                        $boss_phone=$boss_row->phone;
                    }

                $worker_phone_sql="select phone from user_info WHERE uid={$worker_uid}";
                $worker_phone_sql_query=$this->user->query($worker_phone_sql);
                $worker_phone='';
                if (!empty($worker_phone_sql_query))
                    foreach ($worker_phone_sql_query->result() as $worker_row){
                        $worker_phone=$worker_row->phone;
                    }

                $sql_notice="insert into `order_notice` SET
                        `order_id`={$order_id},
                        `boss_uid`={$boss_uid},
                        `worker_uid`={$worker_uid},
                        `order_phone`='{$phone}',
                        `boss_phone`='{$boss_phone}',
                        `woker_phone`='{$worker_phone}',
                        `type`=2,
                        `content`='艺人一小时内未接单,通知:艺人'
                        ";
                $this->orders->query($sql_notice);
            }
        }


        //3艺人接单（预约方、艺人）
        $sql="select id,boss_uid,worker_uid,phone,create_time 
	from user_orders 
where
 	`pay_status`=2
 	AND `status`=4
 	and create_time>FROM_UNIXTIME(UNIX_TIMESTAMP(now())-86400) 
	and id NOT IN ( select order_id  from `order_notice` where `type`=3 and create_time>FROM_UNIXTIME(UNIX_TIMESTAMP(now())-86400) )";
        $query=$this->orders->query($sql);

        if(!empty($query->result())){
            foreach ($query->result() as  $row) {

                $order_id=$row->id;
                $boss_uid=$row->boss_uid;
                $worker_uid=$row->worker_uid;
                $phone=$row->phone;

                $boss_phone_sql="select phone from user_info WHERE uid={$boss_uid}";
                $boss_phone_sql_query=$this->user->query($boss_phone_sql);
                $boss_phone='';
                if (!empty($boss_phone_sql_query))
                    foreach ($boss_phone_sql_query->result() as $boss_row){
                        $boss_phone=$boss_row->phone;
                    }

                $worker_phone_sql="select phone from user_info WHERE uid={$worker_uid}";
                $worker_phone_sql_query=$this->user->query($worker_phone_sql);
                $worker_phone='';
                if (!empty($worker_phone_sql_query))
                    foreach ($worker_phone_sql_query->result() as $worker_row){
                        $worker_phone=$worker_row->phone;
                    }

                $sql_notice="insert into `order_notice` SET
                        `order_id`={$order_id},
                        `boss_uid`={$boss_uid},
                        `worker_uid`={$worker_uid},
                        `order_phone`='{$phone}',
                        `boss_phone`='{$boss_phone}',
                        `woker_phone`='{$worker_phone}',
                        `type`=3,
                        `content`='艺人接单通知:预约方、艺人'
                        ";
                $this->orders->query($sql_notice);
            }
        }


        //4艺人拒绝订单（预约方）
        $sql="select id,boss_uid,worker_uid,phone,create_time 
	from user_orders 
where
 	`pay_status`=2
 	AND `status`=3
 	and create_time>FROM_UNIXTIME(UNIX_TIMESTAMP(now())-86400) 
	and id NOT IN ( select order_id  from `order_notice` where `type`=4 and create_time>FROM_UNIXTIME(UNIX_TIMESTAMP(now())-86400) )";
        $query=$this->orders->query($sql);

        if(!empty($query->result())){
            foreach ($query->result() as  $row) {

                $order_id=$row->id;
                $boss_uid=$row->boss_uid;
                $worker_uid=$row->worker_uid;
                $phone=$row->phone;

                $boss_phone_sql="select phone from user_info WHERE uid={$boss_uid}";
                $boss_phone_sql_query=$this->user->query($boss_phone_sql);
                $boss_phone='';
                if (!empty($boss_phone_sql_query))
                    foreach ($boss_phone_sql_query->result() as $boss_row){
                        $boss_phone=$boss_row->phone;
                    }

                $worker_phone_sql="select phone from user_info WHERE uid={$worker_uid}";
                $worker_phone_sql_query=$this->user->query($worker_phone_sql);
                $worker_phone='';
                if (!empty($worker_phone_sql_query))
                    foreach ($worker_phone_sql_query->result() as $worker_row){
                        $worker_phone=$worker_row->phone;
                    }

                $sql_notice="insert into `order_notice` SET
                        `order_id`={$order_id},
                        `boss_uid`={$boss_uid},
                        `worker_uid`={$worker_uid},
                        `order_phone`='{$phone}',
                        `boss_phone`='{$boss_phone}',
                        `woker_phone`='{$worker_phone}',
                        `type`=4,
                        `content`='支付未成功,通知:预约方'
                        ";
                $this->orders->query($sql_notice);
            }
        }

    }

}
 ?>