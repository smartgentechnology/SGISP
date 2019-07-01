<?php
namespace lib;

class Fanxiu {
	public function dengji($datalist){
		$changelist=array();
		//OA人员信息表
		$memberModel=M('member','org_','OA');
		//U8型号表
		$InventoryModel=M('Inventory','dbo.','U8');
		//U8人员
		$PersonModel=M('Person','dbo.','U8');
		$express=D('Express');
		if(!empty($datalist)){
			foreach($datalist as $value){
				if(is_numeric($value['product'])){
					$value['product']=$InventoryModel->where("I_id = '".$value['product']."'")->getField("cInvStd");
				}
				if(!empty($value['person'])){
					$value['person']=$PersonModel->where("cPersonCode = '%s'",$value['person'])->getField("cPersonName");
				}
				switch($value['result']){
					case 1:
						$value['result']='修好退回';
						break;
					case 2:
						$value['result']='加试入库';
						break;
					case 3:
						$value['result']='修好入库';
						break;
					case 4:
						$value['result']='报废';
						break;
					case 5:
						$value['result']='批量退回-生产';
						break;
				}
				switch($value['bad']){
					case 1:
						$value['bad']='材料不良';
						break;
					case 2:
						$value['bad']='客户使用';
						break;
					case 3:
						$value['bad']='其他';
						break;
					case 4:
						$value['bad']='设计不良';
						break;
					case 5:
						$value['bad']='原因不明';
						break;
					case 6:
						$value['bad']='作业不良';
						break;
					case 7:
						$value['bad']='正常';
						break;
				}
				$value['flagid']=$value['flag'];
				switch($value['flag']){
					case 1:
						$value['flag']='已登记';
						break;
					case 2:
						$value['flag']='维修暂存';
						break;
					case 3:
						$value['flag']='已修';
						break;
					case 4:
						$value['flag']='功能不合格';
						break;
					case 5:
						$value['flag']='功能合格';
						break;
					case 6:
						$value['flag']='包装不合格';
						break;
					case 7:
						$value['flag']='包装合格';
						break;
					case 8:
						$value['flag']='领导审完';
						break;
					case 9:
						$value['flag']='已出库';
						break;
					case 10:
						$value['flag']='已退回';
						break;
					case 11:
						$value['flag']='批量返生产';
						break;
				}

				if($value['add_id']!=0){
					$value['add_id']=$memberModel->where("ID='%s'",$value['add_id'])->getField('NAME');
				}
				if($value['receive_date']!=0){
					$value['receive_date']=date('Y-m-d',$value['receive_date']);
				}
				if($value['pdate']!=0){
					$value['pdate']=date('Y-m-d',$value['pdate']);
				}
				if($value['prdate']!=0){
					$value['prdate']=ceil($value['prdate']/2592000);
				}
				if($value['maint_id']!=0){
					$value['maint_id']=$memberModel->where("ID='%s'",$value['maint_id'])->getField('NAME');
				}

				if($value['maint_date']!=0){
					$value['maint_date']=date('Y-m-d',$value['maint_date']);
				}
				if($value['leader_id']!=0){
					$value['leader_id']=$memberModel->where("ID='%s'",$value['leader_id'])->getField('NAME');
				}

				if($value['leader_date']!=0){
					$value['leader_date']=date('Y-m-d',$value['leader_date']);
				}
				if($value['entry_date']!=0){
					$value['entry_date']=date('Y-m-d',$value['entry_date']);
				}
				if($value['return_date']!=0){
					$value['return_date']=date('Y-m-d',$value['return_date']);
				}
				if($value['tabflag']==1){
					$value['tabflag']="Y";
				}else{
					$value['tabflag']="";
				}
				if($value['express']!=""){
					$value['express']=$express->where("pinyin='%s'",$value['express'])->getField("name");
				}
				$changelist[]=$value;
			}
		}
		return $changelist;
	}
	public function info($value){
		//OA人员信息表
		$memberModel=M('member','org_','OA');
		//U8型号表
		$InventoryModel=M('Inventory','dbo.','U8');
		//U8人员
		$PersonModel=M('Person','dbo.','U8');
		$express=D('Express');
		if(!empty($value)){
				if(is_numeric($value['product'])){
					$value['product']=$InventoryModel->where("I_id = '".$value['product']."'")->getField("cInvStd");
				}
				if(!empty($value['person'])){
					$value['person']=$PersonModel->where("cPersonCode = '%s'",$value['person'])->getField("cPersonName");
				}
				switch($value['result']){
					case 1:
						$value['result']='修好退回';
						break;
					case 2:
						$value['result']='加试入库';
						break;
					case 3:
						$value['result']='修好入库';
						break;
					case 4:
						$value['result']='报废';
						break;
					case 5:
						$value['result']='批量退回-生产';
						break;
				}
				switch($value['bad']){
					case 1:
						$value['bad']='材料不良';
						break;
					case 2:
						$value['bad']='客户使用';
						break;
					case 3:
						$value['bad']='其他';
						break;
					case 4:
						$value['bad']='设计不良';
						break;
					case 5:
						$value['bad']='原因不明';
						break;
					case 6:
						$value['bad']='作业不良';
						break;
					case 7:
						$value['bad']='正常';
						break;
				}
				$value['flagid']=$value['flag'];
				switch($value['flag']){
					case 1:
						$value['flag']='已登记';
						break;
					case 2:
						$value['flag']='维修暂存';
						break;
					case 3:
						$value['flag']='已修';
						break;
					case 4:
						$value['flag']='功能不合格';
						break;
					case 5:
						$value['flag']='功能合格';
						break;
					case 6:
						$value['flag']='包装不合格';
						break;
					case 7:
						$value['flag']='包装合格';
						break;
					case 8:
						$value['flag']='领导审完';
						break;
					case 9:
						$value['flag']='已出库';
						break;
					case 10:
						$value['flag']='已退回';
						break;
					case 11:
						$value['flag']='批量返生产';
						break;
				}

				if($value['add_id']!=0){
					$value['add_id']=$memberModel->where("ID='%s'",$value['add_id'])->getField('NAME');
				}
				if($value['receive_date']!=0){
					$value['receive_date']=date('Y-m-d',$value['receive_date']);
				}
				if($value['pdate']!=0){
					$value['pdate']=date('Y-m-d',$value['pdate']);
				}
				if($value['prdate']!=0){
					$value['prdate']=ceil($value['prdate']/2592000);
				}
				if($value['maint_id']!=0){
					$value['maint_id']=$memberModel->where("ID='%s'",$value['maint_id'])->getField('NAME');
				}

				if($value['maint_date']!=0){
					$value['maint_date']=date('Y-m-d',$value['maint_date']);
				}
				if($value['leader_id']!=0){
					$value['leader_id']=$memberModel->where("ID='%s'",$value['leader_id'])->getField('NAME');
				}

				if($value['leader_date']!=0){
					$value['leader_date']=date('Y-m-d',$value['leader_date']);
				}
				if($value['entry_date']!=0){
					$value['entry_date']=date('Y-m-d',$value['entry_date']);
				}
				if($value['return_date']!=0){
					$value['return_date']=date('Y-m-d',$value['return_date']);
				}
				if($value['tabflag']==1){
					$value['tabflag']="Y";
				}else{
					$value['tabflag']="";
				}
				if($value['express']!=""){
					$value['express']=$express->where("pinyin='%s'",$value['express'])->getField("name");
				}
		}
		return $value;
	}

	public function export($datalist){
		$changelist=array();
		//OA人员信息表
		$memberModel=M('member','org_','OA');
		//U8型号表
		$InventoryModel=M('Inventory','dbo.','U8');
		//U8人员
		$PersonModel=M('Person','dbo.','U8');
		$express=D('Express');
		if(!empty($datalist)){
			foreach($datalist as $value){
				$value['fanxiunumber']=" ".$value['fanxiunumber'];
				if(is_numeric($value['product'])){
					$value['product']=$InventoryModel->where("I_id = '".$value['product']."'")->getField("cInvStd");
				}
				$value['person']=$PersonModel->where("cPersonCode = '%s'",$value['person'])->getField("cPersonName");
				$value['barcode']=" ".$value['barcode'];
				switch($value['result']){
					case 1:
						$value['result']='修好退回';
						break;
					case 2:
						$value['result']='加试入库';
						break;
					case 3:
						$value['result']='修好入库';
						break;
					case 4:
						$value['result']='报废';
						break;
					case 5:
						$value['result']='批量退回-生产';
						break;
				}
				switch($value['bad']){
					case 1:
						$value['bad']='材料不良';
						break;
					case 2:
						$value['bad']='客户使用';
						break;
					case 3:
						$value['bad']='其他';
						break;
					case 4:
						$value['bad']='设计不良';
						break;
					case 5:
						$value['bad']='原因不明';
						break;
					case 6:
						$value['bad']='作业不良';
						break;
					case 7:
						$value['bad']='正常';
						break;
				}
				switch($value['flag']){
					case 1:
						$value['flag']='已登记';
						break;
					case 2:
						$value['flag']='维修暂存';
						break;
					case 3:
						$value['flag']='已修';
						break;
					case 4:
						$value['flag']='功能不合格';
						break;
					case 5:
						$value['flag']='功能合格';
						break;
					case 6:
						$value['flag']='包装不合格';
						break;
					case 7:
						$value['flag']='包装合格';
						break;
					case 8:
						$value['flag']='领导审完';
						break;
					case 9:
						$value['flag']='已出库';
						break;
					case 10:
						$value['flag']='已退回';
						break;
					case 11:
						$value['flag']='批量返生产';
						break;
				}
				$value['add_id']=$memberModel->where("ID='%s'",$value['add_id'])->getField('NAME');
				$value['receive_date']=date('Y-m-d',$value['receive_date']);
				$value['pdate']=date('Y-m-d',$value['pdate']);
				$value['prdate']=ceil($value['prdate']/2592000);
				$httpstr="http://117.158.18.33:90/Public/";
				if(!empty($value['qz'])){
					$value['qz']=$httpstr.$value['qz'];
				}
				if(!empty($value['qb'])){
					$value['qb']=$httpstr.$value['qb'];
				}
				if(!empty($value['hz'])){
					$value['hz']=$httpstr.$value['hz'];
				}
				if(!empty($value['hb'])){
					$value['hb']=$httpstr.$value['hb'];
				}
				if($value['bad']==0){
					$value['bad']="";
				}
				if($value['maint_date']==0){
					$value['maint_date']="";
				}
				if($value['gongneng']==0){
					$value['gongneng']="";
				}
				if($value['baozhuang']==0){
					$value['baozhuang']="";
				}
				if($value['leader_date']==0){
					$value['leader_date']="";
				}
				if($value['entry_date']==0){
					$value['entry_date']="";
				}
				if($value['return_date']==0){
					$value['return_date']="";
				}
				if(!empty($value['expressid'])){
					$value['expressid']=" ".$value['expressid'];
				}
				$value['maint_id']=$memberModel->where("ID='%s'",$value['maint_id'])->getField('NAME');
				if($value['maint_date']!=0){
					$value['maint_date']=date('Y-m-d',$value['maint_date']);
				}
				$value['leader_id']=$memberModel->where("ID='%s'",$value['leader_id'])->getField('NAME');
				if($value['leader_date']!=0){
					$value['leader_date']=date('Y-m-d',$value['leader_date']);
				}
				if($value['entry_date']!=0){
					$value['entry_date']=date('Y-m-d',$value['entry_date']);
				}
				if($value['return_date']!=0){
					$value['return_date']=date('Y-m-d',$value['return_date']);
				}
				if($value['tabflag']==1){
					$value['tabflag']="Y";
				}else{
					$value['tabflag']="";
				}
				$value['express']=$express->where("pinyin='%s'",$value['express'])->getField("name");
				$changelist[]=$value;
			}
		}
		return $changelist;
	}

	public function set($datalist){
		$changelist=array();
		$model=D('Column');
		if(!empty($datalist)){
			foreach($datalist as $value){
				$value['name']=$model->where("id = %d",$value['columnid'])->getField("name");

				$changelist[]=$value;
			}
		}
		return $changelist;
	}
	public function quality($datalist){
		//OA人员信息表
		$memberModel=M('member','org_','OA');
		if(!empty($datalist)){
			foreach($datalist as $key=>$value){
				$datalist[$key]['quality_id']=$memberModel->where("ID='%s'",$value['quality_id'])->getField('NAME');
				$datalist[$key]['quality_date']=date('Y-m-d H:m:s',$value['quality_date']);
				switch($value['result']){
					case 1:
						$datalist[$key]['result']='合格';
						break;
					case 2:
						$datalist[$key]['result']='不合格';
						break;
				}
			}
		}
		return $datalist;
	}
	public function xiuqian($datalist){
		//OA人员信息表
		$memberModel=M('member','org_','OA');
		//U8型号表
		$InventoryModel=M('Inventory','dbo.','U8');
		if(!empty($datalist)){
			if(is_numeric($datalist['product'])){
				$datalist['product']=$InventoryModel->where("I_id = '".$datalist['product']."'")->getField("cInvStd");
			}
			switch($datalist['result']){
				case 1:
					$datalist['result']='修好退回';
					break;
				case 2:
					$datalist['result']='加试入库';
					break;
				case 3:
					$datalist['result']='修好入库';
					break;
				case 4:
					$datalist['result']='报废';
					break;
				case 5:
					$datalist['result']='批量退回-生产';
					break;
			}
			$datalist['add_id']=$memberModel->where("ID='%s'",$datalist['add_id'])->getField('NAME');
			$datalist['receive_date']=date('Y-m-d',$datalist['receive_date']);
			$datalist['pdate']=date('Y-m-d',$datalist['pdate']);
			$datalist['prdate']=ceil($datalist['prdate']/2592000);
			$httpstr="http://117.158.18.33:90/Public/";
			if(!empty($datalist['qz'])){
				$datalist['qz']=$httpstr.$datalist['qz'];
			}
			if(!empty($datalist['qb'])){
				$datalist['qb']=$httpstr.$datalist['qb'];
			}
			if(!empty($datalist['hz'])){
				$datalist['hz']=$httpstr.$datalist['hz'];
			}
			if(!empty($datalist['hb'])){
				$datalist['hb']=$httpstr.$datalist['hb'];
			}
			if(!empty($datalist['quality'])){
				foreach($datalist['quality'] as $key=>$value){
					$datalist['quality'][$key]['quality_id']=$memberModel->where("ID='%s'",$value['quality_id'])->getField('NAME');
					$datalist['quality'][$key]['quality_date']=date('Y-m-d H:m:s',$value['quality_date']);
					switch($value['result']){
						case 1:
							$datalist['quality'][$key]['result']='合格';
							break;
						case 2:
							$datalist['quality'][$key]['result']='不合格';
							break;
					}
				}
			}
		}
		return $datalist;
	}
}





?>
