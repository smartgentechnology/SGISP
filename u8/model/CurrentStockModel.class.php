<?php
defined('ACC')||exit('对不起！你无权访问！');

class CurrentStockModel extends Model{
	protected $table='CurrentStock';
	
	public function selectTable($cInvCode){
		$sql="select iQuantity from ".$this->table." where cInvCode ='".$cInvCode."' and cWhCode='01.01' and iQuantity>0";
		return $this->db->getAll($sql);
	}
	
	
}
?>