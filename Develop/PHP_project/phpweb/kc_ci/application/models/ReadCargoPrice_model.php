<?php 
class ReadCargoPrice_model extends CI_Model
{
	public function __construct()
    {
        parent::__construct();
    }

    public function getCargoPrice($cargo_id=''){
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

    public function getCargoPricedetail($cargo_id=''){

        if (!$cargo_id) return [];
        $this->cargo = $this->load->database('cargo',TRUE);

        $sql="SELECT * FROM hz_cargo_price WHERE cargo_id={$cargo_id}";
        $query=$this->cargo->query($sql);

        $result=[];
        if(!empty($query->result())){
            foreach ($query->result() as $row) {
                $arr['company_id']=$row->company_id;
                $arr['expect_price']=$row->expect_price;
                $arr['ton_count']=$row->ton_count;
                $arr['status']=$row->status;
                $arr['remark']=$row->remark;
            }

            return $result=$arr;
        }else{
            return [];
        }
    }

    public function getCaogoTransportInfo($cargo_id=''){

        if (!$cargo_id) return [];
        $this->cargo = $this->load->database('cargo',TRUE);

        $this->load->model('ReadPersonCompany_model');

        $sql="SELECT * FROM hz_cargo_price WHERE cargo_id={$cargo_id}";
        $query=$this->cargo->query($sql);

        $result=[];
        if(!empty($query->result())){
            foreach ($query->result() as $row) {
                $company_info=$this->ReadPersonCompany_model->getPersonCompany($row->company_id);
                $arr['company_id']=$row->company_id;
                $arr['company_name']=$company_info['company_name'];
                $arr['company_user']=$company_info['company_user'];
                $arr['expect_price']=$row->expect_price;
                $arr['ton_count']=$row->ton_count;
                $arr['status']=$row->status;
                $arr['remark']=$row->remark;

                $result[]=$arr;
            }

            return $result;
        }else{
            return [];
        }

    }

    public function getCargoPriceListdetail($cargo_id='',$page=1,$l=12){

        if (!$cargo_id) return [];
        $this->cargo = $this->load->database('cargo',TRUE);


        $limit='limit '.$l*($page-1).','.$l;

        $where =" and cargo_id={$cargo_id}";


        $sql_count="SELECT COUNT(1) as a FROM hz_cargo_price WHERE 1 $where  ";
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


        $sql="SELECT * FROM hz_cargo_price WHERE 1 $where $limit";
        $query=$this->cargo->query($sql);

        $this->load->model('ReadPersonCompany_model');

        if(!empty($query->result())){
            foreach ($query->result() as $row) {
                $arr['cargo_price_id']=$row->id;
                $arr['company_name']=$this->ReadPersonCompany_model->getPersonCompany($row->company_id);
                $arr['expect_price']=$row->expect_price.'/吨';
//                $arr['ton_count']=$row->ton_count;
                $arr['create_time']=$row->create_time;
                $arr['remark']=$row->remark;

                $arr['roommates']='10/次';

                $arr['operate']=self::CargoPriceOperate($row->status);

                $result['result'][]=$arr;
            }

            return $result;
        }else{
            return [];
        }
    }

    public function CargoPriceOperate($status=1){

        $arr=[];

        $arr[]=[
            'name'=>'下单',
            'url'=>'CargoPriceBOrder'
        ];

        return $arr;
    }

    public function getCargoPriceList($uid='',$params=[]){
        if (empty($params['cargo_sn'])) return false;

        $page = empty($params['page']) ? 1 : $params['page'];
        $l = empty($params['l']) ? 12 : $params['l'];

        $this->cargo = $this->load->database('cargo',TRUE);

        $sql="SELECT id,status FROM hz_cargo WHERE cargo_sn='{$params['cargo_sn']}' ";
        $query=$this->cargo->query($sql);

        if (!empty($query->result()))foreach ($query->result() as $row){
            $cargo_id=$row->id;
            $status=$row->status;
        }
        if (!$cargo_id) return false;

        $data=self::getCargoPriceListdetail($cargo_id,$page,$l);

        if ($data){

            $status_name=[
                0=>'异常',
                1=>'询价中',
                2=>'进行中',
                3=>'待付款',
                4=>'已完成',
                5=>'已取消',
                6=>'已过期'
            ];

            $data['status_info']=[
                'status'=>(int)$status,
                'status_name'=>$status_name[$status]
            ];
        }
        return $data;
    }
}
 ?>