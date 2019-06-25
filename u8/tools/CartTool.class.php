<?php
/*
购物车类
1、购物车的信息全局有效
SESSION 或数据库
2、购物车的实例只能有一个
单例实现

功能分析
判断商品是否存在
添加商品
删除商品
修改商品的数量
查询购物车的商品种类
查询购物车的商品总数
查询购物车的商品总金额
返回购物车里的所有商品
清空购物车

*/
defined('ACC')||exit('对不起！你无权访问！');//给当前文件上锁

class CartTool{
	private static $ins=null;
	private $items=array();
	//防止被继承构造函数
	protected function __construct(){
		
	}
	//防止被克隆
	protected function __clone(){
	
	}
	//单例
	protected static function getIns(){
		if(!(self::$ins instanceof self)){
			self::$ins=new self();
		}
		return self::$ins;
	}
	public static function getCart(){
		if(!isset($_SESSION['cart'])|| !($_SESSION['cart'] instanceof self)){
			$_SESSION['cart']=self::getIns();
		}
		return $_SESSION['cart'];
	}
	/*
	添加商品
	$goods_id 是商品主键
	$goods_name  是商品名称
	$
	*/
	public function addItem($id){
		//如果该商品已经存在，则返回
		if($this->hasItem($id)){
			return ;
		}else{
			$item=array();
			$item['product_id']=$id;
			$this->items[$id]=$item;
		}
	}
	//更新商品
	public function updateItem($xuhao,$id){
		$sum=$this->getCat();
		if($xuhao<=$sum){
			$num=1;
			foreach($this->items as $key=>$value){
				if($xuhao==$num){
					unset($this->items[$key]);
					$this->addItem($id);
					return;
				}
				$num++;
			}
		}else{
			$this->addItem($id);
		}
	}
	//删除商品
	public function delItem($id){
		unset($this->items[$id]);
	} 
	
	//判断某商品是否存在
	public function hasItem($id){
		return array_key_exists($id,$this->items);
	}
	//查询购物车中商品的个数
	public function getCat(){
		return count($this->items);
	}
	//返回购物车中的所有商品
	public function getAllGoods(){
		return $this->items;
	}
	
	//清空购物车
	public function clear(){
		$this->items=array();
	}
	

}
/*
$cart=CartTool::getCart();
if($_GET['test']=='add'){
$cart->addItem(1,'矿泉水',5,1);
echo 'ok';	
}elseif($_GET['test']=='fanzhou'){
$cart->addItem(2,'方舟',100,1);
echo 'ok';	
}elseif($_GET['test']=='clear'){
	$cart->clear();
}elseif($_GET['test']=='show'){
	print_r($cart->getAllGoods());
	echo '<br>';
	echo '共',$cart->getCat(),'种',$cart->getNum(),'个商品<br>';
	echo '共',$cart->getPrice(),'元钱';

}else{
	print_r($cart);
}
*/

?>