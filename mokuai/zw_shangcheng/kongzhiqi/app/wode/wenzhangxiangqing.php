<?php
if($cao=='moren' && $_W['ispost']){
    $wenzhang = Cha('select * from '.BM('he_wenzhang').' where id = '.$_J['id']);	
	$wenzhang['shijian'] = date('Y-m-d',$wenzhang['shijian']);
	 $wenzhang['neirong'] = htmlspecialchars_decode($wenzhang['neirong']);
	json($wenzhang);
}


mb('wenzhangxiangqing')
?>