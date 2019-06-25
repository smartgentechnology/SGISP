<?php
namespace lib;

class Loading {

	//构造方法初始化
	public function check() {
		//OA人员账号
		$principalModel=M('principal','org_','OA');
		//OA人员信息表
		$memberModel=M('member','org_','OA');
		$username=I('post.username');
		$password=I('post.password');
		$data=array();
		$data['userid']=$principalModel->where("LOGIN_NAME='%s'",$username)->getField("ID");
		$data['username']=$memberModel->where("ID='%s'",$data['userid'])->getField("NAME");
		if(empty($data)){
			$data['info']='error';
		}else{
			$data['info']='access';
			
		}
		header('Content-Type:text/html; charset=utf-8');
        exit(json_encode($data));
	}
}







?>