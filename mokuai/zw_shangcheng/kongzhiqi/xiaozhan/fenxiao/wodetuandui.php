<?php
/**
 * [商城开源系统] Copyright (c) 2014 ZhiWi.COM
 *  商城群QQ：628361862  进群下载更新包 交流技术   http://www.ZhiWi.com/.
 */
DengLu();
$cao=empty($_J['c'])?'moren':$_J['c'];
$fxpz=MX()->FenXiaoPeiZhi();
$xiaxian=MX()->XiaXian($_W['huiyuan']['id']);
if($cao=='moren' && $_W['ispost']){
	$ye=max(1,$_J['ye']);	
	$hy=array();		
	foreach($xiaxian as $k=>$x){	
		$x['shijian']=date('Y-m-d H:i',$x['shijian']);
		$hy[]=$x;
	}
	
	$count=$_J['jitiao']?$_J['jitiao']:6;	
	$h=array_slice($hy, $count*($ye-1),$count);	
		
	$shu['lie']=$h;	
	$shu['zongshu']=30;
	$shu['zongyongjin']=300.00;
	json($shu);
	
	
}
mb('wodetuandui');
?>