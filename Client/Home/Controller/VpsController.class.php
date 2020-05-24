<?php
namespace Home\Controller;
use Think\Controller;
use Common\Util\Page;
class VpsController extends HomeController {
    public function index(){
		$servers_where["servertype"]="vps";
		$servers_where["state"]=0;
		$page=((int)$_GET["page"]<1) ? 1 : $_GET["page"];
		$servers=M("servers")->where($servers_where)->select();
		if($servers){
		$agentflag=array_column($servers,"flag");
		
		$product_where["agent"]=array("IN",$agentflag);
		$stringsearch=" state=0";
		if(!empty($_GET["room"])){
			$stringsearch .=" and agent='" . $_GET["room"] . "'";
		}
		
		if(!empty($_GET["cpu"])){
			$stringsearch .=" and find_in_set('" . $_GET["cpu"] . "',cpu)";
		}
		if(!empty($_GET["ram"])){
			$stringsearch .=" and find_in_set('" . $_GET["ram"] . "',ram)";
		}
		if(!empty($_GET["address"])){
			$stringsearch .=" and find_in_set('" . $_GET["address"] . "',address)";
		}
		$product_where["_string"]=$stringsearch;
		$product_where["state"]=0;

		$proarray = M("product")->field("address,cpu,ram")->where($product_where)->select();

		$DictionaryCache=array();
		foreach(array_column($proarray,"cpu") as $k=>$v){
			if(empty($v)) continue;
			$vv=explode(",",$v);
			foreach($vv as $kk=>$vv){
				$DictionaryCache["cpu"][]=$vv;
			}
		}
		foreach(array_column($proarray,"ram") as $k=>$v){
			if(empty($v)) continue;
			$vv=explode(",",$v);
			foreach($vv as $kk=>$vv){
				$DictionaryCache["ram"][]=$vv;
			}
		}
		foreach(array_column($proarray,"address") as $k=>$v){
			if(empty($v)) continue;
			$vv=explode(",",$v);
			foreach($vv as $kk=>$vv){
				$DictionaryCache["address"][]=$vv;
			}
		}		
		$DictionaryCache["cpu"]=array_unique($DictionaryCache["cpu"]);
		asort($DictionaryCache["cpu"]);
		$DictionaryCache["address"]=array_unique($DictionaryCache["address"]);
		asort($DictionaryCache["address"]);
		$DictionaryCache["ram"]=array_unique($DictionaryCache["ram"]);
		asort($DictionaryCache["ram"]);		
	


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
		$this->assign('product',$product);
		$this->assign('DictionaryCache',$DictionaryCache);
		$this->display();
		
       }

}