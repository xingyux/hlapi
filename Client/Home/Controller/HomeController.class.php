<?php
namespace Home\Controller;
use Think\Controller;
use Think;
class HomeController extends Controller{

	protected function _initialize(){
		if(!file_exists(CONF_PATH . "db.bak")){
			$this->redirect("Install/index");
		}

		/***自动清理缓存**/

        if( !file_exists( CONF_PATH . "LastCache.php" ) ){
            $LastCache=0;
        }else{
            $LastCache = include (CONF_PATH . "LastCache.php");

        }
        if( time()-$LastCache>86400 ){
        delDirAndFile(APP_PATH . "Runtime/");
        delDirAndFile(APP_PATH . "Common/Conf/session/");

            file_put_contents( CONF_PATH . "LastCache.php" , '<?php
    return \'' . time() . '\';
    ?>
    ' );

        }
		/*****************/
		$config=getConfig();
		$this->assign('sitename',$config["webname"]);
		$this->assign('islogin',is_login());
		$this->assign('userinfo',session('USER_INFO'));
		set_theme();
	}

function API($parms=array(),$CONTROLLER_NAME=CONTROLLER_NAME,$ACTION_NAME=ACTION_NAME){
	$CONTROLLER_NAME = empty($CONTROLLER_NAME) ? CONTROLLER_NAME  : $CONTROLLER_NAME;
	$ACTION_NAME = empty($ACTION_NAME) ? ACTION_NAME  : $ACTION_NAME;
	$res=API($parms,$CONTROLLER_NAME,$ACTION_NAME);
	$rescode = $res["code"];
	
	if($res["code"]!=0){
		if(IS_AJAX){
			$this->ajaxreturn($res);die;
		}else{
			
			if($res["code"]=="9999189"){
				session("USER_INFO",null);session("USER_CHECK",null);
				$this->error($res["message"],U("User/login"));die;
			}
			
			$this->error($res["message"]);die;
		}
	}

	if( $res["GPC"]["json"]==1 ){
		$this->ajaxreturn($res);die;
	}

	return $res;
}	
function ApiReturn($parms=array(),$CONTROLLER_NAME=CONTROLLER_NAME,$ACTION_NAME=ACTION_NAME){
$CONTROLLER_NAME = empty($CONTROLLER_NAME) ? CONTROLLER_NAME  : $CONTROLLER_NAME;
$ACTION_NAME = empty($ACTION_NAME) ? ACTION_NAME  : $ACTION_NAME;		
$res=$this->API($parms,$CONTROLLER_NAME,$ACTION_NAME);
return $res;
}
function message($code,$str){
$this->assign('code',$code);
$this->assign('message',$str);
$this->display("Common/message");
die;
}	
function CheckMoney($C_Money)    
{    
if (!ereg("^[0-9][.][0-9]$", $C_Money)) {
$this->error("请输入正确的金额");die;
}  
return true;    
}    
//-----------------------------------------------------------------------------------    
// 函数名：CheckEmailAddr($C_mailaddr)    
// 作 用：判断是否为有效邮件地址    
// 参 数：$C_mailaddr（待检测的邮件地址）    
// 返回值：布尔值    
// 备 注：无    
//-----------------------------------------------------------------------------------    
function CheckEmailAddr($C_mailaddr)    
{    
if (!eregi("^[_a-z0-9-]+(.[_a-z0-9-]+)*@[a-z0-9-]+(.[a-z0-9-]+)*$",    $C_mailaddr))    
//(!ereg("^[_a-zA-Z0-9-]+(.[_a-zA-Z0-9-]+)*@[_a-zA-Z0-9-]+(.[_a-zA-Z0-9-]+)*$",    $c_mailaddr))    
{    
$this->error("请输入正确的邮箱");die;
}    
return true;    
}    
//-----------------------------------------------------------------------------------    
// 函数名：CheckWebAddr($C_weburl)    
// 作 用：判断是否为有效网址    
// 参 数：$C_weburl（待检测的网址）    
// 返回值：布尔值    
// 备 注：无    
//-----------------------------------------------------------------------------------    
function CheckWebAddr($C_weburl)    
{    
if (!ereg("^http://[_a-zA-Z0-9-]+(.[_a-zA-Z0-9-]+)*$", $C_weburl))    
{    
$this->error("请输入正确的网址");die;
}    
return true;    
}    
//-----------------------------------------------------------------------------------    
// 函数名：CheckLengthBetween($C_char, $I_len1, $I_len2=100)    
// 作 用：判断是否为指定长度内字符串    
// 参 数：$C_char（待检测的字符串）    
// $I_len1 （目标字符串长度的下限）    
// $I_len2 （目标字符串长度的上限）    
// 返回值：布尔值    
// 备 注：无    
//-----------------------------------------------------------------------------------    
function CheckLengthBetween($C_cahr, $I_len1, $I_len2=100)    
{    
$C_cahr = trim($C_cahr);    
if (strlen($C_cahr) < $I_len1) return false;    
if (strlen($C_cahr) > $I_len2) return false;    
return true;    
}    
// 函数名：CheckPassword($C_passwd)    
// 作 用：判断是否为合法用户密码    
// 参 数：$C_passwd（待检测的密码）    
// 返回值：布尔值    
// 备 注：无    
//-----------------------------------------------------------------------------------    
function CheckPassword($C_passwd,$C_repassword=null,$C_check=false)    
{    
if (!$this->CheckLengthBetween($C_passwd, 4, 20))  {$this->error("请输入正确的密码");die;}
if (!ereg("^[_a-zA-Z0-9]*$", $C_passwd)) {$this->error("请输入正确的密码");die;}   
if($C_check&&$C_repassword!=$C_passwd){
$this->error("请输入正确的重复密码");die;
}
return true;    
}
//-----------------------------------------------------------------------------------    
// 函数名：CheckTelephone($C_telephone)    
// 作 用：判断是否为合法电话号码    
// 参 数：$C_telephone（待检测的电话号码）    
// 返回值：布尔值    
// 备 注：无    
//-----------------------------------------------------------------------------------    
function CheckTelephone($C_telephone)    
{    
if (!ereg("^[+]?[0-9]+([xX-][0-9]+)*$", $C_telephone)) {$this->error("请输入正确的电话号码");die;}
return true;    
}    
//-----------------------------------------------------------------------------------    
// 函数名：CheckValueBetween($N_var, $N_val1, $N_val2)    
// 作 用：判断是否是某一范围内的合法值    
// 参 数：$N_var 待检测的值    
// $N_var1 待检测值的上限    
// $N_var2 待检测值的下限    
// 返回值：布尔值    
// 备 注：无    
//-----------------------------------------------------------------------------------    
function CheckValueBetween($N_var, $N_val1, $N_val2)    
{    
if ($N_var < $N_var1||$N_var > $N_var2)    
{    
$this->error("请输入正确的数值");die;
}    
return true;    
}    
// 函数名：CheckPost($C_post)    
// 作 用：判断是否为合法邮编（固定长度）    
// 参 数：$C_post（待check的邮政编码）    
// 返回值：布尔值    
// 备 注：无    
//-----------------------------------------------------------------------------------    
function CheckPost($C_post)    
{    
$C_post=trim($C_post);    
if (strlen($C_post) == 6)    
{    
if(!ereg("^[+]?[_0-9]*$",$C_post))    
{    
return true;
}else    
{    
$this->error("请输入正确的邮编");die;
}    
}else    
{    
$this->error("请输入正确的邮编");die;  
}    
}    
//-----------------------------------------------------------------------------------    
// 函数名：ReplaceSpacialChar($C_char)    
// 作 用：特殊字符替换函数    
// 参 数：$C_char（待替换的字符串）    
// 返回值：字符串    
// 备 注：这个函数有问题，需要测试才能使用
//-----------------------------------------------------------------------------------    
function ReplaceSpecialChar($C_char)    
{    
$C_char=HTMLSpecialChars($C_char); //将特殊字元转成 HTML 格式。    
$C_char=nl2br($C_char); //将回车替换为    
$C_char=str_replace(" "," ",$C_char); //替换空格为    
return $C_char;    
}    
function checkMoblie($moblie=null){
$pattern = "/^1[34578]{1}\d{9}$/";
if ( !preg_match( $pattern, $moblie ) ){
$this->error("请输入正确的手机号码");die;
}
	}	
	
}