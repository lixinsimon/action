<?php
DengLu();
$cao = empty($_J['c']) ? 'moren' : $_J['c'];
if ($cao == 'moren' && $_W['ispost']) {
	$where=" danyuan=".$_W['danyuan'];
	if($_J['id']>0){
		$where.=' and leibie='.$_J['id'];
	}
	$DangQianYe = max(1, intval($_J['ye']));
	$XianJiLu = 10;   
	$yu_elie=ChaQuan('select *  from '.BM('he_wenzhang').' where '.$where.' order by shijian DESC limit '. ($DangQianYe - 1) * $XianJiLu . ',' . $XianJiLu);
    foreach($yu_elie as $k=>$y){
    	$yu_elie[$k]['shijian']=date('Y-m-d',$y['shijian']);
    	$yu_elie[$k]['suoluetu']=JueDuiUrl($y['suoluetu']);
    	$yu_elie[$k]['neirong']=htmlspecialchars_decode($y['neirong']);
    }    
    if($yu_elie){
       json($yu_elie,1);
    }else{
    	json('没有了',0);
    }
}elseif($cao == 'fenlei' && $_W['ispost']){
	$fenlei=ChaQuan('select *  from '.BM('he_wenzhang_fenlei')." where  danyuan=".$_W['danyuan']." order by shuxu ASC");
	if($fenlei){
       json($fenlei,1);
    }else{
    	json('没有了',0);
    }
}
mb('lie');
?>