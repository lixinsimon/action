<?php
/**
 * [商城开源系统] Copyright (c) 2014 ZhiWi.CN
 *  商城群QQ：628361862  进群下载更新包 交流技术   http://www.ZhiWi.cn/.
 */
$_W['shezhi']=MX()->quSheZhi();	
if(RUKOUMULU=='houtai' || RUKOUMULU=='shanghu' || RUKOUMULU=='daili'){
	DengLu();
	
	
}else{	

	if(DengLu(true) && !Du('zw_shangcheng_huiyuan')){
		$hy=array('danyuan'=>$_W['danyuan'],'hyid'=>$_W['huiyuan']['id']);		
		$cunzai=Qu('zw_shangcheng_huiyuan',$hy);				
		if(!$cunzai){
			$hy['huiyuanshijian']=SHIJIAN;
			ChaRu('zw_shangcheng_huiyuan',$hy); 
		}else{
			Cun('zw_shangcheng_huiyuan',$cunzai);
		}
	}
	$_W['yangshi']=empty($_W['shezhi']['muban'])?'moren':$_W['shezhi']['muban'];
	$_W['gongyou']=$_W['yuming'].'mokuai/'.$_W['mo'].'/muban/app/'.$_W['yangshi'].'/gongyou';
}
require 'gongyou/'.RUKOUMULU.'_caidan.php';	
require 'gongyou/function.php';
require QuXiang('mokuai/'.$_W['mo'].'/kongzhiqi/'.RUKOUMULU.'/'.$_W['kong'].'/'.$_W['xing'].'.php');	
?>