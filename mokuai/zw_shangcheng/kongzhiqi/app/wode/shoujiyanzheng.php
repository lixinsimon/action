<?php
DengLu();
$cao=empty($_J['c'])?'moren':$_J['c'];
if($cao=='moren' && $_W['ispost']){
	
}elseif($cao=='yanzhengma'){
	if(!preg_match("/1[34578]{1}\d{9}/", $_J['shouji'])){
		json('手机号错误!',0);
	}	
	$f=MX('duanxin','he')->YanZhengMa($_J['shouji']);	
	if($f){
		json('发送成功');
	}
	json('发送失败',0);
}elseif($cao=='yanzheng'){
	if(empty($_J['yanzheng'])){
		json('验证码不能为空！',0);
	}
	$shijian=time()-1800;
	$ma=Cha('select neirong from '.BM('he_duanxin').' where shouji='.$_J['shouji'].' and shijian>'.$shijian.' order by shijian DESC');
	if($_J['yanzheng']!=$ma['neirong']){
		json('验证码不正确',0);
	}else{
		Gai('he_huiyuan',array('shouji'=>$_J['shouji']),array('id'=>$_W['huiyuan']['id']));
		json('绑定成功！');
	}
}



mb('shoujiyanzheng');
?>