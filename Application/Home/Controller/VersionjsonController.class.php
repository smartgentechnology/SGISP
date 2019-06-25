<?php
namespace Home\Controller;
class VersionjsonController {
    public function check(){
		//OA部门信息表
		$Model=M('version');
		$datalist=$Model->where('id=1')->field('version,udate,address')->find();
		$data['state']='access';
		$data['info']='查询成功！';
		$data['data']=$datalist;
		header('Content-Type:text/html; charset=utf-8');
        exit(json_encode($data,JSON_UNESCAPED_UNICODE));
    }
}
?>