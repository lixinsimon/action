<?php
require '../neihe/he.php';
require './gongyou/hanshu.php';
require './gongyou/daohang.php';
if($_W['kong']!='denglu'){
	DengLu();
}

DanYuan();
$cao=empty($_J['c'])?'moren':$_J['c'];
if($_W['kong']=='gongyou'){		
  require QuXiang('shanghu/'.$_W['kong'].'/'.$_W['xing'].'.php');	
}elseif(empty($_W['mo'])){
	require QuXiang('shanghu/kongzhiqi/'.$_W['kong'].'/'.$_W['xing'].'.php');
}else{
  require QuXiang('mokuai/'.$_W['mo'].'/index.php');	
}

?>