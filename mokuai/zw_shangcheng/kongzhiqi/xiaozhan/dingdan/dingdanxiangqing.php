<?php
/**
 * [商城开源系统] Copyright (c) 2014 ZhiWi.COM
 *  商城群QQ：628361862  进群下载更新包 交流技术   http://www.ZhiWi.com/.
 */
DengLu();
$cao=empty($_J['c'])?'moren':$_J['c'];



if($cao=='moren' && $_W['ispost']){
	if(empty($_J['id'])){
		json('缺少订单ID',0);
	}
	$shu['dingdan']=MX()->quDingDan($_J['id'],'erweishuzu');
	$kuaidi=ChaKuaiDi($dingdan['kuaidiid'],$dingdan['kuaidihao']);
	$shu['kuaidi']=$kuaidi['data'][0];	
	$shu['maijiahaoma']=$_W['shezhi']['shezhi']['dianhua'];		
	json($shu);
}elseif($cao=='hexiao'){
	$url=UXK('dingdan/hexiao',array('id'=>$_J['id']));
    $erweima = MX('erweima', 'he')->ShengCheng($url);	
	json($_W['yuming'].$erweima);
}
mb('dingdanxiangqing');
?>