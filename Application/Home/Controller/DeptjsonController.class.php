<?php
namespace Home\Controller;
use Common\Controller\AuthController;
class DeptjsonController {
    public function dis(){
		//OA部门信息表
		$unitModel=M('unit','org_','OA');
		//公司
		$company=$unitModel->where("TYPE='Account' and IS_GROUP=0")->field("ID,NAME,PATH,SORT_ID")->find();
		//部门
		$deptside=$unitModel->where("IS_ENABLE=1 and TYPE='Department'")->order("SORT_ID asc")->field("ID,NAME,PATH,SORT_ID")->select();
		$pathlen=strlen($company['path']);
		foreach($deptside as $key=>$value){
			$deptside[$key]['path']=substr($value['path'],$pathlen);
		}
		//格式化部门结构-树形结构
		$utils=new \lib\Utils();
		//部门树
		$deptlist=$utils->getdeptList($deptside);
		//公司树
		$company['son']=$deptlist;
		$datalist=array();
		$arr=array();
		$arr['id']=$company['id'];
		$arr['name']=$company['name'];
		$arr['level']=0;
		$datalist[]=$arr;
		$ason=$company['son'];
		if(!empty($ason)){
			foreach($ason as $b){
				$brr=array();
				$brr['id']=$b['id'];
				$brr['name']=$b['name'];
				$brr['level']=1;
				$datalist[]=$brr;
				$bson=$b['son'];
				if(!empty($bson)){
					foreach($bson as $c){
						$crr=array();
						$crr['id']=$c['id'];
						$crr['name']=$c['name'];
						$crr['level']=2;
						$datalist[]=$crr;
					}
				}
			}
		}
		$data['state']='access';
		$data['info']='查询成功！';
		$data['data']=$datalist;
		header('Content-Type:text/html; charset=utf-8');
        exit(json_encode($data,JSON_UNESCAPED_UNICODE));
    }
}
?>