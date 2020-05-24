<?php
namespace Home\Controller;
use Think\Controller;
use Common\Util\editor\Ueditor\Upload;
class UeditorController extends LoginController {
	
	
    public function index(){
		$upload=new Upload();
		echo $upload->doUpload();
		
       }




	  
}