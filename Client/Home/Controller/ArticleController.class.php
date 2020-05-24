<?php
namespace Home\Controller;
use Think\Controller;
use Common\Util\Page;
class ArticleController extends HomeController {
	
	
    public function index(){
		
		$page=((int)$_GET["page"]<1) ? 1 : $_GET["page"];
		
		$limits=($page-1)*$pagesize;
		$limite=$pagesize;		
		
		$where["type"]=urldecode(I("get.type"));
		
		$count=M("News")->where($where)->count();
		$news=M("News")->where($where)->page("{$page},10")->order("id desc")->select();
		$this->assign('news',$news);

		$Page       =  new Page($count,10);
		
		$show       = $Page->showFront();
	
		$this->assign('page',$show);
		$this->assign('type',urldecode(I("get.type")));
		$this->display();
		
       }

function view(){
	$newsview=M("News")->find((int)I("get.id"));
	if(empty($newsview)){
		$this->error("文章不存在");die;
	}
	$this->assign('newsview',$newsview);
	$this->display("index");
}


	  
}