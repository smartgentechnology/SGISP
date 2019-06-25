<?php
namespace Home\Controller;
use Common\Controller\AuthController;
class FanxiuauditController extends AuthController {
	
    public function index(){
		$model=D('Fanxiu');
		//拼接查询条件
		$map="(result =1 and flag=3) or flag=7 or (result =4 and flag=3)";
		$count=$model->where($map)->count();
		//日常工作计划未完成
		$datalist=$model->where($map)->order('fanxiunumber desc')->select();
		//调用工具类
		$fanxiu=new \lib\Fanxiu();
		$datalist=$fanxiu->dengji($datalist);
		$this->assign('pagetitle','审核');
		$this->assign('datalist',$datalist);
		$this->assign('count',$count);
		$this->assign('page',$show);
		$this->display();
    }
	
	public function edit($id=''){
		$model=D('Fanxiu');
		if(empty($id)){
			$this->ajaxReturn(array(
				'state'=>'error',
				'info' => '请至少选择一条记录！'
				));
		}else{
			$id=substr($id,0,-1);
			$data=array();
			$data['flag']=8;
			$data['leader_id']=session('manager_id');
			$data['leader_date']=time();
			$idlist = explode(",",$id);
			$flagb="";
			foreach($idlist as $value){
				$flagb=$model->where('id = %d',$value)->save($data);
			}
			if($flagb){
				$this->ajaxReturn(array(
					'state'=>'ok',
					'info' => '审核成功！'
				));
			}else{
				$this->ajaxReturn(array(
					'state'=>'error',
					'info' => '审核失败！'
				));
			}
			
		}
	}
	
}
?>