<?php


//登录判断
function is_login()
{

    if (session('USER_INFO')) {
        return true;
    } else {
        return false;
    }
}

function getConfig()
{
    S(array('type' => 'File', 'prefix' => 'WEBCONFIG', 'expire' => 999999));
    $config = S("config");
    if (!is_array($config) || empty($config)) {

        $config = M("Config")->find();
        if (!$config) {
            die("获取配置文件出错");
        }
        S("config", $config);
    }
    return $config;
}

function getClientIP()
{
    global $ip;
    if (getenv("HTTP_CLIENT_IP"))
        $ip = getenv("HTTP_CLIENT_IP");
    else if (getenv("HTTP_X_FORWARDED_FOR"))
        $ip = getenv("HTTP_X_FORWARDED_FOR");
    else if (getenv("REMOTE_ADDR"))
        $ip = getenv("REMOTE_ADDR");
    else $ip = "Unknow";
    return $ip;
}

function API($parms = array(), $CONTROLLER_NAME = CONTROLLER_NAME, $ACTION_NAME = ACTION_NAME)
{
    $CONTROLLER_NAME = empty($CONTROLLER_NAME) ? CONTROLLER_NAME : $CONTROLLER_NAME;
    $ACTION_NAME = empty($ACTION_NAME) ? ACTION_NAME : $ACTION_NAME;

    $CONTROLLER_NAME = MODULE_NAME . "/" . $CONTROLLER_NAME;

    $apiconfig = getConfig();

    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $client_url = "$protocol$_SERVER[HTTP_HOST]";


    $POST = array_merge($_POST, array("VERSION" => C("version"), "HTTP_HOST" => $client_url, "acname" => $apiconfig["acname"], "ackey" => $apiconfig["ackey"], "user_client_ip" => getClientIP()));
    foreach ($parms as $k => &$values) {
        if (is_array($values)) $values = serialize($values);
    }
    foreach ($POST as $k => &$values) {
        if (is_array($values)) $values = serialize($values);
    }
    if (is_array($parms)) {
        $POST = array_merge($POST, $parms);
    }


    if (session('USER_INFO')) {

        $POST = array_merge($POST, array("USER_INFO" => json_encode(session('USER_INFO'))));
    }


    $url = $apiconfig["apiurl"] . U($CONTROLLER_NAME . "/" . $ACTION_NAME, $_GET);

    import("Org.API.curl");
    $res = \CURL::getpost($url, $POST);

    if ($res["code"] != 0) {
        return $res;
    }

    $returns = json_decode($res["body"], true);
    if (empty($returns)) {
        print_r(array("code" => 1, "message" => "数据解析失败||" . var_export($res["body"], true)));
        die;
    }


    return $returns;

}

function is_wx()
{
    $useragent = $_SERVER['HTTP_USER_AGENT'];
    $isMicroMessenger = null;
    if (strstr($useragent, "MicroMessenger")) {
        $MicroMessenger = explode('MicroMessenger/', $useragent);

        $MicroMessengerV = explode(".", $MicroMessenger[1]);
        $isMicroMessenger = $MicroMessengerV[0];

    }
    return $isMicroMessenger;
}

function is_mobile()
{
    $regex_match = "/(nokia|iphone|android|motorola|^mot\-|softbank|foma|docomo|kddi|up\.browser|up\.link|";

    $regex_match .= "htc|dopod|blazer|netfront|helio|hosin|huawei|novarra|CoolPad|webos|techfaith|palmsource|";

    $regex_match .= "blackberry|alcatel|amoi|ktouch|nexian|samsung|^sam\-|s[cg]h|^lge|ericsson|philips|sagem|wellcom|bunjalloo|maui|";

    $regex_match .= "symbian|smartphone|midp|wap|phone|windows ce|iemobile|^spice|^bird|^zte\-|longcos|pantech|gionee|^sie\-|portalmmm|";

    $regex_match .= "jig\s browser|hiptop|^ucweb|^benq|haier|^lct|opera\s*mobi|opera\*mini|320x320|240x320|176x220";

    $regex_match .= ")/i";
    return isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE']) or preg_match($regex_match, strtolower($_SERVER['HTTP_USER_AGENT']));
}

//字典缓存
function ReadDictionaryCache($name, $return)
{
    S(array('type' => 'File', 'prefix' => 'Dictionary', 'expire' => 65535));
    $valuecache = S("dictionary" . $name);
    if (!is_array($valuecache)) {
        $valuecache = M("Dictionary")->where(array("type" => $name))->order("ord asc,id asc")->select();
        if (is_array($valuecache)) {
            $valuecache = array_column($valuecache, "value");
            S("Dictionary" . $name, $valuecache);
        }
    }
    return $valuecache;
}

//产品类型缓存读取
function ReadConfigCache($return, $configtype)
{

    $value = C($configtype);

    return empty($value[$return]) ? $name : $value[$return];
}

//机房缓存读取
function ReadServersCache($name, $return, $where = null)
{

    S(array('type' => 'File', 'prefix' => 'servers', 'expire' => 65535));
    $whereid = empty($where) ? "" : md5(serialize($where));
    $valuecache = S("servers" . $whereid);
    if (!is_array($valuecache)) {
        $valuecache = M("servers")->where($where)->order("ord asc,id asc")->select();

        if (is_array($valuecache)) {
            $valuecache = array_column($valuecache, null, "flag");
            S("servers" . $whereid, $valuecache);

        }
    }

    return returnCache($valuecache, $name, $return);
}

//产品分类读取
function ReadProductFlagCache($name, $agent, $return)
{
    S(array('type' => 'File', 'prefix' => 'productflag' . $agent, 'expire' => 65535));
    $valuecache = S("productflag");
    if (!is_array($valuecache)) {
        $valuecacheAPI = Api(array("cachetime" => time(), "serveragent" => $agent), "Cache", "productflag");

        $valuecache = $valuecacheAPI["cache"];

        if (is_array($valuecache)) {
            $valuecache = array_column($valuecache, null, "flag");
            S("productflag", $valuecache);
        }
    }
    return returnCache($valuecache, $name, $return);
}

//产品缓存读取
function ReadProductCache($name, $agent, $return)
{
    S(array('type' => 'File', 'prefix' => 'product' . $agent, 'expire' => 65535));
    $valuecache = S("product");
    if (!is_array($valuecache)) {
        $valuecache = M("product")->where(array("agent" => $agent))->order("flag asc,ord asc,id asc")->select();

        if (is_array($valuecache)) {
            $valuecache = array_column($valuecache, null, "id");
            S("product", $valuecache);

        }
    }


    return returnCache($valuecache, $name, $return);
}

function getSelect($list, $id, $return)
{

    return empty($list[$id][$return]) ? "-" : $list[$id][$return];
}

//缓存输出
function returnCache($valuecache, $name, $return)
{
    if ($name == "*") {
        return $valuecache;
    }
    $value = $valuecache[$name];
    if ($return == "*") {
        return $value;
    } else {

        return empty($value[$return]) ? $name : $value[$return];
    }
}

function buy($pid)
{
    echo U("Shop/buy", array("id" => $pid));
}

function increment($pid, $id)
{
    echo U("Shop/increment", array("id" => $pid, "productid" => $id));
}

function getState($state)
{
    $sta = C("state");
    return empty($sta[$state]) ? $state : $sta[$state];
}


function delDirAndFile($path, $delDir = FALSE)
{
    $handle = opendir($path);
    if ($handle) {
        while (false !== ($item = readdir($handle))) {
            if ($item != "." && $item != "..")
                is_dir("$path/$item") ? delDirAndFile("$path/$item", $delDir) : unlink("$path/$item");
        }
        closedir($handle);
        if ($delDir)
            return rmdir($path);
    } else {
        if (file_exists($path)) {
            return unlink($path);
        } else {
            return FALSE;
        }
    }
}


function getqqwechatinfo($arr, $name, $type = "text")
{

    $arr = unserialize(base64_decode($arr));
    if (empty($arr)) {
        return ($type == "text") ? "未绑定" : "";
    }
    if (empty($arr[$name])) {
        return ($type == "text") ? "已绑定" : "";
    }
    $res = $arr[$name];
    if ($type == "img") $res = mb_substr($res, 5, "UTF-8");
    return $res;
}

function checkWebUser()
{
    $confg = getConfig();
    $ses = session('USER_INFO');
    return (!empty($ses) && $confg["acname"] == $ses["username"]) ? true : false;
}

function checkAgent()
{
    $ses = session('USER_INFO');
    return (!empty($ses) && (int)$ses["agentlv"] > 0) ? true : false;
}

if (!function_exists('array_column')) {
    function array_column(array $array, $column_key, $index_key = null)
    {
        $result = array();
        foreach ($array as $arr) {
            if (!is_array($arr)) continue;

            if (is_null($column_key)) {
                $value = $arr;
            } else {
                $value = $arr[$column_key];
            }

            if (!is_null($index_key)) {
                $key = $arr[$index_key];
                $result[$key] = $value;
            } else {
                $result[] = $value;
            }
        }
        return $result;
    }
}

function getWebsiteSet($key,$encode=false)
{
	if($encode){
		return \Common\Util\WebsiteSetConfig::get($key);
	}
    return htmlspecialchars_decode(\Common\Util\WebsiteSetConfig::get($key));
}

function getWebsiteList()
{
    return \Common\Util\WebsiteSetConfig::getList();
}

/*设置模版*/
function get_Theme(){
    $tmplete_config = C("tmplete_path");
    if (!is_dir(MODULE_PATH . "View/{$tmplete_config}/")) {
        $dp = dir(MODULE_PATH . "View/");

        while ($file = $dp->read()) {
            if ($file != '.' && $file != '..' && is_dir(MODULE_PATH . "View/{$file}/")) {
                $tmplete_config = $file;
                break;
            }
        }
        $dp->close();
    }
    C("TMPL_PARSE_STRING.__PUBLIC__" , "/Public/{$tmplete_config}" );
    return $tmplete_config;
}
function set_theme($theme = 'pc')
{
    $tmplete_config = get_Theme();




    C("VIEW_PATH", MODULE_PATH . "View/{$tmplete_config}/");
    $IS_MOBILE = is_mobile();
    if ($IS_MOBILE && is_dir(MODULE_PATH . "View/{$tmplete_config}/mobile/")) {
        C("DEFAULT_THEME", "mobile");
    }
}