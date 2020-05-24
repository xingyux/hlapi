<?php
namespace Home\Controller;
use Think\Controller;

class CloudController extends HomeController {
    public function index(){
		$resAPI=$this->Api();
		if(IS_GET){

			$servers_where["servertype"]="cloud";
			$servers_where["state"]=0;
			$servers=M("servers")->where($servers_where)->order("ord asc,id asc")->select();		
			$productshow=array("list"=>$product,"mode"=>$product[0]["pid"]);
			$this->assign('servers',$servers);
			$this->assign('resAPI',$resAPI);
			$this->assign('product',$productshow);
            $room = I('get.room');
			if( $room=='aliyun' || $room=='aliyunv3' || empty( $room ) ){
                $this->display('aliyun');
            }elseif($room=='qqyun' ){
                $this->display('qcloud');
            }else{
                $this->display();
            }


		} else {
			$this->ajaxreturn($resAPI);
		}
	}

	public function index4(){
           $this->display();
	}

}