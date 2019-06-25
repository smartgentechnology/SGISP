<?php
namespace Home\Controller;
use Common\Controller\AuthController;
class ChuchangController extends AuthController {

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
		
		//得到出厂检验工序的数据
		$chuchanglist=$model->where("batch='%s' and type=%d",$batch,3)->order('id desc')->select();
		//调用工具类
		$utils=new \lib\Utils();
		//出厂数据格式化
		$chuchanglist=$utils->changeTime($chuchanglist);
		$chuchanglist=$utils->managerIdtoName($chuchanglist);
		$chuchanglist=$utils->flagtoState($chuchanglist);
		$this->assign('pagetitle','生产计划详细信息');
		$this->assign('batchinfo',$batchinfo);
		$this->assign('chuchanglist',$chuchanglist);
		$this->display();
    }
	
	public function add(){
		$model=D('Pprocedure');
		$data=array();
		$data['model']=I('get.model');
		$data['batch']=I('get.batch');
		$pschedule=D('Pschedule');
		//本批次数量
		$batchnumber=$pschedule->where("batch='%s'",$data['batch'])->field('number')->find();
		$batchnumber=$batchnumber['number']+0;
		//出厂报废的
		$scrapnumber=$model->where("batch='%s' and type=%d and flag=%d",$data['batch'],3,5)->field('SUM(number) as total')->select();
		$scrapnumber=$scrapnumber[0]['total']+0;
		//出厂完成的
		$completenumber=$model->where("batch='%s' and type=%d and flag=%d",$data['batch'],3,1)->field('SUM(number) as total')->select();
		$completenumber=$completenumber[0]['total']+0;
		$total=$batchnumber-$scrapnumber;
		if($total<=$completenumber){
			$this->ajaxReturn(array(
				'state'=>'error',
				'info' => '本批次数量'.$batchnumber.'台，出厂报废'.$scrapnumber.'台，已完成'.$completenumber.'台，不能添加！'
			));
		}else{
			$flaga=$model->where("batch='%s' and type=%d and flag=%d",$data['batch'],3,0)->find();
			if($flaga){
				$this->ajaxReturn(array(
					'state'=>'error',
					'info' => '已有未完成记录！'
				));
			}else{
				$data['starttime']=time();
				$data['manager_id']=session('manager_id');
				$data['type']=3;
				if (!$model->create($data)){ // 创建数据对象
					// 如果创建失败 表示验证没有通过 输出错误提示信息
					exit($model->getError());
				}else{
					// 验证通过 写入新增数据
					$flagb=$model->add();
					if($flagb){
						$this->ajaxReturn(array(
							'state'=>'ok',
							'info' => '出厂检验记录添加成功！'
						));
					}else{
						$this->ajaxReturn(array(
							'state'=>'error',
							'info' => '出厂检验记录添加失败！'
						));
					}
				}
			}
		}
		/*
		//上一道工序完成的数量
		$number=$model->where("batch='%s' and type=%d and flag=%d",$data['batch'],2,1)->field('SUM(number) as total')->select();
		$batchnumber=$number[0]['total']+0;
		//初试入库数量
		$chushitotal=$model->where("batch='%s' and type=%d and flag=%d",$data['batch'],6,3)->field('SUM(number) as total')->select();
		$chushitotal=$chushitotal[0]['total']+0;
		//本工序报废
		$scrapnumber=$model->where("batch='%s' and type=%d and flag=%d",$data['batch'],3,5)->field('SUM(number) as total')->select();
		$scrapnumber=$scrapnumber[0]['total']+0;
		//本工序完成的数量
		$completenumber=$model->where("batch='%s' and type=%d and flag=%d",$data['batch'],3,1)->field('SUM(number) as total')->select();
		$completenumber=$completenumber[0]['total']+0;
		if($batchnumber==0){
			$this->ajaxReturn(array(
				'state'=>'error',
				'info' =>'上一工序没有已完成的数量，不能进行本道工序！'
			));
		}else{
			$total=$batchnumber-$chushitotal-$scrapnumber;
			if($total<=$completenumber){
				$this->ajaxReturn(array(
					'state'=>'error',
					'info' => '初试完成数量'.$batchnumber.'台，入库'.$chushitotal.'台，本工序已报废'.$scrapnumber.'台，已完成'.$completenumber.'台，不能添加！'
				));
			}else{
				$flaga=$model->where("batch='%s' and type=%d and flag=%d",$data['batch'],3,0)->find();
				if($flaga){
					$this->ajaxReturn(array(
						'state'=>'error',
						'info' => '已有未完成记录！'
					));
				}else{
					$data['starttime']=time();
					$data['manager_id']=session('manager_id');
					$data['type']=3;
					if (!$model->create($data)){ // 创建数据对象
						// 如果创建失败 表示验证没有通过 输出错误提示信息
						exit($model->getError());
					}else{
						// 验证通过 写入新增数据
						$flagb=$model->add();
						if($flagb){
							$this->ajaxReturn(array(
								'state'=>'ok',
								'info' => '出厂检验记录添加成功！'
							));
						}else{
							$this->ajaxReturn(array(
								'state'=>'error',
								'info' => '出厂检验记录添加失败！'
							));
						}
					}
				}
			}
		}*/
	}
	
	public function edit(){
		$model=D('Pprocedure');
		$pschedule=D('Pschedule');
		if(IS_GET){
			$id=I('get.id');
			$buttonid=I('get.buttonid');
			if(empty($id)){
				$this->ajaxReturn(array(
					'state'=>'error',
					'info' => '请至少选择一条记录！'
					));
			}else{
				//$id=substr($id,0,-1);
				$result=$model->where('id=%d',$id)->find();
				if($buttonid==3){
					if($result['flag']==0){
						$this->ajaxReturn(array(
						'state'=>'error',
						'info' => '该条记录未完成，请通过修改按钮修改人数！'
						));
					}else{
						$result['starttime']=date('y-m-d H:i:s',$result['starttime']);
						$this->ajaxReturn(array(
							'state'=>'ok',
							'info' => '',
							'data'=>$result
							));
					}
				}else if($buttonid==1 || $buttonid==2){
					if($result['flag']==1){
						$this->ajaxReturn(array(
							'state'=>'error',
							'info' => '该条记录已完成，不能修改！'
						));
					}else if($result['flag']==5){
						$this->ajaxReturn(array(
							'state'=>'error',
							'info' => '该条记录已报废，不能修改！'
						));
					}else{
						$result['starttime']=date('y-m-d H:i:s',$result['starttime']);
						$this->ajaxReturn(array(
							'state'=>'ok',
							'info' => '',
							'data'=>$result
							));
					}
				}else if($buttonid==4){
					if($result['flag']==1){
						$this->ajaxReturn(array(
							'state'=>'error',
							'info' => '该条记录已完成，不能报废！'
						));
					}else if($result['flag']==5){
						$this->ajaxReturn(array(
							'state'=>'error',
							'info' => '该条记录已报废，不能报废！'
						));
					}else{
						$result['starttime']=date('y-m-d H:i:s',$result['starttime']);
						$this->ajaxReturn(array(
							'state'=>'ok',
							'info' => '',
							'data'=>$result
							));
					}
				}
				
				
			}
		}else{
			
			$id=I('post.id');
			$buttonid=I('post.buttonid');
			$data=array();
			$batch=I('post.batch');
			//得到上一工序完成的数量
			$batchnumber=$model->where("batch='%s' and type=%d and flag=%d",$batch,2,1)->field('SUM(number) as total')->select();
			$batchnumber=$batchnumber[0]['total']+0;
			//初试入库数量
			$chushitotal=$model->where("batch='%s' and type=%d and flag=%d",$batch,6,3)->field('SUM(number) as total')->select();
			$chushitotal=$chushitotal[0]['total']+0;

			//新添加的数量
			$addnumber=I('post.number');
			if($buttonid!=3){
				//出厂报废的
				$scrapnumber=$model->where("batch='%s' and type=%d and flag=%d",$batch,3,5)->field('SUM(number) as total')->select();
				$scrapnumber=$scrapnumber[0]['total']+0;
				//本工序已完成的数量
				$completenumber=$model->where("batch='%s' and type=%d and flag=%d",$batch,3,1)->field('SUM(number) as total')->select();
				$completenumber=$completenumber[0]['total']+0;
				if($buttonid==1 || $buttonid==2){
					//已完成+新数量
					$addnumber=$completenumber+$addnumber;
					//总数-报废数量-上一工序入库数量
					$total=$batchnumber-$scrapnumber-$chushitotal;
					if($total<$addnumber){
						$this->ajaxReturn(array(
							'state'=>'error',
							'info' => '初试完成数量'.$batchnumber.'台，入库'.$chushitotal.'台，本工序已报废'.$scrapnumber.'台，已完成'.$completenumber.'台，不能修改！'
						));
					}
				}else if($buttonid==4){
					//报废+新数量
					$addnumber=$scrapnumber+$addnumber;
					//总数-已完成数量-上一工序入库数量
					$total=$batchnumber-$completenumber-$chushitotal;
					if($total<$addnumber){
						$this->ajaxReturn(array(
							'state'=>'error',
							'info' => '初试完成数量'.$batchnumber.'台，入库'.$chushitotal.'台，本工序已完成'.$completenumber.'台，已报废'.$scrapnumber.'台，不能修改！'
						));
					}
				}
				
				
				$starttime=strtotime(I('post.starttime'));
				$data['endtime']=time();
				if($starttime>$data['endtime']){
					$this->ajaxReturn(array(
						'state'=>'error',
						'info' => '完成时间不能小于开始时间！'
					));
				}
				$starthours=date('H',$starttime);
				$endhours=date('H',$data['endtime']);
				if(($starthours<12) and ($endhours>=13)){
					$hours=($data['endtime']-$starttime-3600)/3600;
				}else{
					$hours=($data['endtime']-$starttime)/3600;
				}
				$data['hours']=$hours;
				$data['flag']=I('post.flag');
				
			}else{
				//出厂报废的
				$scrapnumber=$model->where("batch='%s' and type=%d and flag=%d and id!=%d",$batch,3,5,$id)->field('SUM(number) as total')->select();
				$scrapnumber=$scrapnumber[0]['total']+0;
				//本工序已完成的数量
				$completenumber=$model->where("batch='%s' and type=%d and flag=%d and id!=%d",$batch,3,1,$id)->field('SUM(number) as total')->select();
				$completenumber=$completenumber[0]['total']+0;
				$befordata=$model->where("id =%d",$id)->find();
				if($befordata['flag']==1){
					//已完成+新数量
					$addnumber=$completenumber+$addnumber;
					//总数-报废数量-上一工序入库数量
					$total=$batchnumber-$scrapnumber-$chushitotal;
					if($total<$addnumber){
						$this->ajaxReturn(array(
							'state'=>'error',
							'info' => '初试完成数量'.$batchnumber.'台，入库'.$chushitotal.'台，本工序已报废'.$scrapnumber.'台，已完成'.$completenumber.'台，不能修改！'
						));
					}
				}else if($befordata['flag']==5){
					//报废+新数量
					$addnumber=$scrapnumber+$addnumber;
					//总数-已完成数量-上一工序入库数量
					$total=$batchnumber-$completenumber-$chushitotal;
					if($total<$addnumber){
						$this->ajaxReturn(array(
							'state'=>'error',
							'info' => '初试完成数量'.$batchnumber.'台，入库'.$chushitotal.'台，本工序已完成'.$completenumber.'台，已报废'.$scrapnumber.'台，不能修改！'
						));
					}
				}
			}
			$data['number']=I('post.number');
			$data['people']=I('post.people');
			$data['remark']=I('post.remark');
			$data['manager_id']=session('manager_id');
			if (!$model->create($data)){ // 创建数据对象
				// 如果创建失败 表示验证没有通过 输出错误提示信息
				exit($model->getError());
			}else{
				$flagb=$model->where('id=%d',$id)->save();
				if($flagb!==false){
					//出厂报废总数量
					$scraptotal=$model->where("batch='%s' and type=%d and flag=%d",$batch,3,5)->sum('number');
					$scraptotal=$scraptotal+0;
					//出厂报废入库数量
					$scrapdailiao=$model->where("batch='%s' and type=%d and flag=%d",$batch,8,9)->sum('number');
					$scrapdailiao=$scrapdailiao+0;
					if($scrapdailiao==0){
						$first=$pschedule->where("batch='%s'",$batch)->find();
						$arr['batch']=$batch;
						$arr['model']=$first['model'];
						$arr['starttime']=time();
						$arr['number']=$scraptotal;
						$arr['manager_id']=$data['manager_id'];
						$arr['remark']=$data['remark'];
						$arr['type']=8;
						$arr['flag']=9;
						$model->data($arr)->add();
					}else{
						$model->number=$scraptotal;
						$model->where("batch='%s' and type=%d and flag=%d",$batch,8,9)->save();
					}
					//更改计划状态和在线上在线数量
					$numbertotal=$model->where("batch='%s' and type in (5,6,7,8)",$batch)->sum('number');
					$numbertotal=$numbertotal+0;
					$pschedule=D('Pschedule');
					$number=$pschedule->where("batch='%s'",$data['batch'])->find();
					$number=$number['number'];
					$chashu=$number-$numbertotal;
					if($numbertotal==$number){
						$flag['flag']=1;
					}else if($chashu<10){
						$flag['flag']=2;
					}else{
						$flag['flag']=0;
					}
					$flag['onnumber']=$chashu;
					$pschedule->where("batch='%s'",$data['batch'])->save($flag);
					$this->ajaxReturn(array(
						'state'=>'ok',
						'info' => '出厂检验记录修改成功！'
					));
				}else{
					$this->ajaxReturn(array(
						'state'=>'error',
						'info' => '出厂检验记录修改失败！'
					));
				}
			}
			
		}
	}
	
	
}
?>