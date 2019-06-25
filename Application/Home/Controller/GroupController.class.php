<?php
namespace Home\Controller;
use Common\Controller\AuthController;
class GroupController extends AuthController {
    public function index(){
		$model=D('AuthGroup');
		$grouplist=$model->select();
		//print_r($rulelist);
		$this->assign('pagetitle','用户组管理');
		$this->assign('grouplist',$grouplist);
		$this->display();
		
		
    }
	public function add(){
		$model=D('AuthGroup');
		if(IS_POST){
			$data=array();
			$data['title']=I('post.title');
			$data['status']=I('post.status');
			$flaga=$model->where("title='%s'",$data['title'])->find();
			if($flaga){
				$this->ajaxReturn(array(
					'state'=>'error',
					'info' => '用户组已存在！'
				));
			}else{
				$flagb=$model->add($data);
				if($flagb){
					session('add_group_title',$data['title']);
					$this->ajaxReturn(array(
						'state'=>'ok',
						'info' => '用户组添加成功！'
					));
				}else{
					$this->ajaxReturn(array(
						'state'=>'error',
						'info' => '用户组添加失败！'
					));
				}
			}
			
		}else{
			$this->ajaxReturn(array(
				'state'=>'ok',
				'info' => ''
			));
		}
	}
	
	public function edit(){
		$model=D('AuthGroup');
		if(IS_GET){
			$id=I('get.id');
			if(empty($id)){
				$this->ajaxReturn(array(
					'state'=>'error',
					'info' => '请至少选择一条记录！'
					));
			}else{
				$id=substr($id,0,-1);
				$result=$model->where('id=%d',$id)->find();
				$this->ajaxReturn(array(
					'state'=>'ok',
					'info' => '',
					'data'=>$result
					));
			}
		}else{
			$id=I('post.id');
			$data['title']=I('post.title');
			$data['status']=I('post.status');
			$flaga=$model->where("title='%s' AND id !=%d",$data['title'],$id)->find();
			if($flaga){
				$this->ajaxReturn(array(
					'state'=>'error',
					'info' => '用户组已存在！'
				));
			}else{
				$flagc=$model->where('id=%d',$id)->save($data);
				if($flagc!==false){
					$this->ajaxReturn(array(
						'state'=>'ok',
						'info' => '用户组修改成功！'
					));
				}else{
					$this->ajaxReturn(array(
						'state'=>'error',
						'info' => '用户组修改失败！'
					));
				}
			}
		}
	}
	public function rule(){
		$model=D('AuthGroup');
		if(IS_POST){
            $data=I('post.rule_ids');
			$id=I('post.id');
            $rules['rules']=implode(',', $data);
            $result=$model->where('id=%d',$id)->save($rules);
            if ($result!==false) {
                $this->success('操作成功',U('Group/index'));
            }else{
                $this->error('操作失败');
            }
			
        }else{
            $id=I('get.id');
			if(empty($id)){
				$this->error('没有权限！');
			}else{
				 // 获取用户组数据
				$group_data=$model->where('id=%d',$id)->find();
				$group_data['rules']=explode(',', $group_data['rules']);
				// 获取规则数据
				$rule_data=D('AuthRule')->getOrderTreeData('level','id','title');
				
				$assign=array(
                'group_data'=>$group_data,
                'rule_data'=>$rule_data
                );
				$this->assign('pagetitle','用户组管理');
				$this->assign($assign);
				$this->display();
				
			}
           
        }
	}
	public function access(){
		$model=D('AuthGroupAccess');
		if(IS_POST){
            $data=I('post.manager_ids');
			$group_id=I('post.group_id');
            $result=$model->where('group_id=%d',$group_id)->delete();
			foreach($data as $k=>$v){
				$arr=array(
					'uid'=>$v,
					'group_id'=>$group_id
					);
				$result=$model->add($arr);
				
			}
			
            if ($result!==false) {
                $this->success('操作成功',U('Group/index'));
            }else{
                $this->error('操作失败');
            }
			
        }else{
            $id=I('get.id');
			if(empty($id)){
				$this->error('没有权限！');
			}else{
				//OA人员信息表
				$memberModel=M('member','org_','OA');
				// 获取OA用户数据
				$managerlist=$memberModel->where('IS_ENABLE=1 and IS_ADMIN=0')->order('SORT_ID asc')->select();
				 
				$accesslist=$model->where('group_id=%d',$id)->select();
				$access_data=array();
				foreach($accesslist as $value){
					$access_data[]=$value['uid'];
				}
				$assign=array(
                'managerlist'=>$managerlist,
                'access_data'=>$access_data,
				'id'=>$id
                );
				$this->assign('pagetitle','用户组管理');
				$this->assign($assign);
				$this->display();
				
			}
           
        }
	}
	
	public function del($id=''){
		$model=D('AuthGroup');
		if(empty($id)){
			$this->ajaxReturn(array(
				'state'=>'error',
				'info' => '请至少选择一条记录！'
				));
		}else{
			$id=substr($id,0,-1);
			$access=D('AuthGroupAccess');
			$flaga=$access->where('group_id in (%s)',$id)->find();
			if($flaga){
				$this->ajaxReturn(array(
					'state'=>'error',
					'info' => '该用户组已分配有用户，请先删除下属用户！'
				));
			}else{
				$flagb=$model->where('id in (%s)',$id)->delete();
				if($flagb){
					$this->ajaxReturn(array(
						'state'=>'ok',
						'info' => '用户组删除成功！'
					));
				}else{
					$this->ajaxReturn(array(
						'state'=>'error',
						'info' => '用户组删除失败！'
					));
				}
			}
		}
	}
	
}
?>