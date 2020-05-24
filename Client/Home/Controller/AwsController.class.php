<?php
namespace Home\Controller;
use Think\Controller;
class AwsController extends LoginController {
	
	
    public function index(){

		$res=$this->ApiReturn();
		
		if(IS_AJAX){
			$this->ajaxreturn($res);die;
		}
		
		$this->assign('res',$res);
		$this->display();
		
       }

    public function add(){
		
		$res=$this->ApiReturn();
		
		
		if(IS_AJAX){
			$this->ajaxreturn($res);die;
		}		
		if( !empty($res['aws']['content']) ){
		$message = explode( "<data-list>" , $res['aws']['content'] );
		$head = $message[0];
		unset($message[0]);
		$this->assign('content',$message);
		$this->assign('head',$head);
		}
		$this->assign('res',$res);
		$this->display();
		
       }

}