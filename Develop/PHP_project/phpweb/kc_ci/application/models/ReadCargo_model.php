<?php 
class ReadCargo_model extends CI_Model
{
	public function __construct()
    {
        parent::__construct();
    }

    public function getCargo($admin_id=''){
        if (!$admin_id) return false;
        $this->cargo = $this->load->database('cargo',TRUE);

        $sql="SELECT * FROM hz_cargo WHERE shipper_id={$admin_id} ";
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