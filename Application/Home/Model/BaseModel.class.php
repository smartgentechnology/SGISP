<?php
namespace Home\Model;
use Think\Model\RelationModel;
class BaseModel extends RelationModel{
	/**
	 * 获取全部菜单
	 * @param  string $type tree获取树形结构 level获取层级结构
	 * @return array 结构数据
	 */
	 public function getTreeData($type='tree',$pid=-1,$order=''){
	 	// 判断是否需要排序
	 	if(empty($order)){
			//$data=$this->order('order_number is null,'.$order)->select();
			if($pid==-1){
				$data=$this->select();
			}else{
				$data=$this->where('pid =%d',$pid)->select();
			}
			
		}else{
			//$data=$this->order('order_number is null,'.$order)->select();
			if($pid==-1){
				$data=$this->order($order)->select();
			}else{
				$data=$this->where('pid =%d',$pid)->order($order)->select();
			}
			
		}
		//获取树形或者结构数据
		if($type=='tree'){
			$data=\Org\Nx\Data::tree($data,'name','id','pid');
		}elseif($type=='level'){
			$data=\Org\Nx\Data::channelLevel($data,$pid,'&nbsp;','id');
			// 显示有权限的菜单
			$auth=new \Think\Auth();
			foreach ($data as $k => $v) {
				if ($auth->check($v['mca'],session('manager_id'))) {
					foreach ($v['_data'] as $m => $n) {
						if(!$auth->check($n['mca'],session('manager_id'))){
							unset($data[$k]['_data'][$m]);
						}
					}
				}else{
					// 删除无权限的菜单
					unset($data[$k]);
				}
			}
		}elseif($type=='admin'){
			$data=\Org\Nx\Data::channelLevel($data,$pid,'&nbsp;','id');
		}
		return $data;
	 }
	 /**
     * 获取全部数据
     * @param  string $type  tree获取树形结构 level获取层级结构
     * @param  string $order 排序方式   
     * @return array         结构数据
     */
    public function getOrderTreeData($type='tree',$order='',$name='name',$pid=0,$child='id',$parent='pid'){
        // 判断是否需要排序
        if(empty($order)){
            $data=$this->select();
        }else{
            $data=$this->order($order.' is null,'.$order)->select();
        }
        // 获取树形或者结构数据
        if($type=='tree'){
            $data=\Org\Nx\Data::tree($data,$name,$child,$parent);
        }elseif($type="level"){
            $data=\Org\Nx\Data::channelLevel($data,$pid,'&nbsp;',$child);
        }
        return $data;
    }
	//查找子孙树（遍历整个数组并排序）
	public function getSonTree($data,$pid=0,$lev=0){
		$arr=array();
		foreach($data as $value){
			if($value['pid']==$pid){
				$value['lev']=$lev;
				$value['html']=str_repeat('&emsp;',$lev).'└─ ';
				$arr[]=$value;
				$arr=array_merge($arr,$this->getSonTree($data,$value['id'],$lev+2));
			}
		}
		return $arr;
	}
	
	//获取所有id
	public function getSonTreeId($deptson){
		foreach($deptson as $value){
			$id.=$value['id'].',';
		}
		return $id;
	}
}









?>