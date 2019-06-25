<?php
define('ACC',true);  //得到访问权限
require('./include/init.php');  //加载初始化配置
//header('Content-Type: text/html; charset=gb2312'); 

//实例化发货单
$xFahuozhuRs=new DispatchListModel();
//实例化发货单子表
$xFahuoziRs=new DispatchListsModel();
//实例化条码明细表
$hyBarScandetailsRs=new HyBarScandetailsModel();
//实例化条码档案表
$hyBarCodeMainRs=new HyBarCodeMainModel();
//实例化存货档案
$inventoryRs=new InventoryModel();
//定义现发货单列表
$xfahuozhulist=array();
$kehu=array();

$altlist=array();
//得到现发货单列表
$xfahuozhulist=$xFahuozhuRs->selectTable();
foreach($xfahuozhulist as $xZhukey=>$xfahuozhuitem){
	$alt=array();
	//将客户名称转码
	$xzhukehumingcheng=iconv('GBK', 'UTF-8', $xfahuozhuitem['cCusName']);
	//客户编码
	$zhukehubianma=iconv('GBK', 'UTF-8', $xfahuozhuitem['cCusCode']);
	//主ID
	$xfahuozhuDLID=$xfahuozhuitem['DLID'];
	//定义产品列表
	$chanpinlist=array();
	//定义现发货单子表列表
	$xfahuozilist=array();
	//得到现发货单列表
	$xfahuozilist=$xFahuoziRs->selectTable($xfahuozhuitem['DLID']);
	foreach($xfahuozilist as $xZikey=>$xfahuoziitem){
		//存货编码
		$cunhuobianma=iconv('GBK', 'UTF-8', $xfahuoziitem['cInvCode']);
		//子批次
		$xfahuoziPici=$xfahuoziitem['cBatch'];
		
		//获得该产品编码的规格型号
		$guigexinghao=$inventoryRs->selectOneTable($xfahuoziitem['cInvCode']);
		//存货名称
		$xinghao=$guigexinghao["cInvStd"];
		$chanpin=array();
		$chanpin['pici']=$xfahuoziPici;
		$chanpin['xinghao']=$xinghao;
		$chanpin['shuliang']=intval($xfahuoziitem["iQuantity"]);
		
		//检测该客户是否是客户定制，如果不是，读取历史发货记录
		if(kehujiance($zhukehubianma,$cunhuobianma)){
			foreach($kehu as $kehuitem){
				if($kehuitem["kehubianma"]==$zhukehubianma && $kehuitem["cunhuobianma"]==$cunhuobianma){
					//根据发货单号和规格型号查找条码明细表
					$tiaomamingxilist=$hyBarScandetailsRs->selectTable($xfahuozhuitem["cDLCode"],$xfahuoziitem['cInvCode']);
					if(empty($tiaomamingxilist)){
						if(altjiance($xfahuozhuDLID,$xfahuoziPici,$xinghao)){

							$chanpin['banben']=$kehuitem["banbenhao"];
							
							$chanpinlist[]=$chanpin;
						}
					}
				}
			}
		}else{
			//得到历史版本号
			$lishibanben=lishibanbenjiance($xfahuozhuitem["cDLCode"],$xfahuozhuitem['cCusCode'],$xfahuoziitem['cInvCode']);
			
			//根据发货单号和规格型号查找条码明细表
			$tiaomamingxilist=$hyBarScandetailsRs->selectTable($xfahuozhuitem["cDLCode"],$xfahuoziitem['cInvCode']);
			if(empty($tiaomamingxilist)){
				if(altjiance($xfahuozhuDLID,$xfahuoziPici,$xinghao)){
					$chanpin['banben']=$lishibanben;
					$chanpinlist[]=$chanpin;
				}
				
			}
		}
	}
	if(!empty($chanpinlist)){
		$alt['zhuID']=$xfahuozhuDLID;
		$alt['fahuodanhao']=$xfahuozhuitem['cDLCode'];
		$alt['kehumingcheng']=$xzhukehumingcheng;
		$data=object_to_array($xfahuozhuitem['dDate']);
		$alt['riqi']=substr($data['date'],0,10);
		$alt['chanpin']=$chanpinlist;
		$altlist[]=$alt;
	}
	
}

echo json_encode($altlist);
//print_r($altlist);
//日期对象装换成数组
function object_to_array($obj) {
    $arr = array();
    $_arr = is_object($obj)? get_object_vars($obj) : $obj;
    foreach ((array)$_arr as $key => $val) {
        $val = (is_array($val)) || is_object($val) ? object_to_array($val) : $val;
        $arr[$key] = $val;
    }   
    return $arr;    
}

//报警检测不重复
function altjiance($DLID,$cBatch,$xinghao){
	global $altlist;
	foreach($altlist as $altitem){
		if($altitem["zhuID"]==$DLID && $altitem["pici"]==$cBatch && $altitem["xinghao"]==$xinghao){
			return false;
		}
	}
	return true;
}
//历史版本号检测
function lishibanbenjiance($zhufahuodanhao,$zhukehubianma,$zicunhuobianma){
	global $xFahuozhuRs;
	global $hyBarScandetailsRs;
	global $hyBarCodeMainRs;
	$lfahuozhulist=$xFahuozhuRs->selectAllTable($zhufahuodanhao,$zhukehubianma);
	foreach($lfahuozhulist as $lfahuozhuitem){
		$tiaomamingxilist=$hyBarScandetailsRs->selectTable($lfahuozhuitem['cDLCode'],$zicunhuobianma);
		if(!empty($tiaomamingxilist)){
			foreach($tiaomamingxilist as $tiaoma){
				$lishibanben=$hyBarCodeMainRs->selectOneTable($tiaoma["barcode"]);
				if(!empty($lishibanben)){
					return $lishibanben[0]["cBarcodeDefine7"];
				}
			}
				
		}
		
	}
	return 0;
}
//定制客户检测
function kehujiance($zhukehubianma,$cunhuobianma){
	$path=ROOT.'data/kehu.csv';
	$a=array();
	$c=array();
	if(file_exists($path)){
		$fh=fopen($path,'rb');
		while(!feof($fh)){
			$a=fgetcsv($fh);
			$b=array();
			if(is_array($a)){
				foreach($a as $key => $value){
					switch($key){
						case 0:
							if(!empty($value)){
								$b['kehubianma']=$value;
							}
							break;
						case 1:
							if(!empty($value)){
								$b['cunhuobianma']=$value;
							}
							break;
						case 2:
							if(!empty($value)){
								$b['guigexinghao']=$value;
							}
							break;
						case 3:
							if(!empty($value)){
								$b['banbenhao']=$value;
							}
							break;
					}
				}
			}else{
				break;
			}
			$c[]=$b;
		}
		fclose($fh);
	}else{
		return false;
	}
	foreach($c as $kehuitem){
		//判断主客户编码和规格型号是否和定制客户的客户编码和规格型号一致
		if($kehuitem['kehubianma']==$zhukehubianma && $kehuitem['cunhuobianma']==$cunhuobianma){
			global $kehu;
			$kehu=$c;
			return true;
		}
	}
	return false;
}


//include(ROOT.'view/front/index.html'); //加载顶部




?>
