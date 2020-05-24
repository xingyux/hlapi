<?php
namespace Home\Controller;

use Think\Controller;
use Think;


class ApiController extends Controller{
	
	protected function _initialize(){
		
		if(!file_exists(CONF_PATH . "db.bak")){			$this->redirect("Install/index");		}
		
	}
	function message($code,$str){		//$this->error($str);die;		$this->assign('code',$code);		$this->assign('message',$str);		$this->display("Common/message");		die;	}		
}