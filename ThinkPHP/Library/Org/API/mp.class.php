<?php


Class mpAPI
{

function __construct($AppID=null,$AppSecret=null){
	$this->AppID=empty($AppID) ? AppID : $AppID;
	$this->AppSecret=empty($AppSecret) ? AppSecret : $AppSecret;

  }
	
	//获取菜单
		public function getMenu(){
        $reslut=$this->data(CURL::getpost(APIURL."cgi-bin/menu/get?access_token=".$this->createAccessToken(),null));
        return $reslut;
	}
	//建立菜单
	public function createMenu($menu_array){
		$reslut=$this->data(CURL::getpost(APIURL."cgi-bin/menu/create?access_token=".$this->createAccessToken(),$this->wx_json_encode($menu_array)));
		return $reslut;		
	}
	//删除菜单
	public function deleteMenu(){
		$reslut=$this->data(CURL::getpost(APIURL."cgi-bin/menu/delete?access_token=".$this->createAccessToken(),null));
		return $reslut;	
	}	
	//获取二维码
	public function qrLinkCode($qrcodeID,$expire_seconds=2592000){
		$arr=array("expire_seconds"=>$expire_seconds,"action_name"=>"QR_SCENE","action_info"=>array("scene"=>array("scene_id"=>$qrcodeID)));
		//print_r($arr);die;
		$reslut=$this->data(CURL::getpost(APIURL."cgi-bin/qrcode/create?access_token=".$this->createAccessToken(),$arr,"application/json"));
		
		return $reslut;	
	}
		//获取永久二维码
	public function qrLimtLinkCode($qrcodeID){
		$arr=array("action_name"=>"QR_LIMIT_SCENE","action_info"=>array("scene"=>array("scene_id"=>$qrcodeID)));
		//print_r($arr);die;
		$reslut=$this->data(CURL::getpost(APIURL."cgi-bin/qrcode/create?access_token=".$this->createAccessToken(),$arr,"application/json"));
		
		return $reslut;	
	}
	//返回APID
	public function getAppID(){
		return $this->AppID;
	}
	public function getUserInfo($OPENID){
		$reslut=$this->data(CURL::getpost(APIURL."cgi-bin/user/info?access_token=".$this->createAccessToken() . "&openid=$OPENID&lang=zh_CN",null));
		return $reslut;		
	}
	//获取openid
	public function getOpenID($code){
		$reslut=$this->data(CURL::getpost(APIURL."sns/oauth2/access_token?appid=" . $this->AppID . "&secret=" . $this->AppSecret . "&code=$code&grant_type=authorization_code",null));
		return $reslut;
	}
	//模版消息
	public function sendModeText($openid,$templeteid,$url,$array){
		$sendArray=array(
			"touser"=>$openid,
			"template_id"=>$templeteid,
			"url"=>empty($url) ? "#" : $url,
			"data"=>$array
		);
		$reslut=$this->data(CURL::getpost(APIURL."cgi-bin/message/template/send?access_token=".$this->createAccessToken(),$sendArray,"application/json"));
		return ["data"=>$sendArray,"reslut"=>$reslut];			
	}
	//客服消息
	public function customText($sendArray){
		$reslut=$this->data(CURL::getpost(APIURL."cgi-bin/message/custom/send?access_token=".$this->createAccessToken(),$sendArray,"application/json"));
		return $reslut;
	}
	//长链接转短链接
	Public function shorturl($shorturl_url){
		$arr_shorturl=array("action"=>"long2short",'long_url'=>$shorturl_url);
		//print_r($arr_shorturl);die;
		$reslut=$this->data(CURL::getpost(APIURL."cgi-bin/shorturl?access_token=".$this->createAccessToken(),$arr_shorturl,"application/json"));
		return $reslut;	
	}
	//针对微信中文json
	
		private  function wx_json_encode($arr) {
        $parts = array ();
        $is_list = false;
        //Find out if the given array is a numerical array
        $keys = array_keys ( $arr );
        $max_length = count ( $arr ) - 1;
        if (($keys [0] === 0) && ($keys [$max_length] === $max_length )) { //See if the first key is 0 and last key is length - 1
            $is_list = true;
            for($i = 0; $i < count ( $keys ); $i ++) { //See if each key correspondes to its position
                if ($i != $keys [$i]) { //A key fails at position check.
                    $is_list = false; //It is an associative array.
                    break;
                }
            }
        }
        foreach ( $arr as $key => $value ) {
            if (is_array ( $value )) { //Custom handling for arrays
                if ($is_list)
                    $parts [] = $this->wx_json_encode ( $value ); /* :RECURSION: */
                else
                    $parts [] = '"' . $key . '":' . $this->wx_json_encode ( $value ); /* :RECURSION: */
            } else {
                $str = '';
                if (! $is_list)
                    $str = '"' . $key . '":';
                //Custom handling for multiple data types
                if (is_numeric ( $value ) && $value<2000000000)
                    $str .= $value; //Numbers
                elseif ($value === false)
                $str .= 'false'; //The booleans
                elseif ($value === true)
                $str .= 'true';
                else
                    $str .= '"' . addslashes ( $value ) . '"'; //All other things
                // :TODO: Is there any more datatype we should be in the lookout for? (Object?)
                $parts [] = $str;
            }
        }
        $json = implode ( ',', $parts );
        if ($is_list)
            return '[' . $json . ']'; //Return numerical JSON
        return '{' . $json . '}'; //Return associative JSON
    }	
	
	//获取AccessToken
	private function createAccessToken(){
		$iscache=true;
		if(file_exists("/access_token_" . $this->AppID . ".php")) {
			$reslut=include("/access_token_" . $this->AppID . ".php");
			$tim=$reslut["time"];
			if(time()-$tim+1800<$reslut["expires_in"]){
				$iscache=false;
			}

		}

if($iscache){
			$res=CURL::getpost(APIURL."cgi-bin/token?grant_type=client_credential&appid=".$this->AppID."&secret=".$this->AppSecret,null);
			$reslut=$this->data($res);
			$iscache=true;		
		
		$reslut=array_merge($reslut,array("time"=>time()));
		$txt="<?php return ".var_export($reslut,true)."?>";
		 $this->cache("access_token_" . $this->AppID . ".php",$txt);
		 }
		return $reslut["access_token"];
	}

	
	//获取jsToken
	private function createJsToken(){
		$iscache=true;
		if(file_exists("/js_token_" . $this->AppID . ".php")) {
			$reslut=include("/js_token_" . $this->AppID . ".php");
			$tim=$reslut["time"];
			if(time()-$tim+1800<$reslut["expires_in"]){
				$iscache=false;
			}

		}

if($iscache){
			$res=CURL::getpost(APIURL."cgi-bin/ticket/getticket?access_token=" . $this->createAccessToken() . "&type=jsapi",null);
			$reslut=$this->data($res);
			$iscache=true;
		
		$reslut=array_merge($reslut,array("time"=>time()));
		$txt="<?php return ".var_export($reslut,true)."?>";
		 $this->cache("js_token_" . $this->AppID . ".php",$txt);
		 }
		return $reslut["ticket"];
	}
//生成js验证码
	public function createJsSign($tmpArr){
		$tmpArr["jsapi_ticket"]=$this->createJsToken();
		$tmpArr["noncestr"]=$this->createNonceStr();
		$tmpArr["timestamp"]=time();
		$tmpUri=$tmpArr["url"];
		$tmpUris=explode("#",$tmpUri);
		$tmpArr["url"]=$tmpUris[0];
		$tmpStr = "jsapi_ticket=" . $tmpArr["jsapi_ticket"] . "&noncestr=" . $tmpArr["noncestr"] . "&timestamp=" . $tmpArr["timestamp"] . "&url=" . $tmpArr["url"];
	
		$Sign = sha1( $tmpStr );
		return array("signature"=>$Sign,"appid"=>$this->AppID,"url"=>$tmpArr["url"],"noncestr"=>$tmpArr["noncestr"],"timestamp"=>$tmpArr["timestamp"],"tmpstr"=>$tmpStr);
	}	

  public function createNonceStr($length = 16) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $str = "";
    for ($i = 0; $i < $length; $i++) {
      $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
    }
    return $str;
  }	
	
	//解析CURL数据
	private function data($data){
		return json_decode($data["body"],true);
		
	}
	//缓存文件
	private function cache($id,$txt){
		$fp = fopen($id,'w+');
		fwrite($fp,$txt);
		fclose($fp);
	}
//消息处理

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
        sort($tmpArr);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );

        if( $tmpStr == $signature ){
            return true;
        }else{
            return false;
        }
    }

    public function responseMsg()
    {
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
        if (!empty($postStr)){
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $RX_TYPE = trim($postObj->MsgType);

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
        $contentStr = "你发送的是文本，内容为：".$object->Content."帐号：".$object->FromUserName;
        $resultStr = $this->transmitText($object, $contentStr, $funcFlag);
        return $resultStr;
    }

    private function receiveImage($object)
    {
        $funcFlag = 0;
        $contentStr = "你发送的是图片，地址为：".$object->PicUrl;
        $resultStr = $this->transmitText($object, $contentStr, $funcFlag);
        return $resultStr;
    }

    private function receiveLocation($object)
    {
        $funcFlag = 0;
        $contentStr = "你发送的是位置，纬度为：".$object->Location_X."；经度为：".$object->Location_Y."；缩放级别为：".$object->Scale."；位置为：".$object->Label;
        $resultStr = $this->transmitText($object, $contentStr, $funcFlag);
        return $resultStr;
    }

    private function receiveVoice($object)
    {
        $funcFlag = 0;
        $contentStr = "你发送的是语音，媒体ID为：".$object->MediaId;
        $resultStr = $this->transmitText($object, $contentStr, $funcFlag);
        return $resultStr;
    }

    private function receiveVideo($object)
    {
        $funcFlag = 0;
        $contentStr = "你发送的是视频，媒体ID为：".$object->MediaId;
        $resultStr = $this->transmitText($object, $contentStr, $funcFlag);
        return $resultStr;
    }

    private function receiveLink($object)
    {
        $funcFlag = 0;
        $contentStr = "你发送的是链接，标题为：".$object->Title."；内容为：".$object->Description."；链接地址为：".$object->Url;
        $resultStr = $this->transmitText($object, $contentStr, $funcFlag);
        return $resultStr;
    }

    private function receiveEvent($object)
    {
        $contentStr = "";
        switch ($object->Event)
        {
            case "subscribe":
				$qrscene=$object->EventKey;
				$openid=$object->FromUserName;
                $contentStr = $openid."欢迎关注".$qrscene;
                break;
            case "unsubscribe":
                $contentStr = "";
                break;
            case "CLICK":
                switch ($object->EventKey)
                {
                    default:
					
					if($object->EventKey=="TG_QRCODE"){
						
						
						
						
						die;
					}
					
					else if($object->EventKey=="BIND_USER"){
						$contentStr = "您好，<a href=\"http://msy.gztet.com/home/bind.html?openid=" . $object->FromUserName . "\">点此绑定帐号</a>";
					}
					else{
                        $contentStr = "你点击了: ".$object->EventKey;
						}
                        break;
                }
                break;
            default:
                $contentStr = "receive a new event: ".$object->Event;
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
	
	
	}







?>