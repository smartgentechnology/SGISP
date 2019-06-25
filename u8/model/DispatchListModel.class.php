<?php
defined('ACC')||exit('对不起！你无权访问！');

class DispatchListModel extends Model{
	protected $table='DispatchList';
	protected $pk='DLID';
	
	public function selectTable(){
		$sql='select DLID,cDLCode,cCusCode,cCusName,dDate from '.$this->table.' where cVerifier is null and cVouchType=05 order by cDLCode desc';
		return $this->db->getAll($sql);
	}
	public function selectAllTable($cDLCode,$cCusCode){
		$sql="select DLID,cDLCode from ".$this->table." where cDLCode != '".$cDLCode."' and cCusCode= '".$cCusCode."' and cVerifier is not null and cVouchType=05 order by cDLCode desc";
		return $this->db->getAll($sql);
	}
	
	
}
?>