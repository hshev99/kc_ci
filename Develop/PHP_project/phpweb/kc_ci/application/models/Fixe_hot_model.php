<?php 
class Fixe_hot_model extends CI_Model 
{
	public function __construct()
    {
        parent::__construct();
    }

    public function fixe_Hot(){
    	$DB_default = $this->load->database('user',TRUE);
    	$sql="SELECT uid,name FROM user_search_hot ORDER BY weight DESC limit 10";
		$query=$DB_default->query($sql);
        if(!empty($query->result())){
            foreach ($query->result() as $key => $val) {
                $fixe_hot[$key]=get_object_vars($val);
                $fixe_hot[$key]['sort']=$key+1;
            }
            return $fixe_hot;
        }else{
            return '';
        }
    }
    public function activity($data){
        $this->user=$this->load->database('user',TRUE);

        $this->user->where('uid',$data['uid']);
        $this->user->where('activity_time',$data['activity_time']);
        $this->user->where('activity_site',$data['activity_site']);
        $this->user->where('del','0');

        $this->user->select();

        $query=$this->user->get('user_activity');

        if(empty($query->result())){
            $user_activity=$this->user->insert('user_activity',$data);
            if($user_activity){
                return 1;die;
            }else{
                return 2;die;
            }
        }else{
            return 3;die;
        }
    }
    public function del_activity($data){

        $this->user=$this->load->database('user',TRUE);

        $this->user->where('uid',$data['uid']);
        $this->user->where('activity_time',$data['activity_time']);
        $this->user->where('activity_site',$data['activity_site']);
        $this->user->where('del','0');

        $this->user->select();

        $query=$this->user->get('user_activity');

        if(!empty($query->result())){
            $arr['del']=1;
            $this->user->where('uid',$data['uid']);
            $this->user->where('activity_time',$data['activity_time']);
            $this->user->where('activity_site',$data['activity_site']);
            $user_activity=$this->user->update('user_activity',$arr);
            if($user_activity){
                return 1;die;
            }else{
                return 3;die;
            }
        }else{
           return 2;die;
        }
    }
    public function upload_activipy($data){

        $this->user=$this->load->database('user',TRUE);

        $this->user->where('uid',$data['uid']);
        $this->user->where('activity_time',$data['activity_time']);
        $this->user->where('activity_site',$data['activity_site']);
        $this->user->where('del','0');

        $this->user->select();

        $query=$this->user->get('user_activity');
        if(!empty($query->result())){
            foreach ($query->result() as $val) {
                $id=$val->id;
            }
            $arr=array(
                'activity_time'=>$data['new_activity_time'],
                'activity_site'=>$data['new_activity_site'],
                );
            // var_dump($arr);die;
            $this->user->where('id',$id); //uid 数据库中自增id ，$id 控制器中传入id

            $user_activity=$this->user->update('user_activity',$arr);//表名字 传入数组
            if($user_activity){
                return 1;die;
            }else{
                return 2;die;
            }
        }else{
            return 3;die;
        }
    }
    public function select_activipy($data){
        $this->user=$this->load->database('user',TRUE);
        $this->user->where('uid',$data['uid']);
        $this->user->where('del','0');
        $this->user->order_by('activity_time', 'DESC');
        $this->user->select();
        $query=$this->user->get('user_activity');

        $this->user->where('uid',$data['uid']);
        $this->user->where('del','0');
        $this->user->select();
        $user_info_query=$this->user->get('user_info');
        $arr=[];
        foreach ($user_info_query->result() as $value) {
            $arr['img']=$value->img;
        }
        // var_dump($query->result());die;
        $array=[];$i=0;
        foreach ($query->result() as $val) {
            $array[$i]['activity_time']=date('Y年m月d日',strtotime($val->activity_time));
            $array[$i]['activity_site']=$val->activity_site;
            $i++;
        }
        $arr['record']=$array;
        // var_dump($arr);die;
        return $arr;

    }
}
 ?>