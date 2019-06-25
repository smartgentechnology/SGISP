<?php
/*
初始化文件-框架初始化
过滤参数

*/
defined('ACC')||exit('对不起！你无权访问！');//给当前文件上锁
//设置初始化路径 
//define('ROOT',$_SERVER['DOCUMENT_ROOT'].'/');
define('ROOT',str_replace('\\','/',dirname(dirname(__FILE__))).'/');
//定义网站的网站
define('WEB','http://www.smartgen.com.cn');
//定义错误级别
define('DEBUG',true);

//开启SESSION
session_start();

/*
引入基础类

require(ROOT.'include/db.class.php');//抽象数据库类
require(ROOT.'include/mysql.class.php');//单例化实现数据库类
require(ROOT.'model/Model.class.php');//数据库模板类
require(ROOT.'model/TestModel.class.php');//test表操作类
require(ROOT.'include/conf.class.php');//读取配置文件
require(ROOT.'include/log.class.php');//日志操作类
require(ROOT.'include/lib_base.php');//基础类：地址栏过滤
*/
//自动加载基础类
require(ROOT.'include/lib_base.php');//基础类：地址栏过滤
function __autoload($class){
	
	if(strtolower(substr($class,-5))== 'model'){
		require(ROOT.'model/'.$class.'.class.php');
	}elseif(strtolower(substr($class,-4))== 'tool'){
		require(ROOT.'tools/'.$class.'.class.php');
	}else{
		require(ROOT.'include/'.$class.'.class.php');
	}
}



//过滤参数,用递归调用方式过滤$_GET,$_POST,$_COOKIE
$_GET=_addslashes($_GET);
$_POST=_addslashes($_POST);
$_COOKIE=_addslashes($_COOKIE);

//定义错误信息
$fanhui=array();


//设置报错级别 
if(defined('DEBUG')){
	error_reporting (E_ALL & ~E_NOTICE);
}else{
	error_reporting(0);
}
//引入英文国际化文件
require(ROOT.'language/cn/common.inc.php');//引入公共页面
?>