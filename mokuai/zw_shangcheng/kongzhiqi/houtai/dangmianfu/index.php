<?php
DengLu();
$cao=empty($_J['c'])?'moren':$_J['c'];
$mx=MX();
$fenlei=ChaQuan('select * from '.BM('he_shanghu').' where danyuan='.$_W['danyuan']);
if($cao=='moren'){
	$DangQianYe=max(1,$_J['page']);
	
	$tj=' where danyuan ='.$_W['danyuan'];
	if($_J['nicheng']){
		$tj.=' and nicheng='.$_J['nicheng'];
	}
	$shanghulie=ChaQuan('select * from '.BM('he_shanghu') .$tj);
	$zongshu = ChaZongShu('select count(*) from '.BM('he_shanghu') .$tj);
	$quTiaoShu=10;
    $fenye=FenYe($zongshu,$DangQianYe,$quTiaoShu);
}elseif($cao=='xiugai' && $_W['ispost']){
	$kaxinxi = array(
		'ka'=>$_J['ka'],
		'bao'=>$_J['bao'],		
	);
	if(empty($_J['nicheng'])){		
		XiaoXi('店铺名称不能空');
	}
	if(empty($_J['ids'])){
		XiaoXi('修改失败',UHK('dangmianfu/index'));
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
	);
	Gai('he_shanghu',$l,array("danyuan" => $_W['danyuan'],'id'=>$_J['ids']));
	XiaoXi('修改成功',UHK('dangmianfu/index'));
}elseif($cao=='shanchu'){
	if(empty($_J['dangmianfu_id'])){
		XiaoXi('删除失败');
	}
	ShanChu('he_shanghu',array('id'=>$_J['dangmianfu_id']));
	XiaoXi('删除成功');
}elseif($cao=='bianji_'){
	$shanghu = Cha('select * from '.BM('he_shanghu').' where id='.$_J['dangmianfu_id'].' and danyuan = '.$_W['danyuan']);
	$shanghu['kaxinxi']=ZiFuChuan_Zhuan_ShuZu($shanghu['kaxinxi']);	
	$hy=Qu('he_huiyuan',array('id'=>$shanghu['hyid']),'nicheng');
	if(empty($shanghu['kaxinxi'])){
		$shanghu['kaxinxi']=[];
	}
}elseif($cao=='chengerweima'){
	$url = $_W['yuming'] . 'app/index.php?d=' . $_W['danyuan'] . '&m=zw_shangcheng&k=dangmianfu&x=index&sh='. $_J['dangmianfu_id'];
	$erweima = MX('erweima', 'he')->ShengCheng($url);
//	$jiuming=$erweima;
//	$xinming='huancun/erweima/shanghu_'.$_J['dangmianfu_id'].'.png';
//	rename($jiuming,$xinming);
	$erweima = $_W['yuming'] . '/' . $erweima;
	Gai('he_shanghu',array('erweima'=>$erweima),array('id'=>$_J['dangmianfu_id']));
	XiaoXi('生成成功');
}elseif($cao=='jifen'){
	$shuju=Cha('select * from'.BM('zw_dangmianfu_zhuanhua').' where danyuan='.$_W['danyuan'].' and shid='.$_J['dangmianfu_id']);
}elseif($cao=='jiajifen'){
	foreach($_J['jifen'] as $l){
		if(empty($l['jin_e'])){
			XiaoXi('金额不能为空');
		}
		if(empty($l['jifen'])){
			XiaoXi('积分不能为空');
		}
	}
	$m=array(
	'shid'=>$_J['id'],
	'shijian'=>time,
	'zhuanhua'=>ShuZu_Zhuan_ZiFuChuan($_J['jifen']),
	'danyuan'=>$_W['danyuan']
	);
	
	$shuju=Cha('select * from'.BM('zw_dangmianfu_zhuanhua').' where danyuan='.$_W['danyuan'].' and shid='.$_J['id']);
		if($shuju['id']>0){
			Gai('zw_dangmianfu_zhuanhua',$m,array('shid'=>$_J['id']));
			XiaoXi('修改成功');
		}else{
			ChaRu('zw_dangmianfu_zhuanhua',$m);
			XiaoXi('添加成功');
		}
//	
//	if(empty($_J['id'])){
//		
//	}	
		
}elseif($cao=='tixian'){
	
	$DangQianYe=max(1,$_J['page']);
	$zongshu = ChaZongShu('select count(*) from'.BM('he_tixian').' where danyuan='.$_W['danyuan'].' and shanghu='.$_J['dangmianfu_id'].' and leibie=1 order by shijian DESC');
	$shanghulie=ChaQuan('select * from'.BM('he_tixian').' where danyuan='.$_W['danyuan'].' and shanghu='.$_J['dangmianfu_id'].' and leibie=1 order by shijian DESC');
	$zongji=ChaZongShu('select sum(jine) from '.BM('zw_dangmianfu').' where danyuan='.$_W['danyuan'].' and shanghuid='.$_J['dangmianfu_id']);	
	$ketixian=ChaZongShu('select sum(jine) from '.BM('zw_dangmianfu').' where zhuangtai=10 and danyuan='.$_W['danyuan'].' and shanghuid='.$_J['dangmianfu_id'].' and (tixian is null or tixian="")');	
	$leiji=ChaZongShu('select sum(jine) from '.BM('zw_dangmianfu').' where zhuangtai=10 and danyuan='.$_W['danyuan'].' and shanghuid='.$_J['dangmianfu_id'].' and tixian=2');	
	$chuli=ChaZongShu('select sum(jine) from '.BM('zw_dangmianfu').' where zhuangtai=10 and danyuan='.$_W['danyuan'].' and shanghuid='.$_J['dangmianfu_id'].' and tixian=1');	
	$quTiaoShu=10;
    $fenye=FenYe($zongshu,$DangQianYe,$quTiaoShu); 	
	
}elseif($cao=='tiquxianjin'){
	$kaxinxi = Cha('select * from '.BM('he_shanghu').' where id='.$_J['dangmianfu_id'].' and danyuan='.$_W['danyuan']);
	if(empty($kaxinxi['kaxinxi'])){
		XiaoXi('请检查是否填写了收钱账号');
	}
	$kaxinxi['kaxinxi'] = ZiFuChuan_Zhuan_ShuZu($kaxinxi['kaxinxi']);
	$ketixian_e = ChaZongShu('select sum(jine) from '.BM('zw_dangmianfu').' where zhuangtai=10 and danyuan='.$_W['danyuan'].' and shanghuid='.$_J['dangmianfu_id'].' and (tixian is null or tixian="")');
	if(empty($ketixian_e)){
		XiaoXi('没有更多的现金了');
	}
	if(empty($_J['fangshi'])){
		XiaoXi('请选择一个提取现金的方式');
	}
	$l=array();
	$l['shanghu'] = $_J['dangmianfu_id'];
	$l['jine'] = $ketixian_e;
	$l['shijian'] = time();
    $dingdanhao = ShengChengDingDanHao('he_tixian', 'hao', 'TX');
	$l['hao'] = $dingdanhao;
	$l['danyuan'] = $_W['danyuan'];
	$l['fangshi'] = $_J['fangshi'];
	$l['leibie'] = 1;
	$l['zhanghao'] = $kaxinxi['kaxinxi'][$_J['fangshi']];
	ChaRu('he_tixian',$l);
	Gai('zw_dangmianfu',array('tixian'=>1),array('shanghuid'=>$_J['dangmianfu_id'],'danyuan'=>$_W['danyuan']));
	XiaoXi('提现成功，请耐心等待系统转账');
}

mb('index')
?>