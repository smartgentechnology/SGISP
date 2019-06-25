<?php
/*
递归转义数组，过滤地址栏信息
*/
defined('ACC')||exit('对不起！你无权访问！');//给当前文件上锁
function _addslashes($arr){
	foreach($arr as $key=>$value){
		if(is_string($value)){
			$arr[$key]=addslashes($value);
		}else if(is_array($value)){
			$arr[$key]=_addslashes($value);
		}
	}
	return $arr;
}






?>