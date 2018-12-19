<?php
global $_W,$_J;

if($_W['ispost']){
	if(empty($_J['username'])){
		Cuo('用户名不能为空！');
	}
	if(empty($_J['password'])){
		Cuo('密码不能为空！');
	}
	if(empty($_J['mobile'])){
		Cuo('手机不能为空！');
	}
	$zhuce=array(
	      'yonghuming'=>trim($_J['username']),
	      'mima'=>md5(trim($_J['password'])),
	      'dianhua'=>intval(trim($_J['mobile'])),
	      'zhuceshijian'=>time(),
	      'zhuangtai'=>0	      
	);
	ChaRu('he_guanliyuan',$zhuce);
	XiaoXi('注册成功',UH('denglu'));
	
}	
mb('index');
?>