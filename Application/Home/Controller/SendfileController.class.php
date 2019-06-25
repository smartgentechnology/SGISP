<?php
namespace Home\Controller;
use Common\Controller\AuthController;
class SendfileController extends AuthController {
	
    public function index(){
		$model=D('Sendfile');
		
		if(IS_POST){
			$data=I('post.');
			//得到查询条件
			//单位
			$sendfile_model_dir=$data['sendfile_model_dir'];
			
			//拼接型号
			if(!empty($sendfile_model_dir)){
				$map=$map."model like'%".$sendfile_model_dir."%'";
				session('sendfile_model_dir',$sendfile_model_dir);
			}else{
				session('sendfile_model_dir',null);
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
		//日常工作计划未完成
		$sendfilelist=$model->where($map)->order('id desc')->limit($Page->firstRow.','.$Page->listRows)->select();
		$this->assign('pagetitle','下发文件管理');
		$this->assign('sendfilelist',$sendfilelist);
		$this->assign('page',$show);
		$this->assign('count',$count);
		
		$this->display();
    }
	
	public function add(){
		$model=D('Sendfile');
		if(IS_POST){
			$data=array();
			$data['model']=I('post.sendfile_model_a');
			$data['filepath']=I('post.sendfile_filepath_a');
			
			$flaga=$model->where("model='%s'",$data['model'])->find();
			if($flaga){
				$this->ajaxReturn(array(
					'state'=>'error',
					'info' => '该型号已存在！'
				));
			}else{
				$upload = new \Think\Upload();// 实例化上传类
				$upload->maxSize = 31457280 ;// 设置附件上传大小
				$upload->exts = array('exe', 'rar', 'zip');// 设置附件上传类型
				$upload->rootPath = 'Public/data/sendfile/'; // 设置附件上传根目录
				$upload->saveName = '';
				// 上传文件
				$info = $upload->upload();
				if(!$info) {
					// 上传错误提示错误信息 
					$this->error($upload->getError());
				}else{
					// 上传成功 获取上传文件信息 
					foreach($info as $file){
						$data['filename']=$file['name'];
						$data['filepath']='data/sendfile/'.$file['savepath'].$file['savename']; 
					}
					if (!$model->create($data)){ // 创建数据对象
						// 如果创建失败 表示验证没有通过 输出错误提示信息
						exit($model->getError());
					}else{
						// 验证通过 写入新增数据
						$flagb=$model->add();
						if($flagb){
							session('add_sendfile_model',$data['model']);
							$this->success('下发文件添加成功！',U('Sendfile/index'));
						}else{
							$this->error('下发文件添加失败！');
						}
					}
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
		$model=D('Sendfile');
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
			$id=I('post.sendfile_id_e');
			$data=array();
			$data['model']=I('post.sendfile_model_e');
			
			$flaga=$model->where("model='%s' and id!=%d",$data['model'],$id)->find();
			if($flaga){
				$this->ajaxReturn(array(
					'state'=>'error',
					'info' => '该型号已存在！'
				));
			}else{
				if($_FILES['sendfile_filepath_e']['error']!=4){
					$upload = new \Think\Upload();// 实例化上传类
					$upload->maxSize = 31457280 ;// 设置附件上传大小
					$upload->exts = array('exe', 'rar', 'zip');// 设置附件上传类型
					$upload->rootPath = 'Public/data/sendfile/'; // 设置附件上传根目录
					$upload->saveName = '';
					// 上传文件
					$info = $upload->upload();
					if(!$info) {
						// 上传错误提示错误信息 
						$this->error($upload->getError());
					}else{
						// 上传成功 获取上传文件信息 
						foreach($info as $file){
							$data['filename']=$file['name'];
							$data['filepath']='data/sendfile/'.$file['savepath'].$file['savename']; 
						}
						$rs=$model->where('id=%d',$id)->find();
						unlink('Public/'.$rs['filepath']);
					}
				}
				if (!$model->create($data)){ // 创建数据对象
					// 如果创建失败 表示验证没有通过 输出错误提示信息
					exit($model->getError());
				}else{
					$flagb=$model->where('id=%d',$id)->save();
					if($flagb!==false){
						$this->success('下发文件修改成功！',U('Sendfile/index'));
					}else{
						$this->error('下发文件修改失败！');
					}
				}
				
			}
			
		}
	}
	
	public function del($id=''){
		$model=D('Sendfile');
		if(empty($id)){
			$this->ajaxReturn(array(
				'state'=>'error',
				'info' => '请至少选择一条记录！'
				));
		}else{
			$id=substr($id,0,-1);
			$sendfilelist=$model->where('id in (%s)',$id)->select();
			$flagb=$model->where('id in (%s)',$id)->delete();
			if($flagb){
				foreach($sendfilelist as $v){
					unlink('Public/'.$v['filepath']);
				}
				$idlist=explode(',',$id);
				$this->ajaxReturn(array(
					'state'=>'ok',
					'info' => '下发文件删除成功！',
					'data'=>$idlist
				));
			}else{
				$this->ajaxReturn(array(
					'state'=>'error',
					'info' => '下发文件删除失败！'
				));
			}
			
		}
	}
	
}
?>