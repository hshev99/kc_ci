<?php 
class WriteCargoPrice_model extends CI_Model
{
	public function __construct()
    {
        parent::__construct();

        $this->cargo = $this->load->database('cargo',TRUE);
    }

    public function agreeCargoPriceOrder($cargo_price_id,$cargo_expect_price='',$cargo_ton_count=''){

        if (!$cargo_price_id) return false;

        if ($cargo_expect_price || $cargo_expect_price){
            $set =' status =4 ';
            if ($cargo_expect_price)$set .=" , deal_expect_price={$cargo_expect_price}";
            if ($cargo_ton_count) $set .=" , deal_ton_count={$cargo_ton_count}";
        }else{
            $set =' status =2 ';
        }


        $sql="update hz_cargo_price set $set WHERE id={$cargo_price_id}";
        $query=$this->cargo->query($sql);

        if ($query){
            return true;
        }else{
            return false;
        }
    }
    

}
 ?>