<?php
/**
 * [商城开源系统] Copyright (c) 2014 ZhiWi.COM
 *  商城群QQ：628361862  进群下载更新包 交流技术   http://www.ZhiWi.com/.
 */
DengLu();
$cao=empty($_J['c'])?'moren':$_J['c'];
if($cao=='moren' && $_W['ispost']){
	$ye=max(1,$_J['ye']);
	$kehu=MX()->XiaXian($_W['huiyuan']['id'],1,0,0);
	$count=10;
	$kehu=array_slice($kehu, $count*($ye-1),$count);
	foreach($kehu as $k=>$x){
		$kehu[$k]['dingdanshu']=ChaZongShu('select count(*) from '.BM('zw_shangcheng_dingdan').' where danyuan='.$_W['danyuan'].' and huiyuan='.$x['id']);	
		$kehu[$k]['shijian']=date('Y-m-d H:i',$x['shijian']);
	}		
	$shu=array();
	$shu['lie']=$kehu;
		
	if($ye<$count){
		json($shu);
	}else{
		json('没有更多',0);
	}	
}
mb('wodekehu');
?>