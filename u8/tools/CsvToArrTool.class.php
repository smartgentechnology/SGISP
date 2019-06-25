<?php
/*
CSV文件转换成数组并返回
*/
defined('ACC')||exit('对不起！你无权访问！');//给当前文件上锁

class CsvToArrTool{
	
	public function ctoa($file){
		if(!file_exists($file)){
			return false;
		}
		$data=array();
		$fcon=fopen($file,'rb');
		while(!feof($fcon)){
			$row=fgetcsv($fcon);
			$data[]=$row;
		}
		return $data;
	}
}





















?>