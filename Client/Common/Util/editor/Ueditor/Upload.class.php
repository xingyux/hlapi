<?php
//header('Access-Control-Allow-Origin: http://www.baidu.com'); //设置http://www.baidu.com允许跨域访问
//header('Access-Control-Allow-Headers: X-Requested-With,X_Requested_With'); //设置允许的跨域header
namespace Common\Util\editor\Ueditor;
date_default_timezone_set("Asia/chongqing");
error_reporting(E_ERROR);
header("Content-Type: text/html; charset=utf-8");

define('UPLOAD_ROOT_PATH', dirname(__FILE__));
Class Upload{

public function doUpload(){

$CONFIG = json_decode(preg_replace("/\/\*[\s\S]+?\*\//", "", file_get_contents(UPLOAD_ROOT_PATH . "/config.json")), true);
$action = $_GET['action'];



$CONFIG["imagePathFormat"]= "/Public/upload/" . date("Ymd") . "/" .date("YmdHis") . mt_rand(1000,999999);

switch ($action) {
    case 'config':
        $result =  json_encode($CONFIG);
        break;


    case 'uploadimage':
  
    case 'uploadscrawl':
 
    case 'uploadvideo':

    case 'uploadfile':
        $result = include(UPLOAD_ROOT_PATH . "/action_upload.php");
        break;


    case 'listimage':
        $result = include(UPLOAD_ROOT_PATH . "/action_list.php");
        break;

    case 'listfile':
        $result = include(UPLOAD_ROOT_PATH . "/action_list.php");
        break;


    case 'catchimage':
        $result = include(UPLOAD_ROOT_PATH . "/action_crawler.php");
        break;

    default:
        $result = json_encode(array(
            'state'=> '请求地址出错'
        ));
        break;
}

/* 输出结果 */
if (isset($_GET["callback"])) {
    if (preg_match("/^[\w_]+$/", $_GET["callback"])) {
        return htmlspecialchars($_GET["callback"]) . '(' . $result . ')';
    } else {
        return json_encode(array(
            'state'=> 'callback参数不合法'
        ));
    }
} else {
    return $result;
}
}
}