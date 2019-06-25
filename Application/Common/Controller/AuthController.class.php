<?
namespace Common\Controller;
use Think\Controller;
use Think\Auth;
class AuthController extends Controller{
	protected function _initialize(){
		$sess_auth=session('auth');
		if(!$sess_auth){
			$this->error('非法访问，正在跳转到登录页！',U('Index/index'));
		}
		
		if($sess_auth==1){
			return true;
		}
		
	
		$auth=new Auth();
		
		
		if(IS_AJAX){
			if(!$auth->check(CONTROLLER_NAME.'/'.ACTION_NAME,$sess_auth)){
				$this->ajaxReturn(array(
				'state'=>'error',
				'info' => '您没有权限！'
				));
			}
			
		}else{
			if(!$auth->check(CONTROLLER_NAME.'/'.ACTION_NAME,$sess_auth)){
				$this->error('没有权限！');
			}
		}

	}
}


?>