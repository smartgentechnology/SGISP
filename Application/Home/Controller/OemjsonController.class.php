<?php
namespace Home\Controller;
use Think\Controller;
class OemjsonController extends Controller {
    
	public function dis() {
		$data=array();
		$model=D('Oem');
		$datalist=array();
		$datalist=$model->order("oem_id desc")->select();
		if($datalist){
			$data['state']='access';
			$data['info']='查询成功！';
			$data['data']=$datalist;
		}else{
			$data['state']='error';
			$data['info']='查询失败！';
		}
		header('Content-Type:text/html; charset=utf-8');
        exit(json_encode($data,JSON_UNESCAPED_UNICODE));
		
	}
	public function search() {
		$data=array();
		$keyword=I('get.keyword');
		//OA人员账号
		$model=D('Oem');
		$datalist=array();
		$datalist=$model->where("oem_name like '%".$keyword."%'")->order("oem_id desc")->select();
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
		$model=D('Oem');
		$data['pid']=I('post.pid');
		$data['name']=I('post.name');
		$data['mca']=I('post.mca');
		$data['ico']=I('post.ico');
		$data['color']=I('post.color');
		$data['order_number']=I('post.order_number');
		$flaga=$model->where("mca='%s'",$data['mca'])->find();
		if($flaga){
			$jsondata['state']='error';
			$jsondata['info']='菜单链接已存在！';
		}else{
			$flagb=$model->add($data);
			if($flagb){
				$jsondata['state']='access';
				$jsondata['info']='菜单添加成功！';
			}else{
				$jsondata['state']='error';
				$jsondata['info']='菜单添加失败！';
			}
		}
		header('Content-Type:text/html; charset=utf-8');
        exit(json_encode($jsondata,JSON_UNESCAPED_UNICODE));
		
	}
	public function edit() {
		$data=array();
		$jsondata=array();
		$model=D('Nav');
		$id=I('post.id');
		$data['pid']=I('post.pid');
		$data['name']=I('post.name');
		$data['mca']=I('post.mca');
		$data['ico']=I('post.ico');
		$data['color']=I('post.color');
		$data['order_number']=I('post.order_number');
		$flaga=$model->where("mca='%s' AND id !=%d",$data['mca'],$id)->find();
		if($flaga){
			$jsondata['state']='error';
			$jsondata['info']='菜单链接已存在！';
		}else{
			if($id==$data['pid']){
				$jsondata['state']='error';
				$jsondata['info']='父菜单不能是自己！';
			}else{
				$flagc=$model->where('id=%d',$id)->save($data);
				if($flagc!==false){
					$jsondata['state']='access';
					$jsondata['info']='菜单修改成功！';
				}else{
					$jsondata['state']='error';
					$jsondata['info']='菜单修改失败！';
				}
				
			}
		}
		header('Content-Type:text/html; charset=utf-8');
        exit(json_encode($jsondata,JSON_UNESCAPED_UNICODE));
		
	}
	public function del() {
		$jsondata=array();
		$model=D('Oem');
		$id=I('post.id');
		$flaga=$model->where('oem_id =%d',$id)->find();
		if($flaga){
			unlink('Public/'.$flaga['oem_img']);
			$flagb=$model->where('oem_id =%d',$id)->delete();
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