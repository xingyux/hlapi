<?php
$coonnet_defined=get_defined_constants(true);
if(!array_key_exists("AppSecret",$coonnet_defined["user"])){require("conf.php");}
if(!class_exists("mpAPI",false)){require("mp.class.php");}
if(!class_exists("CURL",false)){require("curl.class.php");}
?>