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
			
			if($_GET["bind"]=="qq"){
				$res=$this->ApiReturn("","qqlogin","qqbind");
				Header("Location: {$res["url"]}");
				die();				
			}else{
				$this->success("验证通过",U($_GET["bind"] . "/index"));die;
			}
			

			
		}
	
	
		$res=$this->ApiReturn();
		if(I("post.action"=="editmyinfo")){
			$checkWebUser=checkWebUser();
			if($checkWebUser){
				M("Config")->where(array("id"=>1))->save(array("webname"=>$_POST["edituser"]["webname"]));
				delDirAndFile(APP_PATH . "Runtime/");
				S(array('type'=>'File','prefix'=>'WEBCONFIG','expire'=>999999));
				S("config",null);
				$re=getConfig();
			}
			
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
		   $companyuser = session("companyuser");
		   if(empty($agentchguser)&&empty($companyuser)){
			   session("USER_INFO",null);session("USER_CHECK",null);
			   $this->success("退出成功",U("index"));die;
		   }else{
			  
			$USER_INFO=empty($agentchguser) ? $companyuser : $agentchguser;
			
			$usertag = empty($companyuser) ? "代理" : "员工";
			session("agentchguser",null);
			session("companyuser",null);
			session("USER_CHECK",time());
			session("USER_INFO",$USER_INFO);
				$this->success("退出成功，正在返回{$usertag}帐号",U("index"));die;
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
   
		   session("mt_rand_checked",mt_rand());
		   $session=session("mt_rand_checked");
		   $res=$this->ApiReturn(array("mt_rand_checked"=>$session));
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
				$ajax=I("post.json");
				if($ajax){
					$this->ajaxreturn(array("code"=>1,"message"=>"请先登录"));die;
				}else{
					$this->show("请先登录");die;
				}
				
			}
			$res=$this->ApiReturn();
			$this->assign('checkWebUser',checkWebUser());
			$this->assign('checkAgent',checkAgent());	
			$this->assign('res',$res);			
			$this->display();
	   }
	   
	   function clearcache(){
		   $checkWebUser=checkWebUser();
		   if(!$checkWebUser){$this->show("没有权限，请用接入帐号操作");die;}

			delDirAndFile(APP_PATH . "Runtime/");
			delDirAndFile(APP_PATH . "Common/Conf/session/");
			$re=getConfig();
		   $this->show("删除缓存成功，请重新登录");die;
	   }	   
	   function changepersonnel(){
		   $res=$this->ApiReturn();
		   
			$chguser=$res["chguserinfo"];
			$USER_INFO=session("USER_INFO");
			
			session("companyuser",$USER_INFO);
			session("USER_CHECK",time());
			session("USER_INFO",$chguser);		   
		   
		   $this->success("切换成功","index");die;
	   }

	   function backpwd(){
	   		if(IS_POST){
	   			echo 123;
	   		}else{
	   			// echo date('Y-m-d H:i:s','1495184291');exit;
		   		$this->display();
	   		}
	   }

	   function VerifyCodeImage(){
		   	$Verify = new \Think\Verify();
			$Verify->entry();
	   }

		function sendVerifyCode(){
			$verify = new \Think\Verify();
			if($verify->check(I('post.verify_code'))){
				$data=array(
					'back_type'=>I('post.back_type'),
					'username'=>trim(I('post.account'))
				);
				if($data['back_type']=='0')
					$data['email']=I('post.email');
				else
					$data['moblie']=I('post.moblie');

				$this->ajaxreturn($this->ApiReturn($data));
			}else{
				$this->error('验证码错误','',true);
			}
	    }

	    function changePassWord(){
	    	$data=array('code'=>I('post.verify_code')
	    		,'password'=>I('post.password')
    			,'re_pwd'=>I('post.re_pwd')
    			,'username'=>I('post.account')
	    	);
	    	$this->ajaxreturn($this->ApiReturn($data));
	    }
} 