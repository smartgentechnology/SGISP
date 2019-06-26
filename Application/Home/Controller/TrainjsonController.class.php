<?php
namespace Home\Controller;
use Common\Controller\AuthController;
/*
*author:Xyh
*content:翻译库
*/
class TrainjsonController{

    public function dis(){//翻译库查询
    $data = array();
    $model=D('Tlibrary');
    $result = array();
	  $result = $model->order("id asc")->select();
    if($result){
        $data['state'] = "access";
        $data['info'] = "查询成功！";
        foreach ($result as $key => $value) {
          $result[$key]['mdate'] = date('Y-m-d',$value['mdate']);
        }
        $data['data'] = $result;
    }else{
        $data['state'] = "error";
        $data['info'] = "查询失败！";
    }
    header('Content-Type:text/html; charset=utf-8');
    exit(json_encode($data,JSON_UNESCAPED_UNICODE));
		}

   public function del(){//翻译库删除
       $date = array();
       $model=D('Tlibrary');
       $id = I('post.id');
       $result = $model->where("id='%d'",$id)->delete();
       if($result){
         $date['state']="access";
         $date['info'] = "删除成功！";
       }else {
         $date['state']="error";
         $date['info'] = "删除失败！";
       }
       header('Content-Type:text/html; charset=utf-8');
       exit(json_encode($date,JSON_UNESCAPED_UNICODE));
   }

   public function search() {//翻译库搜索
     $data=array();
     $keyword=I('get.keyword');
     $model=D('Tlibrary');
     $datalist=array();
     $datalist=$model->where("cn like '%".$keyword."%' or remarks like '%".$keyword."%'")->select();
     if($datalist){
       $data['state']='access';
       $data['info']='查询成功！';
       $data['data']=$datalist;
     }else{
       $data['state']='error';
       $data['info']='未查找到相关记录！';
     }
     header('Content-Type:text/html; charset=utf-8');
     exit(json_encode($data,JSON_UNESCAPED_UNICODE));
   }


     public function add(){//翻译库添加
       $model=D('Tlibrary');
       $jsondata=array();
       $data=array();
       $data['cn']=I('post.cn');
       $data['en']=I('post.en');
       $data['abben']=I('post.abben');
       $data['sp']=I('post.sp');
       $data['jp']=I('post.jp');
       $data['ru']=I('post.ru');
       $data['remarks']=I('post.remarks');
       $data['manager_id']=I('post.uid');
       $data['flag']=I('post.flag');
       //添加时间
       $data['mdate']=time();
       $flaga=$model->where("cn='%s'",$data['cn'])->find();
       if($flaga){
         $jsondata['state']='error';
         $jsondata['info']='该翻译库已存在！';
       }else{
         // 验证通过 写入新增数据
         $flagb=$model->add($data);
         if($flagb){
           $jsondata['state']='access';
           $jsondata['info']='翻译库添加成功！';
         }else{
           $jsondata['state']='error';
           $jsondata['info']='翻译库添加失败！';
         }
       }
       header('Content-Type:text/html; charset=utf-8');
       exit(json_encode($jsondata,JSON_UNESCAPED_UNICODE));
     }

     public function edit(){//翻译库修改
   		$model=D('Tlibrary');
   		$jsondata=array();
   		if(IS_GET){//判断post or get
   			$id=I('get.id');
   			$result=$model->where('id=%d',$id)->find();
   			$result['mdate']=date('Y-m-d',$result['mdate']);
   			$jsondata['state']='access';
   			$jsondata['info']='查询成功！';
   			$jsondata['data']=$result;
   		}else{
   			$id=I('post.id');
   			$data=array();
   		//	$data['id']=I('post.id');
   			$data['cn']=I('post.cn');
   			$data['en']=I('post.en');
   			$data['abben']=I('post.abben');
   			$data['sp']=I('post.sp');
   			$data['jp']=I('post.jp');
   			$data['ru']=I('post.ru');
   			$data['remarks']=I('post.remarks');
   			$data['manager_id']=I('post.uid');
        $data['flag']=I('post.flag');
   				$flagb=$model->where('id=%d',$id)->save($data);
   				if($flagb!==false){
   					$jsondata['state']='access';
   					$jsondata['info']='翻译库修改成功！';
   				}else{
   					$jsondata['state']='error';
   					$jsondata['info']='翻译库修改失败！';
   				}
   		}
   		header('Content-Type:text/html; charset=utf-8');
      exit(json_encode($jsondata,JSON_UNESCAPED_UNICODE));
   	}

   public function info(){//翻译库详情
     $model=D('Tlibrary');
     $jsondata=array();
     $id=I('post.id');
     $result=$model->where('id=%d',$id)->find();
      $result['mdate']=date('Y-m-d',$result['mdate']);
      $jsondata['state']='access';
      $jsondata['info']='查询成功！';
      $jsondata['data']=$result;
      header('Content-Type:text/html; charset=utf-8');
      exit(json_encode($jsondata,JSON_UNESCAPED_UNICODE));
   }

}
?>
