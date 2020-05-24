<?php
namespace Home\Controller;
use Think\Controller;
class PluginController extends LoginController {
	
	
    public function index(){
		$checkWebUser=checkWebUser();
		if($checkWebUser===false){
			$this->error("没有权限");die;
		}		
		$res=$this->ApiReturn();
		$this->assign('res',$res);
		$this->display();
		
       }

    public function install(){
		$checkWebUser=checkWebUser();
		if($checkWebUser===false){
			$this->error("没有权限");die;
		}		
		$res=$this->ApiReturn();

		if(IS_POST){
		
			$type=$res["type"];
			$tmplete_path = C("tmplete_path");
			if( $res["path"]!="View" && !is_dir( MODULE_PATH . "View/{$tmplete_path}/mobile" ) ){
				$this->success("没有手机模版");die;
			}
			$vpath = ($res["path"]=="View") ? "View/{$tmplete_path}/pc" : "View/{$tmplete_path}/mobile" ;

			$path=MODULE_PATH . $vpath . "/PluginTpl/";

			if(!is_dir($path)){
				@mkdir($path,0755);
			}
			$PluginTpl=$path . "plugin.html";
			$html = "";
			if(file_exists($PluginTpl)){
					$myfile = fopen($PluginTpl, "r") or die("Unable to open file!");
						$html = fread($myfile,filesize($PluginTpl));
					fclose($myfile);			
			}
			
			$thisplugin= "plugin_" . $type;
			$thispluginhtml="<include file=\"PluginTpl/{$thisplugin}\" />";
			
			file_put_contents( $path . $thisplugin . ".html" , base64_decode($res["result"]));
			if(!strstr($html,$thispluginhtml)){
				$html .= $thispluginhtml;
				file_put_contents( $PluginTpl , $html);
			}
			
			
			$this->success("安装成功",U("index"));
			die;
			
			
		}
		
		
		$this->assign('res',$res);

		
		$this->display();
		
       }	   
	   function uninstall(){
		$checkWebUser=checkWebUser();
		if($checkWebUser===false){
			$this->error("没有权限");die;
		}		   
		$res=$this->ApiReturn();
		
			$type=$res["type"];
			$path=MODULE_PATH . $res["path"] . "/PluginTpl/";
			$PluginTpl=$path . "plugin.html";
			$thisplugin= "plugin_" . $type;
			$thispluginhtml="<include file=\"PluginTpl/{$thisplugin}\" />";
			
			if(file_exists($PluginTpl)){
					$myfile = fopen($PluginTpl, "r") or die("Unable to open file!");
						$html = fread($myfile,filesize($PluginTpl));
					fclose($myfile);

			if(strstr($html,$thispluginhtml)){
				$html = str_ireplace($thispluginhtml,"",$html);
				file_put_contents( $PluginTpl , $html);
			}
			
		@unlink($path . $thisplugin . ".html");
			
			}	
			
			
			$this->success("卸载成功",U("index"));
			die;   
		   
	   }
	   function myplugin(){
		$checkWebUser=checkWebUser();
		if($checkWebUser===false){
			$this->error("没有权限");die;
		}
		$res=$this->ApiReturn(array("show"=>"myplugin"),null,"index");
		$this->assign('res',$res);
		$this->display();		   
		   
	   }
	  
}