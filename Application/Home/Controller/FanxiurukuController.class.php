<?php
namespace Home\Controller;
use Common\Controller\AuthController;
class FanxiurukuController extends AuthController {
	
    public function index(){
		$model=D('Fanxiu');
		//拼接查询条件
		$map="flag=8 and result!=4";
		$count=$model->where($map)->count();
		//日常工作计划未完成
		$datalist=$model->where($map)->order('fanxiunumber desc')->select();
		//调用工具类
		$fanxiu=new \lib\Fanxiu();
		$datalist=$fanxiu->dengji($datalist);
		$this->assign('pagetitle','出库确认');
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
			$data['flag']=9;
			$data['entry_date']=time();
			$idlist = explode(",",$id);
			$flagb="";
			foreach($idlist as $value){
				$flagb=$model->where('id = %d',$value)->save($data);
			}
			if($flagb){
				$this->ajaxReturn(array(
					'state'=>'ok',
					'info' => '确认成功！'
				));
			}else{
				$this->ajaxReturn(array(
					'state'=>'error',
					'info' => '确认失败！'
				));
			}
			
		}
	}
	
}
?>