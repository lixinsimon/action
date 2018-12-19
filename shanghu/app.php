<?php
require '../neihe/he.php';

$cao=empty($_J['c'])?'moren':$_J['c'];
$_W['sh']=Qu('he_shanghu',array('id'=>$_J['shanghu'],'Zhuangtai'=>1),'danyuan');
$_W['danyuan']=$_W['sh']['danyuan'];
//if($_W['kong']=='gongyou'){		
//require QuXiang('shanghu/'.$_W['kong'].'/'.$_W['xing'].'.php');	
//}elseif(empty($_W['mo'])){
//	require QuXiang('shanghu/kongzhiqi/'.$_W['kong'].'/'.$_W['xing'].'.php');
//}else{
//require QuXiang('mokuai/'.$_W['mo'].'/index.php');	
//}
require QuXiang('mokuai/'.$_W['mo'].'/index.php');	
?>