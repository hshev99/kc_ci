<?php 
class ReadAdminUserRole_model extends CI_Model
{
	public function __construct()
    {
        parent::__construct();
    }

    public function getAdminUserRole($admin_id='',$search=[]){
        if (!$admin_id) return false;
        $this->cargo = $this->load->database('cargo',TRUE);

        $where ='';


        $where .=" and `ur`.`user_id`={$admin_id}";



        $sql="SELECT `ur`.`user_id`,`ur`.`role_id`,`r`.`role_name` FROM `hz_admin_user_role` `ur`,`hz_admin_role` `r` 
              WHERE 1 $where and `ur`.`role_id`=`r`.`role_id`  $where ";
        $query=$this->cargo->query($sql);
        $result=[];$this->pr($query->result());
        if(!empty($query->result())){
            foreach ($query->result() as $row) {
                $arr['role_id']=$row->role_id;
                $arr['role_name']=$row->role_name;
                $arr['description']=$row->description;

                $result[]=$arr;
            }
            
            return $result;
        }else{
            return '';
        }
    }



}
 ?>