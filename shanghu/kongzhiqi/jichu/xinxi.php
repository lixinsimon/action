<?php
DengLu();
if($cao == 'moren'){
	
	$xinxi = Cha('select * from '.BM('he_shanghu').' where id='.$_W['shanghu']['id'].' and danyuan='.$_W['danyuan']);
	$xinxi['kaxinxi']=ZiFuChuan_Zhuan_ShuZu($xinxi['kaxinxi']);
	if(empty($xinxi['kaxinxi'])){
		$xinxi['kaxinxi']=[];
	}
	
}elseif($cao =='xiugai'){
	
	$p = array('ka'=>$_J['ka'],'bao'=>$_J['bao'],'xin'=>$_J['xin']);
	$l = array();
	$l['nicheng'] = $_J['nicheng'];
	$l['kaxinxi'] = ShuZu_Zhuan_ZiFuChuan($p);
	$l['QQ'] = $_J['QQ'];
	$l['dianhua'] = $_J['dianhua'];
	$l['xiangxidizhi'] = $_J['xiangxidizhi'];
	$l['sheng'] = $_J['sheng'];
	$l['shi'] = $_J['shi'];
	$l['xian'] = $_J['xian'];
	$l['yingyezhao'] = $_J['yinyezhizhao'];
	$l['danyuan'] = $_W['danyuan'];
	$l['logo'] = $_J['logo'];
	$l['youxiang'] = $_J['youxiang'];
	$l['miaosu'] = $_J['miaosu'];	
	Gai('he_shanghu',$l,array('id' => $_W['shanghu']['id']));
	XiaoXi('修改成功');	
//}elseif($cao=='dizhiw'){
//	$dizhi = $_J['dizhi'];
//	for($a=0,$l=count($dizhi);$a<$l;$a++){
//		ChaRu('he_dizhiku',array('ming'=>$dizhi[$a]['n'],'shunxu'=>$a));
//		$shi = $dizhi[$a]['c'];
//		$shengID=ChaRuID();
//		for($b=0,$k=count($shi);$b<$k;$b++){
//			ChaRu('he_dizhiku',array('ming'=>$shi[$b]['n'],'fuji'=>$shengID));
//			$xian = $shi[$b]['a'];
//			$shiID=ChaRuID();
//			for($c=0,$j=count($xian);$c<$j;$c++){
//				ChaRu('he_dizhiku',array('ming'=>$xian[$c],'fuji'=>$shiID));
//			}
//		}
//	}
//	die;
//	
//	
	
}

mb('xinxi')
?>