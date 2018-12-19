<?php
$cao=empty($_J['c'])?'moren':$_J['c'];
if($cao=='moren' && $_W['ispost']){	
	$zhanghao=empty($_J['zhanghao'])?'':$_J['zhanghao'];	
	$zhanghao=empty($zhanghao)?$_J['shouji']:$_J['zhanghao'];		
	if(empty($_W['danyuan'])){
		json('缺少D值',0);
	}
	if(!preg_match("/1[34578]{1}\d{9}$/", $_J['shouji'])){
		json('手机号错误!',0);
	}
	if(empty($_J['yanzheng'])){
		json('不能为空！',0);
	}
	
	$qt=Qu('he_huiyuan',array('zhanghao'=>$_J['shouji']),'qita');
	$qita=ZiFuChuan_Zhuan_ShuZu($qt['qita']);
	if($qita['da']){
		if($_J['da']!=$qita['da']){
			json('密保答案有误',0);
		}
	}
	
	
	$shijian=time()-1800;
	$ma=Cha('select neirong,shouji from '.BM('he_duanxin').' where shouji='.$_J['shouji'].' and shijian>'.$shijian.' order by shijian DESC');
	if($_J['yanzheng']!=$ma['neirong']){
		json('验证码不正确',0);
	}
	$mima=mb_strlen($_J['mima'],'UTF8');
	if($mima<6){
		json('密码需要6-20个字符！',0);
	}
	if($_J['mima']!=$_J['querenmima']){
		json('密码不一致！',0);
	}
	$zhaohui=array(
	      'mima'=>md5($_J['mima'])     
	);
	Gai('he_huiyuan',$zhaohui,array('zhanghao'=>$ma['shouji'],'danyuan'=>$_W['danyuan']));	
	Json('重置密码成功',1);
}elseif($cao=='yanzhengma' && $_W['ispost']){
	if(!preg_match("/1[34578]{1}\d{9}/", $_J['shouji'])){
		json('手机号错误!',0);
	}
	
	$is_zhanghao=Cha('select * from '.BM('he_huiyuan').' where danyuan='.$_W['danyuan'].' and zhanghao="'.$_J['shouji'].'"');	
	if(!$is_zhanghao){
		json('此账号不存在！',0);
	}

	$f=MX('duanxin','he')->YanZhengMa($_J['shouji']);	
	if($f){
		json('发送成功');
	}
	json('发送失败',0);
}elseif($cao=='cha' && $_W['ispost']){
	$qt=Qu('he_huiyuan',array('zhanghao'=>$_J['shouji']),'qita');
	$qita=ZiFuChuan_Zhuan_ShuZu($qt['qita']);
	if(empty($qita['wen'])){
		json('无密保',0);
	}
	json($qita);	
}
mb('zhaohui');
?>