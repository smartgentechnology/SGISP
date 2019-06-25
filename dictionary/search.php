<?php
define('ACC',true);  //得到访问权限
require('./include/init.php');  //加载初始化配置

$keyword=$_GET['keyword'];
if($keyword==''){
	header('location:index.php');
	exit;
}else{
	//查找ECU
	$tlibrary=new Lc_tlibraryModel();
	$data=array();
	//得到当前页数
	$page = isset($_GET['page']) ? $_GET['page']+0 : 1;
	if($page<1){
		$page=1;
	}
	
	if($keyword!=''){
		$str=" where cn like '%".$keyword."%' or en like '%".$keyword."%' or sp like '%".$keyword."%' or jp like'%".$keyword."%' or ru like '%".$keyword."%' or abben like '%".$keyword."%' ";
	}
	//得到总记录
	$total=$tlibrary->searchCount($str);
	//得到总页数
	$perpage=15;
	$lastpage=ceil($total/$perpage);
	if($page>ceil($total/$perpage)){
		$page=1;
	}
	//计算偏移量
	$offset=($page-1)*$perpage;
	//得到分页代码
	$newpagetool=new NewPageTool($total,$page,$perpage);
	$pagecode=$newpagetool->show();
	//得到资料列表
	$data=$tlibrary->searchWhere($str,$offset,$perpage);

	include(ROOT.'view/front/search.html'); //加载查询结果页面
}


?>
