<?php
/**
 * [商城开源系统] Copyright (c) 2014 ZhiWi.COM
 *  商城群QQ：628361862  进群下载更新包 交流技术   http://www.ZhiWi.com/.
 */
//QuanXian();



DengLu();
if($cao=='moren' &&  $_W['ispost']){	
	$shu=MX()->ZiDingYi('index');
	$shu['huiyuan']=Qu('he_huiyuan',array('id'=>$_W['huiyuan']['id']));		
	$shu['caidan']=$caidan;
	$shu['t']=$_W['huiyuan']['id'];
	json($shu);
	
}elseif($cao=='jiazaishangpin' && $_W['ispost']){
	$ye=max(1,$_J['ye']);
	$jiazaishu=intval($_J['jiazaishu']);
	$ziduan="id,ming,fenlei_yiji,fenlei_erji,shunxu,danwei,xinpin,tuijian,cuxiao,baoyou,miaosha,kaishishijian,jieshushijian,tu,xijietu,jiage,yuanjia,kucun";
	$tiaojian=array(':tuijian'=>1,':zhuangtai'=>1);
	$shangpinlie=MX()->quQuanShangPin($jiazaishu,$ye,$ziduan,$tiaojian);
	if(empty($shangpinlie)){
		json('没有了',0);
	}
    foreach($shangpinlie as $k=>$s){
    	$shangpinlie[$k]['href']=UAK("xiangqing",array("id"=>$s["id"]));
    	$shangpinlie[$k]['tu']=JueDuiUrl($s["tu"]);    	
    }
    json($shangpinlie);	
}

?>