<?php
/*
日志操作类
记录信息到日志

传给我一个内容
	判断当前日志的大小
		如果>1M,备份
		否则，写入
*/
defined('ACC')||exit('对不起！你无权访问！');//给当前文件上锁

class log{
	//建一个常量，代表日志文件的名称
	const LOGFILE='curr.log';
	
	//写日志
	public static function write($cont){
		$cont=date('Y-m-d H:i:s ',time()).$cont."\r\n";
		$log=self::isBak();//计算日志文件的地址
		$fcon=fopen($log,'ab');  //打开文件
		fwrite($fcon,$cont);//写内容
		fclose($fcon);
		
	}
	//备份日志
	public static function bak(){
		$log=ROOT.'data/log/'.self::LOGFILE;
		$bak=ROOT.'data/log/'.date('ynd',time()).mt_rand(10000,99999).'.bak';
		return rename($log,$bak);
	}
	//读取并判断日志的大小
	public static function isBak(){
		$log=ROOT.'data/log/'.self::LOGFILE;
		if(!file_exists($log)){//如果文件不存在，则创建文件
			touch($log);  //快速建立一个文件
			return $log;
		}
		
		//清除缓存
		clearstatcache(true,$log);
		
		//如果存在，判断大小
		$size=filesize($log);
		if($size <= (1024*1024)){//文件小于等于1M，返回
			return $log;
		}
		if(self::bak()){
			return $log;
		}else{
			touch($log);
			return $log;
		}
	}
}

/*
测试

log::write('adb');

class Mysql{
	public function query($sql){
		Log::write($sql);
	}
}
$mysql=new Mysql();

for($i=0;$i<=1000;$i++){
	$sql='select * from user';
	$mysql->query($sql);
}
echo '执行完毕';

*/




?>