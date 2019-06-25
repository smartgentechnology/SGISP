<?php
namespace Home\Controller;
use Common\Controller\AuthController;
class FukuanController extends AuthController {
	
    public function index(){
		$this->assign('pagetitle','供应商待付');
		$this->display();
    }
	public function getfukuan(){
		//得到查询条件
		//截止日期
		$month=I('post.month');
		//拼接完成日期
		if(!empty($month)){
			$jiezhitime=strtotime($month);
		}else{
			$jiezhitime=time();
		}
		session('fukuantime',$jiezhitime);
		$fukuan=new \lib\Fukuan();
		$datalist=$fukuan->gongyingshang($jiezhitime);
		if(!empty($datalist)){
			$this->ajaxReturn(array(
				'state'=>'ok',
				'data'=>$datalist,
			));
		}else{
			$this->ajaxReturn(array(
				'state'=>'error',
			));
		}
		
    }
	public function exportExcel(){
		$xlsTitle = iconv('utf-8', 'gb2312', '供应商待付款');//文件名称
		$expCellName  = array(
		array('tian','日期'),
		array('count','供应商待付款')
		);
		$cellNum = count($expCellName);//多少列
		//$dataNum = count($expTableData);//多少行
		vendor("PHPExcel.PHPExcel");
			
		$objPHPExcel = new \PHPExcel();//实例化PHPExcel类
		$cellName = array('A','B');
		//'A','B','C','D','E','F','G','H','I'
		for($i=0;$i<2;$i++){
			$objPHPExcel->getActiveSheet(0)->setCellValue($cellName[$i].'1', $expCellName[$i][1]);//设置表头值
		}
		$fahuotime=session('fukuantime');
		if(empty($fahuotime)){
			$fahuotime=time();
		}
		$fukuan=new \lib\Fukuan();
		$datalist=$fukuan->export($fahuotime);
		
		$count=count($datalist);
		//设置表内容    
		for($i=0;$i<$count;$i++){
			for($j=0;$j<$cellNum;$j++){
				$objPHPExcel->getActiveSheet(0)->setCellValue($cellName[$j].($i+2),$datalist[$i][$expCellName[$j][0]]);
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