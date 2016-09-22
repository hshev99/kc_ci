<?php 
class ReadCargo_model extends CI_Model
{
	public function __construct()
    {
        parent::__construct();

        $this->cargo = $this->load->database('cargo',TRUE);
    }

    public function getCargo($admin_id=''){
        if (!$admin_id) return false;

        $sql="SELECT * FROM hz_cargo WHERE shipper_id={$admin_id} ";
        $query=$this->cargo->query($sql);

        $result=[];
        if(!empty($query->result())){
            foreach ($query->result() as $row) {
                $arr['cargo_sn']=$row->cargo_sn;
                $arr['send_user_mobile']=$row->send_user_mobile;
                $arr['send_user_name']=$row->send_user_name;
                $arr['send_address']=$row->send_address;


                $arr['receive_address']=$row->receive_address;
                $arr['receive_user_mobile']=$row->receive_user_mobile;
                $arr['receive_user_name']=$row->receive_user_name;

                $arr['cargo_name']=$row->cargo_name;
                $arr['cargo_weight']=$row->cargo_weight;
                $arr['expect_price']=$row->expect_price;
                $arr['start_time']=$row->start_time;
                $arr['end_time']=$row->end_time;
                $arr['status']=$row->status;
                $arr['remark']=$row->remark;
                $arr['create_time']=$row->create_time;
                $arr['update_time']=$row->update_time;

                $result[]=$arr;
            }
            return $result;
        }else{
            return '';
        }
    }

    public function getCargoDefault($uid=''){
        if (!$uid) return false;

        //调用默认货物类型
        $this->load->model('ReadGoodsType_model');
        $goods_type=$this->ReadGoodsType_model->getUserGoodsType($uid);

        $sql="SELECT * FROM hz_cargo WHERE shipper_id={$uid} ORDER BY id DESC limit 1";
        $query=$this->cargo->query($sql);

        $result=[];
        if(!empty($query->result())){
            foreach ($query->result() as $row) {
                $arr['send_user_mobile']=$row->send_user_mobile;
                $arr['send_user_name']=$row->send_user_name;
                $arr['send_address']=$row->send_address;


                $arr['receive_address']=$row->receive_address;
                $arr['receive_user_mobile']=$row->receive_user_mobile;
                $arr['receive_user_name']=$row->receive_user_name;

                $arr['goods_type_default']=$goods_type;
                $result=$arr;
            }
            return $result;
        }else{
            return '';
        }
    }

}
 ?>