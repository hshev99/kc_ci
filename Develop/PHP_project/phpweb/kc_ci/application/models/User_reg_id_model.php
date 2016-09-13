<?php 
class User_reg_id_model extends CI_Model
{
	public function __construct()
    {
        parent::__construct();
    }

    public function get_user_reg_id($phone){
    	$this->user = $this->load->database('user',true);
    	$sql="SELECT * FROM user_regid WHERE phone={$phone}";
		$query=$this->user->query($sql);
        $reg_id='';
        if(!empty($query->result())){
            foreach ($query->result() as $row) {
                $reg_id=$row->regid;
            }
        }
        return $reg_id;
    }

    public function set_user_reg_id($uid='',$regid=''){
        if (!$uid or !$regid) return '';

        $this->user = $this->load->database('user',true);

        $sql_phone="select phone FROM user_info where uid=$uid";
        $sql_phone_query=$this->user->query($sql_phone);
        $phone='';
        if (!empty($sql_phone_query->result())){
            foreach ($sql_phone_query->result() as $row){
                $phone=$row->phone;
            }
        }else{
            $phone_sql="select phone FROM user_login where id=$uid";
            $phone_sql_query=$this->user->query($phone_sql);
            if (!empty($phone_sql_query->result()))
                foreach ($phone_sql_query->result() as $row){
                    $phone=$row->phone;
                }

        }

        $sql="select * from user_regid WHERE uid=$uid";
        $user_regid_query=$this->user->query($sql);
        if (!empty($user_regid_query->result())){


            $sql_update="update user_regid set phone='{$phone}',regid='{$regid}' where uid='$uid'";
            $sql_update_query=$this->user->query($sql_update);
        }else{
            $sql_insert="insert into user_regid SET uid={$uid} ,phone='{$phone}',regid='{$regid}'";
            $sql_insert_query=$this->user->query($sql_insert);
        }
    }
}
 ?>