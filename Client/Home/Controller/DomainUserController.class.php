<?php
namespace Home\Controller;
use Think\Controller;
class DomainUserController extends LoginController {
	
	
    public function index(){
		
		$res=$this->ApiReturn();
		$this->assign('res',$res);
		$servers=ReadServersCache("*","*");
		$this->assign('servers',$servers);	
		$this->display();
		
       }

    public function add(){
		
		$res=$this->ApiReturn();
		$this->ajaxreturn($res);
		
       }
	  
}