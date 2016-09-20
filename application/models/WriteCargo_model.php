<?php 
class ReadCargo_model extends CI_Model
{
	public function __construct()
    {
        parent::__construct();

        $this->cargo = $this->load->database('cargo',TRUE);
    }

    public function setCargo($admin_id=''){
        if (!$admin_id) return false;


        

        $sql="SELECT * FROM hz_cargo WHERE shipper_id={$admin_id} ";
        $query=$this->cargo->query($sql);

        $result=[];
        if(!empty($query->result())){
            foreach ($query->result() as $row) {
                $arr['shipper_id']=$row->shipper_id;
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

}
 ?>