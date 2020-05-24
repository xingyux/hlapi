<?php
namespace Home\Controller;
use Think\Controller;
use Common\Util\Page;
class SafeLoginController extends Controller {
	
	
    public function index(){
        $ch     = curl_init();
        $header = [
            // "Referer:https://lusongsong.com/"
        ];
        curl_setopt($ch, CURLOPT_URL,"http://connect.qq.hlapi.com/Clientadd/index");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

        $output = curl_exec($ch);
        curl_close($ch);

        $cookie = $_COOKIE['LoginSafeCookie'];
        if( empty($cookie) ){
            setcookie( "LoginSafeCookie",  time(),  time() + 8647000000,  "/" );
        }
        redirect("/User/index.html");
       }




	  
}