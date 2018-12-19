<?php
/**
 * [商城开源系统] Copyright (c) 2014 ZhiWi.COM
 *  商城群QQ：628361862  进群下载更新包 交流技术   http://www.ZhiWi.com/.
 */
DengLu();
//$huiyuan=shiFenXiaoShang();
if($cao=='moren' && $_W['ispost']){
	$dj=MX()->quHuiYuan($_W['huiyuan']['id']);	
	$pz=MX()->FenXiaoPeiZhi();
//	if(empty($huiyuan)){
//		json('您还是创客',0);
//	}elseif(!empty($huiyuan['kahao'])){
//		$pz['wanshanziliao']=0;
//	}	
	$nicheng=empty($dj['nicheng'])?$dj['zhanghao']:$dj['nicheng'];
	$yj=MX('huiyuan','he')->BiZongE('yongjin',$_W['huiyuan']['id']);
	$daidao=ChaZongShu('select sum(zhi) from'.BM('he_huiyuan_yongjin').' where huiyuan_id='.$_W['huiyuan']['id'].' and danyuan='.$_W['danyuan'].' and zhuangtai=0');
//	$zong_e=ChaZongShu('select sum(zhi) from'.BM('he_huiyuan_yongjin').' where zhi>0 and  huiyuan_id='.$_W['huiyuan']['id'].' and danyuan='.$_W['danyuan'].' and zhuangtai=1');
	$leiji=ChaZongShu('select sum(jin_e) from'.BM('zw_shangcheng_tixian').' where  huiyuan='.$_W['huiyuan']['id'].' and danyuan='.$_W['danyuan'].' and zhuangtai=20');
	$zong_e=floatval($daidao)+floatval($yj);
	
	$shu=array(
	    'ketixian'=>empty($yj)?0:$yj,
	    'zong_e'=>empty($zong_e)?0:$zong_e,
	    'leiji'=>empty($leiji)?0:$leiji,
	    'dengjiming'=>$dj['fenxiaodengjiming'],
	    'daidao'=>empty($daidao)?0:$daidao,
	    'nicheng'=>$nicheng,
	    'wanshanziliao'=>empty($pz['wanshanziliao'])?0:1
	    );	
	json($shu);
}
mb('index');
?>