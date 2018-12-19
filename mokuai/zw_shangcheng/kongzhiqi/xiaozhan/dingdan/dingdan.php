<?php
/**
 * [商城开源系统] Copyright (c) 2014 ZhiWi.COM
 *  商城群QQ：628361862  进群下载更新包 交流技术   http://www.ZhiWi.com/.
 */
DengLu();
if($cao=='moren'  && $_W['ispost']){
	$DangQianYe=max(1,intval($_J['ye']));
	$tiaojian=array('huiyuan'=>$_W['huiyuan']['id']);
	$zhuangtai=$_J['zhuangtai'];
	if($zhuangtai !='quanbu'){
	   $tiaojian['zhuangtai']=$zhuangtai;
	}
	$dingdan=MX()->quDingDanLie($DangQianYe,$_J['jitiao'],$tiaojian);
	if($dingdan['dingdan']){
		$dingdan['maijiahaoma']=$_W['shezhi']['shezhi']['dianhua'];	
	    json($dingdan);
	}	
	json('没有了',0);
}elseif($cao=='quxiao' && $_W['ispost']){
	if(empty($_J['dingdanid'])){
		json('取消订单失败',0);
	}
	$tiaojian=array('huiyuan'=>$_W['huiyuan']['id'],'id'=>$_J['dingdanid']);	
	if(MX()->gaiDingDanZhuangTai('quxiao',$tiaojian)){
		json('取消订单成功');
	}
	json('取消订单失败',0);
	
}elseif($cao=='shouhuo' && $_W['ispost']){
	if(empty($_J['dingdanid'])){
		json('失败',0);
	}
	$tiaojian=array('huiyuan'=>$_W['huiyuan']['id'],'id'=>$_J['dingdanid']);	
	if(MX()->gaiDingDanZhuangTai('shouhuo',$tiaojian)){
		json('欢迎下次再来');
	}
	json('确认失败',0);
	
}elseif($cao=='tuikuan' && $_W['ispost']){	
	if(empty($_J['dingdanid'])){
		json('失败',0);
	}
	$tiaojian=array('huiyuan'=>$_W['huiyuan']['id'],'id'=>$_J['dingdanid']);	
	if(MX()->gaiDingDanZhuangTai('tuikuan',$tiaojian)){
		json('申请退款成功');
	}
	json('失败',0);
}elseif($cao=='tuihuo' && $_W['ispost']){	
	if(empty($_J['dingdanid'])){
		json('失败',0);
	}
	$tiaojian=array('huiyuan'=>$_W['huiyuan']['id'],'id'=>$_J['dingdanid']);	
	if(MX()->gaiDingDanZhuangTai('tuihuo',$tiaojian)){
		json('申请退换货成功，请耐心等待..');
	}
	json('失败',0);
}
mb('dingdan');
?>