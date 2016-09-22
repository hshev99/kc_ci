<?php 
class ReadCargoPrice_model extends CI_Model
{
	public function __construct()
    {
        parent::__construct();
    }

    public function getCargoPrice($uid=''){
        $this->cargo = $this->load->database('cargo',TRUE);

        $sql="SELECT name FROM hz_goods_type WHERE uid={$uid}";
        $query=$this->cargo->query($sql);

        $result=[];
        if(!empty($query->result())){
            foreach ($query->result() as $row) {
                $result[]['name']=$row->name;
            }
            return $result;
        }else{
            return '';
        }
    }

}
 ?>