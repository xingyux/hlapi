<?php
ini_set('date.timezone','Asia/Shanghai');
require("mp_require.class.php");
$mp_api=new mpAPI();

$array=array(
"first"=>array("value"=>"您的积分兑换到帐成功","color"=>"#173177"),
"tradeDateTime"=>array("value"=>date("Y-m-d H:i:s",time()),"color"=>"#173177"),
"tradeType"=>array("value"=>"增加","color"=>"#173177"),
"curAmount"=>array("value"=>"1元","color"=>"#173177"),
"remark"=>array("value"=>"订单号：123456","color"=>"#173177"),
);

$res=$mp_api->sendModeText("oz1YVuAgnuea4H1A-jxxvpKpthoc","I6m88X6k7rV2Q_g2LmwXFWKFV1LkrK-OZyNr_vTU4ac","http://w.url.cn/s/AbBGOWB",$array);
print_r($res);
?>