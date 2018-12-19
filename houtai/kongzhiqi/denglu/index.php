<?php	
if($cao=='moren' && $_W['ispost']){
	if(empty($_J['username'])){
		XiaoXi('用户名不能空');
	}
	if(empty($_J['password'])){
		XiaoXi('密码不能空');
	}	
	$yonghu=Cha('select * from '.BM('he_guanliyuan').' where yonghuming="'.trim($_J['username']).'" and mima="'.md5(trim($_J['password'])).'"');
  
    if($yonghu){
    	session_start();    	
    	Gai('he_guanliyuan',array('denglushijian'=>SHIJIAN,'denglu_ip'=>GetIp()),array('id'=>$yonghu['id']));    
    	unset($_SESSION['yonghu']);     	    
    	$_SESSION['yonghu']['id']=$yonghu['id'];
    	$_SESSION['yonghu']['yonghuming']=$yonghu['yonghuming'];
    	$_SESSION['yonghu']['denglushijian']=SHIJIAN;
    	$_SESSION['yonghu']['md5']=md5($_SESSION['yonghu']['id'].$_SESSION['yonghu']['yonghuming'].$_SESSION['yonghu']['denglushijian']);  
    	$_SESSION['yonghu']['shenfen']=$yonghu['shenfen'];   	
    	CaoZuoJiLu($yonghu['yonghuming'].'登录成功');   	
    	XiaoXi('登录成功','./index.php?d=12&k=dingdan&x=index&m=zw_shangcheng');    	
    }else{
        XiaoXi('登录失败');    	
    }
}elseif($cao=='qinglihuancun'){		
	Han('wenjian');	
	file_write('HuanCunShiJian',SHIJIAN);	
	CaoZuoJiLu('清理缓存'); 
	XiaoXi('清理缓存成功');exit;   
}

	
if(DengLu(true)){
	TiaoZhuan(UH('danyuan'));exit;
}
mb('index');
?>