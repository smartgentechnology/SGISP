<?php
namespace Home\Controller;
use Common\Controller\AuthController;

class PscheduleController extends AuthController {

    public function index(){
		$model=D('Pschedule');
		$procedure=D('Pprocedure');
		if(IS_POST){
			$data=I('post.');
			//得到查询条件
			$pschedule_batch_dir=$data['pschedule_batch_dir'];
			$pschedule_model_dir=$data['pschedule_model_dir'];
			$pschedule_remark_dir=$data['pschedule_remark_dir'];
			$pschedule_ontime_dir_start=$data['pschedule_ontime_dir_start'];
			$pschedule_ontime_dir_end=$data['pschedule_ontime_dir_end'];
			$pschedule_downtime_dir_start=$data['pschedule_downtime_dir_start'];
			$pschedule_downtime_dir_end=$data['pschedule_downtime_dir_end'];
			$pschedule_mark_dir=$data['pschedule_mark_dir'];
			$pschedule_total_dir=$data['pschedule_total_dir'];
			//拼接批号
			if(!empty($pschedule_batch_dir)){
				$map=$map." and batch like'%".$pschedule_batch_dir."%'";
			}
			//拼接型号
			if(!empty($pschedule_model_dir)){
				$map=$map." and model like'%".$pschedule_model_dir."%'";
			}
			//拼接备注
			if(!empty($pschedule_remark_dir)){
				$map=$map." and remark like'%".$pschedule_remark_dir."%'";
			}
			//拼接计划上线日期
			if(!empty($pschedule_ontime_dir_start) && !empty($pschedule_ontime_dir_end)){
				$map=$map." and ontime>=".strtotime($pschedule_ontime_dir_start)." and ontime<=".strtotime($pschedule_ontime_dir_end);
			}else if(!empty($pschedule_ontime_dir_start) && empty($pschedule_ontime_dir_end)){
				$map=$map." and ontime>=".strtotime($pschedule_ontime_dir_start);
			}else if(empty($pschedule_ontime_dir_start) && !empty($pschedule_ontime_dir_end)){
				$map=$map." and ontime<=".strtotime($pschedule_ontime_dir_end);
			}
			//拼接计划下线日期
			if(!empty($pschedule_downtime_dir_start) && !empty($pschedule_downtime_dir_end)){
				$map=$map." and downtime>=".strtotime($pschedule_downtime_dir_start)." and downtime<=".strtotime($pschedule_downtime_dir_end);
			}else if(!empty($pschedule_downtime_dir_start) && empty($pschedule_downtime_dir_end)){
				$map=$map." and downtime>=".strtotime($pschedule_downtime_dir_start);
			}else if(empty($pschedule_downtime_dir_start) && !empty($pschedule_downtime_dir_end)){
				$map=$map." and downtime<=".strtotime($pschedule_downtime_dir_end);
			}
			if(!empty($pschedule_total_dir) && $pschedule_mark_dir!=0 && is_numeric($pschedule_total_dir)){
				switch($pschedule_mark_dir){
					case 1:
						$map=$map." and onnumber >".$pschedule_total_dir;
						break;
					case 2:
						$map=$map." and onnumber >=".$pschedule_total_dir;
						break;
					case 3:
						$map=$map." and onnumber =".$pschedule_total_dir;
						break;
					case 4:
						$map=$map." and onnumber <".$pschedule_total_dir;
						break;
					case 5:
						$map=$map." and onnumber <=".$pschedule_total_dir;
						break;
				}
			}
			session('map',$map);
			session('flag',0);
		}else if(IS_GET){
			if(!empty($_GET)){
				$flag=I('get.flag');
				session('flag',$flag);
				/*
				if($flag==0 || $flag==1 || $flag==2){
					if($flag==3){
						$flag=0;
					}
					//$map=session('map');
				}*/
			}else{
				session('flag',0);
				session('map',null);
			}
			
		}
		$flag=session('flag');
		$map=session('map');
		$flag="flag =".$flag;
		$count=$model->where($flag.$map)->count();
		$Page=new \Org\Nx\Page($count,10);
		$show=$Page->show();
		//生成数据列表
		$datalist=$model->where($flag.$map)->order('id desc')->limit($Page->firstRow.','.$Page->listRows)->select();
		foreach($datalist as $key=>$batchinfo){
			//得到改批次下面的所有工序状态
			$batch=$batchinfo['batch'];
			//焊接完成
			$hanjietotal=$procedure->where("batch='%s' and type=%d and flag=%d",$batch,1,1)->sum('number');
			$hanjietotal=$hanjietotal+0;
			//焊接报废
			$hanjiescrap=$procedure->where("batch='%s' and type=%d and flag=%d",$batch,1,5)->sum('number');
			$hanjiescrap=$hanjiescrap+0;
			//初试完成
			$chushitotal=$procedure->where("batch='%s' and type=%d and flag=%d",$batch,2,1)->sum('number');
			$chushitotal=$chushitotal+0;
			//初试报废
			$chushiscrap=$procedure->where("batch='%s' and type=%d and flag=%d",$batch,2,5)->sum('number');
			$chushiscrap=$chushiscrap+0;
			//出厂完成
			$chuchangtotal=$procedure->where("batch='%s' and type=%d and flag=%d",$batch,3,1)->sum('number');
			$chuchangtotal=$chuchangtotal+0;
			//出厂报废
			$chuchangscrap=$procedure->where("batch='%s' and type=%d and flag=%d",$batch,3,5)->sum('number');
			$chuchangscrap=$chuchangscrap+0;
			//包装完成
			$baozhuangtotal=$procedure->where("batch='%s' and type=%d",$batch,4)->sum('number');
			$baozhuangtotal=$baozhuangtotal+0;
			//待包装成品库
			$daibaochengpintotal=$procedure->where("batch='%s' and type=%d and flag=%d",$batch,5,10)->sum('number');
			$daibaochengpintotal=$daibaochengpintotal+0;
			//包装完成品库
			$baowanchengpintotal=$procedure->where("batch='%s' and type=%d and flag=%d",$batch,5,11)->sum('number');
			$baowanchengpintotal=$baowanchengpintotal+0;
			//焊接在制品库
			$hanjiezaizhi=$procedure->where("batch='%s' and type=%d and flag=%d",$batch,6,2)->sum('number');
			$hanjiezaizhi=$hanjiezaizhi+0;
			//初试在制品库
			$chushizaizhi=$procedure->where("batch='%s' and type=%d and flag=%d",$batch,6,3)->sum('number');
			$chushizaizhi=$chushizaizhi+0;
			//出厂在制品库
			$chuchangzaizhi=$procedure->where("batch='%s' and type=%d and flag=%d",$batch,6,4)->sum('number');
			$chuchangzaizhi=$chuchangzaizhi+0;
			//包装在制品库
			$baozhuangzaizhi=$procedure->where("batch='%s' and type=%d and flag=%d",$batch,6,6)->sum('number');
			$baozhuangzaizhi=$baozhuangzaizhi+0;
			//电控库
			$diankongtotal=$procedure->where("batch='%s' and type=%d",$batch,7)->sum('number');
			$diankongtotal=$diankongtotal+0;
			//待料库
			$dailiao=$procedure->where("batch='%s' and type=%d and flag in(7,8,9)",$batch,8)->sum('number');
			//待料库数量
			$batchinfo['dailiao']=$dailiao+0;
			
			//成品库数量=待包装成品+已包装成品
			$batchinfo['chengpin']=$daibaochengpintotal+$baowanchengpintotal;
			//在制品库数量=焊接在制+初试在制+出厂在制+包装在制
			$batchinfo['zaizhi']=$hanjiezaizhi+$chushizaizhi+$chuchangzaizhi+$baozhuangzaizhi;
			//电控库数量
			$batchinfo['diankong']=$diankongtotal;
			
			//焊接在线=批数量-焊接完成-焊接报废
			if($hanjietotal!=0){
				$batchinfo['hanjie']=$batchinfo['number']-$hanjietotal-$hanjiescrap;
				if($batchinfo['hanjie']==0){
					$batchinfo['hanjieflag']=3;
				}else{
					$batchinfo['hanjieflag']=2;
				}
			}else{
				$batchinfo['hanjie']=$batchinfo['number']-$hanjiescrap;
				$batchinfo['hanjieflag']=1;
			}
			//初试在线=焊接完成-焊接在制品库-初试完成-初试报废
			$batchinfo['chushi']=$hanjietotal-$hanjiezaizhi-$chushitotal-$chushiscrap;
			//初试颜色
			if($chushitotal==0){
				$batchinfo['chushiflag']=1;
			}else{
				if($batchinfo['chushi']==0){
					$batchinfo['chushiflag']=3;
				}else{
					$batchinfo['chushiflag']=2;
				}
			}
			//出厂在线=初试完成-初试在制品库-出厂完成-出厂报废
			$batchinfo['chuchang']=$chushitotal-$chushizaizhi-$chuchangtotal-$chuchangscrap;
			//出厂颜色
			if($chuchangtotal==0){
				$batchinfo['chuchangflag']=1;
			}else{
				if($batchinfo['chuchang']==0){
					$batchinfo['chuchangflag']=3;
				}else{
					$batchinfo['chuchangflag']=2;
				}
			}
			if($chuchangtotal>$baozhuangtotal){
				//包装在线=出厂完成-出厂在制品库-包装完成-电控库-待包装成品
				$batchinfo['baozhuang']=$chuchangtotal-$chuchangzaizhi-$baozhuangtotal-$diankongtotal-$daibaochengpintotal;
				if($baozhuangtotal==0){
					$batchinfo['baozhuangflag']=1;
				}else{
					$batchinfo['baozhuangflag']=2;
				}
			}else{
				$batchinfo['baozhuang']=0;
				if($baozhuangtotal==0){
					$batchinfo['baozhuangflag']=1;
				}else{
					$batchinfo['baozhuangflag']=3;
				}
				
			}
			//待入库数量=包装完成-包装在制品库-已包装成品库
			$batchinfo['dairuku']=$baozhuangtotal-$baozhuangzaizhi-$baowanchengpintotal;
			
			$datalist[$key]=$batchinfo;
		}
		//调用工具类
		$utils=new \lib\Utils();
		$datalist=$utils->changeDate($datalist);
		$this->assign('datalist',$datalist);
		$this->assign('pagetitle','生产计划表');
		$this->assign('page',$show);
		$this->assign('flag',$flag);
		$this->assign('map',$map);
		$zero=$model->where('flag= 0'.$map)->count();
		$this->assign('zero',$zero);
		$one=$model->where('flag= 1'.$map)->count();
		$this->assign('one',$one);
		$two=$model->where('flag= 2'.$map)->count();
		$this->assign('two',$two);
		
		$this->display();
    }
	
	public function add(){
		$model=D('Pschedule');
		if(IS_POST){
			$data=array();
			$data=I('post.');
			$data['ontime']=strtotime($data['ontime']);
			$data['downtime']=strtotime($data['downtime']);
			$data['onnumber']=$data['number'];
			$flaga=$model->where("batch='%s'",$data['batch'])->find();
			if($flaga){
				$this->ajaxReturn(array(
					'state'=>'error',
					'info' => '该批号已存在！'
				));
			}else{
				if (!$model->create($data)){ // 创建数据对象
					// 如果创建失败 表示验证没有通过 输出错误提示信息
					exit($model->getError());
				}else{
					// 验证通过 写入新增数据
					$flagb=$model->add();
					if($flagb){
						session('add_pschedule_model',$data['model']);
						session('add_pschedule_batch',$data['batch']);
						session('add_pschedule_number',$data['number']);
						//session('add_pschedule_remark',$data['remark']);
						$this->ajaxReturn(array(
							'state'=>'ok',
							'info' => '生产计划添加成功'
						));
					}else{
						$this->ajaxReturn(array(
							'state'=>'error',
							'info' => '生产计划添加失败！'
						));
					}
				}
				
			}
			
		}else{
			$this->ajaxReturn(array(
				'state'=>'ok',
				'info' => ''
			));
		}
	}
	
	public function edit(){
		$model=D('Pschedule');
		if(IS_GET){
			$id=I('get.id');
			if(empty($id)){
				$this->ajaxReturn(array(
					'state'=>'error',
					'info' => '请至少选择一条记录！'
					));
			}else{
				//$id=substr($id,0,-1);
				$result=$model->where('id=%d',$id)->find();
				$result['ontime']=date('y-m-d',$result['ontime']);
				$result['downtime']=date('y-m-d',$result['downtime']);
				$this->ajaxReturn(array(
					'state'=>'ok',
					'info' => '',
					'data'=>$result
					));
			}
		}else{
			$id=I('post.id');
			$data=array();
			$data['model']=I('post.model');
			$data['batch']=I('post.batch');
			$data['number']=I('post.number');
			$data['remark']=I('post.remark');
			$data['ontime']=strtotime(I('post.ontime'));
			$data['downtime']=strtotime(I('post.downtime'));
			
			$planinfo=$model->where("id=%d",$id)->find();
			$pprocedure=D('Pprocedure');
			//焊接工序已存在的数量
			$hanjietotal=$pprocedure->where("batch='%s' and type=%d",$planinfo['batch'],1)->field('SUM(number) as total')->select();
			$hanjietotal=$hanjietotal[0]['total']+0;
			if($data['number']<$hanjietotal){
				$this->ajaxReturn(array(
					'state'=>'error',
					'info' => '该批次计划数量'.$data['number'].'台，不能小于焊接工序的数量'.$hanjietotal.'台！'
				));
			}
			$flaga=$model->where("batch='%s' and id!=%d",$data['batch'],$id)->find();
			if($flaga){
				$this->ajaxReturn(array(
					'state'=>'error',
					'info' => '该批号已存在！'
				));
			}else{
				if (!$model->create($data)){ // 创建数据对象
					// 如果创建失败 表示验证没有通过 输出错误提示信息
					exit($model->getError());
				}else{
					$flagb=$model->where('id=%d',$id)->save();
					if($flagb!==false){
						if($data['batch']!=$planinfo['batch'] || $data['model']!=$planinfo['model']){
							
							$arr['batch']=$data['batch'];
							$arr['model']=$data['model'];
							$pprocedure->where("batch='%s'",$planinfo['batch'])->save($arr);
						}
						$numbertotal=$pprocedure->where("batch='%s' and type in (5,6,7,8)",$data['batch'])->field('SUM(number) as total')->select();
						$numbertotal=$numbertotal[0]['total']+0;
						$number=$data['number'];
						$chashu=$number-$numbertotal;
						if($numbertotal==$number){
							$flag['flag']=1;
						}else if($chashu<10){
							$flag['flag']=2;
						}else{
							$flag['flag']=0;
						}
						$flag['onnumber']=$chashu;
						$model->where("batch='%s'",$data['batch'])->save($flag);
						$this->ajaxReturn(array(
							'state'=>'ok',
							'info' => '生产计划修改成功！'
						));
					}else{
						$this->ajaxReturn(array(
							'state'=>'error',
							'info' => '生产计划修改失败！'
						));
					}
				}
				
			}
			
		}
	}
	
	public function del($id=''){
		$model=D('Pschedule');
		if(empty($id)){
			$this->ajaxReturn(array(
				'state'=>'error',
				'info' => '请至少选择一条记录！'
				));
		}else{
			$id=substr($id,0,-1);
			$batchlist=$model->where('id in (%s)',$id)->field('batch')->select();
			$flagb=$model->where('id in (%s)',$id)->delete();
			if($flagb){
				$pprocedure=D('Pprocedure');
				foreach($batchlist as $value){
					$pprocedure->where("batch='%s'",$value['batch'])->delete();
				}
				$this->ajaxReturn(array(
					'state'=>'ok',
					'info' => '生产计划删除成功！',
					'data'=>$idlist
				));
			}else{
				$this->ajaxReturn(array(
					'state'=>'error',
					'info' => '生产计划删除失败！'
				));
			}
			
		}
	}
	public function exportExcel(){
		$xlsTitle = iconv('utf-8', 'gb2312', 'touruchanchu');//文件名称
		$expCellName  = array(
		array('batch','生产批次'),
		array('model','产品名称'),
		array('number','数量'),
		array('ontime','计划上线日期'),
		array('downtime','计划下线日期'),
		array('actualtime','实际上线日期'),
		array('remark','延期原因'),
		array('hanjie','焊接在线'),
		array('chushi','待初试'),
		array('chuchang','出厂检验'),
		array('baozhuang','待包装'),
		array('dairuku','待入库'),
		array('onnumber','在线合计'),
		array('chengpin','已入成品库数量'),
		array('zaizhi','已入在制品数量'),
		array('hanjiezaizhi','焊接完入库数量'),
		array('tiepian','贴片完入库数量'),
		array('piliang','批量'),
		array('quanbu','全部'),
		array('beizhu','备注')    
		);

		
		$cellNum = count($expCellName);//多少列
		//$dataNum = count($expTableData);//多少行
		vendor("PHPExcel.PHPExcel");
			
		$objPHPExcel = new \PHPExcel();//实例化PHPExcel类
		$cellName = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ');
		
		//'A','B','C','D','E','F','G'合并1和2
		for($i=0;$i<7;$i++){
			$objPHPExcel->getActiveSheet(0)->mergeCells(''.$cellName[$i].'1:'.$cellName[$i].'2');//合并单元格
			$objPHPExcel->getActiveSheet(0)->setCellValue($cellName[$i].'1', $expCellName[$i][1]);//设置表头值
		}
		//合并H1到K1，填写在制品数量
		$objPHPExcel->getActiveSheet(0)->mergeCells('H1:L1');//合并单元格
		//设置H1的值
		$objPHPExcel->getActiveSheet(0)->setCellValue('H1', '在制产品数量');//设置表头值
		//'H','I','G','K','L'的值
		for($i=7;$i<12;$i++){
			$objPHPExcel->getActiveSheet(0)->setCellValue($cellName[$i].'2', $expCellName[$i][1]);//设置表头值
		}
		//'M','N','O','P','Q'合并1和2
		for($i=12;$i<17;$i++){
			$objPHPExcel->getActiveSheet(0)->mergeCells(''.$cellName[$i].'1:'.$cellName[$i].'2');//合并单元格
			$objPHPExcel->getActiveSheet(0)->setCellValue($cellName[$i].'1', $expCellName[$i][1]);//设置表头值
		}
		//合并R1到S1，填写下线日期
		$objPHPExcel->getActiveSheet(0)->mergeCells('R1:S1');//合并单元格
		$objPHPExcel->getActiveSheet(0)->setCellValue('R1', '下线日期');//设置表头值
		$objPHPExcel->getActiveSheet(0)->setCellValue('R2', $expCellName[17][1]);//设置表头值
		$objPHPExcel->getActiveSheet(0)->setCellValue('S2', $expCellName[18][1]);//设置表头值
		//合并T1到T2，填写备注
		$objPHPExcel->getActiveSheet(0)->mergeCells('T1:T2');//合并单元格
		$objPHPExcel->getActiveSheet(0)->setCellValue('T1', $expCellName[19][1]);//设置表头值
		
		//生成数据列表
		$model=D('Pschedule');
		$map=session('map');
		$datalist=$model->where('flag !=4'.$map)->order('id desc')->select();
		foreach($datalist as $key=>$batchinfo){
			//得到改批次下面的所有工序状态
			$batch=$batchinfo['batch'];
			$procedure=D('Pprocedure');
			//实际上线日期
			$actualtime=$procedure->where("batch='%s' and type=%d",$batch,1)->Min('starttime');
			$actualtime=$actualtime+0;
			if($actualtime!=0){
				$batchinfo['actualtime']=date('ymd',$actualtime);
			}
			//焊接完成
			$hanjietotal=$procedure->where("batch='%s' and type=%d and flag=%d",$batch,1,1)->sum('number');
			$hanjietotal=$hanjietotal+0;
			//焊接报废
			$hanjiescrap=$procedure->where("batch='%s' and type=%d and flag=%d",$batch,1,5)->sum('number');
			$hanjiescrap=$hanjiescrap+0;
			//初试完成
			$chushitotal=$procedure->where("batch='%s' and type=%d and flag=%d",$batch,2,1)->sum('number');
			$chushitotal=$chushitotal+0;
			//初试报废
			$chushiscrap=$procedure->where("batch='%s' and type=%d and flag=%d",$batch,2,5)->sum('number');
			$chushiscrap=$chushiscrap+0;
			//出厂完成
			$chuchangtotal=$procedure->where("batch='%s' and type=%d and flag=%d",$batch,3,1)->sum('number');
			$chuchangtotal=$chuchangtotal+0;
			//出厂报废
			$chuchangscrap=$procedure->where("batch='%s' and type=%d and flag=%d",$batch,3,5)->sum('number');
			$chuchangscrap=$chuchangscrap+0;
			//包装完成
			$baozhuangtotal=$procedure->where("batch='%s' and type=%d",$batch,4)->sum('number');
			$baozhuangtotal=$baozhuangtotal+0;
			//成品库
			$chengpintotal=$procedure->where("batch='%s' and type=%d",$batch,5)->sum('number');
			$chengpintotal=$chengpintotal+0;
			//焊接在制品库
			$hanjiezaizhi=$procedure->where("batch='%s' and type=%d and flag=%d",$batch,6,2)->sum('number');
			$hanjiezaizhi=$hanjiezaizhi+0;
			//初试在制品库
			$chushizaizhi=$procedure->where("batch='%s' and type=%d and flag=%d",$batch,6,3)->sum('number');
			$chushizaizhi=$chushizaizhi+0;
			//出厂在制品库
			$chuchangzaizhi=$procedure->where("batch='%s' and type=%d and flag=%d",$batch,6,4)->sum('number');
			$chuchangzaizhi=$chuchangzaizhi+0;
			//包装在制品库
			$baozhuangzaizhi=$procedure->where("batch='%s' and type=%d and flag=%d",$batch,6,6)->sum('number');
			$baozhuangzaizhi=$baozhuangzaizhi+0;
			//电控库
			$diankongtotal=$procedure->where("batch='%s' and type=%d",$batch,7)->sum('number');
			$diankongtotal=$diankongtotal+0;
			//待料库
			$dailiao=$procedure->where("batch='%s' and type=%d and flag in(7,8,9)",$batch,8)->sum('number');
			$dailiao=$dailiao+0;
			//下线日期
			$flag=$model->where("batch='%s'",$batch)->field('flag')->find();
			$flag=$flag['flag'];
			$endtime=$procedure->where("batch='%s' and type in(5,6,7,8)",$batch)->Max('starttime');
			if($flag==1){
				$batchinfo['quanbu']=date('ymd',$endtime);
			}else if($flag==2){
				$batchinfo['piliang']=date('ymd',$endtime);
			}
			
			//成品库数量
			$batchinfo['chengpin']=$chengpintotal;
			//在制品库数量=初试在制+出厂在制+包装在制+电控库+待料库
			$batchinfo['zaizhi']=$chushizaizhi+$chuchangzaizhi+$baozhuangzaizhi+$diankongtotal+$dailiao;
			//焊接在制品数量
			$batchinfo['hanjiezaizhi']=$hanjiezaizhi;
			
			//焊接在线=批数量-焊接完成-焊接报废
			if($hanjietotal!=0){
				$batchinfo['hanjie']=$batchinfo['number']-$hanjietotal-$hanjiescrap;
				
			}else{
				$batchinfo['hanjie']=$batchinfo['number']-$hanjiescrap;
			}
			//初试在线=焊接完成-焊接在制品库-初试完成-初试报废
			$batchinfo['chushi']=$hanjietotal-$hanjiezaizhi-$chushitotal-$chushiscrap;
			
			//出厂在线=初试完成-初试在制品库-出厂完成-出厂报废
			$batchinfo['chuchang']=$chushitotal-$chushizaizhi-$chuchangtotal-$chuchangscrap;
			
			if($chuchangtotal>$baozhuangtotal){
				//包装在线=出厂完成-出厂在制品库-包装完成-电控库
				$batchinfo['baozhuang']=$chuchangtotal-$chuchangzaizhi-$baozhuangtotal-$diankongtotal;
			}else{
				$batchinfo['baozhuang']=0;
			}
			//待入库数量=包装完成-成品库-包装在制品库
			$batchinfo['dairuku']=$baozhuangtotal-$baozhuangzaizhi-$batchinfo['chengpin'];
			
			//在线总数=焊接在线+初试在线+出厂在线+包装在线+待入库
			//$batchinfo['total']=$batchinfo['hanjie']+$batchinfo['chushi']+$batchinfo['chuchang']+$batchinfo['baozhuang']+$batchinfo['dairuku'];
			
			$datalist[$key]=$batchinfo;

		}
		//调用工具类
		$utils=new \lib\Utils();
		$datalist=$utils->changeDate($datalist);
		$resultcount=count($datalist);
		//设置表内容    
		for($i=0;$i<$resultcount;$i++){
			for($j=0;$j<$cellNum;$j++){
				$objPHPExcel->getActiveSheet(0)->setCellValue($cellName[$j].($i+3), $datalist[$i][$expCellName[$j][0]]);
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