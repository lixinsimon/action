<?php
	DengLu(true);
	
		$huiyuan['guanzhu']=1;
		json($huiyuan);
	
	
	if($_W['zhongduan']!='weixin'){
		$huiyuan['guanzhu']=1;
		json($huiyuan);
	}
	if(empty($_W['huiyuan']['openid'])){
		$huiyuan['guanzhu']=0;
		json($huiyuan);
	}
	
	$hy=Qu('he_huiyuan',array('openid'=>$_W['huiyuan']['openid']),'guanzhu');
	if($hy['guanzhu']==0){
		Gai('he_huiyuan',array('guanzhu'=>1),array('openid'=>$_W['huiyuan']['openid']));
		$huiyuan['guanzhu']=0;
		json($huiyuan);
	}else{
		$huiyuan['guanzhu']=1;
		json($huiyuan);
	}
		
//	$huiyuan=MX('weixin','he')->JianChaGuanZhu($_W['huiyuan']['openid']);
//	if(!$huiyuan){	
//		$huiyuan=MX('weixin','he')->JianChaGuanZhu($_W['huiyuan']['openid'],true);		
//	}
//
//	
//	if($huiyuan){
//		json($huiyuan);
//	}else{
//		$huiyuan['guanzhu']=0;
//		json($huiyuan);
//	}
		
?>