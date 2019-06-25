<?php
namespace Home\Controller;
use Common\Controller\AuthController;
class FahuoController extends AuthController {
	
    public function index(){
		$model=D('Workplan');
		//U8存货分类
		$InventoryClassModel=M('Inventoryclass','dbo.','U8');
		//U8发货单主表
		$DispatchlistModel=M('Dispatchlist','dbo.','U8');
		//U8发货单字表
		$DispatchlistsModel=M('Dispatchlists','dbo.','U8');
		//U8型号表
		$InventoryModel=M('Inventory','dbo.','U8');
		if(IS_POST){
			$data=I('post.');
			//得到查询条件
			//计划日期
			$fahuo_fenlei_a=$data['fahuo_fenlei_a'];
			$fahuo_fenlei_b=$data['fahuo_fenlei_b'];
			$fahuo_fenlei_c=$data['fahuo_fenlei_c'];
			$fahuo_fenlei_d=$data['fahuo_fenlei_d'];
			//完成日期
			$workplan_date_dir_start=$data['workplan_date_dir_start'];
			$workplan_date_dir_end=$data['workplan_date_dir_end'];
			
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
			$fahuomap="";
			//拼接完成日期
			if(!empty($workplan_date_dir_start) && !empty($workplan_date_dir_end)){
				$workplan_date_dir_start=strtotime($workplan_date_dir_start);
				$workplan_date_dir_end=strtotime($workplan_date_dir_end);
				$workplan_date_dir_start=date('Y-m-d',$workplan_date_dir_start);
				$workplan_date_dir_end=date('Y-m-d',$workplan_date_dir_end);
				$fahuomap="dverifydate>='".$workplan_date_dir_start."' and dverifydate<='".$workplan_date_dir_end."'";
			}else if(!empty($train_downtime_dir_start) && empty($workplan_date_dir_end)){
				$workplan_date_dir_start=strtotime($workplan_date_dir_start);
				$workplan_date_dir_start=date('Y-m-d',$workplan_date_dir_start);
				$fahuomap="dverifydate>='".$workplan_date_dir_start."'";
			}else if(empty($train_downtime_dir_start) && !empty($workplan_date_dir_end)){
				$workplan_date_dir_end=strtotime($workplan_date_dir_end);
				$workplan_date_dir_end=date('Y-m-d',$workplan_date_dir_end);
				$fahuomap="dverifydate<='".$workplan_date_dir_end."'";
			}
			session('fahuomap',$fahuomap);
			session('cinvccode',$cinvccode);
			$datalist=array();
			
			if($cinvccode!="0" && $fahuomap!=""){
				//查找这个区间审核过的发货单
				$dispatchlist=$DispatchlistModel->where($fahuomap)->field("DLID")->select();
				$arr=array();
				foreach($dispatchlist as $value){
					$arr[]=$value['dlid'];
				}
				//单号转成字符串
				$dispatchstr=implode(",", $arr);
				//得到所选分类信息
				$InventoryClassinfo=$InventoryClassModel->where("cInvCCode=".$cinvccode)->find();
				$number=$InventoryClassinfo['iinvcgrade']+1;
				//查找所选分类的子分类
				$datalist=$InventoryClassModel->where("cInvCCode like '".$cinvccode."%' and iInvCGrade=".$number)->order("cInvCCode asc")->field("cInvCCode,cInvCName")->select();
				
				if(!empty($datalist)){
					$zongshuliang=0;
					$zongjine=0;
					$zibiaolist=$DispatchlistsModel->where("DLID in(".$dispatchstr.")")->field("cInvCode,iQuantity,iNatSum")->select();
					foreach($zibiaolist as $x=>$y){
						//得到发货单产品的分类
						$ycinvccode=$InventoryModel->where("cInvCode = '".$y['cinvcode']."'")->getField("cInvCCode");
						foreach($datalist as $i=>$j){
							$jcinvccode=$j['cinvccode'];
							$jnumber=strlen($jcinvccode);
							$subcinvccode=substr($ycinvccode,0,$jnumber);
							if($subcinvccode==$jcinvccode){
								//数量累加
								$datalist[$i]['iquantity']=$datalist[$i]['iquantity']+$y['iquantity'];
								//总数量
								$zongshuliang=$zongshuliang+$y['iquantity'];
								//金额累加
								$datalist[$i]['inatsum']=$datalist[$i]['inatsum']+$y['inatsum'];
								//总金额
								$zongjine=$zongjine+$y['inatsum'];
							}
							
						}
					}
					
				}
			}else if($fahuomap!=""){
				//查找这个区间审核过的发货单
				$dispatchlist=$DispatchlistModel->where($fahuomap)->field("DLID")->select();
				$arr=array();
				foreach($dispatchlist as $value){
					$arr[]=$value['dlid'];
				}
				//单号转成字符串
				$dispatchstr=implode(",", $arr);
				//得到所选分类信息
				$threelist=$InventoryClassModel->where("iInvCGrade=3")->order("cInvCCode asc")->field("cInvCCode,cInvCName")->select();
				//得到所选分类信息
				$twoinventory=$InventoryClassModel->where("iInvCGrade=2")->order("cInvCCode asc")->field("cInvCCode,cInvCName")->select();
				$twolist=array();
				foreach($twoinventory as $a=>$b){
					$three=$InventoryClassModel->where("iInvCGrade=3 and cInvCCode like '".$b['cinvccode']."'")->find();
					if(empty($three)){
						$twolist[]=$b;
					}
				}
				$zongshuliang=0;
				$zongjine=0;
				$zibiaolist=$DispatchlistsModel->where("DLID in(".$dispatchstr.")")->field("cInvCode,iQuantity,iNatSum")->select();
				foreach($zibiaolist as $x=>$y){
					//得到发货单产品的分类
					$ycinvccode=$InventoryModel->where("cInvCode = '".$y['cinvcode']."'")->getField("cInvCCode");
					foreach($threelist as $i=>$j){
						$jcinvccode=$j['cinvccode'];
						$jnumber=strlen($jcinvccode);
						$subcinvccode=substr($ycinvccode,0,$jnumber);
						if($subcinvccode==$jcinvccode){
							//数量累加
							$threelist[$i]['iquantity']=$threelist[$i]['iquantity']+$y['iquantity'];
							//总数量
							$zongshuliang=$zongshuliang+$y['iquantity'];
							//金额累加
							$threelist[$i]['inatsum']=$threelist[$i]['inatsum']+$y['inatsum'];
							//总金额
							$zongjine=$zongjine+$y['inatsum'];
						}
						
					}
					foreach($twolist as $c=>$d){
						if($ycinvccode==$d['cinvccode']){
							//数量累加
							$twolist[$c]['iquantity']=$twolist[$c]['iquantity']+$y['iquantity'];
							//总数量
							$zongshuliang=$zongshuliang+$y['iquantity'];
							//金额累加
							$twolist[$c]['inatsum']=$twolist[$c]['inatsum']+$y['inatsum'];
							//总金额
							$zongjine=$zongjine+$y['inatsum'];
						}
					}
				}
				//合并数组
				$datalist=array_merge($threelist,$twolist);
					
			}
		}
		$data=array();
		foreach($datalist as $k=>$l){
			if(!empty($l['iquantity']) || !empty($l['inatsum'])){
				$lcinvccode=$l['cinvccode'];
				$yicinvccode=substr($lcinvccode,0,2);
				$ercinvccode=substr($lcinvccode,0,4);
				$yiinfo=$InventoryClassModel->where("cInvCCode='".$yicinvccode."' and iInvCGrade=1")->field("cInvCCode,cInvCName")->find();
				$l['yicinvccode']=$yiinfo['cinvccode'];
				$l['yicinvcname']=$yiinfo['cinvcname'];
				if($ercinvccode!=$l['cinvccode']){
					$erinfo=$InventoryClassModel->where("cInvCCode='".$ercinvccode."' and iInvCGrade=2")->field("cInvCCode,cInvCName")->find();
					$l['ercinvccode']=$erinfo['cinvccode'];
					$l['ercinvcname']=$erinfo['cinvcname'];
				}
				$data[]=$l;
			}
		}
		$InventoryClasslist=$InventoryClassModel->where("iInvCGrade=1")->select();
		$this->assign('pagetitle','发货汇总');
		$this->assign('InventoryClasslist',$InventoryClasslist);
		$this->assign('datalist',$data);
		$this->assign('zongshuliang',$zongshuliang);
		$this->assign('zongjine',$zongjine);
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
		$xlsTitle = iconv('utf-8', 'gb2312', 'fahuohuizong');//文件名称
		$expCellName  = array(
		array('yicinvccode','一级编码'),
		array('yicinvcname','一级名称'),
		array('ercinvccode','二级编码'),
		array('ercinvcname','二级名称'),
		array('cinvccode','三级编码'),
		array('cinvcname','三级名称'),
		array('iquantity','数量'),
		array('inatsum','税价合计')
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
		//U8发货单主表
		$DispatchlistModel=M('Dispatchlist','dbo.','U8');
		//U8发货单字表
		$DispatchlistsModel=M('Dispatchlists','dbo.','U8');
		//U8型号表
		$InventoryModel=M('Inventory','dbo.','U8');
		
		$fahuomap=session('fahuomap');
		$cinvccode=session('cinvccode');
		$datalist=array();
		if($cinvccode!="0" && $fahuomap!=""){
			//查找这个区间审核过的发货单
			$dispatchlist=$DispatchlistModel->where($fahuomap)->field("DLID")->select();
			$arr=array();
			foreach($dispatchlist as $value){
				$arr[]=$value['dlid'];
			}
			//单号转成字符串
			$dispatchstr=implode(",", $arr);
			//得到所选分类信息
			$InventoryClassinfo=$InventoryClassModel->where("cInvCCode=".$cinvccode)->find();
			$number=$InventoryClassinfo['iinvcgrade']+1;
			//查找所选分类的子分类
			$datalist=$InventoryClassModel->where("cInvCCode like '".$cinvccode."%' and iInvCGrade=".$number)->order("cInvCCode asc")->field("cInvCCode,cInvCName")->select();
			
			if(!empty($datalist)){
				$zibiaolist=$DispatchlistsModel->where("DLID in(".$dispatchstr.")")->field("cInvCode,iQuantity,iNatSum")->select();
				foreach($zibiaolist as $x=>$y){
					//得到发货单产品的分类
					$ycinvccode=$InventoryModel->where("cInvCode = '".$y['cinvcode']."'")->getField("cInvCCode");
					foreach($datalist as $i=>$j){
						$jcinvccode=$j['cinvccode'];
						$jnumber=strlen($jcinvccode);
						$subcinvccode=substr($ycinvccode,0,$jnumber);
						if($subcinvccode==$jcinvccode){
							//数量累加
							$datalist[$i]['iquantity']=$datalist[$i]['iquantity']+$y['iquantity'];
							//金额累加
							$datalist[$i]['inatsum']=$datalist[$i]['inatsum']+$y['inatsum'];
						}
						
					}
				}
				
			}
		}else if($fahuomap!=""){
			//查找这个区间审核过的发货单
			$dispatchlist=$DispatchlistModel->where($fahuomap)->field("DLID")->select();
			$arr=array();
			foreach($dispatchlist as $value){
				$arr[]=$value['dlid'];
			}
			//单号转成字符串
			$dispatchstr=implode(",", $arr);
			//得到所选分类信息
			$threelist=$InventoryClassModel->where("iInvCGrade=3")->order("cInvCCode asc")->field("cInvCCode,cInvCName")->select();
			//得到所选分类信息
			$twoinventory=$InventoryClassModel->where("iInvCGrade=2")->order("cInvCCode asc")->field("cInvCCode,cInvCName")->select();
			$twolist=array();
			foreach($twoinventory as $a=>$b){
				$three=$InventoryClassModel->where("iInvCGrade=3 and cInvCCode like '".$b['cinvccode']."'")->find();
				if(empty($three)){
					$twolist[]=$b;
				}
			}
			$zongshuliang=0;
			$zongjine=0;
			$zibiaolist=$DispatchlistsModel->where("DLID in(".$dispatchstr.")")->field("cInvCode,iQuantity,iNatSum")->select();
			foreach($zibiaolist as $x=>$y){
				//得到发货单产品的分类
				$ycinvccode=$InventoryModel->where("cInvCode = '".$y['cinvcode']."'")->getField("cInvCCode");
				foreach($threelist as $i=>$j){
					$jcinvccode=$j['cinvccode'];
					$jnumber=strlen($jcinvccode);
					$subcinvccode=substr($ycinvccode,0,$jnumber);
					if($subcinvccode==$jcinvccode){
						//数量累加
						$threelist[$i]['iquantity']=$threelist[$i]['iquantity']+$y['iquantity'];
						//总数量
						$zongshuliang=$zongshuliang+$y['iquantity'];
						//金额累加
						$threelist[$i]['inatsum']=$threelist[$i]['inatsum']+$y['inatsum'];
						//总金额
						$zongjine=$zongjine+$y['inatsum'];
					}
					
				}
				foreach($twolist as $c=>$d){
					if($ycinvccode==$d['cinvccode']){
						//数量累加
						$twolist[$c]['iquantity']=$twolist[$c]['iquantity']+$y['iquantity'];
						//总数量
						$zongshuliang=$zongshuliang+$y['iquantity'];
						//金额累加
						$twolist[$c]['inatsum']=$twolist[$c]['inatsum']+$y['inatsum'];
						//总金额
						$zongjine=$zongjine+$y['inatsum'];
					}
				}
			}
			//合并数组
			$datalist=array_merge($threelist,$twolist);
		}
		$data=array();
		foreach($datalist as $k=>$l){
			if(!empty($l['iquantity']) || !empty($l['inatsum'])){
				$lcinvccode=$l['cinvccode'];
				$yicinvccode=substr($lcinvccode,0,2);
				$ercinvccode=substr($lcinvccode,0,4);
				$yiinfo=$InventoryClassModel->where("cInvCCode='".$yicinvccode."' and iInvCGrade=1")->field("cInvCCode,cInvCName")->find();
				$l['yicinvccode']=" ".$yiinfo['cinvccode'];
				$l['yicinvcname']=$yiinfo['cinvcname'];
				$erinfo=$InventoryClassModel->where("cInvCCode='".$ercinvccode."' and iInvCGrade=2")->field("cInvCCode,cInvCName")->find();
				if($ercinvccode!=$l['cinvccode']){
					$erinfo=$InventoryClassModel->where("cInvCCode='".$ercinvccode."' and iInvCGrade=2")->field("cInvCCode,cInvCName")->find();
					$l['ercinvccode']=$erinfo['cinvccode'];
					$l['ercinvcname']=$erinfo['cinvcname'];
				}
				$data[]=$l;
			}
		}
		
		$resultcount=count($data);
		//设置表内容    
		for($i=0;$i<$resultcount;$i++){
			for($j=0;$j<$cellNum;$j++){
				$objPHPExcel->getActiveSheet(0)->setCellValue($cellName[$j].($i+2), $data[$i][$expCellName[$j][0]]);
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