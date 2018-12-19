<?php
DengLu();
if($cao=='moren' && $_W['ispost']){ 
	
	$wenzhang = ChaQuan('select * from '.BM('he_wenzhang'));
	foreach($wenzhang as $k=>$l){
		$wenzhang[$k]['shijian'] = date('Y-m-d',$wenzhang[$k]['shijian']);
	}
	
	json($wenzhang);
	
}elseif($cao=='lie'  && $_W['ispost']){
	$where="and danyuan=:danyuan order by shijian DESC";
	$cen=array(':danyuan'=>$_W['danyuan']);
	$DangQianYe = max(1, intval($_J['ye']));
	$XianJiLu = 10;   
	$yu_elie=ChaQuan('select * from '.BM('he_wenzhang').'where 1 '.$where.' limit '. ($DangQianYe - 1) * $XianJiLu . ',' . $XianJiLu,$cen);
    foreach($yu_elie as $k=>$y){
    	$fuhao=($y['zhi']<0)?"":'+';
    	$yu_elie[$k]['zhi']=$fuhao.$y['zhi'];
    	$yu_elie[$k]['shijian']=date('Y-m-d H:i:s',$y['shijian']);
    }    
    if($yu_elie){
       json($yu_elie,1);
    }else{
    	json('没有了',0);
    }
    
}

mb('wenzhang')
?>