<?php

/**
 * Created by PhpStorm.
 * User: hshev99
 * Date: 16/6/13
 * Time: 下午4:12
 */
class Login extends CI_Controller
{
    public $uid;public $phone;public $password;

    public function __construct()
    {
        parent::__construct();

        $this->uid=$this->input->get('uid');
        $this->phone=$this->input->post('phone');
        if (!$this->phone) $this->phone=$this->input->get('phone');
        $this->password=$this->input->post('password');
        $this->base_url = $this->config->item('base_url');
    }
    public function login_add_web(){


        $this->load->view('/Login/login_add',array('base_url'=>$this->base_url));
    }
    //ios注册
    public function login_save_web(){
        $this->phone=$this->input->post('phone');
        $this->password=md5(md5($this->input->post('password').'z'));
        if(empty($this->input->post('type'))){
            $this->type=2;
        }else{
            $this->type=$this->input->post('type');
        }
        $this->web=1;
        $data=$this->save();
    }
    //pc 注册
    public function pc_login_save_web(){
        $this->phone=$this->input->post('phone');
        $this->password=md5(md5($this->input->post('password').'z'));
        if(empty($this->input->post('type'))){
            $this->type=2;
        }else{
            $this->type=$this->input->post('type');
        }
        $this->web=1;
        $data=$this->pcsave();
    }
    public function pcsave(){
        $data=[
            'phone'=>$this->phone,
            'password'=>$this->password,
            'create_time'=>date("Y-m-d H:i:s",time())
        ];
        $type=[
            'type'=>$this->type
        ];

        $this->load->model('Login_model');

        $arr=$this->Login_model->save($data,$type);
        if (empty($arr)){
            if ($this->web) {
                $arrq=[
                    'status'=>0,
                    'errorMsg'=>'',
                    'error'=>'102',
                    'msg'=>'手机号码已注册,请登录',
                    'results'=>[]
                ];
                exit(json_encode($arrq));
            }  
            if ($this->back) {
                echo '第三方用户登录 授权success';die;
                //$this->load->view('/Web/index',array('base_url'=>$this->base_url));die;
            }
        }else{
            if($this->web) {
                $arrq=[
                    'status'=>0,
                    'errorMsg'=>'',
                    'error'=>'0',
                    'msg'=>'注册成功',
                    'results'=>[$arr]
                ];
                //注册成功
                $this->uid=$arr['uid'];
                $this->load->model('User_info_model');
                $user_info=$this->User_info_model->get_user_info($this->uid);

                $_SESSION['user_login']=$user_info;
                exit(json_encode($arrq));
                //exit(json_encode(parent::output($arr)));
            }

            if ($this->back) {
                echo '第三方用户注册 授权success';die;
                //$this->load->view('/Web/index',array('base_url'=>$this->base_url));die;
            }
        }
    }
    //ios  第三方  
    public function third_lib(){
        $this->is_other=1;
        $this->name=$this->input->post('name');//ios 用户名称
        $this->img=$this->input->post('img');//ios 用户头像
        $this->other_id=$this->input->post('other_id');//ios 用户uid
        $this->other=$this->input->post('other');//ios 第三方名称
        $this->unionId=$this->input->post('unionId');//ios 暂时未用到(ios 已传值)
        $data=[
            'is_other'=>$this->is_other,
            'name'=>$this->name,
            'img'=>$this->img,
            'other_id'=>$this->other_id,
            'other'=>$this->other,
            'unionId'=>$this->unionId
        ];
        $this->load->model('Login_model');
        $arr=$this->Login_model->third_lib_model($data);
        
        exit(json_encode(parent::output($arr)));
    }
    //第三方
    public function add(){
        $this->phone=$_SESSION['token']['uid'];
        $this->password=md5(md5($_SESSION['token']['expires_in'].'z'));
        $this->back=1;
        $this->save();
    }
    public function save(){
        $data=[
            'phone'=>$this->phone,
            'password'=>$this->password,
            'create_time'=>date("Y-m-d H:i:s",time())
        ];
        $type=[
            'type'=>$this->type
        ];
        //var_dump($type);die;
        $this->load->model('Login_model');

        $arr=$this->Login_model->save($data,$type);
        if (empty($arr)){
            if ($this->web) {
                $arrq=[
                    'status'=>0,
                    'errorMsg'=>'',
                    'error'=>'102',
                    'msg'=>'手机号码已注册,请登录',
                    'results'=>[]
                ];
                exit(json_encode($arrq));
            }  
            if ($this->back) {
                echo '第三方用户登录 授权success';die;
                //$this->load->view('/Web/index',array('base_url'=>$this->base_url));die;
            }
        }else{
            if($this->web) {
                $arrq=[
                    'status'=>0,
                    'errorMsg'=>'',
                    'error'=>'0',
                    'msg'=>'注册成功',
                    'results'=>[$arr]
                ];
                exit(json_encode($arrq));
                //exit(json_encode(parent::output($arr)));
            }

            if ($this->back) {
                echo '第三方用户注册 授权success';die;
                //$this->load->view('/Web/index',array('base_url'=>$this->base_url));die;
            }
        }
    }
    public function login_in_web(){
        $this->load->view('/Login/login_in',array('base_url'=>$this->base_url));
    }
    //登录
    public function login_check_web(){

        $this->web=1;
        $a=$this->login();
    }
    public function login(){
        $this->phone=$this->input->post('phone');
        $this->password=$this->input->post('password');
        $data=[
            'phone'=>$this->phone,
            'password'=>$this->password
        ];
        $this->load->model('Login_model');
        $model_login=$this->Login_model->login($data);
        if ($model_login==true){
            $this->load->model('User_info_model');
            $user_info=$this->User_info_model->get_user_info($model_login[0]['uid']);
            $_SESSION['user_login']=$user_info;
            parent::web_login_session($model_login[0]['uid']);
            if ($this->web){
                $arrq=[
                    'status'=>0,
                    'errorMsg'=>'',
                    'error'=>'0',
                    'msg'=>'登录成功',
                    'results'=>$model_login
                ];
                exit(json_encode($arrq));
                //exit(json_encode(parent::output($model_login),true));die;
            }else{
                $arr=[
                    'status'=>0,
                    'errorMsg'=>'',
                    'error'=>'202',
                    'msg'=>'账户或密码不正确',
                    'results'=>[]
                ];
                exit(json_encode($arr));die;
            } 
        }else{
            $arr=[
                    'status'=>0,
                    'errorMsg'=>'',
                    'error'=>'202',
                    'msg'=>'账户或密码不正确',
                    'results'=>[]
                ];
                exit(json_encode($arr));die;
        }
    }
    public function login_forget_web(){
        $this->load->view('/Login/login_forget',array('base_url'=>$this->base_url));
    }
    //QQ第三方登录
    public function login_qq(){
        $_POST['appid']='101327073';
        $_POST['appkey']='f0f2ea344c7aa993fb0eeb027b5c4ed8';
        $_POST['callback']='http://www.51huole.cn';
        $arr_scope=array('get_user_info,add_share,list_album,add_album,upload_pic,add_topic,add_one_blog,add_weibo,check_page_fans,add_t,add_pic_t,del_t,get_repost_list,get_info,get_other_info,get_fanslist,get_idolist,add_idol,del_idol,get_tenpay_addr');
        $arr_errorReport='true';
        $_POST['scope'] = implode(",",$arr_scope);
        $_POST['errorReport'] = (boolean) $arr_errorReport;
        $_POST['storageType'] = "file";
        $_POST['host'] = "localhost";
        $_POST['user'] = "root";
        $_POST['password'] = "root";
        $_POST['database'] = "test";
        $setting = json_encode($_POST);
        $setting = str_replace("\/", "/",$setting);
        $incFile = fopen("inc.php","w+",TRUE) or die("请设置\Oauth\comm\inc.php的权限为777");
        if(fwrite($incFile, $setting)){

            $this->load->library('Qc',$setting);

            //拉起第三方
            $qc = new \QC();
            $qc->qq_login();
        }else{
            echo "Error";
        }
    }
    public function Qq_callback(){
            $this->load->library('Qc');
            //回调地址
            $qc = new \QC();
            $token= $qc->qq_callback(); //获取一个token 或者令牌
            $openid= $qc->get_openid(); //获取用户openid 
            echo $token."</br>";
            echo $openid."</br>";
            $qc = new \QC($token,$openid);  //同一个页面 存的session  读取不到 传入参数
            $arr = $qc->get_user_info();  // 获取用户信息
            var_dump($arr);die;
            echo '<meta charset="UTF-8">';
            echo "<p>";
            echo "欢迎".$arr["nickname"]."登录";
            echo "</p>";
    }
    //微博登录
    public function login_lib(){
        $this->load->library('Lib');
    }
    public function Login_callback(){
        $this->load->library('Back');
    }
    //找回密码
    public function login_back_web(){
        $phone=$this->phone;
        $password=md5(md5($this->password.'z'));
        $data=[
            'phone'=>$phone,
            'password'=>$password
        ];

        $this->load->model('Login_model');

        $arr=$this->Login_model->back($data);

        if(empty($arr)){
            $arrq=[
                    'status'=>0,
                    'errorMsg'=>'',
                    'error'=>'102',
                    'msg'=>'手机号码未注册,请先注册',
                    'results'=>[]
                ];
            exit(json_encode($arrq));
        }else{
            $arrq=[
                    'status'=>0,
                    'errorMsg'=>'',
                    'error'=>'101',
                    'msg'=>'密码重置成功',
                    'results'=>[
                        ['phone'=>$arr]
                    ]
                ];
            exit(json_encode($arrq));
        }
    }
    //登录后修改密码
    public function modpwd(){
        $this->uid=$this->input->get('uid');
        $this->used_password=$this->input->post('used_password');
        $this->new_password=$this->input->post('new_password');
        $data = [
            'uid'=>$this->uid,
            'used_password'=>$this->used_password,
            'new_password'=>$this->new_password
        ];
        //var_dump($data);die;
        $this->load->model('Login_model');
        $mod_password=$this->Login_model->mod_password($data);
        //var_dump($mod_password);die;
        if($mod_password==1){
            exit(json_encode(parent::output(['msg'=>'修改成功']),true));die;
            // $this->load->view('/Web/index',array('base_url'=>$this->base_url));die;
        }else if($mod_password=='请输入正确的密码'){
            exit(json_encode(parent::output(['msg'=>'请输入正确的密码']),true));die;
        }else{
            exit(json_encode(parent::output("网络故障,密码修改失败,请重新连接您的网络"),true));die;
        }
    }
    public function index(){
        $check_registered=isset($_GET['check_registered']) ? $_GET['check_registered'] : '';
        if ($check_registered ==1){
            $this->load->model('Login_model');
            if ($this->Login_model->phone($this->phone)){

                exit(json_encode(parent::output([],'failure','101','手机号码已经注册')));
            };
        }

        $params='';
        $params .='&account=cf_huole';
        $params .='&password=360e15816d63e2dd99cbf9a41c018fd5';
        $params .="&mobile=$this->phone";
        $r=rand(1000,9999);
        $params .="&content=您的验证码是：{$r}。请不要把验证码泄露给其他人。如非本人操作，可不用理会！";
        $url = "http://106.ihuyi.cn/webservice/sms.php?method=Submit$params";

        $data=parent::curl_get($url);
        $gets=parent::xml_to_array($data);


        if($gets['SubmitResult']['code']==2){
            $_SESSION['mobile'] = $this->phone;
            $_SESSION['mobile_code'] = $r;
        }else{
            $now=date('Y-m-d H:i:s',time());
            $data=[
                    'phone'=>'213',
                    'code'=>$gets['SubmitResult']['code'],
                    'msg'=>$gets['SubmitResult']['msg'],
                    'create_time'=>"$now"
            ];
            $this->load->model('Login_model');
            $this->Login_model->save_code_msg($data);
            
            exit(json_encode(parent::output([],'failure',$gets['SubmitResult']['code'],$gets['SubmitResult']['msg'])));
        }

        $arr=[
            'phone'=>$this->phone,
            'code'=>"$r"
        ];
        exit(json_encode(parent::output($arr)));


    }
    //用户反馈
    public function lasa(){
        $this->uid=$this->input->get('uid');
        $this->phone_email=$this->input->post('phone_email');
        $this->content=$this->input->post('content');
        $data=array(
            'uid'=>$this->uid,
            'phone_email'=>$this->phone_email,
            'content'=>$this->content
            );
        $this->load->model('Login_model');
        $arr=$this->Login_model->lasa($data);
        exit(json_encode(parent::output($arr),true));die;
    }


    //接口输出
    public function order_outop($arr=[],$res='success',$error=0,$errorMsg=''){
        $arr=[
            'error'=>$error,
            'status'=>$res,
            'errorMsg'=>$errorMsg,
            'results'=>$arr
        ];
        return $arr;
    }

    public function REGISTRATION_ID(){
        $uid=$this->input->post('uid');
        $REGISTRATION_ID=$this->input->post('REGISTRATION_ID');

        $data=['REGISTRATION_ID'=>$REGISTRATION_ID];
        $this->load->model('User_reg_id_model');
        $this->User_reg_id_model->set_user_reg_id($uid,$REGISTRATION_ID);

        $arr=[
            'mag'=>'更新成功'
        ];
        exit(json_encode(parent::output($arr)));
    }
}