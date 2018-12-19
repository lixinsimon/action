<?php


DengLu();
if(empty($_J['d'])){
   XiaoXi('您的权限不够！');
}
$cao=empty($_J['c'])?'moren':$_J['c'];
if($cao=='moren'){
	$peizhi = Cha('select email from ' . BM('he_peizhi') . " where danyuan=" . $_W['danyuan']);	  
    if(empty($peizhi['email'])){
    	$pz=array();
    }else{
    	$pz = ZiFuChuan_Zhuan_ShuZu($peizhi['email']);
    }
 
}elseif($cao=='tianjia'){	
	$shu=array();
	$shu['email']=ShuZu_Zhuan_ZiFuChuan($_J['email']);
	Gai('he_peizhi',$shu,array('danyuan'=>$_W['danyuan']));
	CaoZuoJiLu('EMail配置'); 
	XiaoXi('更新成功');
}

mb("email");
?>