<?php
namespace Home\Controller;
use Common\Controller\AuthController;
class FanxiuhController extends AuthController {
	
    public function index(){
		$this->assign('pagetitle','维修表单');
		$this->display();
    }
	
	public function edit(){
		$model=D('Fanxiu');
		if(IS_GET){
			$barcode=I('get.barcode');
			$result=$model->where("barcode='%s' and flag in(1,2,3)",$barcode)->find();
			
			if(empty($result)){
				$this->ajaxReturn(array(
				'state'=>'error',
				'info' => '没找到维修信息！'
				));
			}else{
				$customer=$result["customer"];
				$datalist=$model->where("customer like'%".$customer."%' and flag not in(10,11)")->field("receive_date,product,barcode,flag")->select();
				//调用工具类
				$fanxiu=new \lib\Fanxiu();
				$result=$fanxiu->xiuqian($result);
				$datalist=$fanxiu->dengji($datalist);
				$this->ajaxReturn(array(
				'state'=>'ok',
				'info' => '',
				'data'=>$result,
				'list'=>$datalist
				));
			}
			
		}else{
			$id=I('post.id');
			$data=array();
			$data['hv']=I('post.hv');
			$data['sv']=I('post.sv');
			$data['fault']=I('post.fault');
			$data['maint']=I('post.maint');
			$data['hsv']=I('post.hsv');
			$data['maint_id']=session('manager_id');
			$data['maint_date']=time();
			
			$houimg=$model->where('id=%d',$id)->field("qz,qb,hz,hb")->find();
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
				if(!empty($houimg['qz'])){
					unlink('Public/'.$houimg['qz']);
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
				if(!empty($houimg['qb'])){
					unlink('Public/'.$houimg['qb']);
				}
				
			}
			//前面
			$hzfile=time()+2;
			$hz=I('post.hz');
			if(!empty($hz)){
				$hz=str_replace('data:image/jpeg;base64,','',$hz);
				$hz=base64_decode($hz);
				file_put_contents($rootPath.$hzfile.'.jpg',$hz);
				$data['hz']=$path.$hzfile.'.jpg';
				if(!empty($houimg['hz'])){
					unlink('Public/'.$houimg['hz']);
				}
				
			}
			
			//背面
			$hbfile=time()+3;
			$hb=I('post.hb');
			if(!empty($hb)){
				$hb=str_replace('data:image/jpeg;base64,','',$hb);
				$hb=base64_decode($hb);
				file_put_contents($rootPath.$hbfile.'.jpg',$hb);
				$data['hb']=$path.$hbfile.'.jpg';
				if(!empty($houimg['hb'])){
					unlink('Public/'.$houimg['hb']);
				}
				
			}
			
			$data['flag']=3;
			//修改
			$flagb=$model->where('id=%d',$id)->save($data);
			if($flagb!==false){
				$this->ajaxReturn(array(
					'state'=>'ok',
					'info' => '修后表单提交成功！'
				));
			}else{
				$this->ajaxReturn(array(
					'state'=>'error',
					'info' => '修后表单提交失败！'
				));
			}
			
		}
	}
	public function temp(){
		$model=D('Fanxiu');
		if(IS_GET){
			$barcode=I('get.barcode');
			$result=$model->where("barcode='%s' and flag in(1,2,3)",$barcode)->find();
			//调用工具类
			$fanxiu=new \lib\Fanxiu();
			$result=$fanxiu->xiuqian($result);
			if(empty($result)){
				$this->ajaxReturn(array(
				'state'=>'error',
				'info' => '没找到维修信息！'
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
			$data['maint']=I('post.maint');
			$data['hsv']=I('post.hsv');
			$data['maint_id']=session('manager_id');
			$data['maint_date']=time();
			
			$houimg=$model->where('id=%d',$id)->field("qz,qb,hz,hb")->find();
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
				if(!empty($houimg['qz'])){
					unlink('Public/'.$houimg['qz']);
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
				if(!empty($houimg['qb'])){
					unlink('Public/'.$houimg['qb']);
				}
				
			}
			//前面
			$hzfile=time()+2;
			$hz=I('post.hz');
			if(!empty($hz)){
				$hz=str_replace('data:image/jpeg;base64,','',$hz);
				$hz=base64_decode($hz);
				file_put_contents($rootPath.$hzfile.'.jpg',$hz);
				$data['hz']=$path.$hzfile.'.jpg';
				if(!empty($houimg['hz'])){
					unlink('Public/'.$houimg['hz']);
				}
				
			}
			
			//背面
			$hbfile=time()+3;
			$hb=I('post.hb');
			if(!empty($hb)){
				$hb=str_replace('data:image/jpeg;base64,','',$hb);
				$hb=base64_decode($hb);
				file_put_contents($rootPath.$hbfile.'.jpg',$hb);
				$data['hb']=$path.$hbfile.'.jpg';
				if(!empty($houimg['hb'])){
					unlink('Public/'.$houimg['hb']);
				}
				
			}
			
			$data['flag']=2;
			//修改
			$flagb=$model->where('id=%d',$id)->save($data);
			if($flagb!==false){
				$this->ajaxReturn(array(
					'state'=>'ok',
					'info' => '维修暂存成功！'
				));
			}else{
				$this->ajaxReturn(array(
					'state'=>'error',
					'info' => '维修暂存失败！'
				));
			}
			
		}
	}
}
?>