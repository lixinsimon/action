<?php

DengLu();

if($cao=='lie' && $_W['ispost']){
	$ye=Max(1,$_J['ye']);
	$quTiaoShu=$_J['jitiao'];

	
	$dingdan_sql='select d.*,h.nicheng from '.BM('he_huiyuan_'.$_J['bi']).' d left join '.BM('he_huiyuan').' h on d.hyid=h.id where d.hyid='.$_W['huiyuan']['id'].' and d.danyuan='.$_W['danyuan'].' and d.leixing='.$_J['leixing'];
	$dingdan_sql.=' order by d.shijian DESC  Limit '. ($ye - 1) * $quTiaoShu . ',' . $quTiaoShu;	

	
	$yongjin=ChaQuan($dingdan_sql);
	foreach($yongjin as $k=>$yj){
		$yongjin[$k]['shijian']=date('Y-m-d H:i', $yj['shijian']);
	}


	$shu['lie']=$yongjin;
	json($shu);
}	
mb('xiaoxilie');
?>