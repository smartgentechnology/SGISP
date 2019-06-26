<?php
namespace Home\Controller;
use Common\Controller\AuthController;

class TrainjsonController{

    public function index(){
		$model=D('Train');
		//OA人员信息表
		$memberModel=M('member','org_','OA');
		//OA部门信息表
		$unitModel=M('unit','org_','OA');
		$strtime=date('n',time());
		switch($strtime){
			case 1:
			case 2:
			case 3:
				$quarter=1;
				break;
			case 4:
			case 5:
			case 6:
				$quarter=2;
				break;
			case 7:
			case 8:
			case 9:
				$quarter=3;
				break;
			case 10:
			case 11:
			case 12:
				$quarter=4;
				break;

		}
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
		$dept_id=session('dept_id');
		$newnumber=$model->where("dept_id='%s' and quarter=%d",$dept_id,$quarter)->max('number')+1;
		if(IS_POST){
			$data=I('post.');
			//得到查询条件
			//部门
			$train_dept_id_dir=$data['train_dept_id_dir'];
			//计划日期
			$train_ontime_dir_start=$data['train_ontime_dir_start'];
			$train_ontime_dir_end=$data['train_ontime_dir_end'];
			//完成日期
			$train_downtime_dir_start=$data['train_downtime_dir_start'];
			$train_downtime_dir_end=$data['train_downtime_dir_end'];
			//培训内容
			$train_content_dir=$data['train_content_dir'];
			//讲师
			$train_lecturer_dir=$data['train_lecturer_dir'];
			//添加人
			$train_manager_name_dir=$data['train_manager_name_dir'];
			//拼接部门
			if(!empty($train_dept_id_dir)){
				//得到该部门下的部门ID
				$deptinfo=$utils->getdeptinfo($company,$train_dept_id_dir);
				$deptidlist=$utils->getTreeID($deptinfo);
				$deptstr=implode(",", $deptidlist);
				$map=$map." and dept_id in(".$deptstr.")";
			}
			//拼接计划日期
			if(!empty($train_ontime_dir_start) && !empty($train_ontime_dir_end)){
				$map=$map." and ontime>=".strtotime($train_ontime_dir_start)." and ontime<=".strtotime($train_ontime_dir_end);
			}else if(!empty($train_ontime_dir_start) && empty($train_ontime_dir_end)){
				$map=$map." and ontime>=".strtotime($train_ontime_dir_start);
			}else if(empty($train_ontime_dir_start) && !empty($train_ontime_dir_end)){
				$map=$map." and ontime<=".strtotime($train_ontime_dir_end);
			}
			//拼接完成日期
			if(!empty($train_downtime_dir_start) && !empty($train_downtime_dir_end)){
				$map=$map." and downtime>=".strtotime($train_downtime_dir_start)." and downtime<=".strtotime($train_downtime_dir_end);
			}else if(!empty($train_downtime_dir_start) && empty($train_downtime_dir_end)){
				$map=$map." and downtime>=".strtotime($train_downtime_dir_start);
			}else if(empty($train_downtime_dir_start) && !empty($train_downtime_dir_end)){
				$map=$map." and downtime<=".strtotime($train_downtime_dir_end);
			}
			//拼接培训内容
			if(!empty($train_content_dir)){
				$map=$map." and train_content like'%".$train_content_dir."%'";
				session('train_content_dir',$train_content_dir);
			}else{
				session('train_content_dir',null);
			}
			//拼接讲师
			if(!empty($train_lecturer_dir)){
				$map=$map." and lecturer like'%".$train_lecturer_dir."%'";
				session('train_lecturer_dir',$train_lecturer_dir);
			}else{
				session('train_lecturer_dir',null);
			}

			if(!empty($train_manager_name_dir)){
				$managerlist=$memberModel->where("NAME like '%".$train_manager_name_dir."%' and IS_ENABLE=1")->select();
				if(!empty($managerlist)){
					foreach($managerlist as $value){
						$str[]=$value['id'];
					}
					$manager_id=implode(',',$str);
					$map=$map." and manager_id in (".$manager_id.")";
				}
				session('train_manager_name_dir',$train_manager_name_dir);
			}else{
				session('train_manager_name_dir',null);
			}
			session('dir_train_dept_id',$train_dept_id_dir);
			session('map',$map);
			session('flag',0);
		}else if(IS_GET){
			if(!empty($_GET)){
				$flag=I('get.flag');
				session('flag',$flag);
			}else{
				session('flag',0);
				session('map',null);
			}

		}
		$flag=session('flag');
		$map=session('map');
		$flag="flag =".$flag;
		$count=$model->where($flag.$map)->count();
		$Page=new \Org\Nx\Page($count,10);
		$show=$Page->show();
		//生成数据列表
		$datalist=$model->where($flag.$map)->order('dept_id asc , number asc , quarter desc')->limit($Page->firstRow.','.$Page->listRows)->select();
		$datalist=$utils->changeFiled($datalist);
		$datalist=$utils->changeDateOne($datalist);
		$datalist=$utils->changeTime($datalist);
		//得到该部门下的部门ID
		$deptinfo=$utils->getdeptinfo($company,$company['id']);
		$deptinfolist=$utils->getdeptone($deptinfo);

		$this->assign('datalist',$datalist);
		$this->assign('pagetitle','培训计划表');
		$this->assign('deptinfolist',$deptinfolist);
		$this->assign('page',$show);
		$this->assign('newnumber',$newnumber);
		$this->assign('flag',$flag);
		$this->assign('map',$map);
		$zero=$model->where('flag= 0'.$map)->count();
		$this->assign('zero',$zero);
		$one=$model->where('flag= 1'.$map)->count();
		$this->assign('one',$one);
		$two=$model->where('flag= 2'.$map)->count();
		$this->assign('two',$two);
		$this->display();
    }
	public function getnumber(){
		$model=D('Train');
		if(IS_GET){
			$dept_id=I('get.dept_id');
			$month=I('get.month');
			$id=I('get.id');
			$strtime=date('n',strtotime($month));
			switch($strtime){
				case 1:
				case 2:
				case 3:
					$quarter=1;
					break;
				case 4:
				case 5:
				case 6:
					$quarter=2;
					break;
				case 7:
				case 8:
				case 9:
					$quarter=3;
					break;
				case 10:
				case 11:
				case 12:
					$quarter=4;
					break;

			}
			if(empty($id)){
				$number=$model->where("dept_id='%s' and quarter=%d",$dept_id,$quarter)->max('number')+1;
			}else{
				$plan=$model->where('id=%d',$id)->find();
				if($plan['dept_id']==$dept_id && $plan['quarter']==$quarter){
					$number=$plan['number'];
				}else{
					$number=$model->where("dept_id='%s' and quarter=%d",$dept_id,$quarter)->max('number')+1;
				}
			}
			$this->ajaxReturn(array(
				'state'=>'ok',
				'info' => '',
				'data'=>$number
			));
		}
	}
	public function add(){
		$model=D('Train');
		if(IS_POST){
			$data=array();
			$data['dept_id']=I('post.train_dept_id_a');
			$data['number']=I('post.train_number_a');
			$data['train_content']=I('post.train_content_a');
			$data['train_people']=I('post.train_people_a');
			$data['lecturer']=I('post.train_lecturer_a');
			$data['remark']=I('post.train_remark_a');
			$data['flag']=I('post.train_flag_a');
			//转变时间格式
			$data['ontime']=strtotime(I('post.train_ontime_a'));
			$strtime=date('n',$data['ontime']);
			switch($strtime){
				case 1:
				case 2:
				case 3:
					$data['quarter']=1;
					break;
				case 4:
				case 5:
				case 6:
					$data['quarter']=2;
					break;
				case 7:
				case 8:
				case 9:
					$data['quarter']=3;
					break;
				case 10:
				case 11:
				case 12:
					$data['quarter']=4;
					break;

			}
			$data['manager_id']=session('manager_id');
			$data['add_time']=time();
			$flaga=$model->where("train_content='%s'",$data['train_content'])->find();
			if($flaga){
				$this->ajaxReturn(array(
					'state'=>'error',
					'info' => '该培训内容已存在！'
				));
			}else{

				if (!$model->create($data)){ // 创建数据对象
					// 如果创建失败 表示验证没有通过 输出错误提示信息
					exit($model->getError());
				}else{
					// 验证通过 写入新增数据
					$flagb=$model->add();
					if($flagb){
						$this->ajaxReturn(array(
							'state'=>'ok',
							'info' => '培训计划添加成功'
						));
					}else{
						$this->ajaxReturn(array(
							'state'=>'error',
							'info' => '培训计划添加失败！'
						));
					}
				}

			}

		}else{
			$this->ajaxReturn(array(
				'state'=>'ok',
				'info' => 'ADD方法'
			));
		}
	}

	public function edit(){
		$model=D('Train');
		if(IS_GET){
			$id=I('get.id');
			if(empty($id)){
				$this->ajaxReturn(array(
					'state'=>'error',
					'info' => '请至少选择一条记录！'
					));
			}else{
				//$id=substr($id,0,-1);
				$result=$model->where('id=%d',$id)->find();
				$result['ontime']=date('Y-m-d',$result['ontime']);
				$manager_id=session('manager_id');
				$result_id=$result['manager_id'];
				if($result['downtime']!=NULL){
					$this->ajaxReturn(array(
					'state'=>'error',
					'info' => '已完成不能修改！'
					));
				}
				if($manager_id!=$result_id){
					$this->ajaxReturn(array(
					'state'=>'error',
					'info' => '不能修改别人的东西哦！'
					));
				}else{
					$this->ajaxReturn(array(
					'state'=>'ok',
					'info' => '',
					'data'=>$result
					));
				}
			}
		}else{
			$id=I('post.train_id_e');
			$data=array();
			$data['dept_id']=I('post.train_dept_id_e');
			$data['number']=I('post.train_number_e');
			$data['train_content']=I('post.train_content_e');
			$data['train_people']=I('post.train_people_e');
			$data['lecturer']=I('post.train_lecturer_e');
			$data['remark']=I('post.train_remark_e');
			$data['flag']=I('post.train_flag_e');
			$data['ontime']=strtotime(I('post.train_ontime_e'));
			$strtime=date('n',$data['ontime']);
			switch($strtime){
				case 1:
				case 2:
				case 3:
					$data['quarter']=1;
					break;
				case 4:
				case 5:
				case 6:
					$data['quarter']=2;
					break;
				case 7:
				case 8:
				case 9:
					$data['quarter']=3;
					break;
				case 10:
				case 11:
				case 12:
					$data['quarter']=4;
					break;

			}

			$flaga=$model->where("train_content='%s' and id!=%d",$data['train_content'],$id)->find();
			if($flaga){
				$this->ajaxReturn(array(
					'state'=>'error',
					'info' => '该培训内容已存在！'
				));
			}
			if (!$model->create($data)){ // 创建数据对象
				// 如果创建失败 表示验证没有通过 输出错误提示信息
				exit($model->getError());
			}else{
				$flagb=$model->where('id=%d',$id)->save();
				if($flagb!==false){
					$this->ajaxReturn(array(
						'state'=>'ok',
						'info' => '培训计划修改成功！'
					));
				}else{
					$this->ajaxReturn(array(
						'state'=>'error',
						'info' => '培训计划修改失败！'
					));
				}
			}
		}
	}
	public function com(){
		$model=D('Train');
		if(IS_GET){
			$id=I('get.id');
			if(empty($id)){
				$this->ajaxReturn(array(
					'state'=>'error',
					'info' => '请至少选择一条记录！'
					));
			}else{
				//$id=substr($id,0,-1);
				$result=$model->where('id=%d',$id)->find();
				$manager_id=session('manager_id');
				$result_id=$result['manager_id'];
				if($result['downtime']!=NULL){
					$this->ajaxReturn(array(
					'state'=>'error',
					'info' => '已完成不能修改！'
					));
				}
				if($manager_id!=$result_id){
					$this->ajaxReturn(array(
					'state'=>'error',
					'info' => '不能修改别人的东西哦！'
					));
				}else{
				$this->ajaxReturn(array(
					'state'=>'ok',
					'info' => '',
					'data'=>$result
					));
				}
			}
		}else{
			$id=I('post.train_id_end');
			$data=array();
			$data['downtime']=strtotime(I('post.train_downtime_e'));
			$data['hours']=I('post.train_hours_e');
			$data['flag']=1;
			//上传培训图片
			if($_FILES['train_img_e']['error']!=4){
				// 实例化上传类
				$upload = new \Think\Upload();
				// 设置附件上传大小
				$upload->maxSize = 104857600 ;
				// 设置附件上传类型
				$upload->exts = array('jpg', 'gif', 'png', 'jpeg');
				// 设置附件上传根目录
				$upload->rootPath = 'Public/data/trainimg/';

				$info=array();
				foreach ($_FILES['train_img_e']['name'] as $key=>$value){
					$file1=array();
					$file1["train_img_e"]['name']=$value;
					$file1["train_img_e"]['type']=$_FILES['train_img_e']["type"][$key];
					$file1["train_img_e"]['tmp_name']=$_FILES['train_img_e']["tmp_name"][$key];
					$file1["train_img_e"]['error']=$_FILES['train_img_e']["error"][$key];
					$file1["train_img_e"]['size']=$_FILES['train_img_e']["size"][$key];
					$info[]=$upload->upload($file1);
				}
				if(!$info) {
					$this->ajaxReturn(array(
							'state'=>'error',
							'info' => $upload->getError()
						));
				}else{
					// 上传成功 获取上传文件信息
					$arr=array();
					foreach($info as $file){
						$arr[]='data/trainimg/'.$file['train_img_e']['savepath'].$file['train_img_e']['savename'];
					}

					$data['img']=implode(',',$arr);
				}
			}
			//上传课件文件
			if($_FILES['train_courseware_e']['error']!=4){
				// 实例化上传类
				$upload = new \Think\Upload();
				// 设置附件上传大小
				$upload->maxSize = 104857600 ;
				// 设置附件上传类型
				$upload->exts = array('jpg', 'gif', 'png', 'jpeg','rar','zip','pdf','doc','docx','xls','xlsx','ppt','pptx','txt');
				// 设置附件上传根目录
				$upload->rootPath = 'Public/data/train/';
				// 上传文件
				$info = $upload->upload();
				if(!$info) {
					$this->ajaxReturn(array(
							'state'=>'error',
							'info' => $upload->getError()
						));
				}else{
					// 上传成功 获取上传文件信息
					foreach($info as $file){
						$data['courseware']='data/train/'.$file['savepath'].$file['savename'];
					}
				}
			}
			if (!$model->create($data)){ // 创建数据对象
				// 如果创建失败 表示验证没有通过 输出错误提示信息
				exit($model->getError());
			}else{
				$flagb=$model->where('id=%d',$id)->save();
				if($flagb!==false){
					$this->ajaxReturn(array(
						'state'=>'ok',
						'info' => '培训计划修改成功！'
					));
				}else{
					$this->ajaxReturn(array(
						'state'=>'error',
						'info' => '培训计划修改失败！'
					));
				}
			}



		}
	}
	public function hr(){
		$model=D('Train');
		if(IS_GET){
			$id=I('get.id');
			if(empty($id)){
				$this->ajaxReturn(array(
					'state'=>'error',
					'info' => '请至少选择一条记录！'
					));
			}else{
				//$id=substr($id,0,-1);
				$result=$model->where('id=%d',$id)->find();

				$this->ajaxReturn(array(
					'state'=>'ok',
					'info' => '',
					'data'=>$result
					));
			}
		}else{
			$id=I('post.id');
			$data=array();
			$data['checkcontent']=I('post.checkcontent');
			$data['money']=I('post.money');
			if (!$model->create($data)){ // 创建数据对象
				// 如果创建失败 表示验证没有通过 输出错误提示信息
				exit($model->getError());
			}else{
				$flagb=$model->where('id=%d',$id)->save();
				if($flagb!==false){
					$this->ajaxReturn(array(
						'state'=>'ok',
						'info' => '培训计划修改成功！'
					));
				}else{
					$this->ajaxReturn(array(
						'state'=>'error',
						'info' => '培训计划修改失败！'
					));
				}
			}



		}
	}

	public function del($id=''){
		$model=D('Train');
		if(empty($id)){
			$this->ajaxReturn(array(
				'state'=>'error',
				'info' => '请至少选择一条记录！'
				));
		}else{
			$id=substr($id,0,-1);
			$result=$model->where('id in (%s)',$id)->select();
			$manager_id=session('manager_id');
			foreach($result as $value){

				if($value['manager_id']!=$manager_id){
					$this->ajaxReturn(array(
					'state'=>'error',
					'info' => '不能删除别人的东西哦！'
					));
				}
			}
			$flagb=$model->where('id in (%s)',$id)->delete();
			if($flagb){
				$this->ajaxReturn(array(
					'state'=>'ok',
					'info' => '培训计划删除成功！'
				));
			}else{
				$this->ajaxReturn(array(
					'state'=>'error',
					'info' => '培训计划删除失败！'
				));
			}

		}
	}
	public function exportExcel(){
		$xlsTitle = iconv('utf-8', 'gb2312', 'peixunjilu');//文件名称
		$expCellName  = array(
		array('dept_name','部门'),
		array('ontime','培训计划日期'),
		array('downtime','完成日期'),
		array('train_content','培训主题或内容'),
		array('train_people','培训对象'),
		array('lecturer','培训讲师'),
		array('remark','变更或其他说明'),
		array('manager_name','添加人'),
		array('checkcontent','人事稽核')
		);


		$cellNum = count($expCellName);//多少列
		//$dataNum = count($expTableData);//多少行
		vendor("PHPExcel.PHPExcel");

		$objPHPExcel = new \PHPExcel();//实例化PHPExcel类
		$cellName = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ');

		//'A','B','C','D','E','F','G','H','I'
		for($i=0;$i<9;$i++){
			$objPHPExcel->getActiveSheet(0)->setCellValue($cellName[$i].'1', $expCellName[$i][1]);//设置表头值
		}

		//生成数据列表
		$model=D('Train');
		$map=session('map');
		//OA人员信息表
		$memberModel=M('member','org_','OA');
		//OA部门信息表
		$unitModel=M('unit','org_','OA');
		$datalist=$model->where('flag !=2'.$map)->order('quarter desc , dept_id asc , number asc')->select();
		foreach($datalist as $key=>$value){
			$datalist[$key]['manager_name']=$memberModel->where("ID='%s'",$value['manager_id'])->getField('NAME');
			$datalist[$key]['dept_name']=$unitModel->where("ID='%s'",$value['dept_id'])->getField('NAME');
		}
		//调用工具类
		$utils=new \lib\Utils();
		$datalist=$utils->changeDateOne($datalist);
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
