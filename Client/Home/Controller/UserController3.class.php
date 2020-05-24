<?php
namespace Home\Controller;
use Think\Controller;

class UserController extends HomeController {
    public function index(){
		
		if(!is_login()){
			$this->redirect("login");
		}
		$this->assign('checkWebUser',checkWebUser());
		$this->assign('checkAgent',checkAgent());	
		$userinfo=session("USER_INFO");


		if(empty($_SESSION["USER_CHECK"])){
			$this->redirect("User/check",array("bind"=>I("get.bind")));die;
		}
		if(!empty($_GET["bind"])){
			
			
			
			$res=$this->ApiReturn("","qqlogin","qqbind");
			Header("Location: {$res["url"]}");
			die();
			
		}
	
	
		$res=$this->ApiReturn();
		if(I("post.action"=="editmyinfo")){
			$this->ajaxreturn($res);die;
		}
		if($res["userinfo"]["isnotbindwechat"]!=1&&empty($res["userinfo"]["openid"])){
			$this->redirect("User/wechat");die;
		}else if(empty($userinfo["openid"])){
			session("USER_INFO",$res["userinfo"]);
		}			
		if(checkWebUser){
			$_SESSION["updatelib"]="sjkdhskh";
		}
		
		
		$this->assign('res',$res);
		$this->assign('VERSION',C("version"));
		$this->assign('nav',C("SERVERTYPE"));
		$this->display();
		
       }
	   Public function login(){
		   
		   
		   
		   session("USER_CHECK",null);
		   if(IS_POST){
			   
				$res=$this->ApiReturn(array("password"=>MD5(strtoupper(MD5($_POST["password"])).$_POST["username"])));
				
								if($res["login_isloacklogin"]==1){
					$this->error($res["message"],U("login"));die;
				}
				session("USER_INFO",$res);
				if($res["ischecked_addr"]==1){
					session("USER_CHECK",time());
				}
				
			   $this->success("登录成功",U("index",array("bind"=>I("post.bind"))));die;
		   }
		   $this->assign('bind',I("get.bind"));
		   $this->display();
	   }
	   function wechatlogin(){
		   session("USER_CHECK",null);
				$res=$this->ApiReturn();
				if($res["login_isloacklogin"]==1){
					$this->error($res["message"],U("login"));die;
				}				
					
						session("USER_INFO",$res);
						session("USER_CHECK",time());
						$this->redirect("index");die;
			
	   
	   }
	   function qqlogin(){
		   
				session("USER_CHECK",null);
				$res=$this->ApiReturn();
				if($res["login_isloacklogin"]==1){
					$this->error($res["message"],U("login"));die;
				}
					
						session("USER_INFO",$res);
						session("USER_CHECK",time());
						$this->redirect("index");die;
		   
	   }
	   function loginqrcode(){
		   session("USER_CHECK",null);
		$res=$this->ApiReturn();

		
		
		
		$this->ajaxreturn($res);
	   }
	   function logout(){
		   $agentchguser=session("agentchguser");
		   if(empty($agentchguser)){
			   session("USER_INFO",null);session("USER_CHECK",null);
			   $this->success("退出成功",U("index"));die;
		   }else{
			$USER_INFO=session("agentchguser");
			session("agentchguser",null);
			session("USER_CHECK",time());
			session("USER_INFO",$USER_INFO);
				$this->success("退出成功，正在返回代理帐号",U("index"));die;
		   }
		   
		   
		   
		   
	   }
	   Public function reg(){

		   if(IS_POST){
			   $this->CheckEmailAddr(I("post.username"));
			   $this->checkMoblie(I("post.phone"));
			   $this->CheckPassword(I("post.password"),I("post.repassword"),true);
			   $res=$this->ApiReturn();
			   $this->success("注册成功",U("login"));die;
		   }		   
		   $this->display();
	   }
	   function wechat(){
		$ticket_id=I("post.ticket_id");
		if(!empty($ticket_id)){
		if(!is_login()){
			$this->ajaxreturn(array("code"=>1,"message"=>"登录失效"));
		}
		$userinfo=session("USER_INFO");


		if(empty($_SESSION["USER_CHECK"])){
			$this->ajaxreturn(array("code"=>1,"message"=>"登录失效"));
		}
		$res=$this->ApiReturn();
		$this->ajaxreturn($res);
			die;
		}
		if(!is_login()){
			$this->redirect("login");
		}
		
		$userinfo=session("USER_INFO");
		

		if(empty($_SESSION["USER_CHECK"])){
			$this->redirect("User/check");die;
		}		   
		
		   $res=$this->ApiReturn();
		   $this->assign('res',$res);
		   $this->display();
	   }
	   function check(){
   
		   
		   $res=$this->ApiReturn();
		   $type=I("get.type");
		   
		   if(I("post.is_checked")==1){
			   if($res["code"]==0){
				   session("USER_CHECK",time());
			   }
			   $this->ajaxreturn($res);die;
		   }
		   if(I("post.is_checked")==2){
			   $this->ajaxreturn($res);die;
		   }		   
			$this->assign('bind',I("get.bind"));
		   $this->assign('res',$res);
		   $this->assign('type',$type);
		   if(!empty($type)){
			   $this->assign('typeinfo',$res["checked"][$type]);
		   }
		   $this->display();
	   }
	   function feedback(){
		   $res=$this->ApiReturn();
		   $this->ajaxreturn($res);
	   }
	   function userReturn(){
			if(!is_login()){
				$this->ajaxreturn(array("code"=>1,"message"=>"请先登录"));die;
			}
			$res=$this->ApiReturn();
			
			$this->ajaxreturn($res);
	   }
}