<?php
/**
 * [商城开源系统] Copyright (c) 2014 ZhiWi.COM
 *  商城群QQ：628361862  进群下载更新包 交流技术   http://www.ZhiWi.com/.
 */
DengLu();
if($cao=='moren' && $_W['ispost']){

	$xiaoxi=ChaZongShu('select count(*) from'.BM('he_huiyuan_xiaoxi').' where  hyid='.$_W['huiyuan']['id'].' and danyuan='.$_W['danyuan'].' and leixing=1');
	$xitong=ChaZongShu('select count(*) from'.BM('he_huiyuan_xiaoxi').' where  hyid='.$_W['huiyuan']['id'].' and danyuan='.$_W['danyuan'].' and leixing=2');
	
	$shu=array(
	    'xiaoxi'=>empty($xiaoxi)?0:$xiaoxi,
	    'xitong'=>empty($xitong)?0:$xitong,
	);	
	json($shu);
}
mb('xxiaoxi');
?>