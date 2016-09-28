<?php 
class ReadLog_model extends CI_Model
{
	public function __construct()
    {
        parent::__construct();

        $this->cargo = $this->load->database('cargo',TRUE);
    }

    public function getLog($from_id=''){

        if (!$from_id) return false;

        $sql="select * from hz_log WHERE from_id={$from_id} ";
        $query=$this->cargo->query($sql);
        $result=[];
        if (!empty($query->result())) foreach ($query->result() as $row){
            $arr=json_decode($row->content,true);
            $result[]=$arr;
        }

        if ($result){
            return $result;
        }else{
            return [];
        }
    }
    

}
 ?>