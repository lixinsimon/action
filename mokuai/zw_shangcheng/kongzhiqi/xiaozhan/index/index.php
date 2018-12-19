<?php
/**
 * [商城开源系统] Copyright (c) 2014 ZhiWi.COM
 *  商城群QQ：628361862  进群下载更新包 交流技术   http://www.ZhiWi.com/.
 */
//QuanXian();


if($cao=='moren' && $_W['ispost']){
	$lunbo=ZiFuChuan_Zhuan_ShuZu($_W['sh']['lunbo']);
	foreach($lunbo as $l){
		$l['tu']=JueDuiUrl($l['tu']);
		$shu['lunbo'][]=$l;	
	}	
	$remai=array('remai'=>1,'shanghu'=>$_J['sh']);	
	$shu['rementuijian']=MX()->quQuanShangPin(4,1,'',$remai);;	
	json($shu);
}elseif($cao=='jiazaishangpin' && $_W['ispost']){
	$ye=max(1,$_J['ye']);
	$jiazaishu=intval($_J['jiazaishu']);
	$ziduan="id,ming,fenlei_yiji,fenlei_erji,shunxu,danwei,xinpin,tuijian,cuxiao,baoyou,miaosha,kaishishijian,jieshushijian,tu,xijietu,jiage,yuanjia,kucun";
	$tiaojian=array(':tuijian'=>1,':zhuangtai'=>1,'shanghu'=>$_J['sh']);
	$shangpinlie=MX()->quQuanShangPin($jiazaishu,$ye,$ziduan,$tiaojian);
	if(empty($shangpinlie)){
		json('没有了',0);
	}
    foreach($shangpinlie as $k=>$s){
    	$shangpinlie[$k]['href']=UXK("xiangqing",array("id"=>$s["id"]));
    	$shangpinlie[$k]['tu']=JueDuiUrl($s["tu"]);    	
    }
    json($shangpinlie);	
}
mb('index');
?>