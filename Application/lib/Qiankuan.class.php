<?php
namespace lib;

class Qiankuan {
	public function kehu($fahuo){
		//U8客户
		$CustomerModel=M('Customer','dbo.','U8');
		//U8发货单主表
		$DispatchlistModel=M('Dispatchlist','dbo.','U8');
		//U8发货单子表
		$DispatchlistsModel=M('Dispatchlists','dbo.','U8');
		//U8应收期初数据
		$ArdetailModel=M('Detail','dbo.ar_','U8');
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
		$customerlist=$CustomerModel->where("dEndDate is null")->field('cCusCode')->select();
		$customer=array();
		foreach($customerlist as $a){
			$customer[]=$a['ccuscode'];
		}
		$customerstr=implode(",",$customer);
		//客户期初借方
		$jiefang=$ArdetailModel->where("cDwCode in (".$customerstr.") and dRegDate < '2017-08-01' and csign = 'Z'")->sum('iDAmount');
		//客户期初贷方
		$daifang=$ArdetailModel->where("cDwCode in (".$customerstr.") and dRegDate < '2017-08-01' and csign is NULL")->sum('iCAmount');
		$qichu=$jiefang-$daifang;
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
				//得到客户的所有发货单主表ID
				$dlidlist=$DispatchlistModel->where("cCusCode !='好的230216' and dverifysystime is not NULL and dverifydate <='".$fahuomap."' and cCusCode in(".$customerstr.")")->field("DLID")->select();
				$dlid=array();
				foreach($dlidlist as $e){
					$dlid[]=$e['dlid'];
				}
				$dlidstr=implode(",",$dlid);
				$fahuo=$DispatchlistsModel->where("DLID in(".$dlidstr.")")->sum('iNatSum');
				
				//客户付款单余额
				$fukuan=$ClosebillModel->where("cVouchType=49  and cFlag='AR' and dVouchDate >='2017-08-01' and dVouchDate <='".$fahuomap."' and cDwCode in (".$customerstr.")")->sum('iAmount');
				//客户应付冲应收
				$fuchongshou=$AccvouchModel->where("(coutsign='ZZ' or coutsign='HZ' ) and doutdate <='".$fahuomap."' and ccus_id in (".$customerstr.")")->sum('mc');
				//客户收款单余额
				$shoukuan=$ClosebillModel->where("cVouchType=48 and cDwCode !='好的230216' and cFlag='AR' and dVouchDate >='2017-08-01' and dVouchDate <='".$fahuomap."' and cDwCode in (".$customerstr.")")->sum('iAmount');
				
				$shoufukuan=$shoukuan+$fuchongshou-$fukuan;
				//计算欠款
				$zong=$qichu+$fahuo-$shoufukuan;
				$count[]=abs(round($zong,2));
			}
		}
		$datalist['tian']=$tian;
		$datalist['count']=$count;
		return $datalist;
	}
	
	public function export($fahuo){
		//U8客户
		$CustomerModel=M('Customer','dbo.','U8');
		//U8发货单主表
		$DispatchlistModel=M('Dispatchlist','dbo.','U8');
		//U8发货单子表
		$DispatchlistsModel=M('Dispatchlists','dbo.','U8');
		//U8应收期初数据
		$ArdetailModel=M('Detail','dbo.ar_','U8');
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
		$customerlist=$CustomerModel->where("dEndDate is null")->field('cCusCode')->select();
		$customer=array();
		foreach($customerlist as $a){
			$customer[]=$a['ccuscode'];
		}
		$customerstr=implode(",",$customer);
		//客户期初借方
		$jiefang=$ArdetailModel->where("cDwCode in (".$customerstr.") and dRegDate < '2017-08-01' and csign = 'Z'")->sum('iDAmount');
		//客户期初贷方
		$daifang=$ArdetailModel->where("cDwCode in (".$customerstr.") and dRegDate < '2017-08-01' and csign is NULL")->sum('iCAmount');
		$qichu=$jiefang-$daifang;
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
				$info=array();
				$info['tian']=$fahuomap;
				//得到该客户的所有发货单主表ID
				$dlidlist=$DispatchlistModel->where("cCusCode !='好的230216' and dverifysystime is not NULL and dverifydate <='".$fahuomap."' and cCusCode in(".$customerstr.")")->field("DLID")->select();
				$dlid=array();
				foreach($dlidlist as $e){
					$dlid[]=$e['dlid'];
				}
				$dlidstr=implode(",",$dlid);
				$fahuo=$DispatchlistsModel->where("DLID in(".$dlidstr.")")->sum('iNatSum');
				
				//客户收付款单余额
				$fukuan=$ClosebillModel->where("cVouchType=49  and cFlag='AR' and dVouchDate >='2017-08-01' and dVouchDate <='".$fahuomap."' and cDwCode in (".$customerstr.")")->sum('iAmount');
				//客户应付冲应收
				$fuchongshou=$AccvouchModel->where("(coutsign='ZZ' or coutsign='HZ' ) and doutdate <='".$fahuomap."' and ccus_id in (".$customerstr.")")->sum('mc');
				//客户收付款单余额
				$shoukuan=$ClosebillModel->where("cVouchType=48 and cDwCode !='好的230216' and cFlag='AR' and dVouchDate >='2017-08-01' and dVouchDate <='".$fahuomap."' and cDwCode in (".$customerstr.")")->sum('iAmount');
				
				$shoufukuan=$shoukuan+$fuchongshou-$fukuan;
				//计算欠款
				$zong=$qichu+$fahuo-$shoufukuan;
				$info['count']=abs(round($zong,2));
				$datalist[]=$info;
			}
		}
		return $datalist;
	}
}





?>