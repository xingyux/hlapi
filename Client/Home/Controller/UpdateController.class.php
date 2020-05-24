<?php
namespace Home\Controller;
use Think\Controller;
use Common\Util\Page;
class UpdateController extends LoginController {
    public function index(){
		$id=I("get.id");
		$page=((int)$_GET["page"]<1) ? 1 : $_GET["page"];
		if(empty($id)){
			$this->error("参数错误");die;
		}
		
		$flag=I("get.flag");
		if(empty($flag)){
			$this->error("参数错误");die;
		}

		$product_where["agent"]="CPZZ";
		$product_where["flag"]=$flag;

		$product_where["state"]=0;
		$product=M("product")->where($product_where)->page("{$page},12")->select();
		if(empty($product)){
			$this->error("此产品无法增值");die;
		}
		$count      =  M("product")->where($product_where)->count();
		
		
		
		$Page       =  new Page($count,12);
		
		$show       = $Page->showFront();
	
		$this->assign('page',$show);
		$this->assign('productid',$id);
		$this->assign('link',$_GET);
		$this->assign('servers',$servers);
		$this->assign('product',$product);
		$this->display();
		
       }

}