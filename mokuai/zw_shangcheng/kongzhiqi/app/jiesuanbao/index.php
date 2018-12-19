<?php
if($cao=='moren'){
	$DangQianYe=max(1,$_J['ye']);
	$quTiaoShu=$_J['jitiao'];	
	$tiaojian='danyuan='.$_W['danyuan'];		
	$sql='select * from '.BM('zw_shangcheng_jiesuanbao')." where $tiaojian order by shijian DESC Limit ". ($DangQianYe - 1) * $quTiaoShu . ',' . $quTiaoShu;	
	$shu['lie']=ChaQuan($sql);
	if($shu['lie'])foreach($shu['lie'] as &$l){
		$l['shouyi']=ZiFuChuan_Zhuan_ShuZu($l['shouyi']);
		$bilie=0;
		if($l['shouyi'])foreach($l['shouyi'] as $j){
			if($j['bilie']>$bilie){
				$bilie=$j['bilie'];
			}
		}
		$l['shouyi']=$bilie;
		
	}
	
	$zuotian=strtotime(date('Y-m-d',SHIJIAN-86400));
	$jintian=strtotime(date('Y-m-d',SHIJIAN));
	$tj='zhuangtai=1 and huiyuan_id='.$_W['huiyuan']['id'];
	$shu['zuotian']=ChaZongshu("select sum(zhi) from".BM('he_huiyuan_jifen')." where leixing='jiesuanbao' and shijian>$zuotian and shijian<$jintian and $tj");
	$shu['zonge']=ChaZongshu("select sum(zhi) from".BM('he_huiyuan_jifen')." where $tj");
	$shu['leiji']=ChaZongshu("select sum(zhi) from".BM('he_huiyuan_jifen')." where leixing='jiesuanbao' and zhi>0 and $tj");
	json($shu);
}elseif($cao=='mairu'){
	$shu=Qu('zw_shangcheng_jiesuanbao',array('id'=>$_J['id']));
	$shu['shouyi']=ZiFuChuan_Zhuan_ShuZu($shu['shouyi']);
    json($shu);
}elseif($cao=='shengqingmairu'){
	$_J['shuliang']=intval($_J['shuliang']);
	if($_J['shuliang']%100){
		json('必须是100的倍数',0);
	}	
	$shu=Qu('zw_shangcheng_jiesuanbao',array('id'=>$_J['id']));
	if($_J['shuliang']<$shu['qitou']){
		json('最低投入'.$shu['qitou'],0);
	}		
	$jifen=intval(MX('huiyuan','he')->BiZongE('jifen',$_W['huiyuan']['id']));
	if($_J['shuliang']>$jifen || empty($_J['shuliang'])){
		json('和券不足',0);
	}
	//生成订单号
	$s['dingdanhao'] = ShengChengDingDanHao('zw_shangcheng_jiesuanbao_jilu', 'dingdanhao', 'JSB');     
	$s['danyuan']=$_W['danyuan'];	
	$s['hyid']=$_W['huiyuan']['id'];
	$s['jiesuanbao']=$shu['id'];
	$s['shuliang']=$_J['shuliang'];
	$s['shijian']=SHIJIAN;
	$s['tian']=$shu['tian'];
	// $s['shouyi']=$shu['shouyi'];
	$s['zhuantai']=1;
	ChaRu('zw_shangcheng_jiesuanbao_jilu',$s);
	MX('huiyuan','he')->BiZong_JiaJian('jifen',$s['hyid'],-$s['shuliang'],'购入'.$shu['biaoti'],$s['dingdanhao']);	
	json('买入成功');
}elseif($cao=='jilu'){
	$DangQianYe=max(1,$_J['ye']);
	$quTiaoShu=$_J['jitiao'];	
	$tiaojian='j.danyuan='.$_W['danyuan'].' and j.hyid='.$_W['huiyuan']['id'];		
	$sql="select j.*,b.biaoti from ".BM('zw_shangcheng_jiesuanbao_jilu')." j left join ".BM('zw_shangcheng_jiesuanbao')." b on j.jiesuanbao=b.id where $tiaojian order by j.shijian DESC Limit ". ($DangQianYe - 1) * $quTiaoShu . ',' . $quTiaoShu;	
	$shu['lie']=ChaQuan($sql);
	if($shu['lie'])foreach($shu['lie'] as &$l){
		$l['shijian']=date('Y-m-d H:i',$l['shijian']);
	}elseif($DangQianYe>1){
		json('没有了',0);
	}
	if($DangQianYe>1){
		json($shu['lie']);		
	}
	$shu['zongshu']=ChaZongshu('select count(*) from '.BM('zw_shangcheng_jiesuanbao_jilu')." j where $tiaojian");
	json($shu);
}
?>
