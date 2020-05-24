<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends HomeController {
    public function index(){
		
		$notice=M("News")->where(array("type"=>"网站公告"))->field("id,title,tim")->limit("0,3")->order("id desc")->select();

		$this->assign('notice',$notice);
		$this->display();
    }

    public function combobox(){
    	$t=I('get.t','host');
    	if(!in_array($t,array('host','vps','server','adsl')))
    		exit;

    	if(I('get.get')){

    		$room=I('get.room');
    		$address=I('get.address');

    		$product_where["agent"]=array("IN",array($room));
			$product_where["state"]=0;

    		$stringsearch="1=1";
    		$stringsearch.=" and agent='".$room."'";
    		$stringsearch.=" and find_in_set('".$address."',address)";

    		$product_where["_string"]=$stringsearch;
    		echo json_encode(M('product')->where($product_where)->order('ord asc,id asc')->limit(6)->select());
    		exit;
    	}else{
			$servers_where["servertype"]=$t;
			$servers_where["state"]=0;
			$servers=M("servers")->where($servers_where)->select();
			$agentflag=array_column($servers,"flag");

			$product_where["agent"]=array("IN",$agentflag);
			$product_where["state"]=0;
			$productList=array();
	    	if($t=='host'){
				$regionList=array();
				foreach ($servers as $index => $server) {
					$product_where["_string"]="agent='".$server['flag']."'";
					$regionList[$index] = M("product")->field("address")->where($product_where)->select();
					$regionList[$index] = array_unique(array_column($regionList[$index],'address'));
					$productList[$index] = M('product')->where($product_where)->order('ord asc,id asc')->limit(6)->select();
				}
		    	$this->assign('servers',$servers);
		    	$this->assign('regionList',$regionList);
	    	}else if($t=='vps'){

				$regionList=array();
				$cpuList=array();
				foreach($servers as $index => $server){
					$product_where["_string"]="state = 0 AND agent='".$server['flag']."'";
					$proarray = M("product")->field("address,cpu")->where($product_where)->select();
					$regionList[$index]=array_unique(array_column($proarray,'address'));
					$cpuList[$index]=array_unique(array_column($proarray,'cpu'));
					$productList[$index] = M('product')->where($product_where)->order('ord asc,id asc')->limit(6)->select();
	    		}
		    	$this->assign('servers',$servers);
		    	$this->assign('regionList',$regionList);
		    	$this->assign('cpuList',$cpuList);
	    	}else if($t=='adsl'){
				$regionList=array();
				$cpuList=array();
				foreach($servers as $index => $server){
					$product_where["_string"] = "state = 0 AND agent='".$server['flag']."'";
					$proarray = M("product")->field("address,cpu")->where($product_where)->select();
					$regionList[$index]=array_unique(array_column($proarray,'address'));
					$cpuList[$index]=array_unique(array_column($proarray,'cpu'));
					$productList[$index] = M('product')->where($product_where)->order('ord asc,id asc')->limit(6)->select();
				}
		    	$this->assign('servers',$servers);
		    	$this->assign('regionList',$regionList);
		    	$this->assign('cpuList',$cpuList);
	    	}else if($t=='server'){
				$regionList=array();
				$cpuList=array();
				foreach($servers as $index => $server){
					$product_where["_string"] = "state = 0 AND agent='".$server['flag']."'";
					$proarray = M("product")->field("address,cpu")->where($product_where)->select();
					$regionList[$index]=array_unique(array_column($proarray,'address'));
					$cpuList[$index]=array_unique(array_column($proarray,'cpu'));
					$productList[$index] = M('product')->where($product_where)->order('ord asc,id asc')->limit(6)->select();
				}
		    	$this->assign('servers',$servers);
		    	$this->assign('regionList',$regionList);
		    	$this->assign('cpuList',$cpuList);
	    	}
	    	$this->assign('t',$t);
	    	$this->assign('productList',$productList);
	    	$this->display();
    	}
    }

}
