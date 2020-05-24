<?php
require("mp_require.class.php");
$mp_api=new mpAPI();
print_r($mp_api->shorturl("https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx816edf06d3389551&redirect_uri=http://msy.gztet.com/ThinkPHP/Library/Org/API/qrcode.class.php&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect"));
?>