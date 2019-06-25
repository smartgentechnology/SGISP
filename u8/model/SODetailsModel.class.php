<?php
defined('ACC')||exit('对不起！你无权访问！');

class SODetailsModel extends Model{
	protected $table='SO_SODetails';
	protected $pk='AutoID';
	
	public function selectTable(){
		$sql='select cSOCode,cInvCode,iQuantity,iFHQuantity,cMemo from '.$this->table.' where iQuantity!=iFHQuantity or iFHQuantity is NULL and cSCloser is NULL order by AutoID asc';
		return $this->db->getAll($sql);
	}
	
}
?>