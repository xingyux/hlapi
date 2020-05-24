<?php
namespace Home\Controller;
use Think\Controller;
use Common\Util\Page;
class NewsController extends LoginController {
	
	
    public function index(){
		$checkWebUser=checkWebUser();
		if($checkWebUser===false){
			$this->error("没有权限");die;
		}
		$page=((int)$_GET["page"]<1) ? 1 : $_GET["page"];
		
		$limits=($page-1)*$pagesize;
		$limite=$pagesize;		
		
		$count=M("News")->count();
		$news=M("News")->page("{$page},10")->order("id desc")->select();
		$this->assign('news',$news);

		$Page       =  new Page($count,10);
		
		$show       = $Page->showFront();
	
		
		
		$this->display();
		
       }

function add(){
	
		$checkWebUser=checkWebUser();
		if($checkWebUser===false){
			$this->error("没有权限");die;
		}	
	
	$news=M("News")->find(I("get.id"));
	$type_array=array("网站公告","技术文章","最新促销");
	if(I("post.submit")=="add"){
		$title=I("post.title");
		$content=I("post.content");
		$type=I("post.type");
		if(empty($title)){
			$this->ajaxreturn(array("code"=>1,"message"=>"请输入标题"));die;
		}
		if(empty($content)){
			$this->ajaxreturn(array("code"=>1,"message"=>"请输入内容"));die;
		}

		if(!in_array($type,$type_array)){
			$this->ajaxreturn(array("code"=>1,"message"=>"请选择正确的分类"));die;
		}

		if(!empty($news["id"])){
		
			 $res=M("News")->where(array("id"=>$news["id"]))->save(
			 	array(
			 		"title"=>$title,
					"content"=>$content,
					"tim"=>time(),
					"type"=>$type,
					)
			 	);
		}else{
 $res=M("News")->where($where)->add(array(
		"title"=>$title,
		"content"=>$content,
		"tim"=>time(),
		"type"=>$type,
	  ));			
		}
		
	  if($res===false){
		  $this->ajaxreturn(array("code"=>1,"message"=>"提交失败"));die;
	  }
	  $this->ajaxreturn(array("code"=>0,"message"=>"提交成功"));die;
	}
	$this->assign('type_array',$type_array);
	$this->assign('news',$news);
	$this->display();
}


	  
}