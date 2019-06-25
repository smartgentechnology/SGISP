<?php
namespace Home\Controller;
use Common\Controller\AuthController;
class OemController extends AuthController {
    public function index(){
		$model=D('Oem');
		
		if(IS_POST){
			$data=I('post.');
			//得到查询条件
			//单位
			$oem_name_dir=$data['oem_name_dir'];
			//代理产品
			$oem_products_dir=$data['oem_products_dir'];
			//代理区域
			$oem_area_dir=$data['oem_area_dir'];
			//计划日期
			$oem_startdate_dir_start=$data['oem_startdate_dir_start'];
			$oem_startdate_dir_end=$data['oem_startdate_dir_end'];
			//完成日期
			$oem_enddate_dir_start=$data['oem_enddate_dir_start'];
			$oem_enddate_dir_end=$data['oem_enddate_dir_end'];

			$map='1=1';
			//拼接单位
			if(!empty($oem_name_dir)){
				$map=$map." and oem_name like'%".$oem_name_dir."%'";
				session('oem_name_dir',$oem_name_dir);
			}else{
				session('oem_name_dir',null);
			}
			//拼接产品
			if(!empty($oem_products_dir)){
				$map=$map." and oem_products like'%".$oem_products_dir."%'";
				session('oem_products_dir',$oem_products_dir);
			}else{
				session('oem_products_dir',null);
			}
			//拼接区域
			if(!empty($oem_area_dir)){
				$map=$map." and oem_area like'%".$oem_area_dir."%'";
				session('oem_area_dir',$oem_area_dir);
			}else{
				session('oem_area_dir',null);
			}
			//拼接计划日期
			if(!empty($oem_startdate_dir_start) && !empty($oem_startdate_dir_end)){
				$map=$map." and startdate>=".strtotime($oem_startdate_dir_start)." and startdate<=".strtotime($oem_startdate_dir_end);
			}else if(!empty($oem_startdate_dir_start) && empty($oem_startdate_dir_end)){
				$map=$map." and startdate>=".strtotime($oem_startdate_dir_start);
			}else if(empty($oem_startdate_dir_start) && !empty($oem_startdate_dir_end)){
				$map=$map." and startdate<=".strtotime($oem_startdate_dir_end);
			}
			//拼接完成日期
			if(!empty($oem_enddate_dir_start) && !empty($oem_enddate_dir_end)){
				$map=$map." and enddate>=".strtotime($oem_enddate_dir_start)." and enddate<=".strtotime($oem_enddate_dir_end);
			}else if(!empty($oem_enddate_dir_start) && empty($oem_enddate_dir_end)){
				$map=$map." and enddate>=".strtotime($oem_enddate_dir_start);
			}else if(empty($oem_enddate_dir_start) && !empty($oem_enddate_dir_end)){
				$map=$map." and enddate<=".strtotime($oem_enddate_dir_end);
			}
			
			session('map',$map);
		}else if(IS_GET){
			if(empty($_GET)){
				session('map',null);
			}
			
		}
		$map=session('map');
		$count=$model->where($map)->count();
		$Page=new \Org\Nx\Page($count,10);
		$show=$Page->show();
		//生成数据列表
		$datalist=$model->where($map)->order('oem_id desc')->limit($Page->firstRow.','.$Page->listRows)->select();
		//print_r($deptlist);
		$this->assign('pagetitle','OEM证书管理');
		$this->assign('datalist',$datalist);
		$this->assign('page',$show);
		$this->assign('count',$count);
		$this->display();
    }
	public function add(){
		$model=D('Oem');
		if(IS_POST){
			$data=array();
			$data['oem_name']=I('post.oem_name_a');
			$data['oem_products']=I('post.oem_products_a');
			$data['oem_area']=I('post.oem_area_a');
			$data['startdate']=I('post.startdate_a');
			$data['enddate']=I('post.enddate_a');
			$upload = new \Think\Upload();// 实例化上传类
			$upload->maxSize = 10485760 ;// 设置附件上传大小
			$upload->exts = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
			$upload->rootPath = 'Public/data/OEM/'; // 设置附件上传根目录
			// 上传文件
			$info = $upload->upload();
			if(!$info) {
				// 上传错误提示错误信息 
				$this->error($upload->getError());
			}else{
				// 上传成功 获取上传文件信息 
				foreach($info as $file){ 
					$data['oem_img']='data/OEM/'.$file['savepath'].$file['savename']; 
				}
				//将日期转换成时间戳
				$data['startdate']=strtotime($data['startdate']);
				$data['enddate']=strtotime($data['enddate'])+1*60*60*24;
				$flagb=$model->add($data);
				if($flagb){
					session('add_oem_name',$data['oem_name']);
					session('add_oem_products',$data['oem_products']);
					session('add_oem_area',$data['oem_area']);
					$this->success('代理商证书添加成功！',U('Oem/index'));
				}else{
					$this->error('代理商证书添加失败！');
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
		$model=D('Oem');
		if(IS_GET){
			$id=I('get.id');
			if(empty($id)){
				$this->ajaxReturn(array(
					'state'=>'error',
					'info' => '请至少选择一条记录！'
					));
			}else{
				$id=substr($id,0,-1);
				$result=$model->where('oem_id=%d',$id)->find();
				$result['startdate']=date('Y-m-d',$result['startdate']);
				$result['enddate']=date('Y-m-d',$result['enddate']-1*60*60*24);
				$this->ajaxReturn(array(
					'state'=>'ok',
					'info' => '',
					'data'=>$result
					));
			}
		}else{
			$id=I('post.oem_id_e');
			$data=array();
			$data['oem_name']=I('post.oem_name_e');
			$data['oem_products']=I('post.oem_products_e');
			$data['oem_area']=I('post.oem_area_e');
			$data['startdate']=I('post.startdate_e');
			$data['enddate']=I('post.enddate_e');
			$data['oem_img']=I('post.oem_img_e');
			if($_FILES['oem_img']['error']!=4){
				$upload = new \Think\Upload();// 实例化上传类
				$upload->maxSize = 10485760 ;// 设置附件上传大小
				$upload->exts = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
				$upload->rootPath = 'Public/data/OEM/'; // 设置附件上传根目录
				// 上传文件
				$info = $upload->upload();
				if(!$info) {
					// 上传错误提示错误信息 
					$this->error($upload->getError());
				}else{
					// 上传成功 获取上传文件信息 
					foreach($info as $file){ 
						$data['oem_img']='data/OEM/'.$file['savepath'].$file['savename']; 
					}
					$rs=$model->where('oem_id=%d',$id)->find();
					unlink('Public/'.$rs['oem_img']);
				}
			}
			//将日期转换成时间戳
			$data['startdate']=strtotime($data['startdate']);
			$data['enddate']=strtotime($data['enddate'])+1*60*60*24;
			
			$flagc=$model->where('oem_id=%d',$id)->save($data);
			if($flagc!==false){
				
				$this->success('代理商证书修改成功！',U('Oem/index'));
			}else{
				$this->error('代理商证书修改失败！');
			}
		}
	}
	
	public function del($id=''){
		$model=D('Oem');
		if(empty($id)){
			$this->ajaxReturn(array(
				'state'=>'error',
				'info' => '请至少选择一条记录！'
				));
		}else{
			$id=substr($id,0,-1);
			$rs=$model->where('oem_id in (%s)',$id)->select();
			
			$flagb=$model->where('oem_id in (%s)',$id)->delete();
			if($flagb){
				foreach($rs as $v){
					unlink('Public/'.$v['oem_img']);
				}
				$this->ajaxReturn(array(
					'state'=>'ok',
					'info' => '代理商证书删除成功！'
				));
			}else{
				$this->ajaxReturn(array(
					'state'=>'error',
					'info' => '代理商证书删除失败！'
				));
			}
			
		}
	}
	
}
?>