<?php
$coonnet_defined=get_defined_constants(true);
if(!array_key_exists("MAILServer",$coonnet_defined["user"])){require("mail_conf.php");}
if(!class_exists("smtp",false)){require("mail.class.php");}
?>