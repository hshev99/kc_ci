<?php 
class ReadAdminUser_model extends CI_Model
{
	public function __construct()
    {
        parent::__construct();
    }

    public function getAdminUser($data=[]){
        $this->cargo = $this->load->database('cargo',TRUE);
        $sql="SELECT * FROM hz_admin_user WHERE login_name='{$data['login_name']}' AND password='{$data['password']}'";
        $query=$this->cargo->query($sql);
$this->pr($sql);
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