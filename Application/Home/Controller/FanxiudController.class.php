<?php
namespace Home\Controller;
use Common\Controller\AuthController;
class FanxiudController extends AuthController {
	
    public function index(){
		$model=D('Fanxiu');
		//U8型号表
		$InventoryModel=M('Inventory','dbo.','U8');
		
		$inventorylist=$InventoryModel->where("cInvCCode like '02%'")->order("cInvStd asc")->field("I_id,cInvName,cInvStd")->select();
		//U8人员
		$PersonModel=M('Person','dbo.','U8');
		$personlist=$PersonModel->where("(cDepCode='602' or cDepCode='603' or cDepCode='604' or cDepCode='606' or cDepCode='607' or cPersonName='崔文玉') and dPInValidDate is null")->field("cPersonCode,cPersonName")->select();
		if(IS_POST){
			$data=I('post.');
			//得到查询条件
			//客户
			$fanxiud_customer_dir=$data['fanxiud_customer_dir'];
			
			//接收日期
			$fanxiud_rdate_dir_start=$data['fanxiud_rdate_dir_start'];
			$fanxiud_rdate_dir_end=$data['fanxiud_rdate_dir_end'];
			
			//产品
			$fanxiud_product_dir=$data['fanxiud_product_dir'];
			
			//条码
			$fanxiud_barcode_dir=$data['fanxiud_barcode_dir'];
			
			
			//生产日期
			$fanxiud_pdate_dir_start=$data['fanxiud_pdate_dir_start'];
			$fanxiud_pdate_dir_end=$data['fanxiud_pdate_dir_end'];
			
			//处理结果
			$fanxiud_result_dir=$data['fanxiud_result_dir'];
			
			//拼接客户
			if(!empty($fanxiud_customer_dir)){
				$map=$map." and customer like'%".$fanxiud_customer_dir."%'";
			}
			//拼接产品
			if(!empty($fanxiud_product_dir)){
				$map=$map." and product ='".$fanxiud_product_dir."'";
			}
			//拼接条码
			if(!empty($fanxiud_barcode_dir)){
				$map=$map." and barcode ='".$fanxiud_barcode_dir."'";
			}
			//拼接处理结果
			if(!empty($fanxiud_result_dir)){
				$map=$map." and result ='".$fanxiud_result_dir."'";
			}
			//拼接接收日期
			if(!empty($fanxiud_rdate_dir_start) && !empty($fanxiud_rdate_dir_end)){
				$fanxiud_rdate_dir_end=strtotime($fanxiud_rdate_dir_end)+86400;
				$map=$map." and receive_date>=".strtotime($fanxiud_rdate_dir_start)." and receive_date<=".$fanxiud_rdate_dir_end;
			}else if(!empty($fanxiud_rdate_dir_start) && empty($fanxiud_rdate_dir_end)){
				$map=$map." and receive_date>=".strtotime($fanxiud_rdate_dir_start);
			}else if(empty($fanxiud_rdate_dir_start) && !empty($fanxiud_rdate_dir_end)){
				$fanxiud_rdate_dir_end=strtotime($fanxiud_rdate_dir_end)+86400;
				$map=$map." and receive_date<=".$fanxiud_rdate_dir_end;
			}
			
			//拼接生产日期
			if(!empty($fanxiud_pdate_dir_start) && !empty($fanxiud_pdate_dir_end)){
				$fanxiud_pdate_dir_end=strtotime($fanxiud_pdate_dir_end)+86400;
				$map=$map." and pdate>=".strtotime($fanxiud_pdate_dir_start)." and pdate<=".$fanxiud_pdate_dir_end;
			}else if(!empty($fanxiud_pdate_dir_start) && empty($fanxiud_pdate_dir_end)){
				$map=$map." and pdate>=".strtotime($fanxiud_pdate_dir_start);
			}else if(empty($fanxiud_pdate_dir_start) && !empty($fanxiud_pdate_dir_end)){
				$fanxiud_pdate_dir_end=strtotime($fanxiud_pdate_dir_end)+86400;
				$map=$map." and pdate<=".$fanxiud_pdate_dir_end;
			}
			session('map',$map);
			session('flag',1);
			
		}else if(IS_GET){
			if(!empty($_GET)){
				$state=I('get.flag');
				session('flag',$state);
			}else{
				session('flag',1);
				session('map',null);
			}
		}
		//拼接查询条件
		$flag=session('flag');
		$map=session('map');
		$flag="flag =".$flag;
		$count=$model->where($flag.$map)->count();
		$Page=new \Org\Nx\Page($count,10);
		$show=$Page->show();
		//日常工作计划未完成
		$datalist=$model->where($flag.$map)->order('fanxiunumber desc')->limit($Page->firstRow.','.$Page->listRows)->select();
		//调用工具类
		$fanxiu=new \lib\Fanxiu();
		$datalist=$fanxiu->dengji($datalist);
		$result=array(array('id'=>1,'value'=>'修好退回'),array('id'=>2,'value'=>'加试入库'),array('id'=>3,'value'=>'修好入库'),array('id'=>4,'value'=>'报废'),array('id'=>5,'value'=>'批量退回-生产'));
		$this->assign('pagetitle','返修登记');
		$this->assign('datalist',$datalist);
		$this->assign('count',$count);
		$this->assign('result',$result);
		$this->assign('inventorylist',$inventorylist);
		$this->assign('personlist',$personlist);
		$this->assign('page',$show);
		$this->display();
    }
	
	public function add(){
		$model=D('Fanxiu');
		if(IS_POST){
			$data=array();
			$nowtime=time();
			$data['fanxiunumber']=$nowtime;
			$data['receive_date']=$nowtime;
			$data['customer']=I('post.customer');
			$data['result']=I('post.result');
			$data['person']=I('post.person');
			$data['product']=I('post.product');
			$data['remark']=I('post.remark');
			$data['add_id']=session('manager_id');
			$data['add_date']=$nowtime;
			if($data['result']==5){
				$data['qty']=I('post.qty');
				$data['flag']=11;
			}else{
				$data['qty']=1;
				$data['flag']=1;
			}
			
			
			//条码列表
			$barcode=I('post.barcode');
			$barcodelist=explode("\n", $barcode);
			$barcodelist=array_filter($barcodelist);
			$datalist=array();
			foreach($barcodelist as $value){
				$temp=array();
				$temp=$data;
				$strlen=strlen($value);
				if($strlen==15){
					//取出周
					$zhou=substr($value,2,2);
					//变成天
					$zhou=intval($zhou);
					$day=($zhou-1)*7;
					//取出年
					$nian=substr($value,4,2);
					//变年份
					$nian=intval($nian);
					$year=2000+$nian-10;
					//生成年份+天数的时间戳
					$temp['pdate']=mktime(0,0,0,0,$day,$year);
					
				}elseif($strlen==17){
					//取出周
					$zhou=substr($value,4,2);
					//变成天
					$zhou=intval($zhou);
					$day=($zhou-1)*7;
					//取出年
					$nian=substr($value,6,2);
					//变年份
					$nian=intval($nian);
					$year=2000+$nian-10;
					//生成年份+天数的时间戳
					$temp['pdate']=mktime(0,0,0,0,$day,$year);
				}else{
					$temp['pdate']=strtotime("1998-03-18");
				}
				if(!empty($temp['pdate'])){
					$temp['barcode']=$value;
					$temp['prdate']=$nowtime-$temp['pdate'];
					$count=$model->where("barcode='%s' and flag =1",$value)->count();
					if($count==0){
						$temp['cishu']=$model->where("barcode='%s'",$value)->count();
						$datalist[]=$temp;
					}
				}
			}
			if(empty($datalist)){
				$this->ajaxReturn(array(
					'state'=>'error',
					'info' => '条码已存在未修记录中！'
				));
			}else{
				// 验证通过 写入新增数据
				$flagb=$model->addAll($datalist);
				if($flagb){
					session('add_fanxiud_customer',$data['customer']);
					session('add_fanxiud_result',$data['result']);
					session('add_fanxiud_person',$data['person']);
					if(empty($data['remark'])){
						session('add_fanxiud_remark',NULL);
					}else{
						session('add_fanxiud_remark',$data['remark']);
					}
					
					$this->ajaxReturn(array(
						'state'=>'ok',
						'info' => '维修记录添加成功！'
					));
				}else{
					$this->ajaxReturn(array(
						'state'=>'error',
						'info' => '维修记录添加失败！'
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
		$model=D('Fanxiu');
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
				$result['pdate']=date('Y-m-d',$result['pdate']);
				$this->ajaxReturn(array(
					'state'=>'ok',
					'info' => '',
					'data'=>$result
					));
			}
		}else{
			$id=I('post.id');
			$data=array();
			$data['customer']=I('post.customer');
			$data['result']=I('post.result');
			$data['person']=I('post.person');
			$data['product']=I('post.product');
			$data['remark']=I('post.remark');
			$data['qty']=I('post.qty');
			$data['pdate']=strtotime(I('post.pdate'));
			$barcode=I('post.barcode');
			$barcodelist=explode("\n", $barcode);
			$data['barcode']=$barcodelist[0];
			$flaga=$model->where("barcode='%s' and id!=%d and flag=1",$data['barcode'],$id)->find();
			if($flaga){
				$this->ajaxReturn(array(
					'state'=>'error',
					'info' => '该条码已存在！'
				));
			}else{
				$receive_date=$model->where("id=%d",$id)->getField("receive_date");
				$data['prdate']=$receive_date-$data['pdate'];
				$flagb=$model->where('id=%d',$id)->save($data);
				if($flagb!==false){
					$this->ajaxReturn(array(
						'state'=>'ok',
						'info' => '维修记录修改成功！'
					));
				}else{
					$this->ajaxReturn(array(
						'state'=>'error',
						'info' => '维修记录修改失败！'
					));
				}
			}
			
		}
	}
	
	
	
	public function del($id=''){
		$model=D('Fanxiu');
		if(empty($id)){
			$this->ajaxReturn(array(
				'state'=>'error',
				'info' => '请至少选择一条记录！'
				));
		}else{
			$id=substr($id,0,-1);
			$flagb=$model->where('id in (%s)',$id)->delete();
			if($flagb){
				$this->ajaxReturn(array(
					'state'=>'ok',
					'info' => '维修记录删除成功！'
				));
			}else{
				$this->ajaxReturn(array(
					'state'=>'error',
					'info' => '维修记录删除失败！'
				));
			}
			
		}
	}
	public function tabflag($id=''){
		$model=D('Fanxiu');
		if(empty($id)){
			$this->ajaxReturn(array(
				'state'=>'error',
				'info' => '请至少选择一条记录！'
				));
		}else{
			$id=substr($id,0,-1);
			$data=array();
			$data["tabflag"]=1;
			$flagb=$model->where('id in (%s)',$id)->save($data);
			if($flagb){
				$this->ajaxReturn(array(
					'state'=>'ok',
					'info' => '制单成功！'
				));
			}else{
				$this->ajaxReturn(array(
					'state'=>'error',
					'info' => '制单失败！'
				));
			}
			
		}
	}
	public function qutabflag($id=''){
		$model=D('Fanxiu');
		if(empty($id)){
			$this->ajaxReturn(array(
				'state'=>'error',
				'info' => '请至少选择一条记录！'
				));
		}else{
			$id=substr($id,0,-1);
			$data=array();
			$data["tabflag"]=0;
			$flagb=$model->where('id in (%s)',$id)->save($data);
			if($flagb){
				$this->ajaxReturn(array(
					'state'=>'ok',
					'info' => '取消制单成功！'
				));
			}else{
				$this->ajaxReturn(array(
					'state'=>'error',
					'info' => '取消制单失败！'
				));
			}
			
		}
	}
}
?>