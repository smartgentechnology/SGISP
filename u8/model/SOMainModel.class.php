<?php
defined('ACC')||exit('对不起！你无权访问！');

class SOMainModel extends Model{
	protected $table='SO_SOMain';
	protected $pk='ID';
	
	//根据ID得到表一行数据
	public function getRow($cSOCode){
		$sql="select cCusName,cVerifier,dverifydate from ".$this->table." where cSOCode ='".$cSOCode."' and iStatus=1 and cCloser is NULL";
		return $this->db->getRow($sql);
	}
	
	
}
?>