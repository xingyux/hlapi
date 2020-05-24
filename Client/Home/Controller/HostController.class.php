<?php
namespace Home\Controller;
use Think\Controller;
use Common\Util\Page;
class HostController extends HomeController {
    public function index(){
		$servers_where["servertype"]="host";
		$servers_where["state"]=0;
		$page=((int)$_GET["page"]<1) ? 1 : $_GET["page"];
		$servers=M("servers")->where($servers_where)->select();
		if($servers){
		$agentflag=array_column($servers,"flag");
		
		$product_where["agent"]=array("IN",$agentflag);
		
			$stringsearch=" 1=1";
		if(!empty($_GET["room"])){
			$stringsearch .=" and agent='" . I("get.room") . "'";
		}
		

		if(!empty($_GET["address"])){
			$stringsearch .=" and find_in_set('" . I("get.address") . "',address)";
		}
		$product_where["_string"]=$stringsearch;
		$product_where["state"]=0;

		$proarray = M("product")->field("address")->where($product_where)->select();

		$DictionaryCache=array();

		foreach(array_column($proarray,"address") as $k=>$v){
			if(empty($v)) continue;
			$vv=explode(",",$v);
			foreach($vv as $kk=>$vv){
				$DictionaryCache["address"][]=$vv;
			}
		}		

		$DictionaryCache["address"]=array_unique($DictionaryCache["address"]);
		asort($DictionaryCache["address"]);


		$product=M("product")->where($product_where)->order("ord asc,id asc")->page("{$page},12")->select();
		
		$count      =  M("product")->where($product_where)->count();
		
		
		
		$Page       =  new Page($count,12);
		
		$show       = $Page->showFront();
	}else{
			$product=null;
			$count=0;
			$Page=null;
			$show=null;
		}
		$this->assign('page',$show);
		$this->assign('link',$_GET);
		$this->assign('servers',$servers);
		$this->assign('DictionaryCache',$DictionaryCache);
		$this->assign('product',$product);
		$this->display();
		
       }

}