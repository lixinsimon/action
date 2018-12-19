<?php
DengLu();
$cao = empty($_J['c']) ? 'moren' : $_J['c'];
if($cao == 'moren'){
	$DangQianYe=max(1,$_J['page']);
	$quTiaoShu=10;	
	$tiaojian .= ' b.danyuan='.$_J['d'];
	if($_J['hao']){
		$tiaojian .= ' and a.hao = "'.$_J['hao'].'"';		
	}
	if($_J['nicheng']){
		$tiaojian .= ' and b.nicheng like "%'.$_J['nicheng'].'%" or b.zhanghao like "%'.$_J['nicheng'].'%" ';		
	}
	if($_J['zhuangtai']){
		$tiaojian .= ' and a.zhuangtai = '.$_J['zhuangtai'];		
	}
	if($_J['shijian']==1){
		$tiaojian .=' and shijian>'.time($_J['kaishi']).' and shijian<='.time($_J['jieshu']);
	}
	$sql='select a.*,b.nicheng,b.zhanghao,b.touxiang from '.BM('he_huiyuan_tixian').' a left join '.BM('he_huiyuan').' b on (a.huiyuan_id=b.id) where '.$tiaojian;
	$tixianlie = ChaQuan($sql);
	$zongshu = ChaZongShu($sql);
    $FenYe=FenYe($zongshu,$DangQianYe,$quTiaoShu); 	
	
}elseif($cao=='xq'){
	$sql='select a.*,b.nicheng,b.zhanghao,b.xingming,b.zhanghao,b.touxiang from '.BM('he_huiyuan_tixian').' a left join '.BM('he_huiyuan').' b on (a.huiyuan_id=b.id) where a.id = '.$_J['id'];
	$tixian = Cha($sql);
}elseif($cao=='xingqingpost'){

	Gai('he_huiyuan_tixian',array('zhuangtai'=>$_J['gai']),array('id'=>$_J['id']));

	XiaoXi('操作成功',UHK('yutixian/index'));
	
}


mb('index')
?>