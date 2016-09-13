<?php 
class User_focus_model extends CI_Model 
{
	public function __construct()
    {
        parent::__construct();
        $this->user=$this->load->database('user',true);
    }

    public function Focus_index($uid){
        $sql="select DISTINCT fans from `user_focus` where uid={$uid}";
        $query = $this->user->query($sql);
        $user_focus = $query->result();

        $arr=[];
        if(!empty($user_focus)){
            $j=0;
            foreach ($user_focus as $val) {
                $focus_user=get_object_vars($val);

                if (!empty($focus_user)){

                    $arr[$j]['uid']=$focus_user['fans'];
                    $user_info=$this->user->query("select * from user_info WHERE uid={$focus_user['fans']}");

                    foreach ($user_info->result() as $row){
                        $arr[$j]['name']=$row->name;
                        $arr[$j]['nick']=$row->nick;
                        $arr[$j]['price']=$row->price;
                        $arr[$j]['style']=empty($row->style)? [] : unserialize($row->style);
                        $arr[$j]['history_price']=$row->history_price;
                        $arr[$j]['img']=$row->img;
                    }
                    $j++;
                }

            }
        }
        return $arr;
    }

    //添加用户收藏
    public function save_fans($data){
        $sql="select * from user_focus WHERE uid={$data['uid']} AND fans={$data['fans']}";
        $query=$this->user->query($sql);


        if (empty($query->result())){
            $this->user->insert('user_focus',$data);
            $arr="收藏成功";
        }else{
            $sql="delete from user_focus WHERE uid={$data['uid']} AND fans={$data['fans']}";
            $this->user->query($sql);
            $arr="取消收藏成功";
        }

        return $arr;
    }

    //删除用户收藏
    public function del_fans($data){
        if (!empty($data)){
            $sql="delete from user_focus WHERE uid={$data['uid']} AND fans={$data['fans']}";
            $this->user->query($sql);
        }

        return '取消收藏成功';
    }

    //查看用户是否收藏
    public function see_fans($data=[]){

        $sql="select * from user_focus WHERE uid={$data['uid']} AND fans={$data['fans']}";
        $query=$this->user->query($sql);


        if (!empty($query->result())){
            $this->user->insert('user_focus',$data);
            $arr="T";
        }else{
            $arr="F";
        }
        return $arr;
    }
}