<?php
DengLu();
if(empty($_J['d'])){
   XiaoXi('您的权限不够！');
}
$cao=empty($_J['c'])?'moren':$_J['c'];
if($cao=='moren'){
	
}elseif($cao=='bianji'){	
	mb('biaoqian/gong_3');exit;
}

mb('gongzhonghao');
?>