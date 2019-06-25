<?php
//ajax分割上传大文件
define('ACC',true);
require('../include/init.php');

$filename=ROOT.'data/download/'.$_POST['name'];
if($_POST['flag']==1){
	if(file_exists($filename)){
		unlink($filename);
	}
}

move_uploaded_file($_FILES['part']['tmp_name'],'temp.lc');
file_put_contents($filename,file_get_contents('temp.lc'),FILE_APPEND);
unlink('temp.lc');

echo '文件上传完成';



?>