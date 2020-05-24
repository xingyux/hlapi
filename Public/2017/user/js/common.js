


var _return_WXLogin=function(ret,checkcode){

			try{
			var r=eval("("+ret+")");
			if(r.code==0){
			top.location.href=_WXLogin_Config.Login._returnurl;
			}else if(r.code==9){
				setTimeout(function(){_WXLogin(checkcode);},5000);
			}else{
				$(_WXLogin_Config.Login.infoId).html(r.message);
			}
			}catch(e){
				alert(ret);
			$(_WXLogin_Config.Login.infoId).html(ret);
			}
		}
		var _WXLogin=function(checkcode){getPost(_WXLogin_Config.WXLoginPath+"?act=qrlogin","checkcode="+checkcode,"_return_WXLogin",checkcode);}
var _load_qrimg_WXLogin=function(ret,o){
	
	try{
		var r=eval("("+ret+")");
		if(r.code!=0){
		if(confirm(r.message)){
				_insert_Login(o.type,o.obj);
			}
		}else{
		
			var info=eval("_WXLogin_Config."+o.type);
			$(info.QRCodeIMG).attr("src",r.img);
			
			_WXLogin(r.checkcode);
			
		}
	}catch(e){
		if(confirm("未知错误，是否重新载入……")){
				_insert_Login(o.type,o.obj);
			}
	}
}


var _WXRegsiter=function(checkcode,o){
	jsonstr=o.jsonstr;
	jsonstr.checkcode=checkcode;
	getPost(_WXLogin_Config.WXLoginPath+"?act=qrregsiter",jsonstr,function(r,o){
			var info=eval("_WXLogin_Config."+o.type);
			if(r.code==0){
			o.obj.show("Login",function(type,obj){
				_insert_Login(type,obj);
			});
			}
			else if(r.code==8){

	if(confirm("此微信号已绑定其他帐号，是否更换微信重新扫码?")){
setTimeout(function(){_WXRegsiter(checkcode,o);},5000);
		}else{
			$(info.QRCodeIMG).closest("div").html("此微信号已绑定其他帐号");
		}			
				
				
			}
			else if(r.code==9){
				setTimeout(function(){_WXRegsiter(checkcode,o);},5000);
			}else{
				$(info.QRCodeIMG).closest("div").html(r.message);
			}
	
	},o,"json");
	}
var _load_qrimg_WXRegsiter=function(ret,o){
	try{
		var r=eval("("+ret+")");
		if(r.code!=0){
					if(confirm(r.message)){

			_insert_Regsiter(o.type,o.obj,o.jsonstr);
		}

		}else{
			var info=eval("_WXLogin_Config."+o.type);
			$(info.QRCodeIMG).attr("src",r.img);
			
			_WXRegsiter(r.checkcode,o);
			
		}
	}catch(e){
		if(confirm("未知错误，是否重新载入……")){

			_insert_Regsiter(o.type,o.obj,o.jsonstr);
		}
		
	}
}
var regsiterqrcode=function(type,obj){
	if(type=="Register"){
		var info=eval("_WXLogin_Config."+type);
		obj.dialog.find(info.SubmitButton).unbind("click");
		obj.dialog.find(info.SubmitButton).click(function(){
			obj.submitserver(type,obj,null,function(jsonstr){
				obj.dialog.find(info.infoId).hide();
			obj.dialog.find(info.SubmitButton).closest("div").hide();
			obj.dialog.find(info.QRCodeIMG).closest("div").show();
			_insert_Regsiter(type,obj,jsonstr);
				
			})
		})
		
		
	}
}
var _insert_Login=function(type,obj){
	getPost(_WXLogin_Config.WXLoginPath+"?act=qrcode","","_load_qrimg_WXLogin",{type:type,obj:obj});
}
var _insert_Regsiter=function(type,obj,jsonstr){
	getPost(_WXLogin_Config.WXLoginPath+"?act=qrcode","","_load_qrimg_WXRegsiter",{type:type,obj:obj,jsonstr:jsonstr});
}

function is_mobile() {  
var regex_match = /(nokia|iphone|android|motorola|^mot-|softbank|foma|docomo|kddi|up.browser|up.link|htc|dopod|blazer|netfront|helio|hosin|huawei|novarra|CoolPad|webos|techfaith|palmsource|blackberry|alcatel|amoi|ktouch|nexian|samsung|^sam-|s[cg]h|^lge|ericsson|philips|sagem|wellcom|bunjalloo|maui|symbian|smartphone|midp|wap|phone|windows ce|iemobile|^spice|^bird|^zte-|longcos|pantech|gionee|^sie-|portalmmm|jigs browser|hiptop|^benq|haier|^lct|operas*mobi|opera*mini|320x320|240x320|176x220)/i;  
var u = navigator.userAgent;  
if (null == u) {  
return true;  
}  
var result = regex_match.exec(u);  
if (null == result) {  
return false  
} else {  
return true  
}  
}  

function isWeiXin(){
    var ua = window.navigator.userAgent.toLowerCase();
    if(ua.match(/MicroMessenger/i) == 'micromessenger'){
        return true;
    }else{
        return false;
    }
}

$(function(){

if(isWeiXin()){
	$(_WXLogin_Config.Login.Button).hide();
	$(_WXLogin_Config.CheckCode.Button).hide();
}

if(is_mobile()&&!isWeiXin()){
	$(_WXLogin_Config.Login.Button).attr("href","/Home/UserInfo/");
	$(_WXLogin_Config.CheckCode.Button).hide();
	return false;
}

	
	if(!_WXLogin_Config.Login.Button){
		getPost(_WXLogin_Config.WXLoginPath+"?act=qrcode","","_load_qrimg_WXLogin");
	}
	else{
		$(_WXLogin_Config.Login.Button).click(function(){
			
			
			var WXLogin_logon = new Logon();
			WXLogin_logon.show("Login",function(type,obj){
				_insert_Login(type,obj);
			});return false;
		});
	}

	if(_WXLogin_Config.CheckCode.Button){
		$(_WXLogin_Config.CheckCode.Button).click(function(){
			var WXLogin_logon = new Logon();
			WXLogin_logon.show("CheckCode",function(type,obj){	
				regsiterqrcode(type,obj);
			});
			return false;
		});		
	}

})