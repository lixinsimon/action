<?php
DengLu();
if($cao=='moren'){
	$shanghu=Qu('he_shanghu',array('hyid'=>$_W['huiyuan']['id']));
	if(empty($shanghu)){
		json('您还没有创建店铺哦！',-2);
	}elseif(empty($shanghu['zhuangtai'])){
		json('审核中，耐心等待..',-3);
	}	
	$shanghu['logo']=JueDuiUrl($shanghu['logo']);
	$shanghu['keti']=$yj=MX('huiyuan','he')->BiZongE('yongjin',$_W['huiyuan']['id']);
	$shanghu['keti']=$shanghu['keti']?$shanghu['keti']:0.00;
	
	$shanghu['leiji']=ChaZongShu('select sum(zhi) from'.BM('he_huiyuan_yongjin').' where zhi>0 and  huiyuan_id='.$_W['huiyuan']['id'].' and danyuan='.$_W['danyuan'].' and zhuangtai=1');
	$shanghu['leiji']=$shanghu['leiji']?$shanghu['leiji']:0.00;
	
	$shanghu['jifen']=ChaZongShu('select sum(sp.songjifen) from '.BM('zw_shangcheng_dingdan').' d right join '.BM('zw_shangcheng_dingdan_shangpin').' sp on d.id=sp.dingdanid where d.zhuangtai>=10 and d.danyuan='.$_W['danyuan'].' and d.shanghu='.$shanghu['id']);
	$shanghu['jifen']=$shanghu['jifen']?$shanghu['jifen']:0.00;
	json($shanghu);
}elseif($cao=='shengqing'){
	$shanghu=MX('huiyuan','he')->ShangHu($_W['huiyuan']['id']);
	json($shanghu);
}elseif($cao=='jifen'){
	  $ye=Max(1,$_J['ye']);
	  $quTiaoShu=$_J['jitiao'];	
		$shanghu=Qu('he_shanghu',array('hyid'=>$_W['huiyuan']['id']));
		$tiaojian=' sp.songjifen>0 and d.shanghu='.$shanghu['id'].' and d.danyuan='.$_W['danyuan'];	
		if($_J['zhuangtai']==1){
			$tiaojian.=' and d.zhuangtai>=30 and d.shanghu_jiesuan=0 ';//末结算
		}elseif($_J['zhuangtai']==2){
			$tiaojian.=' and d.zhuangtai>=10 and d.zhuangtai<30 and d.shanghu_jiesuan=0';//已结算
		}else{
			$tiaojian.=' and d.zhuangtai>=10';//累计结算
		}
	  $dingdan_sql=$tiaojian.' order by d.xiadanshijian DESC  Limit '. ($ye - 1) * $quTiaoShu . ',' . $quTiaoShu;

		
		$shu['lie']=ChaQuan('select sp.dingdanhao,sp.songjifen,d.xiadanshijian from '.BM('zw_shangcheng_dingdan').' d left join '.BM('zw_shangcheng_dingdan_shangpin').' sp on d.id=sp.dingdanid where '.$dingdan_sql);	
	
		if($shu['lie'])foreach($shu['lie'] as &$l){
			   $l['xiadanshijian']=date('Y-m-d H:i',$l['xiadanshijian']);
		}    
	$shu['zonge']=ChaZongShu('select sum(sp.songjifen) from '.BM('zw_shangcheng_dingdan').' d right join '.BM('zw_shangcheng_dingdan_shangpin').' sp on d.id=sp.dingdanid where '.$tiaojian);
		$shu['zonge']=$shu['zonge']?$shu['zonge']:0.00;
		json($shu);
		
		
}elseif($cao=='shezhi'){
	 if($_J['logo']){
		   $shu['logo']=$_J['logo'];
	 }
	 if($_J['ming']){
	 		$shu['ming']=trim($_J['ming']);
	 }
	 if($_J['logo']){
	 		$shu['jianjie']=trim($_J['jianjie']);
	 }
	 Gai('he_shanghu',$shu,array('hyid'=>$_W['huiyuan']['id']));
	 json('更新成功');
}
?>