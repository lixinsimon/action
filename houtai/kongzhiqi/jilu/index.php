<?php

$cao=empty($_J['c'])?'moren':$_J['c'];
$leixing=array('1'=>'购买资格','2'=>'余额提现','3'=>'购物消费','4'=>'余额提现');
if($cao=='moren'){
   $DangQianYe = max(1, intval($_J['page']));
   $XianJiLu = 20;
	if($_J['nicheng']){
		$where.=' and b.nicheng like "%'.$_J['nicheng'].'%"';
	}
	if($_J['xuanze']){
		$where.=' and a.shijian>'.$_J['kaishi'].' and a.shijian<'.$_J['jieshushijian'];
	}
   $jilu = ChaQuan('select a.*,b.* from'.BM('he_zhifu_jilu').' a, '.BM('he_huiyuan').' b where a.hyid=b.id and a.danyuan='.$_W['danyuan'].$where.' order by a.shijian ASC  limit '.($DangQianYe-1)*$XianJiLu.','.$XianJiLu);
   foreach($jilu as $n=>$l){
		$jilu[$n]['leixing']=$leixing[$l['leixing']];
	}
   $shu=ChaZongShu('select count(*) from '.BM('he_zhifu_jilu').' where 1 '); 
   $fenye=FenYe($shu,$DangQianYe,$XianJiLu); 
}



	

mb("index");
?>