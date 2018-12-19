<?php
/**
 * [商城开源系统] Copyright (c) 2014 ZhiWi.COM
 *  商城群QQ：628361862  进群下载更新包 交流技术   http://www.ZhiWi.com/.
 */
DengLu();
$zhuangtai[0]='兑换中';
$zhuangtai[5]='取消';
$zhuangtai[10]='待支付';
$zhuangtai[20]='待确认收款';
$zhuangtai[30]='完成';
if($cao=='moren'){		
	$ye=Max(1,$_J['ye']);
	$quTiaoShu=$_J['jitiao'];	
	$hyid=$_W['huiyuan']['id'];
	$tiaojian="a.danyuan=".$_W['danyuan']." and a.zhuangtai=0 and a.leixing=".$_J['maimai'];
	if($_J['maimai']){
		$T='a.duifang=b.id';
	}else{
		$T='a.hyid=b.id';			
	}
	
	$sql="select a.*,b.nicheng,b.touxiang from ".BM('zw_shangcheng_jiaoyi')." a left join ".BM('he_huiyuan')." b on $T where $tiaojian ";
	$sql.=' order by a.shijian DESC  Limit '. ($ye - 1) * $quTiaoShu . ',' . $quTiaoShu;		
	$shu=ChaQuan($sql);	
	
	if(empty($shu))json('没有了',0);		
	foreach($shu as &$l){
		$l['shijian']=date('Y-m-d H:i',$l['shijian']);	
		$l['nicheng']=$l['nicheng']?$l['nicheng']:'无名';	
	}
	json($shu);	
}elseif($cao=='jifen'){
	$jifen=MX('huiyuan','he')->BiZongE('jifen',$_W['huiyuan']['id']);
	json($jifen);
}elseif($cao=='chushou'){
	$_J['shuliang']=intval($_J['shuliang']);
	if($_J['shuliang']<=0){
		json('出售数量大于零',0);
	}
	$_J['jiage']=intval($_J['jiage']);
	if($_J['jiage']<=0){
		json('价格大于零',0);
	}
	
	if(empty($_J['shoukuan'])){
		json('请输入收款账号',0);
	}
	$jifen=MX('huiyuan','he')->BiZongE('jifen',$_W['huiyuan']['id']);
	if($_J['shuliang']>$jifen ){
		json('和券不足',0);
	}	
	$shu['dingdanhao'] = ShengChengDingDanHao('zw_shangcheng_jiaoyi', 'dingdanhao', 'JY');
	$shu['danyuan']=$_W['danyuan'];
	$shu['hyid']=$_W['huiyuan']['id'];
	$shu['shuliang']=$_J['shuliang'];
	$shu['jiage']=$_J['jiage'];
	$shu['shoukuan']=trim($_J['shoukuan']);
	$shu['shijian']=SHIJIAN;
	$shu['zhuangtai']=0;
	$shu['leixing']=0;
	ChaRu('zw_shangcheng_jiaoyi',$shu);
	MX('huiyuan','he')->BiZong_JiaJian('jifen',$shu['hyid'],-$shu['shuliang'],'出售和券',$shu['dingdanhao']);
	json('发布成功');
}elseif($cao=='qiugou'){
	$_J['shuliang']=intval($_J['shuliang']);
	if($_J['shuliang']<=0){
		json('出售数量大于零',0);
	}
	$_J['jiage']=intval($_J['jiage']);
	if($_J['jiage']<=0){
		json('价格小于零',0);
	}
	$shu['dingdanhao'] = ShengChengDingDanHao('zw_shangcheng_jiaoyi', 'dingdanhao', 'JY');
	$shu['danyuan']=$_W['danyuan'];
	$shu['duifang']=$_W['huiyuan']['id'];
	$shu['shuliang']=$_J['shuliang'];
	$shu['jiage']=$_J['jiage'];
	$shu['shijian']=SHIJIAN;
	$shu['zhuangtai']=0;
	$shu['leixing']=1;
	ChaRu('zw_shangcheng_jiaoyi',$shu);	
	json('发布成功');
}elseif($cao=='jilu'){	
	$ye=Max(1,$_J['ye']);
	$quTiaoShu=$_J['jitiao'];	
	$hyid=$_W['huiyuan']['id'];
	$tiaojian="danyuan=".$_W['danyuan']." and (hyid=$hyid or duifang=$hyid)";
	$sql="select * from ".BM('zw_shangcheng_jiaoyi')." where $tiaojian ";
	$sql.=' order by shijian DESC  Limit '. ($ye - 1) * $quTiaoShu . ',' . $quTiaoShu;		
	$shu['lie']=ChaQuan($sql);	
	
	if($shu['lie'])foreach($shu['lie'] as &$l){
		$l['shijian']=date('Y-m-d H:i',$l['shijian']);
		$l['maimai']=($l['hyid']==$hyid)?0:1;
		$l['zhuangtai']=$zhuangtai[$l['zhuangtai']];		
	}
	if($ye==1){
		$shu['zongshu']=ChaZongShu('select sum(shuliang) from '.BM('zw_shangcheng_jiaoyi')." where $tiaojian");	
		json($shu);
	}
	if(empty($shu['lie'])){
		json('没有了',0);	}	
	json($shu['lie']);
	
}elseif($cao=='xiangqing'){
	
	if(empty($_J['id'])){
		json('没找到',0);
	}
	$shu=Qu('zw_shangcheng_jiaoyi',"id=".$_J['id']);
	if(empty($shu)){
		json('已被删除了',0);
	}
	
	$shu['shijian']=date('Y-m-d H:i',$shu['shijian']);
	$shu['maimai']=($shu['hyid']==$_W['huiyuan']['id'])?0:1;
  $shu['zhuangtai_wenzi']=$zhuangtai[$shu['zhuangtai']];
	$shu['chushou']=Qu('he_huiyuan',array('id'=>$shu['hyid']));
	$shu['mairu']=Qu('he_huiyuan',array('id'=>$shu['duifang']));
	
	json($shu);
}elseif($cao=='zhuangtai'){
	if(empty($_J['id']) || empty($_J['zhuangtai'])){
		json('没找到',0);
	}
   $s=Qu('zw_shangcheng_jiaoyi',"id=".$_J['id'].' and danyuan='.$_W['danyuan']);
   if(empty($s)){
   	json('已被删除了',0);
   }
	$tiaojian['id']=$_J['id'];
	if($_J['zhuangtai']==5){		
		$shu['zhuangtai']=5;
		$tishi='取消成功';
		MX('huiyuan','he')->BiZong_JiaJian('jifen',$s['hyid'],$s['shuliang'],'交易市场取消挂卖',$s['dingdanhao']);
	}elseif($_J['zhuangtai']==10){
		$shu['zhuangtai']=10;		
		$shu['rengoushijian']=SHIJIAN;	
		if($s['zhuangtai']){json('已经认购',0);}	
		if($s['hyid']==$_W['huiyuan']['id'] || $s['duifang']==$_W['huiyuan']['id']){json('不能是自己',0);}
		if($s['leixing']==1){			
			if(empty($_J['shoukuan'])){
				json('收款账号',0);
			}
			$shu['shoukuan']=$_J['shoukuan'];
			$shu['hyid']=$_W['huiyuan']['id'];
			
			
		}else{
			$shu['duifang']=$_W['huiyuan']['id'];
		}		
		$tishi='认购成功请在30分钟内完成支付';
	}elseif($_J['zhuangtai']==20){
		$shu['zhuangtai']=20;		
		$tishi='耐心等待对方确认收款';
	}elseif($_J['zhuangtai']==30){
		$shu['zhuangtai']=30;
		$shu['wanchengshijian']=SHIJIAN;
		$tishi='交易完成';		
		MX('huiyuan','he')->BiZong_JiaJian('jifen',$s['duifang'],$s['shuliang'],'交易市场购买和券',$s['dingdanhao']);
	}
	if(empty($shu)){
		json('操作失败',0);
	}
	Gai('zw_shangcheng_jiaoyi',$shu,$tiaojian);
	json($tishi);
}

?>