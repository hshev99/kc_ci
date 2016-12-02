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

    public function postAdminRole($admin_id='',$search)
    {
        $this->cargo = $this->load->database('cargo',TRUE);

        $where = ' WHERE 1 ';
        $header ='';

        if (isset($search['role_id']) && $search['role_id']){
            $where .=" and role_id='{$search['role_id']}' ";

            $header .="update";
        } else{
//            return '';
            $header .=" insert into ";
            $where ='';
        }

        //搜索条件

        $set ="";
        unset($search['role_id']);
        foreach ($search as $key =>$value){
            $set .=" `$key`='{$value}', ";
        }
        $set .=" `update_time`=now() ";


        $sql = " $header hz_admin_role set $set  $where";
        $query = $this->cargo->query($sql);

        if ($query){
            return true;
        }else{
            return false;
        }

    }

    public function getAdminRoleModule($admin_id='',$search=[]){
        if (!$admin_id) return false;
        $this->cargo = $this->load->database('cargo',TRUE);

        $where ='';


        if (isset($search['role_id'])) {
            $where .=" and role_id={$search['role_id']}";
        }else{

        }


        $sql="SELECT * FROM hz_admin_role_module WHERE 1 $where ";
        $query=$this->cargo->query($sql);
        $result=[];
        if(!empty($query->result())){
            foreach ($query->result() as $row) {
                $arr['role_id']=$row->role_id;
                $arr['module_id']=$row->module_id;
                $result[]=$arr;
            }

            return $result;
        }else{
            return '';
        }
    }

    public function postAdminRoleModule($admin_id='',$search=[]){
        if (!$admin_id) return false;
        $this->cargo = $this->load->database('cargo',TRUE);


        $role_id = isset($search['role_id'])&&!empty($search['role_id']) ? $search['role_id'] : false;
        $module_id = isset($search['module_id'])&&!empty($search['module_id']) ? $search['module_id'] : false;

        if (!$role_id || !$module_id) return false;
        $module_id_last=array_pop($module_id);

        $set ="";
        if (!empty($search['module_id']))foreach ($search['module_id'] as $value){
            $set .=" ($role_id,$value), ";
        }
        $set .="({$role_id},{$module_id_last})";


        $sql_del="delete from `hz_admin_role_module` where role_id={$role_id}";
        $query=$this->cargo->query($sql_del);

        $sql ="insert into `hz_admin_role_module`(`module_id`,`role_id`) values $set";$this->pr($sql);
        $query=$this->cargo->query($sql);

        if ($query){
            return true;
        }else{
            return false;
        }

    }

}
 ?>