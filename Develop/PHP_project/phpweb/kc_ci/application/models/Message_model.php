<?php 
class Message_model extends CI_Model
{
	public function __construct()
    {
        parent::__construct();
    }

    public function get_user_message($uid=''){
        $this->user=$this->load->database('user',true);
        $sql="select * from user_message WHERE uid='{$uid}'";
        $query=$this->user->query($sql);
        $arr=[];
        if (!empty($query->result())){
            $i=0;
            foreach ($query->result() as $row){
                $arr[$i]['title']=$row->title;
                $arr[$i]['time']=$row->time;
                $arr[$i]['content']=unserialize($row->content);
                $i++;
            }
        }else{
            $arr=[];
        }

        $data['message']=$arr;
        return $data;
    }

    public function set_user_message($uid='',$title='',$data=[]){
        $data=serialize($data);
        $this->user=$this->load->database('user',true);
        $sql="insert into user_message 
                SET uid={$uid},
                    title='{$title}',
                    `date`=now(),
                    content='{$data}'
                    ";
        
        $this->user->query($sql);

        
    }

}
 ?>