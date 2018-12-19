<?php
/**
 * [商城开源系统] Copyright (c) 2014 ZhiWi.COM
 *  商城群QQ：628361862  进群下载更新包 交流技术   http://www.ZhiWi.com/.
 */
DengLu();

if($cao=='moren' && $_W['ispost']){
	$ye=Max(1,$_J['ye']);
	$quTiaoShu=$_J['jitiao'];
	$tiaojian='huiyuan_id='.$_W['huiyuan']['id'].' and danyuan='.$_W['danyuan'];
	if($_J['zhuangtai']){
		$tiaojian.=' and zhuangtai='.$_J['zhuangtai'];
	}else{
		$tiaojian.=' and zhuangtai=>0';
	}
	$dingdan_sql='select * from '.BM('he_huiyuan_jifen')." where $tiaojian";
	$dingdan_sql.=' order by shijian DESC  Limit '. ($ye - 1) * $quTiaoShu . ',' . $quTiaoShu;	
	$yongjin=ChaQuan($dingdan_sql);	
	$zhuangtai_wenzi=array('0'=>'待到账','1'=>'已完成');
	if($yongjin)foreach($yongjin as &$yj){
		$yj['zhuangtai_wenzi']=$zhuangtai_wenzi[$yj['zhuangtai']];
		$yj['shijian']=date('Y-m-d H:i',$yj['shijian']);			
	}	
	$shu['lie']=$yongjin;
	$shu['zong']=ChaZongShu('select sum(zhi) from '.BM('he_huiyuan_jifen')." where $tiaojian"); 		
	json($shu);
}	
mb('jifen');
?>