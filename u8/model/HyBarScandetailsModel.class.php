<?php
defined('ACC')||exit('对不起！你无权访问！');

class HyBarScandetailsModel extends Model{
	protected $table='hy_bar_scandetails';
	
	public function selectTable($keyval,$cinvcode){
		$sql="select barcode from ".$this->table." where  keyval = '".$keyval."' and cinvcode= '".$cinvcode."' and cvouchtype=05";
		return $this->db->getAll($sql);
	}
}
?>