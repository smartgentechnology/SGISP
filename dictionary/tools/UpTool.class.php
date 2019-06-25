<?php
/*
单/多文件上传类
允许配置文件后缀
允许配置文件的大小
获取文件的后缀
判断文件的后缀
随机生成目录
随机生成文件名
良好的报错支持
*/
defined('ACC')||exit('对不起！你无权访问！');//给当前文件上锁

class UpTool{
	protected $allowExt='jpg,jpeg,gif,bmp,png'; //限制文件类型
	protected $filedir='data/source/';
	protected $maxSize=20;//M为单位 限制文件大小
	protected $file=null;//准备储存上传文件的信息
	protected $errnu=0;  //错误代码
	protected $error=array(0=>'无错',1=>'上传文件大小超出系统限制',2=>'上传文件大小超出表单大小',3=>'文件只有部分被上传',4=>'没有文件被上传',6=>'找不到临时文件夹',7=>'文件写入失败',8=>'不允许的文件后缀',9=>'文件大小超出类限制',10=>'目录创建失败',11=>'文件移动失败');//错误类型
	
	//单文件上传
	public  function singeUp($key){
		if(!isset($_FILES[$key])){
			return false;
		}
		$f=$_FILES[$key];
		//检验上传有没有成功
		if($f['error']){
			$this->errnu=$f['error'];
			return false;
		}
		//得到后缀
		$ext=$this->getExt($f['name']);
		
		//判断后缀
		if(!$this->isAllowExt($ext)){
			$this->errnu=8;
			return false;
		}
		//判断文件大小
		if(!$this->isAllowSize($f['size'])){
			$this->errnu=9;
			return false;
		}
		//判断路径传
		$dir=$this->filedir;
		if($dir==false){
			$this->errnu=10;
			return false;
		}
		//$newname=$this->randName().'.'.$ext;
		//检测文件名的编码
		//$encoding = mb_detect_encoding($f['name'],array('ASCII','UTF-8','GB2312','GBK','BIG5'));
		$newname=iconv('UTF-8','GB2312',$f['name']);
		$newfile=ROOT.$dir.$newname;
		if(!move_uploaded_file($f['tmp_name'],$newfile)){
			$this->errnu=11;
			return false;
		}
		$newfile=iconv('GB2312','UTF-8',$newfile);
		return str_replace(ROOT,'',$newfile);
	} 
	
	//img上传
	public  function imgUp($key){
		if(!isset($_FILES[$key])){
			return false;
		}
		$f=$_FILES[$key];
		//检验上传有没有成功
		if($f['error']){
			$this->errnu=$f['error'];
			return false;
		}
		//得到后缀
		$ext=$this->getExt($f['name']);
		
		//判断后缀
		if(!$this->isAllowExt($ext)){
			$this->errnu=8;
			return false;
		}
		//判断文件大小
		if(!$this->isAllowSize($f['size'])){
			$this->errnu=9;
			return false;
		}
		//判断路径传
		$dir=$this->mk_dir();
		if($dir==false){
			$this->errnu=10;
			return false;
		}
		$newname=$this->randName().'.'.$ext;
		$newfile=$dir.'/'.$newname;
		
		if(!move_uploaded_file($f['tmp_name'],$newfile)){
			$this->errnu=11;
			return false; 
		}
		return str_replace(ROOT,'',$newfile);
	} 
	
	//设置限制类型
	public function setExt($exts){
		$this->allowExt=$exts;
	}
	//设置文件目录
	public function setFiledir($dir){
		$this->filedir=$dir;
	}
	//设置限制大小
	public function setSize($size){
		$this->maxSize=$size;
	}
	
	//得到错误信息
	public function getErr(){
		return $this->error[$this->errnu];
	}
	
	//得到上传file文件信息
	protected function getFile($key){
		$this->file=$_FILES[$key];
	}
	
	//获取后缀
	protected function getExt($file){
		$tmp=explode('.',$file);
		return end($tmp);
	}
	
	//判断文件后缀
	protected function isAllowExt($ext){
		$arr=explode(',',$this->allowExt);
		return in_array(strtolower($ext),$arr);
	}
	
	//判断文件大小
	protected function isAllowSize($size){
		return $size <= ($this->maxSize * 1024 *1024);
	}
	
	//按日期自动创建目录
	protected function mk_dir(){
		$dir=ROOT.$this->filedir.date('Ymd',time());
		if(is_dir($dir) || mkdir($dir,0777,true)){
			return $dir;	
		}else{
			return false;
		}		
	}
	
	//生成随机文件名
	protected function randName($length=10){
		$str='abcdefghijklmnopqrstuvwxyz0123456789';
		return substr(str_shuffle($str),0,$length);
	}
	/*
　　 * 分割文件 
　　 * 默认大小 10M=10485760
　　 */

	protected function file_split($file,$dir){
	$block_size=10000000;
	$block_info=array();
	$size=filesize($file);//得到文件大小
	$i=0;
	do{
		$block_info[]=array('size'=>($size>=$block_size?$block_size:$size),'file'=>$file.'.'.($i++).'.esplit');
		$size=$size-$block_size;
		
	}while($size>0);//将文件先标记一下分割段
	$fp = fopen($file,"rb");//将文件绑定到文件流上
	//开始循环分割文件
	foreach ($block_info as $bi) {
		$handle = fopen($bi['file'],"wb");//将标记的分割点绑定到文件流
		fwrite($handle,fread($fp,$bi['size']));//开始分割文件 
		fclose($handle);//关闭文件流
		unset($handle);//删除文件流
	}
	fclose ($fp);
	unset($fp);
	}
	
	/*
　　 * 合并文件
　　 * 如果合并后的文件为 CPCUxcp111.flv.0.esplit 
　　 * 则 file=CPCUxcp111.flv，不包含.x.esplit后缀
　　 * save_file为另存为的文件名
　　 */

	protected function file_combine($file,$save_file=''){
	$filename=basename($file);//获取文件名
	$filepath=dirname($file).'/';//获取文件目录
	$block_info=array();
	
	//统计所有分割文件
	for($i=0;;$i++){
		if(file_exists($file.'.'.$i.'.esplit') && filesize($file.'.'.$i.'.esplit')>0){
			$block_info[]=$file.'.'.$i.'.esplit';
			
		}else{
			break;
		}
	}
	//如果另存文件名有值就另存，没有值就用原文件名
	if($save_file){
		$fp=fopen($save_file,"wb");
	}else{
		$fp=fopen($file,"wb");
	}
	//循环合并文件
	foreach ($block_info as $block_file) {
		$handle = fopen($block_file,"rb");
		fwrite($fp,fread($handle,filesize($block_file)));     
		fclose($handle);
		unset($handle);
		unlink($block_file);
	}
	fclose ($fp);
	unset($fp);
	}
	
}





















?>