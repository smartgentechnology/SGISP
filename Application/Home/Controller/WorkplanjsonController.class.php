<?php
namespace Home\Controller;
use Common\Controller\AuthController;
class WorkplanjsonController{
	
    public function dis(){
		$model=D('Workplan');
		//OA人员信息表
		$memberModel=M('member','org_','OA');
		//OA部门信息表
		$unitModel=M('unit','org_','OA');
		
		$state=I('get.state');
		$dept_id=I('get.deptid');
		//获取部门树，左侧菜单
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
		//得到该部门下的部门ID
		$deptinfo=$utils->getdeptinfo($company,$dept_id);
		$deptinfolist=$utils->getdeptone($deptinfo);
		$deptidlist=$utils->getTreeID($deptinfo);
		$deptsonstr=implode(",",$deptidlist);
		//拼接查询条件
		if($state==5){
			$state="state =0";
		}else{
			$state="state =".$state;
		}
		//日常工作计划未完成
		$changelist=$model->where($state.' and dept_id in ('.$deptsonstr.')')->order('manager_id asc ,dept_id asc ,month desc , number asc')->select();
		$workplan=new \lib\Workplan();
		//得到日常工作计划列表
		$changelist=$workplan->jsonchangeFiled($changelist);
		$data['state']='access';
		$data['info']='查询成功！';
		$data['data']=$changelist;
		header('Content-Type:text/html; charset=utf-8');
        exit(json_encode($data,JSON_UNESCAPED_UNICODE));
    }
	public function getmanager(){
		$dept_id=I('get.deptid');
		//OA部门信息表
		$unitModel=M('unit','org_','OA');
		//OA人员信息表
		$memberModel=M('member','org_','OA');
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
		//得到该部门下的部门ID
		$deptinfo=$utils->getdeptinfo($company,$dept_id);
		$deptinfolist=$utils->getdeptone($deptinfo);
		$deptidlist=$utils->getTreeID($deptinfo);
		$deptsonstr=implode(",", $deptidlist);
		if(!empty($deptsonstr)){
			//获取该部门的所有人员
			$managerlist=$memberModel->where('ORG_DEPARTMENT_ID in('.$deptsonstr.') and IS_ENABLE=1')->field('ID,NAME')->select();
		}
		unset($deptinfolist[0]['son']);
		$arr['deptlist']=$deptinfolist;
		$arr['managerlist']=$managerlist;
		$data['state']='access';
		$data['info']='查询成功！';
		$data['data']=$arr;
		header('Content-Type:text/html; charset=utf-8');
		exit(json_encode($data,JSON_UNESCAPED_UNICODE));
	}
	public function getnumber(){
		$model=D('Workplan');
		$dept_id=I('get.deptid');
		$month=I('get.month');
		if(empty($month)){
			$month=date('Y-m',time());
		}
		//OA人员信息表
		$memberModel=M('member','org_','OA');
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
		//得到该部门下的部门ID
		$deptinfo=$utils->getdeptinfo($company,$dept_id);
		$deptinfolist=$utils->getdeptone($deptinfo);
		$deptidlist=$utils->getTreeID($deptinfo);
		$deptsonstr=implode(",", $deptidlist);
		if(!empty($deptsonstr)){
			//获取该部门的所有人员
			$managerlist=$memberModel->where('ORG_DEPARTMENT_ID in('.$deptsonstr.') and IS_ENABLE=1')->field('ID,NAME')->select();
		}
		$number=$model->where("dept_id='%s' and month=%d",$dept_id,strtotime($month))->max('number');
		$arr=array();
		$arr['number']=$number+1;
		$arr['managerlist']=$managerlist;
		$data['state']='access';
		$data['info']='查询成功！';
		$data['data']=$arr;
		header('Content-Type:text/html; charset=utf-8');
		exit(json_encode($data,JSON_UNESCAPED_UNICODE));
	}
	public function search() {
		$model=D('Workplan');
		//OA人员信息表
		$memberModel=M('member','org_','OA');
		//OA部门信息表
		$unitModel=M('unit','org_','OA');
		
		$keyword=I('get.keyword');
		$state=I('get.state');
		$dept_id=I('get.deptid');
		//获取部门树，左侧菜单
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
		//得到该部门下的部门ID
		$deptinfo=$utils->getdeptinfo($company,$dept_id);
		$deptinfolist=$utils->getdeptone($deptinfo);
		$deptidlist=$utils->getTreeID($deptinfo);
		$deptsonstr=implode(",",$deptidlist);
		//拼接查询条件
		if($state==5){
			$state="state =0";
		}else{
			$state="state =".$state;
		}
		//日常工作计划未完成
		$datalist=$model->where($state." and dept_id in (".$deptsonstr.") and content like'%".$keyword."%'")->order('manager_id asc ,dept_id asc ,month desc , number asc')->select();
		$workplan=new \lib\Workplan();
		//得到日常工作计划列表
		$datalist=$workplan->jsonchangeFiled($datalist);
		if($datalist){
			$data['state']='access';
			$data['info']='查询成功！';
			$data['data']=$datalist;
		}else{
			$data['state']='error';
			$data['info']='未查找到相关记录！';
		}
		header('Content-Type:text/html; charset=utf-8');
        exit(json_encode($data,JSON_UNESCAPED_UNICODE));
		
	}
	public function add(){
		$model=D('Workplan');
		$jsondata=array();
		$data=array();
		$data['dept_id']=I('post.deptid');
		$data['month']=strtotime(I('post.month'));
		$data['number']=I('post.number');
		$data['content']=I('post.content');
		$data['resource']=I('post.resource');
		$data['date']=I('post.date');
		$data['manager_id']=I('post.manager_id');
		$data['state']=I('post.state');
		$data['remarks']=I('post.remarks');
		$data['manager_add']=I('post.manager_add');
		//添加时间
		$data['add_time']=time();
		$flaga=$model->where("content='%s'",$data['content'])->find();
		if($flaga){
			$jsondata['state']='error';
			$jsondata['info']='该工作计划已存在！';
		}else{
			// 验证通过 写入新增数据
			$flagb=$model->add($data);
			if($flagb){
				$jsondata['state']='access';
				$jsondata['info']='工作计划添加成功！';
			}else{
				$jsondata['state']='error';
				$jsondata['info']='工作计划添加失败！';
			}
		}
		header('Content-Type:text/html; charset=utf-8');
        exit(json_encode($jsondata,JSON_UNESCAPED_UNICODE));
	}
	
	public function edit(){
		$model=D('Workplan');
		$jsondata=array();
		if(IS_GET){
			$id=I('get.id');
			$result=$model->where('id=%d',$id)->find();
			$result['month']=date('Y-m',$result['month']);
			$jsondata['state']='access';
			$jsondata['info']='查询成功！';
			$jsondata['data']=$result;
		}else{
			$id=I('post.id');
			$data=array();
			$data['dept_id']=I('post.deptid');
			$data['month']=strtotime(I('post.month'));
			$data['number']=I('post.number');
			$data['content']=I('post.content');
			$data['resource']=I('post.resource');
			$data['date']=I('post.date');
			$data['state']=I('post.state');
			$data['manager_id']=I('post.manager_id');
			$data['remarks']=I('post.remarks');
			$flaga=$model->where("content='%s' and id!=%d",$data['content'],$id)->find();
			if($flaga){
				$jsondata['state']='error';
				$jsondata['info']='该工作计划已存在！';
				
			}else{
				$flagb=$model->where('id=%d',$id)->save($data);
				if($flagb!==false){
					$jsondata['state']='access';
					$jsondata['info']='工作计划修改成功！';
				}else{
					$jsondata['state']='error';
					$jsondata['info']='工作计划修改失败！';
				}
			}
			
		}
		header('Content-Type:text/html; charset=utf-8');
        exit(json_encode($jsondata,JSON_UNESCAPED_UNICODE));
	}
	
	public function del(){
		$model=D('Workplan');
		$id=I('post.id');
		$jsondata=array();
		$flagb=$model->where("id =%d",$id)->delete();
		if($flagb){
			$jsondata['state']='access';
			$jsondata['info']='工作计划删除成功！';
		}else{
			$jsondata['state']='error';
			$jsondata['info']='工作计划删除失败！';
		}
		header('Content-Type:text/html; charset=utf-8');
        exit(json_encode($jsondata,JSON_UNESCAPED_UNICODE));
	}
}
?>