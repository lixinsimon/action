<?php
/**
 * [商城开源系统] Copyright (c) 2014 ZhiWi.COM
 *  商城群QQ：628361862  进群下载更新包 交流技术   http://www.ZhiWi.com/.
 */
function DanYuan($tiaojian=array('Zhuangtai'=>1)){
	global $_W;
    $tiaojian['id']=$_W['danyuan'];
	session_start();
	if(empty($_SESSION['dy'])){
        $_SESSION['dy']=Qu('he_danyuan',$tiaojian);
	}
	$_W['dy']=$_SESSION['dy'];	
	return $_W['dy'];
}
function Zai($name='',$NaLi='',$ZhiQuDiZhi=false){
	if(empty($name)){
		trigger_error('文件名不能为空 ', E_USER_ERROR);
		return false;
	}
	if(empty($NaLi)){
		$file = GENMULU.'/'.$name;
	}elseif($NaLi=='han'){
		$file = GENMULU . '/neihe/hanshu/' . $name . '.han.php';
	}elseif($NaLi=='lei'){
		$file = GENMULU . '/neihe/lei/' . $name . '.lei.php';		
	}	
	if (file_exists($file)) {
		if($ZhiQuDiZhi){
			return $file;	
		}else{
			include $file;	
			return true;
		}	
	} else {
		trigger_error('不存在此文件： '.$file, E_USER_ERROR);
		return false;
	}	
}
function QuXiang($name='',$NaLi=''){
	return Zai($name,$NaLi,true);
}
function Han($name){
	static $_HAN = array();	
	if(!empty($_HAN[$name])){
		return $_HAN[$name];
	}
	$_HAN[$name]=Zai($name,'han');
	return $_HAN[$name];
}
function Lei($name){
	static $_LEI = array();	
	if(!empty($_LEI[$name])){
		return $_LEI[$name];
	}
	$_LEI[$name]=Zai($name,'lei');
	return $_LEI[$name];
}
function Cuo($xiao){
	exit($xiao);	
}

function MX($name='moxing',$shui=Null){
	global $_W;	
	static $_MOXING = array();		
	if(empty($shui)){	
	  $n=$_W['mo'].'_'.$name;  
	  $moxing='mokuai/'.$_W['mo'].'/'.$name.'.php';		
	}else{
	   $n=$shui.'_'.$name;  
	   $moxing='mokuai/'.$shui.'/'.$name.'.php';		
	}	
	if($shui=='he' || !file_exists(GENMULU.'/'.$moxing)){	
	  $n=$name;
	  $moxing='neihe/lei/'.$name.'.lei.php';		
	}	
	if(!empty($_MOXING[$n])){		
		return $_MOXING[$n];
	}
	Zai($moxing);	
	$_MOXING[$n]=new $n();
	return $_MOXING[$n];
}
function isMX($mo=Null,$name='moxing'){
	$lujing=GENMULU.'/mokuai/'.$mo.'/'.$name.'.php';
	if(file_exists($lujing)){
		return true;
	}
	return false;	
}
function GetIp() {
	static $ip = '';
	$ip = $_SERVER['REMOTE_ADDR'];
	if(isset($_SERVER['HTTP_CDN_SRC_IP'])) {
		$ip = $_SERVER['HTTP_CDN_SRC_IP'];
	} elseif (isset($_SERVER['HTTP_CLIENT_IP']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_CLIENT_IP'])) {
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	} elseif(isset($_SERVER['HTTP_X_FORWARDED_FOR']) AND preg_match_all('#\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}#s', $_SERVER['HTTP_X_FORWARDED_FOR'], $matches)) {
		foreach ($matches[0] AS $xip) {
			if (!preg_match('#^(10|172\.16|192\.168)\.#', $xip)) {
				$ip = $xip;
				break;
			}
		}
	}
	return $ip;
}
function BiJiaoBanBen($v1, $v2) {
	return version_compare($v1, $v2);
}
function strexists($string, $find) {
	return !(strpos($string, $find) === FALSE);
}
function htmlGeShiHua($var) {
	if (is_array($var)) {
		foreach ($var as $key => $value) {
			$var[htmlspecialchars($key)] = htmlGeShiHua($value);
		}
	} else {
		$var = str_replace('&amp;', '&', htmlspecialchars($var, ENT_QUOTES));
	}
	return $var;
}
function dump($V=''){
	echo "<pre>";
	var_dump($V);
	echo "<pre>";	
}
function random($length, $numeric = FALSE) {
	$seed = base_convert(md5(microtime() . $_SERVER['DOCUMENT_ROOT']), 16, $numeric ? 10 : 35);
	$seed = $numeric ? (str_replace('0', '', $seed) . '012340567890') : ($seed . 'zZ' . strtoupper($seed));
	if ($numeric) {
		$hash = '';
	} else {
		$hash = chr(rand(1, 26) + rand(0, 1) * 32 + 64);
		$length--;
	}
	$max = strlen($seed) - 1;
	for ($i = 0; $i < $length; $i++) {
		$hash .= $seed{mt_rand(0, $max)};
	}
	return $hash;
}

function shiCuo($data) {
	if (empty($data) || !is_array($data) || !array_key_exists('errno', $data) || (array_key_exists('errno', $data) && $data['errno'] == 0)) {
		return false;
	} else {
		return true;
	}
}

function JueDuiUrl($src, $local_path = false){
	global $_W;
	if (empty($src)) {
		return $_W['yuming'].'gongyong/images/moren.jpg';
	}	
	if (strpos($src, './mokuai') === 0) {
		return $_W['yuming'] . str_replace('./', '', $src);
	}
	if (strpos($src, './gongyong') === 0) {
		return $_W['yuming'] . str_replace('./', '', $src);
	}
    if (strexists($src, $_W['yuming']) && !strexists($src, '/mokuai/')) {
		$urls = parse_url($src);
		$src = $t = substr($urls['path'], strpos($urls['path'], 'images'));
	}
	$t = strtolower($src);	
	if (strexists($t, 'https://mmbiz.qlogo.cn')) {
		return url('utility/wxcode/image', array('attach' => $src));
	}
	if (strexists($t, 'http://') || strexists($t, 'https://')) {
		return $src;
	}
	if (strexists($src, 'https://mmbiz.qlogo.cn')) {
		return url('utility/wxcode/image', array('attach' => $src));
	}
	
	if ($local_path || empty($_W['setting']['remote']['type']) || file_exists(GENMULU . '/' . $_W['config']['upload']['attachdir'] . '/' . $src)) {
		$src = $_W['yuming'] . $_W['config']['upload']['attachdir'] . '/' . $src;
	} else {
		$src = $_W['attachurl_remote'] . $src;
	}	
	return $src;
}
function BianJiQi($name, $value = '', $options = array()){
	$html='';
	$id=random(10);	
	if(!defined('BianJiQi')){
		$html.='<script type="text/javascript" charset="utf-8" src="../gongyong/js/ueditor/ueditor.config.js"></script>
		<script type="text/javascript" charset="utf-8" src="../gongyong/js/ueditor/ueditor.all.min.js"> </script>		
		<script type="text/javascript" charset="utf-8" src="../gongyong/js/ueditor/lang/zh-cn/zh-cn.js"></script>';
	    define('BianJiQi', true);
	}
	$options['height'] = empty($options['height']) ? 200 : $options['height'];
	$html .= !empty($id) ? "<textarea id=\"{$id}\" name=\"{$name}\" type=\"text/plain\" style=\"height:{$options['height']}px;\">{$value}</textarea>" : '';
	$html .= !empty($id) ? "<script type='text/javascript'>	var {$id} = UE.getEditor('{$id}');</script>":'';	
	return $html;
	
}


function XiaoXi($xinxi='',$url='',$leixing=''){	
	global $_W;
	if($_W['zhongduan']=='xiaochengxu' || $_W['zhongduan']=='app'){
		json($xinxi,0);
	}elseif(empty($leixing)){
		if($_W['isajax']){
			$vars = array();
			$vars['xin']=$xinxi;
		    $vars['url']=$url;
		    json($vars,0);			
		}elseif($url=='shuaxin'){
			$url='http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];
		}else{
			$url=empty($url)?'javascript:history.go(-1)':$url;	
		}			
		include mb('xiaoxi', TEMPLATE_INCLUDEPATH);
		exit;
	}elseif($leixing==1){		
		$url=empty($url)?'javascript:history.go(-1)':$url;	
		include mb('xiaoxi', TEMPLATE_INCLUDEPATH);exit;
	}elseif($leixing=='ajax'){
		$vars = array();
		$vars['xin']=$vars['message'] = $xinxi;
		$vars['url']=$vars['redirect'] = $url;
		$vars['shi']=$vars['type'] = $leixing;
		exit(json_encode($vars));
	}
	
}
function json($zhi,$shi=1){
	$json=array('shu'=>$zhi,'shi'=>$shi);
	exit(json_encode($json));
}
//创建链接 $quD：去掉D值 也就是去danyuan_id
function U($kongzhiqi,$censhu = array(),$zhongduan='',$quD=false){
	global $_W;
	list($kong, $xing, $mo) = explode('/', $kongzhiqi);
	if(empty($zhongduan)){
	   $url .= $_W['yuming_']."index.php?";	
	}else{
	   $url .= $_W['yuming'].$zhongduan."/index.php?";	
	}
	
	if(empty($censhu['d']) && !$quD){
		$url.=empty($_W['danyuan'])?"":"d={$_W['danyuan']}&";	
	}
	if(!empty($kong)){
		$url.="k=".$kong.'&';
	}
	if(!empty($xing)){
		$url.="x=".$xing.'&';
	}
	if(!empty($mo)){
		$url.="m=".$mo.'&';
	}	
	if (!empty($censhu)) {
		foreach($censhu as $x=>$z){
			if(!empty($z)){
				$url.=$x."=".$z.'&';	
			}
		
		}
	}	
	return rtrim($url,'&');
}
//创建后台链接
function UH($kongzhiqi,$censhu = array(),$quD=false){
	return U($kongzhiqi,$censhu,'houtai',$quD);
}
//创建后台模块链接
function UHK($kongzhiqi,$censhu = array(),$quD=false){
	global $_W;
	$censhu['m']=$_W['mo'];	
	return U($kongzhiqi,$censhu,'houtai',$quD);
}
//创建APP链接
function UA($kongzhiqi,$censhu = array()){
	global $_W;

	if(!empty($_W['tui'])){
		$censhu['t']=$_W['tui'];
	}
	if(!empty($_W['dian'])){
		$censhu['dian']=$_W['dian'];
	}
	return U($kongzhiqi,$censhu,'app');
}
//创建前台模块链接
function UAK($kongzhiqi,$censhu = array(),$quD=false){
	global $_W;
	$censhu['m']=$_W['mo'];	
	if(!empty($_W['tui'])){
		$censhu['t']=$_W['tui'];
	}
	if(!empty($_W['dian'])){
		$censhu['dian']=$_W['dian'];
	}
	return U($kongzhiqi,$censhu,'app',$quD);
}
//创建前台小站链接
function UX($kongzhiqi,$censhu = array(),$quD=false){
	global $_W;	
	if(!empty($_W['tui'])){
		$censhu['t']=$_W['tui'];
	}
	$censhu['sh']=$_W['xiaozhan'];	
	return U($kongzhiqi,$censhu,'xiaozhan',$quD);
}
//创建前台小站模块链接
function UXK($kongzhiqi,$censhu = array(),$quD=false){
	global $_W;
	$censhu['m']=$_W['mo'];	
	if(!empty($_W['tui'])){
		$censhu['t']=$_W['tui'];
	}
	$censhu['sh']=$_W['xiaozhan'];	
	return U($kongzhiqi,$censhu,'xiaozhan',$quD);
}
//创建PC链接
function UP($kongzhiqi,$censhu = array()){
	return U($kongzhiqi,$censhu,'pc');
}
//表名
function BM($table) {
	if(empty($GLOBALS['_W']['config']['db']['master'])) {
		return "`{$GLOBALS['_W']['config']['db']['tablepre']}{$table}`";
	}
	return "`{$GLOBALS['_W']['config']['db']['master']['tablepre']}{$table}`";
}

function TiaoZhuan($url=''){
	if(empty($url)){
		XiaoXi('链接不存在');
	}
	header("Location: ".$url);
    exit;
}

function FenYe($total, $pageIndex, $pageSize = 15, $url = '', $context = array('before' => 5, 'after' => 4, 'ajaxcallback' => '')) {
	global $_W;
	
	$pdata = array(
		'tcount' => 0,
		'tpage' => 0,
		'cindex' => 0,
		'findex' => 0,
		'pindex' => 0,
		'nindex' => 0,
		'lindex' => 0,
		'options' => ''
	);
	if ($context['ajaxcallback']) {
		$context['isajax'] = true;
	}
   
	$pdata['tcount'] = $total;
	
	$pdata['tpage'] = ceil($total / $pageSize);
	
	if ($pdata['tpage'] <= 1) {
		return '';
	}
	$cindex = $pageIndex;	
	$cindex = min($cindex, $pdata['tpage']);
	$cindex = max($cindex, 1);
	
	$pdata['cindex'] = $cindex;
	$pdata['findex'] = 1;
	$pdata['pindex'] = $cindex > 1 ? $cindex - 1 : 1;
	$pdata['nindex'] = $cindex < $pdata['tpage'] ? $cindex + 1 : $pdata['tpage'];
	$pdata['lindex'] = $pdata['tpage'];  	
	if ($context['isajax']) {
		if (!$url) {
			$url = $_W['script_name'] . '?' . http_build_query($_GET);
		}
		$pdata['faa'] = 'href="javascript:;" page="' . $pdata['findex'] . '" '. ($callbackfunc ? 'onclick="'.$callbackfunc.'(\'' . $_W['script_name'] . $url . '\', \'' . $pdata['findex'] . '\', this);return false;"' : '');
		$pdata['paa'] = 'href="javascript:;" page="' . $pdata['pindex'] . '" '. ($callbackfunc ? 'onclick="'.$callbackfunc.'(\'' . $_W['script_name'] . $url . '\', \'' . $pdata['pindex'] . '\', this);return false;"' : '');
		$pdata['naa'] = 'href="javascript:;" page="' . $pdata['nindex'] . '" '. ($callbackfunc ? 'onclick="'.$callbackfunc.'(\'' . $_W['script_name'] . $url . '\', \'' . $pdata['nindex'] . '\', this);return false;"' : '');
		$pdata['laa'] = 'href="javascript:;" page="' . $pdata['lindex'] . '" '. ($callbackfunc ? 'onclick="'.$callbackfunc.'(\'' . $_W['script_name'] . $url . '\', \'' . $pdata['lindex'] . '\', this);return false;"' : '');
	} else {
		if ($url) {
			$pdata['faa'] = 'href="?' . str_replace('*', $pdata['findex'], $url) . '"';
			$pdata['paa'] = 'href="?' . str_replace('*', $pdata['pindex'], $url) . '"';
			$pdata['naa'] = 'href="?' . str_replace('*', $pdata['nindex'], $url) . '"';
			$pdata['laa'] = 'href="?' . str_replace('*', $pdata['lindex'], $url) . '"';
		} else {
			$_GET['page'] = $pdata['findex'];
			$pdata['faa'] = 'href="' . $_W['script_name'] . '?' . http_build_query($_GET) . '"';
			$_GET['page'] = $pdata['pindex'];
			$pdata['paa'] = 'href="' . $_W['script_name'] . '?' . http_build_query($_GET) . '"';
			$_GET['page'] = $pdata['nindex'];
			$pdata['naa'] = 'href="' . $_W['script_name'] . '?' . http_build_query($_GET) . '"';
			$_GET['page'] = $pdata['lindex'];
			$pdata['laa'] = 'href="' . $_W['script_name'] . '?' . http_build_query($_GET) . '"';
		}
	}
	$html = '<div><ul class="pagination pagination-centered">';
	if ($pdata['cindex'] > 1) {
		$html .= "<li><a {$pdata['faa']} class=\"pager-nav\">首页</a></li>";
		$html .= "<li><a {$pdata['paa']} class=\"pager-nav\">&laquo;上一页</a></li>";
	}
		if (!$context['before'] && $context['before'] != 0) {
		$context['before'] = 5;
	}
	if (!$context['after'] && $context['after'] != 0) {
		$context['after'] = 4;
	}

	if ($context['after'] != 0 && $context['before'] != 0) {
		$range = array();
		$range['start'] = max(1, $pdata['cindex'] - $context['before']);
		$range['end'] = min($pdata['tpage'], $pdata['cindex'] + $context['after']);
		if ($range['end'] - $range['start'] < $context['before'] + $context['after']) {
			$range['end'] = min($pdata['tpage'], $range['start'] + $context['before'] + $context['after']);
			$range['start'] = max(1, $range['end'] - $context['before'] - $context['after']);
		}
		for ($i = $range['start']; $i <= $range['end']; $i++) {
			if ($context['isajax']) {
				$aa = 'href="javascript:;" page="' . $i . '" '. ($callbackfunc ? 'onclick="'.$callbackfunc.'(\'' . $_W['script_name'] . $url . '\', \'' . $i . '\', this);return false;"' : '');
			} else {
				if ($url) {
					$aa = 'href="?' . str_replace('*', $i, $url) . '"';
				} else {
					$_GET['page'] = $i;
					$aa = 'href="?' . http_build_query($_GET) . '"';
				}
			}
			$html .= ($i == $pdata['cindex'] ? '<li class="active"><a href="javascript:;">' . $i . '</a></li>' : "<li><a {$aa}>" . $i . '</a></li>');
		}
	}

	if ($pdata['cindex'] < $pdata['tpage']) {
		$html .= "<li><a {$pdata['naa']} class=\"pager-nav\">下一页&raquo;</a></li>";
		$html .= "<li><a {$pdata['laa']} class=\"pager-nav\">尾页</a></li>";
	}
	$html .= '</ul></div>';	
	return $html;
}
function JiaMi64($zhi){	
  return base64_encode($zhi);
}
function JianMi64($zhi){	
  return base64_decode($zhi);
}
function ShuZu_Zhuan_ZiFuChuan($value='') {
	return serialize($value);
}
function ZiFuChuan_Zhuan_ShuZu($value='') {	
	if (empty($value)) {
		return array();
	}
	if (!is_ShuZu_Zhuan_ZiFuChuan($value)) {
		return $value;
	}
	$result = unserialize($value);
	if ($result === false) {

		$temp = preg_replace('!s:(\d+):"(.*?)";!se', "'s:'.strlen('$2').':\"$2\";'", $value);
		return unserialize($temp);
	}
	return $result;
}
function is_ShuZu_Zhuan_ZiFuChuan($data, $strict = true) {
	if (!is_string($data)) {
		return false;
	}
	$data = trim($data);
	if ('N;' == $data) {
		return true;
	}
	if (strlen($data) < 4) {
		return false;
	}
	if (':' !== $data[1]) {
		return false;
	}
	if ($strict) {
		$lastc = substr($data, -1);
		if (';' !== $lastc && '}' !== $lastc) {
			return false;
		}
	} else {
		$semicolon = strpos($data, ';');
		$brace = strpos($data, '}');
				if (false === $semicolon && false === $brace)
			return false;
				if (false !== $semicolon && $semicolon < 3)
			return false;
		if (false !== $brace && $brace < 4)
			return false;
	}
	$token = $data[0];
	switch ($token) {
		case 's' :
			if ($strict) {
				if ('"' !== substr($data, -2, 1)) {
					return false;
				}
			} elseif (false === strpos($data, '"')) {
				return false;
			}
				case 'a' :
		case 'O' :
			return (bool)preg_match("/^{$token}:[0-9]+:/s", $data);
		case 'b' :
		case 'i' :
		case 'd' :
			$end = $strict ? '$' : '';
			return (bool)preg_match("/^{$token}:[0-9.E-]+;$end/", $data);
	}
	return false;
}

function DiQu($name, $values = array()) {
	$html = '';	
	if (empty($values) || !is_array($values)) {
		$values = array('sheng'=>'','shi'=>'','qu'=>'');
	}
	if(empty($values['sheng'])) {
		$values['sheng'] = '';
	}
	if(empty($values['shi'])) {
		$values['shi'] = '';
	}
	if(empty($values['qu'])) {
		$values['qu'] = '';
	}
	$html .= '
		<div class="row row-fix tpl-district-container">
			<div class="col-sm-3">
				<select name="' . $name . '[sheng]" data-value="' . $values['sheng'] . '" class="form-control tpl-province">
				</select>
			</div>
			<div class="col-sm-3">
				<select name="' . $name . '[shi]" data-value="' . $values['shi'] . '" class="form-control tpl-city">
				</select>
			</div>
			<div class="col-sm-3">
				<select name="' . $name . '[qu]" data-value="' . $values['qu'] . '" class="form-control tpl-district">
				</select>
			</div>
		</div>';
	if (!defined('TPL_INIT_DISTRICT')) {
		$html .= '
		<script type="text/javascript" src="../gongyong/js/zhiwei/diqu.js"></script>
		<script type="text/javascript">			
				$(".tpl-district-container").each(function(){
					var elms = {};
					elms.province = $(this).find(".tpl-province")[0];
					elms.city = $(this).find(".tpl-city")[0];
					elms.district = $(this).find(".tpl-district")[0];
					var vals = {};
					vals.province = $(elms.province).attr("data-value");
					vals.city = $(elms.city).attr("data-value");
					vals.district = $(elms.district).attr("data-value");
					$dq.render(elms, vals, {withTitle: true});
				});		
		</script>';
		define('TPL_INIT_DISTRICT', true);
	}
	return $html;
}

function RiQi($name, $value = '', $withtime = false) {	
	$s = '';
	if (!defined('TPL_INIT_DATA')) {
		$s = '
		   <link rel="stylesheet" href="../gongyong/js/components/datetimepicker/jquery.datetimepicker.css" type="text/css" /> 
		   <script src="../gongyong/js/components/datetimepicker/jquery.datetimepicker.js"></script>			
			<script type="text/javascript">			
					$(function(){
						$(".datetimepicker").each(function(){
							var option = {
								lang : "zh",
								step : "10",
								timepicker : ' . (!empty($withtime) ? "true" : "false") .',
								closeOnDateSelect : true,
								format : "Y-m-d' . (!empty($withtime) ? ' H:i:s"' : '"') .
			                '};
			                $(this).datetimepicker(option);
		                });
	                });
              
            </script>';
		define('TPL_INIT_DATA', true);
	}
	$withtime = empty($withtime) ? false : true;
	if (!empty($value)) {
		$value = strexists($value, '-') ? strtotime($value) : $value;
	} else {
		$value = time();
	}
	$value = ($withtime ? date('Y-m-d H:i:00', $value) : date('Y-m-d', $value));
	$s .= '<input type="text" name="' . $name . '"  value="'.$value.'" placeholder="请选择日期时间" readonly="readonly" class="datetimepicker form-control" style="padding-left:12px;" />';
	return $s;
}
function ShengChengDingDanHao($biao, $ziduan, $qianzhui){
        $dingdanhao = date('YmdHis') . random(2, true);
        while (1) {
            $count = ChaZongShu('select count(*) from ' . BM($biao) . " where {$ziduan}=:ziduan limit 1", array(
                ':ziduan' => $dingdanhao
            ));
            if ($count <= 0) {
                break;
            }
            $dingdanhao = date('YmdHis') . random(2, true);
        }
    return  $qianzhui . $dingdanhao;
}

function ShuZu_Zhuan_Url($shu, $qianzhui = null, $gekaifu = '&') {
		if (!is_array($shu))return false;
		$url='';
		foreach($shu as $k=>$s){
			$url.=$qianzhui.$k.'='.$s.'&';
		}
		return rtrim($url,'&');
}
function ChaKuaiDi($id,$kuaidihao,$leixing='shuzu'){
	if(empty($id) || empty($kuaidihao) ){
		return;
	}
	Han('curl');
	$url= "http://m.kuaidi100.com/query?type={$id}&postid={$kuaidihao}&temp=".SHIJIAN;
	return get($url,$leixing);
}
function ShuZu_Zhuan_XML($arr, $level = 1) {
	$s = $level == 1 ? "<xml>" : '';
	foreach ($arr as $tagname => $value) {
		if (is_numeric($tagname)) {
			$tagname = $value['TagName'];
			unset($value['TagName']);
		}
		if (!is_array($value)) {
			$s .= "<{$tagname}>" . (!is_numeric($value) ? '<![CDATA[' : '') . $value . (!is_numeric($value) ? ']]>' : '') . "</{$tagname}>";
		} else {
			$s .= "<{$tagname}>" . ShuZu_Zhuan_XML($value, $level + 1) . "</{$tagname}>";
		}
	}
	$s = preg_replace("/([\x01-\x08\x0b-\x0c\x0e-\x1f])+/", ' ', $s);
	return $level == 1 ? $s . "</xml>" : $s;
}

function GuoLvTeShuZiFu($str){
	$str = str_replace('`', '', $str);
    $str = str_replace('·', '', $str);
    $str = str_replace('~', '', $str);
    $str = str_replace('!', '', $str);
    $str = str_replace('！', '', $str);
    $str = str_replace('@', '', $str);
    $str = str_replace('#', '', $str);
    $str = str_replace('$', '', $str);
    $str = str_replace('￥', '', $str);
    $str = str_replace('%', '', $str);
    $str = str_replace('^', '', $str);
    $str = str_replace('……', '', $str);
    $str = str_replace('&', '', $str);
    $str = str_replace('*', '', $str);
    $str = str_replace('(', '', $str);
    $str = str_replace(')', '', $str);
    $str = str_replace('（', '', $str);
    $str = str_replace('）', '', $str);
    $str = str_replace('-', '', $str);
    $str = str_replace('_', '', $str);
    $str = str_replace('——', '', $str);
    $str = str_replace('+', '', $str);
    $str = str_replace('=', '', $str);
    $str = str_replace('|', '', $str);
    $str = str_replace('\\', '', $str);
    $str = str_replace('[', '', $str);
    $str = str_replace(']', '', $str);
    $str = str_replace('【', '', $str);
    $str = str_replace('】', '', $str);
    $str = str_replace('{', '', $str);
    $str = str_replace('}', '', $str);
    $str = str_replace(';', '', $str);
    $str = str_replace('；', '', $str);
    $str = str_replace(':', '', $str);
    $str = str_replace('：', '', $str);
    $str = str_replace('\'', '', $str);
    $str = str_replace('"', '', $str);
    $str = str_replace('“', '', $str);
    $str = str_replace('”', '', $str);
    $str = str_replace(',', '', $str);
    $str = str_replace('，', '', $str);
    $str = str_replace('<', '', $str);
    $str = str_replace('>', '', $str);
    $str = str_replace('《', '', $str);
    $str = str_replace('》', '', $str);
    $str = str_replace('.', '', $str);
    $str = str_replace('。', '', $str);
    $str = str_replace('/', '', $str);
    $str = str_replace('、', '', $str);
    $str = str_replace('?', '', $str);
    $str = str_replace('？', '', $str);
    return trim($str);
}
/** Json数据格式化 
* @param  Mixed  $data   数据 
* @param  String $indent 缩进字符，默认4个空格 
* @return JSON 
*/  
function jsonFormat($data, $indent=null){  
  
    // 对数组中每个元素递归进行urlencode操作，保护中文字符  
    array_walk_recursive($data, 'jsonFormatProtect');  
  
    // json encode  
    $data = json_encode($data);  
  
    // 将urlencode的内容进行urldecode  
    $data = urldecode($data);  
  
    // 缩进处理  
    $ret = '';  
    $pos = 0;  
    $length = strlen($data);  
    $indent = isset($indent)? $indent : '    ';  
    $newline = "\n";  
    $prevchar = '';  
    $outofquotes = true;  
  
    for($i=0; $i<=$length; $i++){  
  
        $char = substr($data, $i, 1);  
  
        if($char=='"' && $prevchar!='\\'){  
            $outofquotes = !$outofquotes;  
        }elseif(($char=='}' || $char==']') && $outofquotes){  
            $ret .= $newline;  
            $pos --;  
            for($j=0; $j<$pos; $j++){  
                $ret .= $indent;  
            }  
        }  
  
        $ret .= $char;  
          
        if(($char==',' || $char=='{' || $char=='[') && $outofquotes){  
            $ret .= $newline;  
            if($char=='{' || $char=='['){  
                $pos ++;  
            }  
  
            for($j=0; $j<$pos; $j++){  
                $ret .= $indent;  
            }  
        }  
  
        $prevchar = $char;  
    }  
  
    return $ret;  
}  
  
/** 将数组元素进行urlencode 
* @param String $val 
*/  
function jsonFormatProtect(&$val){  
    if($val!==true && $val!==false && $val!==null){  
        $val = urlencode($val);  
    }  
}

function ShuZu_XML($arr, $level = 1) {
	$s = $level == 1 ? "<xml>" : '';
	foreach ($arr as $tagname => $value) {
		if (is_numeric($tagname)) {
			$tagname = $value['TagName'];
			unset($value['TagName']);
		}
		if (!is_array($value)) {
			$s .= "<{$tagname}>" . (!is_numeric($value) ? '<![CDATA[' : '') . $value . (!is_numeric($value) ? ']]>' : '') . "</{$tagname}>";
		} else {
			$s .= "<{$tagname}>" . ShuZu_XML($value, $level + 1) . "</{$tagname}>";
		}
	}
	$s = preg_replace("/([\x01-\x08\x0b-\x0c\x0e-\x1f])+/", ' ', $s);
	$s=str_replace('<>','',$s);
	$s=str_replace('</>','',$s);
	return $level == 1 ? $s . "</xml>" : $s;
}

function J(){
   $v=(file_get_contents("php://input"));
   return json_decode($v,true);
}

function XiaZaiTu($url, $saveName = '', $path = '') {
    // 设置运行时间为无限制
    if(empty($saveName)){
    	$saveName=time().'.jpg';
    }
    if(empty($path)){
    	$path=GENMULU.'/gongyong/xiazaitu/';
    }
	if(!is_dir($path)){	    	
		mkdir($path,0777);
		chmod($path,0777);	
	}
    set_time_limit ( 0 );    
    $url = trim ( $url );
    $curl = curl_init ();
    // 设置你需要抓取的URL
    curl_setopt ( $curl, CURLOPT_URL, $url );
    // 设置header
    curl_setopt ( $curl, CURLOPT_HEADER, 0 );
    // 设置cURL 参数，要求结果保存到字符串中还是输出到屏幕上。
    curl_setopt ( $curl, CURLOPT_RETURNTRANSFER, 1 );
    // 运行cURL，请求网页
    $file = curl_exec ( $curl );
    // 关闭URL请求
    curl_close ( $curl );
    // 将文件写入获得的数据
    $filename = $path . $saveName;
    $write = @fopen ( $filename, "w" );
    if ($write == false) {
        return false;
    }
    if (fwrite ( $write, $file ) == false) {
        return false;
    }
    if (fclose ( $write ) == false) {
        return false;
    }
    return $filename;
}

?>