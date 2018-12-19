<?php


if($_J['t']){
	$shu['danyuan']=$_W['danyuan'];
	$shu['hyid']=$_J['t'];
	$shu['ip']=GetIp();
	$shu['shijian']=SHIJIAN;
	ChaRu('he_huancun',$shu);
}
if($_W['zhongduan']=='weixin' ){
	mb('xiazhai');
}else{
	TiaoZhuan('https://fir.im/v48j');
}
	
// 	if($cao=='uuu'){
// 		mb('xiazhai');
// 	}else{
// 		
// 	}
?>