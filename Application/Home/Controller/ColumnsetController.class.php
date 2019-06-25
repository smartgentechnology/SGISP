<?php
namespace Home\Controller;
use Common\Controller\AuthController;
class ColumnsetController extends AuthController {
	
    public function index(){
		$model=D('Columnset');
		$module=I('get.module');
		$manager_id=session('manager_id');
		$count=$model->where("manager_id='%s' and module=%d",$manager_id,$module)->count();
		//日常工作计划未完成
		$datalist=$model->where("manager_id='%s' and module=%d",$manager_id,$module)->order('rank asc')->select();
		//调用工具类
		$fanxiu=new \lib\Fanxiu();
		$datalist=$fanxiu->set($datalist);
		$column=D('Column');
		$columnlist=$column->where("module=1")->order("rank asc")->field("id,name,width")->select();
		$this->assign('pagetitle','栏目设置');
		$this->assign('datalist',$datalist);
		$this->assign('columnlist',$columnlist);
		$this->assign('page',$show);
		$this->assign('module',$module);
		if($module==1){
			$address="Fanxiu/index";
		}elseif($module==2){
			$address="Zichan/index";
		}
		$this->assign('address',$address);
		$this->display();
    }
	public function addall(){
		$model=D('Columnset');
		$column=D('column');
		$module=I('get.module');
		$manager_id=session('manager_id');
		$model->where("module=%d and manager_id='%s'",$module,$manager_id)->delete();
		$columnlist=$column->where("module=%d",$module)->field('id,module,rank,width')->select();
		$datalist=array();
		foreach($columnlist as $value){
			$arr=array();
			$arr['columnid']=$value['id'];
			$arr['module']=$value['module'];
			$arr['rank']=$value['rank'];
			$arr['width']=$value['width'];
			$arr['manager_id']=$manager_id;
			$datalist[]=$arr;
		}
		$flag=$model->addAll($datalist);
		if($flag){
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
	public function add(){
		$model=D('Columnset');
		if(IS_POST){
			$data=array();
			$data['columnid']=I('post.columnid');
			$data['rank']=I('post.rank');
			$data['width']=I('post.width');
			$data['module']=I('post.module');
			$data['manager_id']=session('manager_id');
			$flaga=$model->where("columnid=%d and module=%d",$data['columnid'],$data['module'])->find();
			if($flaga){
				$this->ajaxReturn(array(
					'state'=>'error',
					'info' => '栏目已存在！'
				));
			}else{
				$flagb=$model->add($data);
				if($flagb){
					session('add_fanxiuset_columnid',$data['columnid']);
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
		$model=D('Columnset');
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
			$data['columnid']=I('post.columnid');
			$data['rank']=I('post.rank');
			$data['width']=I('post.width');
			$data['module']=I('post.module');
			$flaga=$model->where("columnid=%d and module=%d and id!=%d",$data['columnid'],$data['module'],$id)->find();
			if($flaga){
				$this->ajaxReturn(array(
					'state'=>'error',
					'info' => '栏目已存在！'
				));
			}else{
				$flagb=$model->where('id=%d',$id)->save($data);
				if($flagb!==false){
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
		$model=D('Columnset');
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