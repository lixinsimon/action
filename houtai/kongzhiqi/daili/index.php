<?php
DengLu();
$cao=empty($_J['c'])?'moren':$_J['c'];
if($cao=='moren'){	
   $DangQianYe = max(1, intval($_J['page']));
   $XianJiLu = 20;    
   $sql .= " order by zhuceshijian DESC LIMIT " . ($DangQianYe - 1) * $XianJiLu . ',' . $XianJiLu;  
	$tj='where danyuan ='.$_W['danyuan'];
	if($_J['nicheng']){
		$tj.=' and (ming like "%'.$_J['nicheng'].'%" or nicheng like "%'.$_J['nicheng'].'%")';
	}
	if(is_numeric($_J['dengji'])){
		$tj.=' and dengji='.$_J['dengji'];
	}
	$shanghulie=ChaQuan('select * from '.BM('he_daili') .$tj .$sql);	
	$shu=ChaZongShu('select count(*) from '.BM('he_daili') .$tj); 
	foreach($shanghulie as $k=>$l){
		if($l['shiqudaili']){
			$shanghulie[$k]['chengshi']=Cha('select ming,fuji from'.BM('he_dizhiku').' where id='.$l['shiqudaili']);
			$shanghulie[$k]['shengshi']=Cha('select ming from'.BM('he_dizhiku').' where id='.$shanghulie[$k]['chengshi']['fuji']);
		}
	}
    $fenye=FenYe($shu,$DangQianYe,$XianJiLu);
}elseif($cao=='xiugai' && $_W['ispost']){	
	$kaxinxi = array(
		'ka'=>$_J['ka'],
		'bao'=>$_J['bao'],		
	);
	if(empty($_J['nicheng'])){		
		XiaoXi('店铺名称不能空');
	}
	if(empty($_J['ids'])){
		XiaoXi('修改失败',UHK('daili/index'));
	}
	if($_J['jingweidu']){
		$jingweidu = explode(',',$_J['jingweidu']);
	}else{
		$jingweidu = [];
	}
	
	$l = array(
		'logo'=>$_J['logo'],
		'yingyezhao'=>$_J['yingyezhao'],
		'nicheng'=>$_J['nicheng'],
		'dianhua'=>$_J['dianhua'],
		'hyid'=>$_J['hyid'],
		'kaxinxi'=>ShuZu_Zhuan_ZiFuChuan($kaxinxi),
		'QQ'=>$_J['QQ'],
		'youxiang'=>$_J['youxiang'],
		'nicheng'=>$_J['nicheng'],
		'xiangxidizhi'=>$_J['xiangxidizhi'],
		'sheng'=>$_J['sheng'],
		'shi'=>$_J['shi'],
		'xian'=>$_J['xian'],	
		'miaosu'=>$_J['miaosu'],
		'jingdu'=>$jingweidu[0],
		'weidu'=>$jingweidu[1],
		'fenlei'=>$_J['leibie'],
		'guanzhu'=>$_J['guanzhu'],
		'zuihougengxin'=>SHIJIAN,
		'caidantuijian'=>$_J['caidantuijian']
	);
	Gai('he_daili',$l,array("danyuan" => $_W['danyuan'],'id'=>$_J['ids']));
	CaoZuoJiLu('修复代理商信息');
	XiaoXi('修改成功',UHK('daili/index'));
}elseif($cao=='gai' && $_W['ispost']){
	
	if(is_numeric($_J['zhuangtai'])){
		$l['zhuangtai']=intval($_J['zhuangtai']);	
	}
	if(is_numeric($_J['dengji'])){
		$l['dengji']=intval($_J['dengji']);	
	}
	if(is_numeric($_J['muban'])){
		$l['muban']=intval($_J['muban']);	
	}
	if(is_numeric($_J['paixu'])){
		$l['paixu']=intval($_J['paixu']);	
	}
	if($l){
	  Gai('he_daili',$l,array("danyuan" => $_W['danyuan'],'id'=>$_J['id']));
	  json('成功');	
	}
	
}elseif($cao=='shanchu'){
	if(empty($_J['shanghu_id'])){
		XiaoXi('删除失败');
	}
	ShanChu('he_daili',array('id'=>$_J['shanghu_id']));
	CaoZuoJiLu('删除代理商信息');
	XiaoXi('删除成功');
}elseif($cao=='bianji_'){
	$fenlei=ChaQuan('select * from'.BM('zw_shangcheng_feilei').' where fuji_id=0 and danyuan='.$_W['danyuan']);
	$shanghu = Cha('select * from '.BM('he_daili').' where id='.$_J['shanghu_id'].' and danyuan = '.$_W['danyuan']);
	$shanghu['kaxinxi']=ZiFuChuan_Zhuan_ShuZu($shanghu['kaxinxi']);	
	$hy=Qu('he_huiyuan',array('id'=>$shanghu['hyid']),'nicheng');
	if(empty($shanghu['kaxinxi'])){
		$shanghu['kaxinxi']=[];
	}
}elseif($cao=='xiugaixinxi'){
	$p=array(
	'lunbo'=>ShuZu_Zhuan_ZiFuChuan($_J['banner']),
	'zuihougengxin'=>SHIJIAN
	);
	
	Gai('he_daili',$p,array("danyuan" => $_W['danyuan'],'id'=>$_J['shanghu_id']));
	
	XiaoXi('修改成功');
}elseif($cao=='xinxi'){
	$shanghu = Cha('select * from '.BM('he_daili').' where id='.$_J['shanghu_id'].' and danyuan = '.$_W['danyuan']);
	$shanghu['lunbo'] = ZiFuChuan_Zhuan_ShuZu($shanghu['lunbo']);
	if(empty($shanghu['lunbo'])){ 	
		$shanghu['lunbo']=[];
	}	
}


mb('index')
?>