<?php
/**
 * [商城开源系统] Copyright (c) 2014 ZhiWi.COM
 *  商城群QQ：628361862  进群下载更新包 交流技术   http://www.ZhiWi.com/.
 */
DengLu();
$shuju=Cha('select * from'.BM('zw_shangcheng_shezhi').' where danyuan='.$_W['danyuan']);
$feileilie = ZiFuChuan_Zhuan_ShuZu($shuju['fenlei']);
//dump($feileilie['fenlei']);die; 
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
	XiaoXi('更新成功',USK('xitong',array('c'=>$cao)));
}elseif($cao=='fenxiang' && $_W['ispost']){
	$gai_shuju=array('fenxiang'=>ShuZu_Zhuan_ZiFuChuan($_J['fenxiang']));	
	Gai('zw_shangcheng_shezhi',$gai_shuju,$danyuan);
	XiaoXi('更新成功',USK('xitong',array('c'=>$cao)));
}elseif($cao=='jiaoyi' && $_W['ispost']){
	$gai_shuju=array('jiaoyi'=>ShuZu_Zhuan_ZiFuChuan($_J['jiaoyi']));	
	Gai('zw_shangcheng_shezhi',$gai_shuju,$danyuan);
	XiaoXi('更新成功',USK('xitong',array('c'=>$cao)));
}elseif($cao=='tongzhi' && $_W['ispost']){
	$gai_shuju=array('tongzhi'=>ShuZu_Zhuan_ZiFuChuan($_J['tongzhi']));	
	Gai('zw_shangcheng_shezhi',$gai_shuju,$danyuan);
	XiaoXi('更新成功',USK('xitong',array('c'=>$cao)));
}elseif($cao=='muban' && $_W['ispost']){
	$gai_shuju=array('muban'=>$_J['muban']);	
	Gai('zw_shangcheng_shezhi',$gai_shuju,$danyuan);
	XiaoXi('更新成功',USK('xitong',array('c'=>$cao)));
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
}elseif($cao=='tianjiafenlei'){
	$_J['fenlei'][0]['tu']=$_J['tu'];
	if($_J['id']){
		$feileilie['fenlei'][intval(trim($_J['id']))] = $_J['fenlei'];
		$feileilie=ShuZu_Zhuan_ZiFuChuan($feileilie);
//		dump(ZiFuChuan_Zhuan_ShuZu($feileilie));die;
		Gai('zw_shangcheng_shezhi',array('fenlei'=>$feileilie),$danyuan);
		XiaoXi('修改成功');		
	}else{
		if(empty($feileilie['fenlei'])){
			$gai_shuju=array('fenlei'=>$_J['fenlei']);	
			$gai_shuju=ShuZu_Zhuan_ZiFuChuan($gai_shuju);
			Gai('zw_shangcheng_shezhi',array('fenlei'=>$gai_shuju),$danyuan);
			XiaoXi('更新成功');	
		}else{
			$a=ZiFuChuan_Zhuan_ShuZu($feileilie['fenlei']);
			$jj[0]=$_J['fenlei'];
			$gai_shuju=array_merge($jj,$a);
			$gai_shuju=array('fenlei'=>$gai_shuju);	
			$gai_shuju=ShuZu_Zhuan_ZiFuChuan($gai_shuju);
			Gai('zw_shangcheng_shezhi',array('fenlei'=>$gai_shuju),$danyuan);
			XiaoXi('更新成功');	
		}
	}
			
}elseif($cao=='shanchu'){
	unset($feileilie['fenlei'][intval(trim($_J['id']))]);
	$feileilie=ShuZu_Zhuan_ZiFuChuan($feileilie);
	Gai('zw_shangcheng_shezhi',array('fenlei'=>$feileilie),$danyuan);
	XiaoXi('删除成功');		
}elseif($cao=='fenlei2'){
	$bianji_shuju=$feileilie['fenlei'][intval(trim($_J['id']))];
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