<?php
namespace Home\Controller;
use Common\Controller\AuthController;
class SuggestjsonController {
	
	public function dis(){
		$model=D('Suggest');
		$addid=I('post.uid');
		$datalist=$model->where("addid='%s'",$addid)->field("id,type,content,addtime,state")->order("addtime desc")->select();
		if($datalist){
			foreach($datalist as $key=>$value){
				switch($value['type']){
					case 0:
						$datalist[$key]['type']='意见或建议';
						break;
					case 1:
						$datalist[$key]['type']='安全隐患';
						break;
				}
				switch($value['state']){
					case 0:
						$datalist[$key]['state']='未处理';
						break;
					case 1:
						$datalist[$key]['state']='已转处理部门';
						break;
					case 2:
						$datalist[$key]['state']='已采纳';
						break;
					case 3:
						$datalist[$key]['state']='未采纳';
						break;
					case 4:
						$datalist[$key]['state']='处理中';
						break;
					case 5:
						$datalist[$key]['state']='已完成';
						break;
				}
				$datalist[$key]['addtime']=date("Y-m-d",$value['addtime']);
			}
			$data['state']='access';
			$data['info']='查询成功！';
			$data['data']=$datalist;
		}else{
			$data['state']='error';
			$data['info']='查询错误！';
		}
		header('Content-Type:text/html; charset=utf-8');
        exit(json_encode($data,JSON_UNESCAPED_UNICODE));
	}
	
	public function search() {
		$model=D('Suggest');
		$keyword=I('get.keyword');
		$datalist=array();
		$datalist=$model->where("content like '%".$keyword."%'")->field("id,type,content,addtime,state")->order("addtime desc")->select();
		if($datalist){
			foreach($datalist as $key=>$value){
				switch($value['type']){
					case 0:
						$datalist[$key]['type']='意见或建议';
						break;
					case 1:
						$datalist[$key]['type']='安全隐患';
						break;
				}
				switch($value['state']){
					case 0:
						$datalist[$key]['state']='未处理';
						break;
					case 1:
						$datalist[$key]['state']='已转处理部门';
						break;
					case 2:
						$datalist[$key]['state']='已采纳';
						break;
					case 3:
						$datalist[$key]['state']='未采纳';
						break;
					case 4:
						$datalist[$key]['state']='处理中';
						break;
					case 5:
						$datalist[$key]['state']='已完成';
						break;
				}
				$datalist[$key]['addtime']=date("Y-m-d",$value['addtime']);
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
	
	public function info(){
		$model=D('Suggest');
		$id=I('post.id');
		$datalist=$model->where("id=%d",$id)->find();
		if($datalist){
			switch($datalist['type']){
				case 0:
					$datalist['type']='意见或建议';
					break;
				case 1:
					$datalist['type']='安全隐患';
					break;
			}
			switch($datalist['state']){
				case 0:
					$datalist['state']='未处理';
					break;
				case 1:
					$datalist['state']='已转处理部门';
					break;
				case 2:
					$datalist['state']='已采纳';
					break;
				case 3:
					$datalist['state']='未采纳';
					break;
				case 4:
					$datalist['state']='处理中';
					break;
				case 5:
					$datalist['state']='已完成';
					break;
			}
			$httpstr="http://192.168.30.89/OR/Public/";
			if(!empty($datalist['img'])){
				$datalist['img']=$httpstr.$datalist['img'];
			}
			$datalist['addtime']=date("Y-m-d",$datalist['addtime']);
			$data['state']='access';
			$data['info']='查询成功！';
			$data['data']=$datalist;
		}else{
			$data['state']='error';
			$data['info']='查询错误！';
		}
		header('Content-Type:text/html; charset=utf-8');
        exit(json_encode($data,JSON_UNESCAPED_UNICODE));
	}
	public function add(){
		$model=D('Suggest');
		$datalist=array();
		$datalist['type']=I('post.type');
		$datalist['content']=I('post.content');
		$datalist['img']=I('post.img');
		$datalist['addid']=I('post.uid');
		$datalist['addtime']=time();
		//目录
		$rootPath = './Public/data/suggest/';
		$path = 'data/suggest/';
		//前面
		$name=time();
		if(!empty($datalist['img'])){
			$datalist['img']=base64_decode($datalist['img']);
			file_put_contents($rootPath.$name.'.jpg',$datalist['img']);
			$datalist['img']=$path.$name.'.jpg';
		}
		//修改
		$flagb=$model->add($datalist);
		if($flagb){
			$data['state']='access';
			$data['info']='感谢您提的建议，我们会在第一时间处理！';
		}else{
			$data['state']='error';
			$data['info']='添加信息失败！';
		}
		header('Content-Type:text/html; charset=utf-8');
        exit(json_encode($data,JSON_UNESCAPED_UNICODE));
	}
	public function typelist(){
		$datalist=array(0=>"意见或建议",1=>"安全隐患");
		$data['state']='access';
		$data['info']='成功！';
		$data['data']=$datalist;
		header('Content-Type:text/html; charset=utf-8');
        exit(json_encode($data,JSON_UNESCAPED_UNICODE));
	}
}
?>
