<?php 
class ReadUser_model extends CI_Model
{
	public function __construct()
    {
        parent::__construct();

        $this->cargo = $this->load->database('cargo',TRUE);
    }

    public function getUser($admin_id='',$page=1,$l=12,$search){

        $where ='';


        $where .=" and enabled=1";

        //搜索条件

        if (isset($search['user_id']) && $search['user_id']) $where .=" and user_id='{$search['user_id']}' ";
        if (isset($search['login_name']) && $search['login_name']) $where .=" and login_name like '%{$search['login_name']}%' ";
        if (isset($search['user_name']) && $search['user_name']) $where .=" and user_name like '%{$search['user_name']}%' ";

        $limit='limit '.$l*($page-1).','.$l;

        $order_by =' order by user_id DESC ';

        $sql="SELECT * FROM hz_admin_user WHERE 1 $where  $order_by $limit ";echo $sql;exit;
        $query=$this->cargo->query($sql);

        $sql_count="SELECT COUNT(1) as a FROM hz_admin_user WHERE 1 $where ";
        $query_count=$this->cargo->query($sql_count);

        empty($query_count->result()) ? $pageCount=0 : $pageCount=ceil($query_count->result()[0]->a /$l);
        empty($query_count->result()) ? $totalCount=0 : $totalCount=ceil($query_count->result()[0]->a);

        $result=[];
        $result['page']=[
            'curpage'=>$page,
            'limit'=>$l,
            'pageCount'=>$pageCount,
            'totalCount'=>$totalCount
        ];
        if(!empty($query->result())){
            foreach ($query->result() as $row) {
                $arr['user_id']=$row->user_id;

                $arr['user_name']=$row->user_name;
                $arr['login_name']=$row->login_name;

                $arr['create_time']=date("Y-m-d H:i:s",strtotime($row->create_time));

                $arr['email']=$row->email;
                $arr['company_uid']=$row->company_uid;


                $result['result'][]=$arr;
            }
            return $result;
        }else{
            return '';
        }
    }



    
}
 ?>