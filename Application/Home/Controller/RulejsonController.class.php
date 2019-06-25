<?php
namespace Home\Controller;
use Think\Controller;
class RulejsonController extends Controller {
    
	public function dis() {
		$data=array();
		$model=D('AuthRule');
		$datalist=array();
		$temp=$model->getOrderTreeData('tree','id','title');
		if($temp){
			foreach($temp as $value){
				$a=array();
				$a['id']=$value['id'];
				$a['pid']=$value['pid'];
				$a['name']=$value['name'];
				$a['title']=$value['title'];
				$a['level']=$value['_level'];
				$a['bname']=$value['_name'];
				$datalist[]=$a;
			}
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
		$model=D('AuthRule');
		$datalist=array();
		$datalist=$model->where("name like '%".$keyword."%' or title like '%".$keyword."%'")->select();
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
		$model=D('AuthRule');
		$data['pid']=I('post.pid');
		$data['name']=I('post.name');
		$data['title']=I('post.title');
		$flaga=$model->where("name='%s'",$data['name'])->find();
		if($flaga){
			$jsondata['state']='error';
			$jsondata['info']='权限已存在！';
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
		$model=D('AuthRule');
		$id=I('post.id');
		$data['pid']=I('post.pid');
		$data['name']=I('post.name');
		$data['title']=I('post.title');
		$flaga=$model->where("name='%s' AND id !=%d",$data['name'],$id)->find();
		if($flaga){
			$jsondata['state']='error';
			$jsondata['info']='权限已存在！';
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
		$model=D('AuthRule');
		$id=I('post.id');
		$flaga=$model->where('pid =%d',$id)->find();
		if($flaga){
			$jsondata['state']='error';
			$jsondata['info']='该权限有下属权限，请先删除下属权限！';
		}else{
			$flagb=$model->where('id =%d',$id)->delete();
			if($flagb){
				$jsondata['state']='access';
				$jsondata['info']='删除成功！';
			}else{
				$jsondata['state']='error';
				$jsondata['info']='删除失败！';
			}
		}
		header('Content-Type:text/html; charset=utf-8');
        exit(json_encode($jsondata,JSON_UNESCAPED_UNICODE));
		
	}
}
?>