<?php
namespace lib;

class Utils {
	public function changeDate($datalist){
		$changelist=array();
		if(!empty($datalist)){
			foreach($datalist as $value){
				if(!empty($value['add_time'])){
					$value['add_time']=date('ymd',$value['add_time']);
				}
				if(!empty($value['ontime'])){
					$value['ontime']=date('ymd',$value['ontime']);
				}
				if(!empty($value['downtime'])){
					$value['downtime']=date('ymd',$value['downtime']);
				}
				
				$changelist[]=$value;
			}
		}
		return $changelist;
	}
	
	public function changeDateOne($datalist){
		$changelist=array();
		if(!empty($datalist)){
			foreach($datalist as $value){
				if(!empty($value['ontime'])){
					$value['ontime']=date('Y-m',$value['ontime']);
				}
				if(!empty($value['downtime'])){
					$value['downtime']=date('Y-m-d',$value['downtime']);
				}
				$changelist[]=$value;
			}
		}
		return $changelist;
	}
	public function changeTime($datalist){
		$changelist=array();
		if(!empty($datalist)){
			foreach($datalist as $value){
				if(!empty($value['add_time'])){
					$value['add_time']=date('ymd H:i:s',$value['add_time']);
				}
				if(!empty($value['starttime'])){
					$value['starttime']=date('ymd H:i:s',$value['starttime']);
				}
				if(!empty($value['endtime'])){
					$value['endtime']=date('ymd H:i:s',$value['endtime']);
				}
				$changelist[]=$value;
			}
		}
		return $changelist;
	}
	public function getdeptList($deptside){
		$datalist=array();
		$idlist=array();
		foreach($deptside as $x=>$y){
			$ypathlen=strlen($y['path']);
			$ypath=$y['path'];
			$str=$y['id'];
			if(in_array($str, $idlist)){
				unset($deptside[$x]);
			}else{
				$idlist[]=$str;
				$datalist[$x]=$y;
				unset($deptside[$x]);
				$arr=array();
				foreach($deptside as $a=>$b){
					$bpath=substr($b['path'],0,$ypathlen);
					if($ypath==$bpath){
						$idlist[]=$b['id'];
						$arr[]=$b;
						unset($deptside[$a]);
					}
				}
				if(!empty($arr)){
					$datalist[$x]['son']=$arr;
				}
			}
			
		}
		return $datalist;
	}
	//得到部门树
	public function getdeptinfo($deptalllist,$dept_id){
		$deptinfo=array();
		if($deptalllist['id']==$dept_id){
			$deptinfo=$deptalllist;
		}else{
			$a=$deptalllist['son'];
			foreach($a as $j){
				if($j['id']==$dept_id){
					$deptinfo=$j;
				}
				$b=$j['son'];
				if(!empty($b)){
					foreach($b as $x){
						if($x['id']==$dept_id){
							$deptinfo=$x;
						}
					}
				}
			}
		}
		return $deptinfo;
	}
	//部门树转一维数组
	public function getdeptone($data){
		$datalist=array();
		$datalist[]=$data;
		if(!empty($data['son'])){
			$a=$data['son'];
			foreach($a as $j){
				$j['name']='&emsp;├─ '.$j['name'];
				$datalist[]=$j;
				if(!empty($j['son'])){
					$b=$j['son'];
					foreach($b as $x){
						$x['name']='&nbsp;&emsp;|&emsp;&emsp;└─ '.$x['name'];
						$datalist[]=$x;
					}
				}
				
			}
		}
		return $datalist;
	}
	//得到部门树ID
	public function getTreeID($data){
		$arr=array();
		if(empty($data['son'])){
			$arr[]=$data['id'];
		}else{
			$arr[]=$data['id'];
			$a=$data['son'];
			foreach($a as $x){
				$arr[]=$x['id'];
				if(!empty($x['son'])){
					$b=$x['son'];
					foreach($b as $y){
						$arr[]=$y['id'];
					}
				}
			}
		}
		return $arr;
	}
	
	//查找子孙树（遍历整个数组并排序）
	public function getFenLeiTree($data,$iinvcgrade=1,$lev=0){
		$InventoryClassModel=M('Inventoryclass','dbo.','U8');
		$arr=array();
		foreach($data as $value){
			if($value['iinvcgrade']==$iinvcgrade){
				$value['lev']=$lev;
				$value['html']=str_repeat('&emsp;',$lev).'└─ ';
				$arr[]=$value;
				$number=$iinvcgrade+1;
				$data=$InventoryClassModel->where("cInvCCode like '".$value['cinvccode']."%' and iInvCGrade=".$number)->order("cInvCCode asc")->select();
				if(!empty($data)){
					$arr=array_merge($arr,$this->getFenLeiTree($data,$number,$lev+2));
				}
			}
		}
		return $arr;
	}
	
	public function managerIdtoName($datalist){
		$changelist=array();
		//OA人员信息表
		$memberModel=M('member','org_','OA');
		if(!empty($datalist)){
			foreach($datalist as $value){
				$value['manager_name']=$memberModel->where("ID='%s'",$value['manager_id'])->getField('NAME');
				$changelist[]=$value;
			}
		}
		return $changelist;
	}
	public function flagtoState($datalist){
		if(!empty($datalist)){
			foreach($datalist as $key=>$value){
				switch($value['flag']){
					case 0:
						$value['state']="未完成";
						break;
					case 1:
						$value['state']="已完成";
						break;
					case 5:
						$value['state']="报废";
						break;
				}
				
				$datalist[$key]=$value;
			}
		}
		return $datalist;
	}
	public function typetoCangku($datalist){
		if(!empty($datalist)){
			foreach($datalist as $key=>$value){
				switch($value['type']){
					case 5:
						$value['cangku']="成品库";
						break;
					case 6:
						$value['cangku']="在制品库";
						break;
					case 7:
						$value['cangku']="电控库";
						break;
					case 8:
						$value['cangku']="待料库";
						break;
				}
				
				$datalist[$key]=$value;
			}
		}
		return $datalist;
	}
	public function flagtoGongxu($datalist){
		if(!empty($datalist)){
			foreach($datalist as $key=>$value){
				switch($value['flag']){
					case 2:
						$value['gongxu']="焊接入库";
						break;
					case 3:
						$value['gongxu']="初试入库";
						break;
					case 4:
						$value['gongxu']="出厂入库";
						break;
					case 6:
						$value['gongxu']="包装入库";
						break;
					case 7:
						$value['gongxu']="焊接报废入库";
						break;
					case 8:
						$value['gongxu']="初试报废入库";
						break;
					case 9:
						$value['gongxu']="出厂报废入库";
						break;
					case 10:
						$value['gongxu']="待包装入库";
						break;
					case 11:
						$value['gongxu']="包装完入库";
						break;
					
				}
				
				$datalist[$key]=$value;
			}
		}
		return $datalist;
	}
	//Train改变字段
	public function changeFiled($datalist){
		$changelist=array();
		//OA人员信息表
		$memberModel=M('member','org_','OA');
		$unitModel=M('unit','org_','OA');
		if(!empty($datalist)){
			foreach($datalist as $value){
				$value['dept_name']=$unitModel->where("ID='%s'",$value['dept_id'])->getField("NAME");
				if($value['number']<10){
					$value['number']=$value['dept_name'].'0'.$value['number'];
				}else{
					$value['number']=$value['dept_name'].$value['number'];
				}
				
				$value['manager_name']=$memberModel->where("ID='%s'",$value['manager_id'])->getField('NAME');
				if(!empty($value['img'])){
					$img=explode(",", $value['img']);
					$value['imglist']=$img;
				}
				$changelist[]=$value;
			}
		}
		return $changelist;
	}
}





?>