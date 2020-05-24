<?php

$session_path=dirname(__FILE__) . "/session/";
if(!is_dir($session_path)){
	@mkdir($session_path,0755);
}
/*自动生成DATA_CACHE_KEY，解决TP最新漏洞*/
$DATA_CACHE_KEY = file_get_contents( RUNTIME_PATH . "key.txt" );

if( !is_dir(RUNTIME_PATH) ){
    mkdir(RUNTIME_PATH,0755);
}
if( !file_exists( RUNTIME_PATH . "DATA_CACHE_KEY.php" ) ){

}else{
    $DATA_CACHE_KEY = include (RUNTIME_PATH . "DATA_CACHE_KEY.php");

}
if( empty($DATA_CACHE_KEY) ){
    $DATA_CACHE_KEY = mt_rand( 100000,9999999999 ) . time();
    file_put_contents( RUNTIME_PATH . "DATA_CACHE_KEY.php" , '<?php
    return \'' . $DATA_CACHE_KEY . '\';
    ?>
    ' );

}
return array(
	'DEFAULT_THEME' => 'pc',
    'ADMIN_PWD_KEY'			=>	'fdkshfdskihh', //加密秘钥
	'DATA_CACHE_KEY' => $DATA_CACHE_KEY,
	'DB_DEBUG' => true,
	'DB_SQL_LOG'=>true,
	'PAGE_SIZE' => 10, //分页大小
	'LOAD_EXT_CONFIG'=>'db_config,version,tmplete_config',	
	'URL_MODEL'=>2,
	'DEFAULT_MODULE'=>'Home',

	'MODULE_ALLOW_LIST'    =>    array('Home'),
    'VAR_PAGE'=>'page',
	'SESSION_OPTIONS'=> array(
			'expire'=>'65536',
			"path"=>$session_path,
	),
	'SERVERTYPE'=>array(
	'vps'=>'VPS',
	'domain'=>'域名',
	'adsl'=>'ADSL',
	'host'=>'虚拟主机',
	'server'=>'服务器',
	'cloud'=>'弹性云主机',
	'mssql'=>'MSSQL',
	'mysql'=>'MYSQL',
	'seo'=>'营销推广',
	),
	'producttype'=>array(
	'static'=>'普通',
	'rate'=>'费率',
	),
	'buymode'=>array(
	'day'=>"日",
	"week"=>"周",
	"month"=>"月",
	"quarter"=>"季",
	"half"=>"半年",
	"year"=>"年",
	"twoyear"=>"两年",
	"threeyear"=>"三年",
	"fouryear"=>"四年",
	"fiveyear"=>"五年",
	),
	'Dictionary'=>array(
	'address'=>'地区',
	'system'=>'系统',
	'cpu'=>'CPU核心',
	'ram'=>'内存',
	
	),
	'state'=>array(
	'0'=>'处理中，具体查看任务状态',
	'1'=>'已付款',
	'2'=>'已过期',
	'999'=>'正常',
	'998'=>'已取消',
	'996'=>'增值待处理',
	'888'=>'处理中',
	'997'=>'退款申请中',
	),
    'paymode'=>array(
		'static'=>'固定金额',
		'rate'=>'官方折扣',
	),
'TMPL_PARSE_STRING'=>array(
		'__RESOURE__'=>'https://cache-code-ui.html5ui.org',
		'__PUBLIC__'=>'/Public/2016',
	)
);