<?php
namespace lib;

class Fukuan {
	public function gongyingshang($fahuo){
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
		$datalist=array();
		$nowtime=time();
		//计算当月多少天
		$tianshu = date('t',$fahuo);
		$year=date('Y',$fahuo);
		$month=date('m',$fahuo);
		//供应商列表
		$vendorlist=$VendorModel->where("dEndDate is null")->field('cVenCode')->select();
		$vendor=array();
		foreach($vendorlist as $a){
			$vendor[]=$a['cvencode'];
		}
		$vendorstr=implode(",",$vendor);
		//供应商期初借方
		$jiefang=$ApdetailModel->where("cDwCode in (".$vendorstr.") and dRegDate < '2017-08-01' and csign is NULL")->sum('iDAmount');
		//供应商期初贷方
		$daifang=$ApdetailModel->where("cDwCode in (".$vendorstr.") and dRegDate < '2017-08-01' and csign is not NULL")->sum('iCAmount');
		$qichu=$daifang-$jiefang;
		$tian=array();
		$count=array();
		//遍历天数
		for($i=1;$i<=$tianshu;$i++){
			if($i<10){
				$fahuostr=$year."-".$month."-0".$i;
			}else{
				$fahuostr=$year."-".$month."-".$i;
			}
			$fahuotime=strtotime($fahuostr);
			$fahuomap=$fahuostr;
			if($fahuotime<=$nowtime){
				$tian[]=$fahuomap;
				//得到该供应商的所有入库单主表ID
				$dlidlist=$RdRecordModel->where("dVeriDate is not NULL and dVeriDate <='".$fahuomap."' and cVenCode in (".$vendorstr.")")->field("ID")->select();
				//期初
				$qichulist=$RdRecordModel->where("dDate <='2017-07-31' and cVenCode in(".$vendorstr.")")->field("ID")->select();
				$dlid=array();
				foreach($dlidlist as $e){
					$dlid[]=$e['id'];
				}
				foreach($qichulist as $e){
					$dlid[]=$e['id'];
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
				//$pbvidlist=$PurbillvouchModel->where("cVenCode in(".$vendorstr.") and ((dverifydate is not null and dPBVDate <='".$fahuomap."')or (cOrderCode is null and cInCode is null and cAuditDate<='".$fahuomap."')or (cOrderCode is not null and cInCode is null and cAuditDate<='".$fahuomap."') or (cPBVCode='36093854-36093855..' and cAuditDate<='".$fahuomap."'))")->field("PBVID")->select();
				$pbvidlist=$PurbillvouchModel->where("cVenCode in(".$vendorstr.") and PBVID!='1000000781' and ((cOrderCode is null and cInCode is null and cAuditDate<='".$fahuomap."') or (cOrderCode is not null and cInCode is null and cAuditDate<='".$fahuomap."') or (cPBVCode='36093854-36093855..' and cAuditDate<='".$fahuomap."'))")->field("PBVID")->select();
				$pbvid=array();
				foreach($pbvidlist as $d){
					$pbvid[]=$d['pbvid'];
				}
				$pbvidstr=implode(",",$pbvid);
				$jiesuan=0;
				if(!empty($pbvid)){
					$jiesuan=$PurbillvouchsModel->where("PBVID in(".$pbvidstr.")")->sum("iSum");
				}
				$shouhuo=$chukudan+$jiesuan;
				//供应商付款单余额
				$fukuan=$ClosebillModel->where("cVouchType=49  and cFlag='AP' and dVouchDate >='2017-08-01' and dVouchDate <='".$fahuomap."' and cDwCode in (".$vendorstr.")")->sum('iAmount');
				//供应商应付冲应收
				$fuchongshou=$AccvouchModel->where("coutsign='ZZ' and doutdate >='2017-08-01' and doutdate <='".$fahuomap."' and csup_id in (".$vendorstr.")")->sum('md');
				//供应商收款单余额
				$shoukuan=$ClosebillModel->where("cVouchType=48 and cFlag='AP' and dVouchDate >='2017-08-01' and dVouchDate <='".$fahuomap."' and cDwCode in (".$vendorstr.")")->sum('iAmount');
				
				$shoufukuan=$fukuan+$fuchongshou-$shoukuan;
				//计算欠款
				$zong=$qichu+$shouhuo-$shoufukuan;
				$count[]=round($zong,2);
			}
		}
		$datalist['tian']=$tian;
		$datalist['count']=$count;
		return $datalist;
	}
	
	public function export($fahuo){
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
		$datalist=array();
		$nowtime=time();
		//计算当月多少天
		$tianshu = date('t',$fahuo);
		$year=date('Y',$fahuo);
		$month=date('m',$fahuo);
		//客户列表
		$vendorlist=$VendorModel->where("dEndDate is null")->field('cVenCode')->select();
		$vendor=array();
		foreach($vendorlist as $a){
			$vendor[]=$a['cvencode'];
		}
		$vendorstr=implode(",",$vendor);
		//供应商期初借方
		$jiefang=$ApdetailModel->where("cDwCode in (".$vendorstr.") and dRegDate < '2017-08-01' and csign is NULL")->sum('iDAmount');
		//供应商期初贷方
		$daifang=$ApdetailModel->where("cDwCode in (".$vendorstr.") and dRegDate < '2017-08-01' and csign is not NULL")->sum('iCAmount');
		$qichu=$daifang-$jiefang;
		//遍历天数
		for($i=1;$i<=$tianshu;$i++){
			if($i<10){
				$fahuostr=$year."-".$month."-0".$i;
			}else{
				$fahuostr=$year."-".$month."-".$i;
			}
			$fahuotime=strtotime($fahuostr);
			$fahuomap=$fahuostr;
			if($fahuotime<=$nowtime){
				$info=array();
				$info['tian']=$fahuomap;
				//得到该供应商的所有入库单主表ID
				$dlidlist=$RdRecordModel->where("dVeriDate is not NULL and dVeriDate <='".$fahuomap."' and cVenCode in (".$vendorstr.")")->field("ID")->select();
				//期初
				$qichulist=$RdRecordModel->where("dDate <='2017-07-31' and cVenCode in(".$vendorstr.")")->field("ID")->select();
				$dlid=array();
				foreach($dlidlist as $e){
					$dlid[]=$e['id'];
				}
				foreach($qichulist as $e){
					$dlid[]=$e['id'];
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
				//$pbvidlist=$PurbillvouchModel->where("cVenCode in(".$vendorstr.") and ((dverifydate is not null and dPBVDate <='".$fahuomap."')or (cOrderCode is null and cInCode is null and cAuditDate<='".$fahuomap."')or (cOrderCode is not null and cInCode is null and cAuditDate<='".$fahuomap."') or (cPBVCode='36093854-36093855..' and cAuditDate<='".$fahuomap."'))")->field("PBVID")->select();
				$pbvidlist=$PurbillvouchModel->where("cVenCode in(".$vendorstr.") and PBVID!='1000000781' and ((cOrderCode is null and cInCode is null and cAuditDate<='".$fahuomap."') or (cOrderCode is not null and cInCode is null and cAuditDate<='".$fahuomap."') or (cPBVCode='36093854-36093855..' and cAuditDate<='".$fahuomap."'))")->field("PBVID")->select();
				$pbvid=array();
				foreach($pbvidlist as $d){
					$pbvid[]=$d['pbvid'];
				}
				$pbvidstr=implode(",",$pbvid);
				$jiesuan=0;
				if(!empty($pbvid)){
					$jiesuan=$PurbillvouchsModel->where("PBVID in(".$pbvidstr.")")->sum("iSum");
				}
				$shouhuo=$chukudan+$jiesuan;
				
				//供应商付款单余额
				$fukuan=$ClosebillModel->where("cVouchType=49  and cFlag='AP' and dVouchDate >='2017-08-01' and dVouchDate <='".$fahuomap."' and cDwCode in (".$vendorstr.")")->sum('iAmount');
				//供应商应付冲应收
				$fuchongshou=$AccvouchModel->where("coutsign='ZZ' and doutdate >='2017-08-01' and doutdate <='".$fahuomap."' and csup_id in (".$vendorstr.")")->sum('md');
				//供应商收款单余额
				$shoukuan=$ClosebillModel->where("cVouchType=48 and cFlag='AP' and dVouchDate >='2017-08-01' and dVouchDate <='".$fahuomap."' and cDwCode in (".$vendorstr.")")->sum('iAmount');
				
				$shoufukuan=$fukuan+$fuchongshou-$shoukuan;
				//计算欠款
				$zong=$qichu+$shouhuo-$shoufukuan;
				$info['count']=round($zong,2);
				$datalist[]=$info;
			}
		}
		return $datalist;
	}
}


?>