<?php
DengLu();
if(empty($_J['d'])){
   XiaoXi('您的权限不够！');
}
$cao=empty($_J['c'])?'moren':$_J['c'];
if($cao=='moren'){
	
	$xiaochengxu_erweima=MX('xiaochengxu','he')->ErWeiMa();	
}
mb('xinxi');
?>