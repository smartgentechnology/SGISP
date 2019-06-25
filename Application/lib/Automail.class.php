<?php
namespace lib;

class Automail {

	//构造方法初始化
	public function sendmail($id) {
		vendor("PHPMailer.class#phpmailer");
		//实例化phpmailer		
		$phpmailer=new PHPMailer();  
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
		$phpmailer->FromName='smartgen';
		$phpmailer->Subject=$subject;
		$phpmailer->IsHTML(true);
		$phpmailer->Body=$body;
		//添加收件人,可添加多人
		$this->phpmailer->AddAddress($receive,$receiveName);
		//发送
		if($phpmailer->send()){
			return "成功";
		}else{
			$message=$phpmailer->ErrorInfo;
			return message;
		}
		
	}
}







?>