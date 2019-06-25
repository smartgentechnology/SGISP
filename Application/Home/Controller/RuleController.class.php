<?php
namespace Home\Controller;
use Common\Controller\AuthController;
class RuleController extends AuthController {
    public function index(){
		$model=D('AuthRule');
		$rulelist=$model->getOrderTreeData('tree','id','title');
		//print_r($rulelist);
		$this->assign('pagetitle','权限管理');
		$this->assign('rulelist',$rulelist);
		$this->display();
		
		
    }
	public function add(){
		$model=D('AuthRule');
		if(IS_POST){
			$data=array();
			$data['pid']=I('post.pid');
			$data['name']=I('post.name');
			$data['title']=I('post.title');
			$data['status']=I('post.status');
			$data['type']=I('post.type');
			$data['condition']=I('post.condition');
			$flaga=$model->where("name='%s'",$data['name'])->find();
			if($flaga){
				$this->ajaxReturn(array(
					'state'=>'error',
					'info' => '权限链接已存在！'
				));
			}else{
				$flagb=$model->add($data);
				if($flagb){
					session('add_rule_pid',$data['pid']);
					session('add_rule_name',$data['name']);
					session('add_rule_title',$data['title']);
					/*
					session('add_rule_status',$data['status']);
					session('add_rule_type',$data['type']);
					*/
					session('add_rule_condition',$data['condition']);
					$this->ajaxReturn(array(
						'state'=>'ok',
						'info' => '权限添加成功！'
					));
				}else{
					$this->ajaxReturn(array(
						'state'=>'error',
						'info' => '权限添加失败！'
					));
				}
			}
			
		}else{
			$this->ajaxReturn(array(
				'state'=>'ok',
				'info' => ''
			));
		}
	}
	
	public function edit(){
		$model=D('AuthRule');
		if(IS_GET){
			$id=I('get.id');
			if(empty($id)){
				$this->ajaxReturn(array(
					'state'=>'error',
					'info' => '请至少选择一条记录！'
					));
			}else{
				$id=substr($id,0,-1);
				$result=$model->where('id=%d',$id)->find();
				$this->ajaxReturn(array(
					'state'=>'ok',
					'info' => '',
					'data'=>$result
					));
			}
		}else{
			$id=I('post.id');
			$data['pid']=I('post.pid');
			$data['name']=I('post.name');
			$data['title']=I('post.title');
			$data['status']=I('post.status');
			$data['type']=I('post.type');
			$data['condition']=I('post.condition');
			$flaga=$model->where("name='%s' AND id !=%d",$data['name'],$id)->find();
			if($flaga){
				$this->ajaxReturn(array(
					'state'=>'error',
					'info' => '权限链接已存在！'
				));
			}else{
				if($id===$data['pid']){
					$this->ajaxReturn(array(
						'state'=>'error',
						'info' => '父权限不能是自己！'
					));
				}else{
					$flagc=$model->where('id=%d',$id)->save($data);
					if($flagc!==false){
						$this->ajaxReturn(array(
							'state'=>'ok',
							'info' => '权限修改成功！'
						));
					}else{
						$this->ajaxReturn(array(
							'state'=>'error',
							'info' => '权限修改失败！'
						));
					}
				}
			}
		}
	}
	
	public function del($id=''){
		$model=D('AuthRule');
		if(empty($id)){
			$this->ajaxReturn(array(
				'state'=>'error',
				'info' => '请至少选择一条记录！'
				));
		}else{
			$id=substr($id,0,-1);
			$flaga=$model->where('pid in (%s)',$id)->find();
			if($flaga){
				$this->ajaxReturn(array(
					'state'=>'error',
					'info' => '该权限有下级权限，请先删除下级权限！'
				));
			}else{
				$flagb=$model->where('id in (%s)',$id)->delete();
				if($flagb){
					$this->ajaxReturn(array(
						'state'=>'ok',
						'info' => '权限删除成功！'
					));
				}else{
					$this->ajaxReturn(array(
						'state'=>'error',
						'info' => '权限删除失败！'
					));
				}
			}
		}
	}
	
}
?>