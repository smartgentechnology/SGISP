<?php
defined('ACC')||exit('对不起！你无权访问！');

class DispatchListsModel extends Model{
	protected $table='DispatchLists';
	protected $pk='AutoID';
	
	public function selectTable($DLID){
		$sql="select cInvCode,iQuantity,cBatch from ".$this->table." where DLID = ".$DLID." and iQuantity > 0";
		return $this->db->getAll($sql);
	}
	
	
}
?>