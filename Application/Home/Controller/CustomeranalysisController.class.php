<?php
namespace Home\Controller;
use Common\Controller\AuthController;
class CustomeranalysisController extends AuthController {
	
    public function index(){
		//U8客户
		$CustomerModel=M('Customer','dbo.','U8');
		//U8人员档案
		$PersonModel=M('Person','dbo.','U8');
		//U8人员档案
		$personlist=$PersonModel->where("(cDepCode='602' or cDepCode='603' or cDepCode='606' or cDepCode='607' or cPersonName='崔文玉') and dPInValidDate is null")->field("cPersonCode,cPersonName")->select();
		//U8发货单主表
		$DispatchlistModel=M('Dispatchlist','dbo.','U8');
		//U8发货单子表
		$DispatchlistsModel=M('Dispatchlists','dbo.','U8');
		//U8应收期初数据
		$ArdetailModel=M('Detail','dbo.ar_','U8');
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
			$analysis_customer_dir=$data['analysis_customer_dir'];
			//截止日期
			$workplan_date_dir_end=$data['workplan_date_dir_end'];
			//拼接客户名称
			if(!empty($analysis_customer_dir)){
				//客户列表
				$customerlist=$CustomerModel->where("dEndDate is null and cCusPPerson='%s'",$analysis_customer_dir)->field('cCusCode,cCusAbbName,cCusPPerson')->order('cCusPPerson asc,cCusCode asc')->select();
			}else{
				//客户列表
				$customerlist=$CustomerModel->where("dEndDate is null")->field('cCusCode,cCusAbbName,cCusPPerson')->order('cCusPPerson asc,cCusCode asc')->select();
			}
			session('ranalysiscustomer',$analysis_customer_dir);
			$nowtime=time();
			//拼接完成日期
			if(!empty($workplan_date_dir_end)){
				$fahuomap=$workplan_date_dir_end;
			}else{
				$fahuomap=date('Y-m-d',$nowtime);
				
			}
			session('ranalysistime',$fahuomap);
			$datalist=array();
			$yingshou=0;
			$yingfu=0;
			foreach($customerlist as $a){
				$info=array();
				$info=$a;
				//客户期初借方
				$jiefang=$ArdetailModel->where("cDwCode='%s' and dRegDate < '2017-08-01' and csign = 'Z'",$a['ccuscode'])->sum('iDAmount');
				//客户期初贷方
				$daifang=$ArdetailModel->where("cDwCode='%s' and dRegDate < '2017-08-01' and csign is NULL",$a['ccuscode'])->sum('iCAmount');
				$info['qichu']=$jiefang-$daifang;
				
				//得到该客户的所有发货单主表ID
				$dlidlist=$DispatchlistModel->where("dverifydate is not NULL and dverifydate <='%s' and cCusCode='%s'",$fahuomap,$a['ccuscode'])->field("DLID,dverifydate")->order("dverifydate desc")->select();
				$dlid=array();
				if($dlidlist){
					foreach($dlidlist as $d=>$e){
						if($d==0){
							//第一次发货额
							$info['diyitime']=$e['dverifydate'];
							$info['diyijiange']=$nowtime-strtotime($info['diyitime']);
							$info['diyijine']=$DispatchlistsModel->where("DLID =%d",$e['dlid'])->sum('iNatSum');
						}elseif($d==1){
							//第二次发货额
							$info['diertime']=$e['dverifydate'];
							$info['dierjiange']=$nowtime-strtotime($info['diertime']);
							$info['dierjine']=$DispatchlistsModel->where("DLID =%d",$e['dlid'])->sum('iNatSum');
						}
						$dlid[]=$e['dlid'];
					}
				}else{
					//第一次发货额
					$info['diyitime']="2017-07-31";
					$info['diyijiange']=$nowtime-strtotime($info['diyitime']);
				}
				
				//总发货额
				if(!empty($dlid)){
					$dlidstr=implode(",",$dlid);
					$sum=$DispatchlistsModel->where("DLID in(".$dlidstr.")")->sum('iNatSum');
					$info['fahuo']=$info['fahuo']+$sum;
				}
				
				//客户收付款单余额
				$fukuan=$ClosebillModel->where("cVouchType=49 and cFlag='AR' and dVouchDate >='2017-08-01' and dVouchDate <='%s' and cDwCode='%s'",$fahuomap,$a['ccuscode'])->sum('iAmount');
				//客户应付冲应收
				$fuchongshou=$AccvouchModel->where("(coutsign='ZZ' or coutsign='HZ' ) and doutdate <='%s' and ccus_id='%s'",$fahuomap,$a['ccuscode'])->sum('mc');
				//客户收付款单余额
				$closebilllist=$ClosebillModel->where("cVouchType=48 and cFlag='AR' and dVouchDate >='2017-08-01' and dVouchDate <='%s' and cDwCode='%s'",$fahuomap,$a['ccuscode'])->field('dVouchDate,iAmount')->order('dVouchDate desc')->select();
				
				//获得第一、第二回款、收付款
				$shoukuan=0;
				if(!empty($closebilllist)){
					foreach($closebilllist as $f=>$g){
						if($f==0 and !empty($g['dvouchdate'])){
							$info['diyihuikuantime']=$g['dvouchdate'];
							$info['diyihuikuanjiange']=$nowtime-strtotime($info['diyihuikuantime']);
							$info['diyihuikuanjine']=$g['iamount'];
						}elseif($f==1 and !empty($g['dvouchdate'])){
							$info['dierhuikuantime']=$g['dvouchdate'];
							$info['dierhuikuanjiange']=$nowtime-strtotime($info['dierhuikuantime']);
							$info['dierhuikuanjine']=$g['iamount'];
							
						}
						$shoukuan=$shoukuan+$g['iamount'];
					}
				}else{
					//第一次回款
					if(!empty($dlidlist)){
						$info['diyihuikuantime']=$info['diyitime'];
						$info['diyihuikuanjiange']=$info['diyijiange'];
					}elseif(empty($dlidlist)){
						if($info['qichu']!=0){
							$info['diyihuikuantime']=$info['diyitime'];
							$info['diyihuikuanjiange']=$info['diyijiange'];
						}else{
							$info['diyihuikuantime']="2017-01-01";
							$info['diyihuikuanjiange']=$nowtime-strtotime($info['diyihuikuantime']);
						}
					}
				}
				$info['shoufukuan']=$shoukuan+$fuchongshou-$fukuan;
				
				//计算欠款
				$info['qiankuan']=$info['qichu']+$info['fahuo']-$info['shoufukuan'];
				$info['qiankuan']=round($info['qiankuan'],2);
				if($info['qiankuan']!=0){
					$info['cpersonname']=$PersonModel->where("cPersonCode='%s'",$info['ccuspperson'])->getField('cPersonName');
					if($info['qiankuan']>0){
						$info['yingshou']=$info['qiankuan'];
						$yingshou=$yingshou+$info['yingshou'];
						$datalist[]=$info;
					}else if($info['qiankuan']<0){
						$info['yingfu']=abs($info['qiankuan']);
						$yingfu=$yingfu+$info['yingfu'];
						$datalist[]=$info;
					}
				}
				
				
			}
		}
		$this->assign('pagetitle','客户分析');
		$this->assign('datalist',$datalist);
		$this->assign('yingshou',$yingshou);
		$this->assign('yingfu',$yingfu);
		$this->assign('personlist',$personlist);
		$this->display();
    }
	
	public function exportExcel(){
		$xlsTitle = iconv('utf-8', 'gb2312', '客户分析');//文件名称
		$expCellName  = array(
		array('ccuscode','客户编号'),
		array('ccusabbname','客户名称'),
		array('cpersonname','业务员'),
		array('qichu','期初（U8初始化2017.7.31）'),
		array('fahuo','发货（U8）'),
		array('shoufukuan','回款（U8）'),
		array('yingshou','应收（查询日应收）'),
		array('yingfu','应付（查询日应付）'),
		array('diyitime','最后一次发货的日期'),
		array('diyijiangetian','最后一次发货的日期距离查询日的天数'),
		array('diyijiangeyue','最后一次发货的日期距离查询日的月数'),
		array('diyijine','最后一次发货的金额'),
		array('diertime','倒数第二次发货的日期'),
		array('dierjiangetian','倒数第二次发货的日期距离查询日的天数'),
		array('dierjiangeyue','倒数第二次发货的日期距离查询日的月数'),
		array('dierjine','倒数第二次发货的金额'),
		array('diyihuikuantime','最后一次收款的日期'),
		array('diyihuikuanjiangetian','最后一次收款距离查询日的天数'),
		array('diyihuikuanjiangeyue','最后一次收款距离查询日的月数'),
		array('diyihuikuanjine','最后一次收款的金额'),
		array('dierhuikuantime','倒数第二次收款的日期'),
		array('dierhuikuanjiangetian','倒数第二次收款距离查询日的天数'),
		array('dierhuikuanjiangeyue','倒数第二次收款距离查询日的月数'),
		array('dierhuikuanjine','倒数第二次收款的金额'),
		array('itema','180天内客户家数'),
		array('itemb','181-365天客户家数'),
		array('itemc','超365天客户家数')
		);
		$cellNum = count($expCellName);//多少列
		//$dataNum = count($expTableData);//多少行
		vendor("PHPExcel.PHPExcel");
			
		$objPHPExcel = new \PHPExcel();//实例化PHPExcel类
		$cellName = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA');
		$objPHPExcel->getActiveSheet(0)->setTitle("客户欠款详情");
		//'A','B','C','D','E','F','G','H','I'
		for($i=0;$i<27;$i++){
			$objPHPExcel->getActiveSheet(0)->setCellValue($cellName[$i].'1', $expCellName[$i][1]);//设置表头值
		}
		//U8客户
		$CustomerModel=M('Customer','dbo.','U8');
		//U8人员档案
		$PersonModel=M('Person','dbo.','U8');
		//U8部门
		$DepartmentModel=M('Department','dbo.','U8');
		//U8发货单主表
		$DispatchlistModel=M('Dispatchlist','dbo.','U8');
		//U8发货单子表
		$DispatchlistsModel=M('Dispatchlists','dbo.','U8');
		//U8应收期初数据
		$ArdetailModel=M('Detail','dbo.ar_','U8');
		//U8应付期初数据
		$ApdetailModel=M('Detail','dbo.ap_','U8');
		//U8应付
		$ClosebillModel=M('Closebill','dbo.ap_','U8');
		//U8凭证及明细
		$AccvouchModel=M('accvouch','dbo.GL_','U8');
		$fahuomap=session('ranalysistime');
		$nowtime=time();
		if(empty($fahuomap)){
			$fahuomap=date('Y-m-d',$nowtime);
		}
		$analysis_customer_dir=session('ranalysiscustomer');
		//拼接客户名称
		if(!empty($analysis_customer_dir)){
			//客户列表
			$customerlist=$CustomerModel->where("dEndDate is null and cCusPPerson='%s'",$analysis_customer_dir)->field('cCusCode,cCusAbbName,cCusPPerson')->order('cCusPPerson asc,cCusCode asc')->select();
		}else{
			//客户列表
			$customerlist=$CustomerModel->where("dEndDate is null")->field('cCusCode,cCusAbbName,cCusPPerson')->order('cCusPPerson asc,cCusCode asc')->select();
		}
		$datalist=array();
		$baobiaolist=array();
		foreach($customerlist as $a){
			$info=array();
			$info=$a;
			
			//客户期初借方
			$jiefang=$ArdetailModel->where("cDwCode='%s' and dRegDate < '2017-08-01' and csign = 'Z'",$a['ccuscode'])->sum('iDAmount');
			//客户期初贷方
			$daifang=$ArdetailModel->where("cDwCode='%s' and dRegDate < '2017-08-01' and csign is NULL",$a['ccuscode'])->sum('iCAmount');
			$info['qichu']=$jiefang-$daifang;
			
			//得到该客户的所有发货单主表ID
			$dlidlist=$DispatchlistModel->where("dverifydate is not NULL and dverifydate <='%s' and cCusCode='%s'",$fahuomap,$a['ccuscode'])->field("DLID,dverifydate")->order("dverifydate desc")->select();
			$dlid=array();
			if($dlidlist){
				foreach($dlidlist as $d=>$e){
					if($d==0){
						//第一次发货额
						$info['diyitime']=substr($e['dverifydate'],0,10);
						$diyijiange=$nowtime-strtotime($e['dverifydate']);
						$info['diyijiangetian']=round($diyijiange/86400,0);
						$info['diyijiangeyue']=round($diyijiange/2592000,1);
						$info['diyijine']=$DispatchlistsModel->where("DLID =%d",$e['dlid'])->sum('iNatSum');
					}elseif($d==1){
						//第二次发货额
						$info['diertime']=substr($e['dverifydate'],0,10);
						$dierjiange=$nowtime-strtotime($e['dverifydate']);
						$info['dierjiangetian']=round($dierjiange/86400,0);
						$info['dierjiangeyue']=round($dierjiange/2592000,1);
						$info['dierjine']=$DispatchlistsModel->where("DLID =%d",$e['dlid'])->sum('iNatSum');
					}
					$dlid[]=$e['dlid'];
				}
			}else{
				//第一次发货额
				$info['diyitime']="2017-07-31";
				$info['diyijiange']=$nowtime-strtotime($info['diyitime']);
				$diyijiange=$nowtime-strtotime($info['diyitime']);
				$info['diyijiangetian']=round($diyijiange/86400,0);
				$info['diyijiangeyue']=round($diyijiange/2592000,1);
			}
			
			//总发货额
			if(!empty($dlid)){
				$dlidstr=implode(",",$dlid);
				$sum=$DispatchlistsModel->where("DLID in(".$dlidstr.")")->sum('iNatSum');
				$info['fahuo']=$info['fahuo']+$sum;
			}
			
			//客户收付款单余额
			$fukuan=$ClosebillModel->where("cVouchType=49 and cFlag='AR' and dVouchDate >='2017-08-01' and dVouchDate <='%s' and cDwCode='%s'",$fahuomap,$a['ccuscode'])->sum('iAmount');
			//客户应付冲应收
			$fuchongshou=$AccvouchModel->where("(coutsign='ZZ' or coutsign='HZ' ) and doutdate <='%s' and ccus_id='%s'",$fahuomap,$a['ccuscode'])->sum('mc');
			//客户收付款单余额
			$closebilllist=$ClosebillModel->where("cVouchType=48 and cFlag='AR' and dVouchDate >='2017-08-01' and dVouchDate <='%s' and cDwCode='%s'",$fahuomap,$a['ccuscode'])->field('dVouchDate,iAmount')->order('dVouchDate desc')->select();
			
			//获得第一、第二回款、收付款
			$shoukuan=0;
			if(!empty($closebilllist)){
				foreach($closebilllist as $f=>$g){
					if($f==0 and !empty($g['dvouchdate'])){
						$info['diyihuikuantime']=substr($g['dvouchdate'],0,10);
						$diyihuikuanjiange=$nowtime-strtotime($g['dvouchdate']);
						$info['diyihuikuanjiangetian']=round($diyihuikuanjiange/86400,0);
						$info['diyihuikuanjiangeyue']=round($diyihuikuanjiange/2592000,1);
						$info['diyihuikuanjine']=$g['iamount'];
					}elseif($f==1 and !empty($g['dvouchdate'])){
						$info['dierhuikuantime']=substr($g['dvouchdate'],0,10);
						$dierhuikuanjiange=$nowtime-strtotime($g['dvouchdate']);
						$info['dierhuikuanjiangetian']=round($dierhuikuanjiange/86400,0);
						$info['dierhuikuanjiangeyue']=round($dierhuikuanjiange/2592000,1);
						$info['dierhuikuanjine']=$g['iamount'];
						
					}
					$shoukuan=$shoukuan+$g['iamount'];
				}
			}else{
				//第一次回款
				if(!empty($dlidlist)){
					$info['diyihuikuantime']=$info['diyitime'];
					$info['diyihuikuanjiangetian']=$info['diyijiangetian'];
					$info['diyihuikuanjiangeyue']=$info['diyijiangeyue'];
				}elseif(empty($dlidlist)){
					if($info['qichu']!=0){
						$info['diyihuikuantime']=$info['diyitime'];
						$info['diyihuikuanjiangetian']=$info['diyijiangetian'];
						$info['diyihuikuanjiangeyue']=$info['diyijiangeyue'];
					}else{
						$info['diyihuikuantime']="2017-01-01";
						$diyihuikuanjiange=$nowtime-strtotime($info['diyihuikuantime']);
						$info['diyihuikuanjiangetian']=round($diyihuikuanjiange/86400,0);
						$info['diyihuikuanjiangeyue']=round($diyihuikuanjiange/2592000,1);
					}
					
				}
			}
			$info['shoufukuan']=$shoukuan+$fuchongshou-$fukuan;
			
			//计算欠款
			$info['qiankuan']=$info['qichu']+$info['fahuo']-$info['shoufukuan'];
			$info['qiankuan']=round($info['qiankuan'],2);
			if($info['qiankuan']!=0){
				$info['cpersonname']=$PersonModel->where("cPersonCode='%s'",$info['ccuspperson'])->getField('cPersonName');
				if($info['diyihuikuanjiangetian']<=180){
					$info['itema']=$info['diyihuikuanjiangetian'];
				}elseif($info['diyihuikuanjiangetian']>180 && $info['diyihuikuanjiangetian']<=365){
					$info['itemb']=$info['diyihuikuanjiangetian'];
				}elseif($info['diyihuikuanjiangetian']>365){
					$info['itemc']=$info['diyihuikuanjiangetian'];
				}
				$baobiaoitem=array();
				$baobiaoitem['ccuspperson']=$info['ccuspperson'];
				$baobiaoitem['cpersonname']=$info['cpersonname'];
				$baobiaoitem['qiankuan']=$info['qiankuan'];
				$baobiaoitem['jiange']=$info['diyihuikuanjiangetian'];
				$baobiaolist[]=$baobiaoitem;
				if($info['qiankuan']>0){
					$info['yingshou']=$info['qiankuan'];
					$yingshou=$yingshou+$info['yingshou'];
					$datalist[]=$info;
				}else if($info['qiankuan']<0){
					$info['yingfu']=abs($info['qiankuan']);
					$yingfu=$yingfu+$info['yingfu'];
					$datalist[]=$info;
				}
			}
			
			
		}
		$count=count($datalist);
		//设置表内容    
		for($i=0;$i<$count;$i++){
			for($j=0;$j<$cellNum;$j++){
				$objPHPExcel->getActiveSheet(0)->setCellValue($cellName[$j].($i+2),$datalist[$i][$expCellName[$j][0]]);
			}             
		}
		
		
		$baobiaodata=array();
		//U8人员档案
		$personlist=$PersonModel->where("(cDepCode='602' or cDepCode='603' or cDepCode='606' or cDepCode='607' or cPersonName='崔文玉') and dPInValidDate is null")->field("cPersonCode,cPersonName,cDepCode")->select();
		foreach($personlist as $person){
			$personinfo=array();
			$personinfo['bumen']=$DepartmentModel->where("cDepCode='%s'",$person['cdepcode'])->getField("cDepName");
			$personinfo['cpersoncode']=$person['cpersoncode'];
			$personinfo['cpersonname']=$person['cpersonname'];
			foreach($baobiaolist as $value){
				if($person['cpersoncode']==$value['ccuspperson']){
					if($value['jiange']<=180){
						$personinfo['ajiashu']=$personinfo['ajiashu']+1;
						if($value['qiankuan']>0){
							$personinfo['ajine']=$personinfo['ajine']+$value['qiankuan'];
						}else{
							$personinfo['ayingfu']=$personinfo['ayingfu']+abs($value['qiankuan']);
						}
					}elseif($value['jiange']>180 && $value['jiange']<=365){
						$personinfo['bjiashu']=$personinfo['bjiashu']+1;
						if($value['qiankuan']>0){
							$personinfo['bjine']=$personinfo['bjine']+$value['qiankuan'];
						}else{
							$personinfo['byingfu']=$personinfo['byingfu']+abs($value['qiankuan']);
						}
					}elseif($value['jiange']>365){
						$personinfo['cjiashu']=$personinfo['cjiashu']+1;
						if($value['qiankuan']>0){
							$personinfo['cjine']=$personinfo['cjine']+$value['qiankuan'];
						}else{
							$personinfo['cyingfu']=$personinfo['cyingfu']+abs($value['qiankuan']);
						}
					}
					$personinfo['ejiashu']=$personinfo['ejiashu']+1;
					if($value['qiankuan']>0){
						$personinfo['fjine']=$personinfo['fjine']+$value['qiankuan'];
						
					}else if($value['qiankuan']<0){
						$personinfo['gjine']=$personinfo['gjine']+abs($value['qiankuan']);
					}
					$personinfo['ejine']=$personinfo['ejine']+$value['qiankuan'];
				}
			}
			$baobiaodata[]=$personinfo;
			
		}
		$keysValue=array();
		foreach($baobiaolist as $k =>$v){
			$keysValue[$k]=$v["qiankuan"];
		}
		array_multisort($keysValue,SORT_DESC,$baobiaolist);
		for($i=0;$i<20;$i++){
			foreach($baobiaodata as $key=>$value){
				if($baobiaolist[$i]['ccuspperson']==$value['cpersoncode']){
					$baobiaodata[$key]['djiashu']=$baobiaodata[$key]['djiashu']+1;
					$baobiaodata[$key]['djine']=$baobiaodata[$key]['djine']+$baobiaolist[$i]['qiankuan'];
				}
			}
		}
		//报表
		$baobiaoCellName= array(
		array('bumen','部门'),
		array('cpersonname','业务员'),
		array('ajiashu','180天内客户家数'),
		array('ajine','180天内欠款金额'),
		array('ayingfu','180天内应付金额'),
		array('bjiashu','181-365天客户家数'),
		array('bjine','181-365天欠款金额'),
		array('byingfu','181-365天应付金额'),
		array('cjiashu','超365天客户家数'),
		array('cjine','超365天欠款金额'),
		array('cyingfu','超365天应付金额'),
		array('djine','欠款前二十名欠款金额'),
		array('djiashu','欠款前二十名客户家数'),
		array('fjine','欠款总额'),
		array('gjine','预收款总额'),
		array('ejine','总欠款金额（欠款-预收）'),
		array('ejiashu','总欠款客户家数')
		);
		$baobiaolie = count($baobiaoCellName);//多少列
		$objPHPExcel->createSheet();
		$objPHPExcel->setactivesheetindex(1);
		$objPHPExcel->getActiveSheet(1)->setTitle("客户欠款报表");
		
		$lieName = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q');
		//'A','B','C','D','E','F','G','H','I'
		for($i=0;$i<$baobiaolie;$i++){
			$objPHPExcel->getActiveSheet(1)->setCellValue($lieName[$i].'1', $baobiaoCellName[$i][1]);//设置表头值
		}
		$baobiaodatacount=count($baobiaodata);
		//设置表内容 
		for($i=0;$i<$baobiaodatacount;$i++){
			for($j=0;$j<$baobiaolie;$j++){
				$objPHPExcel->getActiveSheet(1)->setCellValue($lieName[$j].($i+2),$baobiaodata[$i][$baobiaoCellName[$j][0]]);
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