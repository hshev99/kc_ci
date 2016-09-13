<?php

/**
 * Created by PhpStorm.
 * User: hshev99
 * Date: 16/6/12
 * Time: 上午10:52
 */
class User_info_model extends CI_Model
{
    public $orders;
    public $id;
    public $name;
    public $logo_class;
    public $price;
    public $company;
    public $unit;
    public $type;
    public $nick;
    public $img;
    public $verify;

    public $v_img;
    public $v_url;

    public $m_img;
    public $m_url;

    public $baike_url;

    public function __construct()
    {
        parent::__construct();
    }

    public function get_user_back($phone){
        $this->user=$this->load->database('user',TRUE);
        $sql_phone_id="SELECT id FROM user_login WHERE phone='$phone'";
        $query=$this->user->query($sql_phone_id);
        foreach ($query->result() as $val) {
            $id=$val->id;
        }
        return $id;
    }

    public function get_user_REGISTRATION_ID($uid=''){
        if (!$uid) return '';
        $this->user=$this->load->database('user',true);
        $query = $this->user->query("select REGISTRATION_ID from user_login where id={$uid}");
        $phone='';
        if (!empty($query)) foreach ($query->result() as $row){
            $REGISTRATION_ID=$row->REGISTRATION_ID;
        }
        return $REGISTRATION_ID;
    }

    public function user_login_uid($user_login){
        $verify=$user_login['user_login']['verify'];
        if($verify==0){
            return 0;
        }else if($verify==1){
            return 1;
        }
        // $this->user=$this->load->database('user',TRUE);
        // $sql_phone_id="SELECT id FROM user_info WHERE verify='$verify'";
    }

    public function get_user_info_total($uid=null,$page=1,$l=12,$where_data=[]){
         return ceil($this->get_user_info($uid,$page,$l,$where_data,1)/$l);
    }

    public function get_user_accompanying($uid=null){
        $this->user=$this->load->database('user',true);
        $sql="select * from user_info where uid=$uid";
        $query = $this->user->query($sql);
        $data=[];
        if (!empty($query->result()))foreach ($query->result() as $row) {
            $data['accompanying'] = is_null($row->accompanying) ? '' : $row->accompanying;
        }
        return $data;

    }
    public function get_user_info($uid=null,$page=1,$l=12,$where_data=[],$total=0)
    {
            $type=[
                1=>'游客',
                2=>'注册未认证',
                3=>'注册已认证',
                4=>'企业认证',
                5=>'经纪人',
                6=>'经纪公司',
                7=>'歌手',
                8=>'旗下歌手',
            ];

            $style=[
                1=>'流行',
                2=>'R&B',
                3=>'摇滚',
                4=>'古典',
                5=>'舞曲',
                6=>'民谣',
                7=>'中国风'
            ];

            $price=[
                1=>[
                    'min'=>0,
                    'max'=>5,
                ],
                2=>[
                    'min'=>5,
                    'max'=>10,
                ],
                3=>[
                    'min'=>10,
                    'max'=>20
                ],
                4=>[
                    'min'=>20,
                    'max'=>50,
                ],
                5=>[
                    'min'=>50,
                    'max'=>100,
                ],
                6=>[
                    'min'=>100,
                    'max'=>10000
                ]
            ];
            $this->user=$this->load->database('user',true);

            $where='1';
            $where .=" and del=0";
            $where .=" and verify=1";
            $where .=" and type in (7,8)";

            $order =" order by sort ASC ";

            if (isset($where_data['gender']) && $where_data['gender']=='') unset($where_data['gender']);
            if (isset($where_data['gender']) && $where_data['gender'] < 0) unset($where_data['gender']);

            //拼接where 条件查询
            if (!empty($where_data)){
                if(!empty($where_data['style'])){
                    ($where_data['style'] < 0) ? '':$where .= " and style like '%{$style[$where_data['style']]}%'";
                }

                if (isset($where_data['gender'])){
                    $where .= ' and gender=' .$where_data['gender'];
                }


                if (isset($where_data['price'])){
                    $where .= ' and price >=' .$price[$where_data['price']]['min'];
                    $where .= ' and price <' .$price[$where_data['price']]['max'];
                }

            }
            if ($total){
                $sql_count="select count(1) as total from user_info WHERE $where ";
                $query = $this->user->query($sql_count);

                $total=0;
                foreach ($query->result() as $row){
                    $total=$row->total;
                }
                return $total;
            }
            if($uid){
                $sql="select * from user_info where uid=$uid";
            }else{
                $limit=$l*($page-1).','.$l;
                $sql="select * from user_info WHERE $where $order limit $limit";
            }
            $query = $this->user->query($sql);

            $data=[];$i=0;
            foreach ($query->result() as $row)
            {
                if($uid){
                    $data['uid']=$uid;
                    $data['name']=$row->name;
                    $data['type']=$row->type;
                    $data['style']=empty($row->style)? [] : unserialize($row->style);
                    $data['price']=$row->price == 0 ? '':$row->price;

                    $data['company']=$row->company;
                    $data['accompanying']=$row->accompanying;
                    $data['type']=$row->type;
                    $data['nick']=$row->nick;
                    $data['img']=empty($row->img) ? 'http://123.57.56.133:90/ce24bbd6aac1d7476ae7c8c5d913019f.jpg' :$row->img;
                    $data['verify']=$row->verify;
                    $data['about_price']=$row->about_price ==0 ? '':$row->about_price;
                    $data['history_price']=$row->history_price ==0 ? '' :$row->history_price;
                    $data['special']=is_null($row->special) ? '':$row->special;
                    $data['phone']=$row->phone;
                    $data['home']=$row->home;
                    $data['email']=$row->email;
                    $data['other']=$row->other;
                }else{
                    $data[$i]['uid']=$row->uid;
                    $data[$i]['name']=$row->name;
                    $data[$i]['type']=$row->type;
                    $data[$i]['style']=empty($row->style)? [] :  unserialize($row->style);
                    $data[$i]['price']=$row->price == 0 ? '':$row->price ;

                    $data[$i]['company']=$row->company;
                    $data[$i]['type']=$row->type;
                    $data[$i]['nick']=$row->nick;
                    $data[$i]['img']=empty($row->img) ? '' : $row->img;
                    $data[$i]['img_380']=empty($row->img_380) ? '' : $row->img_380;
                    $data[$i]['verify']=$row->verify;
                    $data[$i]['about_price']=$row->about_price == 0 ? '' : $row->about_price;
                    $data[$i]['history_price']=$row->history_price == 0 ? '' : $row->history_price;
                    $data[$i]['special']=is_null($row->special) ? '':$row->special;
                }
                $i++;
            }
            // var_dump($data);die;
        return $data;
    }

    public function get_user_phone($uid=null){
        if (!$uid) return '';
        $this->user=$this->load->database('user',true);
        $query = $this->user->query("select * from user_login where id={$uid}");
        $phone='';
        if (!empty($query)) foreach ($query->result() as $row){
            $phone=$row->phone;
        }
        return $phone;

    }
    public function get_user_img($uid=null){
        if (!$uid) return '';
        $this->user=$this->load->database('user',true);
        $query = $this->user->query("select * from user_img where uid=$uid");

            $data=[];
            if (!empty($query->result()))foreach ($query->result() as $row)
            {
                $data[]['url']=$row->img;
            }


        return $data;
    }

    public function introduce($uid=null){
        if (!$uid) return '';


        $this->user=$this->load->database('user',true);

        //用户百科地址
        $query = $this->user->query("select * from user_works_baike where uid=$uid");
        $data=[];
        if (!empty($query->result())){
            foreach ($query->result() as $row){
                $data['baike_url']=$row->url;
            }
        }else{
            $data['baike_url']='';
        }

        //用户音乐
        $query = $this->user->query("select * from user_works_music where uid=$uid");
        $i=0;
        $amp='&amp;';
        if (!empty($query->result())){foreach ($query->result() as $row){
            $data['music'][$i]['img']=$row->m_img;
            if(strpos($row->m_url,$amp)){
                $m_url_amp=str_replace("&amp;","&",$row->m_url);
                $data['music'][$i]['url']=$m_url_amp;
            }else{
                $data['music'][$i]['url']=$row->m_url;
            }
            $data['music'][$i]['name']=$row->m_name;
            $i++;
            }
        }else{
            $data['music']=[];
        }
        //用户视频作品
        $query = $this->user->query("select * from user_works_video where uid=$uid");
        $i=0;
        $amp='&amp;';
        if (!empty($query->result())){foreach ($query->result() as $row){
            $data['video'][$i]['img']=$row->v_img;

            if(strpos($row->v_url,$amp)){

                $v_url_amp=str_replace("&amp;","&",$row->v_url);
                $data['video'][$i]['url']=$v_url_amp;
            }else{
                $data['video'][$i]['url']=$row->v_url;
            }

            $data['video'][$i]['name']=$row->v_title;
            $i++;
            }
        }else{
            $data['video']=[];
        }

        return $data;

    }

    public function introduce_music($uid=null){
        if (!$uid) return '';


        $this->user=$this->load->database('user',true);

        //用户头像
        $query_img=$this->user->query("select img from user_info where uid=$uid");
        $img='';
        if (!empty($query_img->result())) foreach ($query_img->result() as $row){
            $img=$row->img;
        }

        //用户音乐
        $query = $this->user->query("select * from user_works_music where uid=$uid");
        $i=0;
        $amp='&amp;';
        if (!empty($query->result())){
            foreach ($query->result() as $row){
                $data['music'][$i]['img']=$img;
                
            if(strpos($row->m_url,$amp)){

                $m_url_amp=str_replace("&amp;","&",$row->m_url);
                $data['music'][$i]['url']=$m_url_amp;
            }else{
                $data['music'][$i]['url']=$row->m_url;
            }
                
                $data['music'][$i]['name']=$row->m_name;
                $data['music'][$i]['author']=$row->m_author;
                $i++;
            }
        }else{
            $data['music']=[];
        }

        return $data;

    }

    public function introduce_video($uid=null){
        if (!$uid) return '';


        $this->user=$this->load->database('user',true);
        //用户视频作品
        $query = $this->user->query("select * from user_works_video where uid=$uid");
        $i=0;
        $amp='&amp;';
        if (!empty($query->result())){
            foreach ($query->result() as $row){
                $data['video'][$i]['img']=$row->v_img;

            if(strpos($row->v_url,$amp)){

                $v_url_amp=str_replace("&amp;","&",$row->v_url);
                $data['video'][$i]['url']=$v_url_amp;
            }else{
                $data['video'][$i]['url']=$row->v_url;
            }

                $data['video'][$i]['title']=$row->v_title;
                $i++;
            }
        }else{
            $data['video']=[];
        }

        return $data;

    }

    //可预约档期
    public function on_date_defult($uid=null){
        if (!$uid) return [];
        $arr=[];
        $this->orders=$this->load->database('orders',true);
        for ($i=0;$i<7;$i++){
            $sdefaultDate = date("Y-m-d",time());
            if($i >0 ) $sdefaultDate=date('Y-m-d',strtotime("$sdefaultDate +$i days"));

            $data=date('Y-m-d',strtotime("$sdefaultDate"));
            //用户百科地址

            $query = $this->orders->query("select * from hl_orders.user_order_date WHERE uid=$uid AND `date`='$data'");

            if (!empty($query->result())){
                $f='T';
            }else{
                $f='F';
            }

            $arr[]=[
                'week'=> mb_substr( "日一二三四五六",date("w",strtotime($sdefaultDate)),1,"utf-8" ),
                'status'=>$f,
                'date'=>strval((int)substr(date('Y-m-d',strtotime("$sdefaultDate")),-2,2))
            ];
        }
        return $arr;
    }

    //评价
    public function evaluation_defult($uid=null){
        $this->orders=$this->load->database('orders',true);
        $query=$this->orders->query("select sum(1) score from hl_orders.user_order_eval WHERE uid=$uid");
        if(null != $query->row()){
            foreach ($query->row() as $row){
                $score=$row;
            }

            $query=$this->orders->query("select AVG(score) score from hl_orders.user_order_eval WHERE uid=$uid");
            foreach ($query->row() as $row){
                $avg=number_format($row,1);
            }

            $query=$this->orders->query("select *  from hl_orders.user_order_eval WHERE uid=$uid limit 4");
            $other=[];$i=0;
            foreach ($query->result() as $row){
               $other[$i]['score']=$row->score;
               $other[$i]['name']=$row->eval_name;
               $other[$i]['details']=$row->note;
               $other[$i]['create_time']=substr($row->create_time,0,10);
                $i++;
            }
        };
        $arr=[
            'sum'=>"$score",
            'avg'=>"$avg",
            'other'=>$other,
        ];

        return $arr;
        exit(json_encode($this->output($arr),true));
    }

    //全部评价
    //评价
    public function evaluation_other($uid=null,$page=1){
        if (!$uid) return '';
        $this->orders=$this->load->database('orders',true);

        $limit=(($page-1)*10) .','. ($page*10);
        $query=$this->orders->query("select *  from hl_orders.user_order_eval WHERE uid=$uid limit $limit");
        $other=[];$i=0;
        foreach ($query->result() as $row){
            $other[$i]['score']=$row->score;
            $other[$i]['name']=$row->eval_name;
            $other[$i]['details']=$row->note;
            $other[$i]['create_time']=substr($row->create_time,0,10);
            $i++;
        }
        return $other;
    }


    //插入用户信息 添加歌手
    public function add_user_info($data){
        if (!empty($data)){
            $this->user=$this->load->database('user',true);
            $this->user->insert('user_info',$data);
        }

        return '';
    }

    //查询歌手风格
    public function style_user_conf($conf_style){
        $this->db=$this->load->database('conf',true);
        foreach ($conf_style as $k => $val) {
            $name=$val;
            $style_sql="SELECT * FROM user_style WHERE name='$name'";
            $query=$this->db->query($style_sql);
            foreach ($query->result() as $val) {
                $arr=get_object_vars($val);
            }
            $val_arr[]=$arr;
        }
            return $val_arr;die;
    }

    //更新用户信息
    public function update_user_info($uid,$data=[]){
        $where = "uid => ".$uid;
        
        $this->user=$this->load->database('user',true);

        $bool=$this->user->update('user_info', $data, array('uid'=>$uid));
    }

}