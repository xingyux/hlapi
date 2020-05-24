<?php
namespace Home\Controller;
use Think\Controller;
class MoneyController extends LoginController {
	
	
    public function index(){
		
		$res=$this->ApiReturn();
		$this->assign('res',$res);

		$this->display();
		
       }

    public function buy(){
		
		$res=$this->ApiReturn(array("show"=>1),null,"index");
		$this->assign('res',$res);

		$this->display();
		
       }	   
    public function refun(){
		
		$res=$this->ApiReturn(array("show"=>2),null,"index");
		$this->assign('res',$res);

		$this->display();
		
       }	   
		public function pay(){

			$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
			$jsurl = "{$protocol}{$_SERVER[HTTP_HOST]}";
			
		
			$res=$this->ApiReturn(array("returnurl"=>$jsurl));
			$this->success("正在转向充值页面",$res["url"]);
		}
public function paylog(){
		$res=$this->ApiReturn();
		$this->assign('res',$res);

		$this->display();	
}
	  
}