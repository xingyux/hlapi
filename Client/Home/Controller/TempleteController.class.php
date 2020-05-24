<?php
namespace Home\Controller;

use Think\Controller;

class TempleteController extends LoginController
{


    public function index()
    {
        S(array('type' => 'File', 'prefix' => 'UpdateCache', 'expire' => 600));
        S("templete", null);
        $res = $this->ApiReturn();

        if (IS_AJAX) {
            $this->ajaxreturn($res);
            die;
        }
        $theme = get_Theme();
        $online = array();
        $offline = array();
        $backup = array();
        foreach ($res["templetelist"] as $key => &$v) {
            if ($theme == $v["path"]) {
                $v["install"] = "use";
                $offline[] = $v;
            } elseif (file_exists(MODULE_PATH . "View/{$v["path"]}/info.xml")) {
                $v["install"] = "download";
                $offline[] = $v;
            } else {
                $v["install"] = "online";
                $online[] = $v;
            }
        }

        $backupTempleteList = $this->calldir(APP_PATH . "backup");

        foreach ($backupTempleteList as $items) {
            $dirList = $this->calldir($items["path"]);

            foreach ($dirList as $item) {

                $xml = $item["path"] . "/View/info.xml";
                $info = array();
                if (file_exists($xml)) {
                    $info = simplexml_load_file($xml, 'SimpleXMLElement', LIBXML_NOCDATA);


                    $info = json_decode(json_encode($info), true);


                } else {
                    $info["name"] = $items["name"];
                    $info["author"] = "未知";
                    $info["lastdate"] = "未知";
                    $info["install"] = "backup";
                }
                $info["path"] = $items["name"];

                $info["backpath"] = $item["name"];
                $info["time"] = date("Y-m-d H:i:s", $item["name"]);

                $backup[] = $info;
            }
        }
        $res["templeteInfo"] = array(
            "offline" => $offline,
            "backup" => $backup,
            "online" => $online,
        );

        $this->assign('res', $res);
        $this->display();

    }

    public function calldir($path)
    {
        $dp = dir($path);
        $List = array();
        while ($file = $dp->read()) {
            if ($file != '.' && $file != '..') {
                $List[] = array("name" => $file, "path" => "{$path}/$file/");
            }
        }
        $dp->close();
        return $List;
    }

    public function update()
    {
        $checkWebUser = checkWebUser();
        if (!$checkWebUser) {
            die("非接入帐号没有权限更新");
        }
        S(array('type' => 'File', 'prefix' => 'UpdateCache', 'expire' => 600));
        S("templete", null);
        $dir = $this->cacheupdate(I("get.id"));

        if ($dir["code"] != 0) {
            die($dir["message"]);
        }

        $update = unserialize($dir["body"]);

        foreach ($update["list"]["dir"] as $k => $v) {
            if (!is_dir($v)) {
                mkdir($v, 0755);

            }
        }
		

		
		
		
        $tab = '';
        $tabs = '';
        $data = "";
        foreach ($update["list"]["update"] as $k => $v) {
            $tab .= '<li><a href="#tabs-' . ($k + 2) . '">' . $v[2] . '</a></li>';
            $tabs .= '<div id="tabs-' . ($k + 2) . '" class="tab-' . $v[0] . '">';
			$tabs .='<table style="width:100%;">';
			$file = $update["file"][$v[0]];
			
			foreach ($file as $key => $value) {
                $f = BASE_PATH . DIRECTORY_SEPARATOR . $key;
                if (file_exists($f)) {


                } else {
                   $tabs .= '<tr><td>
					<input type="checkbox" name="updatefile" data-name="' . $key . '" data-info="' . base64_encode($v[0]) . '" id="checkbox-' . $v[0] . '" checked="checked" value="' . base64_encode($key) . '"></td>
					<td>' . $key . '</td><td style="width:150px;" class="updateres">未安装</td></tr>
					';
				}
				
            }
			
			$tabs .='</table>';
			$tabs .='</div>';
            
        }

        $html = '
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>在线安装</title>
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
			var _getonefile=function(i,count){
			if( i<count ){
				
			}
			}
  $( function() {
    $( "#tabs" ).tabs();
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

$(".button-update").on( "click" , function(){

	_update(0,-1);



} )





  } );
  </script>
</head>
<body style="margin:20px auto 20px auto;width:90%;">
<a href="' . U('Templete/index') . '" class="ui-button ui-widget ui-corner-all" style="background: #0181ef;color: #fff;">
    <span class="ui-icon ui-icon-gear"></span> 返回模版中心
  </a>
 <button class="ui-button ui-widget ui-corner-all button-update" type="button">
    <span class="ui-icon ui-icon-gear"></span> 安装模版
  </button>
  <div style="margin:20px auto 20px auto;width:100%;">安装进度：<span id="filename">未安装</span></div>
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
	public function getonefile(){
		$id=I("get.i");
		
	}
    public function getfile()
    {
		set_time_limit(0);
        $dir = $this->cacheupdate();

        if ($dir["code"] != 0) {
            die($dir["message"]);
        }
		
        $update = unserialize($dir["body"]);
		//$encode = mb_detect_encoding($dir["body"], array('ASCII','GB2312','GBK','UTF-8')); 
		
        //BASE_PATH
        
		
		
        $this->ajaxreturn( array( "count"=>$i ) );
    }

    function get_extension($file)
    {
        $s = explode('.', $file);
        return end($s);
    }

    function httpcopy($url, $file = "", $timeout = 60)
    {
        $file = empty($file) ? pathinfo($url, PATHINFO_BASENAME) : $file;
        $dir = pathinfo($file, PATHINFO_DIRNAME);
        !is_dir($dir) && @mkdir($dir, 0755, true);
        $url = str_replace(" ", "%20", $url);

        if (function_exists('curl_init')) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            $temp = curl_exec($ch);
            if (@file_put_contents($file, $temp) && !curl_error($ch)) {
                return $file;
            } else {
                return false;
            }
        } else {
            $opts = array(
                "http" => array(
                    "method" => "GET",
                    "header" => "",
                    "timeout" => $timeout)
            );
            $context = stream_context_create($opts);
            if (@copy($url, $file, $context)) {

                return $file;
            } else {
                return false;
            }
        }
    }

    function updatefile()
    {
        $dir = $this->cacheupdate();
        $update = unserialize($dir["body"]);
        $updateHost = "http://update.hlapi.com/templete/";

        $v = base64_decode($_POST["file"]);


        $Path = base64_decode($_POST["path"]);
        $ext = $this->get_extension($v);
        $ext = strtolower($ext);
        if ($ext == "php") {
            $res = $this->httpcopy($updateHost . "files.php?file=" . $v, BASE_PATH . DIRECTORY_SEPARATOR . $v);
        } else {
            $res = $this->httpcopy($updateHost . $v, BASE_PATH . DIRECTORY_SEPARATOR . $v);
        }

        if (file_exists(BASE_PATH . DIRECTORY_SEPARATOR . $v)) {
            if (sha1_file(BASE_PATH . DIRECTORY_SEPARATOR . $v) != $update["file"][$Path][$v]) {
                $this->ajaxreturn(array("res" => "更新失败2"));

            } else {
                $this->ajaxreturn(array("res" => "安装成功"));
            }
        } else {
            $this->ajaxreturn(array("res" => "安装失败"));
        }


    }

    public function cacheupdate($path)
    {
        S(array('type' => 'File', 'prefix' => 'UpdateCache', 'expire' => 600));
        $cache = S("templete");
        if (empty($cache)) {
            import("Org.API.curl");
            $updateHost = "http://update.hlapi.com/templete/";
            $cache = \CURL::getpost($updateHost . "update.php?id={$path}&r=" . time());
            if ($cache["code"] == 0) {
                S("templete", $cache);
            }

        }
        return $cache;

    }

    public function retheme()
    {
        $theme = I("get.id");
        $dobackuppath = I("get.idd");
        $do = I("get.do");
        $repath = APP_PATH . "backup/{$theme}/{$dobackuppath}";
        if (!file_exists("{$repath}/View/info.xml")) {
            $this->ajaxReturn(array("code" => 1, "message" => '备份模版文件不存在'));
            die;
        }
        $message = "还原成功";
        if ($do == "bc" && file_exists(MODULE_PATH . "View/{$theme}/info.xml")) {
            $backuppath = APP_PATH . "backup/{$theme}/" . time();
            if (!is_dir($backuppath)) {
                @mkdir($backuppath, 0755, true);
            }
            $res = rename(MODULE_PATH . "View/{$theme}/", $backuppath . "/View/");
            $res2 = rename(BASE_PATH . "/Public/{$theme}/", $backuppath . "/Public/");
            if ($res !== false) {
                $message = "备份并还原成功，\n备份目录：{$backuppath}";
            } else {
                $this->ajaxReturn(array("code" => 1, "message" => '备份原模版并删除失败'));
                die;
            }
        } elseif ($do == "de" && file_exists(MODULE_PATH . "View/{$theme}/info.xml")) {
            $res = delDirAndFile(MODULE_PATH . "View/{$theme}/", true);
            $res2 = delDirAndFile(BASE_PATH . "/Public/{$theme}/", true);
            if ($res !== false) {

            } else {
                $this->ajaxReturn(array("code" => 1, "message" => '删除失败当前模版失败'));
                die;
            }
        }

        $this->recurse_copy($repath . "/View/", MODULE_PATH . "View/{$theme}/");
        $this->recurse_copy($repath . "/Public/", BASE_PATH . "/Public/{$theme}/");
        $this->ajaxReturn(array("code" => 0, "message" => $message));
        die;
    }

    function recurse_copy($src, $dst)
    {
        $dir = opendir($src);
        @mkdir($dst);
        while (false !== ($file = readdir($dir))) {
            if (($file != '.') && ($file != '..')) {
                if (is_dir($src . '/' . $file)) {
                    $this->recurse_copy($src . '/' . $file, $dst . '/' . $file);
                } else {
                    copy($src . '/' . $file, $dst . '/' . $file);
                }
            }
        }
        closedir($dir);
    }

    public function del()
    {
        $theme = I("get.id");
        if (!file_exists(MODULE_PATH . "View/{$theme}/info.xml")) {
            $this->ajaxReturn(array("code" => 1, "message" => '模版文件不存在'));
            die;
        }
        $res = delDirAndFile(MODULE_PATH . "View/{$theme}/", true);
        $res2 = delDirAndFile(BASE_PATH . "/Public/{$theme}/", true);
        if ($res !== false) {
            $this->ajaxReturn(array("code" => 0, "message" => "删除成功"));
            die;
        } else {
            $this->ajaxReturn(array("code" => 1, "message" => '删除失败'));
            die;
        }
    }

    public function backup()
    {
        $theme = I("get.id");
        if (!file_exists(MODULE_PATH . "View/{$theme}/info.xml")) {
            $this->ajaxReturn(array("code" => 1, "message" => '模版文件不存在'));
            die;
        }
        $backuppath = APP_PATH . "backup/{$theme}/" . time();
        if (!is_dir($backuppath)) {
            @mkdir($backuppath, 0755, true);
        }
        $res = rename(MODULE_PATH . "View/{$theme}/", $backuppath . "/View/");
        $res2 = rename(BASE_PATH . "/Public/{$theme}/", $backuppath . "/Public/");
        if ($res !== false) {
            $this->ajaxReturn(array("code" => 0, "message" => "备份并删除成功，\n备份目录：{$backuppath}"));
            die;
        } else {
            $this->ajaxReturn(array("code" => 1, "message" => '备份并删除失败'));
            die;
        }
    }

    public function usetemplete()
    {
        $theme = I("get.id");
        if (!file_exists(MODULE_PATH . "View/{$theme}/info.xml")) {
            $this->error('模版文件不存在');
            die;
        }
        if (file_put_contents(CONF_PATH . "/tmplete_config.php", '<?php
		return array(
		\'tmplete_path\'=>\'' . $theme . '\'
		);
		?>')) {
            $this->success('保存成功');
        } else {
            $this->error('修改失败，请修改' . CONF_PATH . 'tmplete_config.php文件权限');
        }
    }
}