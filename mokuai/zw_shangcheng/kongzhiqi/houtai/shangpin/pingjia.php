<?php
DengLu();
if(empty($_J['d'])){
   XiaoXi('您的权限不够！');
}
$cao=empty($_J['c'])?'moren':$_J['c'];
if($cao=='moren'){
	
}elseif ($cao=="add") {	
	mb("biaoqian/pingjia_add");exit;
}elseif ($cao=="back") {	
	mb("biaoqian/huifu");exit;
}

mb("pingjia");
?>