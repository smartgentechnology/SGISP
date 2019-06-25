<?php
namespace Home\Controller;
use Common\Controller\AuthController;
class ManagerController extends AuthController {
    public function index(){
		$this->assign('pagetitle','用户管理');
		$this->display();
    }
	public function export(){
		$xlsTitle = iconv('utf-8', 'utf-8', 'LinkOptionValue_system');//文件名称

		$expCellName  = array(
		array('loginname','登录名'),
		array('name','用户名')
		);

		
		$cellNum = count($expCellName);//多少列
		//$dataNum = count($expTableData);//多少行
		vendor("PHPExcel.PHPExcel");
			
		$objPHPExcel = new \PHPExcel();//实例化PHPExcel类
		$cellName = array('A','B');
		$objPHPExcel->getActiveSheet(0)->mergeCells('A1:C1');
		$objPHPExcel->getActiveSheet(0)->setCellValue('A1', '关联系统参数列表');//设置表头值
		//设置表头
		for($i=0;$i<2;$i++){
			$objPHPExcel->getActiveSheet(0)->setCellValue($cellName[$i].'2', $expCellName[$i][1]);//设置表头值
		}
		
		//生成数据列表
		//OA人员账号
		$principalModel=M('principal','org_','OA');
		//OA人员信息表
		$memberModel=M('member','org_','OA');
		//正常用户信息列表
		$memberlist=$memberModel->where('IS_ENABLE=1')->field('ID')->select();
		
		$data=array();
		foreach($memberlist as $value){
			$arr=array();
			$arr['loginname']=$principalModel->where("MEMBER_ID='%s'",$value['id'])->getField("LOGIN_NAME");
			$arr['name']=$arr['loginname'];
			$arr['password']='';
			$data[]=$arr;
		}
		$resultcount=count($data);
		//设置表内容    
		for($i=0;$i<$resultcount;$i++){
			for($j=0;$j<$cellNum;$j++){
				$objPHPExcel->getActiveSheet(0)->setCellValue($cellName[$j].($i+3), $data[$i][$expCellName[$j][0]]);
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