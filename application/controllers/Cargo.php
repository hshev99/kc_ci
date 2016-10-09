<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cargo extends CI_Controller {

	public $user_login;
	public $uid;

	public function __construct()
	{
		parent::__construct();

		//判断是否登录
	}


	//发货操作
	public function setCargo(){
		//发货地址

		$data=json_decode(parent::get_json(),true);

		//添加 用户信息  订单号
		$data['shipper_id']=$this->uid;
		$data['cargo_sn']='MJ'.date("ymdHis").rand(1,9);

		$this->load->model('WriteCargo_model');

		if (isset($data['token'])) unset($data['token']);


		$result=$this->WriteCargo_model->setCargo($data,$this->user_name);

		if ($result){
			$arr=[
				'msg'=>'提交成功'
			];
			parent::outPutEnd($arr);
		}else{
			parent::outPutEnd([],201,'提交失败');
		}
	}
	/*
	 * @content 发货列表
	 * @time 20160919
	 *
	 * */
	public function getCargoList(){

		$data=json_decode(parent::get_json(),true);


		$status=isset($data['status'])&&!empty($data['status']) ? $data['status'] : 0;
		$page=isset($data['page'])&&!empty($data['page']) ? $data['page'] : 1;
		$l=isset($data['limit'])&&!empty($data['limit']) ? $data['limit'] : 12;

		$xls=isset($data['xls'])&&!empty($data['xls']) ? $data['xls'] : 'N';

		$search=[
			'cargo_sn'=>isset($data['cargo_sn'])&&!empty($data['cargo_sn']) ? $data['cargo_sn'] : false,
			'send_address'=>isset($data['send_address'])&&!empty($data['send_address']) ? $data['send_address'] : false,
			'receive_address'=>isset($data['receive_address'])&&!empty($data['receive_address']) ? $data['receive_address'] : false,
			'start_time'=>isset($data['start_time'])&&!empty($data['start_time']) ? $data['start_time'] : false,
			'end_time'=>isset($data['end_time'])&&!empty($data['end_time']) ? $data['end_time'] : false,
		];

		$this->load->model('ReadCargo_model');
		$result=$this->ReadCargo_model->getCargo($this->uid,$status,$page,$l,$search);



		if ($xls == "Y") $result['page']['xls']=self::xls($result);

		if (!$result){
			parent::outPutEnd([],109,'暂无数据');
		}else{
			parent::outPutEnd($result);
		}
	}

	public function xls($data=[]){
		//文件请求
//$this->pr($data['result']);

		$data=$data['result'];
		require_once PHPEXCEL_ROOT.'PHPExcel.php';
		$objPHPExcel = new PHPExcel();

		$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);



		$objPHPExcel->setActiveSheetIndex(0); //切换到新创建的工作表
		$objPHPExcel->getActiveSheet()->setTitle('CargoList'.date('Y-m-d',time())); //设置工作表名称


		$page=1;
		$AZ=range('A','Z');

		$objPHPExcel->getActiveSheet()->setCellValue("$AZ[0]".$page, '序号');
		$objPHPExcel->getActiveSheet()->setCellValue("$AZ[1]".$page, '货单号');
		$objPHPExcel->getActiveSheet()->setCellValue("$AZ[2]".$page, '发货地');
		$objPHPExcel->getActiveSheet()->setCellValue("$AZ[3]".$page, '收货地');
		$objPHPExcel->getActiveSheet()->setCellValue("$AZ[4]".$page, '发货日期');
		$objPHPExcel->getActiveSheet()->setCellValue("$AZ[5]".$page, '发货信息');
		$objPHPExcel->getActiveSheet()->setCellValue("$AZ[6]".$page, '状态');
// 		pr($data);exit();

		$i=1;$page++;$money_num ='';
		foreach ($data as $key=>$val)
		{
				$objPHPExcel->getActiveSheet()->setCellValue("$AZ[0]".$page, $i);

				$objPHPExcel->getActiveSheet()->setCellValue("$AZ[1]".$page, $val['cargo_sn']);

				$objPHPExcel->getActiveSheet()->setCellValue("$AZ[2]".$page, $val['send_address']);
				$objPHPExcel->getActiveSheet()->setCellValue("$AZ[3]".$page, $val['receive_address']);
				$objPHPExcel->getActiveSheet()->setCellValue("$AZ[4]".$page, $val['start_time'].'-'.$val['end_time']);
				$objPHPExcel->getActiveSheet()->setCellValue("$AZ[5]".$page, $val['cargo_detail_name'].'-'.$val['cargo_detail_weight']);
				$objPHPExcel->getActiveSheet()->setCellValue("$AZ[6]".$page, 1);
				$page++;$i++;

		}
//		$objPHPExcel->getActiveSheet()->setCellValue("$AZ[9]".$page,'合计:'.$money_num);
		//EXECL 设置部分
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);

		/*
		header("Pragma: public");
		header("Expires: 0");
		header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
		header("Content-Type:application/force-download");
		header("Content-Type:application/vnd.ms-execl");
		header("Content-Type:application/octet-stream");
		header("Content-Type:application/download");header("Content-type:application/vnd.ms-excel;charset=UTF-8");
		header('Content-Disposition:attachment;filename="CargoList-'.date('Ymd',time()).'.xls"');
		header("Content-Transfer-Encoding:binary");
		*/
		/*
		$objWriteHTML = new PHPExcel_Writer_HTML($objPHPExcel);

//		exit;
		$a=$objWriteHTML->save('php://output');
exit;
		*/
		$file_path=APPPATH."xls/";
		if(!is_file($file_path)) @mkdir($file_path,0777);

		$file_name=date("YmdHis").".xlsx";

		$file=$file_path.$file_name;
		$fileName = iconv("utf-8", "gb2312", $file);
		$objWriter->save($fileName);

		return 'xls/'.$file_name;

		exit;
		exit;
		echo $a;exit;
		$this->pr($a);
		exit();


		$this->pr($objPHPExcel);
	}

	/*
	 * @content 获取默认信息
	 * @time 20160920
	 *
	 * **/
	public function getCargoDefault(){

		$this->load->model('ReadCargo_model');
		$result=$this->ReadCargo_model->getCargoDefault($this->uid);

		if (!$result){
			parent::outPutEnd([],201,'暂无默认货物数据');
		}else{
			parent::outPutEnd($result);
		}
	}

	/*
	 * @content
	 * @time 20160921
	 * **/
	public function getCargoPriceList(){
		$this->load->model('ReadCargoPrice_model');
		$data=json_decode(parent::get_json(),true);

		$cargo_sn=isset($data['cargo_sn'])&&!empty($data['cargo_sn']) ? $data['cargo_sn'] : false;

		if (!$cargo_sn) parent::outPutEnd([],301,'cargo_sn无效');
		$page=isset($data['page'])&&!empty($data['page']) ? $data['page'] : 1;
		$l=isset($data['limit'])&&!empty($data['limit']) ? $data['limit'] : 12;

		$params=[
			'cargo_sn'=>$cargo_sn,
			'page'=>$page,
			'l'=>$l
		];
		$result=$this->ReadCargoPrice_model->getCargoPriceList($this->uid,$params);

		if (!$result){
			parent::outPutEnd([],302,'暂无物流信息');
		}else{
			parent::outPutEnd($result);
		}
	}

	/*
	 * @content 货单详情
	 * **/
	public function getCargoDetail(){
		$data=json_decode(parent::get_json(),true);
		$cargo_sn = isset($data['cargo_sn']) ? $data['cargo_sn'] : '';

		if (!$cargo_sn) parent::outPutEnd([],606,'未检测到sn');

		$this->load->model('ReadCargo_model');
		$result=$this->ReadCargo_model->getCargoDetail($cargo_sn);

		parent::outPutEnd($result);
		$this->pr($result);
	}

	/*
	 * @content 预下单信息
	 * @time 0926
	 * **/
	public function getCargoOrder(){
		$data=json_decode(parent::get_json(),true);
		$cargo_sn = isset($data['cargo_sn']) ? $data['cargo_sn'] : '';
		$cargo_price_id = isset($data['cargo_price_id']) ? $data['cargo_price_id'] : '';

		if (!$cargo_sn || !$cargo_price_id) parent::outPutEnd([],608,'参数不正确');

		$this->load->model('ReadCargo_model');
		$result=$this->ReadCargo_model->getCargoOrder($cargo_sn,$cargo_price_id);

		if (!$result){
			parent::outPutEnd([],302,'信息不正确');
		}else{
			parent::outPutEnd($result);
		}

	}

	public function agreeCargoOrder(){
		$data=json_decode(parent::get_json(),true);
		$cargo_sn = isset($data['cargo_sn']) ? $data['cargo_sn'] : '';
		$cargo_price_id = isset($data['cargo_price_id']) ? $data['cargo_price_id'] : '';

		$cargo_expect_price = isset($data['cargo_expect_price']) ? (float)$data['cargo_expect_price'] : '';
		$cargo_ton_count = isset($data['cargo_ton_count']) ? (float)$data['cargo_ton_count'] : '';

		if (!$cargo_sn || !$cargo_price_id) parent::outPutEnd([],608,'参数不正确');

		if ($cargo_expect_price || $cargo_ton_count){

			$this->load->model('WriteCargo_model');
			$result=$this->WriteCargo_model->agreeCargoOrder($cargo_sn,$cargo_price_id);


			$this->load->model('WriteCargoPrice_model');
			$result=$this->WriteCargoPrice_model->agreeCargoPriceOrder($cargo_price_id,$cargo_expect_price,$cargo_ton_count);

			if (!$result){
				parent::outPutEnd([],302,'信息不正确');
			}else{
				parent::outPutEnd(['msg'=>'操作成功,等待物流确认','cargo_sn'=>$cargo_sn]);
			}

		}else{


			$this->load->model('WriteCargo_model');
			$result=$this->WriteCargo_model->agreeCargoOrder($cargo_sn,$cargo_price_id);

			$this->load->model('WriteCargoPrice_model');
			$result=$this->WriteCargoPrice_model->agreeCargoPriceOrder($cargo_price_id,$cargo_expect_price,$cargo_ton_count);

			if (!$result){
				parent::outPutEnd([],302,'信息不正确');
			}else{
				parent::outPutEnd(['msg'=>'操作成功','cargo_sn'=>$cargo_sn]);
			}

		}



	}



	public function cancelCargoOrder()
	{
		$data = json_decode(parent::get_json(), true);
		$cargo_sn = isset($data['cargo_sn']) ? $data['cargo_sn'] : '';

		if (!$cargo_sn ) parent::outPutEnd([], 608, '参数不正确');

		$this->load->model('WriteCargo_model');
		$result=$this->WriteCargo_model->cancelCargoOrder($cargo_sn);

		if (!$result){
			parent::outPutEnd([],402,'信息不正确');
		}else{
			parent::outPutEnd(['msg'=>'取消发货操作成功']);
		}

	}
}
