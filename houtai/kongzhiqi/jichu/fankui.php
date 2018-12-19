<?php 
$cao = empty($_J['c']) ? 'moren' : $_J['c'];
if ($cao == 'moren') {
	$DangQianYe = max(1, $_J['page']);
    $quTiaoShu = 10;
    $tj='danyuan='.$_W['danyuan'];   
  
    $juan=ChaQuan('select f.*,h.nicheng,h.touxiang,h.zhanghao from '.BM('he_fankui').' f left join '.BM('he_huiyuan').' h on h.id=f.fankuiren where h.danyuan='.$_W['danyuan'].' order by f.shijian
	     DESC Limit '.($DangQianYe - 1) * $quTiaoShu.','.$quTiaoShu );
    
    
    
    $zongshu=ChaZongShu("select count(*) from ".BM('he_fankui')." where {$tj} ");
    $fenye = FenYe($zongshu, $DangQianYe, $quTiaoShu);
}elseif ($cao=='shanchu') {
	 ShanChu('he_fankui',array('id'=>$_J['id'],'danyuan'=>$_W['danyuan']));
	 CaoZuoJiLu('删除反馈'); 
	  XiaoXi('删除成功',UH('jichu/fankui'));eixt;
}
mb('fankui');
?>