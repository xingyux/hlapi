<?php
session_start();
//error_reporting(E_ALL);
//ini_set('display_errors', '1');

$redirect=$_GET["redirect"];
if(!strstr($redirect,"index.php/")){
	$redirect='Home/'.$redirect.'/index.html?&tim='.time();
}
if(isset($_SESSION["openid"])){
		echo json_encode(array("code"=>1001,"url"=>$redirect));die;
		//header('HTTP/1.1 301 Moved Permanently');
		//header('Location:../../../../home/' . $redirect . '.html?openid='.$_SESSION["openid"].'&tim='.time()); 
}
require("mp_require.class.php");
if (isset($_GET['code'])){
	

	
	$mp_api=new mpAPI();
    $code = $_GET['code'];
	
	$result=$mp_api->getOpenID($code);
	$url=MPWebSiteUrl."info.html?redirect=".$redirect;
	$WXUri="https://open.weixin.qq.com/connect/oauth2/authorize?appid=" . $mp_api->getAppID() . "&redirect_uri=" . urlencode($url) . "&response_type=code&scope=snsapi_base&state=1#wechat_redirect";
	
	if($result["errcode"]>0){
		echo json_encode(array('code'=>1001,"url"=>$WXUri,'message'=>""));die;
		//print_r($result);die;
	}
	$openid=$result["openid"];
	$_SESSION["openid"]=$openid;
	$url=$redirect;
	//$_SESSION["redirect_uri"]=$url;
	echo json_encode(array("code"=>1001,"url"=>$url));die;
	//print_r($result);die;
// 		header('HTTP/1.1 301 Moved Permanently');
// 		header('Location:../../../../home/' . $redirect . '.html?openid='.$openid.'&tim='.time()); 
	//print_r($result);die;
}else{
	
    echo json_encode(array('code'=>1001,"url"=>$WXUri,'message'=>""));die;
	
}
?>