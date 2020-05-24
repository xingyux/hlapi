<?php
namespace Home\Controller;
use Think\Controller;
class PricesettingController extends LoginController {
	
	
    public function index(){
		$ses = session('USER_INFO');
		$conf = getConfig();
		$chekced=($conf["acname"]==$ses["username"]) ? true : false;
		if(I("get.action")=="clearcache"){
			if(!$chekced){
				$this->error("更新成功",U(ACTION_NAME));die;
			}	
			S(array('type'=>'File','prefix'=>'servers','expire'=>0));
			S("servers",null);
			$this->success("更新成功",U("index"));die;			
		}
		if(I("get.action")=="update"){

		if(!$chekced){
			$this->error("更新成功",U(ACTION_NAME));die;
		}		
			
			$valuecacheAPI=$this->Api(array("cachetime"=>time()),"Cache","servers");
			$valuecache=$valuecacheAPI["cache"];
			$flags=array();
			foreach($valuecache as $k=>$v){
				$flags[]=$k;
				$find=M("servers")->where(array("flag"=>$k))->find();
				if($find){
					$res=M("servers")->where(array("id"=>$find["id"]))->save($v);
				}else{
					$res=M("servers")->add($v);
				}
				if($res===false){
					
				}
			}
			M("servers")->where(array("flag"=>array("NOT IN",$flags)))->delete();
			
			
			S(array('type'=>'File','prefix'=>'servers','expire'=>0));
			S("servers",null);
			$this->success("同步成功",U("index"));die;
		}
		
			if(IS_POST){
				$res=$this->API();
				if($chekced){
				M("servers")->where(array("flag"=>I("post.flag")))->save(array("name"=>$_POST["name"]));
				S(array('type'=>'File','prefix'=>'servers','expire'=>0));
				S("servers",null);
				}
				$this->success("设置成功",U("index"));die;
			}		
		
		$servers=ReadServersCache("*","*");
		
		$this->assign('servers',$servers);
		$this->assign('chekced',$chekced);
		$this->display();
		
       }
	   Public function product(){
	   	$conf2 = getConfig();
	   	$ses2 = session('USER_INFO');
		   $chekced=($conf2["acname"]==$ses2["username"]) ? true : false;
		   $agent=I("get.agent");
		   
		if(I("get.action")=="clearcache"){
			if(!$chekced){
				$this->error("更新成功",U(ACTION_NAME,array("agent"=>$agent)));die;
			}	
			S(array('type'=>'File','prefix'=>'product'.$agent,'expire'=>0));
			S("product",null);
			$this->success("更新成功",U("product",array("agent"=>$agent)));die;			
		}
		if(I("get.action")=="update"){

		if(!$chekced){
			$this->error("更新成功",U(ACTION_NAME,array("agent"=>$agent)));die;
		}		
			
			$valuecacheAPI=$this->Api(array("cachetime"=>time(),"serveragent"=>$agent),"Cache","product");
			$valuecache=$valuecacheAPI["cache"];
			$ids=array();
			foreach($valuecache as $k=>$v){
				$ids[]=$k;
				$find=M("product")->where(array("id"=>$k))->find();
				if($find){
					$data=$v;
					
					M("product")->where(array("id"=>$find["id"]))->save($data);
				}else{
					M("product")->add($v);
				}
			}
			M("product")->where(array("agent"=>$agent,"id"=>array("NOT IN",$ids)))->delete();
			S(array('type'=>'File','prefix'=>'product'.$agent,'expire'=>0));
			S("product",null);
			$this->success("更新成功",U("product",array("agent"=>$agent)));die;
		}
		
		   $servers=ReadServersCache($agent,"*");
		   $product=ReadProductCache("*",$agent,"*");
		//我的产品价格
			$valuecacheAPI=$this->Api(array("cachetime"=>time(),"serveragent"=>$agent),"Cache","myproduct");
			
			$myproduct=$valuecacheAPI["cache"];
			//print_r($myproduct);die;
			$this->assign('list',$product);
			$this->assign('myproduct',$myproduct);
			$this->assign('agent',$agent);
			$this->assign('chekced',$chekced);
			$this->assign('servers',$servers);
		  // print_r($product);die;
		   $this->display();
	   }
	   function pricetype(){
		   
			if(IS_POST){
				
				$res=$this->API(array("editaction"=>1));
				

			
				$this->success("设置成功",U("pricetype",$_GET));die;
			}		   
		   
		$res=$this->ApiReturn();
		$this->assign('res',$res);

		$this->display();		   
		   

	   }
	  function agentprice(){
		  
		  
			if(IS_POST){
				
				$res=$this->API(array("editaction"=>1));
				

			
				$this->success("设置成功",U("agentprice",$_GET));die;
			}		  
		  $servers=ReadServersCache(I("get.agent"),"*");$this->assign('servers',$servers);
		  		  (int)$id=I("get.id");
		  if($id!=0){
			  $product=ReadProductCache($id,I("get.agent"),"*","id,name");
	
			  $this->assign('product',$product);
		  }
		$res=$this->ApiReturn();
		$this->assign('res',$res);

		  $this->display();
	  }
	  function sellprice(){
		  (int)$id=I("get.id");
		if(IS_POST){
				
				$res=$this->API(array("editaction"=>1));
				
			$arr=$_GET;
			unset($arr["id"]);
			$arr=array_merge($arr,array("action"=>"update"));
			$this->success("设置成功",U("product",$arr));die;
				
			}		  
		  $servers=ReadServersCache(I("get.agent"),"*");$this->assign('servers',$servers);
		  
		  if($id!=0){
			  $product=ReadProductCache($id,I("get.agent"),"id,name");
	
			  $this->assign('product',$product);
		  }
		$res=$this->ApiReturn();
		$this->assign('res',$res);
		  
		  $this->display();
	  }
	  function apiset(){
		  
		if(IS_POST){
				
				$res=$this->API(array("editaction"=>1));
		
			$this->success("设置成功",U("index"));die;
				
			}			  
		 
		$servers=ReadServersCache(I("get.agent"),"*");$this->assign('servers',$servers);
		$res=$this->ApiReturn();
		
	//	redirect( $res["link"] );
		
		$this->assign('res',$res);
		  
		  $this->display();		  
	  }
	  public function getbatchserver(){
		  
		  $valuecacheAPI=$this->Api(array("cachetime"=>time()),"Cache","servers");
		  $server=$valuecacheAPI["cache"];
			  foreach($server as $k=>&$v){
				  $servers=ReadServersCache($v["flag"],"*");
				  $v["statebuy"] = empty($servers) ? "n" : "y";
			  }
			return $server;
	  }
	  public function batch(){
	

		   
			  
			  
			 

			  
			  	   
		   
		  $action=I("get.action");
		  $this->assign('tablib',I('get.tab'));
		  if($action=="servers"){
			$this->assign('res',$this->getbatchserver());	
		  $Res=$this->ApiReturn(null,null,"pricetype");
		  $pricetype=$Res["pricetype"];
		   $this->assign('pricetype',$pricetype);
		  
			  $getpricetypeserver=$this->ApiReturn(null,null,"getpricetypeserver");
			  $pricetypeserver=$getpricetypeserver["pricetype_discount"];

			  $this->assign('pricetypeserver',$pricetypeserver);
			  $this->display("batchinfo");
			  die;
		  }
		  if($action=="product"){

					  
		  $Res=$this->ApiReturn(null,null,"pricetype");
		  $pricetype=$Res["pricetype"];
		  $this->assign('pricetype',$pricetype);
		  
			  $getpricetypeserver=$this->ApiReturn(null,null,"getpricetypeproduct");
			  $pricetypeserver=$getpricetypeserver["pricetype_discount"];

	  foreach($pricetypeserver as $k=>&$v){
				  $servers=ReadProductCache($v["id"],$v["agent"],"*");
				  $v["statebuy"] = empty($servers) ? "n" : "y";
			  }			  
			  $this->assign('agent',I("get.agent"));
			 $this->assign('res',$pricetypeserver);
			  $this->display("batchproinfo");
			  
			  die;
		  }
		  $this->assign('res',$this->getbatchserver());	
		  $this->display();
	  }
	  
	  function updateProduct($agent,$pro_id=null){
					$valuecacheAPI=$this->Api(array("cachetime"=>time(),"serveragent"=>$agent,"pid"=>$pro_id),"Cache","product");
					$valuecache=$valuecacheAPI["cache"];
					$ids=array();
					foreach($valuecache as $k=>$v){
						$ids[]=$k;
						$find=M("product")->where(array("id"=>$k))->find();
						if($find){
							$data=$v;
					
							M("product")->where(array("id"=>$find["id"]))->save($data);
						}else{
							M("product")->add($v);
						}
			}
			if(empty($pro_id)){
				M("product")->where(array("agent"=>$agent,"id"=>array("NOT IN",$ids)))->delete();
			}
			
	  }
	  
	  function domoney(){
		
		  $Res=$this->ApiReturn();
		  
		  $checkWebUser=checkWebUser();
		  if($checkWebUser&&I("post.typeid")==0){
			  $agent=I("post.agent");
			  if($agent!="0"){
					$this->updateProduct($agent);
					delDirAndFile(APP_PATH . "Runtime/");
				}else{
					$res=M("servers")->field("flag")->select();
					foreach($res as $k=>$v){
						$this->updateProduct($v["flag"]);
					}
					delDirAndFile(APP_PATH . "Runtime/");
					
				}
		  }
		  
		  $this->ajaxreturn($Res);
	  }
	  function doproductmoney(){
		
		  $Res=$this->ApiReturn();
		  
		  $product=$Res["product"];

		   $checkWebUser=checkWebUser();
		  if($checkWebUser&&I("post.typeid")==0){
			  $agent=I("post.agent");
			  $pid=I("post.pid");
			  if($pid==0){
				$pid=null;
			  }
		  $this->updateProduct($agent,$pid);
			delDirAndFile(APP_PATH . "Runtime/");
			
		  }
		  
		  $this->ajaxreturn($Res);
	  }	  
	  function dodel(){
		  $agent=I("post.agent");
		   $checkWebUser=checkWebUser();
		  if(!$checkWebUser){
			  $this->ajaxreturn(array("code"=>1,"message"=>"没有权限"));die;
		  }
		  if(empty($agent)){
			  $this->ajaxreturn(array("code"=>1,"message"=>"参数错误"));die;
		  }
		  $res=M("product")->where(array("agent"=>$agent))->delete();
		  if($res===false){
			  $this->ajaxreturn(array("code"=>1,"message"=>"清理产品失败"));die;
		  }
		  $res=M("servers")->where(array("flag"=>$agent))->delete();
		  if($res===false){
			  $this->ajaxreturn(array("code"=>1,"message"=>"清理机房失败"));die;
		  }
		 
		  
			$clear=delDirAndFile(APP_PATH . "Runtime/");
			if($clear===false){
				$this->ajaxreturn(array("code"=>1,"message"=>"清理缓存失败"));die;
			}			  
		  

			$re=getConfig();		  
			$this->ajaxreturn(array("code"=>0,"message"=>"停止销售成功"));die;
	  }
}