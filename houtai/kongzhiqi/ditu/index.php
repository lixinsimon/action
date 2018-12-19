<?php
DengLu();
$cao=empty($_J['c'])?'moren':$_J['c'];

if($cao=='moren'){
	$tj='where danyuan ='.$_W['danyuan'];
	$ditulie=ChaQuan('select * from '.BM('he_quyu') .$tj);
}elseif($cao=='shanchu'){
	if(empty($_J['ditu_id'])){
		XiaoXi('删除失败');
	}
	ShanChu('he_quyu',array('id'=>$_J['ditu_id']));
	XiaoXi('删除成功');
	
}elseif($cao=='shanchuxianlu'){
	if(empty($_J['id'])){
		XiaoXi('删除失败');
	}
	ShanChu('zw_jiesong_xianlu',array('id'=>$_J['id']));
	XiaoXi('删除成功');
	
}elseif($cao=='bianji_' || $cao=='tianjia'  &&  $_W['ispost']){
	$shu=ChaQuan('select * from'.BM('he_quyu').' where danyuan='.$_W['danyuan']);
	foreach($shu as $k=>$s){
		$shu[$k]['zuobiao']=ZiFuChuan_Zhuan_ShuZu($s['zuobiao']);
		$shu[$k]['biaozhu']=ZiFuChuan_Zhuan_ShuZu($s['biaozhu']);
	}
   	json($shu);
}elseif($cao=='quyu'){
	$dizhi=substr($_J['zuobiao'],0,strlen($_J['zuobiao'])-1);
	$dizhi = explode(',', $dizhi);
	if($dizhi){
		foreach($dizhi as $k=>$dz){
			$zb= explode('_',$dz);
			$zuobiao[$k]['lat']=$zb[0];
	 		$zuobiao[$k]['lng']=$zb[1];
	  	}

	  	$zuobiao=ShuZu_Zhuan_ZiFuChuan($zuobiao);
	  	
	  	$bz= explode(',',$_J['biaozhu']);

	  	if($bz){
			$biaozhu['lng']=$bz[0];
		 	$biaozhu['lat']=$bz[1];
	  	}
	  	$biaozhu=ShuZu_Zhuan_ZiFuChuan($biaozhu);
	  	
		$shu['danyuan']=$_W['danyuan'];
		$shu['ming']=$_J['ming'];
		$shu['beizhu']=$_J['beizhu'];
		$shu['shijian']=SHIJIAN;
		$shu['zuobiao']=$zuobiao;
		$shu['biaozhu']=$biaozhu;
		ChaRu('he_quyu',$shu);	
		XiaoXi('添加成功');
	}
}elseif($cao=='xianlu'){
	$DangQianYe=max(1,$_J['page']);
	$quTiaoShu=10;	
	$tiaojian .= ' b.danyuan='.$_J['d'];
	
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
	$sql='select a.*,b.ming as qiming,c.ming as zhongming from '.BM('zw_jiesong_xianlu').' a left join '.BM('he_quyu').' b on a.qidiang=b.id left join '.BM('he_quyu').' c on a.zhongdiang=c.id where '.$tiaojian.' ORDER by shijian ASC';
	$xianlu = ChaQuan($sql);
	$zongshu = ChaZongShu($sql);
    $FenYe=FenYe($zongshu,$DangQianYe,$quTiaoShu); 	
}elseif($cao=='jiaxianlu'){
	$quyu=ChaQuan('select * from '.BM('he_quyu').' where danyuan='.$_W['danyuan']);
	if($_J['id']){
		$tiaojian=' a.danyuan='.$_W['danyuan'].' and a.id='.$_J['id'];
		$sql='select a.*,b.ming as qiming,b.id as qiid,c.ming as zhongming,c.id as zhongid from '.BM('zw_jiesong_xianlu').' a left join '.BM('he_quyu').' b on a.qidiang=b.id left join '.BM('he_quyu').' c on a.zhongdiang=c.id where '.$tiaojian;
		$xianlu=Cha($sql);
	}
	
}elseif($cao=='gaixianlu'){
	$shu=array(
		'zhuangtai'=>10,
		'jiage'=>$_J['jiage'],
		'shijian'=>SHIJIAN,
		'danyuan'=>$_W['danyuan'],
		'qidiang'=>$_J['qiid'],
		'zhongdiang'=>$_J['zhongid']	
	);
	if(empty($_J['id'])){
		ChaRu('zw_jiesong_xianlu',$shu);
		XiaoXi('添加成功');
	}else{
		Gai('zw_jiesong_xianlu',$shu,array('id'=>$_J['id']));
		XiaoXi('修改成功');
	}
}

mb('index')
?>