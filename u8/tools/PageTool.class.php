<?php
/*
产品分页

分页导航生成

*/
defined('ACC')||exit('对不起！你无权访问！');

class PageTool{
	protected $total=0;
	protected $perpage=20;
	protected $page=1;
	
	public function __construct($total,$page=false,$perpage=false){
		$this->total=$total;
		if($page){
			$this->page=$page;
		}
		if($perpage){
			$this->perpage=$perpage;
		}
		
	}
	
	//创建分页导航
	
	public function show($pageflag='page'){
		$cnt=ceil($this->total/$this->perpage);//得到总页数
		$uri=$_SERVER['REQUEST_URI'];//得到地址栏上的地址
		$parse=parse_url($uri);//地址解析到数组
		
		$param=array();//存放地址栏的参数
		if(isset($parse['query'])){
			parse_str($parse['query'],$param);
		}
		
		unset($param[$pageflag]);
		
		$url=$parse['path'].'?';
		if(!empty($param)){
			$param=http_build_query($param);
			$url=$url.$param.'&';
		}
		$nav=array();
		$nav[0]='<a href="#">'.$this->page.'</a>';
		
		for($left=$this->page-1,$right=$this->page+1;($left>=1||$right<=$cnt)&& count($nav)<5;){
				if($left>=1){
				array_unshift($nav,'<a href="'.$url.$pageflag.'='.$left.'">['.$left.']</a>');
				$left-=1;
				}
				if($right<=$cnt){
				array_push($nav,'<a href="'.$url.$pageflag.'='.$right.'">['.$right.']</a>');
				$right+=1;
				}
			
		}
		return implode('',$nav);
		
	}
	
}
/*
$page=$_GET['page']?$_GET['page']:1;
$p=new PageTool(20,$page,6);
echo $p->show();
*/










?>