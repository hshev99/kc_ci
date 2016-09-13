<?php 
/**
 * Created by PhpStorm.
 * User: hshev99
 * Date: 16/6/12
 * Time: 上午10:52
 */

class Orders_info_model extends CI_Model
{
	public $id;
	public $status;//订单状态
	public $boss_uid;//老板UID
	public $worker_uid;//歌手ID
	public $name;//活动名称
	public $place;//活动地点
	public $phone;//电话
	public $start_time;//开始时间
	public $end_time;//结束时间
	public $cate;//类别
	public $scen;//场景
	public $per_menber;//演出数量
	public $meal;//餐标
	public $live;//住宿
	public $travel;//出行方式
	public $insurance;//演出保险
	public $note;//备注


	public function __construct()
    {
        parent::__construct();
        $this->orders=$this->load->database('orders',true);
    }

    public function save_Order($data)
    {
		$query = $this->orders->insert('user_orders',$data);

		return $query;
    }

	public function order_uid_phone($order_sn=''){
		$sql="select boss_uid,worker_uid,phone,worker_name from user_orders where order_sn='{$order_sn}'";
		$query=$this->orders->query($sql);


		$arr=[];
		if (!empty($query->result())) foreach ($query->result() as $row){
			$arr['boss_uid']=$row->boss_uid;
			$arr['boss_phone']=$this->user_phone($row->boss_uid);

			$arr['worker_name']=$row->worker_name;
			$arr['worker_uid']=$row->worker_uid;
			$arr['worker_phone']=$this->user_phone($row->worker_uid);

			$arr['add_user_phone']=$row->phone;
			//查询电话号码
		}
		return $arr;
	}

	public function user_phone($uid=''){
		$this->user=$this->load->database('user',true);
		$sql="select phone from user_info where uid={$uid}";
		$query=$this->user->query($sql);
		$phone='';
		if (!empty($query->result())) foreach ($query->result() as $row){
			$phone=$row->phone;
		}

		return $phone;
	}
}
 ?>