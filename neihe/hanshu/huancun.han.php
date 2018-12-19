<?php
/**
 * [商城开源系统] Copyright (c) 2014 ZhiWi.COM
 *  商城群QQ：628361862  进群下载更新包 交流技术   http://www.ZhiWi.com/.
 */

function Du($key='',$type=''){
	if($type=='redis' || $type=='r'){
		$C=Du_Redis($key);
	}elseif($type=='memcache' || $type=='m'){
		$C=Du_Memcache($key);
	}else{
		$C=Du_Session($key);
	}
}
function Cun($key='',$val='',$type=''){	
	if($type=='redis' || $type=='r'){
		$C=Cun_Redis($key,$val);
	}elseif($type=='memcache' || $type=='m'){
		$C=Cun_Memcache($key,$val);
	}else{
		$C=Cun_Session($key,$val);
	}
	return $C;
}

function Du_Session($key=''){
	session_start();
	if(empty($key)){
		return array();
	} 
	return $_SESSION[$key];
}

function Cun_Session($key='',$val=''){
	session_start();
	if(empty($key)){
		cuo("key不能为空");
	}	
	$_SESSION[$key]=$val;
	return $key;
}
?>