<?php
class APPClass{
	public function ceart_hash_hmac($str){
		return base64_encode(hash_hmac("sha1", $str, APPKEY, true));
	}
	private function creatgsin($array){
		$time=time();
		$array=array_merge($array,array("timestmp"=>$time));
		$action=$array["action"];
		$userid=$array["userid"];
		$gsinstr=$action.$time.$userid.APIIP;
		$gsin=$this->ceart_hash_hmac($gsinstr);
		$array=array_merge($array,array("gsin"=>$gsin));
		return $array;
	}
	public function connnet($url,$array,$appurl){

if(!$appurl) $appurl=APPUrl;
		
		return $this->data(CURL::getpost($appurl.$url,$array));
		
		
		//return $this->creatgsin($array);
		
	}

		private function data($data){
		if($data["code"]>0)
		{
			return $data;
		}else
		{
		return $data["body"];
		}
	}
	
}
?>