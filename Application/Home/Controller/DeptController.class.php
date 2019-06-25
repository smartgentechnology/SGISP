<?php
namespace Home\Controller;
use Common\Controller\AuthController;
class DeptController extends AuthController {
    public function index(){
		$model=D('Dept');
		$deptlist=$model->getTreeData('tree','rank,id');
		//print_r($deptlist);
		$this->assign('pagetitle','部门管理');
		$this->assign('deptlist',$deptlist);
		$this->display();
    }
	public function add(){
		$model=D('Dept');
		if(IS_POST){
			$data=array();
			$data['pid']=I('post.pid');
			$data['dept_name']=I('post.dept_name');
			$data['rank']=I('post.rank');
			$dept=D('Dept');
			$flaga=$model->where("dept_name='%s'",$data['dept_name'])->find();
			if($flaga){
				$this->ajaxReturn(array(
					'state'=>'error',
					'info' => '部门已存在！'
				));
			}else{
				$flagb=$model->add($data);
				if($flagb){
					session('add_dept_pid',$data['pid']);
					session('add_dept_name',$data['dept_name']);
					session('add_dept_rank',$data['rank']);
					$this->ajaxReturn(array(
						'state'=>'ok',
						'info' => '部门添加成功！'
					));
				}else{
					$this->ajaxReturn(array(
						'state'=>'error',
						'info' => '部门添加失败！'
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
		$model=D('Dept');
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
			$data['dept_name']=I('post.dept_name');
			$data['rank']=I('post.rank');
			$flaga=$model->where("dept_name='%s' AND id !=%d",$data['dept_name'],$id)->find();
			if($flaga){
				$this->ajaxReturn(array(
					'state'=>'error',
					'info' => '部门已存在！'
				));
			}else{
				if($id===$data['pid']){
					$this->ajaxReturn(array(
						'state'=>'error',
						'info' => '父部门不能是自己！'
					));
				}else{
					$flagc=$model->where('id=%d',$id)->save($data);
					if($flagc!==false){
						$this->ajaxReturn(array(
							'state'=>'ok',
							'info' => '部门修改成功！'
						));
					}else{
						$this->ajaxReturn(array(
							'state'=>'error',
							'info' => '部门修改失败！'
						));
					}
				}
			}
		}
	}
	
	public function del($id=''){
		$model=D('Dept');
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
					'info' => '该部门有下级部门，请先删除下级部门！'
				));
			}else{
				$flagb=$model->where('id in (%s)',$id)->delete();
				if($flagb){
					$this->ajaxReturn(array(
						'state'=>'ok',
						'info' => '部门删除成功！'
					));
				}else{
					$this->ajaxReturn(array(
						'state'=>'error',
						'info' => '部门删除失败！'
					));
				}
			}
		}
	}
	
}
?>