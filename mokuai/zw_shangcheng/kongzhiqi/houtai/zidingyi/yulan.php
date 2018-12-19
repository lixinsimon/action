<?php
if($cao=='moren'){
	$shu=Qu('zw_shangcheng_zidingyi',array('id'=>$_J['id'],'danyuan'=>$_W['danyuan']));
	$z=ZiFuChuan_Zhuan_ShuZu($shu['shuju']);	
	

	
	if($z){
		foreach($z as $k=>$s){
			$zujian=explode('_',$k);				
			$z[$k]['zujian']=$zujian[0];			
		}
	}
	
}	
mb('yulan');
?>