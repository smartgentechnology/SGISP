<?php
namespace Home\Controller;
use Common\Controller\AuthController;

class BasefunctionController extends AuthController {
	//基础档案
    public function index($id){
		$nav=D('Nav');
		if(session('manager_id')==1){
		// 获取管理员菜单数据
		$mod_data=$nav->getTreeData('admin',$id,'order_number,id');
		}else{
		// 获取其他人员菜单数据
		$mod_data=$nav->getTreeData('level',$id,'order_number,id');
		}
		//传送数据到显示页面
		$this->assign('mod_data',$mod_data);
		$this->display();
    }
}
?>