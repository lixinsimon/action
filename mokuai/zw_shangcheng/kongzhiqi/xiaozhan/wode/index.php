<?php
/**
 * [商城开源系统] Copyright (c) 2014 ZhiWi.COM
 *  商城群QQ：628361862  进群下载更新包 交流技术   http://www.ZhiWi.com/.
 */	
DengLu();
$cao=empty($_J['c'])?'moren':$_J['c'];	
if(empty($_W['huiyuan']['id'])){
	XiaoXi('瞎搞~~别乱来...');	exit;
}
if($cao=='moren' && $_W['ispost']){		
	$huiyuan=MX()->quHuiYuan($_W['huiyuan']['id']);			
	$huiyuan['touxiang']=empty($huiyuan['touxiang'])?$_W['yuming'].'/gongyong/images/morentu.png':JueDuiUrl($huiyuan['touxiang']);	
	$huiyuan['kefudianhua']=$_W['shezhi']['shezhi']['dianhua'];
	$huiyuan['hexiao']=Qu('he_hexiaoyuan',array('hyid'=>$_W['huiyuan']['id'],'danyuan'=>$_W['danyuan']),'hexiao');	
	json($huiyuan);
	
}	
mb('wode');
?>