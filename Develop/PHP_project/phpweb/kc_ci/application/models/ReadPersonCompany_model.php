<?php 
class ReadPersonCompany_model extends CI_Model
{
	public function __construct()
    {
        parent::__construct();
    }

    public function getPersonCompany($user_id=''){
        if (!$user_id) return '';
        $this->caravans = $this->load->database('caravans',TRUE);

        $sql="SELECT company_name,boss FROM person_company WHERE user_id={$user_id}";$this->pr($sql);
        $query=$this->caravans->query($sql);

        $result=[];
        if(!empty($query->result())){
            foreach ($query->result() as $row) {
                $result['company_name']=$row->company_name;
                $result['company_user']=$row->boss;
            }

            return $result;
        }else{
            return [];
        }
    }

}
 ?>