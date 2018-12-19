<?php
DengLu();
$cao=empty($_J['c'])?'moren':$_J['c'];
if(empty($_J['d'])){
   XiaoXi('您的权限不够！');
}
if($cao=='moren'){
	$peizhi = Cha('select cunchu from ' . BM('he_peizhi') . " where danyuan=" . $_W['danyuan']);	
    $pz = (array) ZiFuChuan_Zhuan_ShuZu($peizhi['cunchu']);  
}elseif($cao=='tianjia'){	
	$shu=array();
	$shu['cunchu']=ShuZu_Zhuan_ZiFuChuan($_J['cunchu']);
	Gai('he_peizhi',$shu,array('danyuan'=>$_W['danyuan']));
	CaoZuoJiLu('存储配置'); 
	XiaoXi('更新成功');
}

mb("cunchu");
?>