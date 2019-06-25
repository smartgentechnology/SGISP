<?php
namespace Home\Controller;
use Common\Controller\AuthController;
class FanxiugonggaoController extends AuthController {
	
    public function index(){
		$model=D('Fanxiugonggao');
		//日常工作计划未完成
		$datalist=$model->select();
		//调用工具类
		$utils=new \lib\Utils();
		$datalist=$utils->managerIdtoName($datalist);
		
		$this->assign('pagetitle','返修公告');
		$this->assign('datalist',$datalist);
		$this->display();
    }
	
	public function add(){
		$model=D('Fanxiugonggao');
		if(IS_POST){
			$data=array();
			$data['content']=I('post.content');
			$data['add_time']=time();
			$data['manager_id']=session('manager_id');
			// 验证通过 写入新增数据
			$flagb=$model->add($data);
			if($flagb){
				$this->ajaxReturn(array(
					'state'=>'ok',
					'info' => '返修公告添加成功！'
				));
			}else{
				$this->ajaxReturn(array(
					'state'=>'error',
					'info' => '返修公告添加失败！'
				));
			}
		}else{
			$this->ajaxReturn(array(
				'state'=>'ok',
				'info' => ''
			));
		}
	}
	
	public function edit(){
		$model=D('Fanxiugonggao');
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
			$data=array();
			$data['content']=I('post.content');
			$manager_id=session('manager_id');
			$orgmanagerid=$model->where('id=%d',$id)->getField("manager_id");
			if($orgmanagerid==$manager_id){
				$flagb=$model->where('id=%d',$id)->save($data);
				if($flagb!==false){
					$this->ajaxReturn(array(
						'state'=>'ok',
						'info' => '维修公告修改成功！'
					));
				}else{
					$this->ajaxReturn(array(
						'state'=>'error',
						'info' => '维修公告修改失败！'
					));
				}
			}else{
				$this->ajaxReturn(array(
					'state'=>'error',
					'info' => '不允许修改别人的信息！'
				));
			}
			
			
		}
	}
	
	public function del(){
		$model=D('Fanxiugonggao');
		$id=I('get.id');
		if(empty($id)){
			$this->ajaxReturn(array(
				'state'=>'error',
				'info' => '请至少选择一条记录！'
				));
		}else{
			$id=substr($id,0,-1);
			$manager_id=session('manager_id');
			$flagb=$model->where('id in ('.$id.') and manager_id='.$manager_id)->delete();
			if($flagb){
				$this->ajaxReturn(array(
					'state'=>'ok',
					'info' => '维修公告删除成功！'
				));
			}else{
				$this->ajaxReturn(array(
					'state'=>'error',
					'info' => '维修公告删除失败！'
				));
			}
			
		}
	}
	
}
?>