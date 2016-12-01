<?php 
class ReadAdminRole_model extends CI_Model
{
	public function __construct()
    {
        parent::__construct();
    }

    public function getAdminRole($admin_id='',$search=[]){
        if (!$admin_id) return false;
        $this->cargo = $this->load->database('cargo',TRUE);

        $where ='';


        if (isset($search['role_id'])) {
            $where .=" and role_id={$search['role_id']}";
        }else{

        }


        $sql="SELECT * FROM hz_admin_role WHERE 1 $where ";
        $query=$this->cargo->query($sql);
        $result=[];
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

    public function postAdminModule($admin_id='',$search)
    {
        $this->cargo = $this->load->database('cargo',TRUE);

        $where = ' WHERE 1 ';
        $header ='';

        if (isset($search['module_id']) && $search['module_id']){
            $where .=" and module_id='{$search['module_id']}' ";

            $header .="update";
        } else{
//            return '';
            $header .=" insert into ";
            $where ='';
        }

        //搜索条件

        $set ="";
        unset($search['module_id']);
        foreach ($search as $key =>$value){
            $set .=" `$key`='{$value}', ";
        }
        $set .=" `update_time`=now() ";


        $sql = " $header hz_admin_module set $set  $where";
        $query = $this->cargo->query($sql);

        if ($query){
            return true;
        }else{
            return false;
        }

    }

}
 ?>