<?php
namespace Home\Controller;
use Common\Controller\AuthController;
/*
*author:Xyh
*content:返修审核
*/
class FanxiushenhejsonController{
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
}
?>
