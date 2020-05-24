<?php
$coonnet_defined=get_defined_constants(true);
if(!array_key_exists("APPKEY",$coonnet_defined["user"])){require("app_conf.php");}
if(!class_exists("CURL",false)){require("curl.class.php");}
if(!class_exists("APPClass",false)){require("app.class.php");}
?>