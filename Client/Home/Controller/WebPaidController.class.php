<?php
namespace Home\Controller;
use Think\Controller;
use Common\Util\Page;
class WebPaidController extends HomeController {
    public function index(){
        $type = I('get.type');
		$them = empty( $type ) ? 'index' : $type;

		$array = [
		    'index'=>['name'=>'腾讯云'],
            'ali'=>['name'=>'阿里云'],
            'ty'=>['name'=>'天翼云'],
            'bd'=>['name'=>'百度云'],
            'hnja'=>['name'=>'景安快云服务器'],

        ];
        $array[$them]['active']='active';
        $this->assign('Type',$array);
        $this->assign('ThisType',$array[$them]);
        $this->assign('sType',$them);
		$this->display( $them );
		
       }

}