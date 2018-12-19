<?php	
if(DengLu(true)){
	TiaoZhuan(US('danyuan'));
}
if($_W['ispost']){
	if(empty($_J['zhanghao'])){
		XiaoXi('用户名不能空');
	}
	if(empty($_J['mima'])){
		XiaoXi('密码不能空');
	}	
	$shanghu=Cha('select * from '.BM('he_shanghu').' where zhanghao="'.trim($_J['zhanghao']).'" and mima="'.md5(trim($_J['mima'])).'"');
   
  
    if($shanghu){
    	session_start();    	
    	Gai('he_shanghu',array('shangcidenglu'=>SHIJIAN,'denglu_ip'=>GetIp()),array('id'=>$shanghu['id']));    
    	unset($_SESSION['shanghu']);     	    
    	$_SESSION['shanghu']['id']=$shanghu['id'];
    	$_SESSION['shanghu']['zhanghao']=$shanghu['zhanghao'];
    	$_SESSION['shanghu']['nicheng']=$shanghu['nicheng'];
    	$_SESSION['shanghu']['denglushijian']=SHIJIAN;    	
    	$_SESSION['shanghu']['md5']=md5($_SESSION['shanghu']['id'].$_SESSION['shanghu']['zhanghao'].$_SESSION['shanghu']['denglushijian']);  
     	$_SESSION['danyuan']= $shanghu['danyuan']; 	
    	XiaoXi('登录成功',US('danyuan/xinxi',array('d'=>$shanghu['danyuan'])));    	
    }else{
        XiaoXi('登录失败');    	
    }
}
mb('index');
?>