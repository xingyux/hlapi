<?php
//error_reporting(E_ALL);
//ini_set('display_errors', '1');
require("mp_require.class.php");
if (isset($_GET['code'])){
	$mp_api=new mpAPI();
    $code = $_GET['code'];
	$result=$mp_api->getOpenID($code);
	if(array_key_exists("errorcode",$result)){print_r($result);die;}
	$openid=$result["openid"];
		header('HTTP/1.1 301 Moved Permanently');
		header('Location:../../../../home/MyGroup.html?openid='.$openid.'&tim='.time()); 
	//print_r($result);die;
}else{
    echo "NO CODE";
}
?>