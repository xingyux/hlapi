<?php
namespace Home\Controller;
use Think\Controller;
use Common\Util\Page;
class DomainController extends HomeController {
    public function index(){
		
		$this->display();
		
       }
	
public function check(){
	
	$res=$this->Api();
	$this->ajaxreturn($res);
}	

}