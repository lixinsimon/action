<?php
DengLu();
$cao=empty($_J['c'])?'moren':$_J['c'];	
if($cao=='moren' && $_W['ispost']){
    $zong_e=MX('huiyuan','he')->qu_jifen($_W['huiyuan']['id']);
    json($zong_e,1); 
}elseif($cao=='lie'  && $_W['ispost']){
	$where="and danyuan=:danyuan and huiyuan_id=:huiyuan_id order by shijian DESC";
	$cen=array(':danyuan'=>$_W['danyuan'],':huiyuan_id'=>$_W['huiyuan']['id']);
	$DangQianYe = max(1, intval($_J['ye']));
	$XianJiLu = 10;   
	$yu_elie=ChaQuan('select * from '.BM('he_huiyuan_jifen').'where 1 '.$where.' limit '. ($DangQianYe - 1) * $XianJiLu . ',' . $XianJiLu,$cen);
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
mb('jifen');
?>