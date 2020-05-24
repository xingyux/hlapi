<?php
namespace Home\Controller;
use Think\Controller;
class LoginLogController extends LoginController {
	
	
    public function index(){
		
		$res=$this->ApiReturn();
		$this->assign('res',$res);
	
		$this->display();
		
       }

    public function addr(){
		$res=$this->ApiReturn();
		
		if(!empty($_GET['addrname'])){
			$this->success("设置成功");die;
		}
	
		$this->assign('res',$res);
		if(IS_AJAX){
			$this->assign('ajax',1);
		}
		$this->display();
		
       }


	  
}