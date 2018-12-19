<?php
DengLu();
if(empty($_J['d'])){
   XiaoXi('您的权限不够！');
}
$cao=empty($_J['c'])?'moren':$_J['c'];
if($cao=='moren'){
	$x=Qu('he_huifu_xitong',array('danyuan'=>$_W['danyuan']));	
	if(empty($x)){
		ChaRu('he_huifu_xitong',array('danyuan'=>$_W['danyuan']));
	}
	
}elseif($cao=='post'){
	$s=array('guanzhu'=>trim($_J['guanzhu']),'moren'=>trim($_J['moren']));	
	Gai('he_huifu_xitong',$s,array('danyuan'=>$_W['danyuan']));
	XiaoXi('更新成功');
}

mb("huifu");
?>