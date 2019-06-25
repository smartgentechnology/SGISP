<?php
define('ACC',true);  //得到访问权限
require('./include/init.php');  //加载初始化配置

//实例化订单子表
$dingdanzirs=new SODetailsModel();
//实例化订单子表
$dingdanzhurs=new SOMainModel();
//得到订单子表列表
$dingdanzilist=$dingdanzirs->selectTable();
//实例化存货档案
$cunhuodanganRs=new InventoryModel();
//实例化存货库存
$kucunRs=new CurrentStockModel();
$manzulist=array();
$bumanzulist=array();
//遍历订单子列表
foreach($dingdanzilist as $ziitem){
	$dingdanzhuitem=$dingdanzhurs->getRow($ziitem['cSOCode']);
	if(!empty($dingdanzhuitem)){
		$shuliang=0;
		//将客户名称转码
		$kehumingcheng=iconv('GBK', 'UTF-8', $dingdanzhuitem['cCusName']);
		//审核人
		$shenheren=iconv('GBK', 'UTF-8', $dingdanzhuitem['cVerifier']);
		//制单日期
		$data=object_to_array($dingdanzhuitem['dverifydate']);
		$zhidanriqi=substr($data['date'],0,10);
		//备注
		$beizhu=iconv('GBK', 'UTF-8', $ziitem['cMemo']);
		//获得该产品编码的规格型号
		$guigexinghao=$cunhuodanganRs->selectOneTable($ziitem['cInvCode']);
		if(!empty($guigexinghao['cInvStd'])){
			$xinghao=iconv('GBK', 'UTF-8', $guigexinghao['cInvStd']);
		}else{
			$xinghao="服务费";
		}
		$kucunlist=array();
		//根据存货编码获取库存数量
		$kucunlist=$kucunRs->selectTable($ziitem['cInvCode']);
		if(empty($kucunlist)){
			$shuliang=0;
		}else{
			//遍历库存数量数组
			foreach($kucunlist as $kucunitem){
				$shuliang=$shuliang+$kucunitem['iQuantity'];
			}
		}
		//得到需要发货的数量，总数量-已发货数量
		$xufahuo=$ziitem['iQuantity']-$ziitem['iFHQuantity'];
		$item=array();
		//得到订单号
		$item['dingdanhao']=$ziitem['cSOCode'];
		//得到客户
		$item['kehu']=$kehumingcheng;
		//得到规格型号
		$item['xinghao']=$xinghao;
		//得到应发数量
		$item['yingfa']=intval($ziitem['iQuantity']);
		//得到已发数量
		$item['yifa']=intval($ziitem['iFHQuantity']);
		//得到库存数量
		$item['kucun']=intval($shuliang);
		//得到审核人
		$item['shenhe']=$shenheren;
		//得到备注
		$item['beizhu']=$beizhu;
		//得到审核日期
		$item['riqi']=$zhidanriqi;
		
		if($xufahuo<=$shuliang){
			//满足发货条件
			$manzulist[]=$item;
			//按审核日期排序
			$manzulist=sort_array($manzulist,'riqi');
		}else{
			//不满足发货条件
			$bumanzulist[]=$item;
			//按审核日期排序
			$bumanzulist=sort_array($bumanzulist,'riqi');
			
		}
		
		
	}
	
	
}
//整合订单
$manzulist=zhenghe_array($manzulist);
$manzunum=count($manzulist);
//print_r($manzulist);
//整合订单
$bumanzulist=zhenghe_array($bumanzulist);
$bumanzunum=count($bumanzulist);
//print_r($bumanzulist);

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
//数组按照某列排序
function sort_array($array, $keyid, $order = 'desc', $type = 'string') {  
	if (is_array($array)) {  
		foreach ($array as $val) {  
			$order_arr[] = $val[$keyid];  
		}  
		$order = ($order == 'asc') ? SORT_ASC : SORT_DESC;  
		$type = ($type == 'number') ? SORT_NUMERIC : SORT_STRING;  
		array_multisort($order_arr, $order, $type, $array);
	}
	return $array;
}
//二维数组去重
function array_unique_fb($array2D){
	$temp=array();
  foreach($array2D as $v){
	  $v = join(",",$v); //降维,也可以用implode,将一维数组转换为用逗号连接的字符串
	  $temp[] = $v;
  }
  $temp = array_unique($temp);    //去掉重复的字符串,也就是重复的一维数组
  foreach($temp as $k => $v){
	  $temp[$k] = explode(",",$v);   //再将拆开的数组重新组装
  }
  return $temp;
   
}
//订单整合
function zhenghe_array($yuanarr) {
	$dingdan=array();
	$dingdanlist=array(); 
	if (is_array($yuanarr)) {
		foreach ($yuanarr as $z) {
		$itemz=array();
		$itemz[]=$z['dingdanhao'];
		$itemz[]=$z['kehu'];
		$itemz[]=$z['shenhe'];
		$itemz[]=$z['riqi'];
		$dingdan[]=$itemz;
			
		}
		$dingdan=array_unique_fb($dingdan);
		foreach($dingdan as $value){
			$itemx=array();
			$productlist=array();
			foreach($yuanarr as $y){
				if($value[0]==$y['dingdanhao']){
					$itemxitem=array();
					//得到规格型号
					$itemxitem['xinghao']=$y['xinghao'];
					//得到应发数量
					$itemxitem['yingfa']=$y['yingfa'];
					//得到已发数量
					$itemxitem['yifa']=$y['yifa'];
					//得到库存数量
					$itemxitem['kucun']=$y['kucun'];
					//得到备注
					$itemxitem['beizhu']=$y['beizhu'];
					$productlist[]=$itemxitem;
				}
			}
			$itemx['dingdanhao']=$value[0];
			$itemx['kehu']=$value[1];
			$itemx['shenhe']=$value[2];
			$itemx['riqi']=$value[3];
			$itemx['chanpin']=$productlist;
			$dingdanlist[]=$itemx;
		}
	}
	return $dingdanlist;
}

include(ROOT.'view/front/dingdanfahuo.html'); //加载顶部




?>
