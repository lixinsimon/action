<?php
/**
 * [商城开源系统] Copyright (c) 2014 ZhiWi.COM
 *  商城群QQ：628361862  进群下载更新包 交流技术   http://www.ZhiWi.com/.
 */
DengLu();
$cao=empty($_J['c'])?'moren':$_J['c'];
$yj=MX('huiyuan','he')->BiZongE('yongjin',$_W['huiyuan']['id']);
$pz=MX()->FenXiaoPeiZhi();
if($cao=='moren' && $_W['ispost']){
	
	
	$huiyuan=Cha('select hy.* from '.BM('he_huiyuan').' h left join '.BM('zw_shangcheng_huiyuan').' hy on hy.hyid=h.id where hy.hyid='.$_W['huiyuan']['id']);
	
	$huiyuan['ketixian']=$yj;
	$huiyuan['qidian']=$pz['tixian_e'];
	
	json($huiyuan);
}elseif($cao=='tixian' && $_W['ispost']){
	if(empty($_J['fangshi'])){
		json('请选择提现方式',0);
	}

// 	if(empty($_J['mima'])){
// 		json('密码不能为空',0);
// 	}
	if(empty($_J['jine'])){
		json('金额不能为空',0);
	}
	$pz=MX()->FenXiaoPeiZhi();
	
	if($pz['tixian_e']>$_J['jine']){
		json('小于最低提现额度',0);	
	}
	if($yj<$_J['jine']){
		json('超过可提现额度',0);
	}

	$hy=Cha('select hy.*,h.mima from '.BM('he_huiyuan').' h left join '.BM('zw_shangcheng_huiyuan').' hy on hy.hyid=h.id where hy.hyid='.$_W['huiyuan']['id']);

	if(empty($hy['xingming'])){
		json('您还未实名认证',3);
	}

	

	$zong_e=$_J['jine'];
	
	
	$gengxin=array();
	$shijian=time(); 
// 
//	if($zong_e<$pz['tixian_e'] || empty($zong_e)){		
//		json('提现金额不足',0);
//	}
	


	$dingdanhao=ShengChengDingDanHao('zw_shangcheng_tixian','dingdanhao','TX');
	$shu=array(
	     'dingdanhao'=>$dingdanhao,
	     'danyuan'=>$_W['danyuan'],  
	     'huiyuan'=>$_W['huiyuan']['id'], 
	     'jin_e'=>$zong_e,
//	     'dingdanids'=>$ids,
//	     'duihuan_dingdanids'=>$dh['ids'],
	     'tixianfangshi'=>$_J['fangshi'],
	     'shenqingshijian'=>$shijian,
	     'kaihuming'=>$hy['kaihuming'],	  
	     'kahao'=>$hy['kahao'],	
	     'yinhang'=>$hy['yinhang'],	
	     'kaihuhang'=>$hy['kaihuhang'],
	     'zhuangtai'=>0
	);
	ChaRu('zw_shangcheng_tixian',$shu);
	MX('huiyuan','he')->BiZong_JiaJian('yongjin',$_W['huiyuan']['id'],-$zong_e,'余额提现',$dingdanhao);	
	$shu['shijian']=$shu['shenqingshijian'];
	// MX('api')->TiXianTiXing($shu);        
	
	
	json('申请提现成功，等待平台打款');		
}	
	
mb('tixian');
?>