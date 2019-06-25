<?php
namespace Home\Controller;
use Common\Controller\AuthController;
class FahuoshixiaoController extends AuthController {
	
    public function index(){
		//U8存货分类
		$InventoryClassModel=M('Inventoryclass','dbo.','U8');
		//U8销售订单主表
		$SomainModel=M('Somain','dbo.so_','U8');
		//U8销售订单子表
		$SodetailsModel=M('Sodetails','dbo.so_','U8');
		//U8型号表
		$InventoryModel=M('Inventory','dbo.','U8');
		//常规产品
		$changgui=array('020207','020210','020211','020215','020216','020217','020219','020220','020221','020222','020224','02020101','02020102','02020103','020201014','02020105','02020106','02020107','02020108','02020109','02020110','02020111','02020112','02020113','02020114','02020115','02020116','02020117','02020118','02020119','02020120','02020122','02020122','02020124','02020127','02020128','02020129','02020131','02020132','02020204','02020205','02020206','02020207','02020208','02020209','02020301','02020302','02020303','020208','020227','020209');
		$kongzhigui=array('020305','02030601','02030602','02030603','02030604','02030701','02030702','020308');
		//$jiareqi=array('020209');
		$waigou=array('02040101','02040102','02040102','02040201','02040202','02040203','02040204','02040205','020403','02050101','02050102','02050103','02050104','020502','020601','020602','0208');
		if(IS_POST){
			$data=I('post.');
			//得到查询条件
			//完成日期
			$fahuoshixiao_date_dir=$data['fahuoshixiao_date_dir'];
			
			//拼接完成日期
			if(!empty($fahuoshixiao_date_dir)){
				$year=$fahuoshixiao_date_dir;
				
			}elseif(empty($fahuoshixiao_date_dir)){
				$year=date('Y',time());
			}
			$fahuomap="dverifysystime<='".$workplan_date_dir_end."'";
			session('fahuoshixiaomap',$year);
			$datalist=array();
			$data1=array();
			$data2=array();
			$data3=array();
			$data4=array();
			$data5=array();
			$data6=array();
			for($i=1;$i<=12;$i++){
				if($i<10){
					$fahuomap="dverifysystime>='".$year."-0".$i."-01' and dverifysystime<='".$year."-0".$i."-".cal_days_in_month(CAL_GREGORIAN,$i,$year)."'";
				}else{
					$fahuomap="dverifysystime>='".$year."-".$i."-01' and dverifysystime<='".$year."-".$i."-".cal_days_in_month(CAL_GREGORIAN,$i,$year)."'";
				}
				$seltime=strtotime($year."-".$i);
				$nowtime=strtotime(date('Y-m',time()));
				if($seltime<=$nowtime){
					$changguilist=array();
					$feichangguilist=array();
					$zonghelist=array();
					$kongzhiguilist=array();
					$waigoulist=array();
					$yuancailiaolist=array();
					//查找这个区间审核过的销售订单
					$somainlist=array();
					$somainlist=$SomainModel->where($fahuomap." and bReturnFlag = 0")->field("cSOCode,cCusCode,dverifysystime")->order("dverifysystime asc")->select();
					if(!empty($somainlist)){
						foreach($somainlist as $key=>$value){
							//根据销售订单查找字表内容
							$arr=array();
							$arr=$SodetailsModel->where("cSOCode='%s'",$value['csocode'])->field("cInvCode,iSOsID,iQuantity")->select();
							if(!empty($arr)){
								$b=array();
								$b=$value;
								foreach($arr as $a){
									$inventoryinfo=$InventoryModel->where("cInvCode='%s'",$a['cinvcode'])->field("cInvName,cInvStd,cInvCCode,cInvDefine11")->find();
									$b['cinvccode']=$inventoryinfo['cinvccode'];
									//销售订单分类
									//常规产品
									if(in_array($inventoryinfo['cinvccode'],$changgui) && $inventoryinfo['cinvdefine11']==0){
										$changguilist[]=$b;
									//非常规产品
									}else if(in_array($inventoryinfo['cinvccode'],$changgui) && $inventoryinfo['cinvdefine11']==1){
										$feichangguilist[]=$b;
									//控制柜
									}else if(in_array($inventoryinfo['cinvccode'],$kongzhigui)){
										$kongzhiguilist[]=$b;
									//外购件
									}else if(in_array($inventoryinfo['cinvccode'],$waigou)){
										$waigoulist[]=$b;
									//原材料和其他
									}else{
										$yuancailiaolist[]=$b;
									}
									
									
								}
							}
							
						}
					}
						
					//调用发货时效工具类
					$fahuoshixiao=new \lib\Fahuoshixiao();
					//常规订单发货单
					$changguilist=$fahuoshixiao->fahuodan($changguilist,$fahuomap);
					$changguifahuolist=$changguilist[0];
					//统计
					$changguitongji=$fahuoshixiao->tongji($changguifahuolist);
					$changguitongji[8]=count($changguilist[1]);
					$data1[$i]=$changguitongji;
					
					//非常规订单发货单
					$feichangguilist=$fahuoshixiao->fahuodan($feichangguilist,$fahuomap);
					$feichangguifahuolist=$feichangguilist[0];
					//统计
					$feichangguitongji=$fahuoshixiao->tongji($feichangguifahuolist);
					$feichangguitongji[8]=count($feichangguilist[1]);
					$data2[$i]=$feichangguitongji;
					
					$arr=array();
					for($x=0;$x<=8;$x++){
						$arr[$x]=$changguitongji[$x]+$feichangguitongji[$x];
					}
					$data3[$i]=$arr;
					//控制柜订单发货单
					$kongzhiguilist=$fahuoshixiao->fahuodan($kongzhiguilist,$fahuomap);
					$kongzhiguifahuolist=$kongzhiguilist[0];
					//统计
					$kongzhiguitongji=$fahuoshixiao->tongji($kongzhiguifahuolist);
					$kongzhiguitongji[8]=count($kongzhiguilist[1]);
					$data4[$i]=$kongzhiguitongji;
					
					//外购件订单发货单
					$waigoulist=$fahuoshixiao->fahuodan($waigoulist,$fahuomap);
					$waigoufahuolist=$waigoulist[0];
					//统计
					$waigoutongji=$fahuoshixiao->tongji($waigoufahuolist);
					$waigoutongji[8]=count($waigoulist[1]);
					$data5[$i]=$waigoutongji;
					
					//原材料订单发货单
					$yuancailiaolist=$fahuoshixiao->fahuodan($yuancailiaolist,$fahuomap);
					$yuancailiaofahuolist=$yuancailiaolist[0];
					//统计
					$yuancailiaotongji=$fahuoshixiao->tongji($yuancailiaofahuolist);
					$yuancailiaotongji[8]=count($yuancailiaolist[1]);
					$data6[$i]=$yuancailiaotongji;
				}
			}
			
			
		}
		
		$this->assign('pagetitle','发货时效');
		$this->assign('data1',$data1);
		$this->assign('data2',$data2);
		$this->assign('data3',$data3);
		$this->assign('data4',$data4);
		$this->assign('data5',$data5);
		$this->assign('data6',$data6);
		$this->assign('year',$year);
		$this->display();
    }
	
	
	public function exportExcel(){
		$xlsTitle = iconv('utf-8', 'gb2312', '发货时效');//文件名称
		$expCellName  = array(
		array('csocode','销售订单'),
		array('dverifysystime','审核时间'),
		array('ccusname','客户名称'),
		array('cinvcode','存货编码'),
		array('cinvname','存货名称'),
		array('cinvstd','规格型号'),
		array('iquantity','订单数量'),
		array('fahuotime','发货时间'),
		array('fiquantity','发货数量'),
		array('tian','发货周期(天)'),
		array('shi','发货周期(时)')
		);
		$cellNum = count($expCellName);//多少列
		//$dataNum = count($expTableData);//多少行
		vendor("PHPExcel.PHPExcel");
			
		$objPHPExcel = new \PHPExcel();//实例化PHPExcel类
		$cellName = array('A','B','C','D','E','F','G','H','I','J','K');
		$objPHPExcel->getActiveSheet(0)->setTitle("常规产品");
		//'A','B','C','D','E','F','G','H','I'
		for($i=0;$i<11;$i++){
			$objPHPExcel->getActiveSheet(0)->setCellValue($cellName[$i].'1', $expCellName[$i][1]);//设置表头值
		}
		
		//U8存货分类
		$InventoryClassModel=M('Inventoryclass','dbo.','U8');
		//U8销售订单主表
		$SomainModel=M('Somain','dbo.so_','U8');
		//U8销售订单子表
		$SodetailsModel=M('Sodetails','dbo.so_','U8');
		//U8型号表
		$InventoryModel=M('Inventory','dbo.','U8');
		
		
		//常规产品
		$changgui=array('020207','020210','020211','020215','020216','020217','020219','020220','020221','020222','020224','02020101','02020102','02020103','020201014','02020105','02020106','02020107','02020108','02020109','02020110','02020111','02020112','02020113','02020114','02020115','02020116','02020117','02020118','02020119','02020120','02020122','02020122','02020124','02020127','02020128','02020129','02020131','02020132','02020204','02020205','02020206','02020207','02020208','02020209','02020301','02020302','02020303','020208','020227','020209');
		$kongzhigui=array('020305','02030601','02030602','02030603','02030604','02030701','02030702','020308');
		$waigou=array('02040101','02040102','02040102','02040201','02040202','02040203','02040204','02040205','020403','02050101','02050102','02050103','02050104','020502','020601','020602','0208');
		
		$fahuomap=session('fahuoshixiaomap');
		$datalist=array();
		if($fahuomap!=""){
			//查找这个区间审核过的销售订单
			$somainlist=array();
			$somainlist=$SomainModel->where($fahuomap." and bReturnFlag = 0")->field("cSOCode,cCusCode,dverifysystime")->order("dverifysystime asc")->select();
			if(!empty($somainlist)){
				foreach($somainlist as $key=>$value){
					//根据销售订单查找字表内容
					$arr=array();
					$arr=$SodetailsModel->where("cSOCode='%s'",$value['csocode'])->field("cInvCode,iSOsID,iQuantity")->select();
					if(!empty($arr)){
						$b=array();
						$b=$value;
						foreach($arr as $a){
							$b['isosid']=$a['isosid'];
							$b['cinvcode']=$a['cinvcode'];
							$b['iquantity']=intval($a['iquantity']);
							$inventoryinfo=$InventoryModel->where("cInvCode='%s'",$b['cinvcode'])->field("cInvName,cInvStd,cInvCCode,cInvDefine11")->find();
							$b['cinvname']=$inventoryinfo['cinvname'];
							$b['cinvstd']=$inventoryinfo['cinvstd'];
							$b['cinvccode']=$inventoryinfo['cinvccode'];
							//销售订单分类
							//常规产品
							if(in_array($inventoryinfo['cinvccode'],$changgui) && $inventoryinfo['cinvdefine11']==0){
								$changguilist[]=$b;
							//非常规产品
							}else if(in_array($inventoryinfo['cinvccode'],$changgui) && $inventoryinfo['cinvdefine11']==1){
								$feichangguilist[]=$b;
							//控制柜
							}else if(in_array($inventoryinfo['cinvccode'],$kongzhigui)){
								$kongzhiguilist[]=$b;
							//外购件
							}else if(in_array($inventoryinfo['cinvccode'],$waigou)){
								$waigoulist[]=$b;
							//原材料和其他
							}else{
								$yuancailiaolist[]=$b;
							}
						}
					}
					
				}
			}
				
				//调用发货时效工具类
				$fahuoshixiao=new \lib\Fahuoshixiao();
				//常规订单发货单
				$changguilist=$fahuoshixiao->export($changguilist,$fahuomap);
				$changguifahuolist=array_merge($changguilist[0],$changguilist[1]);
				
				//非常规订单发货单
				$feichangguilist=$fahuoshixiao->export($feichangguilist,$fahuomap);
				$feichangguifahuolist=array_merge($feichangguilist[0],$feichangguilist[1]);
				
				//控制柜订单发货单
				$kongzhiguilist=$fahuoshixiao->export($kongzhiguilist,$fahuomap);
				$kongzhiguifahuolist=array_merge($kongzhiguilist[0],$kongzhiguilist[1]);
				
				//外购件订单发货单
				$waigoulist=$fahuoshixiao->export($waigoulist,$fahuomap);
				$waigoufahuolist=array_merge($waigoulist[0],$waigoulist[1]);
				
				//原材料订单发货单
				$yuancailiaolist=$fahuoshixiao->export($yuancailiaolist,$fahuomap);
				$yuancailiaofahuolist=array_merge($yuancailiaolist[0],$yuancailiaolist[1]);
				
				$changguicount=count($changguifahuolist);
				$feichangguicount=count($feichangguifahuolist);
				$kongzhiguicount=count($kongzhiguifahuolist);
				$jiareqicount=count($jiareqifahuolist);
				$waigoucount=count($waigoufahuolist);
				$yuancailiaocount=count($yuancailiaofahuolist);
				//设置表内容    
				for($i=0;$i<$changguicount;$i++){
					for($j=0;$j<$cellNum;$j++){
						$objPHPExcel->getActiveSheet(0)->setCellValue($cellName[$j].($i+2),$changguifahuolist[$i][$expCellName[$j][0]]);
					}             
				}
				$objPHPExcel->createSheet();
				$objPHPExcel->setactivesheetindex(1);
				$objPHPExcel->getActiveSheet(1)->setTitle("非常规产品");
				for($i=0;$i<11;$i++){
					$objPHPExcel->getActiveSheet(1)->setCellValue($cellName[$i].'1',$expCellName[$i][1]);//设置表头值
				}
				//设置表内容    
				for($i=0;$i<$feichangguicount;$i++){
					for($j=0;$j<$cellNum;$j++){
						$objPHPExcel->getActiveSheet(1)->setCellValue($cellName[$j].($i+2),$feichangguifahuolist[$i][$expCellName[$j][0]]);
					}             
				}
				$objPHPExcel->createSheet();
				$objPHPExcel->setactivesheetindex(2);
				$objPHPExcel->getActiveSheet(2)->setTitle("控制柜");
				for($i=0;$i<11;$i++){
					$objPHPExcel->getActiveSheet(2)->setCellValue($cellName[$i].'1',$expCellName[$i][1]);//设置表头值
				}
				//设置表内容    
				for($i=0;$i<$kongzhiguicount;$i++){
					for($j=0;$j<$cellNum;$j++){
						$objPHPExcel->getActiveSheet(2)->setCellValue($cellName[$j].($i+2),$kongzhiguifahuolist[$i][$expCellName[$j][0]]);
					}             
				}
				
				$objPHPExcel->createSheet();
				$objPHPExcel->setactivesheetindex(3);
				$objPHPExcel->getActiveSheet(3)->setTitle("外购件");
				for($i=0;$i<11;$i++){
					$objPHPExcel->getActiveSheet(3)->setCellValue($cellName[$i].'1',$expCellName[$i][1]);//设置表头值
				}
				//设置表内容    
				for($i=0;$i<$waigoucount;$i++){
					for($j=0;$j<$cellNum;$j++){
						$objPHPExcel->getActiveSheet(3)->setCellValue($cellName[$j].($i+2),$waigoufahuolist[$i][$expCellName[$j][0]]);
					}             
				}
				$objPHPExcel->createSheet();
				$objPHPExcel->setactivesheetindex(4);
				$objPHPExcel->getActiveSheet(4)->setTitle("原材料");
				for($i=0;$i<11;$i++){
					$objPHPExcel->getActiveSheet(4)->setCellValue($cellName[$i].'1',$expCellName[$i][1]);//设置表头值
				}
				//设置表内容    
				for($i=0;$i<$yuancailiaocount;$i++){
					for($j=0;$j<$cellNum;$j++){
						$objPHPExcel->getActiveSheet(4)->setCellValue($cellName[$j].($i+2),$yuancailiaofahuolist[$i][$expCellName[$j][0]]);
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
	
}
?>