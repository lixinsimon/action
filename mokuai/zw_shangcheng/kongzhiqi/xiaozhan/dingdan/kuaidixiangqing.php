<?php
/**
 * [商城开源系统] Copyright (c) 2014 ZhiWi.COM
 *  商城群QQ：628361862  进群下载更新包 交流技术   http://www.ZhiWi.com/.
 */
DengLu();

$cao=empty($_J['c'])?'moren':$_J['c'];
if($cao=='moren'  && $_W['ispost']){
	if(empty($_J['dingdanid'])){
	   json('找不到快递',0);
	}
	$tianjian=array(':danyuan'=>$_W['danyuan'],':huiyuan'=>$_W['huiyuan']['id'],':id'=>$_J['dingdanid']);
	$dingdan=Cha('select id,kuaidihao,kuaidiming,kuaidiid from '.BM('zw_shangcheng_dingdan').' where danyuan=:danyuan and huiyuan=:huiyuan and id=:id',$tianjian);
	$kuaidi=ChaKuaiDi($dingdan['kuaidiid'],$dingdan['kuaidihao']);
	$kuaidi['ming']=$dingdan['kuaidiming'];
	$kuaidi['hao']=$dingdan['kuaidihao'];
//	$shu=MB('biaoqian/kuaidi','TEMPLATE_FETCH');
	json($kuaidi);
}	
mb('kuaidixiangqing');
?>