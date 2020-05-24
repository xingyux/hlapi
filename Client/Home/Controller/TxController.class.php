<?php
namespace Home\Controller;
use Think\Controller;
class TxController extends LoginController {
	
	
    public function index(){
		$session=session("mt_rand_checked");
		$res=$this->ApiReturn(array("mt_rand_checked"=>$session));
		if(!empty($_POST["submit"])){
			$this->ajaxreturn($res);die;
		}
		$this->assign('res',$res);
	
		$this->display();
		
       }

function qrcode(){
	$session=session("mt_rand_checked");
	$res=$this->ApiReturn(array("mt_rand_checked"=>$session));
	$this->ajaxreturn($res);die;
}
function withdrawcash(){
	$session=session("mt_rand_checked");
	$res=$this->ApiReturn(array("mt_rand_checked"=>$session));
	$this->ajaxreturn($res);die;	
	
}
function aliup(){
		$session=session("mt_rand_checked");
	
		if(!empty($_GET["img"])){
			$this->assign('img',str_ireplace("http;", "//" , $_GET["img"]));
			$this->display();
			die;
			
			
		}
		
		$thisUrl="//" . $_SERVER['SERVER_NAME'] . U("aliup");
		
		$res=$this->ApiReturn(array("mt_rand_checked"=>$session,"returnhost"=>base64_encode($thisUrl)));
		
		Header("Location: {$res['url']}");
		die();
	
}
	  
}