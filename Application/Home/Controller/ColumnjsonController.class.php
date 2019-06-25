<?php
namespace Home\Controller;
use Think\Controller;
class ColumnjsonController extends Controller {
    
	public function dis() {
		$data=array();
		$model=D('Column');
		$datalist=array();
		$datalist=$model->order("rank asc,id asc")->select();
		if($datalist){
			$data['state']='access';
			$data['info']='查询成功！';
			$data['data']=$datalist;
		}else{
			$data['state']='error';
			$data['info']='未查找到相关记录！';
		}
		header('Content-Type:text/html; charset=utf-8');
        exit(json_encode($data,JSON_UNESCAPED_UNICODE));
		
	}
	public function search() {
		$data=array();
		$keyword=I('get.keyword');
		$model=D('Column');
		$datalist=array();
		$datalist=$model->where("name like '%".$keyword."%' or module like '%".$keyword."%'")->select();
		if($datalist){
			$data['state']='access';
			$data['info']='查询成功！';
			$data['data']=$datalist;
		}else{
			$data['state']='error';
			$data['info']='未查找到相关记录！';
		}
		header('Content-Type:text/html; charset=utf-8');
        exit(json_encode($data,JSON_UNESCAPED_UNICODE));
		
	}
	
	public function add() {
		$data=array();
		$jsondata=array();
		$model=D('Column');
		$data['name']=I('post.name');
		$data['module']=I('post.module');
		$data['field']=I('post.field');
		$data['width']=I('post.width');
		$data['rank']=I('post.rank');
		$flaga=$model->where("module='%s' and field='%s'",$data['module'],$data['field'])->find();
		if($flaga){
			$jsondata['state']='error';
			$jsondata['info']='栏目已存在！';
		}else{
			$flagb=$model->add($data);
			if($flagb){
				$jsondata['state']='access';
				$jsondata['info']='添加成功！';
			}else{
				$jsondata['state']='error';
				$jsondata['info']='添加失败！';
			}
		}
		header('Content-Type:text/html; charset=utf-8');
        exit(json_encode($jsondata,JSON_UNESCAPED_UNICODE));
		
	}
	public function edit() {
		$data=array();
		$jsondata=array();
		$model=D('Column');
		$id=I('post.id');
		$data['name']=I('post.name');
		$data['module']=I('post.module');
		$data['field']=I('post.field');
		$data['width']=I('post.width');
		$data['rank']=I('post.rank');
		$flaga=$model->where("module='%s' and field='%s' AND id !=%d",$data['module'],$data['field'],$id)->find();
		if($flaga){
			$jsondata['state']='error';
			$jsondata['info']='栏目已存在！';
		}else{
			$flagc=$model->where('id=%d',$id)->save($data);
			if($flagc!==false){
				$jsondata['state']='access';
				$jsondata['info']='修改成功！';
			}else{
				$jsondata['state']='error';
				$jsondata['info']='修改失败！';
			}
		}
		header('Content-Type:text/html; charset=utf-8');
        exit(json_encode($jsondata,JSON_UNESCAPED_UNICODE));
		
	}
	public function del() {
		$jsondata=array();
		$model=D('Column');
		$id=I('post.id');
		$flagb=$model->where('id =%d',$id)->delete();
		if($flagb){
			$jsondata['state']='access';
			$jsondata['info']='删除成功！';
		}else{
			$jsondata['state']='error';
			$jsondata['info']='删除失败！';
		}
		header('Content-Type:text/html; charset=utf-8');
        exit(json_encode($jsondata,JSON_UNESCAPED_UNICODE));
		
	}
}
?>