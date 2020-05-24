<?php

Class WXPAY{
	
	
	
	public static function connnet($url,$arr,$https){
		$arrkey=array();
		foreach($arr as $k=>$v){
			$arrkey[]=$k;
		}
		sort($arrkey,SORT_STRING);
		$stringA="";
		foreach($arrkey as $k=>$v){
			$stringA.="&$v=".$arr[$v];
		}
		$stringA=substr($stringA,1);
		$stringA.="&key=".mchkey;
		$sign=strtoupper(MD5($stringA));
		$arr=array_merge($arr,array("sign"=>$sign));
		$xml = new A2Xml();
		$xmlStr=$xml->toXml($arr);
		if(!$https){
		$data = self::curl_post_ssl("https://api.mch.weixin.qq.com/$url", $xmlStr);
		$data=$xml->uncdata($data);
		
		return json_decode(json_encode( (array)simplexml_load_string($data)),true);
		}else{
			$data = CURL::getpost("https://api.mch.weixin.qq.com/$url", $xmlStr);
			return $data;
		}
	}
	
private static function curl_post_ssl($url, $vars, $second=30,$aHeader=array())
{
	$ch = curl_init();

	curl_setopt($ch,CURLOPT_TIMEOUT,$second);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);

	curl_setopt($ch,CURLOPT_URL,$url);
	curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
	curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);
	
	
	curl_setopt($ch,CURLOPT_SSLCERTTYPE,'PEM');
	curl_setopt($ch,CURLOPT_SSLCERT,sitePATH.'/cert/apiclient_cert.pem');

	curl_setopt($ch,CURLOPT_SSLKEYTYPE,'PEM');
	curl_setopt($ch,CURLOPT_SSLKEY,sitePATH.'/cert/apiclient_key.pem');
	//curl_setopt($ch,CURLOPT_CAINFOTYPE,'PEM');
	curl_setopt($ch,CURLOPT_CAINFO,sitePATH.'/cert/rootca.pem');

	
	if( count($aHeader) >= 1 ){
		curl_setopt($ch, CURLOPT_HTTPHEADER, $aHeader);
	}
 
	curl_setopt($ch,CURLOPT_POST, 1);
	curl_setopt($ch,CURLOPT_POSTFIELDS,$vars);
	$data = curl_exec($ch);
	if($data){
		curl_close($ch);
		return $data;
	}
	else { 
		$error = curl_errno($ch);
		echo "call faild, errorCode:$error\n"; 
		curl_close($ch);
		return false;
	}
}	
	
}

?>