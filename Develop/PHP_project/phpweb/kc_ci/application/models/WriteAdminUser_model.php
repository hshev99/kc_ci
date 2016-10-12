<?php 
class WriteAdminUser_model extends CI_Model
{
	public function __construct()
    {
        parent::__construct();
    }

    public function upAdminUser($data=[]){
        $this->cargo = $this->load->database('cargo',TRUE);
        $password=md5(md5(md5($data['password']).'tuodui2016').'0918');

        $sql="SELECT * FROM hz_admin_user WHERE login_name='{$data['login_name']}' ";
        $query=$this->cargo->query($sql);

        if(empty($query->result())){
            return false;
        }

        $sql="update hz_admin_user set password='{$password}' WHERE login_name='{$data['login_name']}'";
        $query=$this->cargo->query($sql);

        return true;
    }

}
 ?>