<?php
namespace Home\Controller;
use Common\Controller\AuthController;
class SuggestuntreatedjsonController {
	
	public function dis(){
		$model=D('Suggest');
		$datalist=$model->where("state=0")->field("id,type,content,addtime,state,img")->order("addtime desc")->select();
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
						$datalist[$key]['state']='已采纳';
						break;
					case 2:
						$datalist[$key]['state']='未采纳';
						break;
					case 3:
						$datalist[$key]['state']='处理中';
						break;
					case 4:
						$datalist[$key]['state']='已完成';
						break;
				}
				$httpstr="http://192.168.30.89/OR/Public/";
				if(!empty($value['img'])){
					$datalist[$key]['img']=$httpstr.$value['img'];
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
		$datalist=$model->where("content like '%".$keyword."%'")->field("id,type,content,addtime,state,img")->order("addtime desc")->select();
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
	
	public function edit(){
		$model=D('Suggest');
		$datalist=array();
		$id=I('post.id');
		$datalist['dept_id']=I('post.deptid');
		$datalist['transfer']=I('post.uid');
		$datalist['transfertime']=time();
		$datalist['state']=1;
		//修改
		$flagb=$model->where("id=%d",$id)->save($datalist);
		if($flagb){
			$data['state']='access';
			$data['info']='提交成功！';
		}else{
			$data['state']='error';
			$data['info']='提交失败！';
		}
		header('Content-Type:text/html; charset=utf-8');
        exit(json_encode($data,JSON_UNESCAPED_UNICODE));
	}
}
?>
