<?php
namespace Home\Controller;
use Common\Controller\AuthController;
class BaozhuangController extends AuthController {

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
		
		//得到包装工序的数据
		$baozhuanglist=$model->where("batch='%s' and type=%d",$batch,4)->order('id desc')->select();
		//调用工具类
		$utils=new \lib\Utils();
		//焊接数据格式化
		$baozhuanglist=$utils->changeTime($baozhuanglist);
		$baozhuanglist=$utils->managerIdtoName($baozhuanglist);
		$this->assign('pagetitle','生产计划详细信息');
		$this->assign('batchinfo',$batchinfo);
		$this->assign('baozhuanglist',$baozhuanglist);
		$this->display();
    }
	
	public function add(){
		$model=D('Pprocedure');
		$data=array();
		$data['batch']=I('post.batch');
		$data['model']=I('post.model');
		$data['sn']=I('post.sn');
		$pschedule=D('Pschedule');
		//本批次数量
		$batchnumber=$pschedule->where("batch='%s'",$data['batch'])->field('number')->find();
		$batchnumber=$batchnumber['number']+0;
		//出厂完成的
		$completenumber=$model->where("batch='%s' and type=%d",$data['batch'],4)->field('SUM(number) as total')->select();
		$completenumber=$completenumber[0]['total']+0;
		if($batchnumber<=$completenumber){
			$this->ajaxReturn(array(
				'state'=>'error',
				'info' => '本批次数量'.$batchnumber.'台，已完成'.$completenumber.'台不能添加！'
			));
		}else{
			$flaga=$model->where("batch='%s' and sn='%s'",$data['batch'],$data['sn'])->find();
			if($flaga){
				$this->ajaxReturn(array(
					'state'=>'error',
					'info' => '本批次该条形码已存在，不能重复添加！'
				));
			}else{
				$data['starttime']=time();
				$data['number']=1;
				$data['manager_id']=session('manager_id');
				$data['type']=4;
				if (!$model->create($data)){ // 创建数据对象
					// 如果创建失败 表示验证没有通过 输出错误提示信息
					exit($model->getError());
				}else{
					// 验证通过 写入新增数据
					$flagb=$model->add();
					if($flagb){
						$this->ajaxReturn(array(
							'state'=>'ok',
							'info' => '包装记录添加成功！'
						));
					}else{
						$this->ajaxReturn(array(
							'state'=>'error',
							'info' => '包装记录添加失败！'
						));
					}
				}
			}
		}
		
		/*
		//上一道工序完成的数量
		$number=$model->where("batch='%s' and type=%d and flag=%d",$data['batch'],3,1)->field('SUM(number) as total')->select();
		$batchnumber=$number[0]['total']+0;
		//出厂入库数量
		$chuchangtotal=$model->where("batch='%s' and type=%d and flag=%d",$data['batch'],6,4)->field('SUM(number) as total')->select();
		$chuchangtotal=$chuchangtotal[0]['total']+0;
		//电控库数量
		$diankongtotal=$model->where("batch='%s' and type=%d",$data['batch'],7)->field('SUM(number) as total')->select();
		$diankongtotal=$diankongtotal[0]['total']+0;
		//本工序完成的数量
		$total=$model->where("batch='%s' and type=%d",$data['batch'],4)->field('SUM(number) as total')->select();
		$completenumber=$total[0]['total']+0;
		if($batchnumber==0){
			$this->ajaxReturn(array(
				'state'=>'error',
				'info' =>'上一工序没有已完成的数量，不能进行本道工序！'
			));
		}else{
			$batchnumber=$batchnumber-$chuchangtotal-$diankongtotal;
			if($batchnumber<=$completenumber){
				$this->ajaxReturn(array(
					'state'=>'error',
					'info' => '上一工序已完成'.$batchnumber.'台，本工序已完成'.$completenumber.'台，不能添加！'
				));
			}else{
				$flaga=$model->where("batch='%s' and sn='%s'",$data['batch'],$data['sn'])->find();
				if($flaga){
					$this->ajaxReturn(array(
						'state'=>'error',
						'info' => '本批次该条形码已存在，不能重复添加！'
					));
				}else{
					$data['starttime']=time();
					$data['number']=1;
					$data['manager_id']=session('manager_id');
					$data['type']=4;
					if (!$model->create($data)){ // 创建数据对象
						// 如果创建失败 表示验证没有通过 输出错误提示信息
						exit($model->getError());
					}else{
						// 验证通过 写入新增数据
						$flagb=$model->add();
						if($flagb){
							$this->ajaxReturn(array(
								'state'=>'ok',
								'info' => '包装记录添加成功！'
							));
						}else{
							$this->ajaxReturn(array(
								'state'=>'error',
								'info' => '包装记录添加失败！'
							));
						}
					}
				}
			}
		}*/
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
			$data=$model->where('id in (%s)',$id)->select();
			$baozhuangdel=0;
			$batch=$data[0]['batch'];
			foreach($data as $value){
				$baozhuangdel+=$value['number'];
			}
			//包装工序数量
			$baozhuangtotal=$model->where("batch='%s' and type=%d",$batch,4)->field('SUM(number) as total')->select();
			$baozhuangtotal=$baozhuangtotal[0]['total']+0;
			$baozhuangnow=$baozhuangtotal-$baozhuangdel;
			//在制品包装入库数量
			$zaizhibaozhuang=$model->where("batch='%s' and type=%d and flag=%d",$batch,6,6)->field('SUM(number) as total')->select();
			$zaizhibaozhuang=$zaizhibaozhuang[0]['total']+0;
			//已包装成品入库数量
			$chengpintotal=$model->where("batch='%s' and type=%d and flag=%d and id !=%d",$batch,5,11,$id)->field('SUM(number) as total')->select();
			$chengpintotal=$chengpintotal[0]['total'];
			$total=$zaizhibaozhuang+$chengpintotal+0;
			if($baozhuangnow<$total){
				$this->ajaxReturn(array(
					'state'=>'error',
					'info' => '工序完成数量小于库存数量，不能删除！'
				));
			}else{
				$flagb=$model->where('id in (%s)',$id)->delete();
				if($flagb){
					$this->ajaxReturn(array(
						'state'=>'ok',
						'info' => '包装记录删除成功！',
						'data'=>$idlist
					));
				}else{
					$this->ajaxReturn(array(
						'state'=>'error',
						'info' => '包装记录删除失败！'
					));
				}
			}
			
			
		}
	}
	
	
}
?>