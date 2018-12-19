<?php
/**
 * [商城开源系统] Copyright (c) 2014 ZhiWi.COM
 *  商城群QQ：628361862  进群下载更新包 交流技术   http://www.ZhiWi.com/.
 */
DengLu();
$shuju=Cha('select * from'.BM('zw_shangcheng_shezhi').' where danyuan='.$_W['danyuan']);
$feileilie = ZiFuChuan_Zhuan_ShuZu($shuju['fenlei']);
if($feileilie['fenlei']){
	$flag = array();  
	foreach($feileilie['fenlei'] as $v){
	    $flag[] = $v[0]['paixu'];  
	}  
	array_multisort($flag, SORT_ASC, $feileilie['fenlei']);
} 
if(empty($_J['d'])){
   XiaoXiXi('您的权限不够！');
}
QuanXian();
$cao=empty($_J['c'])?'moren':$_J['c'];
$danyuan=array('danyuan'=>$_W['danyuan']);
$sz=$_W['shezhi'];
//Gai('zw_shangcheng_shezhi',array('fenlei'=>$feileilie),$danyuan);
if(empty($sz)){	
	ChaRu('zw_shangcheng_shezhi',$danyuan);	
}
if($cao=='moren' && $_W['ispost']){
	$gai_shuju=array('shezhi'=>ShuZu_Zhuan_ZiFuChuan($_J['shezhi']));	
	Gai('zw_shangcheng_shezhi',$gai_shuju,$danyuan);	
	CaoZuoJiLu('修改基本设置');
	XiaoXi('更新成功',UHK('xitong',array('c'=>$cao)));
}elseif($cao=='fenxiang' && $_W['ispost']){
	$gai_shuju=array('fenxiang'=>ShuZu_Zhuan_ZiFuChuan($_J['fenxiang']));	
	Gai('zw_shangcheng_shezhi',$gai_shuju,$danyuan);
	CaoZuoJiLu('修改分享设置');
	XiaoXi('更新成功',UHK('xitong',array('c'=>$cao)));
}elseif($cao=='jiaoyi' && $_W['ispost']){
	$gai_shuju=array('jiaoyi'=>ShuZu_Zhuan_ZiFuChuan($_J['jiaoyi']));	
	Gai('zw_shangcheng_shezhi',$gai_shuju,$danyuan);
	CaoZuoJiLu('修改交易设置');
	XiaoXi('更新成功',UHK('xitong',array('c'=>$cao)));
}elseif($cao=='tongzhi' && $_W['ispost']){
	$gai_shuju=array('tongzhi'=>ShuZu_Zhuan_ZiFuChuan($_J['tongzhi']));	
	Gai('zw_shangcheng_shezhi',$gai_shuju,$danyuan);
	CaoZuoJiLu('修改通知设置');
	XiaoXi('更新成功',UHK('xitong',array('c'=>$cao)));
}elseif($cao=='muban' && $_W['ispost']){
	$gai_shuju=array('muban'=>$_J['muban']);	
	Gai('zw_shangcheng_shezhi',$gai_shuju,$danyuan);
	CaoZuoJiLu('修改模板设置');
	XiaoXi('更新成功',UHK('xitong',array('c'=>$cao)));
}elseif($cao=='so'){
	$so=trim($_J['so']);
	if(empty($so)){
		json('请输入会员ID/昵称',0);
	}
	if(intval($so)){
		$tj=' and id='.$so;
	}else{
		$tj=' and nicheng like "%'.$so.'%"';
	}
	$hy=Cha('select id,nicheng,touxiang,openid from '.BM('he_huiyuan').' where danyuan='.$_W['danyuan'].$tj);
	if(empty($hy)){
		json('没找到此人',0);
	}
	json($hy);
}
         
$shezhi=empty($sz['shezhi'])?array():$sz['shezhi'];
$fenxiang=empty($sz['fenxiang'])?array():$sz['fenxiang'];
$tongzhi=empty($sz['tongzhi'])?array():$sz['tongzhi'];
$jiaoyi=empty($sz['jiaoyi'])?array():$sz['jiaoyi'];
if($jiaoyi['tixing']){
	$Tx=ChaQuan('select id,nicheng from '.BM('he_huiyuan').' where id in ('.$jiaoyi['tixing'].')');	
}
$muban=empty($sz['muban'])?array():$sz['muban'];
mb("xitong");
?>