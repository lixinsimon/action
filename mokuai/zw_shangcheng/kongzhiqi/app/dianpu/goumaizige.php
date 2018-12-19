<?php
/**
 * [商城开源系统] Copyright (c) 2014 ZhiWi.COM
 *  商城群QQ：628361862  进群下载更新包 交流技术   http://www.ZhiWi.com/.
 */
DengLu();
if($cao=='moren'  && $_W['ispost']){
	if(!$_J['dengji']){
		json("请选择等级",0);
	}
	if(!$_J['miaoshu']){
		json("请添加描述",0);
	}

	$shu=array();

	$shu['dengji'] = $_J['dengji'];
	$shu['miaoshu'] = $_J['miaoshu'];
	// $shu['danyuan'] = $_W['danyuan'];
	// $shu['hyid'] = $_W['huiyuan']['id'];
	// $shu['shijian'] = SHIJIAN;
	$k=Gai("he_shanghugoumaizige",$shu,array('hyid' => $_W['huiyuan']['id']));
	if($k){
		json("成功",1);
	}else{
		json("失败",0);
	}
}
mb('goumaizige');
?>