<?php
namespace Home\Controller;
use Think\Controller;
class GroupjsonController extends Controller {
    
	public function dis() {
		$data=array();
		$model=D('AuthGroup');
		$datalist=array();
		$datalist=$model->order("id")->field("id,title")->select();
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
		$model=D('AuthGroup');
		$datalist=array();
		$datalist=$model->where("title like '%".$keyword."%'")->select();
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
		$model=D('AuthGroup');
		$data['title']=I('post.title');
		$data['status']=1;
		$flaga=$model->where("title='%s'",$data['title'])->find();
		if($flaga){
			$jsondata['state']='error';
			$jsondata['info']='用户组已存在！';
		}else{
			$flagb=$model->add($data);
			if($flagb){
				$jsondata['state']='access';
				$jsondata['info']='用户组添加成功！';
			}else{
				$jsondata['state']='error';
				$jsondata['info']='用户组添加失败！';
			}
		}
		header('Content-Type:text/html; charset=utf-8');
        exit(json_encode($jsondata,JSON_UNESCAPED_UNICODE));
		
	}
	public function edit() {
		$data=array();
		$jsondata=array();
		$model=D('AuthGroup');
		$id=I('post.id');
		$data['title']=I('post.title');
		$flaga=$model->where("title='%s' AND id !=%d",$data['title'],$id)->find();
		if($flaga){
			$jsondata['state']='error';
			$jsondata['info']='用户组已存在！';
		}else{
			$flagc=$model->where('id=%d',$id)->save($data);
			if($flagc!==false){
				$jsondata['state']='access';
				$jsondata['info']='用户组修改成功！';
			}else{
				$jsondata['state']='error';
				$jsondata['info']='用户组修改失败！';
			}
		}
		header('Content-Type:text/html; charset=utf-8');
        exit(json_encode($jsondata,JSON_UNESCAPED_UNICODE));
		
	}
	public function del() {
		$jsondata=array();
		$model=D('AuthGroup');
		$access=D('AuthGroupAccess');
		$id=I('post.id');
		$flaga=$access->where('group_id =%d',$id)->find();
		if($flaga){
			$jsondata['state']='error';
			$jsondata['info']='该用户组已分配有用户，请先删除下属用户！';
		}else{
			$flagb=$model->where('id =%d',$id)->delete();
			if($flagb){
				$jsondata['state']='access';
				$jsondata['info']='用户组删除成功！';
			}else{
				$jsondata['state']='error';
				$jsondata['info']='用户组删除失败！';
			}
		}
		header('Content-Type:text/html; charset=utf-8');
        exit(json_encode($jsondata,JSON_UNESCAPED_UNICODE));
		
	}
	public function rule(){
		$jsondata=array();
		$model=D('AuthGroup');
		if(IS_POST){
			$id=I('post.id');
			$data['rules']=I('post.rules');
			$flagb=$model->where('id=%d',$id)->save($data);
			if($flagb!==false){
				$jsondata['state']='access';
				$jsondata['info']='修改成功！';
			}else{
				$jsondata['state']='error';
				$jsondata['info']='修改失败！';
			}
		}else{
			$id=I('get.id');
			$flagb=$model->where('id=%d',$id)->getField("rules");
			$jsondata['state']='access';
			$jsondata['info']='查询成功！';
			$jsondata['data']=$flagb;
		}
		header('Content-Type:text/html; charset=utf-8');
        exit(json_encode($jsondata,JSON_UNESCAPED_UNICODE));
	}
	public function access(){
		$model=D('AuthGroupAccess');
		$jsondata=array();
		if(IS_POST){
            $datastr=I('post.uid');
			$group_id=I('post.id');
            $result=$model->where("group_id=".$group_id)->delete();
			$data=explode(",",$datastr);
			foreach($data as $v){
				$arr=array();
				if(!empty($v)){
					$arr['uid']=$v;
					$arr['group_id']=$group_id;
					$result=$model->add($arr);
				}
			}
            if ($result) {
				$jsondata['state']='access';
				$jsondata['info']='修改成功！';
				$jsondata['data']=$data;
			}else{
				$jsondata['state']='error';
				$jsondata['info']='修改失败！';
			}
        }else{
            $id=I('get.id');
			//OA人员信息表
			$memberModel=M('member','org_','OA');
			// 获取OA用户数据
			$managerlist=$memberModel->where('IS_ENABLE=1 and IS_ADMIN=0')->field("ID,NAME")->order('SORT_ID asc')->select();
			$uidlist=$model->where('group_id=%d',$id)->field("uid")->select();
			$assign=array(
			'userlist'=>$managerlist,
			'uidlist'=>$uidlist
			);
			$jsondata['state']='access';
			$jsondata['info']='查询成功！';
			$jsondata['data']=$assign;
			
        }
		header('Content-Type:text/html; charset=utf-8');
        exit(json_encode($jsondata,JSON_UNESCAPED_UNICODE));
	}
}
?>