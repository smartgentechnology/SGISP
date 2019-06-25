<?php
defined('ACC')||exit('对不起！你无权访问！');

class Lc_tlibraryModel extends Model{
	protected $table='lc_tlibrary';
	protected $pk='id';
	//自动验证数据库字段
	protected $fields=array('id','cn','en','abben','sp','jp','ru','remarks','manager_id','mdate','flag');
	
	//得到总数搜索使用
	public function searchCount($where){
		$sql='select count(*) from '.$this->table.$where;
		return $this->db->getOne($sql);
	}
	//搜索使用得到搜索信息
	public function searchWhere($where,$offset=0,$limit=5){
		$sql='select * from '.$this->table.$where.' order by mdate desc limit '.$offset.','.$limit;
		return $this->db->getAll($sql);
	}
}
?>