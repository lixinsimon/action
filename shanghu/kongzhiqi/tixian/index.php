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
		$tiaojian .= ' and b.nicheng like "%'.$_J['nicheng'].'%"';		
	}
	if($_J['zhuangtai']){
		if($_J['zhuangtai']==1){
			$tiaojian .= ' and a.zhuangtai is null';
		}
		if($_J['zhuangtai']==10){
			$tiaojian .= ' and a.zhuangtai = 10';		
		}
	}
	
	if($_J['shijian']==1){
		$tiaojian .=' and shijian>'.time($_J['kaishi']).' and shijian<='.time($_J['jieshu']);
	}
	$sql='select a.*,b.nicheng from '.BM('he_tixian').' a left join '.BM('he_shanghu').' b on (a.shanghu=b.id) where '.$tiaojian;
	$tixianlie = ChaQuan($sql);
	$zongshu = ChaZongShu($sql);
    $FenYe=FenYe($zongshu,$DangQianYe,$quTiaoShu); 	
	
}elseif($cao=='xq'){
	$sql='select a.*,b.nicheng,b.dianhua from '.BM('he_tixian').' a left join '.BM('he_shanghu').' b on (a.shanghu=b.id) where a.id = '.$_J['id'];
	$tixian = Cha($sql);
}elseif($cao=='xingqingpost'){
	$cha=Cha('select * from'.BM('he_tixian').' where danyuan='.$_W['danyuan'].' and id='.$_J['id']);
	
	if($cha['leibie']==1){
		Gai('zw_dangmianfu',array('tixian'=>2),array('shanghuid'=>$cha['shanghu'],'danyuan'=>$_W['danyuan']));
		Gai('he_tixian',array('zhuangtai'=>10),array('id'=>$_J['id']));
	}else{
		Gai('he_tixian',array('zhuangtai'=>10),array('id'=>$_J['id']));
	}
	XiaoXi('提现成功',USK('tixian/index'));
	
}


mb('index')
?>