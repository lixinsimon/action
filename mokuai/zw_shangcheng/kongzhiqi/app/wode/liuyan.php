<?php
/**
 * [商城开源系统] Copyright (c) 2014 ZhiWi.COM
 *  商城群QQ：628361862  进群下载更新包 交流技术   http://www.ZhiWi.com/.
 */	
DengLu();

if($cao=='moren' && $_W['ispost']){
	$shu=Cha('select * from'.BM('zw_shangcheng_liuyan').' where hyid='.$_W['huiyuan']['id']);
	if(empty($shu)){
		json('没有了',0);
	}
	$shu['tu']=ZiFuChuan_Zhuan_ShuZu($shu['tu']);
	json($shu);

}elseif($cao=='baocun' && $_W['ispost']){
	if(empty($_J['liuyan'])){
		json('请写上两句',0);
	}
	$sj['tu']=$_POST['tu'];
	$sj['hyid']=$_W['huiyuan']['id'];
	$sj['danyuan']=$_W['danyuan'];
	$sj['liuyan']=$_J['liuyan'];
	$sj['shijian']=SHIJIAN;	
	ChaRu('zw_shangcheng_liuyan',$sj);	
	json('感谢您对我们关注，我们尽快处理您问题');
}	
mb('liuyan');
?>