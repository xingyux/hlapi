<?php
namespace Home\Controller;
use Think\Controller;
class AddController extends Controller {
    public function index(){
						import("Org.API.mp_require");
					$MP_API=new \mpAPI();	
				$openid=isset($_GET["openid"]) ? $_GET["openid"] : null;
				if(empty($openid)){$openid=isset($_SESSION["openid"]) ? $_SESSION["openid"] : null;}
				
				if(empty($openid)){
					$code=(isset($_GET["code"])) ? I("get.code") : null ;
					if(empty($code)){
						$this->assign("error","错误的参数，请从公众号中重新点入");
						$this->display();
						die;
					}

					$result=$MP_API->getOpenID($code);
					if(empty($result["openid"])){
						$this->assign("error","错误的参数，请从公众号中重新点入<br>".var_export($result,true));
						$this->display();
						die;						
					}
					$openid=$result["openid"];
					$_SESSION["openid"]=$openid;
				}
				
				$userlist = M('UserList')->where(array('openid'=>$openid))->find();
				if(empty($userlist)){
						$this->assign("error","用户不存在");
						$this->display();
						die;					
				}
				if($userlist["check"]==1){
						$this->assign("error","恭喜您，您的认证已通过！");
						$this->display();
						die;						
				}
				if($userlist["check"]==2){
						$this->assign("error","您的证件照片未通过审核，请重新上传");
						$this->display();
						die;						
				}
				if($userlist["check"]==4){
						$this->assign("error","请等待管理人员进行证件照片审核");
						$this->display();
						die;						
				}				
				if($userlist["check"]==3){
						$this->assign("error","您的认证被取消，请联系客服");
						$this->display();
						die;						
				}				
				if(empty($userlist["pic"])){
						$this->assign("error","请先在公众号中上传证件照片");
						$this->display();
						die;						
				}

    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $jsurl = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	$jsApiArray["url"]=$jsurl;
	$signature=$MP_API->createJsSign($jsApiArray);	
	$this->assign('jsArray',$signature);				
				
				$this->assign("openid",$openid);
                $this->display();
       }
	   public function sendsms(){
		   $phone=I("post.phone");
		   $openid=I("post.openid");
		   if(empty($openid)){
			   $this->ajaxreturn(array("code"=>1,"message"=>"参数错误，请重新从公众号中进入"));die;
		   }
		   if(empty($phone)){
			   $this->ajaxreturn(array("code"=>1,"message"=>"手机号错误"));die;
		   }

        if(!preg_match("/^1[3458]\d{9}$/",$phone)){
			$this->ajaxreturn(array("code"=>1,"message"=>"手机号错误"));die;
        }

				$userlist = M('UserList')->where(array('openid'=>$openid))->find();
				if(empty($userlist)){
						$this->ajaxreturn(array("code"=>1,"message"=>"用户不存在"));die;				
				}
				if($userlist["check"]==1){
					$this->ajaxreturn(array("code"=>1,"message"=>"恭喜您，您的认证已通过！"));die;						
				}
				if(empty($userlist["pic"])){
					$this->ajaxreturn(array("code"=>1,"message"=>"请先在公众号中上传证件照片"));die;				
				}
				if((int)$userlist["money"]<1){
					$this->ajaxreturn(array("code"=>9,"message"=>"余额不足，请充值后再进行认证"));die;				
				}					
				if(time()-(int)$userlist["smstime"]<60){
					$this->ajaxreturn(array("code"=>1,"message"=>"60秒内只能发送一条短信"));die;		
				}
				$rancode=mt_rand(100000,999999);
				$data=array(
					"rancode"=>$rancode,
					"phone"=>$phone,
					"smstime"=>time(),
				);
				M("UserList")->where(array("id"=>$userlist["id"]))->save($data);
				
				$smsbody=array(
				"action"=>"send",
				"account"=>"szzd00278",
				"password"=>"qq8113456",
				"mobile"=>$phone,
				"content"=>"尊敬的用户您好，您的手机验证码是:" . $rancode,
				"checkcontent"=>0,
				"mobilenumber"=>1,
				"countnumber"=>1,
				"telephonenumber"=>0,
				);
				import("Org.API.curl");
				$res=\CURL::getpost("http://sz.ipyy.com/sms.aspx",$smsbody);
				if($res["code"]>0){
					$this->ajaxreturn(array("code"=>1,"message"=>$res["message"]));die;	
				}
				try{
					$body=simplexml_load_string($res["body"], 'SimpleXMLElement', LIBXML_NOCDATA);
				}catch(Exception $e){
					$this->ajaxreturn(array("code"=>1,"message"=>$e->getMessage()));die;
				}
				
				if($body->returnstatus=="Success"){
					$this->ajaxreturn(array("code"=>0,"message"=>"验证码发送成功，请在短信中查看"));die;	
				}else{
					$this->ajaxreturn(array("code"=>1,"message"=>$body->message));die;	
				}
				
	   }
	   public function bind(){
		   $phone=I("post.phone");
		   $openid=I("post.openid");
		   $realname=I("post.realname");
		   $sfz=I("post.sfz");
			$code=I("post.code");
		   if(empty($openid)){
			   $this->ajaxreturn(array("code"=>1,"message"=>"参数错误，请重新从公众号中进入，本次不扣余额"));die;
		   }
		   if(empty($phone)){
			   $this->ajaxreturn(array("code"=>1,"message"=>"手机号错误，本次不扣余额"));die;
		   }

        if(!preg_match("/^1[3458]\d{9}$/",$phone)){
			$this->ajaxreturn(array("code"=>1,"message"=>"手机号错误，本次不扣余额"));die;
        }
		   if(!$this->isCreditNo($sfz)){
			   $this->ajaxreturn(array("code"=>1,"message"=>"机主身份证号错误，本次不扣余额"));die;
		   }
		   if(empty($realname)){
			   $this->ajaxreturn(array("code"=>1,"message"=>"机主姓名错误，本次不扣余额"));die;
		   }
				$userlist = M('UserList')->where(array('openid'=>$openid))->find();
				if(empty($userlist)){
						$this->ajaxreturn(array("code"=>1,"message"=>"用户不存在，本次不扣余额"));die;				
				}
				if($userlist["check"]==1){
					$this->ajaxreturn(array("code"=>0,"message"=>"恭喜您，您的认证已通过，本次不扣余额！"));die;						
				}
				if(empty($userlist["pic"])){
					$this->ajaxreturn(array("code"=>1,"message"=>"请先在公众号中上传证件照片，本次不扣余额"));die;				
				}
				if((int)$userlist["money"]<1){
					$this->ajaxreturn(array("code"=>9,"message"=>"余额不足，请充值后再进行认证"));die;				
				}					
				if($userlist["phone"]!=$phone){
					$this->ajaxreturn(array("code"=>1,"message"=>"请使用接收验证码的手机验证，本次不扣余额"));die;						
				}
				if($userlist["rancode"]!=$code){
					$this->ajaxreturn(array("code"=>1,"message"=>"验证码错误，本次不扣余额"));die;						
				}	
				if(time()-(int)$userlist["smstime"]>1800){
					$this->ajaxreturn(array("code"=>1,"message"=>"验证码超过半小时，请重新获取，本次不扣余额"));die;		
				}
				$data=array("idcard"=>$sfz,"realname"=>$realname);
				M("UserList")->where(array("id"=>$userlist["id"]))->save($data);
				M("UserList")->where(array("id"=>$userlist["id"]))->setInc("money",-1);
				$outmoney=$userlist["money"]-1;
				$juhuUrl="http://v.juhe.cn/telecom/query?";
				$juhuQuery="key=58ba352f29f842910f18e4b3b9098248&idcard=" . strtoupper($sfz) . "&realname=" . urlencode($realname) . "&mobile=" . $phone;
				import("Org.API.curl");
				
				$res=\CURL::getpost($juhuUrl . $juhuQuery,null);
				
				if($res["code"]>0){
					$this->ajaxreturn(array("code"=>1,"message"=>"错误：" . $res["message"] . "，本次扣费1次，帐号余额{$outmoney}元"));die;	
				}
				$body=json_decode($res["body"],true);
				if(empty($body)){
					$this->ajaxreturn(array("code"=>1,"message"=>"错误：" . $res["body"] . "，本次扣费1次，帐号余额{$outmoney}元"));die;	
				}
				$error_code=$body["error_code"];
				if($error_code!=0){
					
					
					
					M("UserList")->where(array("id"=>$userlist["id"]))->save(array("check"=>1,"error_code"=>$error_code,"msg"=>$body["reason"]));
					$this->ajaxreturn(array("code"=>0,"message"=>"恭喜您认证成功，请重新扫二维码绑定机器即可使用，谢谢您的合作"));die;	
					}
				$result=$body["result"]["res"];
				if($result!=1){
					M("UserList")->where(array("id"=>$userlist["id"]))->save(array("error_code"=>$error_code,"msg"=>$body["result"]["resmsg"]));
					
				$this->ajaxreturn(array("code"=>1,"message"=>"认证失败：" . $body["result"]["resmsg"] . "，本次扣费1次，帐号余额{$outmoney}元"));die;	
				}
				M("UserList")->where(array("id"=>$userlist["id"]))->save(array("check"=>1));	
				$this->ajaxreturn(array("code"=>0,"message"=>"恭喜您认证成功，请重新扫二维码绑定机器即可使用，谢谢您的合作"));die;	
				
	   }
	public function dopay(){
	 import("Org.API.mp_require");
	 import("Org.API.order");
	 import("Org.API.xml");
		$MP_API=new \mpAPI();	
		   $phone=I("post.phone");
		   $openid=I("post.openid");
		   if(empty($openid)){
			   $this->ajaxreturn(array("code"=>1,"message"=>"参数错误，请重新从公众号中进入"));die;
		   }
		   if(empty($phone)){
			   $this->ajaxreturn(array("code"=>1,"message"=>"手机号错误"));die;
		   }

        if(!preg_match("/^1[3458]\d{9}$/",$phone)){
			$this->ajaxreturn(array("code"=>1,"message"=>"手机号错误"));die;
        }

				$userlist = M('UserList')->where(array('openid'=>$openid))->find();
				if(empty($userlist)){
						$this->ajaxreturn(array("code"=>1,"message"=>"用户不存在"));die;				
				}
				if($userlist["check"]==1){
					$this->ajaxreturn(array("code"=>1,"message"=>"恭喜您，您的认证已通过！"));die;						
				}
				if(empty($userlist["pic"])){
					$this->ajaxreturn(array("code"=>1,"message"=>"请先在公众号中上传证件照片"));die;				
				}
	$order=array(
		"orderid"=>$MP_API->createNonceStr(5) . time(),
		"phone"=>$phone,
		"openid"=>$openid,
		"state"=>0,
		"moneystate"=>0,
		"money"=>5,
		"tim"=>time(),
	);
	$orderID=M("order")->add($order);
	$payarray=array(
		"appid"=>AppID,
		"mch_id"=>mchid,
		"device_info"=>"WEB",
		"nonce_str"=>$MP_API->createNonceStr(32),
		"body"=>"用户名" . $order["phone"],
		"out_trade_no"=>$order["orderid"],
		"total_fee"=>$order["money"]*100,
		"spbill_create_ip"=>"127.0.0.1",
		"notify_url"=>"http://weixin.bohaofuwuqi.com" . U("wxnotify",array("oid"=>$orderID)),
		"trade_type"=>"JSAPI",
		"product_id"=>$order["phone"],
		"openid"=>$openid,
		
	);
		$res=\WXPAY::connnet("pay/unifiedorder",$payarray,true);

	if($res["code"]>0){
		$this->ajaxReturn(array("code"=>1,"message"=>$res["message"]));die;
	}
	$xml2 = new \A2Xml();
	$data=$xml2->uncdata($res["body"]);
	$data=json_decode(json_encode( (array)simplexml_load_string($data)),true);
	if($data["return_code"]!="SUCCESS"){
		$this->ajaxReturn(array("code"=>1,"message"=>$data["return_msg"]));die;
	}
	if($data["result_code"]!="SUCCESS"){
		$this->ajaxReturn(array("code"=>1,"message"=>$data["err_code_des"]));die;	
	}
	 $prepay_id=$data["prepay_id"];

	$wxpayarray=array(
		"appId"=>AppID,
		"nonceStr"=>$MP_API->createNonceStr(32),
		"package"=>"prepay_id=$prepay_id",
		"signType"=>"MD5",
		"timeStamp"=>time(),
	);	 
	
		foreach($wxpayarray as $k=>$v){
			$arrkey[]=$k;
		}
		sort($arrkey,SORT_STRING);
		$stringA="";
		foreach($arrkey as $k=>$v){
			$stringA.="&$v=".$wxpayarray[$v];
		}
		$stringA=substr($stringA,1);
		$stringA.="&key=".mchkey;
		$sign=strtoupper(MD5($stringA));	
	
	// $paySign=\WXPAY::createsign($wxpayarray);

	$paylist=array(
		"nonceStr"=>$wxpayarray["nonceStr"],
		"package"=>$wxpayarray["package"],
		"signType"=>"MD5",
		"timestamp"=>$wxpayarray["timeStamp"],
		"paySign"=>$sign
	);
	 $this->ajaxReturn(array("code"=>0,"paylist"=>$paylist));die;		
		
		
	}   
	
	public function wxnotify(){
	$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
	
			import("Org.API.xml");
			$xml2 = new \A2Xml();
	 
	 
	
	 
		if (!empty($postStr)){
				$data=$xml2->uncdata($postStr);
				$data=json_decode(json_encode( (array)simplexml_load_string($data)),true);		
				if(!$data){
					echo "fail";die;
				}
				$orderid=$data["out_trade_no"];
				if(!$orderid){
					echo "fail";die;
				}
				 $order=M("order")->where(array("orderid"=>$orderid))->find();
			if(!$order){
				echo "fail";die;
			}
			ksort($data,SORT_STRING);
					$arrkey=array();
					foreach($data as $k=>$v){
						if($k!="sign"){
							$arrkey[]=$k."=".$v;
						}
					}
					import("Org.API.mp_require");
					$stringA=implode("&",$arrkey);
					$stringA.="&key=".mchkey;
					$sign=strtoupper(MD5($stringA));
					if($sign!=$data["sign"]){
						echo "fail";die;
					}
					if($data["result_code"]!="SUCCESS"){
						echo "fail";die;
					}
					if($order["state"]==1&&$order["moneystate"]==1){
						echo "SUCCESS";die;
					}
					if($order["state"]==1){
						$model = M();
						$model->startTrans();	
						$transflag=true;
						$transflag=$model->table(C('DB_PREFIX').'order')->where(array("id"=>$order["id"]))->save(array("ntime"=>time(),"moneystate"=>1));
						if($transflag){
							$transflag=$model->table(C('DB_PREFIX').'user_list')->where(array("openid"=>$order["openid"]))->setInc("money",1);
						}
						if($transflag){
							$model->commit();
							
							setText($order,$MP_API);
							
							echo "SUCCESS";die;
						}else{
							echo "fail";die;
						}
					}
						$model = M();
						$model->startTrans();	
						$transflag=true;
						$transflag=$model->table(C('DB_PREFIX').'order')->where(array("id"=>$order["id"]))->save(array("ntime"=>time(),"state"=>1,"moneystate"=>1));
						if($transflag){
							$transflag=$model->table(C('DB_PREFIX').'user_list')->where(array("openid"=>$order["openid"]))->setInc("money",1);
						}
						if($transflag){
							$model->commit();
							
							setText($order,$MP_API);
							
							echo "SUCCESS";die;
						}else{
							echo "fail";die;
						}						
					
		}else{
			echo "fail";
		}
		
		
	}
	
	private function setText($sorder,$MP_API){
		$order=M("order")->find($sorder["id"]);
		if($order["state"]==1&&$order["moneystate"]==1){
			
			$sendText=array(
				"first"=>array("value"=>"您好" . $order["phone"] . "，您的支付已成功到账。","color"=>"#173177"),
				"keyword1"=>array("value"=>$order["money"] . "元","color"=>"#173177"),
				"keyword2"=>array("value"=>$order["orderid"],"color"=>"#173177"),
				"remark"=>array("value"=>"您的支付已成功到账，您可以继续尝试进行实名认证，感谢你的使用。","color"=>"#173177"),
			);
			
					$url="http://weixin.bohaofuwuqi.com" . U('Home/add/index');
					$WXUri="https://open.weixin.qq.com/connect/oauth2/authorize?appid=" . $MP_API->getAppID() . "&redirect_uri=" . urlencode($url) . "&response_type=code&scope=snsapi_base&state=1#wechat_redirect";

			
			$sendTextRes=$MP_API->sendModeText($order["openid"],"b4qjh6Qhe1MGVbLV5BuhQxaemt_8-ePTnrp8Etr5vlw",$WXUri,$sendText);		
			}
	}
	
	private function isCreditNo($vStr)
{
    $vCity = array(
        '11','12','13','14','15','21','22',
        '23','31','32','33','34','35','36',
        '37','41','42','43','44','45','46',
        '50','51','52','53','54','61','62',
        '63','64','65','71','81','82','91'
    );
 
    if (!preg_match('/^([\d]{17}[xX\d]|[\d]{15})$/', $vStr)) return false;
 
    if (!in_array(substr($vStr, 0, 2), $vCity)) return false;
 
    $vStr = preg_replace('/[xX]$/i', 'a', $vStr);
    $vLength = strlen($vStr);
 
    if ($vLength == 18)
    {
        $vBirthday = substr($vStr, 6, 4) . '-' . substr($vStr, 10, 2) . '-' . substr($vStr, 12, 2);
    } else {
        $vBirthday = '19' . substr($vStr, 6, 2) . '-' . substr($vStr, 8, 2) . '-' . substr($vStr, 10, 2);
    }
 
    if (date('Y-m-d', strtotime($vBirthday)) != $vBirthday) return false;
    if ($vLength == 18)
    {
        $vSum = 0;
 
        for ($i = 17 ; $i >= 0 ; $i--)
        {
            $vSubStr = substr($vStr, 17 - $i, 1);
            $vSum += (pow(2, $i) % 11) * (($vSubStr == 'a') ? 10 : intval($vSubStr , 11));
        }
 
        if($vSum % 11 != 1) return false;
    }
 
    return true;
}
}