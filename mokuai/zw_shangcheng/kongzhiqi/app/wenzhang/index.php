<?php
DengLu();
$cao = empty($_J['c']) ? 'moren' : $_J['c'];
if($cao == 'moren' && $_W['ispost']){
	$fenlei=Cha('select *  from '.BM('he_wenzhang')." where  danyuan=".$_W['danyuan']." and id=".$_J['id']." order by id DESC");
	$fenlei['shijian']=date('Y-m-d' ,$fenlei['shijian']);
	$fenlei['neirong']=htmlspecialchars_decode($fenlei['neirong']);
	if($fenlei){
       json($fenlei,1);
    }else{
    	json('没有了',0);
    }
}

mb('index');
?>