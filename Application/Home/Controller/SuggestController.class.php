<?php
namespace Home\Controller;
use Common\Controller\AuthController;
class SuggestController extends AuthController  {
	
    public function index(){
		$model=D('Suggest');
		$addid=I('post.uid');
		$datalist=$model->where("addid='%s'",$addid)->field("id,type,content,addtime,state")->select();
		if($datalist){
			foreach($datalist as $key=>$value){
				switch($value['type']){
					case 0:
						$datalist[$key]['type']='意见或建议';
						break;
					case 1:
						$datalist[$key]['type']='安全隐患';
						break;
				}
				switch($value['state']){
					case 0:
						$datalist[$key]['state']='未处理';
						break;
					case 1:
						$datalist[$key]['state']='已采纳';
						break;
					case 2:
						$datalist[$key]['state']='未采纳';
						break;
					case 3:
						$datalist[$key]['state']='处理中';
						break;
					case 4:
						$datalist[$key]['state']='已完成';
						break;
				}
				$datalist[$key]['addtime']=date("Y-m-d",$value['addtime']);
			}
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
		$model=D('Suggest');
		$data=array();
		$data['type']=I('post.type');
		$data['content']=I('post.content');
		$data['img']=I('post.img');
		$data['addid']=I('post.uid');
		$data['addtime']=time();
		//目录
		$rootPath = './Public/data/suggest/';
		$path = 'data/suggest/';
		//前面
		$name=time();
		if(!empty($data['img'])){
			$data['img']=base64_decode($data['img']);
			file_put_contents($rootPath.$name.'.jpg',$data['img']);
			$data['img']=$path.$name.'.jpg';
		}
		//修改
		$flagb=$model->add($data);
		if($flagb){
			$data['state']='access';
			$data['info']='感谢您提的建议，我们会在第一时间处理！';
		}else{
			$data['state']='error';
			$data['info']='添加信息失败！';
		}
	}
	public function typelist(){
		$datalist=array(0=>"意见或建议",1=>"安全隐患");
		$data['state']='access';
		$data['info']='成功！';
		$data['data']=$datalist;
		header('Content-Type:text/html; charset=utf-8');
        exit(json_encode($data,JSON_UNESCAPED_UNICODE));
	}
}
?>