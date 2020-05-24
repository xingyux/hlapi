<?php

ini_set('session.save_path',realpath(dirname(__FILE__) . "/Client/Common/Conf/session/"));
session_start();
$username=$_SESSION["USER_INFO"]["username"];
header("Content-type: text/html; charset=utf-8");

$ischeck=isset($_SESSION["updatelib"]) ? $_SESSION["updatelib"] : false;
if($ischeck!=="sjkdhskh"){
	die("未授权");
}
function get_extension($file) 
{
$s=explode('.', $file);
return end($s); 
}

function httpcopy($url, $file="", $timeout=60) {
  $file = empty($file) ? pathinfo($url,PATHINFO_BASENAME) : $file;
  $dir = pathinfo($file,PATHINFO_DIRNAME);
  !is_dir($dir) && @mkdir($dir,0755,true);
  $url = str_replace(" ","%20",$url);
  
  if(function_exists('curl_init')) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    $temp = curl_exec($ch);
    if(@file_put_contents($file, $temp) && !curl_error($ch)) {
      return $file;
    } else {
      return false;
    }
  } else {
    $opts = array(
      "http"=>array(
      "method"=>"GET",
      "header"=>"",
      "timeout"=>$timeout)
    );
    $context = stream_context_create($opts);
    if(@copy($url, $file, $context)) {
      //$http_response_header
      return $file;
    } else {
      return false;
    }
  }
}
$dir=dirname(__FILE__);

$versionfile = strtoupper(substr(PHP_OS,0,3))==='WIN'? $dir . "\\Client\\Common\\Conf\\version.php" : $dir . "/Client/Common/Conf/version.php" ; 

$version=include($versionfile);
$server_version=file_get_contents("http://update.hlapi.com/version.php?version={$version['version']}&username={$username}&r=" . time());

if($server_version=="new"){

	echo "<a href='/home/user/index.html'>已是最新版，完成更新</a>";
	die();
}else if($server_version=="err"){
	die("版本错误：v".$version["version"]);
}

$path=$server_version;

$files=file_get_contents("http://update.hlapi.com/update.php?path={$path}");

$list=json_decode($files,true);
if(!$list){
	die("文件未找到" .$files);
}
if(is_array($list["dir"])){
foreach($list["dir"] as $k=>$v){
	if(!is_dir(dirname(__FILE__)  . $v)){
		@mkdir(dirname(__FILE__)  . $v,0755);
	}
}
}
foreach($list["file"] as $k=>$v){
		$ext=strtolower(get_extension($v));
		if($ext=="php"){
			$res[$v]=httpcopy("http://update.hlapi.com/files.php?path={$path}&file=" . $v,dirname(__FILE__) . $v);
		}else{
			$res[$v]=httpcopy("http://update.hlapi.com/{$path}{$v}",dirname(__FILE__) . $v);
		}
	
		
}



if(empty($list["sql"])){
	echo "当前版本：{$version['version']}，<a href='?" . time() . "'>继续更新下一版本：{$path}</a>";

	
}else{
	$f="sql" . time() . ".php";
	$res[$v]=httpcopy("http://update.hlapi.com/files.php?path={$path}&file=" . $list["sql"],$f);
	Header("HTTP/1.1 301 Moved Permanently");
	Header("Location: " . $f . "");	
}






?>