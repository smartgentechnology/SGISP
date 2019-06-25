<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
		$this->display();
    }
	public function login(){
		//得到是否记住密码
		$remember= I('post.remember');
		//得到用户名和密码
		$map=array();
		$map['manager_name']=I('post.manager_name');
		$map['manager_passwd']=md5(I('post.manager_passwd'));
		//查询数据库，判断用户是否存在
		$manager=M('manager');
		$result=$manager->where($map)->find();
		//判断是否有用户信息
		if($result){
			//判断是否记住用户名
			if(!empty($remember)){
				session('remember',$remember);
			}else{
				session('remember',null);
			}
			//将用户信息添加到SESSION中
			session('manager_id',$result['id']);
			session('manager_name',$result['manager_name']);
			session('manager_passwd',I('post.manager_passwd'));
			session('dept_id',$result['dept_id']);
			session('auth',$result['id']);
			//登录主界面
			$this->redirect('Main/index');
		}else{
			//查询用户和密码错误，返回首页并提示
			$this->assign('message','用户名或密码错误！');
			$this->redirect('Index/index');
		}
		
	}
	public function oalogin(){
		//得到OA用户名
		$login_name=I('post.login_name');
		//查询数据库，判断用户是否存在
		//OA人员账号
		$principalModel=M('principal','org_','OA');
		//OA人员信息表
		$memberModel=M('member','org_','OA');
		
		//OA人员信息ID
		$member_id=$principalModel->where("LOGIN_NAME='%s'",$login_name)->getField("MEMBER_ID");
		//判断是否有用户信息
		if($member_id){
			$result=array();
			$result=$memberModel->where("ID='%s'",$member_id)->find();
			//将用户信息添加到SESSION中
			session('manager_id',$result['id']);
			session('manager_name',$result['name']);
			session('dept_id',$result['org_department_id']);
			session('auth',$result['id']);
			//登录主界面
			$this->redirect('Main/index');
		}else{
			//查询用户和密码错误，返回首页并提示
			$this->assign('message','用户名或密码错误！');
			$this->redirect('Index/index');
		}
		
	}
}
?>