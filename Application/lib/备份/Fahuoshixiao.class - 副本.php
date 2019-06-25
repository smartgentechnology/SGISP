<?php
namespace lib;

class Fahuoshixiao {
	public function fahuodan($datalist,$fahuomap){
		$changelist=array();
		$fahuolist=array();
		$weifahuolist=array();
		//U8发货单主表
		$DispatchlistModel=M('Dispatchlist','dbo.','U8');
		//U8发货单子表
		$DispatchlistsModel=M('Dispatchlists','dbo.','U8');
		//客户档案表
		$CustomerModel=M('Customer','dbo.','U8');
		if(!empty($datalist)){
			foreach($datalist as $i=>$c){
				//根据销售订单和审核人查询发货单
				$dispatchlist=$DispatchlistModel->where($fahuomap." and cSOCode='".$c['csocode']."'")->field("cCusName,DLID,dverifysystime")->select();
				$g=0;
				if(!empty($dispatchlist)){
					foreach($dispatchlist as $d){
						//根据发货单ID和存货编码查询发货数量
						$dispatchlists=$DispatchlistsModel->where("DLID ='%s'",$d['dlid'])->field("iQuantity")->select();
						if(!empty($dispatchlists)){
							foreach($dispatchlists as $e){
								if($e['iquantity']>0){
									$f=array();
									$f=$c;
									$f['ccusname']=$d['ccusname'];
									$f['fahuotime']=$d['dverifysystime'];
									$f['jiange']=strtotime($f['fahuotime'])-strtotime($f['dverifysystime']);
									$tian=$f['jiange']/86400;
									$f['tian']=round($tian,2);
									$f['fiquantity']=intval($e['iquantity']);
									$fahuolist[]=$f;
								}
								$g++;
							}
						}
					}
					if($g==0){
						$c['ccusname']=$CustomerModel->where("cCusCode='%s'",$c['ccuscode'])->getField('cCusAbbName');
						$c['fahuotime']='';
						/*$c['jiange']=time()-strtotime($c['dverifysystime']);;
						$tian=$c['jiange']/86400;
						$c['tian']=round($tian,2);
						$c['fiquantity']=0;
						*/
						$c['jiange']="";
						$c['tian']="";
						$c['fiquantity']="";
						$weifahuolist[]=$c;
					}
				}else{
					$c['ccusname']=$CustomerModel->where("cCusCode='%s'",$c['ccuscode'])->getField('cCusAbbName');
					$c['fahuotime']="";
					$c['jiange']="";
					//$tian=$c['jiange']/86400;
					$c['tian']="";
					$c['fiquantity']="";
					$weifahuolist[]=$c;
				}
				
			}
		}
		$changelist[0]=$fahuolist;
		$changelist[1]=$weifahuolist;
		return $changelist;
	}
	public function tongji($datalist){
		$tongji=array();
		if(!empty($datalist)){
			$zong=count($datalist);
			$shijian=0;
			foreach($datalist as $value){
				//9小时
				if($value['jiange']<=32400){
					$tongji[0]++;
				}
				//1天内
				if($value['jiange']<=86400){
					$tongji[1]++;
				}
				//1-3天
				if($value['jiange']>86400 && $value['jiange']<=259200){
					$tongji[2]++;
				}
				//3-10天
				if($value['jiange']>259200 && $value['jiange']<=864000){
					$tongji[3]++;
				}
				//10-15天
				if($value['jiange']>864000 && $value['jiange']<=1296000){
					$tongji[4]++;
				}
				//15-20天
				if($value['jiange']>1296000 && $value['jiange']<=1728000){
					$tongji[5]++;
				}
				//20-31天
				if($value['jiange']>1728000 && $value['jiange']<=2678400){
					$tongji[6]++;
				}
				$shijian=$shijian+$value['jiange'];
			}
			$tongji[7]=$shijian/$zong;
			foreach($datalist as $value){
				//<=平均值
				if($value['jiange']<=$tongji[7]){
					$tongji[8]++;
				}
				//<3天
				if($value['jiange']<259200){
					$tongji[9]++;
				}
				//>=3天
				if($value['jiange']>=259200){
					$tongji[10]++;
				}
				//>=10天
				if($value['jiange']>=864000){
					$tongji[11]++;
				}
				//>=15天
				if($value['jiange']>=1296000){
					$tongji[12]++;
				}
				//>=20天
				if($value['jiange']>=1728000){
					$tongji[13]++;
				}
			}
			$tongji[14]=$zong;
			
		}
		return $tongji;
	}
	public function export($datalist,$fahuomap){
		$changelist=array();
		$fahuolist=array();
		$weifahuolist=array();
		//U8发货单主表
		$DispatchlistModel=M('Dispatchlist','dbo.','U8');
		//U8发货单子表
		$DispatchlistsModel=M('Dispatchlists','dbo.','U8');
		//客户档案表
		$CustomerModel=M('Customer','dbo.','U8');
		if(!empty($datalist)){
			foreach($datalist as $i=>$c){
				//根据销售订单和审核人查询发货单
				$dispatchlist=$DispatchlistModel->where("cSOCode='".$c['csocode']."' and ".$fahuomap)->field("cCusName,DLID,dverifysystime")->select();
				$g=0;
				if(!empty($dispatchlist)){
					foreach($dispatchlist as $d){
						//根据发货单ID和存货编码查询发货数量
						$dispatchlists=$DispatchlistsModel->where("DLID ='%s'",$d['dlid'])->field("iQuantity")->select();
						if(!empty($dispatchlists)){
							foreach($dispatchlists as $e){
								if($e['iquantity']>0){
									$f=array();
									$f=$c;
									$f['ccusname']=$d['ccusname'];
									$f['fahuotime']=$d['dverifysystime'];
									$f['jiange']=strtotime($f['fahuotime'])-strtotime($f['dverifysystime']);
									$tian=$f['jiange']/86400;
									$f['tian']=round($tian,2);
									$shi=$f['jiange']/3600;
									$f['shi']=round($shi,2);
									$f['fiquantity']=intval($e['iquantity']);
									$fahuolist[]=$f;
								}
								$g++;
							}
						}
					}
					if($g==0){
						$c['ccusname']=$CustomerModel->where("cCusCode='%s'",$c['ccuscode'])->getField('cCusAbbName');
						
						$c['fahuotime']='';
						/*
						$c['jiange']=time()-strtotime($c['dverifysystime']);
						$tian=$c['jiange']/86400;
						$c['tian']=round($tian,2);
						$shi=$c['jiange']/3600;
						$c['shi']=round($shi,2);
						$c['fiquantity']=0;
						*/
						$c['jiange']="";
						$c['tian']="";
						$c['shi']="";
						$c['fiquantity']="";
						$weifahuolist[]=$c;
					}
				}else{
					$c['ccusname']=$CustomerModel->where("cCusCode='%s'",$c['ccuscode'])->getField('cCusAbbName');
					$c['fahuotime']='';
					$c['jiange']="";
						$c['tian']="";
						$c['shi']="";
						$c['fiquantity']="";
					$weifahuolist[]=$c;
				}
				
			}
		}
		$changelist[0]=$fahuolist;
		$changelist[1]=$weifahuolist;
		return $changelist;
	}
}





?>