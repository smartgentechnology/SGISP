<?php
namespace Home\Controller;
use Common\Controller\AuthController;
class CailiaoController extends AuthController {
	
    public function index(){
		$model=D('Workplan');
		//U8存货分类
		$InventoryClassModel=M('Inventoryclass','dbo.','U8');
		//U8型号表
		$InventoryModel=M('Inventory','dbo.','U8');
		//U8入库单主表
		$RdRecordModel=M('Rdrecord01','dbo.','U8');
		//U8入库单子表
		$RdrecordsModel=M('rdrecords01','dbo.','U8');
		//U8采购发票主表
		$PurbillvouchModel=M('Purbillvouch','dbo.','U8');
		//U8采购发票子表
		$PurbillvouchsModel=M('Purbillvouchs','dbo.','U8');
		if(IS_POST){
			$data=I('post.');
			//得到查询条件
			//计划日期
			$fahuo_fenlei_a=$data['fahuo_fenlei_a'];
			$fahuo_fenlei_b=$data['fahuo_fenlei_b'];
			$fahuo_fenlei_c=$data['fahuo_fenlei_c'];
			$fahuo_fenlei_d=$data['fahuo_fenlei_d'];
			
			$cinvccode="";
			//拼接分类
			if($fahuo_fenlei_d=="0"){
				if($fahuo_fenlei_c=="0"){
					if($fahuo_fenlei_b=="0"){
						if($fahuo_fenlei_a=="0"){
							$cinvccode="0";
						}else{
							$cinvccode=$fahuo_fenlei_a;
						}
					}else{
						$cinvccode=$fahuo_fenlei_b;
					}
				}else{
					$cinvccode=$fahuo_fenlei_c;
				}
				
			}else{
				$cinvccode=$fahuo_fenlei_d;
			}
			session('cinvccode',$cinvccode);
			$datalist=array();
			
			if($cinvccode!="0"){
				
				//得到发货单产品的分类
				$inventorylist=$InventoryModel->where("dEDate is null and cInvCCode like '".$cinvccode."%'")->field("cInvCode,cInvCCode,cInvName,cInvStd,iInvSPrice")->select();
				foreach($inventorylist as $j){
					//入库单
					$inventoryinfo=$RdrecordsModel->where("cInvCode='%s' and( iUnitCost!=0 or iUnitCost is not null)",$j['cinvcode'])->order("AutoID desc")->field("iUnitCost,iOriTaxCost,ID,dSDate,AutoID")->find();
					$arr=array();
					if(!empty($inventoryinfo['dsdate'])){
						$purbillvouchsinfo=$PurbillvouchsModel->where("RdsId ='%s'",$inventoryinfo['autoid'])->field("iOriCost,iOriTaxCost")->find();
						//单价
						$arr['danjia']=round($purbillvouchsinfo['ioricost'],6);
						//含税单价
						$arr['hanshui']=round($purbillvouchsinfo['ioritaxcost'],6);
					}else{
						//单价
						$arr['danjia']=round($inventoryinfo['iunitcost'],6);
						//含税单价
						$arr['hanshui']=round($inventoryinfo['ioritaxcost'],6);
						
					}
					//存货编码
					$arr['cinvcode']=$j['cinvcode'];
					//存货大类
					$arr['cinvccode']=$j['cinvccode'];
					//存货名称
					$arr['cinvname']=$j['cinvname'];
					//规格型号
					$arr['cinvstd']=$j['cinvstd'];
					//参考成本
					$arr['iinvsprice']=round($j['iinvsprice'],6);
					if($arr['danjia']!=0){
						//入库审核时间
						$arr['ddate']=$RdRecordModel->where("ID ='".$inventoryinfo['id']."'")->getField("dDate");
					}
					$datalist[]=$arr;
				}
				
			}
		}
		
		$InventoryClasslist=$InventoryClassModel->where("cInvCCode='01'")->select();
		$this->assign('pagetitle','原材料价格');
		$this->assign('InventoryClasslist',$InventoryClasslist);
		$this->assign('datalist',$datalist);
		$this->display();
    }
	public function getson(){
		$cinvccode=I('get.fenlei');
		$datalist=array();
		if($cinvccode!=0){
			//U8存货分类
			$InventoryClassModel=M('Inventoryclass','dbo.','U8');
			$Inventoryinfo=$InventoryClassModel->where("cInvCCode = '".$cinvccode."'")->find();
			$iinvcgrade=$Inventoryinfo['iinvcgrade']+1;
			$datalist=$InventoryClassModel->where("iInvCGrade=".$iinvcgrade." and cInvCCode like '".$Inventoryinfo['cinvccode']."%'")->order('cInvCCode asc')->select();
		}
		$this->ajaxReturn(array(
			'state'=>'ok',
			'info' => '',
			'data'=>$datalist
		));
		
	}
	
	public function exportExcel(){
		$xlsTitle = iconv('utf-8', 'gb2312', '原材料价格');//文件名称
		$expCellName  = array(
		array('cinvcode','存货编码'),
		array('cinvccode','存货大类'),
		array('cinvname','存货名称'),
		array('cinvstd','规格型号'),
		array('danjia','单价'),
		array('hanshui','含税单价'),
		array('iinvsprice','参考成本'),
		array('ddate','最后入库时间')
		);
		$cellNum = count($expCellName);//多少列
		//$dataNum = count($expTableData);//多少行
		vendor("PHPExcel.PHPExcel");
			
		$objPHPExcel = new \PHPExcel();//实例化PHPExcel类
		$cellName = array('A','B','C','D','E','F','G','H');
		
		//'A','B','C','D','E','F','G','H','I'
		for($i=0;$i<8;$i++){
			$objPHPExcel->getActiveSheet(0)->setCellValue($cellName[$i].'1', $expCellName[$i][1]);//设置表头值
		}
		
		//U8存货分类
		$InventoryClassModel=M('Inventoryclass','dbo.','U8');
		//U8型号表
		$InventoryModel=M('Inventory','dbo.','U8');
		//U8入库单主表
		$RdRecordModel=M('Rdrecord01','dbo.','U8');
		//U8入库单子表
		$RdrecordsModel=M('rdrecords01','dbo.','U8');
		//U8采购发票主表
		$PurbillvouchModel=M('Purbillvouch','dbo.','U8');
		//U8采购发票子表
		$PurbillvouchsModel=M('Purbillvouchs','dbo.','U8');
		
		$cinvccode=session('cinvccode');
		if($cinvccode=="" || $cinvccode=="0"){
			$cinvccode="01";
		}
		$datalist=array();
		if($cinvccode!="0"){
			//得到发货单产品的分类
			$inventorylist=$InventoryModel->where("dEDate is null and cInvCCode like '".$cinvccode."%'")->field("cInvCode,cInvCCode,cInvName,cInvStd,iInvSPrice")->select();
			foreach($inventorylist as $j){
				//入库单
				$inventoryinfo=$RdrecordsModel->where("cInvCode='%s' and( iUnitCost!=0 or iUnitCost is not null)",$j['cinvcode'])->order("AutoID desc")->field("iUnitCost,iOriTaxCost,ID,dSDate,AutoID")->find();
				$arr=array();
				if(!empty($inventoryinfo['dsdate'])){
					$purbillvouchsinfo=$PurbillvouchsModel->where("RdsId ='%s'",$inventoryinfo['autoid'])->field("iOriCost,iOriTaxCost")->find();
					//单价
					$arr['danjia']=round($purbillvouchsinfo['ioricost'],6);
					//含税单价
					$arr['hanshui']=round($purbillvouchsinfo['ioritaxcost'],6);
				}else{
					//单价
					$arr['danjia']=round($inventoryinfo['iunitcost'],6);
					//含税单价
					$arr['hanshui']=round($inventoryinfo['ioritaxcost'],6);
					
				}
				//存货编码
				$arr['cinvcode']=$j['cinvcode'];
				//存货大类
				$arr['cinvccode']=$j['cinvccode'];
				//存货名称
				$arr['cinvname']=$j['cinvname'];
				//规格型号
				$arr['cinvstd']=$j['cinvstd'];
				//参考成本
				$arr['iinvsprice']=round($j['iinvsprice'],6);
				if($arr['danjia']!=0){
					//入库审核时间
					$arr['ddate']=$RdRecordModel->where("ID ='".$inventoryinfo['id']."'")->getField("dDate");
				}
				$datalist[]=$arr;
			}
			
		}
		
		$resultcount=count($datalist);
		//设置表内容    
		for($i=0;$i<$resultcount;$i++){
			for($j=0;$j<$cellNum;$j++){
				$objPHPExcel->getActiveSheet(0)->setCellValue($cellName[$j].($i+2), $datalist[$i][$expCellName[$j][0]]);
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