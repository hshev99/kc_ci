<?php

/**
 * Created by PhpStorm.
 * User: hshev99
 * Date: 16/6/12
 * Time: 下午5:15
 */
class Img extends CI_Controller
{
    public $uid;
    public function __construct()
    {
        parent::__construct();
        $this->uid=$this->input->get('uid');
        if (!$this->uid) $this->uid=$this->input->post('uid');
        $this->load->helper(array('form', 'url'));
        ini_set('max_execution_time',864000);
    }

    public function index($img=null)
    {
        header( "Content-type: image/jpeg");
        $PSize = filesize("/fire/uploade/$img");
        $picturedata = fread(fopen("/fire/phpweb/img/uploade/$img", "r"), $PSize);
        echo $picturedata;
exit();
        echo 'http://www.fire.com/fire/uploade/f55e4843bfb5624511f6682e211f2737.gif';exit();
    }

    public function do_upload()
    {
        $config['upload_path']      = '/fire/phpweb/img/uploade';
        $config['allowed_types']    = 'gif|jpg|png|jpeg|doc|psd';
        $config['max_size']     = 0;
        $config['max_width']        = 0;
        $config['max_height']       = 0;
        $config['file_name']       = md5(time().rand(10000,99999));

        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('userfile'))
        {
            $error = array('error' => $this->upload->display_errors());

            exit(json_encode($this->output([],'error','101',$error['error'])));

        }
        else
        {
            $data = array('upload_data' => $this->upload->data());
            $arr=[];
            $arr['img']="http://123.57.56.133:90/".$data['upload_data']['orig_name'];//echo '<pre>';print_r($arr);echo '</pre>';exit();
            exit(json_encode(parent::output($arr)));
        }
    }

    public function upload(){
        $config['upload_path']      = '/fire/phpweb/img/uploade';
        $config['allowed_types']    = 'gif|jpg|png|jpeg|doc|psd';
        $config['max_size']     = 0;
        $config['max_width']        = 0;
        $config['max_height']       = 0;
        $config['file_name']       = md5(time().rand(10000,99999));

        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('userfile'))
        {
            $error = array('error' => $this->upload->display_errors());

            return $error;

        }
        else
        {
            $data = array('upload_data' => $this->upload->data());

            $img="http://123.57.56.133:90/".$data['upload_data']['orig_name'];

            return $img;
        }
    }
    //上传头像接口
    public function portrait(){

        $arr=$this->upload();
        //保存头像
        $this->load->model("User_info_model");
        $this->User_info_model->update_user_info($this->uid,['img'=>$arr]);
        $arr=[
                'message'=>"头像修改成功",
                'img'=>$arr
        ];

        exit(json_encode(parent::output($arr)));
    }

    public function portrait_380(){

        $arr=$this->upload();
        //保存头像
        $this->load->model("User_info_model");
        $this->User_info_model->update_user_info($this->uid,['img_380'=>$arr]);
        $arr=[
            'message'=>"头像修改成功",
            'img_380'=>$arr
        ];

        exit(json_encode(parent::output($arr)));
    }

}