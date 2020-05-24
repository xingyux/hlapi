<?php
namespace Home\Controller;
use Think\Controller;
class SoftUpdateController extends HomeController {
	
	
    public function index(){
		$this->login();
		
		S(array('type'=>'File','prefix'=>'UpdateCache','expire'=>6000));
		$RESOURE = S("TMPL_PARSE_STRING" );
		if( !empty( $RESOURE ) ){
			$TMPL_PARSE_STRING = C("TMPL_PARSE_STRING");
		$Arr = '<?php
		return array(
		"TMPL_PARSE_STRING"=>array(
		';
		foreach( $TMPL_PARSE_STRING as $key=>$val ){
		if( $key=="__RESOURE__" ){ $val=$RESOURE; }
			$Arr .= "'{$key}'=>'{$val}',";
		}
		$Arr .= '
		),
		);
		?>';
		file_put_contents( APP_PATH . "Home/Conf/config.php" , $Arr );
		S("TMPL_PARSE_STRING" , null );
						}
		S(array('type'=>'File','prefix'=>'UpdateCache','expire'=>600));
		S("update2017" , null);
		$dir = $this->cacheupdate();
		
		if( $dir["code"]!=0 ){
			die($dir["message"]);
		}

		$update = unserialize( $dir["body"] );
		
		foreach( $update["list"]["dir"] as $k=>$v ){
			if( !is_dir( $v ) ){
				mkdir( $v , 0755 );
				
			}
		}
$tab = '<li><a href="#tabs-1">系统版本</a></li>';
$tabs	 = '<div id="tabs-1"><b>最新版本：' . $update["list"]["version"] . '</b><br><b>本地版本：' . C("version") . '</b><br><br><br>' . $update["list"]["VersionList"] . '</div>';
$data = "";
foreach( $update["list"]["update"] as $k=>$v ){
		$tab .= '<li><a href="#tabs-' . ($k+2) . '">' . $v[2] . '</a></li>';
		$tabs .= '<div id="tabs-' . ($k+2) . '" class="tab-' . $v[0] . '">加载中……</div>';
		
		$data .='
		var ' . $v[0] . '=data.' . $v[0] . '||null;
		if(' . $v[0] . '){
		var tab' . $v[0] . ' = "<table style=\"width:100%;\">";
		
		$.each(' . $v[0] . ' , function(k,v){
			var atab="";
			if( "' . $v[0] . '"=="view" || "' . $v[0] . '"=="WapView" || "' . $v[0] . '"=="Public" ){
				if(v.tag=="文件未找到"){
					atab = "<td><input type=\"checkbox\" name=\"updatefile\" data-name=\""+v.file+"\" data-info=\"' . base64_encode($v[0]) . '\" id=\"checkbox-' . $v[0] . '\" checked=\"checked\" value=\""+v.basefile+"\" disabled=\"disabled\"></td>";
				}else{
					atab = "<td><input type=\"checkbox\" name=\"updatefile\" data-name=\""+v.file+"\" data-info=\"' . base64_encode($v[0]) . '\" id=\"checkbox-' . $v[0] . '\" value=\""+v.basefile+"\" checked=\"checked\"></td>";
				}
			}else{
				atab = "<td><input type=\"checkbox\" name=\"updatefile\" data-name=\""+v.file+"\" data-info=\"' . base64_encode($v[0]) . '\" id=\"checkbox-' . $v[0] . '\" checked=\"checked\" value=\""+v.basefile+"\"  disabled=\"disabled\"></td>";
			}
			tab' . $v[0] . ' += "<tr>"+atab+"<td>"+v.file+"</td><td style=\"width:150px;\">"+v.tag+"</td><td style=\"width:150px;\" class=\"updateres\">未更新</td></tr>";
		} )
		tab' . $v[0] . ' += "</table>";
		}else{
			tab' . $v[0] . '="已是最新";
		}
		$(".tab-' . $v[0] . '").html(tab' . $v[0] . ');
		';
		}
		
		$html = '
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>在线更新</title>
  <link rel="stylesheet" href="https://cache-code-ui.html5ui.org/jquery-ui-1.12.1.custom/jquery-ui.min.css">
<style>
  #custom-handle {
    width: 100px;
    height: 1.6em;
    top: 50%;
    margin-top: -.8em;
    text-align: center;
    line-height: 1.6em;
	background: #0181ef;
    color: #fff;
  }
  </style>
  <script src="https://cache-code-ui.html5ui.org/jQuery/jquery-1.9.1.min.js"></script>
  <script src="https://cache-code-ui.html5ui.org/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
  <script>
  var sliders;var handle;
  var _update_version=function(i){
	  $("#filename").html("版本信息");
	  var objects = $("form").find("[type=\'checkbox\']:checked:eq("+i+")");
	  var object={file:objects.val(),path:objects.data("info")};
	  $.ajax({
		type: "POST",
		url: "' . U("updatefile") . '",
		data: object,
		success: function(data){
			objects.closest("tr").find(".updateres").html(data.res);
			$("#filename").html("更新完成");
		},
		dataType: "json"
		});
  }
  var _update=function(i,versioni){
	  var size = $("form").find("[type=\'checkbox\']:checked").size();
	  sliders.slider( "value", i );
	  handle.text( i+"/"+size );
	  if( i>=size  ){
		  if( versioni!=-1 ){
			 _update_version(versioni);
		  }
		  return false;
		  }
	  var objects = $("form").find("[type=\'checkbox\']:checked:eq("+i+")");
	  
	  if( objects.val().indexOf("version.php")!=-1 ){
		  var ii=i+1;
		  _update(ii,i);
		  return false;
	  }
	  
	  var object={file:objects.val(),path:objects.data("info")};
	  $("#filename").html(objects.data("name") );
	  $.ajax({
		type: "POST",
		url: "' . U("updatefile") . '",
		data: object,
		success: function(data){
			objects.closest("tr").find(".updateres").html(data.res);
			setTimeout( function(){
				var ii=i+1;
				_update(ii,versioni);
				
			},500 )
		},
		dataType: "json"
		});
  }
  
  $( function() {
    $( "#tabs" ).tabs();
	
	$.ajax({
  type: "POST",
  url: "' . U("getfile") . '",
  data: {rand:' . time() . '},
  success: function(data){
	  
	  ' . $data . '
	  var size = $("form").find("[type=\'checkbox\']:checked").size();
	  if(size==0){
		  $(".button-update").prop("disabled",true);
		  $(".button-update").off("click");
		  $(".button-update").text("暂无更新");
	  }

	handle = $( "#custom-handle" );
    sliders=$( "#slider" ).slider({
	  min: 0,
      max: size,
      create: function() {
        handle.text( "0/"+size );
      },
      slide: function( event, ui ) {
        return false;
      },
	  value:0,
	  
    });	  
	  
  },
  dataType: "json"
});
	
$(".button-update").on( "click" , function(){
	
	_update(0,-1);
	
	
	
} )



	
	
  } );
  </script>
</head>
<body style="margin:20px auto 20px auto;width:90%;">
<a href="' . U('User/index') . '" class="ui-button ui-widget ui-corner-all" style="background: #0181ef;color: #fff;">
    <span class="ui-icon ui-icon-gear"></span> 返回管理中心
  </a>
 <button class="ui-button ui-widget ui-corner-all button-update" type="button">
    <span class="ui-icon ui-icon-gear"></span> 更新选择文件【除模版文件外其他文件为必选更新】
  </button>
  <div style="margin:20px auto 20px auto;width:100%;">更新进度：<span id="filename">未更新</span></div>
  <div id="slider">
  <div id="custom-handle" class="ui-slider-handle"></div>
</div>
 <form class="form-horizontal" name="form" action=""> 
<div id="tabs" style="margin-top:20px;">
  <ul>
    ' . $tab . '
  </ul>
  
  ' . $tabs . '
</div>
</form> 
 
</body>
</html>		
		';
		echo $html;
		
		
		
		
       }
	public function login(){
	
		$checkWebUser = checkWebUser();
		if( !$checkWebUser ){
			if( IS_POST ){
		$res=$this->ApiReturn(array("password"=>MD5(strtoupper(MD5($_POST["password"])).$_POST["username"]) ), "User" , "login" );
		session("USER_INFO",$res);
		session("USER_CHECK",time());
		$this->success("登录成功",U("index"));die;
	}
			echo '
			<form id="form" action="' . U("login") . '" method="post">
		<section>
    	<div class="main clear">
        	
            <div class="main_r">
                <p>请用网站接入帐号登录</p>
			   <div id="wechatlogin"></div>
                <input type="text" class="user" name="username" placeholder="请输入您的邮箱">
                <input type="password" class="password" name="password" placeholder="请输入您用户名的密码">
                
                <button type="submit">登录</button>
                <input type="hidden" name="bind" value="">
				
            </div>
        
        </div>
    </section>
</form>
			';
		die;
			
		}
		
		
	}
	public function getfile(){
		$this->login();
		$dir = $this->cacheupdate();
		
		if( $dir["code"]!=0 ){
			die($dir["message"]);
		}
		
		$update = unserialize( $dir["body"] );
		
		//BASE_PATH
		$outfile=array();
		foreach( $update["list"]["update"] as $k=>$v ){
			$file = $update["file"][$v[0]];
			foreach( $file as $key=>$value ){
				$f = BASE_PATH . DIRECTORY_SEPARATOR . $key;
				if( file_exists($f) ){
					$RESOURE = C("TMPL_PARSE_STRING.__RESOURE__");
					if( strstr( $key, "Home/Conf/config.php" ) && !empty( $RESOURE ) ){
						S(array('type'=>'File','prefix'=>'UpdateCache','expire'=>6000));
						S("TMPL_PARSE_STRING" , $RESOURE );
						
						}
					
					if( sha1_file($f)!=$value ){
						$outfile[$v[0]][]=array("file"=> $key , "basefile"=>base64_encode($key) ,"tag"=>"文件不一致","md5_1"=>sha1_file($f),"md5"=>$value);
					}
					
				}else{
					$outfile[$v[0]][]=array("file"=> $key , "basefile"=>base64_encode($key) ,"tag"=>"文件未找到");
				}
				
			}
			
		}
		
		$this->ajaxreturn($outfile);
	}
	function updatefile(){
		$this->login();
		S(array('type'=>'File','prefix'=>'UpdateCache','expire'=>6000));
		$RESOURE = S("TMPL_PARSE_STRING" );
		if( !empty( $RESOURE ) ){
			$TMPL_PARSE_STRING = C("TMPL_PARSE_STRING");
		$Arr = '<?php
		return array(
		"TMPL_PARSE_STRING"=>array(
		';
		foreach( $TMPL_PARSE_STRING as $key=>$val ){
		if( $key=="__RESOURE__" ){ $val=$RESOURE; }
			$Arr .= "'{$key}'=>'{$val}',";
		}
		$Arr .= '
		),
		);
		?>';
		file_put_contents( APP_PATH . "Home/Conf/config.php" , $Arr );
		S("TMPL_PARSE_STRING" , null );
						}
		
		$dir = $this->cacheupdate();
		$update = unserialize( $dir["body"] );
		$updateHost = "http://update.hlapi.com/new2017/";
		
		$v = base64_decode($_POST["file"]);
		
		
		
		$Path = base64_decode($_POST["path"]);
		$ext=$this->get_extension($v);
		$ext=strtolower($ext);
		if($ext=="php"){
			$res=$this->httpcopy($updateHost."files.php?file=" . $v,BASE_PATH . DIRECTORY_SEPARATOR . $v);
		}else{
			$res=$this->httpcopy($updateHost.$v,BASE_PATH . DIRECTORY_SEPARATOR . $v);
		}
		
		if( file_exists( BASE_PATH . DIRECTORY_SEPARATOR . $v ) ){
			if( sha1_file( BASE_PATH . DIRECTORY_SEPARATOR . $v )!= $update["file"][$Path][$v] ){
				$this->ajaxreturn( array( "res"=>"更新失败2") );
						
					}else{
						
						$this->ajaxreturn( array( "res"=>"更新成功") );
					}
		}else{
			$this->ajaxreturn( array( "res"=>"更新失败") );
		}
		
		
		
	}
function get_extension($file) 
{
$s=explode('.', $file);
return end($s); 
}	
	
function httpcopy($url, $file="", $timeout=60) {
  $file = empty($file) ? pathinfo($url,PATHINFO_BASENAME) : $file;
  $dir = pathinfo($file,PATHINFO_DIRNAME);
  !is_dir($dir) && @mkdir($dir,0755,true);
  $url = str_replace(" ","%20",$url);
  
  if(function_exists('curl_init')) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    $temp = curl_exec($ch);
    if(@file_put_contents($file, $temp) && !curl_error($ch)) {
      return $file;
    } else {
      return false;
    }
  } else {
    $opts = array(
      "http"=>array(
      "method"=>"GET",
      "header"=>"",
      "timeout"=>$timeout)
    );
    $context = stream_context_create($opts);
    if(@copy($url, $file, $context)) {
      
      return $file;
    } else {
      return false;
    }
  }
}	
	
	public function cacheupdate(){
		S(array('type'=>'File','prefix'=>'UpdateCache','expire'=>600));
		$version = C("version");
		$HomeConfigVersion = C("TMPL_PARSE_STRING.__HomeConfigVersion__");
		$theme = get_Theme();
		$cache = S("update2017");
		if( empty( $cache ) ){
			import("Org.API.curl");
			$updateHost = "http://update.hlapi.com/new2017/";
			$cache = \CURL::getpost($updateHost . "update.php?theme={$theme}&hv={$HomeConfigVersion}&r=" . time());
			if($cache["code"]==0){
				S("update2017" , $cache);
			}
			
		}
		return $cache;
		
	}
	

	
}