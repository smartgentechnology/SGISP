<?php
namespace Home\Controller;
use Common\Controller\AuthController;
class ZichanController extends AuthController {
	
    public function index(){
		$model=D('Zichan');
		//OA人员信息表
		$memberModel=M('member','org_','OA');
		//OA部门信息表
		$unitModel=M('unit','org_','OA');
		//得到用户自定义栏目框
		$manager_id=session('manager_id');
		$columnset=D('Columnset');
		$column=D('Column');
		$columnsetlist=$columnset->where("manager_id='%s' and module=2",$manager_id)->order("rank asc, id asc")->select();
		$columnlist=array();
		$namelist=array();
		$fieldlist=array();
		if(empty($columnsetlist)){
			$columnlist=$column->where("module=2")->order("rank asc")->field("name,field,width")->select();
		}else{
			foreach($columnsetlist as $key=>$value){
				$temp=array();
				$temp=$column->where("id=%d",$value['columnid'])->field("name,field,width")->find();
				$columnlist[]=$temp;
			}
		}
		$width=0;
		foreach($columnlist as $value){
			$arr=array();
			$arr['name']=$value['name'];
			$arr['width']=$value['width'];
			$width+=$value['width'];
			$namelist[]=$arr;
			$fieldlist[]=$value["field"];
		}
		$strfield = implode(",",$fieldlist);
		if(IS_POST){
			$data=I('post.');
			//得到查询条件
			
			//设备类型
			$zichan_leixing_dir=$data['zichan_leixing_dir'];
			//编码
			$zichan_bianma_dir=$data['zichan_bianma_dir'];
			//编码修订
			$zichan_bianmaxiuding_dir=$data['zichan_bianmaxiuding_dir'];
			//名称
			$zichan_mingcheng_dir=$data['zichan_mingcheng_dir'];
			//名称修订
			$zichan_mingchengxiuding_dir=$data['zichan_mingchengxiuding_dir'];
			//设备类型
			$zichan_leibie_dir=$data['zichan_leibie_dir'];
			//型号
			$zichan_xinghao_dir=$data['zichan_xinghao_dir'];
			//入账日期
			$zichan_ruriqi_start=$data['zichan_ruriqi_start'];
			$zichan_ruriqi_end=$data['zichan_ruriqi_end'];
			//U8备注
			$zichan_beizhu_dir=$data['zichan_beizhu_dir'];
			//备注
			$zichan_remark_dir=$data['zichan_remark_dir'];
			//负责人
			$zichan_fuzeren_dir=$data['zichan_fuzeren_dir'];
			//状态
			$zichan_zhuangtai_dir=$data['zichan_zhuangtai_dir'];
			//拼接完成情况
			if($zichan_zhuangtai_dir !=5){
				session('zhuangtai',$zichan_zhuangtai_dir);
			}else{
				session('zhuangtai',5);
			}
			$map="";
			//设备类型
			if($zichan_leixing_dir !=10){
				$map=$map."and leixing =".$zichan_leixing_dir;
			}
			//编码
			if(!empty($zichan_bianma_dir)){
				$map=$map." and bianma like'%".$zichan_bianma_dir."%'";
			}
			//编码修订
			if(!empty($zichan_bianmaxiuding_dir)){
				$map=$map." and bianmaxiuding like'%".$zichan_bianma_dir."%'";
			}
			//名称
			if(!empty($zichan_mingcheng_dir) ){
				$map=$map." and mingcheng like'%".$zichan_mingcheng_dir."%'";
			}
			//名称修订
			if(!empty($zichan_mingchengxiuding_dir)){
				$map=$map." and mingchengxiuding like'%".$zichan_mingchengxiuding_dir."%'";
			}
			//类别
			if($zichan_leibie_dir!=10){
				$map=$map." and leibie =".$zichan_leibie_dir;
			}
			//型号
			if(!empty($zichan_xinghao_dir)){
				$map=$map." and xinghao like'%".$zichan_xinghao_dir."%'";
			}
			//入账日期
			if(!empty($zichan_ruriqi_start) && !empty($zichan_ruriqi_end)){
				$map=$map." and ruriqi>=".strtotime($zichan_ruriqi_start)." and ruriqi<=".strtotime($zichan_ruriqi_end);
			}elseif(!empty($zichan_ruriqi_start) && empty($zichan_ruriqi_end)){
				$map=$map." and ruriqi>=".strtotime($zichan_ruriqi_start);
			}elseif(empty($zichan_ruriqi_start) && !empty($zichan_ruriqi_end)){
				$map=$map." and ruriqi<=".strtotime($zichan_ruriqi_end);
			}
			
			//U8备注zichan_beizhu_dir
			if(!empty($zichan_beizhu_dir)){
				$map=$map." and beizhu like'%".$zichan_beizhu_dir."%'";
			}
			//备注
			if(!empty($zichan_remark_dir)){
				$map=$map." and remark like'%".$zichan_remark_dir."%'";
			}
			//负责人
			if($zichan_fuzeren_dir !=0){
				$map=$map." and fuzeren =".$zichan_fuzeren_dir;
			}
			session('map',$map);
		}else if(IS_GET){
			if(!empty($_GET)){
				$zhaungtai='';
				$zhuangtai=I('get.zhuangtai');
				if($zhuangtai==''){
					$zhuangtai=session('zhuangtai');
					if(!empty($zhuangtai)){
						session('zhuangtai',$zhuangtai);
					}else{
						session('zhuangtai',0);
					}
				}else{
					session('zhuangtai',$zhuangtai);
				}
				$dept=I('get.dept');
				if(empty($dept)){
					$dept=session('dept');
					session('dept',$dept);
				}else{
					session('dept',$dept);
				}
				
			}else{
				session('zhuangtai',0);
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
		
		//拼接查询条件
		$zhuangtai=session('zhuangtai');
		if($zhuangtai==5){
			$zhuangtai="zhuangtai=0";
		}else{
			$zhuangtai="zhuangtai=".$zhuangtai;
		}
		$map=session('map');
		
		$count=$model->where($zhuangtai.' and bumen in ('.$deptsonstr.')'.$map)->count();
		$Page=new \Org\Nx\Page($count,10);
		$show=$Page->show();
		
		//日常工作计划未完成
		$changelist=$model->where($zhuangtai.' and bumen in ('.$deptsonstr.')'.$map)->limit($Page->firstRow.','.$Page->listRows)->field("id,".$strfield)->order('daoqiriqi asc,bianma asc')->select();
		$zichan=new \lib\Zichan();
		$changelist=$zichan->changeFiled($changelist);
		
		$zhuangtai=array(array('id'=>0,'value'=>'在用'),array('id'=>1,'value'=>'闲置'),array('id'=>2,'value'=>'报废'),array('id'=>3,'value'=>'删除'));
		$leixing=array(array('id'=>0,'value'=>'固定资产'),array('id'=>1,'value'=>'100~800设施'),array('id'=>2,'value'=>'一般设备'),array('id'=>3,'value'=>'关键设备'),array('id'=>4,'value'=>'工具设备'),array('id'=>5,'value'=>'生产过程工具'),array('id'=>6,'value'=>'周转设备'));
		$leibie=array(array('id'=>0,'value'=>'办公设备'),array('id'=>1,'value'=>'餐厅用具'),array('id'=>2,'value'=>'交通工具'),array('id'=>3,'value'=>'房屋'),array('id'=>4,'value'=>'监测设备'),array('id'=>5,'value'=>'生产设备'),array('id'=>6,'value'=>'其它'),array('id'=>7,'value'=>'工具'),array('id'=>8,'value'=>'生产过程工装'),array('id'=>9,'value'=>'周转车'));
		$danwei=array(array('id'=>0,'value'=>'台'),array('id'=>1,'value'=>'套'),array('id'=>2,'value'=>'个'),array('id'=>3,'value'=>'把'),array('id'=>4,'value'=>'组'),array('id'=>5,'value'=>'张'),array('id'=>6,'value'=>'栋'),array('id'=>7,'value'=>'次'),array('id'=>8,'value'=>'件'),array('id'=>9,'value'=>'匹'),array('id'=>10,'value'=>'辆'),array('id'=>11,'value'=>'部'),array('id'=>12,'value'=>'块'),array('id'=>13,'value'=>'付'));
		$xiaozhunleixing=array(array('id'=>0,'value'=>'/'),array('id'=>1,'value'=>'内校'),array('id'=>2,'value'=>'外校'));
		//获取该部门的所有人员
		$fuzeren=$memberModel->where("NAME='吕茵' or NAME='易娜'")->field('ID,NAME')->select();
		$this->assign('pagetitle','固定资产');
		$this->assign('zhuangtai',$zhuangtai);
		$this->assign('leixing',$leixing);
		$this->assign('leibie',$leibie);
		$this->assign('danwei',$danwei);
		$this->assign('xiaozhunleixing',$xiaozhunleixing);
		$this->assign('company',$company);
		$this->assign('changelist',$changelist);
		$this->assign('deptinfolist',$deptinfolist);
		$this->assign('namelist',$namelist);
		$this->assign('fieldlist',$fieldlist);
		$this->assign('fuzeren',$fuzeren);
		$this->assign('state',$state);
		$this->assign('width',$width);
		$this->assign('page',$show);
		$zero=$model->where('zhuangtai=0'.' and bumen in ('.$deptsonstr.')'.$map)->count();
		$this->assign('zero',$zero);
		$one=$model->where('zhuangtai=1'.' and bumen in ('.$deptsonstr.')'.$map)->count();
		$this->assign('one',$one);
		$two=$model->where('zhuangtai=2'.' and bumen in ('.$deptsonstr.')'.$map)->count();
		$this->assign('two',$two);
		$three=$model->where('zhuangtai=3'.' and bumen in ('.$deptsonstr.')'.$map)->count();
		$this->assign('three',$three);
		$this->display();
    }
	
	public function add(){
		$model=D('Zichan');
		if(IS_POST){
			$data=array();
			$data=I('post.');
			if(!empty($data['ruriqi'])){
				$data['ruriqi']=strtotime($data['ruriqi']);
			}
			if(!empty($data['shouxiaoriqi'])){
				$data['shouxiaoriqi']=strtotime($data['shouxiaoriqi']);
			}
			if(!empty($data['jianyanriqi'])){
				$data['jianyanriqi']=strtotime($data['jianyanriqi']);
			}
			if(!empty($data['daoqiriqi'])){
				$data['daoqiriqi']=strtotime($data['daoqiriqi']);
			}
			if(!empty($data['jianyanriqi']) && !empty($data['daoqiriqi'])){
				$data['zhouqi']=$data['daoqiriqi']-$data['jianyanriqi'];
			}
			//添加时间
			$data['fuzeren']=session('manager_id');
			//添加时间
			$data['add_time']=time();
			if (!$model->create($data)){ // 创建数据对象
				// 如果创建失败 表示验证没有通过 输出错误提示信息
				exit($model->getError());
			}else{
				// 验证通过 写入新增数据
				$flagb=$model->add();
				if($flagb){
					session('add_zichan_leixing',$data['leixing']);
					session('add_zichan_bianma',$data['bianma']);
					session('add_zichan_bianmaxiuding',$data['bianmaxiuding']);
					session('add_zichan_mingcheng',$data['mingcheng']);
					session('add_zichan_mingchengxiuding',$data['mingchengxiuding']);
					session('add_zichan_leibie',$data['leibie']);
					session('add_zichan_xinghao',$data['xinghao']);
					session('add_zichan_shuliang',$data['shuliang']);
					session('add_zichan_danwei',$data['danwei']);
					//$data['ruriqi']=date('Y-m-d',$data['ruriqi']);
					//session('add_zichan_ruriqi',$data['ruriqi']);
					session('add_zichan_bumen',$data['bumen']);
					session('add_zichan_didian',$data['didian']);
					session('add_zichan_zhuangtai',$data['zhuangtai']);
					session('add_zichan_beizhu',$data['beizhu']);
					session('add_zichan_remark',$data['remark']);
					session('add_zichan_chuchangbianhao',$data['chuchangbianhao']);
					session('add_zichan_changjia',$data['changjia']);
					session('add_zichan_jigou',$data['jigou']);
					session('add_zichan_xiaozhunleixing',$data['xiaozhunleixing']);
					$this->ajaxReturn(array(
						'state'=>'ok',
						'info' => '添加成功！'
					));
				}else{
					$this->ajaxReturn(array(
						'state'=>'error',
						'info' => '添加失败！'
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
		$model=D('Zichan');
		if(IS_GET){
			$id=I('get.id');
			if(empty($id)){
				$this->ajaxReturn(array(
					'state'=>'error',
					'info' => '请至少选择一条记录！'
					));
			}else{
				$id=substr($id,0,-1);
				$data=$model->where('id=%d',$id)->find();
				if(!empty($data['ruriqi'])){
					$data['ruriqi']=date('Y-m-d',$data['ruriqi']);
				}else{
					$data['ruriqi']='';
				}
				if(!empty($data['shouxiaoriqi'])){
					$data['shouxiaoriqi']=date('Y-m-d',$data['shouxiaoriqi']);
				}else{
					$data['shouxiaoriqi']='';
				}
				if(!empty($data['jianyanriqi'])){
					$data['jianyanriqi']=date('Y-m-d',$data['jianyanriqi']);
				}else{
					$data['jianyanriqi']='';
				}
				if(!empty($data['daoqiriqi'])){
					$data['daoqiriqi']=date('Y-m-d',$data['daoqiriqi']);
				}else{
					$data['daoqiriqi']='';
				}
				$this->ajaxReturn(array(
					'state'=>'ok',
					'info' => '',
					'data'=>$data
					));
			}
		}else{
			$id=I('post.id');
			$data=array();
			$data['leixing']=I('post.leixing');
			$data['bianma']=I('post.bianma');
			$data['bianmaxiuding']=I('post.bianmaxiuding');
			$data['mingcheng']=I('post.mingcheng');
			$data['mingchengxiuding']=I('post.mingchengxiuding');
			$data['leibie']=I('post.leibie');
			$data['xinghao']=I('post.xinghao');
			$data['danjia']=I('post.danjia');
			$data['shuliang']=I('post.shuliang');
			$data['ruriqi']=I('post.ruriqi');
			$data['bumen']=I('post.bumen');
			$data['didian']=I('post.didian');
			$data['zhuangtai']=I('post.zhuangtai');
			$data['beizhu']=I('post.beizhu');
			$data['remark']=I('post.remark');
			$data['chuchangbianhao']=I('post.chuchangbianhao');
			$data['changjia']=I('post.changjia');
			$data['shouxiaoriqi']=I('post.shouxiaoriqi');
			$data['jianyanriqi']=I('post.jianyanriqi');
			$data['daoqiriqi']=I('post.daoqiriqi');
			$data['jigou']=I('post.jigou');
			$data['xiaozhunleixing']=I('post.xiaozhunleixing');
			if(!empty($data['ruriqi'])){
				$data['ruriqi']=strtotime($data['ruriqi']);
			}
			if(!empty($data['shouxiaoriqi'])){
				$data['shouxiaoriqi']=strtotime($data['shouxiaoriqi']);
			}
			if(!empty($data['jianyanriqi'])){
				$data['jianyanriqi']=strtotime($data['jianyanriqi']);
			}
			if(!empty($data['daoqiriqi'])){
				$data['daoqiriqi']=strtotime($data['daoqiriqi']);
			}
			if(!empty($data['jianyanriqi']) && !empty($data['daoqiriqi'])){
				$data['zhouqi']=$data['daoqiriqi']-$data['jianyanriqi'];
			}
			$flagb=$model->where('id=%d',$id)->save($data);
			if($flagb){
				$this->ajaxReturn(array(
					'state'=>'ok',
					'info' => '修改成功！'
				));
			}else{
				$this->ajaxReturn(array(
					'state'=>'error',
					'info' => '修改失败！'
				));
			}
			
		}
	}
	
	public function del(){
		$model=D('Zichan');
		$id=I('get.id');
		if(empty($id)){
			$this->ajaxReturn(array(
				'state'=>'error',
				'info' => '请至少选择一条记录！'
				));
		}else{
			$id=substr($id,0,-1);
			$arr=array();
			$arr['zhuangtai']=3;
			$flagb=$model->where('id in (%s)',$id)->save($arr);
			if($flagb){
				$this->ajaxReturn(array(
					'state'=>'ok',
					'info' => '删除成功！'
				));
			}else{
				$this->ajaxReturn(array(
					'state'=>'error',
					'info' => '删除失败！'
				));
			}
			
		}
	}
	
	public function exportExcel(){
		$xlsTitle = iconv('utf-8', 'gb2312', '固定资产');//文件名称
		$expCellName  = array(
		array('leixing','设备类型'),
		array('bianma','编码'),
		array('bianmaxiuding','编码修订'),
		array('mingcheng','名称'),
		array('mingchengxiuding','名称修订'),
		array('leibie','类别'),
		array('xinghao','型号'),
		array('danjia','入库单价'),
		array('shuliang','数量'),
		array('danwei','单位'),
		array('ruriqi','入账日期'),
		array('bumen','部门'),
		array('didian','存放地点'),
		array('zhuangtai','状态'),
		array('beizhu','U8备注'),
		array('remark','备注'),
		array('fuzeren','负责人'),
		array('chuchangbianhao','出厂编号'),
		array('changjia','厂家'),
		array('shouxiaoriqi','首校日期'),
		array('jianyanriqi','检验日期'),
		array('daoqiriqi','到期日期'),
		array('daoqijiange','到期间隔'),
		array('zhouqi','校准周期(年)'),
		array('jigou','校准机构'),
		array('xiaozhunleixing','校准类型')
		);
		$cellNum = count($expCellName);//多少列
		vendor("PHPExcel.PHPExcel");
		
		$objPHPExcel = new \PHPExcel();//实例化PHPExcel类
		$cellName = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
		
		for($i=0;$i<$cellNum;$i++){
			$objPHPExcel->getActiveSheet(0)->setCellValue($cellName[$i].'1', $expCellName[$i][1]);//设置表头值
		}
		
		//生成数据列表
		$model=D('Zichan');
		
		//拼接查询条件
		$zhuangtai=session('zhuangtai');
		if($zhuangtai==5 || empty($zhuangtai)){
			$zhuangtai="zhuangtai in(0,1,2,3)";
		}else{
			$zhuangtai="zhuangtai =".$zhuangtai;
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
		
		$datalist=$model->where($zhuangtai.' and bumen in ('.$deptsonstr.')'.$map)->order('bumen asc,leixing asc,leibie asc')->select();
		$zichan=new \lib\Zichan();
		$datalist=$zichan->changeFiled($datalist);
		
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