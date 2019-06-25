<?php
namespace Home\Controller;
use Common\Controller\AuthController;
class FanxiuexpressController extends AuthController {
	
    public function index(){
		$model=D('Fanxiu');
		$express=D('Express');
		$map="";
		if(IS_POST){
			$fanxiuexpress_barcode_dir=I('post.fanxiuexpress_barcode_dir');
			//拼接条码
			if(!empty($fanxiuexpress_barcode_dir)){
				
				$customer=$model->where("barcode='%s' and flag not in(10,11)",$fanxiuexpress_barcode_dir)->getField("customer");
				$map="customer like '%".$customer."%' and flag not in(10,11)";
			}
		}else if(IS_GET){
			//拼接查询条件
			$map="flag=9 and result=1";
		}
		if($map!=""){
			$count=$model->where($map)->count();
			//日常工作计划未完成
			$datalist=$model->where($map)->order('fanxiunumber desc')->select();
			$expresslist=$express->field("name,pinyin")->select();
			//调用工具类
			$fanxiu=new \lib\Fanxiu();
			$datalist=$fanxiu->dengji($datalist);
		}
		$this->assign('pagetitle','退回登记');
		$this->assign('datalist',$datalist);
		$this->assign('expresslist',$expresslist);
		$this->assign('count',$count);
		$this->assign('page',$show);
		$this->display();
    }
		
	public function edit(){
		$model=D('Fanxiu');
		$id=I('post.id');
		$id=substr($id,0,-1);
		$data=array();
		$data['flag']=10;
		$data['return_date']=time();
		$data['express']=I('post.express');
		$data['expressid']=I('post.expressid');
		$idlist = explode(",",$id);
		$flagb="";
		foreach($idlist as $value){
			$flagb=$model->where('id = %d',$value)->save($data);
		}
		if($flagb){
			$this->ajaxReturn(array(
				'state'=>'ok',
				'info' => '登记成功！'
			));
		}else{
			$this->ajaxReturn(array(
				'state'=>'error',
				'info' => '登记失败！'
			));
		}
	}
	
}
?>