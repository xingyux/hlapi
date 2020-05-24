<?php

class CURL{
	Public static function chk(){
		return array("code"=>0);
	}
	public static function getpost($url,$parm,$ContentType=null){

$ch = curl_init();
if($ContentType=="application/json"){
	$parm=json_encode($parm);
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
	curl_setopt($ch, CURLOPT_POSTFIELDS,$parm);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		'Content-Type: application/json',
		'Content-Length: ' . strlen($parm))
	);	
}else{
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		if(count($parm)>0){

 curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $parm);
			
			}
 }      
        $response= curl_exec($ch);
		
 if ($response  === FALSE) {
          return array("code"=>1,"message"=>curl_error($ch),"url"=>$url,"post"=>$parm);
        }
		
		$httpCode = curl_getinfo($ch,CURLINFO_HTTP_CODE);
		if($httpCode<>200){return array("code"=>$httpCode,"message"=>"HTTP错误：" . $httpCode . $response,"url"=>$url,"post"=>$parm);}
        curl_close($ch);	
		$return_arr=array("code"=>0,"body"=>trim($response,"\xEF\xBB\xBF"),"message"=>"curl调用成功","url"=>$url,"post"=>$parm);
/*		
$fp = fopen('log/'.time().'.txt','w+'); 
fwrite($fp,var_export($return_arr,true)); 
fclose($fp);
*/		
		return $return_arr;
		}



	}

?>