<?php
DengLu();
if(empty($_J['d'])){
   XiaoXi('您的权限不够！');
}
$cao=empty($_J['c'])?'moren':$_J['c'];
if($cao=='moren'){
	
}elseif($cao=='anzhuang'){
	mb('biaoqian/kuozhan_tishi');exit;
}

mb('kuozhan');
?>