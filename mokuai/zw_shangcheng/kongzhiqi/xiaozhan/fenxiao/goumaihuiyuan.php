<?php
/**
 * [商城开源系统] Copyright (c) 2014 ZhiWi.COM
 *  商城群QQ：628361862  进群下载更新包 交流技术   http://www.ZhiWi.com/.
 */
DengLu();
$cao=empty($_J['c'])?'moren':$_J['c'];
if($cao=='moren' && $_W['ispost']){
	$ye=max(1,$_J['ye']);
	$Zongshu=$_J['jiazaishu'];	
	$ziduan='id,ming,jiage,tu';
	$tiaojian=array(':zhuangtai'=>1,array('fenxiaodengji>0'));
	$sp=MX()->quQuanShangPin($Zongshu,$ye,$ziduan,$tiaojian);
	if($sp){
		foreach($sp as $k=>$s){
    	    $sp[$k]['href']=UXK("xiangqing",array("id"=>$s["id"]));	       
        }
		json($sp,1);
	}
	json('没有商品',0);
}
mb('goumaihuiyuan');
?>