<?php
//自动生成缩略图、水印
defined('ACC')||exit('对不起！你无权访问！');//给当前文件上锁

class ImageTool {
	
	
	/*
	得到图片文件信息
	array getimagesize()
	索引 0 包含图像宽度的像素值，索引 1 包含图像高度的像素值。索引 2 是图像类型的标记：1 = GIF，2 = JPG，3 = PNG，4 = SWF，5 = PSD，6 = BMP，7 = TIFF(intel byte order)，8 = TIFF(motorola byte order)，9 = JPC，10 = JP2，11 = JPX，12 = JB2，13 = SWC，14 = IFF，15 = WBMP，16 = XBM。
	得到图片文件后缀
	string image_type_to_extension  ( int $imagetype  [, bool $include_dot  = TRUE    ] )
	*/
	protected static function imgInfo($file){
		if(!file_exists($file)){
			return false;
		}
		$info = getimagesize($file);
		if($info==false){
			return false;
		}
		$imginfo['width']=$info[0];
		$imginfo['height']=$info[1];
		$imginfo['ext']=substr($info['mime'],strpos($info['mime'],'/')+1);
		return $imginfo;
	}
	/*
	加水印
	$sim 原图
	$water
	$save保存路径
	$alpha 透明度
	$pos 水印位置 0左上,1右上,2左下,3右下
	
	*/
	public static function addWater($simg,$water,$save=null,$alpha=50,$pos=3){
		if(!file_exists($simg) || !file_exists($water)){
			return false;
		}
		$simginfo=self::imgInfo($simg);
		$waterinfo=self::imgInfo($water);
		if(($waterinfo['width'] > $simginfo['width']) || ($waterinfo['height'] > $simginfo['height'])){
			return false;
		}
		$simgfun='imagecreatefrom'.$simginfo['ext'];
		$waterfun='imagecreatefrom'.$waterinfo['ext'];
		if(!function_exists($simgfun) || !function_exists($waterfun)){
			return false;
		}
		//创建画布
		$sim=$simgfun($simg);
		$wim=$waterfun($water);
		
		//加水印
		
		switch($pos){
			case 0: //左上角
				$posx=0;
				$posy=0;
				break;
			case 1: //右上角
				$posx=$simginfo['width']-$waterinfo['width'];
				$posy=0;
				break;
			case 2: //左下角
				$posx=0;
				$posy=$simginfo['height']-$waterinfo['height'];
				break;
			default: //右下角
				$posx=$simginfo['width']-$waterinfo['width'];
				$posy=$simginfo['height']-$waterinfo['height'];
				break;
		}
		imagecopymerge($sim,$wim,$posx,$posy,0,0,$waterinfo['width'],$waterinfo['height'],$alpha);
		
		//保存
		if(!$save){
			$save=$simg;
			unlink($simg);
		}
		
		$createfun='image'.$simginfo['ext'];
		$createfun($sim,$save);
		
		imagedestroy($sim);
		imagedestroy($wim);
		return true;
	}
	/*
	生成缩略图
	 等比例缩放两边留白
	*/
	public static function thumb($simg,$save,$width=200,$height=200){
		if(!file_exists($simg)){
			return false;
		}
		$simginfo=self::imgInfo($simg);
		if($simginfo==false){
			return false;
		}
		//计算宽、高缩放比例取最小缩放比例 
		$calc=min($width/$simginfo['width'],$height/$simginfo['height']);
		$dw=(int)$simginfo['width']*$calc;
		$dh=(int)$simginfo['height']*$calc;
		$dx=(int)($width-$dw)/2;
		$dy=(int)($height-$dh)/2;
		//创建原始画布
		$simgfun='imagecreatefrom'.$simginfo['ext'];
		$sim=$simgfun($simg);
		//创建缩略画布
		$tim=imagecreatetruecolor($width,$height);
		//创建背景颜色
		$white=imagecolorallocate($tim,255,255,255);
		//填充缩略图的背景颜色为白色
		imagefill($tim,0,0,$white);
		/*
		开始创建缩略图
		bool imagecopyresampled  ( resource $dst_image  , resource $src_image  , int $dst_x  , int $dst_y  , int $src_x  , int $src_y  , int $dst_w  , int $dst_h  , int $src_w  , int $src_h  )
		*/
		imagecopyresampled($tim,$sim,$dx,$dy,0,0,$dw,$dh,$simginfo['width'],$simginfo['height']);
		//保存
		if(!$save){
			$save=$simg;
			unlink($simg);
		}
		
		$createfun='image'.$simginfo['ext'];
		$createfun($tim,$save);
		
		imagedestroy($sim);
		imagedestroy($tim);
		return true;
	}
}














?>