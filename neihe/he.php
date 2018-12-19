<?php
/**
 * [商城开源系统] Copyright (c) 2014 ZhiWi.COM
 *  商城群QQ：628361862  进群下载更新包 交流技术   http://www.ZhiWi.com/.
 */
define('IN_IA', true);
define('GENMULU', str_replace("\\", '/', dirname(dirname(__FILE__))));
define('ATTACHMENT_ROOT', GENMULU.'/gongyong/shangchuan');
define('RUKOUMULU', substr($_SERVER['PHP_SELF'], 1, strrpos($_SERVER['PHP_SELF'], '/')-1));

define('MAGIC_QUOTES_GPC', (function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc()) || @ini_get('magic_quotes_sybase'));
define('SHIJIAN',time());
$_W = $_J =$_GPC= array();

require GENMULU . "/gongyong/config.php";
require GENMULU . '/gongyong/banben.php';
require GENMULU . '/neihe/hanshu.php';
Han('ku');
Han('muban');
Han('huancun');
lei('agent');
$_W['config'] = $config;
$_W['config']['db']['tablepre'] = !empty($_W['config']['db']['master']['tablepre']) ? $_W['config']['db']['master']['tablepre'] : $_W['config']['db']['tablepre'];
$_W['timestamp'] = time();
$_W['charset'] = $_W['config']['setting']['charset'];
$_W['clientip'] = getip();

if($_SERVER['HTTP_KOULING']){
   session_id($_SERVER['HTTP_KOULING']);	
}
//是否开启调试
define('DEVELOPMENT', $_W['config']['setting']['development'] ==0);
if(DEVELOPMENT) {
	ini_set('display_errors', '1');
	error_reporting(E_ALL ^ E_NOTICE);
} else {
	error_reporting(0);
}
if(function_exists('date_default_timezone_set')) {
	date_default_timezone_set($_W['config']['setting']['timezone']);
}
if(!empty($_W['config']['memory_limit']) && function_exists('ini_get') && function_exists('ini_set')) {
	if(@ini_get('memory_limit') != $_W['config']['memory_limit']) {
		@ini_set('memory_limit', $_W['config']['memory_limit']);
	}
}

$_W['yuming'] = htmlspecialchars($_SERVER['REQUEST_SCHEME'].'://' . $_SERVER['HTTP_HOST']);
$_W['yuming_']= $_W['yuming'].'/'.RUKOUMULU;
$_W['url']=$_W['yuming'].'/'.$_SERVER['REQUEST_URI'];

if(substr($_W['yuming'], -1) != '/') {
	$_W['yuming'] .= '/';
}
if(substr($_W['yuming_'], -1) != '/') {
	$_W['yuming_'] .= '/';
}

$_W['isajax'] = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
$_W['ispost'] = $_SERVER['REQUEST_METHOD'] == 'POST';

if(MAGIC_QUOTES_GPC) {
	$_GET = istripslashes($_GET);
	$_POST = istripslashes($_POST);
	$_COOKIE = istripslashes($_COOKIE);
}
$cplen = strlen($_W['config']['cookie']['pre']);
foreach($_COOKIE as $key => $value) {
	if(substr($key, 0, $cplen) == $_W['config']['cookie']['pre']) {
		$_J[substr($key, $cplen)] = $value;
	}
}
unset($cplen, $key, $value);


$_J = array_merge($_GET, $_POST, $_J);
$_J = htmlGeShiHua($_J);
//dump($_J );die;
if(!$_W['isajax']) {
	$input = file_get_contents("php://input");
	if (!empty($input)) {
		$__input = @json_decode($input, true);
		if (!empty($__input)) {
			$_GPC['__input'] = $__input;
			$_W['isajax'] = true;
		}
	}
	unset($input, $__input);
}
$_W['os'] = Agent::deviceType();
if($_W['os'] == Agent::DEVICE_MOBILE) {
	$_W['os'] = 'mobile';
} elseif($_W['os'] == Agent::DEVICE_DESKTOP) {
	$_W['os'] = 'windows';
} else {
	$_W['os'] = 'unknown';
}

$_W['zhongduan'] = Agent::browserType();
if($_SERVER['HTTP_APP']=='app'){
	$_W['zhongduan'] = 'app';
}elseif($_SERVER['HTTP_APP']=='xiaochengxu'){
	$_W['zhongduan'] = 'xiaochengxu';
}elseif(Agent::isMicroMessage() == Agent::MICRO_MESSAGE_YES) {
	$_W['zhongduan'] = 'weixin';
} elseif ($_W['zhongduan'] == Agent::BROWSER_TYPE_ANDROID) {
	$_W['zhongduan'] = 'android';
} elseif ($_W['zhongduan'] == Agent::BROWSER_TYPE_IPAD) {
	$_W['zhongduan'] = 'ipad';
} elseif ($_W['zhongduan'] == Agent::BROWSER_TYPE_IPHONE) {
	$_W['zhongduan'] = 'iphone';
} elseif ($_W['zhongduan'] == Agent::BROWSER_TYPE_IPOD) {
	$_W['zhongduan'] = 'ipod';
} else {
	$_W['zhongduan'] = 'unknown';
}
$_W['rukou']=$_J['r']?$_J['r']:'app';
$_W['kong']=empty($_J['k'])?'index':$_J['k'];
$_W['xing']=empty($_J['x'])?'index':$_J['x'];
$_W['mo']=empty($_J['m'])?'':$_J['m'];
$_W['danyuan']=empty($_J['d'])?'':$_J['d'];
$_W['xiaozhan']=empty($_J['sh'])?'':$_J['sh'];
if($_J['t']){
   $_W['tui']=$_J['t'];	
}
if($_J['dian']){
   $_W['dian']=$_J['dian'];	
}
header('Content-Type: text/html; charset=' . $_W['charset']);
header('Access-Control-Allow-Origin: *');

?>