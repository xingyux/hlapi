<?php
namespace Home\Controller;
use Think\Controller;
class UserListController extends LoginController {
	
	
    public function index(){

		$res=$this->ApiReturn();
		$this->assign('res',$res);	
		
		$this->display();
		
       }

    public function changelv(){
		$companyuser=session("companyuser");
		
		$myname = I( "post.id");
	
		if( !empty($companyuser) ){
			if( $companyuser["id"]== $myname ){
				$this->ajaxreturn(array("code"=>1, "message"=> "员工帐号没有权限更新自己的级别") );die;
			}
			
		}
		$res=$this->ApiReturn();
		$this->ajaxreturn($res);	
		
       }	   
	   function changemoney(){
		$companyuser=session("companyuser");
		$myname = I( "post.id");
		if( !empty($companyuser) ){
			if( $companyuser["id"]== $myname ){
				$this->ajaxreturn(array("code"=>1, "message"=> "员工帐号没有权限更新自己的金额") );die;
			}
			
		}	   
		   
			$res=$this->ApiReturn();
			$this->ajaxreturn($res);			   
	   }

	   function changeuser(){
			$res=$this->ApiReturn();
			if($res["code"]>0){
				$this->ajaxreturn($res);			   die;
			}
			$chguser=$res["chguserinfo"];
			$USER_INFO=session("USER_INFO");
			session("agentchguser",$USER_INFO);
			session("USER_CHECK",time());
			session("USER_INFO",$chguser);
			
			
			$this->ajaxreturn(array("code"=>0,"message"=>"切换成功"));			   
	   }	   
	   
}