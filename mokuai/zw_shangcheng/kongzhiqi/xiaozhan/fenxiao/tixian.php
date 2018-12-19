<?php
/**
 * [商城开源系统] Copyright (c) 2014 ZhiWi.COM
 *  商城群QQ：628361862  进群下载更新包 交流技术   http://www.ZhiWi.com/.
 */
DengLu();
$cao=empty($_J['c'])?'moren':$_J['c'];

if($cao=='moren' && $_W['ispost']){
	$yj=MX()->FenXiaoYongJin($_W['huiyuan']['id']);
	$pz=MX()->FenXiaoPeiZhi();
	$shu=array(
	    'ketixian'=>$yj['ketixian'],	    
	    'qidian'=>$pz['tixian_e']	    
	    );
	json($shu);
}elseif($cao=='shenqingtixian' && $_W['ispost']){
	
	if(empty($_J['fangshi'])){
		json('请选择提现方式',0);
	}
	$pz=MX()->FenXiaoPeiZhi();
	$yj=ChaQuan('select yongjin,zhuangtai,id,wanchengshijian from '.BM('zw_shangcheng_dingdan').' where danyuan='.$_W['danyuan'].' and zhuangtai>=30 and dailiren like "%_'.$_W['huiyuan']['id'].'_%"');
	$zong_e=0;
	$ids='';
	$gengxin=array();
	$shijian=time(); 
    if(empty($pz['jiesuantian'])){
	   $pz['jiesuantian']=0;
	}
	foreach($yj as $j){
		$j['yongjin']=ZiFuChuan_Zhuan_ShuZu($j['yongjin']);	
		$wanchengshijian=empty($j['wanchengshijian'])?$shijian:$j['wanchengshijian'];
		$sj=$shijian-$wanchengshijian;    				
		$jiesuan=86400*$pz['jiesuantian'];  
		if(empty($j['yongjin']['zhuangtai'.$_W['huiyuan']['id']]) && $sj>=$jiesuan){
			$j['yongjin']['zhuangtai'.$_W['huiyuan']['id']]=1;
			$gengxin[$j['id']]=$j['yongjin'];
			$zong_e+=$j['yongjin'][$_W['huiyuan']['id']];
			$ids.=$j['id'].','	;		
		}		  		
	} 	
	if($_W['shezhi']["jiaoyi"]["shangpiao"]){
		$dh=MX('moxing','zw_duihuan')->TiXian($_W['huiyuan']['id']);		
		$zong_e+=$dh['zong_e'];		
	}	
	if($zong_e<$pz['tixian_e'] || empty($zong_e)){		
		json('提现金额不足',0);
	}
	$ids=rtrim($ids,',');
	$hy=Cha('select kaihuming,kahao,yinhang,kaihuhang,zhifubao_zhanghao,zhifubao_ming from '.BM('zw_shangcheng_huiyuan').' where hyid='.$_W['huiyuan']['id']);
	if($_J['fangshi']=='yinhang'){
		if(empty($hy['kahao']) || empty($hy['kaihuming'])){
			json('银行卡信息不完整',0);
		}
	}elseif($_J['fangshi']=='zhifubao'){
		if(empty($hy['zhifubao_zhanghao']) || empty($hy['zhifubao_ming'])){
			json('支付宝信息不完整',0);
		}
		$hy['kahao']=$hy['zhifubao_zhanghao'];
		$hy['kaihuming']=$hy['zhifubao_ming'];
	}
	$dingdanhao=ShengChengDingDanHao('zw_shangcheng_tixian','dingdanhao','TX');
	$shu=array(
	     'dingdanhao'=>$dingdanhao,
	     'danyuan'=>$_W['danyuan'],  
	     'huiyuan'=>$_W['huiyuan']['id'], 
	     'jin_e'=>$zong_e,
	     'dingdanids'=>$ids,
	     'duihuan_dingdanids'=>$dh['ids'],
	     'tixianfangshi'=>$_J['fangshi'],
	     'shenqingshijian'=>time(),
	     'kaihuming'=>$hy['kaihuming'],	  
	     'kahao'=>$hy['kahao'],	
	     'yinhang'=>$hy['yinhang'],	
	     'kaihuhang'=>$hy['kaihuhang'],
	     'zhuangtai'=>0	  
	     );
	ChaRu('zw_shangcheng_tixian',$shu);
	foreach($gengxin as $k=>$g){
		Gai('zw_shangcheng_dingdan',array('yongjin'=>ShuZu_Zhuan_ZiFuChuan($g)),array('id'=>$k));
	}
	if($dh['gengxin']){
		foreach($dh['gengxin'] as $k=>$g){
		Gai('zw_duihuan_dingdan',array('yongjin'=>ShuZu_Zhuan_ZiFuChuan($g)),array('id'=>$k));
	   }
	}	
	json('申请提现成功',1);	
}	
	
mb('tixian');
?>