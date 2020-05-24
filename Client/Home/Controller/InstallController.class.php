<?php
namespace Home\Controller;
use Think\Controller;
class InstallController extends Controller {
	protected function _initialize(){

		set_theme();

	}
    public function index(){
		$action=I("action");
		if(file_exists(CONF_PATH . "db.bak")){
			print_r("请先删除".CONF_PATH . "db.bak");die;
		}
		if($action=="apisetting"){
			
			$data=$_POST;
			
			unset($data["action"]);

			$res=M("Config")->where(array("id"=>1))->save($data);

			if($res===false){
				
				$this->error("配置失败");die;
			}
			S(array('type'=>'File','prefix'=>'WEBCONFIG','expire'=>999999));
			S("config",$data);

		$this->redirect("update");die;

		/*	
		if(file_put_contents(CONF_PATH . "/db.bak", "1")){
			
			
			
            $this->redirect("update");
        } else {
            $this->error('修改失败，请修改'.CONF_PATH.'db.bak文件权限');
        }			
			*/
			
		}
		if($action=="connnet"){
			$myhost=I("post.myhost");
			$myport=I("post.myport");
			$mydbname=I("post.mydbname");
			$myuser=I("post.myuser");
			$mypass=I("post.mypass");
			$myprefix=I("post.myprefix");
			$deltable=I("post.deltable");
			$isdrop = empty($deltable) ? false : true;
	
			
			if(substr($myprefix,-1)!="_"){$myprefix .="_";}

			$conn=mysql_connect("{$myhost}:{$myport}",$myuser,$mypass) or $this->error("数据库连接失败");
			$res=mysql_select_db($mydbname,$conn);
if(empty($res)){
	$res=mysql_query("CREATE DATABASE {$mydbname}",$conn);
		if(!$res){
			$this->error('数据库安装失败');
		}else{
			$res=mysql_select_db($mydbname,$conn);	
		}	
}

	$sql = "
	DROP TABLE IF EXISTS `{$myprefix}news`;
	";
if($isdrop)	mysql_query($sql) or die(mysql_error());

	$sql = "
CREATE TABLE `{$myprefix}news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `updateid` int(11) DEFAULT '0',
  `title` varchar(255) DEFAULT NULL,
  `content` text,
  `tim` int(11) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
	";
	mysql_query($sql) or $this->showsqlerror(mysql_error() );	

	$sql = "
	DROP TABLE IF EXISTS `{$myprefix}config`;
	";
	mysql_query($sql) or $this->error(mysql_error());

$sql = "
CREATE TABLE `{$myprefix}config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `acname` varchar(255) DEFAULT NULL,
  `ackey` varchar(255) DEFAULT NULL,
  `apiurl` varchar(255) DEFAULT NULL,
  `webname` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
";
mysql_query($sql) or $this->error("0001".mysql_error());



$sql = "
DELETE FROM `{$myprefix}config`;
";
mysql_query($sql,$conn) or die("0002".mysql_error());
$sql = "
INSERT INTO `{$myprefix}config` VALUES (1,null, null, null,null);
";	
mysql_query($sql,$conn) or die("0003".mysql_error());

	$sql = "
	DROP TABLE IF EXISTS `{$myprefix}product`;
	";
if($isdrop)		mysql_query($sql) or $this->error("0004".mysql_error());

$sql = "
CREATE TABLE `{$myprefix}product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `pid` varchar(255) DEFAULT NULL,
  `dayprice` decimal(10,2) DEFAULT NULL,
  `weekprice` decimal(10,2) DEFAULT NULL,
  `monthprice` decimal(10,2) DEFAULT NULL,
  `quarterprice` decimal(10,2) DEFAULT NULL,
  `halfprice` decimal(10,2) DEFAULT NULL,
  `yearprice` decimal(10,2) DEFAULT NULL,
  `twoyearprice` decimal(10,2) DEFAULT NULL,
  `threeyearprice` decimal(10,2) DEFAULT NULL,
  `fouryearprice` decimal(10,2) DEFAULT NULL,
  `fiveyearprice` decimal(10,2) DEFAULT NULL,
  `dayrate` decimal(20,10) DEFAULT NULL,
  `weekrate` decimal(20,10) DEFAULT NULL,
  `monthrate` decimal(20,10) DEFAULT NULL,
  `quarterrate` decimal(20,10) DEFAULT NULL,
  `halfrate` decimal(20,10) DEFAULT NULL,
  `yearrate` decimal(20,10) DEFAULT NULL,
  `twoyearrate` decimal(20,10) DEFAULT NULL,
  `threeyearrate` decimal(20,10) DEFAULT NULL,
  `fouryearrate` decimal(20,10) DEFAULT NULL,
  `fiveyearrate` decimal(20,10) DEFAULT NULL,
  `cpu` text,
  `ram` text,
  `hd` int(11) DEFAULT NULL,
  `hdinfo` varchar(255) DEFAULT NULL,
  `bd` int(11) DEFAULT NULL,
  `bdinfo` varchar(255) DEFAULT NULL,
  `ipinfo` varchar(255) DEFAULT NULL,
  `firewall` int(11) DEFAULT NULL,
  `system` text,
  `address` text,
  `infos` text,
  `state` tinyint(4) DEFAULT NULL,
  `flag` varchar(255) DEFAULT NULL,
  `agent` varchar(255) DEFAULT NULL,
  `ord` int(11) DEFAULT NULL,
  `dayrenewprice` decimal(10,2) DEFAULT NULL,
  `weekrenewprice` decimal(10,2) DEFAULT NULL,
  `monthrenewprice` decimal(10,2) DEFAULT NULL,
  `quarterrenewprice` decimal(10,2) DEFAULT NULL,
  `halfrenewprice` decimal(10,2) DEFAULT NULL,
  `yearrenewprice` decimal(10,2) DEFAULT NULL,
  `twoyearrenewprice` decimal(10,2) DEFAULT NULL,
  `threeyearrenewprice` decimal(10,2) DEFAULT NULL,
  `fouryearrenewprice` decimal(10,2) DEFAULT NULL,
  `fiveyearrenewprice` decimal(10,2) DEFAULT NULL,
  `flow` int(11) DEFAULT NULL,
  `hostsize` int(11) DEFAULT NULL,
  `mysqlsize` int(11) DEFAULT NULL,
  `mssqlsize` int(11) DEFAULT NULL,
  `paymode` varchar(255) DEFAULT NULL,
  `ischeckos` tinyint(11) DEFAULT '0',
  `isdiscount` tinyint(11) DEFAULT '0',
  `ispricecheck` tinyint(4) DEFAULT '0',
  `isrenewdiscount` tinyint(4) DEFAULT '0',
  
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2679 DEFAULT CHARSET=utf8;
";
mysql_query($sql) or $this->showsqlerror("0005".mysql_error());

	$sql = "
	DROP TABLE IF EXISTS `{$myprefix}dictionary`;
	";
if($isdrop)		mysql_query($sql) or $this->error("0006".mysql_error());

$sql = "
CREATE TABLE `{$myprefix}dictionary` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  `ord` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=51 DEFAULT CHARSET=utf8;
";
mysql_query($sql) or $this->showsqlerror("0007".mysql_error());	



	$sql = "
	DROP TABLE IF EXISTS `{$myprefix}servers`;
	";
if($isdrop)		mysql_query($sql) or $this->error("0008".mysql_error());

$sql = "
CREATE TABLE `{$myprefix}servers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `flag` varchar(255) DEFAULT NULL,
  `ord` int(11) DEFAULT NULL,
  `servertype` varchar(255) DEFAULT NULL,
  `producttype` varchar(255) DEFAULT NULL,
  `state` tinyint(4) DEFAULT '0',
  `infos` varchar(255) DEFAULT NULL,
  `apihost` varchar(255) DEFAULT NULL,
  `apicheck` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1032 DEFAULT CHARSET=utf8;
";
mysql_query($sql) or $this->showsqlerror("0009".mysql_error());	

	
	
		$Config=array(
    //数据库配置信息
    'DB_TYPE'   => 'mysql', // 数据库类型
    'DB_HOST'   => $myhost, // 服务器地址
    'DB_NAME'   => $mydbname, // 数据库名
    'DB_USER'   => $myuser, // 用户名
    'DB_PWD'    => $mypass, // 密码
    'DB_PORT'   => $myport, // 端口
    'DB_PREFIX' => $myprefix, // 数据库表前缀
    'DB_CHARSET'=> 'utf8', // 字符集
    'DB_DEBUG'  =>  FALSE, // 数据库调试模式 开启后可以记录SQL日志 3.2.3新增  		
		
		);
		
		if(file_put_contents(CONF_PATH . "/db_config.php", "<?php\r\nreturn " . var_export($Config, true) . ";")){
            $this->redirect("index",array("action"=>"setting"));
        } else {
            $this->error('修改失败，请修改'.CONF_PATH.'db_config.php文件权限');
        }
		
		die;
		}
		

		if(empty($action)){
			$this->display("index");
		}else{
			$this->display($action);
		}
          
       }
	public function comm(){
		
		if(file_put_contents(CONF_PATH . "/db.bak", "1")){
			
			
			
            $this->redirect("User/index");
        } else {
            $this->error('修改失败，请修改'.CONF_PATH.'db.bak文件权限');
        }			
		
	}
	public function update(){
		$ses = session('USER_INFO');
		$conf = getConfig();
		if(empty($ses)){
			$chekced=false;
		}else{
			$chekced=($conf["acname"]==$ses["username"]) ? true : false;
		}
		
	
		if($chekced===false){
		if(file_exists(CONF_PATH . "db.bak")){
			
			print_r("请先删除".CONF_PATH . "db.bak或者权限不足");die;
		}	
	}
		$res=API();
		if(!empty($_POST["submit"])){
			if($res["code"]!=0){
				$this->ajaxreturn($res);die;
			}			
		}
		if(I("post.submit")=="server"){
			delDirAndFile(APP_PATH . "Runtime/");
			$re=getConfig();			
			
			$valuecache=$res["product"];
			$flags=array();
			foreach($valuecache as $k=>$v){
				$flags[]=$k;
				$find=M("servers")->where(array("flag"=>$k))->find();
			
				if($find){
					$ress=M("servers")->where(array("id"=>$find["id"]))->save($v);
				}else{
					$ress=M("servers")->add($v);
				}
				if($ress===false){
					$this->ajaxreturn(array("code"=>1,"message"=>$v['name']."更新失败"));die;
				}
			}
				
			
			$this->ajaxreturn($res);die;
			
		}

		if(I("post.submit")=="dictionary"){
			
			
			$valuecache=$res["dictionary"];
			$flags=array();
			
			
			foreach($valuecache as $k=>$v){
				$flags[]=$v["id"];
				$find=M("Dictionary")->where(array("id"=>$v["id"]))->find();
			if($find){
					M("Dictionary")->where(array("id"=>$v["id"]))->save($v);
				}else{
					M("Dictionary")->add($v);
				}
			}			
			
	
			M("Dictionary")->where(array("id"=>array("NOT IN",$flags)))->delete();			
			
			$this->ajaxreturn($res);die;
			
		}


		if(I("post.submit")=="product"){
			delDirAndFile(APP_PATH . "Runtime/");
			$re=getConfig();				
			
			$valuecache=$res["dictionary"];
			$flags=array();
			
		
			foreach($valuecache as $k=>$v){
				if(empty($agent)) $agent=$v["agent"];
				$flags[]=$v["id"];
				$find=M("product")->where(array("id"=>$v["id"]))->find();
				if($find){
					$data=$v;
					
					$ress=M("product")->where(array("id"=>$find["id"]))->save($data);
				}else{
					$ress=M("product")->add($v);
				}
				if($ress!==false){
				}else{
					die(M()->getlastsql());
				}
			}			
			
	
			M("product")->where(array("agent"=>$agent,"id"=>array("NOT IN",$flags)))->delete();			
			
			$this->ajaxreturn($res);die;
			
		}
		//
		if(I("post.submit")=="clear"){
			
			
			delDirAndFile(APP_PATH . "Runtime/");
			$re=getConfig();
			$this->ajaxreturn(array("code"=>0));die;
			
		}		
		if($res["code"]!=0){
			print_r("<h1>获取数据失败，请刷新重试</h1>");
			print_r($res);
			die;
		}
		

		$this->assign('res',$res);	
		$this->display();
		
		
		
	}
	
	/**
 * 删除目录及目录下所有文件或删除指定文件
 * @param str $path   待删除目录路径
 * @param int $delDir 是否删除目录，1或true删除目录，0或false则只删除文件保留目录（包含子目录）
 * @return bool 返回删除状态
 */

function showsqlerror($err){
	if(strstr($err,"exists")){
		
	}else{
		echo $err ;die;
	}
}
	
	
}