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


    public function agreeCargoOrder($cargo_sn='',$cargo_price_id=''){

        if (!$cargo_sn || !$cargo_price_id) return false;

        $sql="update hz_cargo_price set status=2 WHERE id={$cargo_price_id}";
        $query=$this->cargo->query($sql);

        if ($query){
            return true;
        }else{
            return false;
        }
    }
    

}
 ?>