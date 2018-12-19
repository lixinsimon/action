<?php
/**
 * [商城开源系统] Copyright (c) 2014 ZhiWi.COM
 *  商城群QQ：628361862  进群下载更新包 交流技术   http://www.ZhiWi.com/.
 */
DengLu();
$huiyuan=shiFenXiaoShang();
if($cao=='moren' && $_W['ispost']){		
	$yj=MX()->FenXiaoYongJin($_W['huiyuan']['id']);
	$dj=MX()->quHuiYuan($_W['huiyuan']['id']);	
	$pz=MX()->FenXiaoPeiZhi();
	if(empty($huiyuan)){
		json('您还是创客',0);
	}elseif(!empty($huiyuan['kahao'])){
		$pz['wanshanziliao']=0;
	}	
	$nicheng=empty($dj['nicheng'])?$dj['zhanghao']:$dj['nicheng'];
	$gg=Qu('gf_shangsheng_fenxiao_peizhi',array('danyuan'=>$_W['danyuan']),'gonggao');
	$gonggao=ZiFuChuan_Zhuan_ShuZu($gg['gonggao']);
	$shu=array(
	    'ketixian'=>$yj['ketixian'],
	    'zong_e'=>$yj['zong_e'],
	    'dengjiming'=>$dj['fenxiaodengjiming'],
	    'nicheng'=>$nicheng,
	    'gonggao'=>$gonggao,
	    'wanshanziliao'=>empty($pz['wanshanziliao'])?0:1
	    );	
	json($shu);
}
mb('index');
?>