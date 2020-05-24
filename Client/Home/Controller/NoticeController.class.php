<?php
namespace Home\Controller;
use Think\Controller;
class NoticeController extends LoginController {
	
	
    public function index(){
		
		$res=$this->ApiReturn();
		if(!empty($_POST["submit"])){
			$this->ajaxreturn($res);die;
		}
		$this->assign('res',$res);
	
		$this->display();
		
       }




	  
}