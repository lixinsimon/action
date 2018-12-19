<?php
DengLu();
$cao=empty($_J['c'])?'moren':$_J['c'];
if(empty($_J['d'])){
   XiaoXi('您的权限不够！');
}
if($cao=='moren'){
	$peizhi = Cha('select duanxin from ' . BM('he_peizhi') . " where danyuan=" . $_W['danyuan']);	
    $pz = ZiFuChuan_Zhuan_ShuZu($peizhi['duanxin']);
  
}elseif($cao=='tianjia'){	
	$shu=array();
	$shu['duanxin']=ShuZu_Zhuan_ZiFuChuan($_J['duanxin']);
	Gai('he_peizhi',$shu,array('danyuan'=>$_W['danyuan']));
	CaoZuoJiLu('短信配置'); 
	XiaoXi('更新成功');
}

mb("duanxin");
?>