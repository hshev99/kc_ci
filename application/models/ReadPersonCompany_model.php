<?php 
class ReadPersonCompany_model extends CI_Model
{
	public function __construct()
    {
        parent::__construct();
    }

    public function getPersonCompany($cargo_id=''){
        if (!$cargo_id) return 0;
        $this->cargo = $this->load->database('cargo',TRUE);

        $sql="SELECT count(1) as a FROM hz_cargo_price WHERE cargo_id={$cargo_id}";
        $query=$this->cargo->query($sql);

        $result=0;
        if(!empty($query->result())){
            foreach ($query->result() as $row) {
                $result=$row->a;
            }

            if ($result > 99) $result ="99+";
            return $result;
        }else{
            return 0;
        }
    }

}
 ?>