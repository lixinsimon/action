<?php
/**
 * [商城开源系统] Copyright (c) 2014 ZhiWi.COM
 *  商城群QQ：628361862  进群下载更新包 交流技术   http://www.ZhiWi.com/.
 */
DengLu();

if($cao=='moren' && $_W['ispost']){
	if(empty($_J['id'])){
		json('缺少订单ID',0);
	}
	$shu['dingdan']=MX()->quDingDan($_J['id'],'erweishuzu');	
	$shu['maijiahaoma']=$_W['shezhi']['shezhi']['dianhua'];	
	$shu['dingdan']['zhuangtai']=intval($shu['dingdan']['zhuangtai']);	
	if($shu['dingdan']['zhuangtai']>=30){
		$shu['dingdan']['ketuihuo']=(SHIJIAN-$shu['dingdan']['wanchengshijian'])<=(86400*15);
	}
	json($shu);
}elseif($cao=='hexiao'){
	$url=UAK('dingdan/hexiao',array('id'=>$_J['id']));
    $erweima = MX('erweima', 'he')->ShengCheng($url);	
	json($_W['yuming'].$erweima);
}
mb('dingdanxiangqing');
?>