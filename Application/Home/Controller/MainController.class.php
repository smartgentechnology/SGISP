<?php
namespace Home\Controller;
use Think\Controller;
class MainController extends Controller {
    public function index(){
		//获得用户SESSION信息
		$manager_id=session('manager_id');
		$manager_name=session('manager_name');
		$dept_id=session('dept_id');
		
		//判断是否有用户信息，如果没有直接返回登录页面
		if(!empty($manager_id) && !empty($manager_name) && !empty($dept_id)){
			$this->display();
			
		}else{
			$this->redirect('Index/index');
		}
		
    }
	public function logout(){
		session('manager_id',null);
		session('dept_id',null);
		$this->redirect('Index/index');
	}
	public function resetpw(){
		if(IS_POST){
			$model=D('Manager');
			$data=I('post.');
			$model->manager_passwd=md5($data['manager_passwd']);  
			$flag=$model->where('id =%d',$data['manager_id'])->save();
			if($flag){
				$this->ajaxReturn(array(
					'state'=>'ok',
					'info' => '重置密码成功！'
				));
				
			}else{
				$this->ajaxReturn(array(
					'state'=>'error',
					'info' => '重置密码失败！'
				));
			}
			
			
		}else{
			$this->display();
		}
		
	}
	
}
?>