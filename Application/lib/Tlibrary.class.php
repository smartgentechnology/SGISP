<?php
namespace lib;

class Tlibrary {
	public function changeFiled($datalist){
		$changelist=array();
		//OA人员信息表
		$memberModel=M('member','org_','OA');
		if(!empty($datalist)){
			foreach($datalist as $value){
				switch($value['flag']){
					case 0:
						$value['flag']='办公';
						break;
					case 1:
						$value['flag']='研发';
						break;
				}
				$value['mdate']=date('Y-m-d',$value['mdate']);
				$value['manager_name']=$memberModel->where("ID='%s'",$value['manager_id'])->getField('NAME');
				$changelist[]=$value;
			}
		}
		return $changelist;
	}
}





?>