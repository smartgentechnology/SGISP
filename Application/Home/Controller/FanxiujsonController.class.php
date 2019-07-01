<?php
namespace Home\Controller;
use Common\Controller\AuthController;
/*
*author:Xyh
*content:返修台账
*/
class FanxiujsonController{
  public function dis(){//返修台账查询
    $data =array();
    $result = D('Fanxiu');
    $all = array();
    $x = I('get.id');
    $all = $result->order("id desc")->limit($x,'20')->select();
    if($all){
      $data['state'] = "access";
      $data['info'] = "查询成功！";
      //调用工具类
  		$fanxiu=new \lib\Fanxiu();
  		$all=$fanxiu->dengji($all);
      $data['date'] = $all;
    }else{
      $data['state'] = "error";
      $data['info'] = "查询失败！";
    }
    header('Content-Type:text/html; charset=utf-8');
    exit(json_encode($data,JSON_UNESCAPED_UNICODE));
  }

   public function search(){//返修台账搜索
     $data=array();
     $keyword=I('get.keyword');
     $model=D('Fanxiu');
     $datalist=array();
     $datalist=$model->where("customer like '%".$keyword."%' or remark like '%".$keyword."%'")->select();
     if($datalist){
       $data['state']='access';
       $data['info']='查询成功！';
       $fanxiu=new \lib\Fanxiu();
       $datalist=$fanxiu->dengji($datalist);
       $data['date'] = $datalist;
     }else{
       $data['state']='error';
       $data['info']='未查找到相关记录！';
     }
     header('Content-Type:text/html; charset=utf-8');
     exit(json_encode($data,JSON_UNESCAPED_UNICODE));
   }

   public function info(){//返修台账详情
     $model=D('Fanxiu');
     $jsondata=array();
     $id=I('post.id');
     $result=$model->where('id=%d',$id)->find();
     if($result){

       $jsondata['state']='access';
       $jsondata['info']='查询成功！';
       $fanxiu=new \lib\Fanxiu();
   	   $result=$fanxiu->info($result);
       $jsondata['date'] = $result;

     }else{
       $jsondata['state']='error';
       $jsondata['info']='查询失败！';
     }
      header('Content-Type:text/html; charset=utf-8');
      exit(json_encode($jsondata,JSON_UNESCAPED_UNICODE));
   }
}

?>
