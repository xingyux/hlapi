<?php
namespace Home\Controller;
use Think\Controller;
class LoginController extends HomeController {
 	protected function _initialize(){

		$config=getConfig();
		
		$this->assign('sitename',$config["webname"]);
		
		if(!is_login()){
		    if( IS_AJAX ){
                $this->ajaxreturn(array( 'code'=>1,'message'=>'请先登录' ));die;
            }else{
                $this->redirect("User/login");die;
            }

		}
		$userinfo=session("USER_INFO");

		$checked=session("USER_CHECK");
		if(empty($checked)){
			$this->redirect("User/check");die;
		}
		
		if($userinfo["isnotbindwechat"]!=1&&empty($userinfo["openid"])){
			$this->redirect("User/wechat");die;
		}

		if(I("post.searchword")=="true"){
			$searchword=base64_encode( json_encode(array_map($_GET,$_POST)));
			$this->redirect(CONTROLLER_NAME . "/" . ACTION_NAME,array("page"=>1,"keyword"=>$searchword));
			die;
		}

		$this->assign('checkWebUser',checkWebUser());
		$this->assign('checkAgent',checkAgent());
		$this->assign('islogin',1);
		$this->assign('AgentInfo',$userinfo);
		$this->assign('nav',C("SERVERTYPE"));
		set_theme();
		
	}
}