<?php
DengLu();
$cao=empty($_J['c'])?'moren':$_J['c'];	
if($cao=='moren' && $_W['ispost']){
	$where="and danyuan=:danyuan and hyid=:huiyuan_id order by shijian DESC";
	$cen=array(':danyuan'=>$_W['danyuan'],':huiyuan_id'=>$_W['huiyuan']['id']);
	$DangQianYe = max(1, intval($_J['ye']));
	$XianJiLu = 10;   
	$yu_elie=ChaQuan('select * from '.BM('zw_shangcheng_qiandao').'where 1 '.$where.' limit '. ($DangQianYe - 1) * $XianJiLu . ',' . $XianJiLu,$cen);
    foreach($yu_elie as $k=>$y){
    	$fuhao=($y['jifen']<0)?"":'+';
    	$yu_elie[$k]['jifen']=$fuhao.$y['jifen'];
    	$yu_elie[$k]['shijian']=date('Y-m-d H:i:s',$y['shijian']);
    }    
    
    if($yu_elie){
       json($yu_elie,1);
    }else{
    	json('没有了',0);
    }
}
mb('jilu');
?>