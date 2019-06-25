<?php
/*
数组和XML文件之间切换
*/
defined('ACC')||exit('对不起！你无权访问！');//给当前文件上锁

class ParseXMLTool{
	//得到文件返回数组
	public function getarr($file){
		if(!is_file($file)){
			return false;
		}
		$simxml=simplexml_load_file($file);
		return $this->xmltoarr($simxml);
	}
	//文件转换数组
	protected function xmltoarr($simxml){
		$arr=(array)$simxml;
		foreach($arr as $key=>$value){
			if($value instanceof SimpleXMLElement || is_array($value)){
				$arr[$key]=$this->xmltoarr($value);
			}
		}
		return $arr;
	}
	//得到数组返回文件是否创建成功
	public function getxml($arr,$root,$filename,$val){
		$simxml=new SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?>'.$root);
		$simxml=$this->arrtoxml($simxml,$arr,$val);
		return $simxml->asXML($filename);
	}
	//数组转文件
	protected function arrtoxml($sim,$arr,$val){
		foreach($arr as $key=>$value){
			if(is_array($value)){
				if(is_numeric($key)){
					$this->arrtoxml($sim->addChild($val),$value,$val);
				}else{
					$this->arrtoxml($sim->addChild($key),$value,$val);
				}
			}else{
				if(is_numeric($key)){
					$sim->addChild($val,$value);
				}else{
					$sim->addChild($key,$value);
				}
			}
		}
		return $sim;
	}
}

/*
$parsexml=new ParseXML();

$arr=array('item'=>'HGM9000系列','abc'=>array('a1'=>'a1','a2'=>'a2','a3'=>array('a','a4','5a','a6')));
header('content-type: text/xml');
echo $parsexml->getxml($arr);


$parsexml->getarr(CATEGORY.'category.xml');
echo '<br>';
echo '<hr>';
$parsexml->getarr(SERIES.'genset.xml');
echo '<br>';
echo '<hr>';
$parsexml->getarr(SERIES.'atscontrol.xml');
echo '<br>';
echo '<hr>';
$parsexml->getarr(SERIES.'marine.xml');
echo '<br>';
echo '<hr>';
$parsexml->getarr(SERIES.'waterpump.xml');
echo '<br>';
echo '<hr>';
$parsexml->getarr(PRODUCTS.'hgm72.xml');
echo '<br>';
echo '<hr>';
$parsexml->getarr(PRODUCTS.'hgm180hc.xml');
echo '<br>';
echo '<hr>';
$parsexml->getarr(PRODUCTS.'hmc9510.xml');
echo '<br>';
echo '<hr>';
$parsexml->getarr(PRODUCTS.'apc715.xml');
echo '<br>';
echo '<hr>';
$parsexml->getarr(DOWNLOAD.'downloadlist.xml');
*/



?>