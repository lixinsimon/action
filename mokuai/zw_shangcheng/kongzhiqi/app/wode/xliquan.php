<?php
/**
 * [商城开源系统] Copyright (c) 2014 ZhiWi.COM
 *  商城群QQ：628361862  进群下载更新包 交流技术   http://www.ZhiWi.com/.
 */
DengLu();

if($cao=='moren' && $_W['ispost']){

	$keyong=MX('huiyuan','he')->BiZongE('liquan',$_W['huiyuan']['id']);
	$daidao=ChaZongShu('select sum(zhi) from'.BM('he_huiyuan_liquan').' where  huiyuan_id='.$_W['huiyuan']['id'].' and danyuan='.$_W['danyuan'].' and zhuangtai=0');
	$zong_e=ChaZongShu('select sum(zhi) from'.BM('he_huiyuan_liquan').' where zhi>0 and  huiyuan_id='.$_W['huiyuan']['id'].' and danyuan='.$_W['danyuan']);
	
	$shu=array(
	    'keyong'=>empty($keyong)?0:intval($keyong) ,
	    'daidao'=>empty($daidao)?0:intval($daidao) ,
	    'zong_e'=>intval($daidao)+intval($keyong)
	);	
	json($shu);
}
mb('xliquan');
?>