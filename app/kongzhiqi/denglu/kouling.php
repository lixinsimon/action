<?php
if(empty($_J['kouling'])){
	json('请重新登录!',0);
}
$shu= ZiFuChuan_Zhuan_ShuZu(JianMi64($_J['kouling']));	
$mx=MX('huiyuan','he');
$kouling=$mx->KouLing($shu);
if($kouling){
	$shu=array('kouling'=>$kouling);
	json($shu,1);
}
json('口令过期了',0);
?>