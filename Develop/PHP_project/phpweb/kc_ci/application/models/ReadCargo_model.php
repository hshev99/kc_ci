<?php 
class ReadCargo_model extends CI_Model
{
	public function __construct()
    {
        parent::__construct();
    }

    public function getCargo($admin_id=''){
        if (!$admin_id) return false;
        $this->cargo = $this->load->database('cargo',TRUE);

        $sql="SELECT * FROM hz_cargo WHERE shipper_id={$admin_id} ";
        $query=$this->cargo->query($sql);

        $result='';
        if(!empty($query->result())){
            foreach ($query->result() as $row) {
                $result['shipper_id']=$row->shipper_id;
                $result['send_user_mobile']=$row->send_user_mobile;
                $result['send_user_name']=$row->send_user_name;
                $result['send_address']=$row->send_address;


                $result['receive_address']=$row->receive_address;
                $result['receive_user_mobile']=$row->receive_user_mobile;
                $result['receive_user_name']=$row->receive_user_name;

                $result['cargo_name']=$row->cargo_name;
                $result['cargo_weight']=$row->cargo_weight;
                $result['expect_price']=$row->expect_price;
                $result['start_time']=$row->start_time;
                $result['end_time']=$row->end_time;
                $result['status']=$row->status;
                $result['remark']=$row->remark;
                $result['create_time']=$row->create_time;
                $result['update_time']=$row->update_time;


            }
            return $result;
        }else{
            return '';
        }
    }

}
 ?>