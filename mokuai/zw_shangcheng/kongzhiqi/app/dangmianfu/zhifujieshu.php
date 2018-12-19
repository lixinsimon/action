<?php


if($cao=='moren' && $_W['ispost']){
	$zongjifen = Cha('select * from'.BM('he_huiyuan').' where danyuan='.$_W['danyuan'].' and id='.$_W['huiyuan']['id']);
	$shuju=ChaQuan('select * from'.BM('zw_dangmianfu').' where danyuan='.$_W['danyuan'].' and shanghuid='.$_J['shid'].' and hyid='.$_W['huiyuan']['id'].' order by shijian DESC');
	foreach($shuju as $k=>$l){
		$shuju[$k]['shijian']=date('Y-m-d',$shuju[$k]['shijian']);	
	}
	
	json(array('shuju'=>$shuju,'jifen'=>$zongjifen['jifen']));
}


mb('zhifujieshu')
?>