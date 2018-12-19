<?php
/**
 * [商城开源系统] Copyright (c) 2014 ZhiWi.CN
 *  商城群QQ：628361862  进群下载更新包 交流技术   http://www.ZhiWi.cn/.
 */

if($_W['ispost']){	
	$id=intval($_J['id']);
    $shangpin=MX()->quShangPin($id);
	$guige=MX()->quGuiGe($id);	
	foreach($guige['guige_zu'] as $k=>$z){
		$g[$k]=$z;
		foreach($guige['guige'] as $gg){			
		   if($z['guigezu_id']==$gg['guigezu_id']){
		       $gg['guige_tu']=JueDuiUrl($gg['guige_tu']);
		   	   $g[$k]['haizi'][]=$gg;
		   }
	   }
	}
	
	$shanghu['geshu']=ChaZongShu('select count(*) from'.BM('zw_shangcheng_shangpin').' where shanghu='.$shangpin['shanghu']);
	$shanghu['ziliao'] = Qu('he_shanghu',array('id'=>$shangpin['shanghu']));
	$shanghu['dongtai']=ChaZongShu('select count(*) from'.BM('zw_shanghu_zixun').' where shanghu='.$shangpin['shanghu']);
	
	foreach($guige['guige_xuanze'] as $k=>$z){
		$guige_xuanze[$z['guige_xuanze_id']]=$z;
	}
	unset($guige);
    $quanXian=iS($shangpin,$_W); 
    if($shangpin['jieshushijian']){
    	$shangpin['jieshu']=date('Y-m-d H:i:s', $shangpin['jieshushijian']);  
    }
    
    if($shangpin['xijietu']){
    	$a[]=$shangpin['tu'];
    	$shangpin['xijietu']=array_merge($a,$shangpin['xijietu']);
    }
  
    $shoucang=Qu('zw_shangcheng_shoucang',array('danyuan'=>$_W['danyuan'],'huiyuan'=>$_W['huiyuan']['id'],'shangpin'=>$shangpin['id']),'id'); 
  	
	$pregRule = "/<[img|IMG].*?src=[\'|\"](.*?(?:[\.jpg|\.jpeg|\.png|\.gif|\.bmp]))[\'|\"].*?[\/]?>/";
    $shangpin['xiangqing']= preg_replace($pregRule, '<img src="${1}" style="max-width:100%">',$shangpin['xiangqing']);  
	json(array('shangpin'=>$shangpin,'guige'=>$g,'guige_xuanze'=>$guige_xuanze,'shoucang'=>$shoucang,'shanghu'=>$shanghu),$quanXian);
}
mb('xiangqing');

//$quanXian = 1; // 1.正常,-1.未登录 ,-2.库存不足,-3.购买权限角色不够，-4.超过购买数量
function iS($shangpin,$_W){
	if(!DengLu(true)){
		return -1;
	}	
	if($shangpin['kucun']<=0){
    	return -2;
   }	
 
	//判断会员角色是否购
	$hy = MX()->quHuiYuan($_W['huiyuan']['id']);      
    if($shangpin['goumaiquanxian'] > $hy['dengji'] && $shangpin['goumaiquanxian']){
        return -3;
    }
     
	//最多购买数量
	$maishu=ChaZongShu('select sum(shuliang) from '.BM('zw_shangcheng_dingdan_shangpin').' where danyuan='.$_W['danyuan'].' and shangpin='.$shangpin['id'].' and huiyuan='.$_W['huiyuan']['id']);
	if($maishu>=$shangpin['zuiduomai'] && !empty($shangpin['zuiduomai'])){
    	 return -4;
   }   
   
   return 1; 
	
}
?>