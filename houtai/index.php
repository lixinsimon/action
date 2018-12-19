<?php
require '../neihe/he.php';
require './gongyou/hanshu.php';
require './gongyou/daohang.php';
DanYuan();
DengLu(true);
$cao=$_J['c']?$_J['c']:'moren';
if($_W['kong']=='gongyou'){		
  require QuXiang('houtai/'.$_W['kong'].'/'.$_W['xing'].'.php');	
}elseif(empty($_W['mo'])){
	require QuXiang('houtai/kongzhiqi/'.$_W['kong'].'/'.$_W['xing'].'.php');
	
}else{
  require QuXiang('mokuai/'.$_W['mo'].'/index.php');	
}

?>