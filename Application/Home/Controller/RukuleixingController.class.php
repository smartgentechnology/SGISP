<?php
namespace Home\Controller;
use Common\Controller\AuthController;
class RukuleixingController extends AuthController {

	public function index(){
		$pschedule=D('Pschedule');
		$model=D('Pprocedure');
		$batch=I('get.batch');
		//通过批号获得计划详细信息
		$batchinfo=$pschedule->where("batch='%s'",$batch)->find();
		$batchinfo['ontime']=date('ymd',$batchinfo['ontime']);
		$batchinfo['downtime']=date('ymd',$batchinfo['downtime']);
		
		//焊接完成
		$hanjietotal=$model->where("batch='%s' and type=%d and flag=%d",$batch,1,1)->sum('number');
		$hanjietotal=$hanjietotal+0;
		//焊接报废
		$hanjiescrap=$model->where("batch='%s' and type=%d and flag=%d",$batch,1,5)->sum('number');
		$hanjiescrap=$hanjiescrap+0;
		//初试完成
		$chushitotal=$model->where("batch='%s' and type=%d and flag=%d",$batch,2,1)->sum('number');
		$chushitotal=$chushitotal+0;
		//初试报废
		$chushiscrap=$model->where("batch='%s' and type=%d and flag=%d",$batch,2,5)->sum('number');
		$chushiscrap=$chushiscrap+0;
		//出厂完成
		$chuchangtotal=$model->where("batch='%s' and type=%d and flag=%d",$batch,3,1)->sum('number');
		$chuchangtotal=$chuchangtotal+0;
		//出厂报废
		$chuchangscrap=$model->where("batch='%s' and type=%d and flag=%d",$batch,3,5)->sum('number');
		$chuchangscrap=$chuchangscrap+0;
		//包装完成
		$baozhuangtotal=$model->where("batch='%s' and type=%d",$batch,4)->sum('number');
		$baozhuangtotal=$baozhuangtotal+0;
		//待包装成品库
		$daibaochengpintotal=$model->where("batch='%s' and type=%d and flag=%d",$batch,5,10)->sum('number');
		$daibaochengpintotal=$daibaochengpintotal+0;
		//包装完成品库
		$baowanchengpintotal=$model->where("batch='%s' and type=%d and flag=%d",$batch,5,11)->sum('number');
		$baowanchengpintotal=$baowanchengpintotal+0;
		//焊接在制品库
		$hanjiezaizhi=$model->where("batch='%s' and type=%d and flag=%d",$batch,6,2)->sum('number');
		$hanjiezaizhi=$hanjiezaizhi+0;
		//初试在制品库
		$chushizaizhi=$model->where("batch='%s' and type=%d and flag=%d",$batch,6,3)->sum('number');
		$chushizaizhi=$chushizaizhi+0;
		//出厂在制品库
		$chuchangzaizhi=$model->where("batch='%s' and type=%d and flag=%d",$batch,6,4)->sum('number');
		$chuchangzaizhi=$chuchangzaizhi+0;
		//包装在制品库
		$baozhuangzaizhi=$model->where("batch='%s' and type=%d and flag=%d",$batch,6,6)->sum('number');
		$baozhuangzaizhi=$baozhuangzaizhi+0;
		//电控库
		$diankongtotal=$model->where("batch='%s' and type=%d",$batch,7)->sum('number');
		$diankongtotal=$diankongtotal+0;
		//待料库
		$dailiao=$model->where("batch='%s' and type=%d and flag in(7,8,9)",$batch,8)->sum('number');
		//待料库数量
		$batchinfo['dailiao']=$dailiao+0;
		
		//成品库数量=待包装成品+已包装成品
		$batchinfo['chengpin']=$daibaochengpintotal+$baowanchengpintotal;
		//在制品库数量=焊接在制+初试在制+出厂在制+包装在制
		$batchinfo['zaizhi']=$hanjiezaizhi+$chushizaizhi+$chuchangzaizhi+$baozhuangzaizhi;
		//电控库数量
		$batchinfo['diankong']=$diankongtotal;
		
		//焊接在线=批数量-焊接完成-焊接报废
		if($hanjietotal!=0){
			$batchinfo['hanjie']=$batchinfo['number']-$hanjietotal-$hanjiescrap;
		}else{
			$batchinfo['hanjie']=$batchinfo['number']-$hanjiescrap;
		}
		//焊接报废=焊接报废-焊接待料库
		$batchinfo['hanjiescrap']=$hanjiescrap;
		//初试在线=焊接完成-焊接在制品库-初试完成-初试报废
		$batchinfo['chushi']=$hanjietotal-$hanjiezaizhi-$chushitotal-$chushiscrap;
		//初试报废=初试报废-初试待料库
		$batchinfo['chushiscrap']=$chushiscrap;
		//出厂在线=初试完成-初试在制品库-出厂完成-出厂报废
		$batchinfo['chuchang']=$chushitotal-$chushizaizhi-$chuchangtotal-$chuchangscrap;
		//出厂报废=出厂报废-出厂待料库
		$batchinfo['chuchangscrap']=$chuchangscrap;
		if($chuchangtotal>$baozhuangtotal){
			//包装在线=出厂完成-出厂在制品库-包装完成-电控库-待包装成品
			$batchinfo['baozhuang']=$chuchangtotal-$chuchangzaizhi-$baozhuangtotal-$diankongtotal-$daibaochengpintotal;
		}else{
			$batchinfo['baozhuang']=0;
		}
		//待入库数量=包装完成-包装在制品库-已包装成品库
		$batchinfo['dairuku']=$baozhuangtotal-$baozhuangzaizhi-$baowanchengpintotal;
		
		
		//得到入库类型的数据
		$rukuleixinglist=$model->where("batch='%s' and type in (5,6,7,8)",$batch)->order('id desc')->select();
		//调用工具类
		$utils=new \lib\Utils();
		//入库数据格式化
		$rukuleixinglist=$utils->changeTime($rukuleixinglist);
		$rukuleixinglist=$utils->managerIdtoName($rukuleixinglist);
		$rukuleixinglist=$utils->typetoCangku($rukuleixinglist);
		$rukuleixinglist=$utils->flagtoGongxu($rukuleixinglist);
		$chengpinleixing=array(array('id'=>10,'value'=>'待包装入库'),array('id'=>11,'value'=>'包装完入库'));
		$gongxu=array(array('id'=>2,'value'=>'焊接入库'),array('id'=>3,'value'=>'初试入库'),array('id'=>4,'value'=>'出厂入库'),array('id'=>6,'value'=>'包装入库'));
		$category=array(array('id'=>5,'value'=>'成品库'),array('id'=>6,'value'=>'在制品库'),array('id'=>7,'value'=>'电控库'));
		$this->assign('pagetitle','生产计划详细信息');
		$this->assign('batchinfo',$batchinfo);
		$this->assign('rukuleixinglist',$rukuleixinglist);
		$this->assign('chengpinleixing',$chengpinleixing);
		$this->assign('category',$category);
		$this->assign('gongxu',$gongxu);
		$this->display();
    }
	
	public function add(){
		$model=D('Pprocedure');
		$data=array();
		$data['type']=I('post.type');
		$data['number']=I('post.number');
		$data['remark']=I('post.remark');
		$data['batch']=I('post.batch');
		$data['model']=I('post.model');
		if($data['type']==5){
			$data['flag']=I('post.flag');
			//出厂完成
			$chuchangtotal=$model->where("batch='%s' and type=%d and flag=%d",$data['batch'],3,1)->field('SUM(number) as total')->select();
			$chuchangtotal=$chuchangtotal[0]['total']+0;
			//包装工序完成的数量
			$baozhuangtotal=$model->where("batch='%s' and type=%d",$data['batch'],4)->field('SUM(number) as total')->select();
			$baozhuangtotal=$baozhuangtotal[0]['total']+0;
			//在制品包装入库
			$zaizhibaozhuang=$model->where("batch='%s' and type=%d and flag=%d",$data['batch'],6,6)->field('SUM(number) as total')->select();
			$zaizhibaozhuang=$zaizhibaozhuang[0]['total']+0;
			//电控库
			$diankongtotal=$model->where("batch='%s' and type=%d",$data['batch'],7)->field('SUM(number) as total')->select();
			$diankongtotal=$diankongtotal[0]['total']+0;
			//判断是那个工序入在成品库
			if($data['flag']==10){
				//待包装入库=出厂完成-包装完成-电控库
				$total=$chuchangtotal-$baozhuangtotal-$diankongtotal;
			}else if($data['flag']==11){
				//包装入库=包装完成-在制品包装入库
				$total=$baozhuangtotal-$zaizhibaozhuang;
			}
			//成品库数量
			$chengpintotal=$model->where("batch='%s' and type=%d and flag=%d",$data['batch'],5,$data['flag'])->field('SUM(number) as total')->select();
			$chengpintotal=$chengpintotal[0]['total']+$data['number']+0;
			if($total<$chengpintotal){
				$this->ajaxReturn(array(
					'state'=>'error',
					'info' =>'本批次该工序已完成'.$total.'台，成品库不能入'.$chengpintotal.'台！'
				));
			}
		}else if($data['type']==6){
			$data['flag']=I('post.flag');
			//焊接完成
			$hanjietotal=$model->where("batch='%s' and type=%d and flag=%d",$data['batch'],1,1)->field('SUM(number) as total')->select();
			
			//初试完成
			$chushitotal=$model->where("batch='%s' and type=%d and flag=%d",$data['batch'],2,1)->field('SUM(number) as total')->select();
			//初试报废
			$chushiscrap=$model->where("batch='%s' and type=%d and flag=%d",$data['batch'],2,5)->field('SUM(number) as total')->select();
			//出厂完成
			$chuchangtotal=$model->where("batch='%s' and type=%d and flag=%d",$data['batch'],3,1)->field('SUM(number) as total')->select();
			//出厂报废
			$chuchangcrap=$model->where("batch='%s' and type=%d and flag=%d",$data['batch'],3,5)->field('SUM(number) as total')->select();
			//包装完成
			$baozhuangtotal=$model->where("batch='%s' and type=%d",$data['batch'],4)->field('SUM(number) as total')->select();
			//待包成品库
			$daibaochengpintotal=$model->where("batch='%s' and type=%d",$data['batch'],5,10)->field('SUM(number) as total')->select();
			$daibaochengpintotal=$daibaochengpintotal[0]['total']+0;
			//已包成品库
			$yibaochengpintotal=$model->where("batch='%s' and type=%d",$data['batch'],5,11)->field('SUM(number) as total')->select();
			$yibaochengpintotal=$yibaochengpintotal[0]['total']+0;
			//电控库
			$diankongtotal=$model->where("batch='%s' and type=%d",$data['batch'],7)->field('SUM(number) as total')->select();
			$diankongtotal=$diankongtotal[0]['total']+0;
			
			$hanjietotal=$hanjietotal[0]['total']+0;
			$chushitotal=$chushitotal[0]['total']+0;
			$chushiscrap=$chushiscrap[0]['total']+0;
			$chuchangtotal=$chuchangtotal[0]['total']+0;
			$chuchangcrap=$chuchangcrap[0]['total']+0;
			$baozhuangtotal=$baozhuangtotal[0]['total']+0;
			//判断是那个工序入在制品库
			if($data['flag']==2){
				//焊接入库=焊接完成-初试完成-初试报废
				$total=$hanjietotal-$chushitotal-$chushiscrap;
			}else if($data['flag']==3){
				//初试入库=初始完成-出厂完成-出厂报废
				$total=$chushitotal-$chuchangtotal-$chuchangcrap;
			}else if($data['flag']==4){
				//出厂入库=出厂完成-包装完成-电控库-待包成品库
				$total=$chuchangtotal-$baozhuangtotal-$diankongtotal-daibaochengpintotal;
			}else if($data['flag']==6){
				//包装入库=包装完成-已包成品库
				$total=$baozhuangtotal-$chengpintotal;
			}
			//在制品库数量
			$zaizhitotal=$model->where("batch='%s' and type=%d and flag=%d",$data['batch'],6,$data['flag'])->field('SUM(number) as total')->select();
			$zaizhitotal=$zaizhitotal[0]['total']+$data['number'];
			
			if($total<$zaizhitotal){
				$this->ajaxReturn(array(
					'state'=>'error',
					'info' =>'本批次该工序半成品'.$total.'台，在制品库不能入'.$zaizhitotal.'台！'
				));
			}
		}else if($data['type']==7){
			//出厂工序完成的数量
			$chuchangtotal=$model->where("batch='%s' and type=%d and flag=%d",$data['batch'],3,1)->field('SUM(number) as total')->select();
			//包装完成
			$baozhuangtotal=$model->where("batch='%s' and type=%d",$data['batch'],4)->field('SUM(number) as total')->select();
			//在制品库的出厂入库
			$zaizhitotal=$model->where("batch='%s' and type=%d and flag=%d",$data['batch'],6,4)->field('SUM(number) as total')->select();
			$zaizhitotal=$zaizhitotal[0]['total'];
			
			$chuchangtotal=$chuchangtotal[0]['total']+0;
			$baozhuangtotal=$baozhuangtotal[0]['total']+0;
			
			$total=$chuchangtotal-$baozhuangtotal-$zaizhitotal;
			
			$diankongtotal=$model->where("batch='%s' and type=%d",$data['batch'],7)->field('SUM(number) as total')->select();
			$diankongtotal=$diankongtotal[0]['total']+$data['number'];
			
			if($total<$diankongtotal){
				$this->ajaxReturn(array(
					'state'=>'error',
					'info' =>'本批次出厂检验工序现在有'.$total.'台，电控库不能入'.$diankongtotal.'台！'
				));
			}
		}/*else if($data['type']==8){
			$data['flag']=I('post.flag');
			//焊接报废
			$hanjiescrap=$model->where("batch='%s' and type=%d and flag=%d",$data['batch'],1,5)->field('SUM(number) as total')->select();
			$hanjiescrap=$hanjiescrap[0]['total']+0;
			//初试报废
			$chushiscrap=$model->where("batch='%s' and type=%d and flag=%d",$data['batch'],2,5)->field('SUM(number) as total')->select();
			$chushiscrap=$chushiscrap[0]['total']+0;
			//出厂报废
			$chuchangcrap=$model->where("batch='%s' and type=%d and flag=%d",$data['batch'],3,5)->field('SUM(number) as total')->select();
			$chuchangcrap=$chuchangcrap[0]['total']+0;
			//焊接待料库
			$hanjietotal=$model->where("batch='%s' and type=%d and flag=%d",$data['batch'],8,7)->field('SUM(number) as total')->select();
			$hanjietotal=$hanjietotal[0]['total']+0;
			//初试待料库
			$chushitotal=$model->where("batch='%s' and type=%d and flag=%d",$data['batch'],8,8)->field('SUM(number) as total')->select();
			$chushitotal=$chushitotal[0]['total']+0;
			//出厂待料库
			$chuchangtotal=$model->where("batch='%s' and type=%d and flag=%d",$data['batch'],8,9)->field('SUM(number) as total')->select();
			$chuchangtotal=$chuchangtotal[0]['total']+0;

			//判断是那个工序入待料库
			if($data['flag']==7){
				//焊接报废入库=焊接报废-焊接待料已入
				$total=$hanjiescrap-$hanjietotal;
			}else if($data['flag']==8){
				//初试报废入库=初试报废-初试待料已入
				$total=$chushiscrap-chushitotal;
			}else if($data['flag']==9){
				//出厂报废入库=出厂报废-出厂待料已入
				$total=$chuchangcrap-chuchangtotal;
			}
			//待料库数量
			$dailiaototal=$model->where("batch='%s' and type=%d and flag=%d",$data['batch'],8,$data['flag'])->field('SUM(number) as total')->select();
			$dailiaototal=$dailiaototal[0]['total']+$data['number'];
			
			if($total<$dailiaototal){
				$this->ajaxReturn(array(
					'state'=>'error',
					'info' =>'本批次该工序报废'.$total.'台，待料库不能入'.$dailiaototal.'台！'
				));
			}
		}*/
		
		$data['starttime']=time();
		$data['manager_id']=session('manager_id');
		if (!$model->create($data)){ // 创建数据对象
			// 如果创建失败 表示验证没有通过 输出错误提示信息
			exit($model->getError());
		}else{
			// 验证通过 写入新增数据
			$flagb=$model->add();
			if($flagb){
				$numbertotal=$model->where("batch='%s' and type in (5,6,7,8)",$data['batch'])->sum('number');
				$numbertotal=$numbertotal+0;
				$pschedule=D('Pschedule');
				$number=$pschedule->where("batch='%s'",$data['batch'])->find();
				$number=$number['number'];
				$chashu=$number-$numbertotal;
				if($numbertotal==$number){
					$arr['flag']=1;
				}else if($chashu<10){
					$arr['flag']=2;
				}else{
					$arr['flag']=0;
				}
				$arr['onnumber']=$chashu;
				$pschedule->where("batch='%s'",$data['batch'])->save($arr);
				$this->ajaxReturn(array(
					'state'=>'ok',
					'info' => '入库记录添加成功！'
				));
			}else{
				$this->ajaxReturn(array(
					'state'=>'error',
					'info' => '入库记录添加失败！'
				));
			}
		}
				
	}
	
	public function edit(){
		$model=D('Pprocedure');
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
			$data=array();
			$data['type']=I('post.type');
			$data['number']=I('post.number');
			$data['remark']=I('post.remark');
			$data['batch']=I('post.batch');
			$id=I('post.id');
			if($data['type']==5){
				$data['flag']=I('post.flag');
				
				//出厂完成
				$chuchangtotal=$model->where("batch='%s' and type=%d and flag=%d",$data['batch'],3,1)->field('SUM(number) as total')->select();
				$chuchangtotal=$chuchangtotal[0]['total']+0;
				//包装工序完成的数量
				$baozhuangtotal=$model->where("batch='%s' and type=%d",$data['batch'],4)->field('SUM(number) as total')->select();
				$baozhuangtotal=$baozhuangtotal[0]['total']+0;
				//在制品包装入库
				$zaizhibaozhuang=$model->where("batch='%s' and type=%d and flag=%d",$data['batch'],6,6)->field('SUM(number) as total')->select();
				$zaizhibaozhuang=$zaizhibaozhuang[0]['total']+0;
				//电控库
				$diankongtotal=$model->where("batch='%s' and type=%d",$data['batch'],7)->field('SUM(number) as total')->select();
				$diankongtotal=$diankongtotal[0]['total']+0;
				//判断是那个工序入在成品库
				if($data['flag']==10){//待包装入库
					//出厂入库=出厂完成-包装完成-电控库
					$total=$chuchangtotal-$baozhuangtotal-$diankongtotal;
				}else if($data['flag']==11){//包装入库
					//包装入库=包装完成-在制品包装入库
					$total=$baozhuangtotal-$zaizhibaozhuang;
				}
				//成品库数量
				$chengpintotal=$model->where("batch='%s' and type=%d and flag=%d and id !=%d",$data['batch'],5,$data['flag'],$id)->field('SUM(number) as total')->select();
				$chengpintotal=$chengpintotal[0]['total']+$data['number'];
				
				if($total<$chengpintotal){
					$this->ajaxReturn(array(
						'state'=>'error',
						'info' =>'本批次该工序已完成'.$total.'台，成品库不能入'.$chengpintotal.'台！'
					));
				}
			}else if($data['type']==6){
				$data['flag']=I('post.flag');
				//焊接完成
				$hanjietotal=$model->where("batch='%s' and type=%d and flag=%d",$data['batch'],1,1)->field('SUM(number) as total')->select();
				//初试完成
				$chushitotal=$model->where("batch='%s' and type=%d and flag=%d",$data['batch'],2,1)->field('SUM(number) as total')->select();
				//初试报废
				$chushiscrap=$model->where("batch='%s' and type=%d and flag=%d",$data['batch'],2,5)->field('SUM(number) as total')->select();
				//出厂完成
				$chuchangtotal=$model->where("batch='%s' and type=%d and flag=%d",$data['batch'],3,1)->field('SUM(number) as total')->select();
				//出厂报废
				$chuchangcrap=$model->where("batch='%s' and type=%d and flag=%d",$data['batch'],3,5)->field('SUM(number) as total')->select();
				//包装完成
				$baozhuangtotal=$model->where("batch='%s' and type=%d",$data['batch'],4)->field('SUM(number) as total')->select();
				//待包成品库
				$daibaochengpintotal=$model->where("batch='%s' and type=%d",$data['batch'],5,10)->field('SUM(number) as total')->select();
				$daibaochengpintotal=$daibaochengpintotal[0]['total']+0;
				//已包成品库
				$yibaochengpintotal=$model->where("batch='%s' and type=%d",$data['batch'],5,11)->field('SUM(number) as total')->select();
				$yibaochengpintotal=$yibaochengpintotal[0]['total']+0;
				
				//电控库
				$diankongtotal=$model->where("batch='%s' and type=%d",$data['batch'],7)->field('SUM(number) as total')->select();
				$diankongtotal=$diankongtotal[0]['total']+0;
				
				$hanjietotal=$hanjietotal[0]['total']+0;
				$chushitotal=$chushitotal[0]['total']+0;
				$chushiscrap=$chushiscrap[0]['total']+0;
				$chuchangtotal=$chuchangtotal[0]['total']+0;
				$chuchangcrap=$chuchangcrap[0]['total']+0;
				$baozhuangtotal=$baozhuangtotal[0]['total']+0;
				//判断是那个工序入在制品库
				if($data['flag']==2){
					//焊接入库=焊接完成-初试完成-初试报废
					$total=$hanjietotal-$chushitotal-$chushiscrap;
				}else if($data['flag']==3){
					//初试入库=初始完成-出厂完成-出厂报废
					$total=$chushitotal-$chuchangtotal-$chuchangcrap;
				}else if($data['flag']==4){
					//出厂入库=出厂完成-包装完成-电控库-待包成品库
					$total=$chuchangtotal-$baozhuangtotal-$diankongtotal-daibaochengpintotal;
				}else if($data['flag']==6){
					//包装入库=包装完成-已包成品库
					$total=$baozhuangtotal-$chengpintotal;
				}
				//在制品库数量
				$zaizhitotal=$model->where("batch='%s' and type=%d and flag=%d and id!=%d",$data['batch'],6,$data['flag'],$id)->field('SUM(number) as total')->select();
				$zaizhitotal=$zaizhitotal[0]['total']+$data['number'];
				
				if($total<$zaizhitotal){
					$this->ajaxReturn(array(
						'state'=>'error',
						'info' =>'本批次该工序半成品'.$total.'台，在制品库不能入'.$zaizhitotal.'台！'
					));
				}
			}else if($data['type']==7){
				$data['flag']=0;
				//出厂工序完成的数量
				$chuchangtotal=$model->where("batch='%s' and type=%d and flag=%d",$data['batch'],3,1)->field('SUM(number) as total')->select();
				//包装完成
				$baozhuangtotal=$model->where("batch='%s' and type=%d",$data['batch'],4)->field('SUM(number) as total')->select();
				
				//在制品库的出厂入库
				$zaizhitotal=$model->where("batch='%s' and type=%d and flag=%d",$data['batch'],6,4)->field('SUM(number) as total')->select();
				$zaizhitotal=$zaizhitotal[0]['total'];
				
				$chuchangtotal=$chuchangtotal[0]['total']+0;
				$baozhuangtotal=$baozhuangtotal[0]['total']+0;
				
				$total=$chuchangtotal-$baozhuangtotal-$zaizhitotal;
				
				$diankongtotal=$model->where("batch='%s' and type=%d and id!=%d",$data['batch'],7,$id)->field('SUM(number) as total')->select();
				$diankongtotal=$diankongtotal[0]['total']+$data['number'];
				
				if($total<$diankongtotal){
					$this->ajaxReturn(array(
						'state'=>'error',
						'info' =>'本批次出厂检验工序现在有'.$total.'台，电控库不能入'.$diankongtotal.'台！'
					));
				}
			}/*else if($data['type']==8){
				$data['flag']=I('post.flag');
				//焊接报废
				$hanjiescrap=$model->where("batch='%s' and type=%d and flag=%d",$data['batch'],1,5)->field('SUM(number) as total')->select();
				$hanjiescrap=$hanjiescrap[0]['total']+0;
				//初试报废
				$chushiscrap=$model->where("batch='%s' and type=%d and flag=%d",$data['batch'],2,5)->field('SUM(number) as total')->select();
				$chushiscrap=$chushiscrap[0]['total']+0;
				//出厂报废
				$chuchangcrap=$model->where("batch='%s' and type=%d and flag=%d",$data['batch'],3,5)->field('SUM(number) as total')->select();
				$chuchangcrap=$chuchangcrap[0]['total']+0;
				//焊接待料库
				$hanjietotal=$model->where("batch='%s' and type=%d and flag=%d",$data['batch'],8,7)->field('SUM(number) as total')->select();
				$hanjietotal=$hanjietotal[0]['total']+0;
				//初试待料库
				$chushitotal=$model->where("batch='%s' and type=%d and flag=%d",$data['batch'],8,8)->field('SUM(number) as total')->select();
				$chushitotal=$chushitotal[0]['total']+0;
				//出厂待料库
				$chuchangtotal=$model->where("batch='%s' and type=%d and flag=%d",$data['batch'],8,9)->field('SUM(number) as total')->select();
				$chuchangtotal=$chuchangtotal[0]['total']+0;

				//判断是那个工序入待料库
				if($data['flag']==7){
					//焊接报废入库=焊接报废
					$total=$hanjiescrap;
				}else if($data['flag']==8){
					//初试报废入库=初试报废
					$total=$chushiscrap;
				}else if($data['flag']==9){
					//出厂报废入库=出厂报废
					$total=$chuchangcrap;
				}
				//待料库数量
				$dailiaototal=$model->where("batch='%s' and type=%d and flag=%d and id!=%d",$data['batch'],8,$data['flag'],$id)->field('SUM(number) as total')->select();
				$dailiaototal=$dailiaototal[0]['total']+$data['number'];
				
				if($total<$dailiaototal){
					$this->ajaxReturn(array(
						'state'=>'error',
						'info' =>'本批次该工序报废'.$total.'台，待料库不能入'.$dailiaototal.'台！'
					));
				}
			}*/
			
			$data['starttime']=time();
			$data['manager_id']=session('manager_id');
			$flagb=$model->where('id=%d',$id)->save($data);
			
			if($flagb){
				$numbertotal=$model->where("batch='%s' and type in (5,6,7,8)",$data['batch'])->sum('number');
				$numbertotal=$numbertotal+0;
				$pschedule=D('Pschedule');
				$number=$pschedule->where("batch='%s'",$data['batch'])->find();
				$number=$number['number'];
				$chashu=$number-$numbertotal;
				if($numbertotal==$number){
					$arr['flag']=1;
				}else if($chashu<10){
					$arr['flag']=2;
				}else{
					$arr['flag']=0;
				}
				$arr['onnumber']=$chashu;
				$pschedule->where("batch='%s'",$data['batch'])->save($arr);
				$this->ajaxReturn(array(
					'state'=>'ok',
					'info' => '入库记录修改成功！'
				));
			}else{
				$this->ajaxReturn(array(
					'state'=>'error',
					'info' => '入库记录修改失败！'
				));
			}
			
		}
	}
	
	
	public function del($id=''){
		$model=D('Pprocedure');
		if(empty($id)){
			$this->ajaxReturn(array(
				'state'=>'error',
				'info' => '请至少选择一条记录！'
				));
		}else{
			$id=substr($id,0,-1);
			$data=$model->where('id in (%s)',$id)->find();
			$flagb=$model->where('id in (%s)',$id)->delete();
			if($flagb){
				$numbertotal=$model->where("batch='%s' and type in (5,6,7,8)",$data['batch'])->sum('number');
				$numbertotal=$numbertotal+0;
				$pschedule=D('Pschedule');
				$number=$pschedule->where("batch='%s'",$data['batch'])->find();
				$number=$number['number'];
				$chashu=$number-$numbertotal;
				if($numbertotal==$number){
					$arr['flag']=1;
				}else if($chashu<10){
					$arr['flag']=2;
				}else{
					$arr['flag']=0;
				}
				$arr['onnumber']=$chashu;
				$pschedule->where("batch='%s'",$data['batch'])->save($arr);
				$this->ajaxReturn(array(
					'state'=>'ok',
					'info' => '入库记录删除成功！',
					'data'=>$idlist
				));
			}else{
				$this->ajaxReturn(array(
					'state'=>'error',
					'info' => '入库记录删除失败！'
				));
			}
			
		}
	}
	
	
}
?>