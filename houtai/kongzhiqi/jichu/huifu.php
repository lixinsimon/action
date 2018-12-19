<?php
DengLu();

if($cao=='moren'){
	$x=Qu('he_huifu_xitong',array('danyuan'=>$_W['danyuan']));	
	if(empty($x)){
		ChaRu('he_huifu_xitong',array('danyuan'=>$_W['danyuan']));
	}
	
}elseif($cao=='post'){
	$s=array('guanzhu'=>trim($_J['guanzhu']),'moren'=>trim($_J['moren']));	
	Gai('he_huifu_xitong',$s,array('danyuan'=>$_W['danyuan']));
	CaoZuoJiLu('自定义系统回复'); 
	XiaoXi('更新成功');
}

mb("huifu");
?>