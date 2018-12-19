<?php
DengLu();
if(empty($_J['d'])){
   XiaoXi('您的权限不够！');
}
$cao=empty($_J['c'])?'moren':$_J['c'];
if($cao=='moren'){
	$peizhi = Cha('select app from ' . BM('he_peizhi') . " where danyuan=" . $_W['danyuan']);	  
    if(empty($peizhi['app'])){
    	$pz=array();
    }else{
    	$pz = ZiFuChuan_Zhuan_ShuZu($peizhi['app']);
    }
 
}elseif($cao=='tianjia'){	
	$shu=array();
	$shu['app']=ShuZu_Zhuan_ZiFuChuan($_J['app']);
	Gai('he_peizhi',$shu,array('danyuan'=>$_W['danyuan']));
	CaoZuoJiLu('更新APP配置'); 
	XiaoXi('更新成功');
}

mb("app");
?>