<?php
namespace Home\Controller;
use Common\Controller\AuthController;
class FanxiugongnengController extends AuthController {
	
    public function index(){
		$model=D('Fanxiu');
		//拼接查询条件
		$map="flag in (3,4) and result not in (1,4)";
		$count=$model->where($map)->count();
		//日常工作计划未完成
		$datalist=$model->where($map)->order('fanxiunumber desc')->select();
		//调用工具类
		$fanxiu=new \lib\Fanxiu();
		$datalist=$fanxiu->dengji($datalist);
		$result=array(array('id'=>1,'value'=>'合格'),array('id'=>2,'value'=>'不合格'));
		$this->assign('pagetitle','功能检验');
		$this->assign('datalist',$datalist);
		$this->assign('result',$result);
		$this->display();
    }
	//显示功能质检记录
	public function disgongneng(){
		// 实例化数据库连接类
		$model=D('Fanxiuquality');
		$id=I('get.id');
		//查找该方案下的工序
		$qualitylist=$model->where("fanxiuid=%d and type=1",$id)->order('quality_date desc')->select();
		if(empty($qualitylist)){
			$this->ajaxReturn(array(
			'state'=>'error',
			'info' => ''
			));
		}else{
			//调用工具类
			$fanxiu=new \lib\Fanxiu();
			$qualitylist=$fanxiu->quality($qualitylist);
			$this->ajaxReturn(array(
			'state'=>'ok',
			'info' => '',
			'data'=>$qualitylist
			));
		}
	}
	//显示包装质检记录
	public function disbaozhuang(){
		// 实例化数据库连接类
		$model=D('Fanxiuquality');
		$id=I('get.id');
		//查找该方案下的工序
		$qualitylist=$model->where("fanxiuid=%d and type=2",$id)->order('quality_date desc')->select();
		if(empty($qualitylist)){
			$this->ajaxReturn(array(
			'state'=>'error',
			'info' => ''
			));
		}else{
			//调用工具类
			$fanxiu=new \lib\Fanxiu();
			$qualitylist=$fanxiu->quality($qualitylist);
			$this->ajaxReturn(array(
			'state'=>'ok',
			'info' => '',
			'data'=>$qualitylist
			));
		}
	}
	public function edit(){
		$model=D('Fanxiu');
		$fanxiuqualityModel=D('Fanxiuquality');
		$id=I('post.id');
		$id=substr($id,0,-1);
		$data=array();
		$data['result']=I('post.result');
		$data['describe']=I('post.describe');
		$data['fanxiuid']=$id;
		$data['quality_id']=session('manager_id');
		$data['quality_date']=time();
		$data['type']=1;
		$arr=array();
		if($data['result']==1){
			//合格
			$arr['flag']=5;
		}else{
			//不合格
			$arr['flag']=4;
		}
		$arr['gongneng']=1;
		$flagb=$fanxiuqualityModel->add($data);
		if($flagb!==false){
			$flagb=$model->where('id=%d',$id)->save($arr);
			$this->ajaxReturn(array(
				'state'=>'ok',
				'info' => '添加成功！'
			));
		}else{
			$this->ajaxReturn(array(
				'state'=>'error',
				'info' => '添加失败！'
			));
		}
	}
}
?>