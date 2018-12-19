<?php
DengLu();
$cao=empty($_J['c'])?'moren':$_J['c'];
if($cao=='moren'){
	// $m='gf_shangcheng';
	
	 require GENMULU.'/houtai/gongyou/quanxian.php';
	 $qx=$quanxian;	 
	 $mk=array(
	     'zw_shangcheng'=>'知微商城',
	     'gf_shangcheng'=>'官方商城'
	     );
	 foreach($mk as $m=>$ming){
	 	require GENMULU.'/mokuai/'.$m.'/quanxian.php';	 
	    $qx[$m]=array($ming,$quanxian);
	 }
	 
	 
	 
	 
	 		
	 $yonghu=Qu('he_guanliyuan',array('id'=>$_J['id']));
	 $danyuan=Qu('he_danyuan',array('id'=>$_W['danyuan']));	
	 $dygl=Qu('he_danyuan_guanliyuan',array('danyuanid'=>$_W['danyuan'],'guanliyuanid'=>$_J['id']));
	 $dygl['quanxian']=explode('|',$dygl['quanxian']);
	 $quanxian=array();
	 foreach($dygl['quanxian'] as $q){
	 	$quanxian[$q]=1;
	 };
	
}elseif($cao=='bianji'){
	$qx='';
	foreach($_J['quanxian'] as $q){
		$qx.=$q.'|';
	};
	$qx=rtrim($qx,'|');	
	Gai('he_danyuan_guanliyuan',array('quanxian'=>$qx),array('id'=>$_J['id']));
	XiaoXi('更新权限成功','shuaxin');
}
mb("quanxian");
?>