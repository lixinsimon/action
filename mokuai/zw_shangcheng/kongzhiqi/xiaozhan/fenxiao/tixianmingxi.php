<?php
/**
 * [商城开源系统] Copyright (c) 2014 ZhiWi.COM
 *  商城群QQ：628361862  进群下载更新包 交流技术   http://www.ZhiWi.com/.
 */
DengLu();
$cao=empty($_J['c'])?'moren':$_J['c'];
if($cao=='moren' && $_W['ispost']){
	$DangQianYe=max(1,$_J['ye']);
	$quTiaoShu=10;
	$shu=array();
//	$zhuangtai=array('daishenhe'=>0,'daidakuan'=>10,'yidakuan'=>20,'wuxiao'=>5);
	$zhuangtai_text=array(0=>'待核审',10=>'待打款',20=>'已打款',5=>'无效');	
	$shijianzu=array(0=>'shenqingshijian',10=>'shenheshijian',20=>'dakuanshijian',5=>'wuxiaoshijian');
	
	
	$tiaojian='danyuan='.$_W['danyuan'].' and huiyuan='.$_W['huiyuan']['id'];
	
	if(is_numeric($_J['zhuangtai'])){		
		$tiaojian.=' and zhuangtai='.$_J['zhuangtai'];
	}
	$shu['lie']=ChaQuan('select * from '.BM('zw_shangcheng_tixian').' where '.$tiaojian.' order by shenqingshijian DESC Limit '. ($DangQianYe - 1) * $quTiaoShu . ',' . $quTiaoShu);	
	$shu['zongshu']=ChaZongShu('select count(*) from '.BM('zw_shangcheng_tixian').' where '.$tiaojian);
	$shu['zongyongjin']=ChaZongShu('select sum(jin_e) from '.BM('zw_shangcheng_tixian').' where '.$tiaojian);
	foreach($shu['lie'] as $k=>$l){
		$shu['lie'][$k]['zhuangtai_text']=$zhuangtai_text[$l['zhuangtai']];
		$sj=$l[$shijianzu[$l['zhuangtai']]];		
		if($sj){
		   $shu['lie'][$k]['shijian']=date('Y-m-d H:i',$sj);
		}else{
			 $shu['lie'][$k]['shijian']=date('Y-m-d H:i',$l['shenqingshijian']);
		}
				
	}
	if($shu['lie']){
		json($shu);
	}else{
		$shu['zongyongjin']=empty($shu['zongyongjin'])?0:$shu['zongyongjin'];
		json($shu,0);
	}
}
	
mb('tixianmingxi');
?>