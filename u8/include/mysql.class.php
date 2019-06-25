<?php

defined('ACC')||exit('对不起！你无权访问！');//给当前文件上锁

class mysql extends db{
	private static $ins=null;
	private $con=null;
	private $conf=array();
	
	//初始化类定义为最终，禁止继承，实现单例
	final protected function __construct(){
		$this->conf=conf::getIns();
		$conInfo=array('Database'=>$this->conf->dbname, 'UID'=>$this->conf->user, 'PWD'=>$this->conf->pwd);
		$this->connect($this->conf->host,$conInfo);
		//$this->changeDB($this->conf->dbname);
		//$this->setChar($this->conf->charset);
	}
	//禁止克隆
	final protected function __clone(){
	
	}
	public function __destruct(){
		sqlsrv_close($this->con);
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
	$conInfo=array('Database'=>'osbst', 'UID'=>'sa', 'PWD'=>'123456');
	$conn=sqlsrv_connect('192.168.1.208', $conInfo);
	*/
	public function connect($host,$arr){
		$this->con=sqlsrv_connect($host,$arr);
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
		$rs=sqlsrv_query($this->con,$sql);
		log::write($sql);
		return $rs;
	}
	
	/*
	查询多条语句
	$sql 查询语句
	return array/bool
	*/
	public function getAll($sql){
		$list=array();
		$rs=$this->query($sql);
		if(!$rs){
			return false;
		}
		while($row=sqlsrv_fetch_array($rs,SQLSRV_FETCH_ASSOC)){
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
		$rs=$this->query($sql);
		if(!$rs){
			return false;
		}
		return sqlsrv_fetch_array($rs,SQLSRV_FETCH_ASSOC);
	}
	/*
	查询单个值
	$sql 查询语句
	return 值/bool
	*/
	public function getOne($sql){
		$rs=$this->query($sql);
		if(!$rs){
			return false;
		}
		$row=sqlsrv_get_field($rs);
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
        return sqlsrv_rows_affected($this->con);
    }
	/*
    // 返回最新的auto_increment列的自增长的值
    public function insert_id() {
        return sqlsrv_insert_id($this->con);
    }
	*/
}









?>