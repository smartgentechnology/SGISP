<?php
namespace Home\Controller;
use Common\Controller\AuthController;
class FanxiuController extends AuthController {
	
    public function index(){
		$model=D('Fanxiu');
		$queryModel=D('Query');
		//得到用户自定义栏目框
		$manager_id=session('manager_id');
		$columnset=D('Columnset');
		$column=D('Column');
		$columnsetlist=$columnset->where("manager_id='%s' and module=1",$manager_id)->order("rank asc, id asc")->select();
		$columnlist=array();
		$namelist=array();
		$fieldlist=array();
		if(empty($columnsetlist)){
			$columnlist=$column->where("module=1")->order("rank asc")->field("name,field,width")->select();
		}else{
			foreach($columnsetlist as $key=>$value){
				$temp=array();
				$temp=$column->where("id=%d",$value['columnid'])->field("name,field,width")->find();
				$columnlist[]=$temp;
			}
		}
		$width=0;
		foreach($columnlist as $value){
			$arr=array();
			$arr['name']=$value['name'];
			$arr['width']=$value['width'];
			$width+=$value['width'];
			$namelist[]=$arr;
			$fieldlist[]=$value["field"];
		}
		$strfield = implode(",",$fieldlist);
		
		//U8型号表
		$InventoryModel=M('Inventory','dbo.','U8');
		$inventorylist=$InventoryModel->where("cInvCCode like '02%'")->order("cInvStd asc")->field("I_id,cInvName,cInvStd")->select();
		//U8人员
		$PersonModel=M('Person','dbo.','U8');
		$personlist=$PersonModel->where("(cDepCode='602' or cDepCode='603' or cDepCode='604' or cDepCode='606' or cDepCode='607' or cPersonName='崔文玉') and dPInValidDate is null")->field("cPersonCode,cPersonName")->select();
		if(IS_POST){
			$data=I('post.');
			//得到查询条件
			//客户
			$fanxiud_customer_dir=$data['fanxiud_customer_dir'];
			
			//接收日期
			$fanxiud_rdate_dir_start=$data['fanxiud_rdate_dir_start'];
			$fanxiud_rdate_dir_end=$data['fanxiud_rdate_dir_end'];
			/*系列
			$fanxiud_series_dir=$data['fanxiud_series_dir'];
			*/
			//产品
			$fanxiud_product_dir=$data['fanxiud_product_dir'];
			
			//条码
			$fanxiud_barcode_dir=$data['fanxiud_barcode_dir'];
			
			//生产日期
			$fanxiud_pdate_dir_start=$data['fanxiud_pdate_dir_start'];
			$fanxiud_pdate_dir_end=$data['fanxiud_pdate_dir_end'];
			
			//处理结果
			$fanxiud_result_dir=$data['fanxiud_result_dir'];
			
			//不良类型
			$fanxiud_bad_dir=$data['fanxiud_bad_dir'];
			
			//处理状态
			$fanxiud_flag_dir=$data['fanxiud_flag_dir'];
			//产返符号
			$fanxiud_prdate_tag_dir=$data['fanxiud_prdate_tag_dir'];
			//产返数值
			$fanxiud_prdate_number_dir=$data['fanxiud_prdate_number_dir'];
			//现象-过程
			$fanxiud_fault_dir=$data['fanxiud_fault_dir'];
			
			//拼接接收日期
			if(!empty($fanxiud_rdate_dir_start) && !empty($fanxiud_rdate_dir_end)){
				$fanxiud_rdate_dir_end=strtotime($fanxiud_rdate_dir_end)+86400;
				$map=$map." receive_date>=".strtotime($fanxiud_rdate_dir_start)." and receive_date<=".$fanxiud_rdate_dir_end;
			}else if(!empty($fanxiud_rdate_dir_start) && empty($fanxiud_rdate_dir_end)){
				$map=$map." receive_date>=".strtotime($fanxiud_rdate_dir_start);
			}else if(empty($fanxiud_rdate_dir_start) && !empty($fanxiud_rdate_dir_end)){
				$fanxiud_rdate_dir_end=strtotime($fanxiud_rdate_dir_end)+86400;
				$map=$map." receive_date<=".$fanxiud_rdate_dir_end;
			}
			if(empty($fanxiud_rdate_dir_start) && empty($fanxiud_rdate_dir_end)){
				//拼接生产日期
				if(!empty($fanxiud_pdate_dir_start) && !empty($fanxiud_pdate_dir_end)){
					$fanxiud_pdate_dir_end=strtotime($fanxiud_pdate_dir_end)+86400;
					$map=$map."pdate>=".strtotime($fanxiud_pdate_dir_start)." and pdate<=".$fanxiud_pdate_dir_end;
				}else if(!empty($fanxiud_pdate_dir_start) && empty($fanxiud_pdate_dir_end)){
					$map=$map."pdate>=".strtotime($fanxiud_pdate_dir_start);
				}else if(empty($fanxiud_pdate_dir_start) && !empty($fanxiud_pdate_dir_end)){
					$fanxiud_pdate_dir_end=strtotime($fanxiud_pdate_dir_end)+86400;
					$map=$map."pdate<=".$fanxiud_pdate_dir_end;
				}
			}else if(!empty($fanxiud_rdate_dir_start) || !empty($fanxiud_rdate_dir_end)){
				//拼接生产日期
				if(!empty($fanxiud_pdate_dir_start) && !empty($fanxiud_pdate_dir_end)){
					$fanxiud_pdate_dir_end=strtotime($fanxiud_pdate_dir_end)+86400;
					$map=$map." and pdate>=".strtotime($fanxiud_pdate_dir_start)." and pdate<=".$fanxiud_pdate_dir_end;
				}else if(!empty($fanxiud_pdate_dir_start) && empty($fanxiud_pdate_dir_end)){
					$map=$map." and pdate>=".strtotime($fanxiud_pdate_dir_start);
				}else if(empty($fanxiud_pdate_dir_start) && !empty($fanxiud_pdate_dir_end)){
					$fanxiud_pdate_dir_end=strtotime($fanxiud_pdate_dir_end)+86400;
					$map=$map." and pdate<=".$fanxiud_pdate_dir_end;
				}
			}
			if(empty($fanxiud_rdate_dir_start) && empty($fanxiud_rdate_dir_end) && empty($fanxiud_pdate_dir_start) && empty($fanxiud_pdate_dir_end)){
				//拼接客户
				if(!empty($fanxiud_customer_dir)){
					$map=$map."customer like'%".$fanxiud_customer_dir."%'";
				}
			}else if(!empty($fanxiud_rdate_dir_start) || !empty($fanxiud_rdate_dir_end) || !empty($fanxiud_pdate_dir_start) || !empty($fanxiud_pdate_dir_end)){
				//拼接客户
				if(!empty($fanxiud_customer_dir)){
					$map=$map." and customer like'%".$fanxiud_customer_dir."%'";
				}
			}
			
			if(empty($fanxiud_rdate_dir_start) && empty($fanxiud_rdate_dir_end) && empty($fanxiud_pdate_dir_start) && empty($fanxiud_pdate_dir_end) && empty($fanxiud_customer_dir)){
				
				//拼接型号
				if(!empty($fanxiud_product_dir)){
					$productlist=$InventoryModel->where("cInvStd like'".$fanxiud_product_dir."' and cInvCCode like '0202%'")->field("I_id")->select();
					if(!empty($productlist)){
						$arr=array();
						foreach($productlist as $value){
							$arr[]=$value['i_id'];
						}
						$productstr=implode(",", $arr);
						$map=$map."product in (".$productstr.")";
					}
				}
				
			}else if(!empty($fanxiud_rdate_dir_start) || !empty($fanxiud_rdate_dir_end) || !empty($fanxiud_pdate_dir_start) || !empty($fanxiud_pdate_dir_end) || !empty($fanxiud_customer_dir)){
					//拼接型号
					if(!empty($fanxiud_product_dir)){
						$productlist=$InventoryModel->where("cInvStd like'".$fanxiud_product_dir."' and cInvCCode like '0202%'")->field("I_id")->select();
						if(!empty($productlist)){
							$arr=array();
							foreach($productlist as $value){
								$arr[]=$value['i_id'];
							}
							$productstr=implode(",", $arr);
							$map=$map." and product in (".$productstr.")";
						}
					}
			}
			
			if(empty($fanxiud_rdate_dir_start) && empty($fanxiud_rdate_dir_end) && empty($fanxiud_pdate_dir_start) && empty($fanxiud_pdate_dir_end) && empty($fanxiud_customer_dir) && empty($fanxiud_product_dir)){
				//拼接条码
				if(!empty($fanxiud_barcode_dir)){
					$map=$map."barcode like '%".$fanxiud_barcode_dir."%'";
				}
			}else if(!empty($fanxiud_rdate_dir_start) || !empty($fanxiud_rdate_dir_end) || !empty($fanxiud_pdate_dir_start) || !empty($fanxiud_pdate_dir_end) || !empty($fanxiud_customer_dir) || !empty($fanxiud_product_dir)){
				//拼接条码
				if(!empty($fanxiud_barcode_dir)){
					$map=$map." and barcode like '%".$fanxiud_barcode_dir."%'";
				}
			}
			
			if(empty($fanxiud_rdate_dir_start) && empty($fanxiud_rdate_dir_end) && empty($fanxiud_pdate_dir_start) && empty($fanxiud_pdate_dir_end) && empty($fanxiud_customer_dir) && empty($fanxiud_product_dir) && empty($fanxiud_barcode_dir)){
				//拼接处理结果
				if($fanxiud_result_dir!=0){
					$map=$map."result =".$fanxiud_result_dir;
				}
			}else if(!empty($fanxiud_rdate_dir_start) || !empty($fanxiud_rdate_dir_end) || !empty($fanxiud_pdate_dir_start) || !empty($fanxiud_pdate_dir_end) || !empty($fanxiud_customer_dir) || !empty($fanxiud_product_dir) || !empty($fanxiud_barcode_dir)){
				//拼接处理结果
				if($fanxiud_result_dir!=0){
					$map=$map." and result =".$fanxiud_result_dir;
				}
			}
			if(empty($fanxiud_rdate_dir_start) && empty($fanxiud_rdate_dir_end) && empty($fanxiud_pdate_dir_start) && empty($fanxiud_pdate_dir_end) && empty($fanxiud_customer_dir) && empty($fanxiud_product_dir) && empty($fanxiud_barcode_dir) && ($fanxiud_result_dir==0)){
				//拼接不良类型
				if($fanxiud_bad_dir!=0){
					$map=$map."bad =".$fanxiud_bad_dir;
				}
			}else if(!empty($fanxiud_rdate_dir_start) || !empty($fanxiud_rdate_dir_end) || !empty($fanxiud_pdate_dir_start) || !empty($fanxiud_pdate_dir_end) || !empty($fanxiud_customer_dir) || !empty($fanxiud_product_dir) || !empty($fanxiud_barcode_dir) || ($fanxiud_result_dir!=0)){
				//拼接不良类型
				if($fanxiud_bad_dir!=0){
					$map=$map." and bad =".$fanxiud_bad_dir;
				}
			}
			
			if(empty($fanxiud_rdate_dir_start) && empty($fanxiud_rdate_dir_end) && empty($fanxiud_pdate_dir_start) && empty($fanxiud_pdate_dir_end) && empty($fanxiud_customer_dir) && empty($fanxiud_product_dir) && empty($fanxiud_barcode_dir) && ($fanxiud_result_dir==0) && ($fanxiud_bad_dir==0)){
				//拼接状态
				if($fanxiud_flag_dir!=0){
					$map=$map."flag =".$fanxiud_flag_dir;
				}
			}else if(!empty($fanxiud_rdate_dir_start) || !empty($fanxiud_rdate_dir_end) || !empty($fanxiud_pdate_dir_start) || !empty($fanxiud_pdate_dir_end) || !empty($fanxiud_customer_dir) || !empty($fanxiud_product_dir) || !empty($fanxiud_barcode_dir) || ($fanxiud_result_dir!=0) || ($fanxiud_bad_dir!=0)){
				//拼接状态
				if($fanxiud_flag_dir!=0){
					$map=$map." and flag =".$fanxiud_flag_dir;
				}
			}
			
			if(empty($fanxiud_rdate_dir_start) && empty($fanxiud_rdate_dir_end) && empty($fanxiud_pdate_dir_start) && empty($fanxiud_pdate_dir_end) && empty($fanxiud_customer_dir) && empty($fanxiud_product_dir) && empty($fanxiud_barcode_dir) && ($fanxiud_result_dir==0) && ($fanxiud_bad_dir==0) && ($fanxiud_flag_dir==0)){
				//拼接现象过程
				if(!empty($fanxiud_fault_dir)){
					$map=$map."fault like '%".$fanxiud_fault_dir."%' or maint like '%".$fanxiud_fault_dir."%'";
				}
			}else if(!empty($fanxiud_rdate_dir_start) || !empty($fanxiud_rdate_dir_end) || !empty($fanxiud_pdate_dir_start) || !empty($fanxiud_pdate_dir_end) || !empty($fanxiud_customer_dir) || !empty($fanxiud_product_dir) || !empty($fanxiud_barcode_dir) || ($fanxiud_result_dir!=0) || ($fanxiud_bad_dir!=0) || ($fanxiud_flag_dir!=0)){
				//拼接现象过程
				if(!empty($fanxiud_fault_dir)){
					$map=$map." and (fault like '%".$fanxiud_fault_dir."%' or maint like '%".$fanxiud_fault_dir."%')";
				}
			}
			
			if(empty($fanxiud_rdate_dir_start) && empty($fanxiud_rdate_dir_end) && empty($fanxiud_pdate_dir_start) && empty($fanxiud_pdate_dir_end) && empty($fanxiud_customer_dir) && empty($fanxiud_product_dir) && empty($fanxiud_barcode_dir) && ($fanxiud_result_dir==0) && ($fanxiud_bad_dir==0) && ($fanxiud_flag_dir==0) && empty($fanxiud_fault_dir)){
				//拼接产返
				if(!empty($fanxiud_prdate_number_dir) && $fanxiud_prdate_tag_dir!=0 && is_numeric($fanxiud_prdate_number_dir)){
					$fanxiud_prdate_number_dir=$fanxiud_prdate_number_dir*2592000;
					switch($fanxiud_prdate_tag_dir){
						case 1:
							$map=$map."prdate >".$fanxiud_prdate_number_dir;
							break;
						case 2:
							$map=$map."prdate >=".$fanxiud_prdate_number_dir;
							break;
						case 3:
							$map=$map."prdate =".$fanxiud_prdate_number_dir;
							break;
						case 4:
							$map=$map."prdate <".$fanxiud_prdate_number_dir;
							break;
						case 5:
							$map=$map."prdate <=".$fanxiud_prdate_number_dir;
							break;
					}
				}
			}else if(!empty($fanxiud_rdate_dir_start) || !empty($fanxiud_rdate_dir_end) || !empty($fanxiud_pdate_dir_start) || !empty($fanxiud_pdate_dir_end) || !empty($fanxiud_customer_dir) || !empty($fanxiud_product_dir) || !empty($fanxiud_barcode_dir) || ($fanxiud_result_dir!=0) || ($fanxiud_bad_dir!=0) || ($fanxiud_flag_dir!=0) || !empty($fanxiud_fault_dir)){
				//拼接产返
				if(!empty($fanxiud_prdate_number_dir) && $fanxiud_prdate_tag_dir!=0 && is_numeric($fanxiud_prdate_number_dir)){
					$fanxiud_prdate_number_dir=$fanxiud_prdate_number_dir*2592000;
					switch($fanxiud_prdate_tag_dir){
						case 1:
							$map=$map." and prdate >".$fanxiud_prdate_number_dir;
							break;
						case 2:
							$map=$map." and prdate >=".$fanxiud_prdate_number_dir;
							break;
						case 3:
							$map=$map." and prdate =".$fanxiud_prdate_number_dir;
							break;
						case 4:
							$map=$map." and prdate <".$fanxiud_prdate_number_dir;
							break;
						case 5:
							$map=$map." and prdate <=".$fanxiud_prdate_number_dir;
							break;
					}
				}
			}
			
			
			session('map',$map);
			//存储查询条件
			$tag=$queryModel->where("module=1 and manager_id='%s'",$manager_id)->find();
			$temp=array();
			$temp['query']=$map;
			if($tag){
				$queryModel->where("id=%d",$tag['id'])->save($temp);
			}else{
				$temp['manager_id']=$manager_id;
				$temp['module']=1;
				$queryModel->add($temp);
			}
		}else if(IS_GET){
			//得到查询条件
			$query=$queryModel->where("module=1 and manager_id='%s'",$manager_id)->getField("query");
			if($query){
				session('map',$query);
			}else{
				session('map',null);
			}
		}
		//拼接查询条件
		$map=session('map');
		$count=$model->where($map)->count();
		$Page=new \Org\Nx\Page($count,20);
		$show=$Page->show();
		//日常工作计划未完成
		$datalist=$model->where($map)->order('fanxiunumber desc')->limit($Page->firstRow.','.$Page->listRows)->field("id,".$strfield)->select();
		//调用工具类
		$fanxiu=new \lib\Fanxiu();
		$datalist=$fanxiu->dengji($datalist);
		
		$result=array(array('id'=>1,'value'=>'修好退回'),array('id'=>2,'value'=>'加试入库'),array('id'=>3,'value'=>'修好入库'),array('id'=>4,'value'=>'报废'),array('id'=>5,'value'=>'批量退回-生产'));
		$badlist=array(array('id'=>1,'value'=>'材料不良'),array('id'=>2,'value'=>'客户使用'),array('id'=>3,'value'=>'其他'),array('id'=>4,'value'=>'设计不良'),array('id'=>5,'value'=>'原因不明'),array('id'=>6,'value'=>'作业不良'),array('id'=>7,'value'=>'正常'));
		$flaglist=array(array('id'=>1,'value'=>'已登记'),array('id'=>2,'value'=>'维修暂存'),array('id'=>3,'value'=>'已修'),array('id'=>4,'value'=>'功能不合格'),array('id'=>5,'value'=>'功能合格'),array('id'=>6,'value'=>'包装不合格'),array('id'=>7,'value'=>'包装合格'),array('id'=>8,'value'=>'领导审完'),array('id'=>9,'value'=>'已出库'),array('id'=>10,'value'=>'已退回'),array('id'=>11,'value'=>'批量返生产'));
		$this->assign('pagetitle','返修台帐');
		$this->assign('datalist',$datalist);
		$this->assign('count',$count);
		$this->assign('result',$result);
		$this->assign('badlist',$badlist);
		$this->assign('flaglist',$flaglist);
		$this->assign('namelist',$namelist);
		$this->assign('fieldlist',$fieldlist);
		$this->assign('width',$width);
		//$this->assign('inventoryclasslist',$inventoryclasslist);
		$this->assign('inventorylist',$inventorylist);
		$this->assign('personlist',$personlist);
		$this->assign('page',$show);
		$this->display();
    }
	
	//显示快递
	public function disexpressid(){
		// 实例化数据库连接类
		$model=D('Fanxiu');
		$id=I('get.id');
		//查找该方案下的工序
		$expressinfo=$model->where("id=%d",$id)->field("express,expressid")->find();
		if(empty($expressinfo)){
			$this->ajaxReturn(array(
			'state'=>'error',
			'info' => ''
			));
		}else{
			//快递
			$EBusinessID='1455547';
			$AppKey='e1f702aa-549e-4b36-8705-8bcf614c08e6';
			$ReqURL='http://api.kdniao.com/Ebusiness/EbusinessOrderHandle.aspx';
			
			$requestData= "{'OrderCode':'','ShipperCode':'".$expressinfo['express']."','LogisticCode':'".$expressinfo['expressid']."'}";
			$datas = array(
				'EBusinessID' => $EBusinessID,
				'RequestType' => '1002',
				'RequestData' => urlencode($requestData) ,
				'DataType' => '2',
			);
			$datas['DataSign'] = urlencode(base64_encode(md5($requestData.$AppKey)));
			
			$temps = array();	
			foreach ($datas as $key => $value) {
				$temps[] = sprintf('%s=%s', $key, $value);		
			}	
			$post_data = implode('&', $temps);
			$url_info = parse_url($ReqURL);
			if(empty($url_info['port']))
			{
				$url_info['port']=80;	
			}
			$httpheader = "POST " . $url_info['path'] . " HTTP/1.0\r\n";
			$httpheader.= "Host:" . $url_info['host'] . "\r\n";
			$httpheader.= "Content-Type:application/x-www-form-urlencoded\r\n";
			$httpheader.= "Content-Length:" . strlen($post_data) . "\r\n";
			$httpheader.= "Connection:close\r\n\r\n";
			$httpheader.= $post_data;
			$fd = fsockopen($url_info['host'], $url_info['port']);
			fwrite($fd, $httpheader);
			$gets = "";
			$headerFlag = true;
			while (!feof($fd)) {
				if (($header = @fgets($fd)) && ($header == "\r\n" || $header == "\n")) {
					break;
				}
			}
			while (!feof($fd)) {
				$gets.= fread($fd, 128);
			}
			fclose($fd);
			$data = str_replace("\r\n",'',$gets );
			$data = json_decode($data,true);
			$traces=$data['Traces'];
			$this->ajaxReturn(array(
			'state'=>'ok',
			'info' => '',
			'data'=>$traces
			));
		}
	}
	
	public function edit(){
		$model=D('Fanxiu');
		if(IS_GET){
			$id=I('get.id');
			if(empty($id)){
				$this->ajaxReturn(array(
					'state'=>'error',
					'info' => '请至少选择一条记录！'
					));
			}else{
				$id=substr($id,0,-1);
				$result=$model->where('id=%d',$id)->find();
				$result['pdate']=date('Y-m-d',$result['pdate']);
				$this->ajaxReturn(array(
					'state'=>'ok',
					'info' => '',
					'data'=>$result
					));
			}
		}else{
			$id=I('post.id');
			$data=array();
			$data['customer']=I('post.customer');
			$data['result']=I('post.result');
			$data['person']=I('post.person');
			$data['product']=I('post.product');
			$data['remark']=I('post.remark');
			$data['qty']=I('post.qty');
			$data['pdate']=strtotime(I('post.pdate'));
			$barcode=I('post.barcode');
			$barcodelist=explode("\n", $barcode);
			$data['barcode']=$barcodelist[0];
			$flaga=$model->where("barcode='%s' and id!=%d and flag=1",$data['barcode'],$id)->find();
			if($flaga){
				$this->ajaxReturn(array(
					'state'=>'error',
					'info' => '该条码已存在！'
				));
			}else{
				$receive_date=$model->where("id=%d",$id)->getField("receive_date");
				$data['prdate']=$receive_date-$data['pdate'];
				$flagb=$model->where('id=%d',$id)->save($data);
				if($flagb!==false){
					$this->ajaxReturn(array(
						'state'=>'ok',
						'info' => '维修记录修改成功！'
					));
				}else{
					$this->ajaxReturn(array(
						'state'=>'error',
						'info' => '维修记录修改失败！'
					));
				}
			}
			
		}
	}
	public function remark(){
		$model=D('Fanxiu');
		if(IS_GET){
			$id=I('get.id');
			if(empty($id)){
				$this->ajaxReturn(array(
					'state'=>'error',
					'info' => '请至少选择一条记录！'
					));
			}else{
				$id=substr($id,0,-1);
				$result=$model->where('id in (%s)',$id)->find();
				$this->ajaxReturn(array(
					'state'=>'ok',
					'info' => '',
					'data'=>$result['remark']
					));
			}
		}else{
			$id=I('post.id');
			$id=substr($id,0,-1);
			$data=array();
			$data['remark']=I('post.remark');
			$flagb=$model->where('id in (%s)',$id)->save($data);
			if($flagb!==false){
				$this->ajaxReturn(array(
					'state'=>'ok',
					'info' => '修改成功！'
				));
			}else{
				$this->ajaxReturn(array(
					'state'=>'error',
					'info' => '改失败！'
				));
			}
			
		}
	}
	
	public function cause(){
		$model=D('Fanxiu');
		if(IS_GET){
			$id=I('get.id');
			if(empty($id)){
				$this->ajaxReturn(array(
					'state'=>'error',
					'info' => '请至少选择一条记录！'
					));
			}else{
				$id=substr($id,0,-1);
				$result=$model->where('id=%d',$id)->find();
				$this->ajaxReturn(array(
					'state'=>'ok',
					'info' => '',
					'data'=>$result
					));
			}
			
		}else{
			$id=I('post.id');
			$data=array();
			$data['bad']=I('post.bad');
			$data['bad_cause']=I('post.bad_cause');
			$data['improve']=I('post.improve');
			$data['cause_id']=session('manager_id');
			$data['cause_date']=time();
			$flagb=$model->where('id=%d',$id)->save($data);
			if($flagb!==false){
				$this->ajaxReturn(array(
					'state'=>'ok',
					'info' => '分析提交成功！'
				));
			}else{
				$this->ajaxReturn(array(
					'state'=>'error',
					'info' => '分析提交失败！'
				));
			}
			
		}
	}
	
	public function exportExcel(){
		$xlsTitle = iconv('utf-8', 'gb2312', '返修台帐');//文件名称
		//得到用户自定义栏目框
		$manager_id=session('manager_id');
		$column=D('Column');
		$expCellName=$column->where("module=1")->order("rank asc")->field("field,name")->select();
		
		$cellNum = count($expCellName);//多少列
		//$dataNum = count($expTableData);//多少行
		vendor("PHPExcel.PHPExcel");
			
		$objPHPExcel = new \PHPExcel();//实例化PHPExcel类
		$cellName = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ');
		
		//'A','B','C','D','E','F','G','H','I'
		for($i=0;$i<$cellNum;$i++){
			$objPHPExcel->getActiveSheet(0)->setCellValue($cellName[$i].'1', $expCellName[$i]["name"]);//设置表头值
		}
		
		//生成数据列表
		$model=D('Fanxiu');
		$queryModel=D('Query');
		$map=$queryModel->where("module=1 and manager_id='%s'",$manager_id)->getField("query");
		$datalist=$model->where($map)->select();
		//调用工具类
		$fanxiu=new \lib\Fanxiu();
		$datalist=$fanxiu->export($datalist);
		
		$resultcount=count($datalist);
		//设置表内容    
		for($i=0;$i<$resultcount;$i++){
			for($j=0;$j<$cellNum;$j++){
				if($expCellName[$j]['field']=='qz' || $expCellName[$j]['field']=='qb' || $expCellName[$j]['field']=='hz' || $expCellName[$j]['field']=='hb'){
					if(!empty($datalist[$i][$expCellName[$j]['field']])){
						$objPHPExcel->getActiveSheet(0)->setCellValue($cellName[$j].($i+2), "查看");
						$objPHPExcel->getActiveSheet(0)->getCell($cellName[$j].($i+2))->getHyperlink()->setUrl($datalist[$i][$expCellName[$j]['field']]);
					}
				}else{
					$objPHPExcel->getActiveSheet(0)->setCellValue($cellName[$j].($i+2), $datalist[$i][$expCellName[$j]['field']]);
				}
			}             
		}
		
		$objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		
		header("Content-type: text/csv");//重要
		header('pragma:public');
		header('Content-Type: application/vnd.ms-excel');//告诉浏览器将要输出excel03文件
		header('Content-Disposition:attachment;filename="'.$xlsTitle.'.xls"');//告诉浏览器将输出文件的名称
        header('Cache-Control: max-age=0');//禁止缓存
		$objWriter->save('php://output');
		exit;
	}
}
?>