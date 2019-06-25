<?php
namespace Home\Controller;
use Common\Controller\AuthController;
class AutomailController extends AuthController {
	
    public function index(){
		//网站产品
		$productsModel=M('','products','ZW');
		//拼接查询条件
		$flag="is_delete =0";
		//日常工作计划未完成
		$datalist=$productsModel->where($flag)->order('product_id desc')->limit($Page->firstRow.','.$Page->listRows)->field("product_id,product_name,product_feature,cishu")->select();
		$count=count($datalist);
		$this->assign('pagetitle','邮件发送');
		$this->assign('datalist',$datalist);
		$this->assign('count',$count);
		$this->display();
    }
	
	public function send(){
		$productModel=M('','products','ZW');
		$downloadModel=M('','download','ZW');
		$productimgModel=M('','productimg','ZW');
		$parameterModel=M('','parameter','ZW');
		$parameteritemModel=M('','parameter_item','ZW');
		$customerModel=D('Customer');
		$id=I('get.id');
		$productinfo=$productModel->where('product_id=%d',$id)->find();
		//接线图
		$jiexiantu=$downloadModel->where('product_id=%d and down_type=3',$id)->getField("down_value");
		//产品图片
		$productimg=$productimgModel->where('product_id=%d',$id)->getField("product_img");
		//参数
		$parameterlist=$parameterModel->where('product_id=%d',$id)->order("para_id asc")->field("item_id,para_value")->select();
		foreach($parameterlist as $key=>$value){
			$parameterlist[$key]["item_id"]=$parameteritemModel->where("item_id=%d",$value['item_id'])->getField("item_title");
		}
		$customerlist=$customerModel->select();
		vendor("PHPMailer.PHPMailer");
		//添加收件人,可添加多人
		foreach($customerlist as $a){
			//实例化phpmailer		
			$phpmailer=new \PHPMailer();  
			//用SMTP协议来发送邮件
			$phpmailer->IsSMTP(); 
			//设置字符编码
			$phpmailer->CharSet='utf-8';
			//设置发送地址和用户名密码
			$phpmailer->Host="smtp.exmail.qq.com";
			$phpmailer->SMTPAuth=true;
			$phpmailer->Username='smartgen@smartgen.cn';
			$phpmailer->Password='Smartgen980318';
			//$phpmailer->SMTPSecure='ssl';
			//$phpmailer->Port=465;
			//设置邮件头信息
			$phpmailer->From='smartgen@smartgen.cn';
			$phpmailer->FromName='SmartGen';
			$phpmailer->Subject='新品推荐-'.$productinfo['product_name'].$productinfo['product_feature'];
			$phpmailer->IsHTML(true);
			$strtop='
				<br>
				<div style="padding-left:50px;">
					<a href="http://www.smartgen.com.cn/index.php" target="_blank">
					<img src="http://www.smartgen.com.cn/view/front/userimage/l_logo.png">
					</a>
				</div>
				<br>';
			$strproductimg='<div><table width="100%"><tr><td width="50%"><center><a href="http://www.smartgen.com.cn/product.php?cat_id='.$productinfo['cat_id'].'&product_id='.$productinfo['product_id'].'" target="_blank" title="点击查看详情"><img src="http://www.smartgen.com.cn/'.$productimg.'"/></a></center></td><td width="50%"><center><a href="http://www.smartgen.com.cn/product.php?cat_id='.$productinfo['cat_id'].'&product_id='.$productinfo['product_id'].'" target="_blank" title="点击查看详情"><img width="80%" src="http://www.smartgen.com.cn/'.$jiexiantu.'"></a></center></td></tr><tr><td><center><h3><a href="http://www.smartgen.com.cn/product.php?cat_id='.$productinfo['cat_id'].'&product_id='.$productinfo['product_id'].'"  style="text-decoration:none; color:#000000" target="_blank" title="点击查看详情">'.$productinfo['product_name'].'</a></h3></center></td><td><center><h3><a href="http://www.smartgen.com.cn/product.php?cat_id='.$productinfo['cat_id'].'&product_id='.$productinfo['product_id'].'" style="text-decoration:none; color:#000000" target="_blank" title="点击查看详情">接线图</a></h3></center></td></tr></table></center></div>';
			if(empty($parameterlist)){
				$strbody='<div style="background-color:#eeeeee"><br><table width="100%"><tr><td width="100%" style="padding-left:50px;">'.$productinfo['product_desc'].'</td></tr></table>';
			}else{
				$strpara="";
				$flag=0;
				foreach($parameterlist as $value){
					if($flag==0){
						$strpara=$strpara.'<tr><td style="background-color:#ffffff;">'.$value['item_id'].'</td><td style="background-color:#ffffff;">'.$value['para_value'].'</td></tr>';
						$flag=1;
					}else{
						$strpara=$strpara.'<tr><td style="background-color:#dddddd;">'.$value['item_id'].'</td><td style="background-color:#dddddd;">'.$value['para_value'].'</td></tr>';
						$flag=0;
					}
					
				}
				$strbody='<div style="background-color:#eeeeee"><br><table width="100%"><tr><td width="50%" style="padding-left:50px;"><center><strong><h3>产品简介</h3></strong></center>'.$productinfo['product_desc'].'</td><td width="50%" valign="top" style="padding-left:50px;"><center><strong><h3>参数表</h3></strong></center><table width="100%" style="margin-top:10px;"><tr><td width="50%" style="background-color:#000066; color:#FFFFFF;"><strong>功能</strong></td><td width="50%" style="background-color:#000066; color:#FFFFFF;"><strong>参数</strong></td></tr>'.$strpara.'</table></td></tr></table>';
			}
			
			$strbottom='
			<div style="background-color:#999999;">
				<br>
				<table width="100%">
					<tr>
						<td width="70%">
							<p style="color:#FFFFFF;padding-left:50px;">Web：<a style="text-decoration:none; color:#FFFFFF" href="http://www.smartgen.com.cn" target="_blank">中文</a>&nbsp;·&nbsp;<a style="text-decoration:none; color:#FFFFFF" href="http://www.smartgen.hk" target="_blank">繁体</a>&nbsp;·&nbsp;<a style="text-decoration:none; color:#FFFFFF" href="http://www.smartgen.cn" target="_blank">English</a>&nbsp;·&nbsp;<a style="text-decoration:none; color:#FFFFFF" href="https://shop113335048.taobao.com" target="_blank">淘宝商城</a></p>
						</td>
						<td rowspan="7" align="right">
							<center><img width="80%" src="http://www.smartgen.com.cn/view/front/userimage/app_download.png"><br>
							<p style="color:#FFFFFF;">众智产品 / SmartGen Product</p></center>
						</td>
						<td rowspan="7" align="right">
							<center><img width="80%" src="http://www.smartgen.com.cn/view/front/userimage/yun.jpg"><br>
							<p style="color:#FFFFFF;">众智云 / SmartGen Cloud</p></center>
						</td>
					</tr>
					<tr>
						<td><p style="color:#FFFFFF;padding-left:50px;">地址：中国·河南省郑州高新技术开发区金梭路28号</p></td>
					</tr>
					<tr>
						<td><p style="color:#FFFFFF;padding-left:50px;">Add：No.28 Jinsuo Road, Zhengzhou City, Henan Province, China</p></td>
					</tr>
					<tr>
						<td><p style="color:#FFFFFF;padding-left:50px;">Tel：0086-371-67988888/67981000(overseas)</p></td>
					</tr>
					<tr>
						<td><p style="color:#FFFFFF;padding-left:50px;">Fax：0086-371-67992952</p></td>
					</tr>
					<tr>
						<td><p style="color:#FFFFFF;padding-left:50px;">E-mail：sales@smartgen.cn</p></td>
					</tr>
					<tr>
						<td><p style="color:#FFFFFF;padding-left:50px;">Copyright&copy; Since 1998 SmartGen</p></td>
					</tr>
				</table>
				<br>
				</div></div>';
		
		
			$phpmailer->Body=$strtop.$strproductimg.$strbody.$strjiexian.$strbottom;
			$phpmailer->AddAddress($a['email'],$a['email']);
			$phpmailer->send();
		}
		$arr=array();
		$arr['cishu']=$productinfo['cishu']+1;
		$productModel->where('product_id=%d',$id)->save($arr);
		$this->ajaxReturn(array(
			'state'=>'ok',
			'info' => '成功'
		));
	}
	public function testsend(){
		$productModel=M('','products','ZW');
		$downloadModel=M('','download','ZW');
		$productimgModel=M('','productimg','ZW');
		$parameterModel=M('','parameter','ZW');
		$parameteritemModel=M('','parameter_item','ZW');
		$customerModel=D('Testmail');
		$id=I('get.id');
		$productinfo=$productModel->where('product_id=%d',$id)->find();
		//接线图
		$jiexiantu=$downloadModel->where('product_id=%d and down_type=3',$id)->getField("down_value");
		//产品图片
		$productimg=$productimgModel->where('product_id=%d',$id)->getField("product_img");
		//参数
		$parameterlist=$parameterModel->where('product_id=%d',$id)->order("para_id asc")->field("item_id,para_value")->select();
		foreach($parameterlist as $key=>$value){
			$parameterlist[$key]["item_id"]=$parameteritemModel->where("item_id=%d",$value['item_id'])->getField("item_title");
		}
		vendor("PHPMailer.PHPMailer");
		$customerlist=$customerModel->select();
		//添加收件人,可添加多人
		foreach($customerlist as $a){
			
			//实例化phpmailer		
			$phpmailer=new \PHPMailer();  
			//用SMTP协议来发送邮件
			$phpmailer->IsSMTP(); 
			//设置字符编码
			$phpmailer->CharSet='utf-8';
			//设置发送地址和用户名密码
			$phpmailer->Host="smtp.exmail.qq.com";
			$phpmailer->SMTPAuth=true;
			$phpmailer->Username='smartgen@smartgen.cn';
			$phpmailer->Password='Smartgen980318';
			//$phpmailer->SMTPSecure='ssl';
			//$phpmailer->Port=465;
			//设置邮件头信息
			$phpmailer->From='smartgen@smartgen.cn';
			$phpmailer->FromName='SmartGen';
			$phpmailer->Subject='新品推荐-'.$productinfo['product_name'].$productinfo['product_feature'];
			$phpmailer->IsHTML(true);
			$strtop='
				<br>
				<div style="padding-left:50px;">
					<a href="http://www.smartgen.com.cn/index.php" target="_blank">
					<img src="http://www.smartgen.com.cn/view/front/userimage/l_logo.png">
					</a>
				</div>
				<br>';
			$strproductimg='<div><table width="100%"><tr><td width="50%"><center><a href="http://www.smartgen.com.cn/product.php?cat_id='.$productinfo['cat_id'].'&product_id='.$productinfo['product_id'].'" target="_blank" title="点击查看详情"><img src="http://www.smartgen.com.cn/'.$productimg.'"/></a></center></td><td width="50%"><center><a href="http://www.smartgen.com.cn/product.php?cat_id='.$productinfo['cat_id'].'&product_id='.$productinfo['product_id'].'" target="_blank" title="点击查看详情"><img width="80%" src="http://www.smartgen.com.cn/'.$jiexiantu.'"></a></center></td></tr><tr><td><center><h3><a href="http://www.smartgen.com.cn/product.php?cat_id='.$productinfo['cat_id'].'&product_id='.$productinfo['product_id'].'"  style="text-decoration:none; color:#000000" target="_blank" title="点击查看详情">'.$productinfo['product_name'].'</a></h3></center></td><td><center><h3><a href="http://www.smartgen.com.cn/product.php?cat_id='.$productinfo['cat_id'].'&product_id='.$productinfo['product_id'].'" style="text-decoration:none; color:#000000" target="_blank" title="点击查看详情">接线图</a></h3></center></td></tr></table></center></div>';
			if(empty($parameterlist)){
				$strbody='<div style="background-color:#eeeeee"><br><table width="100%"><tr><td width="100%" style="padding-left:50px;">'.$productinfo['product_desc'].'</td></tr></table>';
			}else{
				$strpara="";
				$flag=0;
				foreach($parameterlist as $value){
					if($flag==0){
						$strpara=$strpara.'<tr><td style="background-color:#ffffff;">'.$value['item_id'].'</td><td style="background-color:#ffffff;">'.$value['para_value'].'</td></tr>';
						$flag=1;
					}else{
						$strpara=$strpara.'<tr><td style="background-color:#dddddd;">'.$value['item_id'].'</td><td style="background-color:#dddddd;">'.$value['para_value'].'</td></tr>';
						$flag=0;
					}
					
				}
				$strbody='<div style="background-color:#eeeeee"><br><table width="100%"><tr><td width="50%" style="padding-left:50px;"><center><strong><h3>产品简介</h3></strong></center>'.$productinfo['product_desc'].'</td><td width="50%" valign="top" style="padding-left:50px;"><center><strong><h3>参数表</h3></strong></center><table width="100%" style="margin-top:10px;"><tr><td width="50%" style="background-color:#000066; color:#FFFFFF;"><strong>功能</strong></td><td width="50%" style="background-color:#000066; color:#FFFFFF;"><strong>参数</strong></td></tr>'.$strpara.'</table></td></tr></table>';
			}
			
			$strbottom='
			<div style="background-color:#999999;">
				<br>
				<table width="100%">
					<tr>
						<td width="70%">
							<p style="color:#FFFFFF;padding-left:50px;">Web：<a style="text-decoration:none; color:#FFFFFF" href="http://www.smartgen.com.cn" target="_blank">中文</a>&nbsp;·&nbsp;<a style="text-decoration:none; color:#FFFFFF" href="http://www.smartgen.hk" target="_blank">繁体</a>&nbsp;·&nbsp;<a style="text-decoration:none; color:#FFFFFF" href="http://www.smartgen.cn" target="_blank">English</a>&nbsp;·&nbsp;<a style="text-decoration:none; color:#FFFFFF" href="https://shop113335048.taobao.com" target="_blank">淘宝商城</a></p>
						</td>
						<td rowspan="7" align="right">
							<center><img width="80%" src="http://www.smartgen.com.cn/view/front/userimage/app_download.png"><br>
							<p style="color:#FFFFFF;">众智产品 / SmartGen Product</p></center>
						</td>
						<td rowspan="7" align="right">
							<center><img width="80%" src="http://www.smartgen.com.cn/view/front/userimage/yun.jpg"><br>
							<p style="color:#FFFFFF;">众智云 / SmartGen Cloud</p></center>
						</td>
					</tr>
					<tr>
						<td><p style="color:#FFFFFF;padding-left:50px;">地址：中国·河南省郑州高新技术开发区金梭路28号</p></td>
					</tr>
					<tr>
						<td><p style="color:#FFFFFF;padding-left:50px;">Add：No.28 Jinsuo Road, Zhengzhou City, Henan Province, China</p></td>
					</tr>
					<tr>
						<td><p style="color:#FFFFFF;padding-left:50px;">Tel：0086-371-67988888/67981000(overseas)</p></td>
					</tr>
					<tr>
						<td><p style="color:#FFFFFF;padding-left:50px;">Fax：0086-371-67992952</p></td>
					</tr>
					<tr>
						<td><p style="color:#FFFFFF;padding-left:50px;">E-mail：sales@smartgen.cn</p></td>
					</tr>
					<tr>
						<td><p style="color:#FFFFFF;padding-left:50px;">Copyright&copy; Since 1998 SmartGen</p></td>
					</tr>
				</table>
				<br>
				</div></div>';
			
			
			$phpmailer->Body=$strtop.$strproductimg.$strbody.$strjiexian.$strbottom;
			$phpmailer->AddAddress($a['email'],$a['email']);
			$phpmailer->send();
		}
		$this->ajaxReturn(array(
			'state'=>'ok',
			'info' => '成功'
		));
	}
}
?>