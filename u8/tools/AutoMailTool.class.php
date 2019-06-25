<?php
//密码重置类
defined('ACC')||exit('对不起！你无权访问！');//给当前文件上锁


class AutoMailTool {
	private $Host=null;
	private $Username=null;
	private $Password=null;
	private $phpmailer=null;
	private $conf=array();
	private $message=null;
 
	//构造方法初始化
	public function __construct() {
		require('./lib/PHPMailer/class.phpmailer.php');
		$this->phpmailer=new PHPMailer();  //实例化phpmailer
		$this->conf=conf::getIns();		//得到配置文件
		$this->Host=$this->conf->smtp;
		$this->Username=$this->conf->username;
		$this->Password=$this->conf->password;
	}
	//设置登录信息
 	protected function setlogin(){
		//用SMTP协议来发送邮件
		$this->phpmailer->IsSMTP(); 
		//设置字符编码
		$this->phpmailer->CharSet='utf-8';
		//设置发送地址和用户名密码
		$this->phpmailer->Host=$this->Host;
		$this->phpmailer->SMTPAuth=true;
		$this->phpmailer->Username=$this->Username;
		$this->phpmailer->Password=$this->Password;
	}
	//设置头信息
 	public function setheader($subject='密码重置',$body='Holle world!'){
		$this->setlogin();
		//设置邮件头信息
		$this->phpmailer->From='admin@smartgen.cn';
		$this->phpmailer->FromName='smartgen';
		$this->phpmailer->Subject=$subject;
		$this->phpmailer->IsHTML(true);
		$this->phpmailer->Body=$body;
	}
	public function setaddress($receive,$receiveName){
		//添加收件人
		$this->phpmailer->AddAddress($receive,$receiveName);
	}
	public function send(){
		if($this->phpmailer->send()){
			return true;
		}else{
			$this->message=$this->phpmailer->ErrorInfo;
			return false;
		}
		
	}
	public function getError(){
		return $this->message;
	}
}







?>