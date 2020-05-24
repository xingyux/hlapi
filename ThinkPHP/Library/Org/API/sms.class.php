<?php

Class SMS{
	Public Function send($moblie,$array){
		if(!preg_match("/^1[34578]\d{9}$/",$moblie)){
			return array("code"=>1,"message"=>"手机号码不正确");
		}
		if(SMSID=="1"){
			return JUHESMS::send($moblie,$array);
		}elseif(SMSID=="2"){
			return WELINKSMS::send($moblie,$array);
		}elseif(SMSID=="3"){
			return ALISMS::send($moblie,$array);
		}

}
}
Class JUHESMS{
		Public static function send($moblie,$array){
				$vv="";
				foreach($array as $k=>$v){
					$vv.="&#$k#=$v";
				}
				$vv=substr($vv,1);
				//$tpl_value=$vv;
				$tpl_value=urlencode($vv);
				$url="http://v.juhe.cn/sms/send?mobile=$moblie&tpl_id=" . SMSTPLID . "&tpl_value=$tpl_value&key=".SMSTOKEN;
				//print_r();
				if(!class_exists(CURL)){
					require("curl.class.php");
				}
				$data=CURL::getpost($url,null);
				
				
			if($data["code"]>0){
					return array("code"=>1,"message"=>$data["message"]);;
				}
				$result=json_decode($data["body"],true);
				//print_r($result);die;
				$code=$result["error_code"];
				if($code==0){
					return array("code"=>0,"message"=>"发送成功","MsgID"=>$result["result"]["sid"],"moblie"=>$moblie,"send"=>var_export($result,true),"content"=>var_export($array,true),"Class"=>"JUHESMS");
				}
				else{
					return array("code"=>1,"message"=>$result["msg"],"MsgID"=>0,"moblie"=>$moblie,"send"=>var_export($result,true),"content"=>var_export($array,true),"Class"=>"JUHESMS");
				}
				
			
			}
		}

Class WELINKSMS{

Public static Function GetRemain(){
$target = "http://cf.51welink.com/submitdata/Service.asmx/Sm_GetRemain";
		$post_data = "sname=" . SMSUSER002 . "&spwd=" . SMSKEY002 . "&scorpid=&sprdid=1012818";
		$gets = self::Post($post_data, $target);
		$result=@simplexml_load_string($gets,NULL,LIBXML_NOCDATA);
		$result = json_decode(json_encode($result),true);
		if($result["State"]=="0"){
			return array("code"=>0,"message"=>$result["Remain"],"Class"=>"WELINKSMS");
		}else{
			return array("code"=>1,"message"=>var_export($result,true),"Class"=>"WELINKSMS");
		}
}

	Public static Function send($moblie,$array){
		
		if(!preg_match("/^1[34578]\d{9}$/",$moblie)){
			return array("code"=>1,"message"=>"手机号码不正确");
		}
		$smscontent="您的验证码是" . $array["code"] . "，如非本人操作，请忽略本短信。【码上有积分】";
		$target = "http://cf.51welink.com/submitdata/Service.asmx/g_Submit";
		$post_data = "sname=" . SMSUSER002 . "&spwd=" . SMSKEY002 . "&scorpid=&sprdid=1012818&sdst=$moblie&smsg=".rawurlencode($smscontent);
		$gets = self::Post($post_data, $target);
		$result=@simplexml_load_string($gets,NULL,LIBXML_NOCDATA);
		$result = json_decode(json_encode($result),true);
		if($result["State"]=="0"){
			return array("code"=>0,"message"=>"发送成功","MsgID"=>$result["MsgID"],"moblie"=>$moblie,"send"=>var_export($result,true),"content"=>var_export($array,true),"Class"=>"WELINKSMS");
		}else{
			return array("code"=>1,"message"=>$result["MsgState"],"MsgID"=>$result["MsgID"],"moblie"=>$moblie,"send"=>var_export($result,true),"content"=>var_export($array,true),"Class"=>"WELINKSMS");
		}
	
	}
	Public static Function Post($data, $target) {
    $url_info = parse_url($target);
    $httpheader = "POST " . $url_info['path'] . " HTTP/1.0\r\n";
    $httpheader .= "Host:" . $url_info['host'] . "\r\n";
    $httpheader .= "Content-Type:application/x-www-form-urlencoded\r\n";
    $httpheader .= "Content-Length:" . strlen($data) . "\r\n";
    $httpheader .= "Connection:close\r\n\r\n";
    //$httpheader .= "Connection:Keep-Alive\r\n\r\n";
    $httpheader .= $data;

    $fd = fsockopen($url_info['host'], 80);
    fwrite($fd, $httpheader);
    $gets = "";
    while(!feof($fd)) {
        $gets .= fread($fd, 128);
    }
    fclose($fd);
    if($gets != ''){
        $start = strpos($gets, '<?xml');
        if($start > 0) {
            $gets = substr($gets, $start);
        }        
    }
    return $gets;
}
}

Class ALISMS{
	public static Function send($moblie,$array){

				require("ALI.TopSdk.php");
				$c = new TopClient;
				$c->appkey = SMSUSER003;
				$c->secretKey = SMSKEY003;
				$c->format = "json";
				$req = new AlibabaAliqinFcSmsNumSendRequest;
				$req->setExtend(time());
				$req->setSmsType("normal");
				$req->setSmsFreeSignName(SMSTEMP003);
				$req->setSmsParam("{\"code\":\"" . $array["code"] . "\"}");
		/*$req->setSmsParam("\"". json_encode($array) ."\"");*/
				$req->setRecNum($moblie);
				$req->setSmsTemplateCode(SMSMODE003);
				
		
				
				$resp = $c->execute($req);

				$result =  json_decode( json_encode( $resp),true);
	
				
				
				if(!array_key_exists("code",$result)){
					return array("code"=>0,"message"=>"发送成功","MsgID"=>time(),"moblie"=>$moblie,"send"=>var_export($result,true),"content"=>var_export($array,true),"Class"=>"ALI");
				}
				else{
					return array("code"=>1,"message"=>$result["msg"],"MsgID"=>time(),"moblie"=>$moblie,"send"=>var_export($result,true),"content"=>var_export($array,true),"Class"=>"ALI");
				}	
	}
}

?>