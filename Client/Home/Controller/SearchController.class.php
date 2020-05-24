<?php
namespace Home\Controller;
use Think\Controller;
class SearchController extends LoginController {
	
	
    public function index(){
		
		$search_keyword=I("post.search_keyword");
		
		$link="{$search_keyword["model_name"]}/{$search_keyword["controller_name"]}/{$search_keyword["action_name"]}";
		unset($search_keyword["model_name"]);
		unset($search_keyword["controller_name"]);
		unset($search_keyword["action_name"]);
		$this->redirect($link,array("page"=>1,"show"=>I("post.show"),"search_keyword"=>base64_encode( json_encode($search_keyword) )));
		
       }


	  
}