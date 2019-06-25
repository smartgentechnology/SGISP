<?php
namespace Home\Controller;
use Common\Controller\AuthController;
class TlibraryController extends AuthController {
	
    public function index(){
		$model=D('Tlibrary');
		if(IS_POST){
			$data=I('post.');
			//得到查询条件
			//搜索词
			$tlibrary_content_dir=$data['tlibrary_content_dir'];

			//拼接培训内容
			if(!empty($tlibrary_content_dir)){
				$map=$map." and cn like'%".$tlibrary_content_dir."%' or en like '%".$tlibrary_content_dir."%' or abben like '%".$tlibrary_content_dir."%'";
				session('tlibrary_content_dir',$tlibrary_content_dir);
			}else{
				session('tlibrary_content_dir',null);
			}
			
			session('map',$map);
			session('flag',0);
		}else if(IS_GET){
			if(!empty($_GET)){
				$state=I('get.state');
				session('state',$state);
			}else{
				session('state',0);
				session('map',null);
			}
			
		}
		$flag=session('state');
		$map=session('map');
		$flag="flag =".$flag;
		$count=$model->where($flag.$map)->count();
		$Page=new \Org\Nx\Page($count,10);
		$show=$Page->show();
		//生成数据列表
		$datalist=$model->where($flag.$map)->order('mdate desc')->limit($Page->firstRow.','.$Page->listRows)->relation(true)->select();
		$flag=array(array('id'=>0,'value'=>'办公'),array('id'=>1,'value'=>'研发'));
		//调用工具类
		$utils=new \lib\Tlibrary();
		$datalist=$utils->changeFiled($datalist);
		$this->assign('pagetitle','翻译库');
		$this->assign('datalist',$datalist);
		$this->assign('flag',$flag);
		$this->assign('page',$show);
		$this->display();
    }
	
	public function add(){
		$model=D('Tlibrary');
		if(IS_POST){
			$data=array();
			$data=I('post.');
			$data['manager_id']=session('manager_id');
			$flaga=$model->where("cn='%s' or en='%s'",$data['cn'],$data['en'])->find();
			if($flaga){
				$this->ajaxReturn(array(
					'state'=>'error',
					'info' => '该翻译已存在！'
				));
			}else{
				if (!$model->create($data)){ // 创建数据对象
					// 如果创建失败 表示验证没有通过 输出错误提示信息
					exit($model->getError());
				}else{
					// 验证通过 写入新增数据
					$flagb=$model->add();
					if($flagb){
						session('add_tlibrary_flag',$data['flag']);
						session('add_tlibrary_cn',$data['cn']);
						session('add_tlibrary_en',$data['en']);
						session('add_tlibrary_abben',$data['abben']);
						session('add_tlibrary_sp',$data['sp']);
						session('add_tlibrary_jp',$data['jp']);
						session('add_tlibrary_ru',$data['ru']);
						session('add_tlibrary_remarks',$data['remarks']);
						$this->ajaxReturn(array(
							'state'=>'ok',
							'info' => '翻译添加成功！'
						));
					}else{
						$this->ajaxReturn(array(
							'state'=>'error',
							'info' => '翻译添加失败！'
						));
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
		$model=D('Tlibrary');
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
			$data['flag']=I('post.flag');
			$data['cn']=I('post.cn');
			$data['en']=I('post.en');
			$data['abben']=I('post.abben');
			$data['sp']=I('post.sp');
			$data['jp']=I('post.jp');
			$data['ru']=I('post.ru');
			$data['remarks']=I('post.remarks');
			$data['manager_id']=session('manager_id');
			$flaga=$model->where("(cn='%s' or en='%s') and id!=%d",$data['cn'],$data['en'],$id)->find();
			if($flaga){
				$this->ajaxReturn(array(
					'state'=>'error',
					'info' => '该翻译已存在！'
				));
			}else{
				if (!$model->create($data)){ // 创建数据对象
					// 如果创建失败 表示验证没有通过 输出错误提示信息
					exit($model->getError());
				}else{
					$flagb=$model->where('id=%d',$id)->save();
					if($flagb!==false){
						$this->ajaxReturn(array(
							'state'=>'ok',
							'info' => '翻译修改成功！'
						));
					}else{
						$this->ajaxReturn(array(
							'state'=>'error',
							'info' => '翻译修改失败！'
						));
					}
				}
				
			}
			
		}
	}
	
	public function del($id=''){
		$model=D('Tlibrary');
		if(empty($id)){
			$this->ajaxReturn(array(
				'state'=>'error',
				'info' => '请至少选择一条记录！'
				));
		}else{
			$id=substr($id,0,-1);
			$flagb=$model->where('id in (%s)',$id)->delete();
			if($flagb){
				$idlist=explode(',',$id);
				$this->ajaxReturn(array(
					'state'=>'ok',
					'info' => '翻译删除成功！',
					'data'=>$idlist
				));
			}else{
				$this->ajaxReturn(array(
					'state'=>'error',
					'info' => '翻译删除失败！'
				));
			}
			
		}
	}
	
}
?>