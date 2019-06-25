<?php
namespace Home\Controller;
use Think\Controller;
class RbacjsonController extends Controller {
    
	public function check() {
		$data=array();
		$uid=I('get.uid');
		$name=I('get.name');
		$authRuleModel=D('AuthRule');
		$authGroupAccessModel=D('AuthGroupAccess');
		$authGroupModel=D('AuthGroup');
		$groupIdList=array();
		$groupIdList=$authGroupAccessModel->where("uid='%s'",$uid)->field("group_id")->select();
		if($groupIdList){
			$groupId=array();
			foreach($groupIdList as $a){
				$groupId[]=$a["group_id"];
			}
			$groupIdStr=implode(",",$groupId);
			//权限列表
			$authGroupList=$authGroupModel->where("id in (".$groupIdStr.")")->field("rules")->select();
			if($authGroupList){
				$authGroupStrList=array();
				foreach($authGroupList as $b){
					if($b['rules']!=""){
						$c=explode(",",$b['rules']);
						foreach($c as $d){
							$authGroupStrList[]=$d;
						}
					}
					
				}
				if(!empty($authGroupStrList)){
					$authGroupStr=implode(",",$authGroupStrList);
					$flag=$authRuleModel->where("id in(".$authGroupStr.") and name='".$name."'")->find();
					if($flag){
						$data['state']='access';
						$data['info']='有此模块权限！';
					}else{
						$data['state']='error';
						$data['info']='没有此模块权限！';
					}
				}else{
					$data['state']='error';
					$data['info']='没有此模块权限！';
				}
			}else{
				$data['state']='error';
				$data['info']='没有此模块权限！';
			}
		}else{
			$data['state']='error';
			$data['info']='没有此模块权限！';
		}
		header('Content-Type:text/html; charset=utf-8');
        exit(json_encode($data,JSON_UNESCAPED_UNICODE));
		
	}
	
}
?>