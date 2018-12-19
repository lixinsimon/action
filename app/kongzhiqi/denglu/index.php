<?php

if($_W['ispost'] && $cao=='moren'){	
		if(!preg_match("/1{1}\d{10}$/", $_J['zhanghao'])){
			json('手机号错误!',0);
		}
		$mima=mb_strlen($_J['mima'],'UTF8');
		if($mima<6){
			json('密码需要6-20个字符！',0);
		}
		$shu=array('zhanghao'=>trim($_J['zhanghao']),'mima'=>$_J['mima'],'shebeihao'=>$_J['shebeihao']);
		$denglu=MX('huiyuan','he')->AppDengLu($shu);
		if(empty($denglu)){
			json('账号或密码错误！',0);		
		}
		unset($denglu['mima']);		
		json($denglu,1);
}elseif($cao=='xiaochengxu'){	
		if(empty($_J['code'])){
			json('获取code失败',0);
		}
		$shu=MX('xiaochengxu','he')->DengLu($_J);  
		json($shu);
}elseif($cao=='shoujidenglu'){
	  if(!preg_match("/1{1}\d{10}$/", $_J['shouji'])){
	  	json('手机号错误!',0);
	  }
		$shijian=SHIJIAN-1800;
		$ma=Cha('select neirong from '.BM('he_duanxin').' where shouji='.$_J['shouji'].' and shijian>'.$shijian.' order by shijian DESC');
		if($_J['yanzheng']!=$ma['neirong'] || empty($_J['yanzheng'])){
			json('验证码不正确',0);
		}
	  $shu=array('zhanghao'=>trim($_J['shouji']));
	
	  $denglu=MX('huiyuan','he')->AppDengLu($shu);	
	  if($denglu){
	  	unset($denglu['mima']);		
	  	json($denglu,1);
	  	
	  }else{		
	  	json('账号或密码错误！',0);
	  }	
}
mb('denglu');
?>