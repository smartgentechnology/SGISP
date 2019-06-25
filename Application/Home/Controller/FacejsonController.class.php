<?php
namespace Home\Controller;
class FacejsonController {
    public function dis(){
		$model=D('Face');
		$datalist=array();
		$datalist=$model->field('id,addtime')->select();
		//$datalist=$model->field('phone,cdata')->select();
		if(!empty($datalist)){
			//foreach($datalist as $key=>$value){
			//	$datalist[$key]['cdata']=explode(",",$value['cdata']);
			//}
			$data['state']='access';
			$data['info']='查询成功！';
			$data['data']=$datalist;
		}else{
			$data['state']='error';
			$data['info']='查询错误！';
		}
		header('Content-Type:text/html; charset=utf-8');
        exit(json_encode($data,JSON_UNESCAPED_UNICODE));
    }
	public function find(){
		$model=D('Face');
		$id=I('post.id');
		$datalist=$model->where("id=%d",$id)->field('phone,cdata')->find();
		if(!empty($datalist)){
			$data['state']='access';
			$data['info']='查询成功！';
			$data['data']=$datalist;
		}else{
			$data['state']='error';
			$data['info']='查询错误！';
		}
		header('Content-Type:text/html; charset=utf-8');
        exit(json_encode($data,JSON_UNESCAPED_UNICODE));
    }
	
	public function add(){
		$model=D('Face');
		$json = file_get_contents("php://input");
    	$data = json_decode($json, true);
		$data['cdata']=implode(",",$data['cdata']);
		$data['addtime']=time();
		if(!empty($data['phone']) && strlen($data['phone'])==11){
			$flaga=$model->where("phone='%s'",$data['phone'])->find();
			if($flaga){
				$id=$flaga["id"];
				unset($flaga["id"]);
				$flagc=$model->where("id=%d",$id)->save($flaga);
				if($flagc!==false){
					$datalist['state']='access';
					$datalist['info']='人脸更新成功！';
				}else{
					$datalist['state']='error';
					$datalist['info']='人脸更新失败！';
				}
				
			}else{
				$flagb=$model->add($data);
				if($flagb!==false){
					$datalist['state']='access';
					$datalist['info']='注册成功！';
				}else{
					$datalist['state']='error';
					$datalist['info']='注册失败！';
				}
			}
		}else{
			$datalist['state']='error';
			$datalist['info']='注册失败！';
		}
		
		header('Content-Type:text/html; charset=utf-8');
        exit(json_encode($datalist,JSON_UNESCAPED_UNICODE));
    }
}
?>