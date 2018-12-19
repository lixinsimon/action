<?php
DengLu();
if ($cao == 'moren' && $_W['ispost']) {
	$huiyuan=Qu('zw_shangcheng_huiyuan',array('hyid'=>$_W['huiyuan']['id']),'xingming,shenfenzheng,xiugai');
	if($huiyuan){
		json($huiyuan);
	}else{
		json('错误',0);
	}
	
}elseif($cao == 'renzheng' && $_W['ispost']){
	if(empty($_J['xingming'])){
		json('姓名不能为空',0);
	}
	if(empty($_J['shenfenzheng'])){
		json('身份证不能为空',0); 
	}
	
	$huiyuan=Qu('zw_shangcheng_huiyuan',array('hyid'=>$_W['huiyuan']['id']),'xiugai,xingming,shenfenzheng');
	
	if(empty($huiyuan['xingming'])||empty($huiyuan['xingming']) ){
		Gai('zw_shangcheng_huiyuan',array('xingming'=>$_J['xingming'],'shenfenzheng'=>$_J['shenfenzheng'],'xiugai'=>1),array('hyid'=>$_W['huiyuan']['id']));
		json('保存成功');
	}
	
	
	
	if($huiyuan['xiugai']!=1){
		Gai('zw_shangcheng_huiyuan',array('xingming'=>$_J['xingming'],'shenfenzheng'=>$_J['shenfenzheng'],'xiugai'=>1),array('hyid'=>$_W['huiyuan']['id']));
		json('修改成功');
	}else{
		json('您没有修改权限',0);
	}
	
}	
	
	
mb('shimingrenzheng');
?>