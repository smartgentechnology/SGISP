<?php
namespace lib;

class Workplan {
	public function changeFiled($datalist){
		$changelist=array();
		//OA人员信息表
		$memberModel=M('member','org_','OA');
		$unitModel=M('unit','org_','OA');
		if(!empty($datalist)){
			foreach($datalist as $value){
				$value['dept_name']=$unitModel->where("ID='%s'",$value['dept_id'])->getField("NAME");
				if($value[number]<10){
					$value['number']=$value['dept_name'].date('m',$value['month']).'-0'.$value['number'];
				}else{
					$value['number']=$value['dept_name'].date('m',$value['month']).'-'.$value['number'];
				}
				switch($value['state']){
					case 0:
						$value['state']='未完成';
						break;
					case 1:
						$value['state']='已完成';
						break;
					case 2:
						$value['state']='暂停或取消';
						break;
					case 3:
						$value['state']='持续';
						break;
				}
				$value['manager_name']=$memberModel->where("ID='%s'",$value['manager_id'])->getField('NAME');
				$value['manager_add_name']=$memberModel->where("ID='%s'",$value['manager_add'])->getField('NAME');
				$value['add_time']=date('Y-m-d',$value['add_time']);
				$changelist[]=$value;
			}
		}
		return $changelist;
	}
	public function jsonchangeFiled($datalist){
		$changelist=array();
		//OA人员信息表
		$memberModel=M('member','org_','OA');
		$unitModel=M('unit','org_','OA');
		if(!empty($datalist)){
			foreach($datalist as $value){
				$arr=array();
				$arr['id']=$value['id'];
				$value['dept_name']=$unitModel->where("ID='%s'",$value['dept_id'])->getField("NAME");
				if($value[number]<10){
					$arr['number']=$value['dept_name'].date('m',$value['month']).'-0'.$value['number'];
				}else{
					$arr['number']=$value['dept_name'].date('m',$value['month']).'-'.$value['number'];
				}
				$arr['content']=$value['content'];
				$arr['resource']=$value['resource'];
				$arr['date']=$value['date'];
				$arr['manager_name']=$memberModel->where("ID='%s'",$value['manager_id'])->getField('NAME');
				switch($value['state']){
					case 0:
						$arr['state']='未完成';
						break;
					case 1:
						$arr['state']='已完成';
						break;
					case 2:
						$arr['state']='暂停或取消';
						break;
					case 3:
						$arr['state']='持续';
						break;
				}
				$arr['remarks']=$value['remarks'];
				$arr['manager_add_name']=$memberModel->where("ID='%s'",$value['manager_add'])->getField('NAME');
				$arr['add_time']=date('Y-m-d',$value['add_time']);
				$changelist[]=$arr;
			}
		}
		return $changelist;
	}
}





?>