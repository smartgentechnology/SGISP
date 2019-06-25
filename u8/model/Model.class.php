<?php
//Model父类，实现数据库增删改查，并对数据进行自动过滤、自动填充
defined('ACC')||exit('对不起！你无权访问！');//给当前文件上锁

class Model{
	protected $table=null;
	protected $pk='';
	protected $fields=array();//自动过滤数组
	protected $auto=array();//自动填充数组
	protected $valid=array();//自动验证所有字段
	protected $emailvalid=array();//自动验证EMAIL
	protected $passwdvalid=array();//自动验证密码
	protected $error=array();
	//得到mysql类
	public function __construct(){
		$this->db=mysql::getIns();
	}
	public function table($table){
		$this->table=$table;
	}
	/*
	自动过滤
	负责把传来的数组清除掉不用的单元，留下与表的字段对应的单元
	*/
	public function _facade($array=array()){
		$data=array();
		foreach($array as $key=>$value){
			if(in_array($key,$this->fields)){
				  $data[$key]=$value;
			}
		}
		return $data;
	}
	/*
	自动填充，负责把表中需要值的字段，而POST又没有传的字段赋值
	*/
	public function _autoValue($data){
		foreach($this->auto as $value){
			if(!array_key_exists($value[0],$data)){
				switch($value[1]){
					case 'value':
					$data[$value[0]]=$value[2];
					break;
					case 'function':
					$data[$value[0]]=call_user_func($value[2]);
					break;
				}
			}
		}
		return $data;
	}
	/*
	自动验证 
	1是必须验证  
	0是有则验证   无则不验证 
	2如有且内容不为空，则检查长度
	格式：protected $valid=array(
	array('goods_name',1,'商品名不能为空','require'),
	array('cat_id',1,'栏目ID必须是整型值','number'),
	array('is_new',0,'只能是0或1','in','0,1'),
	array('goods_brief',2,'简介应在10到100字符','length','10,100')
	);
	*/
	public function _validate($data){
		if(empty($this->valid)){
			return true;
		}
		foreach($this->valid as $key=>$value){
			switch($value[1]){
				case 1:
					if(!isset($data[$value[0]]) || empty($data[$value[0]])){
						$this->error[]=$value[2];
						return false;
					}
					if(!isset($value[4])){
						$value[4]='';
					}
					if(!$this->check($data[$value[0]],$value[3],$value[4])){
						$this->error[]=$value[2];
						return false;
					}
					break;
				case 0:
					if(isset($data[$value[0]])){
						if(!$this->check($data[$value[0]],$value[3],$value[4])){
							$this->error[]=$value[2];
							return false;
						}
					}
					break;
				case 2:
					if(isset($data[$value[0]]) && !empty($data[$value[0]])){
						if(!$this->check($data[$value[0]],$value[3],$value[4])){
							$this->error[]=$value[2];
							return false;
						}
					}
					break;
			}
		}
		return true;
	}
	//自动验证邮箱
	public function _emailvalidate($data){
		if(empty($this->emailvalid)){
			return true;
		}
		foreach($this->emailvalid as $key=>$value){
			switch($value[1]){
				case 1:
					if(!isset($data[$value[0]]) || empty($data[$value[0]])){
						$this->error[]=$value[2];
						return false;
					}
					if(!isset($value[4])){
						$value[4]='';
					}
					if(!$this->check($data[$value[0]],$value[3],$value[4])){
						$this->error[]=$value[2];
						return false;
					}
					break;
			}
		}
		return true;
	}
	//自动验证密码
	public function _passwdvalidate($data){
		if(empty($this->passwdvalid)){
			return true;
		}
		foreach($this->passwdvalid as $key=>$value){
			switch($value[1]){
				case 1:
					if(!isset($data[$value[0]]) || empty($data[$value[0]])){
						$this->error[]=$value[2];
						return false;
					}
					if(!isset($value[4])){
						$value[4]='';
					}
					if(!$this->check($data[$value[0]],$value[3],$value[4])){
						$this->error[]=$value[2];
						return false;
					}
					break;
				case 2:
					if(isset($data[$value[0]]) && !empty($data[$value[0]])){
						if(!$this->check($data[$value[0]],$value[3],$value[4])){
							$this->error[]=$value[2];
							return false;
						}
					}
					break;
			}
		}
		return true;
	}
	protected function check($value,$rule='',$parm=''){
		switch($rule){
			case 'require':
				return !empty($value);
			case 'email':
				return (filter_var($value,FILTER_VALIDATE_EMAIL)!==false);
			case 'number':
				return is_numeric($value);
			case 'in':
				$temp=explode(',',$parm);
				return in_array($value,$temp);
			case 'between':
				list($min,$max)=explode(',',$parm);
				return $value>=$min && $value <= $max;
			case 'length':
				list($min,$max)=explode(',',$parm);
				return strlen($value) >= $min && strlen($value) <= $max;
			default:
				return false;
		}
	}
	
	public function getErr(){
		return $this->error;
	}
	
	//添加操作
	public function add($data){
		return $this->db->autoExecute($this->table,$data);
	}
	//根据主键删除
	public function delete($id){
		$sql='delete from '.$this->table.' where '.$this->pk.'='.$id;
		if($this->db->query($sql)){
			return $this->db->affected_rows();
		}else{
			return false;
		}
		
	}
	//根据ID更新
	public function update($data,$id){
		if($this->db->autoExecute($this->table,$data,'update',' where '.$this->pk.'='.$id)){
			return $this->db->affected_rows();
		}else{
			return false;
		}
		
	}
	//添加操作
	public function truncate(){
		$sql='truncate table '.$this->table;
		if($this->db->query($sql)){
			return $this->db->affected_rows();
		}else{
			return false;
		}
	}
	//查询表所有信息
	public function select(){
		$sql='select * from '.$this->table;
		return $this->db->getAll($sql);
	}
	//根据ID得到表一行数据
	public function find($id){
		$sql='select * from '.$this->table.' where '.$this->pk.'='.$id;
		return $this->db->getRow($sql);
	}
	public function insert_id(){
		return $this->db->insert_id();
	}
	//得到总数
	public function getCountByWhere($where){
		$sql='select count(*) from '.$this->table.$where;
		return $this->db->getOne($sql);
	}
	//取出制定的内容
	public function selectIdByWhere($where){
		$sql='select id from '.$this->table.$where;
		return $this->db->getAll($sql);
	}
	//取出制定的内容
	public function selectByWhere($where){
		$sql='select * from '.$this->table.$where;
		return $this->db->getAll($sql);
	}
	//取出制定的内容
	public function getAllItembyWhere($where,$offset=0,$limit=5){
		$sql='select * from '.$this->table.' where '.$where. ' order by '.$this->pk.' desc limit '.$offset.','.$limit;
		return $this->db->getAll($sql);
	}
}

?>