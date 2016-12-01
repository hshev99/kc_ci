<?php 
class ReadAdminModule_model extends CI_Model
{
	public function __construct()
    {
        parent::__construct();
    }

    public function getAdminModule($admin_id='',$search=[]){
        if (!$admin_id) return false;
        $this->cargo = $this->load->database('cargo',TRUE);

        $where ='';


        if (isset($search['module_id'])) {
            $where .=" and module_id={$search['module_id']}";
        }else{
            if (isset($search['parent_id'])) $where .=" and parent_id={$search['parent_id']}";
        }

        $child ="Y";
        if (isset($search['child'])){
            $child =$search['child'];
        }else{
            $child ="Y";
        }

        $sql="SELECT * FROM hz_admin_module WHERE 1 $where AND enabled=0";
        $query=$this->cargo->query($sql);
        $result=[];
        if(!empty($query->result())){
            foreach ($query->result() as $row) {
                $arr['module_id']=$row->module_id;
                $arr['parent_id']=$row->parent_id;
                $arr['name']=$row->name;
                $arr['url']=$row->url;
                $arr['enabled']=$row->enabled;
                $arr['sort']=$row->sort;
                $arr['action']=$row->action;

                if ($child == 'Y')$arr['child'] = self::getAdminModuleChild($row->module_id);


                $result[]=$arr;
            }
            
            return $result;
        }else{
            return '';
        }
    }

    public function getAdminModuleChild($parent_id=''){

        $this->cargo = $this->load->database('cargo',TRUE);

        $sql="SELECT * FROM hz_admin_module WHERE parent_id=$parent_id AND enabled=0";
        $query=$this->cargo->query($sql);

        $result=[];
        if (!empty($query->result())){
            foreach ($query->result() as $val){
                $arr['module_id']=$val->module_id;
                $arr['parent_id']=$val->parent_id;
                $arr['name']=$val->name;
                $arr['url']=$val->url;
                $arr['enabled']=$val->enabled;
                $arr['sort']=$val->sort;
                $arr['action']=$val->action;

                $arr['child'] = self::getAdminModuleChild($val->module_id);
                $result[]=$arr;
            }
        }else{
            return false;
        }

        return $result;
    }

    public function postAdminModule($admin_id='',$search)
    {

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


        $sql = " $header hz_admin_module set $set  $where";exit($sql);
        $query = $this->cargo->query($sql);

        if ($query){
            return true;
        }else{
            return false;
        }

    }

}
 ?>