<?php
namespace Home\Controller;
use Think\Controller;
class QrcodeController extends Controller {
    public function index(){
		$id=I("get.id");
		if((int)$id==0){
			echo "fail";die;
		}
		$code=$id+10000000;
                import("Org.API.mp_require");
                $MP_API=new \mpAPI();
				$res=$MP_API->qrLinkCode($code);
				$ticket=$res["ticket"];	
				$routeUrl='https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket='.$ticket;
				Header("HTTP/1.1 301 Moved Permanently");
				Header("Location: " . $routeUrl);
       }
	
}