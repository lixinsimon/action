<?php
/**
 * [商城开源系统] Copyright (c) 2014 ZhiWi.COM
 *  商城群QQ：628361862  进群下载更新包 交流技术   http://www.ZhiWi.com/.
 */
function mb($MuBanMing,$flag = TEMPLATE_DISPLAY){
	global $_W;	
	$yangshi=empty($_W['yangshi'])?"moren":$_W['yangshi'];
	$kong=empty($_W['kong'])?'':$_W['kong'].'/';
	$mo=empty($_W['mo'])?'':'/mokuai/'.$_W['mo'];	
	if($mo && $flag!='APP' ){
		$mokuai_yangshi=RUKOUMULU.'/'.$yangshi;
		if(RUKOUMULU=='houtai' || RUKOUMULU=='shanghu' || RUKOUMULU=='daili'){
			$mokuai_yangshi=RUKOUMULU;
		}
		$yuan = GENMULU .$mo. "/muban/".$mokuai_yangshi."/{$kong}{$MuBanMing}.html";	
	    $huan = GENMULU . "/huancun/muban".$mo."_".$mokuai_yangshi."_{$_W['kong']}_{$MuBanMing}.tpl.php";
	    if(!is_file($yuan)) {
		   $yuan = GENMULU .$mo. "/muban/".$mokuai_yangshi."/gongyou/{$MuBanMing}.html";
		   $huan = GENMULU . "/huancun/muban".$mo."_".$mokuai_yangshi."_{$_W['kong']}_{$MuBanMing}.tpl.php";
		}	   
	}else{
		$yuan = GENMULU . "/".RUKOUMULU."/muban/{$yangshi}/{$kong}{$MuBanMing}.html";
	    $huan = GENMULU . "/huancun/muban/".RUKOUMULU."_{$_W['kong']}_{$MuBanMing}.tpl.php";
	}		
	if(!is_file($yuan)) {
	   $yuan = GENMULU . "/".RUKOUMULU."/muban/{$yangshi}/gongyou/{$MuBanMing}.html";
	   $huan = GENMULU . "/huancun/muban/".RUKOUMULU."_{$_W['kong']}_gongyou_{$_W['xing']}_{$MuBanMing}.tpl.php";
	}
	if(!is_file($yuan)) {
	   $yuan = GENMULU . "/".RUKOUMULU."/muban/moren/gongyou/{$MuBanMing}.html";	   
	}	
	if(!is_file($yuan)) {		
		cuo("此模板'{$yuan}'不存在 ！");
	}	
	if(DEVELOPMENT || !is_file($huan) || filemtime($yuan) > filemtime($huan)) {		
		template_compile($yuan, $huan);
	}	
	switch ($flag) {
		case TEMPLATE_DISPLAY:
		default:				
			extract($GLOBALS, EXTR_SKIP);		
			include $huan;		
			break;
		case TEMPLATE_FETCH:
			extract($GLOBALS, EXTR_SKIP);
			ob_flush();
			ob_clean();
			ob_start();
			include $huan;
			$contents = ob_get_contents();
			ob_clean();
			return $contents;
			break;
		case TEMPLATE_INCLUDEPATH:
			return $huan;
			break;
	}
	
}
function template_compile($from, $to, $inmodule = false) {
	$path = dirname($to);
	if (!is_dir($path)) {
		han('wenjian');
		mkdirs($path);
	}
	$content = template_parse(file_get_contents($from), $inmodule);
	if(IMS_FAMILY == 'x' && !preg_match('/(footer|header|account\/welcome|login|register)+/', $from)) {
		$content = str_replace('微信', '系统', $content);
	}
	file_put_contents($to, $content);
}

function template_parse($str, $inmodule = false) {
	$str = preg_replace('/<!--{(.+?)}-->/s', '{$1}', $str);
	$str = preg_replace('/{template\s+(.+?)}/', '<?php (!empty($this) && $this instanceof WeModuleSite || '.intval($inmodule).') ? (include $this->template($1, TEMPLATE_INCLUDEPATH)) : (include template($1, TEMPLATE_INCLUDEPATH));?>', $str);
	$str = preg_replace('/{mb\s+(.+?)}/', '<?php (!empty($this) && $this instanceof WeModuleSite || '.intval($inmodule).') ? (include $this->mb($1, TEMPLATE_INCLUDEPATH)) : (include mb($1, TEMPLATE_INCLUDEPATH));?>', $str);	
	$str = preg_replace('/{php\s+(.+?)}/', '<?php $1?>', $str);
	$str = preg_replace('/{if\s+(.+?)}/', '<?php if($1) { ?>', $str);
	$str = preg_replace('/{else}/', '<?php } else { ?>', $str);
	$str = preg_replace('/{else ?if\s+(.+?)}/', '<?php } else if($1) { ?>', $str);
	$str = preg_replace('/{\/if}/', '<?php } ?>', $str);
	$str = preg_replace('/{loop\s+(\S+)\s+(\S+)}/', '<?php if(is_array($1)) { foreach($1 as $2) { ?>', $str);
	$str = preg_replace('/{loop\s+(\S+)\s+(\S+)\s+(\S+)}/', '<?php if(is_array($1)) { foreach($1 as $2 => $3) { ?>', $str);
	$str = preg_replace('/{\/loop}/', '<?php } } ?>', $str);
	$str = preg_replace('/{(\$[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)}/', '<?php echo $1;?>', $str);
	$str = preg_replace('/{(\$[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff\[\]\'\"\$]*)}/', '<?php echo $1;?>', $str);
	$str = preg_replace('/{url\s+(\S+)}/', '<?php echo url($1);?>', $str);
	$str = preg_replace('/{url\s+(\S+)\s+(array\(.+?\))}/', '<?php echo url($1, $2);?>', $str);
	$str = preg_replace('/{media\s+(\S+)}/', '<?php echo tomedia($1);?>', $str);
	$str = preg_replace_callback('/<\?php([^\?]+)\?>/s', "template_addquote", $str);
	$str = preg_replace('/{([A-Z_\x7f-\xff][A-Z0-9_\x7f-\xff]*)}/s', '<?php echo $1;?>', $str);
	$str = str_replace('{##', '{', $str);
	$str = str_replace('##}', '}', $str);
	if (!empty($GLOBALS['_W']['setting']['remote']['type'])) {
		$str = str_replace('</body>', "<script>$(function(){\$('img').attr('onerror', '').on('error', function(){if (!\$(this).data('check-src') && (this.src.indexOf('http://') > -1 || this.src.indexOf('https://') > -1)) {this.src = this.src.indexOf('{$GLOBALS['_W']['attachurl_local']}') == -1 ? this.src.replace('{$GLOBALS['_W']['attachurl_remote']}', '{$GLOBALS['_W']['attachurl_local']}') : this.src.replace('{$GLOBALS['_W']['attachurl_local']}', '{$GLOBALS['_W']['attachurl_remote']}');\$(this).data('check-src', true);}});});</script></body>", $str);
	}
	$str = "<?php defined('IN_IA') or exit('Access Denied');?>" . $str;
	return $str;
}

function template_addquote($matchs) {
	$code = "<?php {$matchs[1]}?>";
	$code = preg_replace('/\[([a-zA-Z0-9_\-\.\x7f-\xff]+)\](?![a-zA-Z0-9_\-\.\x7f-\xff\[\]]*[\'"])/s', "['$1']", $code);
	return str_replace('\\\"', '\"', $code);
}


function Html($lujing,$neirong){
	global $_W;		
	$huan=GENMULU.'/huancun/zidingyi/';	
	$huan.=empty($_W['mo'])?'':$_W['mo'].'_';
	//$huan.=empty($_W['kong'])?'':$_W['kong'].'_';
	$huan.=$lujing.'.php';		
	$path = dirname($huan);	
	if (!is_dir($path)) {
		han('wenjian');
		mkdirs($path);
	}	
	return file_put_contents($huan, $neirong);
}

function ZiDingYi($MuBanMing='index'){
	global $_W;	
	$huan=GENMULU.'/huancun/zidingyi/';	
	$huan.=empty($_W['mo'])?'':$_W['mo'].'_';
	//$huan.=empty($_W['kong'])?'':$_W['kong'].'_';
	$huan.=$MuBanMing.'.php';	
	if(!is_file($huan)) {		
		cuo("此模板'{$huan}'不存在 ！");
	}
	include $huan;	
}
?>