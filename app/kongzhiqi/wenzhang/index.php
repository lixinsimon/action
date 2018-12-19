<?php
$cao = empty($_J['c']) ? 'moren' : $_J['c'];

if($cao=='moren'){
	$shuju['kongjian']=ChaQuan('select * from'.BM('zw_zhuangxiu_kongjian').' where danyuan='.$_W['danyuan']);
	$shuju['fengge']=ChaQuan('select * from'.BM('zw_zhuangxiu_fengge').' where danyuan='.$_W['danyuan']);
	$shuju['huxing']=ChaQuan('select * from'.BM('zw_zhuangxiu_huxing').' where danyuan='.$_W['danyuan']);
	$shuju['gongzhuang']=ChaQuan('select * from'.BM('zw_zhuangxiu_gongzhuang').' where danyuan='.$_W['danyuan']);
	foreach($shuju['kongjian'] as $k=>$l){
		if($l['tu']){
			$shuju['kongjian'][$k]['tu']=JueDuiUrl($l['tu']);
		}
	}
	
	
	
	json($shuju);
}

mb('index');
?>