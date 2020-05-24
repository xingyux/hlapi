<?php
namespace Home\Controller;
use Think\Controller;
class AppController extends HomeController {
	
	
    public function info(){
		$action=I("get.action");
		if(empty($action)) $action="index";
		
		$res=$this->ApiReturn(null,null,$action);
		$this->ajaxreturn($res);
		die;
		
       }
    public function getmoneynew(){

		$res=$this->ApiReturn();
		$this->ajaxreturn($res);
		die;		
	}
    public function getmoney(){
        $res=$this->ApiReturn();
        $this->ajaxreturn($res);
        die;
    }
public function changeproductuser(){
		if(!is_login()){
			$this->ajaxreturn( array("code"=>1,"message"=>"请先登录"));die;
		}	
		$res=$this->ApiReturn();
		$this->ajaxreturn($res);
		die;		
}
	public function creatShopUrl(){
		if(!is_login()){
			$this->ajaxreturn( array("code"=>1,"message"=>"请先登录"));die;
		}
		$this->ajaxreturn(array("code"=>0,"url"=>U("Shop/buy",$_POST)));
	}
	  
}