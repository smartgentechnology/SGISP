<?php
namespace Home\Controller;
use Common\Controller\AuthController;
class SupplieranalysisController extends AuthController {
	
    public function index(){
		//U8人员档案
		$PersonModel=M('Person','dbo.','U8');
		//U8人员档案
		$personlist=$PersonModel->where("cDepCode=304")->field("cPersonCode,cPersonName")->select();
		//U8供应商
		$VendorModel=M('Vendor','dbo.','U8');
		//U8入库单主表
		$RdRecordModel=M('Rdrecord01','dbo.','U8');
		//U8入库单子表
		$RdrecordsModel=M('rdrecords01','dbo.','U8');
		//U8采购发票主表
		$PurbillvouchModel=M('Purbillvouch','dbo.','U8');
		//U8采购发票子表
		$PurbillvouchsModel=M('Purbillvouchs','dbo.','U8');
		//U8应付期初数据
		$ApdetailModel=M('Detail','dbo.ap_','U8');
		//U8应付
		$ClosebillModel=M('Closebill','dbo.ap_','U8');
		//U8凭证及明细
		$AccvouchModel=M('accvouch','dbo.GL_','U8');
		if(IS_POST){
			$data=I('post.');
			//得到查询条件
			//客户名称
			$analysis_vendor_dir=$data['analysis_supplier_dir'];
			//截止日期
			$workplan_date_dir_end=$data['workplan_date_dir_end'];
			//拼接客户名称
			if(!empty($analysis_vendor_dir)){
				//客户列表
				$vendorlist=$VendorModel->where("dEndDate is null and cVenPPerson='%s'",$analysis_vendor_dir)->field('cVenCode,cVenAbbName,cVenPPerson')->select();
			}else{
				//客户列表
				$vendorlist=$VendorModel->where("dEndDate is null")->field('cVenCode,cVenAbbName,cVenPPerson')->order('cVenCode asc')->select();
			}
			session('ranalysisvendor',$analysis_vendor_dir);
			$nowtime=time();
			//拼接完成日期
			if(!empty($workplan_date_dir_end)){
				$fahuomap=$workplan_date_dir_end;
			}else{
				$fahuomap=date('Y-m-d',$nowtime);
				
			}
			session('ranalysisvendortime',$fahuomap);
			$datalist=array();
			$yingfu=0;
			foreach($vendorlist as $a){
				$info=array();
				$info=$a;
				//客户期初借方
				$info['jiefang']=$ApdetailModel->where("cDwCode='%s' and dRegDate < '2017-08-01' and csign is NULL",$a['cvencode'])->sum('iDAmount');
				//客户期初贷方
				$info['daifang']=$ApdetailModel->where("cDwCode='%s' and dRegDate < '2017-08-01' and csign is not NULL",$a['cvencode'])->sum('iCAmount');
				$info['qichu']=$info['daifang']-$info['jiefang'];
				
				//期初入库单
				$qichulist=$RdRecordModel->where("dDate <='2017-07-31' and cVenCode='%s'",$a['cvencode'])->field("ID")->select();
				//得到该客户的所有入库单主表ID
				$dlidlist=$RdRecordModel->where("dVeriDate is not NULL and dVeriDate <='%s' and cVenCode='%s'",$fahuomap,$a['cvencode'])->field("ID")->select();
				//未开票
				$dlid=array();
				foreach($qichulist as $b){
					$dlid[]=$b['id'];
				}
				foreach($dlidlist as $c){
					$dlid[]=$c['id'];
				}
				$dlidstr=implode(",",$dlid);
				/*
				
				$weijiesuan=0;
				if(!empty($dlid)){
					//$weijiesuan=$RdrecordsModel->where("ID in(".$dlidstr.") and dSDate is null")->sum('iSum');
					$weijiesuan=$RdrecordsModel->where("ID in(".$dlidstr.")")->sum('iSum');
				}
				*/
				$chukudan=0;
				$fapiao=array();
				
				$chukudan=$chukudan+$RdrecordsModel->where("ID in(".$dlidstr.") and dSDate is null")->sum('iSum');
				$fapiaoid=$RdrecordsModel->where("ID in(".$dlidstr.") and dSDate is not null")->field('AutoID')->select();
				foreach($fapiaoid as $f){
				$fapiao[]=$f['autoid'];
				}
				if(!empty($fapiao)){
					$fapiaostr=implode(",",$fapiao);
					$chukudan=$chukudan+$PurbillvouchsModel->where("RdsId in(".$fapiaostr.")")->sum("iSum");
				}
				//已开票金额
				//$pbvidlist=$PurbillvouchModel->where("cVenCode='%s' and((dverifydate is not null and dPBVDate <='%s')or (cOrderCode is null and cInCode is null and cAuditDate<='%s')or (cOrderCode is not null and cInCode is null and cAuditDate<='%s') or (cPBVCode='36093854-36093855..' and cAuditDate<='%s'))",$a['cvencode'],$fahuomap,$fahuomap,$fahuomap,$fahuomap)->field("PBVID")->select();
				$pbvidlist=$PurbillvouchModel->where("cVenCode='".$a['cvencode']."' and PBVID!='1000000781' and ((cOrderCode is null and cInCode is null and cAuditDate<='".$fahuomap."') or (cOrderCode is not null and cInCode is null and cAuditDate<='".$fahuomap."') or (cPBVCode='36093854-36093855..' and cAuditDate<='".$fahuomap."'))")->field("PBVID")->select();
				$pbvid=array();
				foreach($pbvidlist as $d){
					$pbvid[]=$d['pbvid'];
				}
				$pbvidstr=implode(",",$pbvid);
				$jiesuan=0;
				if(!empty($pbvid)){
					$jiesuan=$PurbillvouchsModel->where("PBVID in(".$pbvidstr.")")->sum("iSum");
				}
				$info['shouhuo']=$chukudan+$jiesuan;
				
				//客户收付款单余额
				$fukuan=$ClosebillModel->where("cVouchType=49  and cFlag='AP' and dVouchDate >='2017-08-01' and dVouchDate <='%s' and cDwCode='%s'",$fahuomap,$a['cvencode'])->sum('iAmount');
				//客户应付冲应收
				$fuchongshou=$AccvouchModel->where("coutsign='ZZ' and doutdate >='2017-08-01' and doutdate <='%s' and csup_id='%s'",$fahuomap,$a['cvencode'])->sum('md');
				//客户收付款单余额
				$shoukuan=$ClosebillModel->where("cVouchType=48 and cFlag='AP' and dVouchDate >='2017-08-01' and dVouchDate <='%s' and cDwCode='%s'",$fahuomap,$a['cvencode'])->sum('iAmount');
				
				$info['shoufukuan']=$fukuan+$fuchongshou-$shoukuan;
				//应付
				$qiankuan=$info['qichu']+$info['shouhuo']-$info['shoufukuan'];
				$qiankuan=round($qiankuan,2);
				if($qiankuan!=0){
					$info['cvenpperson']=$PersonModel->where("cPersonCode='%s'",$info['cvenpperson'])->getField('cPersonName');
					$info['yingfu']=$qiankuan;
					$yingfu=$yingfu+$qiankuan;
					$datalist[]=$info;
				}
				
				
			}
		}
		$this->assign('pagetitle','供应商分析');
		$this->assign('datalist',$datalist);
		$this->assign('yingfu',$yingfu);
		$this->assign('personlist',$personlist);
		$this->display();
    }
	
	public function exportExcel(){
		$xlsTitle = iconv('utf-8', 'gb2312', '供应商分析');//文件名称
		$expCellName  = array(
		array('cvencode','编号'),
		array('cvenabbname','名称'),
		array('cvenpperson','业务员'),
		array('jiefang','期初借方'),
		array('daifang','期初贷方'),
		array('shouhuo','到货'),
		array('shoufukuan','付款'),
		array('yingfu','应付')
		);
		$cellNum = count($expCellName);//多少列
		//$dataNum = count($expTableData);//多少行
		vendor("PHPExcel.PHPExcel");
			
		$objPHPExcel = new \PHPExcel();//实例化PHPExcel类
		$cellName = array('A','B','C','D','E','F','G','H','I');
		//'A','B','C','D','E','F','G','H','I'
		for($i=0;$i<9;$i++){
			$objPHPExcel->getActiveSheet(0)->setCellValue($cellName[$i].'1', $expCellName[$i][1]);//设置表头值
		}
		//U8人员档案
		$PersonModel=M('Person','dbo.','U8');
		//U8人员档案
		$personlist=$PersonModel->where("cDepCode=304")->field("cPersonCode,cPersonName")->select();
		//U8供应商
		$VendorModel=M('Vendor','dbo.','U8');
		//U8入库单主表
		$RdRecordModel=M('Rdrecord01','dbo.','U8');
		//U8入库单子表
		$RdrecordsModel=M('Rdrecords01','dbo.','U8');
		//U8采购发票主表
		$PurbillvouchModel=M('Purbillvouch','dbo.','U8');
		//U8采购发票子表
		$PurbillvouchsModel=M('Purbillvouchs','dbo.','U8');
		//U8应付期初数据
		$ApdetailModel=M('Detail','dbo.ap_','U8');
		//U8应付
		$ClosebillModel=M('Closebill','dbo.ap_','U8');
		//U8凭证及明细
		$AccvouchModel=M('accvouch','dbo.GL_','U8');
		$fahuomap=session('ranalysisvendortime');
		$nowtime=time();
		if(empty($fahuomap)){
			$fahuomap=date('Y-m-d',$nowtime);
		}
		$analysis_vendor_dir=session('ranalysisvendor');
		//拼接客户名称
		if(!empty($analysis_vendor_dir)){
			//客户列表
			$vendorlist=$VendorModel->where("dEndDate is null and cVenPPerson='%s'",$analysis_vendor_dir)->field('cVenCode,cVenAbbName,cVenPPerson')->select();
		}else{
			//客户列表
			$vendorlist=$VendorModel->where("dEndDate is null")->field('cVenCode,cVenAbbName,cVenPPerson')->order('cVenCode asc')->select();
		}
		$datalist=array();
		
		foreach($vendorlist as $a){
			$info=array();
				$info=$a;
				//客户期初借方
				$info['jiefang']=$ApdetailModel->where("cDwCode='%s' and dRegDate < '2017-08-01' and csign is NULL",$a['cvencode'])->sum('iDAmount');
				//客户期初贷方
				$info['daifang']=$ApdetailModel->where("cDwCode='%s' and dRegDate < '2017-08-01' and csign is not NULL",$a['cvencode'])->sum('iCAmount');
				$info['qichu']=$info['daifang']-$info['jiefang'];
				
				//期初入库单
				$qichulist=$RdRecordModel->where("dDate <='2017-07-31' and cVenCode='%s'",$a['cvencode'])->field("ID")->select();
				//得到该客户的所有入库单主表ID
				$dlidlist=$RdRecordModel->where("dVeriDate is not NULL and dVeriDate <='%s' and cVenCode='%s'",$fahuomap,$a['cvencode'])->field("ID")->select();
				//未开票
				$dlid=array();
				foreach($qichulist as $b){
					$dlid[]=$b['id'];
				}
				foreach($dlidlist as $c){
					$dlid[]=$c['id'];
				}
				$dlidstr=implode(",",$dlid);
				/*
				
				$weijiesuan=0;
				if(!empty($dlid)){
					//$weijiesuan=$RdrecordsModel->where("ID in(".$dlidstr.") and dSDate is null")->sum('iSum');
					$weijiesuan=$RdrecordsModel->where("ID in(".$dlidstr.")")->sum('iSum');
				}
				*/
				$chukudan=0;
				$fapiao=array();
				
				$chukudan=$chukudan+$RdrecordsModel->where("ID in(".$dlidstr.") and dSDate is null")->sum('iSum');
				$fapiaoid=$RdrecordsModel->where("ID in(".$dlidstr.") and dSDate is not null")->field('AutoID')->select();
				foreach($fapiaoid as $f){
				$fapiao[]=$f['autoid'];
				}
				if(!empty($fapiao)){
					$fapiaostr=implode(",",$fapiao);
					$chukudan=$chukudan+$PurbillvouchsModel->where("RdsId in(".$fapiaostr.")")->sum("iSum");
				}
				//已开票金额
				//$pbvidlist=$PurbillvouchModel->where("cVenCode='%s' and((dverifydate is not null and dPBVDate <='%s')or (cOrderCode is null and cInCode is null and cAuditDate<='%s')or (cOrderCode is not null and cInCode is null and cAuditDate<='%s') or (cPBVCode='36093854-36093855..' and cAuditDate<='%s'))",$a['cvencode'],$fahuomap,$fahuomap,$fahuomap,$fahuomap)->field("PBVID")->select();
				$pbvidlist=$PurbillvouchModel->where("cVenCode='".$a['cvencode']."' and PBVID!='1000000781' and ((cOrderCode is null and cInCode is null and cAuditDate<='".$fahuomap."') or (cOrderCode is not null and cInCode is null and cAuditDate<='".$fahuomap."') or (cPBVCode='36093854-36093855..' and cAuditDate<='".$fahuomap."'))")->field("PBVID")->select();
				$pbvid=array();
				foreach($pbvidlist as $d){
					$pbvid[]=$d['pbvid'];
				}
				$pbvidstr=implode(",",$pbvid);
				$jiesuan=0;
				if(!empty($pbvid)){
					$jiesuan=$PurbillvouchsModel->where("PBVID in(".$pbvidstr.")")->sum("iSum");
				}
				$info['shouhuo']=$chukudan+$jiesuan;
				
				//客户收付款单余额
				$fukuan=$ClosebillModel->where("cVouchType=49  and cFlag='AP' and dVouchDate >='2017-08-01' and dVouchDate <='%s' and cDwCode='%s'",$fahuomap,$a['cvencode'])->sum('iAmount');
				//客户应付冲应收
				$fuchongshou=$AccvouchModel->where("coutsign='ZZ' and doutdate >='2017-08-01' and doutdate <='%s' and csup_id='%s'",$fahuomap,$a['cvencode'])->sum('md');
				//客户收付款单余额
				$shoukuan=$ClosebillModel->where("cVouchType=48 and cFlag='AP' and dVouchDate >='2017-08-01' and dVouchDate <='%s' and cDwCode='%s'",$fahuomap,$a['cvencode'])->sum('iAmount');
				
				$info['shoufukuan']=$fukuan+$fuchongshou-$shoukuan;
				//应付
				$qiankuan=$info['qichu']+$info['shouhuo']-$info['shoufukuan'];
				$qiankuan=round($qiankuan,2);
				if($qiankuan!=0){
					$info['cvenpperson']=$PersonModel->where("cPersonCode='%s'",$info['cvenpperson'])->getField('cPersonName');
					$info['yingfu']=$qiankuan;
					$yingfu=$yingfu+$qiankuan;
					$datalist[]=$info;
				}
			
		}
		$count=count($datalist);
		//设置表内容    
		for($i=0;$i<$count;$i++){
			for($j=0;$j<$cellNum;$j++){
				$objPHPExcel->getActiveSheet(0)->setCellValue($cellName[$j].($i+2),$datalist[$i][$expCellName[$j][0]]);
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