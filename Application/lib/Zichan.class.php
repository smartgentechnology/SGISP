<?php
namespace lib;

class Zichan {
	
	public function changeFiled($datalist){
		$changelist=array();
		//OA人员信息表
		$memberModel=M('member','org_','OA');
		$unitModel=M('unit','org_','OA');
		if(!empty($datalist)){
			foreach($datalist as $value){
				$value['bumen']=$unitModel->where("ID='%s'",$value['bumen'])->getField("NAME");
				$value['fuzeren']=$memberModel->where("ID='%s'",$value['fuzeren'])->getField('NAME');
				if($value['leixing']==0 || $value['leixing']==1){
					$value['daoqiriqi']='';
					$value['daoqijiange']='';
				}else{
					if(!empty($value['daoqiriqi'])){
						$value['daoqijiange']=ceil(($value['daoqiriqi']-time())/86400);
						if($value['daoqijiange']<=60){
							$value['bgcolor']="#FF0000";
							$value['color']="#FFFFFF";
						}
						$value['daoqiriqi']=date('Y-m-d',$value['daoqiriqi']);
					}else{
						$value['daoqiriqi']='';
					}
				}
				
				switch($value['leixing']){
					case 0:
						$value['leixing']='固定资产';
						break;
					case 1:
						$value['leixing']='100~800设施';
						break;
					case 2:
						$value['leixing']='一般设备';
						break;
					case 3:
						$value['leixing']='关键设备';
						break;
					case 4:
						$value['leixing']='工具设备';
						break;
					case 5:
						$value['leixing']='生产过程工装';
						break;
					case 6:
						$value['leixing']='周转设备';
						break;
				}
				switch($value['leibie']){
					case 0:
						$value['leibie']='办公设备';
						break;
					case 1:
						$value['leibie']='餐厅用具';
						break;
					case 2:
						$value['leibie']='交通工具';
						break;
					case 3:
						$value['leibie']='房屋';
						break;
					case 4:
						$value['leibie']='监测设备';
						break;
					case 5:
						$value['leibie']='生产设备';
						break;
					case 6:
						$value['leibie']='其它';
						break;
					case 7:
						$value['leibie']='工具';
						break;
					case 8:
						$value['leibie']='生产过程工装';
						break;
					case 9:
						$value['leibie']='周转车';
						break;
				}
				switch($value['danwei']){
					case 0:
						$value['danwei']='台';
						break;
					case 1:
						$value['danwei']='套';
						break;
					case 2:
						$value['danwei']='个';
						break;
					case 3:
						$value['danwei']='把';
						break;
					case 4:
						$value['danwei']='组';
						break;
					case 5:
						$value['danwei']='张';
						break;
					case 6:
						$value['danwei']='栋';
						break;
					case 7:
						$value['danwei']='次';
						break;
					case 8:
						$value['danwei']='件';
						break;
					case 9:
						$value['danwei']='匹';
						break;
					case 10:
						$value['danwei']='辆';
						break;
					case 11:
						$value['danwei']='部';
						break;
					case 12:
						$value['danwei']='块';
						break;
					case 13:
						$value['danwei']='付';
						break;
				}
				switch($value['zhuangtai']){
					case 0:
						$value['zhuangtai']='在用';
						break;
					case 1:
						$value['zhuangtai']='闲置';
						break;
					case 2:
						$value['zhuangtai']='报废';
						break;
					case 3:
						$value['zhuangtai']='删除';
						break;
				}
				switch($value['xiaozhunleixing']){
					case 0:
						$value['xiaozhunleixing']='';
						break;
					case 1:
						$value['xiaozhunleixing']='内校';
						break;
					case 2:
						$value['xiaozhunleixing']='外校';
						break;
				}
				if(!empty($value['ruriqi'])){
					$value['ruriqi']=date('Y-m-d',$value['ruriqi']);
				}else{
					$value['ruriqi']='';
				}
				if(!empty($value['shouxiaoriqi'])){
					$value['shouxiaoriqi']=date('Y-m-d',$value['shouxiaoriqi']);
				}else{
					$value['shouxiaoriqi']='';
				}
				if(!empty($value['jianyanriqi'])){
					$value['jianyanriqi']=date('Y-m-d',$value['jianyanriqi']);
				}else{
					$value['jianyanriqi']='';
				}
				if(!empty($value['zhouqi'])){
					$value['zhouqi']=round($value['zhouqi']/86400/365,2);
				}else{
					$value['zhouqi']='';
				}
				$changelist[]=$value;
			}
		}
		return $changelist;
	}
	
}





?>