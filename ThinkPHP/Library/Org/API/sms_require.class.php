<?php
$coonnet_defined=get_defined_constants(true);
if(!array_key_exists("SMSTOKEN",$coonnet_defined["user"])){require("sms_conf.php");}
if(!class_exists("CURL",false)){require("curl.class.php");}
if(!class_exists("SMS",false)){require("sms.class.php");}
?>