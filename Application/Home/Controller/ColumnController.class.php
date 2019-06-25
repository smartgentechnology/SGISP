<?php
namespace Home\Controller;
use Common\Controller\AuthController;
class ColumnController extends AuthController {
    public function index(){
		$model=D('Column');
		$datalist=$model->order("module desc ,rank desc,id asc")->select();
		foreach($datalist as $key=>$value){
			switch($value['module']){
				case 1:
					$datalist[$key]['module']='返修台帐';
					break;
				case 2:
					$datalist[$key]['module']='固定资产';
					break;
			}
		}
		$module=array(array('id'=>1,'value'=>'返修台帐'),array('id'=>2,'value'=>'固定资产'));
		$this->assign('pagetitle','栏目设置');
		$this->assign('datalist',$datalist);
		$this->assign('module',$module);
		$this->display();
		
		
    }
	public function add(){
		$model=D('Column');
		if(IS_POST){
			$data=array();
			$data['module']=I('post.module');
			$data['name']=I('post.name');
			$data['field']=I('post.field');
			$data['rank']=I('post.rank');
			$data['width']=I('post.width');
			$flaga=$model->where("name='%s' and module=%d",$data['name'],$data['module'])->find();
			if($flaga){
				$this->ajaxReturn(array(
					'state'=>'error',
					'info' => '栏目已存在！'
				));
			}else{
				$flagb=$model->add($data);
				if($flagb){
					$this->ajaxReturn(array(
						'state'=>'ok',
						'info' => '栏目添加成功！'
					));
				}else{
					$this->ajaxReturn(array(
						'state'=>'error',
						'info' => '栏目添加失败！'
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
		$model=D('Column');
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
			$data['module']=I('post.module');
			$data['name']=I('post.name');
			$data['field']=I('post.field');
			$data['rank']=I('post.rank');
			$data['width']=I('post.width');
			$flaga=$model->where("name='%s' and id !=%d and module=%d",$data['name'],$id,$data['module'])->find();
			if($flaga){
				$this->ajaxReturn(array(
					'state'=>'error',
					'info' => '栏目已存在！'
				));
			}else{
				$flagc=$model->where('id=%d',$id)->save($data);
				if($flagc!==false){
					$this->ajaxReturn(array(
						'state'=>'ok',
						'info' => '栏目修改成功！'
					));
				}else{
					$this->ajaxReturn(array(
						'state'=>'error',
						'info' => '栏目修改失败！'
					));
				}
			}
		}
	}
	
	public function del($id=''){
		$model=D('Column');
		if(empty($id)){
			$this->ajaxReturn(array(
				'state'=>'error',
				'info' => '请至少选择一条记录！'
				));
		}else{
			$id=substr($id,0,-1);
			$flagb=$model->where('id in (%s)',$id)->delete();
			if($flagb){
				$this->ajaxReturn(array(
					'state'=>'ok',
					'info' => '栏目删除成功！'
				));
			}else{
				$this->ajaxReturn(array(
					'state'=>'error',
					'info' => '栏目删除失败！'
				));
			}
		}
	}
	
}
?>