<?php
DengLu(true);
if($_W['ispost']){	
//	json(htmlspecialchars_decode($_W['shezhi']['shezhi']['lianxifangshi']));

	$lie=ChaQuan('select id,biaoti from '.BM('he_wenzhang').' where leibie=15 ');
	
	foreach($lie as $k=>$l){
		$lie[$k]['href']=UAK('wenzhang/index',array('id'=>$l['id']));
	}
	$shu['lie']=$lie;
	$shu['kefu']=$_W['shezhi']['shezhi']['dianhua'];
	
	$shu['zhengwen'] = Cha('select id,biaoti,neirong,shijian from  '.BM('he_wenzhang'). ' where _zhuangtai = 1');
	$shu['zhengwen']['shijian'] = date('Y-m-d',$shu['zhengwen']['shijian']);
	$shu['zhengwen']['neirong'] = htmlspecialchars_decode($shu['zhengwen']['neirong']);
	
	json($shu); 
}
	
mb('kefu');
?>