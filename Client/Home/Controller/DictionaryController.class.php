<?php
namespace Home\Controller;
use Think\Controller;
class DictionaryController extends LoginController {
	
	
    public function index(){
		S(array('type'=>'File','prefix'=>'Dictionary','expire'=>65535));
		
		$conf = getConfig();
		$ses = session('USER_INFO');
		$chekced=($conf["acname"]==$ses["username"]) ? true : false;
		$DictionaryType=C("Dictionary");
				if(I("get.action")=="update"){

		if(!$chekced){
			$this->error("权限不足");die;
		}	
		
			$valuecacheAPI=$this->Api(array("cachetime"=>time()),"Cache","dictionary");
			$valuecache=$valuecacheAPI["cache"];
			foreach($valuecache as $k=>$v){
				$find=M("Dictionary")->where(array("id"=>$v["id"]))->find();
			if($find){
					M("Dictionary")->where(array("id"=>$v["id"]))->save($v);
				}else{
					M("Dictionary")->add($v);
				}
			}
			foreach($DictionaryType as $k=>$v){
				S("Dictionary" . $k,null);
			}
			
			$this->success("同步成功",U("index"));die;
				}
		
		$type=(empty($_GET["type"])) ? "address" : $_GET["type"];
		$Rows=S("Dictionary" . $type);
		if(!$Rows){
			$Rows=M("Dictionary")->where(array("type"=>$type))->order("ord asc,id asc")->select();
			S("Dictionary" . $type,$Rows);
		}
		$this->assign('DictionaryType',$DictionaryType);	
		$this->assign('Dictionary',$Rows);	
		$this->display();
		
       }
	  
}