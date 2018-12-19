<?php
DengLu();
if(empty($_J['d'])){
   XiaoXi('您的权限不够！');
}
QuanXian();

if($cao=='moren'){
	
}elseif ($cao=="jifen") {
	$where="and danyuan=:danyuan and huiyuan_id=:huiyuan_id order by shijian DESC";
	$cen=array(':danyuan'=>$_W['danyuan'],':huiyuan_id'=>$_J['id']);
	$DangQianYe = max(1, intval($_J['page']));
    $XianJiLu = 20;   
	$jifen=ChaQuan('select * from '.BM('he_huiyuan_jifen').'where zhuangtai>=0 '.$where.' limit '. ($DangQianYe - 1) * $XianJiLu . ',' . $XianJiLu,$cen);
	$shu=ChaZongShu('select count(*) from '.BM('he_huiyuan_jifen').' where  zhuangtai>=0  '.$where.'',$cen);	 
	$fenye=FenYe($shu,$DangQianYe,$XianJiLu); 
	mb("biaoqian/huiyuan_3");exit;
}elseif($cao=="yu_e"){
	$where="and danyuan=:danyuan and huiyuan_id=:huiyuan_id order by shijian DESC";
	$cen=array(':danyuan'=>$_W['danyuan'],':huiyuan_id'=>$_J['id']);
	$DangQianYe = max(1, intval($_J['page']));
  $XianJiLu = 20;   
	$jifen=ChaQuan('select * from '.BM('he_huiyuan_yu_e').'where  zhuangtai>=0  '.$where.' limit '. ($DangQianYe - 1) * $XianJiLu . ',' . $XianJiLu,$cen);
	$shu=ChaZongShu('select count(*) from '.BM('he_huiyuan_yu_e').' where  zhuangtai>=0  '.$where.'',$cen);	 
	$fenye=FenYe($shu,$DangQianYe,$XianJiLu);	
	mb("biaoqian/rizhi_yue");exit;
}elseif($cao=="denglu"){
	$where="and danyuan=:danyuan and huiyuan=:huiyuan order by shijian DESC";
	$cen=array(':danyuan'=>$_W['danyuan'],':huiyuan'=>$_J['id']);
	$DangQianYe = max(1, intval($_J['page']));
    $XianJiLu = 20;   
	$denglu=ChaQuan('select * from '.BM('he_denglu_jilu').'where 1 '.$where.' limit '. ($DangQianYe - 1) * $XianJiLu . ',' . $XianJiLu,$cen);
	$shu=ChaZongShu('select count(*) from '.BM('he_denglu_jilu').' where  1 '.$where.'',$cen);	 
	$fenye=FenYe($shu,$DangQianYe,$XianJiLu);	
	mb("biaoqian/rizhi_denglu");exit;
}elseif($cao=="yongjin"){
	$where="and danyuan=:danyuan and huiyuan_id=:huiyuan_id order by shijian DESC";
	$cen=array(':danyuan'=>$_W['danyuan'],':huiyuan_id'=>$_J['id']);
	$DangQianYe = max(1, intval($_J['page']));
    $XianJiLu = 20;   
	$yongjin=ChaQuan('select * from '.BM('he_huiyuan_yongjin').'where  zhuangtai>=0  '.$where.' limit '. ($DangQianYe - 1) * $XianJiLu . ',' . $XianJiLu,$cen);
	$shu=ChaZongShu('select count(*) from '.BM('he_huiyuan_yongjin').' where  zhuangtai>=0  '.$where.'',$cen);	 
	$fenye=FenYe($shu,$DangQianYe,$XianJiLu);	
	$bi='余额';
	mb("biaoqian/rizhi_yongjin");exit;
}elseif($cao=="xunzhang"){
	$where="and danyuan=:danyuan and huiyuan_id=:huiyuan_id order by shijian DESC";
	$cen=array(':danyuan'=>$_W['danyuan'],':huiyuan_id'=>$_J['id']);
	$DangQianYe = max(1, intval($_J['page']));
    $XianJiLu = 20;   
	$yongjin=ChaQuan('select * from '.BM('he_huiyuan_xunzhang').'where  zhuangtai>=0  '.$where.' limit '. ($DangQianYe - 1) * $XianJiLu . ',' . $XianJiLu,$cen);
	$shu=ChaZongShu('select count(*) from '.BM('he_huiyuan_xunzhang').' where  zhuangtai>=0  '.$where.'',$cen);	 
	$fenye=FenYe($shu,$DangQianYe,$XianJiLu);	
	$bi='勋章';
	mb("biaoqian/rizhi_yongjin");exit;
}elseif($cao=="liquan"){
	$where="and danyuan=:danyuan and huiyuan_id=:huiyuan_id order by shijian DESC";
	$cen=array(':danyuan'=>$_W['danyuan'],':huiyuan_id'=>$_J['id']);
	$DangQianYe = max(1, intval($_J['page']));
    $XianJiLu = 20;   
	$yongjin=ChaQuan('select * from '.BM('he_huiyuan_liquan').'where  zhuangtai>=0  '.$where.' limit '. ($DangQianYe - 1) * $XianJiLu . ',' . $XianJiLu,$cen);
	$shu=ChaZongShu('select count(*) from '.BM('he_huiyuan_liquan').' where  zhuangtai>=0  '.$where.'',$cen);	 
	$fenye=FenYe($shu,$DangQianYe,$XianJiLu);	
	$bi='礼券';
	mb("biaoqian/rizhi_yongjin");exit;
}
mb("rizhi");
?>