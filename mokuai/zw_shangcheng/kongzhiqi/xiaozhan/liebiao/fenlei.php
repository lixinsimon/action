<?php
	/**
 * [商城开源系统] Copyright (c) 2014 ZhiWi.COM
 *  商城群QQ：628361862  进群下载更新包 交流技术   http://www.ZhiWi.com/.
 */

if($cao=='moren' && $_W['ispost']){	
	$shu=MX()->QuanFenLei_XiaoZhan(0);		
	if(empty($shu)){
		json('没有分类',0);
	}
	json($shu);	
}
mb('fenlei');
?>