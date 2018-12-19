<?php
/**
 * [商城开源系统] Copyright (c) 2014 ZhiWi.COM
 *  商城群QQ：628361862  进群下载更新包 交流技术   http://www.ZhiWi.com/.
 */
DengLu();
if($cao=='moren' && $_W['ispost']){	
	$ye=Max(1,$_J['ye']);
	$quTiaoShu=$_J['jitiao'];
	if(empty($_J['bi'])){
		$_J['bi']='yongjin';
	}
	if(empty($_J['zhuangtai'])){
		$_J['zhuangtai']=0;
		$tiaojian=' and d.zhuangtai='.$_J['zhuangtai'];
	}elseif($_J['zhuangtai']==100){
		$tiaojian=' and d.zhi>0 and d.zhuangtai>=0';
	}else{
		$tiaojian=' and d.zhuangtai='.$_J['zhuangtai'];
	}
	
	if($_J['leixing']){
		$tiaojian=' and d.leixing="'.$_J['leixing'].'"';
	}
	$dingdan_sql='select d.shuoming,d.zhi,d.dingdanhao,d.shijian,h.nicheng from '.BM('he_huiyuan_'.$_J['bi']).' d left join '.BM('he_huiyuan').' h on d.huiyuan_id=h.id where d.huiyuan_id='.$_W['huiyuan']['id'].' and d.danyuan='.$_W['danyuan'].$tiaojian;
	$dingdan_sql.=' order by d.shijian DESC  Limit '. ($ye - 1) * $quTiaoShu . ',' . $quTiaoShu;		
	$yongjin=ChaQuan($dingdan_sql);	
	$zhuangtai_wenzi=array('0'=>'待到账','1'=>'已完成');
	foreach($yongjin as $k=>$yj){
		$yongjin[$k]['yongjin']=$yj['zhi']; 
		$yongjin[$k]['shijian']=date('Y-m-d H:i',$yj['shijian']);
		$yongjin[$k]['nicheng']=$yj['nicheng']?$yj['nicheng']:'未设定';		
	}	
	$shu['lie']=$yongjin;
	
	$dingdan_sql='select sum(d.zhi) from '.BM('he_huiyuan_'.$_J['bi']).' d left join '.BM('he_huiyuan').' h on d.huiyuan_id=h.id where d.huiyuan_id='.$_W['huiyuan']['id'].' and d.danyuan='.$_W['danyuan'].$tiaojian;

	$shu['zong']=ChaZongShu($dingdan_sql);	
	$shu['zhuangtai']=$_J['zhuangtai'];	
	json($shu);
}	
?>