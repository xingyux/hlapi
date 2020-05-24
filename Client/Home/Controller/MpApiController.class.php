<?php
namespace Home\Controller;
use Think\Controller;
class MpApiController extends Controller {
	
public function index(){

	
	if (isset($_GET['echostr'])) {
    $this->valid();
}else{
    $this->responseMsg();
}
}

	
	public function valid()
	{
		$echoStr = $_GET["echostr"];
		
		if($this->checkSignature()){
			echo $echoStr;
			exit;
		}
	}
	
	private function checkSignature()
	{
		$signature = $_GET["signature"];
		$timestamp = $_GET["timestamp"];
		$nonce = $_GET["nonce"];
		
		$token = TOKEN;
		$tmpArr = array($token, $timestamp, $nonce);
		sort($tmpArr,SORT_STRING);
		$tmpStr = implode( $tmpArr );
		
		$tmpStr = sha1( $tmpStr );
	   //print_r($tmpStr);die;
		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}
	
	public function responseMsg()
	{
		$postStr = isset($GLOBALS['HTTP_RAW_POST_DATA']) ? $GLOBALS['HTTP_RAW_POST_DATA'] : file_get_contents("php://input");

		if (!empty($postStr)){
			$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
			$RX_TYPE = trim($postObj->MsgType);
					import("Org.API.mp_require");
					$MP_API=new \mpAPI();						
					$openid = mb_convert_encoding($postObj->FromUserName,'utf-8',"gbk");
					$userlist = M('UserList')->where(array('openid'=>$openid))->find();
					$ischeck=false;
					if(!$userlist){
						M('UserList')->add(array('openid'=>$openid, 'createtime'=>time()));
						$userlist = M('UserList')->where(array('openid'=>$openid))->find();
					}else{
						if($userlist["check"]==1){
							$ischeck=true;
						}
					}

					$url="http://weixin.bohaofuwuqi.com" . U('Home/add/index');
					$WXUri="https://open.weixin.qq.com/connect/oauth2/authorize?appid=" . $MP_API->getAppID() . "&redirect_uri=" . urlencode($url) . "&response_type=code&scope=snsapi_base&state=1#wechat_redirect";

					
					$postObj->FromUserName=$openid;
					$postObj->ISChecked=$ischeck;
					$postObj->OAUTHWXUri=$WXUri;
					$postObj=json_decode(json_encode($postObj),true);
					$postObj["UserInfo"]=$userlist;
					$postObj=json_decode(json_encode($postObj));
					//$postObj->UserInfo=json_decode(json_encode($userlist));
			switch ($RX_TYPE)
			{
				case "text":
					$resultStr = $this->receiveText($postObj);
					break;
				case "image":
					$resultStr = $this->receiveImage($postObj);
					break;
				case "location":
					$resultStr = $this->receiveLocation($postObj);
					break;
				case "voice":
					$resultStr = $this->receiveVoice($postObj);
					break;
				case "video":
					$resultStr = $this->receiveVideo($postObj);
					break;
				case "link":
					$resultStr = $this->receiveLink($postObj);
					break;
				case "event":
					$resultStr = $this->receiveEvent($postObj);
					break;
				default:
					$resultStr = "unknow msg type: ".$RX_TYPE;
					break;
			}
			echo $resultStr;
		}else {
			echo "";
			exit;
		}
	}
	
	private function receiveText($object)
	{
		$funcFlag = 0;
		if(!$object->ISChecked){
			if(empty($object->UserInfo->pic)){
			$contentStr = "接杭州电信通知，杭州目前所有ADSL均需进行实名认证，请先准备【电信、联通、移动】运营商的手机，及手机实名的身份证件及证件号码，身份证姓名（手机机主），然后手持身份证拍上半身证件照后点右下角加发送照片，照片发送后请根据提示进行实名认证";
			}else{
				
			if($object->Content=="101"){

			  
		
				$real_path=$object->UserInfo->picnew;
				$real_path = (substr($real_path,0,4)=="http") ? $real_path : "http://weixin.bohaofuwuqi.com/" . $real_path;				
				if($object->UserInfo->check==2||$object->UserInfo->check==4){
					M("UserList")->where(array("id"=>$object->UserInfo->id))->save(array("check"=>4,"pic"=>$object->UserInfo->picnew));
					$resultStr = $this->transmitPICText($object,"您的照片更新成功",$real_path, "您的照片更新成功，请等待管理人员审核", $funcFlag);
					return $resultStr;
				}
				M("UserList")->where(array("id"=>$object->UserInfo->id))->save(array("pic"=>$object->UserInfo->picnew));
				$resultStr = $this->transmitPICText($object,"您的照片更新成功",$real_path, "您的照片更新成功，请点下方详情继续进行实名认证", $funcFlag);
				return $resultStr;
			}				
				if($object->UserInfo->check==2||$object->UserInfo->check==4){
					$real_path=$object->UserInfo->pic;
					$real_path = (substr($real_path,0,4)=="http") ? $real_path : "http://weixin.bohaofuwuqi.com/" . $real_path;				
					$resultStr = $this->transmitPICText($object,"您的照片审核失败，请重传",$real_path, "您的照片审核失败，请重传", $funcFlag);
					return $resultStr;						
				}
				if($object->UserInfo->check==3){
					$real_path=$object->UserInfo->pic;
					$real_path = (substr($real_path,0,4)=="http") ? $real_path : "http://weixin.bohaofuwuqi.com/" . $real_path;				
					$resultStr = $this->transmitPICText($object,"您的认证被取消，请联系客服",$real_path, "您的认证被取消，请联系客服", $funcFlag);
					return $resultStr;						
				}						
				$real_path=$object->UserInfo->pic;
				$real_path = (substr($real_path,0,4)=="http") ? $real_path : "http://weixin.bohaofuwuqi.com/" . $real_path;				
				$resultStr = $this->transmitPICText($object,"您的照片已上传成功",$real_path, "您的照片已上传成功，请点下方详情继续进行实名认证", $funcFlag);
				return $resultStr;
				//$contentStr = "<a href=\"" . $object->OAUTHWXUri . "\">请您点此继续提交实名认证</a>";
			}
			
	
			
			
		}else{
			$contentStr = "您的实名认证已成功！";
		}
		
		$resultStr = $this->transmitText($object, $contentStr, $funcFlag);
		return $resultStr;
	}
	
	private function receiveImage($object)
	{
		$funcFlag = 0;
		if($object->ISChecked){
			$contentStr = "您的实名认证已成功！";
		}else{
			if(empty($object->UserInfo->pic)){
		/*
				$savepath="tmp/".date("Ymd")."/";
				if(!is_dir($savepath)){
					@mkdir($savepath,"0755");
				}
					$curl = curl_init($object->PicUrl);
					$filename = $savepath . $object->UserInfo->id .".jpg";
					if(file_exists($filename)){
						@unlink($filename);
					}
					curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
					$imageData = curl_exec($curl);
					curl_close($curl);
					$tp = @fopen($filename, 'a');
					fwrite($tp, $imageData);
					fclose($tp);
				*/
				M("UserList")->where(array("id"=>$object->UserInfo->id))->save(array("pic"=>$object->PicUrl));
				$real_path=$object->PicUrl;
				$real_path = (substr($real_path,0,4)=="http") ? $real_path : "http://weixin.bohaofuwuqi.com/" . $real_path;
				$resultStr = $this->transmitPICText($object,"您的照片已上传成功",$real_path, "您的照片已上传成功，请点下方详情继续进行实名认证", $funcFlag);
				return $resultStr;
				//$contentStr = "<a href=\"" . $object->OAUTHWXUri . "\">请您点此继续提交实名认证</a>";
			}else{
				if($object->UserInfo->check==2||$object->UserInfo->check==4){
					M("UserList")->where(array("id"=>$object->UserInfo->id))->save(array("check"=>4,"pic"=>$object->PicUrl));
				try{
				$real_path=$object->PicUrl;
				$real_path = (substr($real_path,0,4)=="http") ? $real_path : "http://weixin.bohaofuwuqi.com/" . $real_path;
				$resultStr = $this->transmitPICText($object,"您的照片更新成功，请等待管理人员审核",$real_path, "您的照片更新成功，请等待管理人员审核", $funcFlag);
				return $resultStr;
				}catch(Exception $e){
$contentStr=$e->getMessage();
}
					
				}else{
					M("UserList")->where(array("id"=>$object->UserInfo->id))->save(array("picnew"=>$object->PicUrl));
try{
				$real_path=$object->UserInfo->pic;
				$real_path = (substr($real_path,0,4)=="http") ? $real_path : "http://weixin.bohaofuwuqi.com/" . $real_path;
				$resultStr = $this->transmitPICText($object,"您的原有证件照片存储",$real_path, "如果需更新刚刚上传的照片请回复【101】，不更新请点下方详情继续进行实名认证", $funcFlag);
				return $resultStr;
				}catch(Exception $e){
$contentStr=$e->getMessage();
}
					}
				
				
						
				
				
			}
		}
	//	$contentStr = "你发送的是图片，地址为：".$object->PicUrl;
		$resultStr = $this->transmitText($object, $contentStr, $funcFlag);
		return $resultStr;
	}
	
	private function receiveLocation($object)
	{
	//	$funcFlag = 0;
	//	$contentStr = "你发送的是位置，纬度为：".$object->Location_X."；经度为：".$object->Location_Y."；缩放级别为：".$object->Scale."；位置为：".$object->Label;
	//	$resultStr = $this->transmitText($object, $contentStr, $funcFlag);
	//	return $resultStr;
	}
	
	private function receiveVoice($object)
	{
	//	$funcFlag = 0;
	//	$contentStr = "你发送的是语音，媒体ID为：".$object->MediaId;
	//	$resultStr = $this->transmitText($object, $contentStr, $funcFlag);
	//	return $resultStr;
	}
	
	private function receiveVideo($object)
	{
	//	$funcFlag = 0;
	//	$contentStr = "你发送的是视频，媒体ID为：".$object->MediaId;
	//	$resultStr = $this->transmitText($object, $contentStr, $funcFlag);
	//	return $resultStr;
	}
	
	private function receiveLink($object)
	{
	//	$funcFlag = 0;
	//	$contentStr = "你发送的是链接，标题为：".$object->Title."；内容为：".$object->Description."；链接地址为：".$object->Url;
	//	$resultStr = $this->transmitText($object, $contentStr, $funcFlag);
	//	return $resultStr;
	}
	
	private function receiveEvent($object)
	{
		$contentStr = "";
		if(!$object->ISChecked){
			if(empty($object->UserInfo->pic)){
			$contentStr = "接杭州电信通知，杭州目前所有ADSL均需进行实名认证，请先准备【电信、联通、移动】运营商的手机，及手机实名的身份证件及证件号码，身份证姓名（手机机主），然后手持身份证拍上半身证件照后点右下角加发送照片，照片发送后请根据提示进行实名认证";
			}else{
				if($object->UserInfo->check==2){
					$real_path=$object->UserInfo->pic;
					$real_path = (substr($real_path,0,4)=="http") ? $real_path : "http://weixin.bohaofuwuqi.com/" . $real_path;				
					$resultStr = $this->transmitPICText($object,"您的照片审核失败，请重传",$real_path, "您的照片审核失败，请重传", $funcFlag);
					return $resultStr;						
				}
				if($object->UserInfo->check==4){
					$real_path=$object->UserInfo->pic;
					$real_path = (substr($real_path,0,4)=="http") ? $real_path : "http://weixin.bohaofuwuqi.com/" . $real_path;				
					$resultStr = $this->transmitPICText($object,"请等待管理人员进行证件照片审核",$real_path, "请等待管理人员进行证件照片审核", $funcFlag);
					return $resultStr;						
				}				
				if($object->UserInfo->check==3){
					$real_path=$object->UserInfo->pic;
					$real_path = (substr($real_path,0,4)=="http") ? $real_path : "http://weixin.bohaofuwuqi.com/" . $real_path;				
					$resultStr = $this->transmitPICText($object,"您的认证被取消，请联系客服",$real_path, "您的认证被取消，请联系客服", $funcFlag);
					return $resultStr;						
				}				
				$real_path=$object->UserInfo->pic;
				$real_path = (substr($real_path,0,4)=="http") ? $real_path : "http://weixin.bohaofuwuqi.com/" . $real_path;				
				$resultStr = $this->transmitPICText($object,"您的照片更新成功",$real_path, "您的照片更新成功，请点此链接继续进行实名认证", $funcFlag);
				return $resultStr;				
				//$contentStr = "<a href=\"" . $object->OAUTHWXUri . "\">请您点此继续提交实名认证</a>";
			}
		}elseif($object->Event=="subscribe"||$object->Event=="SCAN"){
			$contentStr = "机器实名成功，请点重新登录面板管理机器，谢谢合作！";
		}else{
			$contentStr = "欢迎使用！";
		}
		$openid=$object->FromUserName;
		switch ($object->Event)
		{
			case "subscribe":
					$qrscene=mb_convert_encoding($object->EventKey,"UTF-8","auto");
					$qrscene=str_ireplace("qrscene_","",$qrscene);
					
					$proudctid=$qrscene-10000000;
					if($object->ISChecked){
						$res=\CURL::getpost("http://221.231.6.136:81/lls/smrz.asp",http_build_query(array("id"=>mb_convert_encoding($proudctid,"GBK","UTF-8"),"phone"=>mb_convert_encoding($object->UserInfo->phone,"GBK","UTF-8"))));
						if($res["code"]>0){
							$contentStr = $res["message"];
						}else{
							if($res["body"]=="ok"){
								$contentStr = "机器绑定成功，请点二维码下方按钮重新进入管理面板";
							}else{
								$contentStr = $res["body"];
							}
						}
					}
					
					
					break;
			case "unsubscribe":

				$contentStr = "";
				break;
			case "CLICK":
				switch ($object->EventKey)
				{
					default:
							
				
							
						break;
				}
				break;
			case "SCAN":
					$qrscene=$object->EventKey;
		
					$proudctid=$qrscene-10000000;
					if($object->ISChecked){
						$res=\CURL::getpost("http://221.231.6.136:81/lls/smrz.asp",http_build_query(array("id"=>mb_convert_encoding($proudctid,"GBK","UTF-8"),"phone"=>mb_convert_encoding($object->UserInfo->phone,"GBK","UTF-8"))));
						if($res["code"]>0){
							$contentStr = $res["message"];
						}else{
							if($res["body"]=="ok"){
								$contentStr = "机器绑定成功，请点二维码下方按钮重新进入管理面板";
							}else{
								$contentStr = $res["body"];
							}
						}
					}
					

					
					
			
				break;			
			default:
				break;	
		}
		$resultStr = $this->transmitText($object, $contentStr);
		return $resultStr;
	}
	
	private function transmitText($object, $content, $flag = 0)
	{
		$textTpl = "<xml>
					<ToUserName><![CDATA[%s]]></ToUserName>
					<FromUserName><![CDATA[%s]]></FromUserName>
					<CreateTime>%s</CreateTime>
					<MsgType><![CDATA[text]]></MsgType>
					<Content><![CDATA[%s]]></Content>
					<FuncFlag>%d</FuncFlag>
					</xml>";
		$resultStr = sprintf($textTpl, $object->FromUserName, $object->ToUserName, time(), $content, $flag);
		return $resultStr;
	}
	private function transmitPICText($object,$title,$pic, $content, $flag = 0)
	{
		$textTpl = "<xml>
					<ToUserName><![CDATA[%s]]></ToUserName>
					<FromUserName><![CDATA[%s]]></FromUserName>
					<CreateTime>%s</CreateTime>
					<MsgType><![CDATA[news]]></MsgType>
					<ArticleCount>1</ArticleCount>
					<Articles>
					<item>
						<Title><![CDATA[%s]]></Title>
						<Description><![CDATA[%s]]></Description>
						<PicUrl><![CDATA[%s]]></PicUrl>
						<Url><![CDATA[%s]]></Url>
					</item>	
					</Articles>
					<FuncFlag>%d</FuncFlag>
					</xml>";
		$resultStr = sprintf($textTpl, $object->FromUserName, $object->ToUserName, time(),$title, $content,$pic,$object->OAUTHWXUri, $flag );
		return $resultStr;
	}	
	
}
?>