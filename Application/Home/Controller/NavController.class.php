<?php
namespace Home\Controller;
use Common\Controller\AuthController;
class NavController extends AuthController {
    public function index(){
		$model=D('Nav');
		$navlist=$model->getTreeData('tree',-1,'order_number,id');
		//print_r($navlist);
		$this->assign('pagetitle','菜单管理');
		$this->assign('navlist',$navlist);
		$this->display();
		
		
    }
	public function add(){
		$model=D('Nav');
		if(IS_POST){
			$data=array();
			$data['pid']=I('post.pid');
			$data['name']=I('post.name');
			$data['mca']=I('post.mca');
			$data['ico']=I('post.ico');
			$data['color']=I('post.color');
			$data['order_number']=I('post.order_number');
			$flaga=$model->where("mca='%s'",$data['mca'])->find();
			if($flaga){
				$this->ajaxReturn(array(
					'state'=>'error',
					'info' => '菜单链接已存在！'
				));
			}else{
				$flagb=$model->add($data);
				if($flagb){
					session('add_nav_pid',$data['pid']);
					session('add_nav_name',$data['name']);
					session('add_nav_mca',$data['mca']);
					session('add_nav_ico',$data['ico']);
					session('color',$data['color']);
					$this->ajaxReturn(array(
						'state'=>'ok',
						'info' => '菜单添加成功！'
					));
				}else{
					$this->ajaxReturn(array(
						'state'=>'error',
						'info' => '菜单添加失败！'
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
		$model=D('Nav');
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
			$data['mca']=I('post.mca');
			$data['ico']=I('post.ico');
			$data['color']=I('post.color');
			$data['order_number']=I('post.order_number');
			$flaga=$model->where("mca='%s' AND id !=%d",$data['mca'],$id)->find();
			if($flaga){
				$this->ajaxReturn(array(
					'state'=>'error',
					'info' => '菜单链接已存在！'
				));
			}else{
				if($id===$data['pid']){
					$this->ajaxReturn(array(
						'state'=>'error',
						'info' => '父菜单不能是自己！'
					));
				}else{
					$flagc=$model->where('id=%d',$id)->save($data);
					if($flagc!==false){
						$this->ajaxReturn(array(
							'state'=>'ok',
							'info' => '菜单修改成功！'
						));
					}else{
						$this->ajaxReturn(array(
							'state'=>'error',
							'info' => '菜单修改失败！'
						));
					}
				}
			}
		}
	}
	
	public function del($id=''){
		$model=D('Nav');
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
					'info' => '该菜单有下级菜单，请先删除下级菜单！'
				));
			}else{
				$flagb=$model->where('id in (%s)',$id)->delete();
				if($flagb){
					$this->ajaxReturn(array(
						'state'=>'ok',
						'info' => '菜单删除成功！'
					));
				}else{
					$this->ajaxReturn(array(
						'state'=>'error',
						'info' => '菜单删除失败！'
					));
				}
			}
		}
	}
	
}
?>