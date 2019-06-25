<?php
/*
引入配置文件实现类单例
*/
defined('ACC')||exit('对不起！你无权访问！');//给当前文件上锁
class conf{

	protected static $ins=null;
	protected $data=array();
	
	final protected function  __construct(){
		include(ROOT.'include/config.inc.php');	//一次性把配置文件信息读进来
		$this->data = $_CFG;  			//把配置文件信息付给data数组
	}
	
	final protected function __clone(){
	
	}
	
	public static function getIns(){
		if(self::$ins instanceof self){
			return self::$ins;
		}else{
			self::$ins=new self();
			return self::$ins;
		}
	}
	//用魔术方法读取data内的信息
	public function __get($key){
		if(array_key_exists($key,$this->data)){
			return $this->data[$key];
		}else{
			return null;
		}
	}
	//用魔术方法运行期动态改变配置选项
	public function __set($key,$value){
		$this->data[$key] = $value;
	}
	
	
}
/*
调试该类

$conf=conf::getIns();
echo $conf->host;
echo $conf->user;
echo $conf->pwd;
var_dump($conf->abc);


$conf->name='abc';
echo $conf->name;

*/






































?>