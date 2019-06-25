<?php
/*
数据库抽象类
*/
defined('ACC')||exit('对不起！你无权访问！');//给当前文件上锁
abstract class db{
	/*
	链接数据库
	$h  服务器地址
	$u  用户名
	$p  密码
	return bool
	*/
	public abstract function connect($host,$arr);
	
	/*
	发送查询
	$sql 查询语句
	return array/bool
	*/
	public abstract function query($sql);
	
	/*
	查询多条语句
	$sql 查询语句
	return array/bool
	*/
	public abstract function getAll($sql);
	/*
	查询单条语句
	$sql 查询语句
	return array/bool
	*/
	public abstract function getRow($sql);
	
	/*
	查询单个值
	$sql 查询语句
	return 值/bool
	*/
	public abstract function getOne($sql);
	
	/*
	自动执行insert/update语句
	$table 表名
	$data 列名和值
	$act 动作
	$where  update 时使用
	return int
	*/
	public abstract function autoExecute($table,$arr,$mode='insert',$where='where 1 limit 1');
	
}












?>