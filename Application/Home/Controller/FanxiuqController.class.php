<?php
namespace Home\Controller;
use Common\Controller\AuthController;
class FanxiuqController extends AuthController {
	
    public function index(){
		$this->assign('pagetitle','修前表单');
		$this->display();
    }
	
	public function edit(){
		$model=D('Fanxiu');
		if(IS_GET){
			$barcode=I('get.barcode');
			$result=$model->where("barcode='%s' and flag in(1,2)",$barcode)->find();
			//调用工具类
			$fanxiu=new \lib\Fanxiu();
			$result=$fanxiu->xiuqian($result);
			if(empty($result)){
				$this->ajaxReturn(array(
				'state'=>'error',
				'info' => '没找到登记信息！'
				));
			}else{
				$this->ajaxReturn(array(
				'state'=>'ok',
				'info' => '',
				'data'=>$result
				));
			}
			
		}else{
			$id=I('post.id');
			$data=array();
			$data['hv']=I('post.hv');
			$data['sv']=I('post.sv');
			$data['fault']=I('post.fault');
			$qianimg=$model->where('id=%d',$id)->field("qz,qb")->find();
			//目录
			$rootPath = './Public/data/fanxiu/';
			$path = 'data/fanxiu/';
			//前面
			$qzfile=time();
			$qz=I('post.qz');
			if(!empty($qz)){
				$qz=str_replace('data:image/jpeg;base64,','',$qz);
				$qz=base64_decode($qz);
				file_put_contents($rootPath.$qzfile.'.jpg',$qz);
				$data['qz']=$path.$qzfile.'.jpg';
				if(!empty($qianimg['qz'])){
					unlink('Public/'.$qianimg['qz']);
				}
				
			}
			
			//背面
			$qbfile=time()+1;
			$qb=I('post.qb');
			if(!empty($qb)){
				$qb=str_replace('data:image/jpeg;base64,','',$qb);
				$qb=base64_decode($qb);
				file_put_contents($rootPath.$qbfile.'.jpg',$qb);
				$data['qb']=$path.$qbfile.'.jpg';
				if(!empty($qianimg['qb'])){
					unlink('Public/'.$qianimg['qb']);
				}
				
			}
			
			$data['flag']=2;
			//修改
			$flagb=$model->where('id=%d',$id)->save($data);
			if($flagb!==false){
				$this->ajaxReturn(array(
					'state'=>'ok',
					'info' => '修前表单提交成功！'
				));
			}else{
				$this->ajaxReturn(array(
					'state'=>'error',
					'info' => '修前表单提交失败！'
				));
			}
			
		}
	}
}
?>