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



        $sql="SELECT `ur`.`user_id`,`ur`.`role_id` FROM `hz_admin_user_role` `ur`
              WHERE 1 $where ";
        $query=$this->cargo->query($sql);
        $role_id_arr=[];
        if(!empty($query->result())){
            foreach ($query->result() as $row) {
//                $arr_role[$row->role_id]=$row->role_id;
                $role_id_arr[]=$row->role_id;
            }

        }else{
            $role_id_arr=[];
        }
        
        $sql ="select * FROM hz_admin_role";
        $query=$this->cargo->query($sql);
        if(!empty($query->result())){
            foreach ($query->result() as $row) {
//                $arr['user_id']=$row->user_id;
                $arr['role_id']=$row->role_id;
                $arr['role_name']=$row->role_name;
                $arr['selected']=in_array($row->role_id,$role_id_arr)? "Y":"N";
                $result[]=$arr;
            }

            return $result;
        }else{
            return '';
//            $result=[];
        }

    }

    public function postAdminUserRole($admin_id='',$search=[]){
        if (!$admin_id) return false;
        $this->cargo = $this->load->database('cargo',TRUE);


        $role_id = isset($search['role_id'])&&!empty($search['role_id']) ? $search['role_id'] : false;

//        if (!$role_id ) return false;

        $arr=[];
        if (!empty($role_id))foreach ($role_id as $value){
            $arr[$value]=$value;
        }else{
            $arr=[];
        }

        $role_id_last=array_pop($arr);

        $role_id_arr=[];
        $role_id_arr=$arr;



        $set ="";
        if (!empty($role_id_arr))foreach ($role_id_arr as $value){
            $set .=" ($admin_id,$value), ";
        }
        $set .="({$admin_id},{$role_id_last})";


        $sql_del="delete from `hz_admin_user_role` where user_id={$admin_id}";
        $query=$this->cargo->query($sql_del);

        $sql ="insert into `hz_admin_user_role`(`user_id`,`role_id`) values $set";
        $query=$this->cargo->query($sql);

        if ($query){
            return true;
        }else{
            return false;
        }

    }




}
 ?>