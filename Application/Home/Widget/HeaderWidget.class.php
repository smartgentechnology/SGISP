<?php
namespace Home\Widget;
use Think\Controller;
class HeaderWidget extends Controller{
	public function top(){
		$nav=D('Nav');
		if(session('manager_id')==1){
		// 获取管理员菜单数据
		$nav_data=$nav->getTreeData('admin',0,'order_number,id');
		}else{
		// 获取其他人员菜单数据
		$nav_data=$nav->getTreeData('level',0,'order_number,id');
		}
		$this->assign('nav_data',$nav_data);
		
		$this->display('Header:top');
	}
	public function footer(){
		$this->display('Header:footer');
	}
	
}





?>