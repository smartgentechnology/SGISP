<?php
namespace Home\Controller;
use Think\Controller;
class LoadingjsonController extends Controller {
    //构造方法初始化
	public function check() {
		$data=array();
		//OA人员信息表
		$memberModel=M('member','org_','OA');
		$phone=I('post.phone');
		if($phone!=""){
			$userinfo=$memberModel->where("EXT_ATTR_1='".$phone."'")->field("ID,NAME,ORG_DEPARTMENT_ID")->find();
			if($userinfo){
				$data['info']='access';
				$data['userid']=$userinfo['id'];
				$data['name']=$userinfo['name'];
				$data['deptid']=$userinfo['org_department_id'];
			}else{
				$data['info']='error';
			}
		}else{
			$data['info']='error';
		}
		header('Content-Type:text/html; charset=utf-8');
        exit(json_encode($data,JSON_UNESCAPED_UNICODE));
		
	}
	public function gettoken() {
		$model=D('Baidutoken');
		$datajson=array();
		$nowtime=time();
		$info=$model->find();
		if(!empty($info)){
			if($nowtime<$info['expires_in']){
				$datajson['info']='access';
				$datajson['access_token']=$info['access_token'];
			}else{
				$postUrl='https://aip.baidubce.com/oauth/2.0/token';
				$post_data['grant_type']='client_credentials';
				$post_data['client_id']='lDaQFCsFntVOMZkmTw8mjzEz';
				$post_data['client_secret']='B31EfyYG5x4LViYonUPSWwSyyjttk9wL';
				$o="";
				foreach($post_data as $k => $v ) 
				{
					$o.= "$k=" . urlencode( $v ). "&" ;
					//$o.= $k."=".$v."&";
				}
				$curlPost=substr($o,0,-1);
				$ch =curl_init();
				$timeout = 300;
				curl_setopt($ch, CURLOPT_URL, $postUrl);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
				curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
				curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
				$data = curl_exec($ch);//运行curl
				$data=json_decode($data,true);
				curl_close($ch);
				$arr["expires_in"]=$nowtime+$data["expires_in"];
				$arr["access_token"]=$data["access_token"];
				$model->where("id=%d",$info['id'])->save($arr);
				$datajson['info']='access';
				$datajson['access_token']=$arr["access_token"];
			}
		}else{
			$postUrl='https://aip.baidubce.com/oauth/2.0/token';
			$post_data['grant_type']='client_credentials';
			$post_data['client_id']='lDaQFCsFntVOMZkmTw8mjzEz';
			$post_data['client_secret']='B31EfyYG5x4LViYonUPSWwSyyjttk9wL';
			$o="";
			foreach($post_data as $k => $v ) 
			{
				$o.= "$k=" . urlencode( $v ). "&" ;
				//$o.= $k."=".$v."&";
			}
			$curlPost=substr($o,0,-1);
			$ch =curl_init();
			$timeout = 300;
			curl_setopt($ch, CURLOPT_URL, $postUrl);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
			curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
			$data = curl_exec($ch);//运行curl
			$data=json_decode($data,true);
			curl_close($ch);
			$arr["expires_in"]=$nowtime+$data["expires_in"];
			$arr["access_token"]=$data["access_token"];
			$model->add($arr);
			$datajson['info']='access';
			$datajson['access_token']=$arr["access_token"];
		}
		header('Content-Type:text/html; charset=utf-8');
        exit(json_encode($datajson,JSON_UNESCAPED_UNICODE));
		
	}
}
?>