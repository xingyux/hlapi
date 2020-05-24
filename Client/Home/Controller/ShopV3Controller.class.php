<?php
namespace Home\Controller;
use Think\Controller;
use Common\Util\Page;
class ShopV3Controller extends LoginController {
    public function index(){
	
       }
function buy(){
	

	$res=$this->Api();
    $res['url'] = U('Cronlist/index');
	$this->ajaxreturn($res);

}


	   Public function renew(){
		   if(I("post.buy_choose")=="1"){
		$session_Rand=session("mt_rand");
		if($session_Rand!=I("post.mt_rand")){
			$this->ajaxreturn(array("code"=>1,"message"=>"已处理，请不要重复提交"));die;
		}
		session("mt_rand",null);
		$res=$this->Api();
		
		$this->ajaxreturn($res);		
		   }
		   $product_id=I("post.product_id");
		   $res=$this->Api();
		   
	$session_Rand=session("mt_rand");
	if( empty($session_Rand) ){
		$session_Rand=mt_rand(0,999999);
		session("mt_rand",$session_Rand);
	}
   
		   
		   $res["mt_rand"]=$session_Rand;
		   $this->ajaxreturn($res);
	   }
function increment(){
	
	
	if(I("post.buy_choose")=="1"){
		$session_Rand=session("mt_rand");
		if($session_Rand!=I("post.mt_rand")){
			$this->success("已处理，请不要重复提交",U("Cronlist/index"));die;
		}
		session("mt_rand",null);
$res=$this->Api();		
		$this->success("任务下发成功，请等待管理人员处理",U('Product/order'));die;
	}
	$session_Rand=session("mt_rand");
	if( empty($session_Rand) ){
		$session_Rand=mt_rand(0,999999);
		session("mt_rand",$session_Rand);
	}
	$this->assign('mt_rand',$session_Rand);
$res=$this->Api();
	$this->assign('res',$res);
	$this->display();	
}
function wechatbind(){
	$res=$this->Api();
	
	if(empty($res["wechat"]["qrcode"]["ticket"])){
		$this->assign('errmsg',var_export($res["wechat"]["qrcode"],true));
	}else{
		$this->assign('res',$res);
	}
	
	$this->display();
}

function domain(){
	
	
	if(I("post.buy_choose")=="1"){
		$session_Rand=session("mt_rand");
		if($session_Rand!=I("post.mt_rand")){
			$this->success("已处理，请不要重复提交",U("Cronlist/index"));die;
		}
		session("mt_rand",null);
		$res=$this->Api();
		
		Header("HTTP/1.1 301 Moved Permanently");
		Header("Location: " . U('Cronlist/index'));
	
		die;
		$this->success("任务下发成功，正在转向通知页面",U('wechatbind',array("cron_id"=>$res["cron_id"])));die;
	}
	
	
	$res=$this->Api();
$this->assign('res',$res);
	$session_Rand=session("mt_rand");
	if( empty($session_Rand) ){
		$session_Rand=mt_rand(0,999999);
		session("mt_rand",$session_Rand);
	}
	$this->assign('mt_rand',$session_Rand);	
	$this->display();
}

}