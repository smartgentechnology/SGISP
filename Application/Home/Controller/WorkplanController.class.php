<?php
namespace Home\Controller;
use Common\Controller\AuthController;
class WorkplanController extends AuthController {
	
    public function index(){
		$model=D('Workplan');
		//OA人员信息表
		$memberModel=M('member','org_','OA');
		//OA部门信息表
		$unitModel=M('unit','org_','OA');
		
		if(IS_POST){
			$data=I('post.');
			//得到查询条件
			//计划日期
			$workplan_month_dir_start=$data['workplan_month_dir_start'];
			$workplan_month_dir_end=$data['workplan_month_dir_end'];
			//计划内容
			$workplan_content_dir=$data['workplan_content_dir'];
			//完成日期
			$workplan_date_dir_start=$data['workplan_date_dir_start'];
			$workplan_date_dir_end=$data['workplan_date_dir_end'];
			//添加人
			$workplan_manager_name_dir=$data['workplan_manager_name_dir'];
			//完成情况
			$workplan_state_dir=$data['workplan_state_dir'];

			
			//拼接计划日期
			if(!empty($workplan_month_dir_start) && !empty($workplan_month_dir_end)){
				$map=$map." and month>=".strtotime($workplan_month_dir_start)." and month<=".strtotime($workplan_month_dir_end);
			}else if(!empty($train_ontime_dir_start) && empty($workplan_month_dir_end)){
				$map=$map." and month>=".strtotime($workplan_month_dir_start);
			}else if(empty($train_ontime_dir_start) && !empty($workplan_month_dir_end)){
				$map=$map." and month<=".strtotime($workplan_month_dir_end);
			}
			//拼接培训内容
			if(!empty($workplan_content_dir)){
				$map=$map." and content like'%".$workplan_content_dir."%'";
				session('workplan_content_dir',$workplan_content_dir);
			}else{
				session('workplan_content_dir',null);
			}
			//拼接完成日期
			if(!empty($workplan_date_dir_start) && !empty($workplan_date_dir_end)){
				$map=$map." and date>=".strtotime($workplan_date_dir_start)." and date<=".strtotime($workplan_date_dir_end);
			}else if(!empty($train_downtime_dir_start) && empty($workplan_date_dir_end)){
				$map=$map." and date>=".strtotime($workplan_date_dir_start);
			}else if(empty($train_downtime_dir_start) && !empty($workplan_date_dir_end)){
				$map=$map." and date<=".strtotime($workplan_date_dir_end);
			}
			//拼接讲师
			if(!empty($train_lecturer_dir)){
				$map=$map." and lecturer like'%".$train_lecturer_dir."%'";
			}
			//拼接完成情况
			if($workplan_state_dir !=5){
				session('state',$workplan_state_dir);
			}else{
				session('state',5);
			}
			
			if(!empty($workplan_manager_name_dir)){
				$managerlist=$memberModel->where("NAME like '%".$workplan_manager_name_dir."%' and IS_ENABLE=1")->select();
				if(!empty($managerlist)){
					foreach($managerlist as $value){
						$str[]=$value['id'];
					}
					$manager_id=implode(',',$str);
					$map=$map." and manager_id in (".$manager_id.")";
				}
				session('workplan_manager_name_dir',$workplan_manager_name_dir);
			}else{
				session('workplan_manager_name_dir',null);
			}
			session('map',$map);
			
		}else if(IS_GET){
			if(!empty($_GET)){
				$state=I('get.state');
				session('state',$state);
				$dept=I('get.dept');
				session('dept',$dept);
			}else{
				session('state',0);
				session('map',null);
				$dept=session('dept');
				if(empty($dept)){
					$dept=session('dept_id');
				}
				session('dept',$dept);
			}
			
		}
		$dept_id=session('dept');
		//获取部门树，左侧菜单
		//公司
		$company=$unitModel->where("TYPE='Account' and IS_GROUP=0")->field("ID,NAME,PATH,SORT_ID")->find();
		//部门
		$deptside=$unitModel->where("IS_ENABLE=1 and TYPE='Department'")->order("SORT_ID asc")->field("ID,NAME,PATH,SORT_ID")->select();
		$pathlen=strlen($company['path']);
		
		foreach($deptside as $key=>$value){
			$deptside[$key]['path']=substr($value['path'],$pathlen);
		}
		//格式化部门结构-树形结构
		$utils=new \lib\Utils();
		//部门树
		$deptlist=$utils->getdeptList($deptside);
		//公司树
		$company['son']=$deptlist;
		//得到该部门下的部门ID
		$deptinfo=$utils->getdeptinfo($company,$dept_id);
		$deptinfolist=$utils->getdeptone($deptinfo);
		$deptidlist=$utils->getTreeID($deptinfo);
		$deptsonstr=implode(",", $deptidlist);
		
		$strtime=strtotime(date('Y-m',time()));
		$newnumber=$model->where('dept_id='.$dept_id.' and month='.$strtime)->max('number')+1;
		//拼接查询条件
		
		$state=session('state');
		if($state==5){
			$state="state =0";
		}else{
			$state="state =".$state;
		}
		$map=session('map');
		
		$count=$model->where($state.' and dept_id in ('.$deptsonstr.')'.$map)->count();
		//$Page=new \Org\Nx\Page($count,10);
		//$show=$Page->show();
		
		//日常工作计划未完成
		//$changelist=$model->where($state.' and dept_id in ('.$deptsonstr.')'.$map)->order('dept_id asc , month desc , number asc')->limit($Page->firstRow.','.$Page->listRows)->select();
		//日常工作计划未完成
		$changelist=$model->where($state.' and dept_id in ('.$deptsonstr.')'.$map)->order('manager_id asc ,dept_id asc ,  month desc , number asc')->select();
		
		//计划完成率
		//已完成计划条数
		$successnumber=$model->where('state =1 and dept_id in ('.$deptsonstr.')')->count();
		//总计划条数
		$totalnumber=$model->where('state !=3 and dept_id in ('.$deptsonstr.')')->count();
		//计划完成率
		$successrate=round(($successnumber/$totalnumber)*100,2);
		$workplan=new \lib\Workplan();
		//得到日常工作计划列表
		$changelist=$workplan->changeFiled($changelist);
		
		//获取该部门的所有人员
		$managerlist=$memberModel->where('ORG_DEPARTMENT_ID in('.$deptsonstr.') and IS_ENABLE=1')->field('ID,NAME')->select();
		
		$state=array(array('id'=>0,'value'=>'未完成'),array('id'=>3,'value'=>'持续'),array('id'=>1,'value'=>'已完成'),array('id'=>2,'value'=>'暂停或取消'));
		$this->assign('pagetitle','计划管理');
		$this->assign('successrate',$successrate);
		$this->assign('company',$company);
		$this->assign('changelist',$changelist);
		$this->assign('deptinfolist',$deptinfolist);
		$this->assign('managerlist',$managerlist);
		$this->assign('newnumber',$newnumber);
		$this->assign('state',$state);
		$this->assign('page',$show);
		$zero=$model->where('state= 0'.' and dept_id in ('.$deptsonstr.')'.$map)->count();
		$this->assign('zero',$zero);
		$one=$model->where('state= 1'.' and dept_id in ('.$deptsonstr.')'.$map)->count();
		$this->assign('one',$one);
		$two=$model->where('state= 2'.' and dept_id in ('.$deptsonstr.')'.$map)->count();
		$this->assign('two',$two);
		$three=$model->where('state= 3'.' and dept_id in ('.$deptsonstr.')'.$map)->count();
		$this->assign('three',$three);
		$this->display();
    }
	public function getmanager(){
		$model=D('Workplan');
		if(IS_GET){
			$dept_id=I('get.dept_id');
			$month=I('get.month');
			//OA人员信息表
			$memberModel=M('member','org_','OA');
			//OA部门信息表
			$unitModel=M('unit','org_','OA');
			//公司
			$company=$unitModel->where("TYPE='Account' and IS_GROUP=0")->field("ID,NAME,PATH,SORT_ID")->find();
			//部门
			$deptside=$unitModel->where("IS_ENABLE=1 and TYPE='Department'")->order("SORT_ID asc")->field("ID,NAME,PATH,SORT_ID")->select();
			$pathlen=strlen($company['path']);
			
			foreach($deptside as $key=>$value){
				$deptside[$key]['path']=substr($value['path'],$pathlen);
			}
			//格式化部门结构-树形结构
			$utils=new \lib\Utils();
			//部门树
			$deptlist=$utils->getdeptList($deptside);
			//公司树
			$company['son']=$deptlist;
			//得到该部门下的部门ID
			$deptinfo=$utils->getdeptinfo($company,$dept_id);
			$deptinfolist=$utils->getdeptone($deptinfo);
			$deptidlist=$utils->getTreeID($deptinfo);
			$deptsonstr=implode(",", $deptidlist);
			//获取该部门的所有人员
			$managerlist=$memberModel->where('ORG_DEPARTMENT_ID in('.$deptsonstr.') and IS_ENABLE=1')->field('ID,NAME')->select();
			$number=$model->where("dept_id='%s' and month=%d",$dept_id,strtotime($month))->max('number');
			session('number',$number+1);
			$this->ajaxReturn(array(
					'state'=>'ok',
					'info' => '',
					'data'=>$managerlist
					));
		}
		
	}
	public function getnumber(){
		$number=session('number');
		$this->ajaxReturn(array(
				'state'=>'ok',
				'info' => '',
				'data'=>$number
				));
		
		
	}
	public function add(){
		$model=D('Workplan');
		if(IS_POST){
			$data=array();
			$data=I('post.');
			$data['month']=strtotime($data['month']);
			$data['manager_add']=session('manager_id');
			//添加时间
			$data['add_time']=time();
			$flaga=$model->where("content='%s'",$data['content'])->find();
			if($flaga){
				$this->ajaxReturn(array(
					'state'=>'error',
					'info' => '该工作计划已存在！'
				));
			}else{
				if (!$model->create($data)){ // 创建数据对象
					// 如果创建失败 表示验证没有通过 输出错误提示信息
					exit($model->getError());
				}else{
					// 验证通过 写入新增数据
					$flagb=$model->add();
					if($flagb){
						session('add_workplan_dept_id',$data['dept_id']);
						$month=date('Y-m',$data['month']);
						session('add_workplan_month',$month);
						session('add_workplan_number',$data['number']);
						session('add_workplan_content',$data['content']);
						session('add_workplan_resource',$data['resource']);
						session('add_workplan_date',$data['date']);
						session('add_workplan_manager_id',$data['manager_id']);
						session('add_workplan_state',$data['state']);
						session('add_workplan_remarks',$data['remarks']);
						$this->ajaxReturn(array(
							'state'=>'ok',
							'info' => '工作计划添加成功！'
						));
					}else{
						$this->ajaxReturn(array(
							'state'=>'error',
							'info' => '工作计划添加失败！'
						));
					}
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
		$model=D('Workplan');
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
				$result['month']=date('Y-m',$result['month']);
				$this->ajaxReturn(array(
					'state'=>'ok',
					'info' => '',
					'data'=>$result
					));
			}
		}else{
			$id=I('post.id');
			$data=array();
			$data['dept_id']=I('post.dept_id');
			$data['month']=strtotime(I('post.month'));
			$data['number']=I('post.number');
			$data['content']=I('post.content');
			$data['resource']=I('post.resource');
			$data['date']=I('post.date');
			$data['state']=I('post.state');
			$data['manager_id']=I('post.manager_id');
			$data['remarks']=I('post.remarks');
			$flaga=$model->where("content='%s' and id!=%d",$data['content'],$id)->find();
			if($flaga){
				$this->ajaxReturn(array(
					'state'=>'error',
					'info' => '该工作计划已存在！'
				));
			}else{
				$flagb=$model->where('id=%d',$id)->save($data);
				if($flagb!==false){
					$idinfo=$model->where('id=%d',$id)->relation(true)->select();
					$workplan=new \lib\Workplan();
					//得到日常工作计划列表
					$idinfo=$workplan->changeFiled($idinfo);
					$idinfo=$idinfo[0];
					$this->ajaxReturn(array(
						'state'=>'ok',
						'info' => '工作计划修改成功！',
						'data'=>$idinfo
					));
				}else{
					$this->ajaxReturn(array(
						'state'=>'error',
						'info' => '工作计划修改失败！'
					));
				}
			}
			
		}
	}
	
	public function del($id=''){
		$model=D('Workplan');
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
					'info' => '工作计划删除成功！'
				));
			}else{
				$this->ajaxReturn(array(
					'state'=>'error',
					'info' => '工作计划删除失败！'
				));
			}
			
		}
	}
	public function exportExcel(){
		$xlsTitle = iconv('utf-8', 'gb2312', '工作计划');//文件名称
		$expCellName  = array(
		array('dept_name','编号'),
		array('content','计划内容'),
		array('resource','需要资源'),
		array('date','计划完成时间'),
		array('manager_id','负责人'),
		array('state','完成情况'),
		array('remarks','备注'),
		array('manager_add','添加人')
		);
		$cellNum = count($expCellName);//多少列
		//$dataNum = count($expTableData);//多少行
		vendor("PHPExcel.PHPExcel");
			
		$objPHPExcel = new \PHPExcel();//实例化PHPExcel类
		$cellName = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ');
		
		//'A','B','C','D','E','F','G','H','I'
		for($i=0;$i<8;$i++){
			$objPHPExcel->getActiveSheet(0)->setCellValue($cellName[$i].'1', $expCellName[$i][1]);//设置表头值
		}
		
		//生成数据列表
		$model=D('Workplan');
		
		//拼接查询条件
		$state=session('state');
		if($state==5){
			$state="state in(0,1,2,3)";
		}else{
			$state="state =".$state;
		}
		
		$map=session('map');
		$dept_id=session('dept');
		//OA人员信息表
		$memberModel=M('member','org_','OA');
		//OA部门信息表
		$unitModel=M('unit','org_','OA');
		//公司
		$company=$unitModel->where("TYPE='Account' and IS_GROUP=0")->field("ID,NAME,PATH,SORT_ID")->find();
		//部门
		$deptside=$unitModel->where("IS_ENABLE=1 and TYPE='Department'")->order("SORT_ID asc")->field("ID,NAME,PATH,SORT_ID")->select();
		$pathlen=strlen($company['path']);
		
		foreach($deptside as $key=>$value){
			$deptside[$key]['path']=substr($value['path'],$pathlen);
		}
		//格式化部门结构-树形结构
		$utils=new \lib\Utils();
		//部门树
		$deptlist=$utils->getdeptList($deptside);
		//公司树
		$company['son']=$deptlist;
		//得到该部门下的部门ID
		$deptinfo=$utils->getdeptinfo($company,$dept_id);
		$deptinfolist=$utils->getdeptone($deptinfo);
		$deptidlist=$utils->getTreeID($deptinfo);
		$deptsonstr=implode(",", $deptidlist);
		$datalist=$model->where($state.' and dept_id in('.$deptsonstr.') '.$map)->order('month desc , dept_id asc , number asc')->select();
		foreach($datalist as $key=>$value){
			$value['dept_name']=$unitModel->where("ID='%s'",$value['dept_id'])->getField("NAME");
			$month=date('m',$value['month']);
			$datalist[$key]['dept_name']=$value['dept_name'].$month.'-'.$value['number'];
			switch($value['state']){
				case 0:
					$datalist[$key]['state']='未完成';
					break;
				case 1:
					$datalist[$key]['state']='已完成';
					break;
				case 2:
					$datalist[$key]['state']='暂停或取消';
					break;
				case 3:
					$datalist[$key]['state']='持续';
					break;
			}
			$value['manager_id']=$memberModel->where("ID='%s'",$value['manager_id'])->getField('NAME');
			$value['manager_add']=$memberModel->where("ID='%s'",$value['manager_add'])->getField('NAME');
			$datalist[$key]['manager_id']=$value['manager_id'];
			$datalist[$key]['manager_add']=$value['manager_add'];
			
		}
		$resultcount=count($datalist);
		//设置表内容    
		for($i=0;$i<$resultcount;$i++){
			for($j=0;$j<$cellNum;$j++){
				$objPHPExcel->getActiveSheet(0)->setCellValue($cellName[$j].($i+2), $datalist[$i][$expCellName[$j][0]]);
			}             
		}
		
		$objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		
		header("Content-type: text/csv");//重要
		header('pragma:public');
		header('Content-Type: application/vnd.ms-excel');//告诉浏览器将要输出excel03文件
		header('Content-Disposition:attachment;filename="'.$xlsTitle.'.xls"');//告诉浏览器将输出文件的名称
        header('Cache-Control: max-age=0');//禁止缓存
		$objWriter->save('php://output');
		exit;
	}
	
}
?>