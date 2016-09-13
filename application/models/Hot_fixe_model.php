<?php 
class Hot_fixe_model extends CI_Model
{
	public function __construct()
    {
        parent::__construct();
    }
    public function hot_Fixe($name){
        $type=[
                1=>'游客',
                2=>'注册未认证',
                3=>'注册已认证',
                4=>'企业认证',
                5=>'经纪人',
                6=>'经纪公司',
                7=>'歌手',
                8=>'线下歌手',
            ];
    	//搜索name
    	$this->user=$this->load->database('user',TRUE);
        //ci框架模糊查询
        $sql="SELECT * FROM user_info WHERE verify=1 AND name like '%$name%'";
		$query=$this->user->query($sql);

        $data=[];$i=0;
        foreach ($query->result() as $row)
            {
                if($name){
                    $data[$i]['uid']=$row->uid;
                    $data[$i]['name']=$row->name;
                    $data[$i]['style']=empty($row->style)? [] : unserialize($row->style);
                    $data[$i]['price']=$row->price;
                    $data[$i]['history_price']=$row->history_price;
                    $data[$i]['company']=$row->company;
                    $data[$i]['type']=$type[$row->type];
                    $data[$i]['nick']=$row->nick;
                    $data[$i]['img']=$row->img;
                    $data[$i]['verify']=$row->verify;
                    $data[$i]['about_price']=$row->about_price;
                }else{
                    $data[$i]['name']=$row->name;
                    $data[$i]['style']=empty($row->style)? [] : unserialize($row->style);
                    $data[$i]['price']=$row->price;
                    $data[$i]['history_price']=$row->history_price;
                    $data[$i]['company']=$row->company;
                    $data[$i]['type']=$type[$row->type];
                    $data[$i]['nick']=$row->nick;
                    $data[$i]['img']=$row->img;
                    $data[$i]['verify']=$row->verify;
                    $data[$i]['about_price']=$row->about_price;
                }
                $i++;
            }
            // echo 1;
            // var_dump($data);die;
            return $data;
    }
}
 ?>