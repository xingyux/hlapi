<?php
namespace Home\Controller;
use Think\Controller;
class CronlistController extends LoginController {
	
	
    public function index(){
		
		$res=$this->ApiReturn();
		$this->assign('res',$res);

		$this->display();
		
       }


public function dolist(){
		$res=$this->ApiReturn();
		$this->assign('res',$res);

		$this->display();	
}
	  
}