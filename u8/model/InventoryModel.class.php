<?php
defined('ACC')||exit('对不起！你无权访问！');

class InventoryModel extends Model{
	protected $table='Inventory';
	
	public function selectOneTable($cInvCode){
		$sql="select cInvStd from ".$this->table." where cInvCode ='".$cInvCode."'";
		return $this->db->getRow($sql);
	}
	
	
}
?>