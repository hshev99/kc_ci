<?php 
class ReadCargoPrice_model extends CI_Model
{
	public function __construct()
    {
        parent::__construct();
    }

    public function getCargoPrice($cargo_id=''){
        $this->cargo = $this->load->database('cargo',TRUE);

        $sql="SELECT count(1) as a FROM hz_cargo_price WHERE cargo_id={$cargo_id}";
        $query=$this->cargo->query($sql);

        $result=0;
        if(!empty($query->result())){
            foreach ($query->result() as $row) {
                $result=$row->a;
            }
            return $result;
        }else{
            return 0;
        }
    }

}
 ?>