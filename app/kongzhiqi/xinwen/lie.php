<?php
//DengLu();
$cao = empty($_J['c']) ? 'moren' : $_J['c'];
if ($cao == 'moren' && $_W['ispost']) {
	$where=" danyuan=".$_W['danyuan'].' and suoluetu<>""';
	$fenlei = ChaQuan('select * from'.BM('he_wenzhang_fenlei').' where danyuan='.$_W['danyuan'].' order by shuxu DESC');
	
	if($_J['id']>0){
		$where.=' and leibie='.$_J['id'].' and (suoluetu is not null or suoluetu !="") ';
	}else{
		$where.=' and leibie='.$fenlei[0]['id'].' and (suoluetu is not null or suoluetu !="") ';
	}
	$DangQianYe = max(1, intval($_J['ye']));
	$XianJiLu = 15;   
	$yu_elie=ChaQuan('select shijian,id,suoluetu,yueducishu,biaoti  from '.BM('he_wenzhang').' where '.$where.' order by shijian DESC limit '. ($DangQianYe - 1) * $XianJiLu . ',' . $XianJiLu);
    foreach($yu_elie as $k=>$y){
    	$yu_elie[$k]['shijian']=date('Y-m-d',$y['shijian']);
		$a=explode(',',$y['suoluetu']);
		$yu_elie[$k]['suoluetu'] = $a[0];
    	$yu_elie[$k]['neirong']=htmlspecialchars_decode($y['neirong']);
    }
   json(array('wenzhang'=>$yu_elie,'fenlei'=>$fenlei),1);
}
mb('lie');
?>