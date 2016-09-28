<?php 
class WriteLog_model extends CI_Model
{
	public function __construct()
    {
        parent::__construct();

        $this->cargo = $this->load->database('cargo',TRUE);
    }

    public function setLog($from_id='',$content=''){

        if (!$from_id) return false;

        $sql="insert into hz_cargo_price set from_id={$from_id} , content='{$content}' ";
        $query=$this->cargo->query($sql);

        if ($query){
            return true;
        }else{
            return false;
        }
    }
    

}
 ?>