<?php
DengLu();
if(empty($_J['d'])){
   XiaoXi('您的权限不够！');
}
$cao=empty($_J['c'])?'moren':$_J['c'];
if($cao=='moren'){
	$DangQianYe=max(1,$_J['page']);
	$quTiaoShu=10;	
	$tianjian='p.danyuan='.$_W['danyuan'];	
	if($_J['dingdan']>0){
		$tianjian.=' and p.dingdan='.$_J['dingdan'];	
	}
	if($_J['shangpin']>0){
		$tianjian.=' and p.shangpin='.$_J['shangpin'];	
	}
	$tj.=$tianjian.' order by shijian DESC  Limit '. ($DangQianYe - 1) * $quTiaoShu . ',' . $quTiaoShu;	
	$pj=ChaQuan('select p.*,s.ming,s.tu,d.dingdanhao,d.zongjia,s.jiage,h.nicheng,h.touxiang from '.BM('zw_shangcheng_pingjia').' p left join '.BM('zw_shangcheng_shangpin').' s on p.shangpin=s.id left join '.BM('zw_shangcheng_dingdan').' d on p.dingdan=d.id left join '.BM('he_huiyuan').' h on p.hyid=h.id where '.$tj);  
    $shu=ChaZongShu('select count(*) from '.BM('zw_shangcheng_pingjia').' where danyuan='.$_W['danyuan']);
    $fenye=FenYe($shu,$DangQianYe,$quTiaoShu);	    
}elseif($cao=="tianjia") {	

}elseif($cao=="huifu") {	
	$tianjian='p.danyuan='.$_W['danyuan'].' and p.id='.$_J['id'];	
	$pj=Cha('select p.*,s.ming,s.tu as shangpintu,d.dingdanhao,d.zongjia,s.jiage,h.nicheng,h.touxiang from '.BM('zw_shangcheng_pingjia').' p left join '.BM('zw_shangcheng_shangpin').' s on p.shangpin=s.id left join '.BM('zw_shangcheng_dingdan').' d on p.dingdan=d.id left join '.BM('he_huiyuan').' h on p.hyid=h.id where '.$tianjian);
   
}elseif($cao=="post"){
	if(empty($_J['huifu']) || empty($_J['id'])){
		XiaoXi('回复不能为空！');exit;
	}
	$shu=array('huifu'=>$_J['huifu'],'huifushijian'=>time());
	Gai('zw_shangcheng_pingjia',$shu,array('id'=>$_J['id'],'danyuan'=>$_W['danyuan']));
	XiaoXi('回复成功！');exit;
}elseif($cao=='shanchu'){
	ShanChu('zw_shangcheng_pingjia',array('id'=>$_J['id'],'danyuan'=>$_W['danyuan']));
	XiaoXi('删除成功！');exit;
}

mb("pingjia");
?>