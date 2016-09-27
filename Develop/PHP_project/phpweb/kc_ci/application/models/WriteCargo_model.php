<?php 
class WriteCargo_model extends CI_Model
{
	public function __construct()
    {
        parent::__construct();

        $this->cargo = $this->load->database('cargo',TRUE);
    }

    public function setCargo($data){
        if (!$data) return false;

        if (!empty($data)){
            $result=$this->cargo->insert('hz_cargo',$data);

        }
        return $result;
    }



}
 ?>