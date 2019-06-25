<?php

defined('ACC')||exit('对不起！你无权访问！');//给当前文件上锁

class mysql extends db{
	private static $ins=null;
	private $con=null;
	private $conf=array();
	
	//初始化类定义为最终，禁止继承，实现单例
	final protected function __construct(){
		$this->conf=conf::getIns();
		$this->connect($this->conf->host,$this->conf->user,$this->conf->pwd);
		$this->changeDB($this->conf->dbname);
		$this->setChar($this->conf->charset);
	}
	//禁止克隆
	final protected function __clone(){
	
	}
	public function __destruct(){
		mysql_close($this->con);
	}
	//静态调用方法
	public static function getIns(){
		if(self::$ins instanceof self){
			return self::$ins;
		}else{
			self::$ins=new self();
			return self::$ins;
		}
	}
	/*
	链接数据库
	$h  服务器地址
	$u  用户名
	$p  密码
	return bool
	*/
	public function connect($host,$user,$pwd){
		$this->con=mysql_connect($host,$user,$pwd);
		if(!$this->con){
			$err=new Exception('连接失败');
			throw $err;
		}
	}
	
	//切换数据库
	public function changeDB($dbName){
		$sql='use '.$dbName;
		$this->query($sql);
	}
	//改变字符集
	public function setChar($charset){
		$sql='set names '.$charset;
		$this->query($sql);
	}
	
	/*
	发送查询
	$sql 查询语句
	return array/bool
	*/
	public function query($sql){
		$rs=mysql_query($sql,$this->con);
		//log::write($sql);
		return $rs;
	}
	
	/*
	查询多条语句
	$sql 查询语句
	return array/bool
	*/
	public function getAll($sql){
		$list=array();
		$rs=$this->query($sql,$this->con);
		if(!$rs){
			return false;
		}
		while($row=mysql_fetch_assoc($rs)){
			$list[]=$row;
		}
		return $list;
	}
	/*
	查询单条语句
	$sql 查询语句
	return array/bool
	*/
	public function getRow($sql){
		$rs=$this->query($sql,$this->con);
		if(!$rs){
			return false;
		}
		return mysql_fetch_assoc($rs);
	}
	/*
	查询单个值
	$sql 查询语句
	return 值/bool
	*/
	public function getOne($sql){
		$rs=$this->query($sql,$this->con);
		if(!$rs){
			return false;
		}
		$row=mysql_fetch_row($rs);
		return $row[0];
	}
	
	/*
	自动执行insert/update语句
	$table 表名
	$data 列名和值
	$act 动作
	$where  update 时使用
	return int
	*/
	public function autoExecute($table,$arr,$mode='insert',$where='where 1 limit 1'){
		if(!is_array($arr)){
			return false;
		}
		//更新语句拼接
		if($mode=='update'){
			$sql='update '.$table.' set ';
			foreach($arr as $key=>$value){
				$sql.=$key."='".$value."',";
			}
			$sql =rtrim($sql,',');
			$sql.=' '.$where;
			return $this->query($sql);
		}
		//出入语句拼接
		$sql='insert into '.$table.'('.implode(',',array_keys($arr)).')';
		$sql.=' values (\'';
		$sql.=implode("','",array_values($arr));
		$sql.='\')';
		return $this->query($sql);
	}
	// 返回影响行数的函数
    public function affected_rows() {
        return mysql_affected_rows($this->con);
    }

    // 返回最新的auto_increment列的自增长的值
    public function insert_id() {
        return mysql_insert_id($this->con);
    }
}









?>