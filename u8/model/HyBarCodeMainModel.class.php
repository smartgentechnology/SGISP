<?php
defined('ACC')||exit('对不起！你无权访问！');

class HyBarCodeMainModel extends Model{
	protected $table='HY_BarCodeMain';
	
	public function selectOneTable($BarCode){
		$sql="select cBarcodeDefine7 from ".$this->table." where BarCode = '".$BarCode."' and cBarcodeDefine7 is not NULL and cBarcodeDefine7!=''";
		return $this->db->getAll($sql);
	}
	
	
}
?>