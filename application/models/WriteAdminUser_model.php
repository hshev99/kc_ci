<?php 
class WriteAdminUser_model extends CI_Model
{
	public function __construct()
    {
        parent::__construct();
    }

    public function setAdminUser($data=[]){
        $this->cargo = $this->load->database('cargo',TRUE);
        $password=md5(md5(md5($data['password'])+'tuodui2016')+'0918');

        $sql="SELECT * FROM hz_admin_user WHERE login_name='{$data['login_name']}' AND password='{$password}'";
        $query=$this->cargo->query($sql);

        $result='';
        if(!empty($query->result())){
            foreach ($query->result() as $row) {
                $result['user_id']=$row->user_id;
                $result['user_name']=$row->user_name;
                $result['login_name']=$row->login_name;
            }
            return $result;
        }else{
            return '';
        }
    }

}
 ?>