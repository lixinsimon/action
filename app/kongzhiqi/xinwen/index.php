<?php
DengLu();
$cao = empty($_J['c']) ? 'moren' : $_J['c'];
if($cao == 'moren' && $_W['ispost']){
	$fenlei=Cha('select *  from '.BM('he_wenzhang')." where  danyuan=".$_W['danyuan']." and id=".$_J['id']);
	$fenlei['shijian']=date('Y-m-d' ,$fenlei['shijian']);
	
	$fenlei['neirong']=htmlspecialchars_decode($fenlei['neirong']);
	$pregRule = "/<[img|IMG].*?src=[\'|\"](.*?(?:[\.jpg|\.jpeg|\.png|\.gif|\.bmp]))[\'|\"].*?[\/]?>/";
    $fenlei['neirong']= preg_replace($pregRule, '<img src="${1}" style="max-width:100%">',$fenlei['neirong']); 
	
	$a=$fenlei['yueducishu']+1;
	Gai('he_wenzhang',array('yueducishu'=>$a),array('id'=>$_J['id']));
	if($fenlei){
       json($fenlei,1);
    }else{
    	json('没有了',0);
    }
}

mb('index');
?>