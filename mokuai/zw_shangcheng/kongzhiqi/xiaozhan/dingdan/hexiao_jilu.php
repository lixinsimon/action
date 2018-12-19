<?php
DengLu();
if($cao=='moren' && $_W['ispost']){
	//$shu=Qu('he_hexiaoyuan',array('hyid'=>$_W['huiyuan']['id']));
	$DangQianYe=max(1,intval($_J['ye']));
	$tiaojian=array('hexiaoyuan'=>$_W['huiyuan']['id'],'zhuangtai'=>30,'danyuan'=>$_W['danyuan']);
	$dingdan=MX()->quDingDanLie($DangQianYe,$_J['jitiao'],$tiaojian);
	if($dingdan['dingdan']){
		foreach($dingdan['dingdan'] as $k=>$l){
			$dingdan['dingdan'][$k]['wanchengshijian']=date('Y-m-d H:i:s',$l['wanchengshijian']);
		}
	}	
	json($dingdan);
	
}
MB('hexiao_jilu');
?>