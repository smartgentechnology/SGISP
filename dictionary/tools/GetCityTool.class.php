<?php
/*
获取客户端IP地址
将IP地址转换成城市
*/
defined('ACC')||exit('对不起！你无权访问！');//给当前文件上锁

class GetCityTool{
	//获取计算机的外网ip
	 public function getClientIp(){
		$onlineip=''; 
		if(getenv('HTTP_CLIENT_IP')&&strcasecmp(getenv('HTTP_CLIENT_IP'),'unknown')){ 
			$onlineip=getenv('HTTP_CLIENT_IP'); 
		} elseif(getenv('HTTP_X_FORWARDED_FOR')&&strcasecmp(getenv('HTTP_X_FORWARDED_FOR'),'unknown')){ 
			$onlineip=getenv('HTTP_X_FORWARDED_FOR'); 
		} elseif(getenv('REMOTE_ADDR')&&strcasecmp(getenv('REMOTE_ADDR'),'unknown')){ 
			$onlineip=getenv('REMOTE_ADDR'); 
		} elseif(isset($_SERVER['REMOTE_ADDR'])&&$_SERVER['REMOTE_ADDR']&&strcasecmp($_SERVER['REMOTE_ADDR'],'unknown')){ 
			$onlineip=$_SERVER['REMOTE_ADDR']; 
		} 
		return $onlineip;	 
	}
	//将IP地址转换成城市
	public function GetIpLookup($ip = ''){  
		if(empty($ip)){  
			$ip = GetIp();  
		}
		$res = @file_get_contents('http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=js&ip=' . $ip);  
		if(empty($res)){ return false; }
		$jsonMatches = array();  
		preg_match('#\{.+?\}#', $res, $jsonMatches);
		if(!isset($jsonMatches[0])){ return false; }
			$json = json_decode($jsonMatches[0], true);
		if(isset($json['ret']) && $json['ret'] == 1){
			$json['ip'] = $ip;
			unset($json['ret']);
		}else{
			return false;
		}
		return $json;
	}
}





















?>