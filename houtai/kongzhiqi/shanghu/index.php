<?php
DengLu();
$cao=empty($_J['c'])?'moren':$_J['c'];
$DengJiLie=array('0'=>'普通会员','1'=>'VIP');
$mubanlie=array('0'=>'模板一','1'=>'模板二');

if($cao=='moren'){	
   $DangQianYe = max(1, intval($_J['page']));
   $XianJiLu = 20;    
   $sql .= " order by shijian DESC LIMIT " . ($DangQianYe - 1) * $XianJiLu . ',' . $XianJiLu;  
	$tj='where danyuan ='.$_W['danyuan'];
	if($_J['ming']){
		$tj.=' and (ming like "%'.$_J['ming'].'%" or ming like "%'.$_J['ming'].'%")';
	}
	if(is_numeric($_J['dengji'])){
		$tj.=' and dengji='.$_J['dengji'];
	}
	$shanghulie=ChaQuan('select * from '.BM('he_shanghu') .$tj .$sql);	
	$shu=ChaZongShu('select count(*) from '.BM('he_shanghu') .$tj); 

  $fenye=FenYe($shu,$DangQianYe,$XianJiLu);
}elseif($cao=='xiugai' && $_W['ispost']){	

	if(empty($_J['ming'])){		
		XiaoXi('店铺名称不能空');
	}
	if(empty($_J['id'])){
		XiaoXi('修改失败');
	}
	if($_J['jingweidu']){
		$jingweidu = explode(',',$_J['jingweidu']);
	}else{
		$jingweidu = [];
	}
	
	$l = array(
		'logo'=>$_J['logo'],
		// 'yingyezhao'=>$_J['yingyezhao'],
		'ming'=>$_J['ming'],
		'gongsiming'=>$_J['gongsiming'],
		'dianhua'=>$_J['dianhua'],
		'hyid'=>$_J['hyid'],
		'dizhi'=>$_J['xiangxidizhi'],	
		'shengshiqu'=>$_J['sheng'].' '.$_J['shi'].' '.$_J['xian'],	
		'jianjie'=>$_J['jianjie'],
		'jingdu'=>$jingweidu[0],
		'weidu'=>$jingweidu[1],
		'fenlei'=>$_J['leibie'],
		'guanzhu'=>$_J['guanzhu'],

	);
	Gai('he_shanghu',$l,array("danyuan" => $_W['danyuan'],'id'=>$_J['id']));
	
  CaoZuoJiLu('更新商户信息');  
	XiaoXi('更新成功');
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
	  Gai('he_shanghu',$l,array("danyuan" => $_W['danyuan'],'id'=>$_J['id']));
	  json('成功');	
	}
	
}elseif($cao=='shanchu'){
	if(empty($_J['shanghu_id'])){
		XiaoXi('删除失败');
	}
	ShanChu('he_shanghu',array('id'=>$_J['shanghu_id']));
	  CaoZuoJiLu('删除商户信息');  
	XiaoXi('删除成功');
}elseif($cao=='bianji_'){
	$fenlei=ChaQuan('select * from'.BM('zw_shangcheng_feilei').' where fuji_id=0 and danyuan='.$_W['danyuan']);
	$shanghu = Cha('select * from '.BM('he_shanghu').' where id='.$_J['shanghu_id'].' and danyuan = '.$_W['danyuan']);
	$shanghu['kaxinxi']=ZiFuChuan_Zhuan_ShuZu($shanghu['kaxinxi']);	
	$hy=Qu('he_huiyuan',array('id'=>$shanghu['hyid']));
	$hy['nicheng']=$hy['nicheng']?$hy['nicheng']:$hy['zhanghao'];

}elseif($cao=='xiugaixinxi'){
	$p=array(
	'lunbo'=>ShuZu_Zhuan_ZiFuChuan($_J['banner']),
	'zuihougengxin'=>SHIJIAN
	);
	
	Gai('he_shanghu',$p,array("danyuan" => $_W['danyuan'],'id'=>$_J['shanghu_id']));
	 CaoZuoJiLu('修改商户信息');  
	XiaoXi('修改成功');
}elseif($cao=='xinxi'){
	$shanghu = Cha('select * from '.BM('he_shanghu').' where id='.$_J['shanghu_id'].' and danyuan = '.$_W['danyuan']);
	$shanghu['lunbo'] = ZiFuChuan_Zhuan_ShuZu($shanghu['lunbo']);
	if(empty($shanghu['lunbo'])){ 	
		$shanghu['lunbo']=[];
	}	
}


mb('index')
?>