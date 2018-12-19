<?php
DengLu();
if(empty($_J['d'])){
   XiaoXi('您的权限不够！');
}
QuanXian();
$cao=empty($_J['c'])?'moren':$_J['c'];
if($cao=='moren'){
	//mb("wenzi");
	
}

mb("fensi");
?>