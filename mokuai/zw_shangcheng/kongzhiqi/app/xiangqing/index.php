<?php
/**
 * [商城开源系统] Copyright (c) 2014 ZhiWi.CN
 *  商城群QQ：628361862  进群下载更新包 交流技术   http://www.ZhiWi.cn/.
 */

if($_W['ispost'] && $cao == 'moren'){
	$id=intval($_J['id']);
  $shangpin=MX()->quShangPin($id);
	$guige=MX()->quGuiGe($id);	


	if($guige['guige_zu']){
		foreach($guige['guige_zu'] as $k=>$z){
			$g[$k]=$z;
			foreach($guige['guige'] as $gg){			
			   if($z['guigezu_id']==$gg['guigezu_id']){
			       $gg['guige_tu']=JueDuiUrl($gg['guige_tu']);
			   	   $g[$k]['haizi'][]=$gg;
			   }
		   }
		}
	}
	if($shangpin['shanghu']){
		$shanghu['geshu']=ChaZongShu('select count(*) from'.BM('zw_shangcheng_shangpin').' where shanghu='.$shangpin['shanghu']);
		$shanghu['ziliao'] = Qu('he_shanghu',array('id'=>$shangpin['shanghu']));
	
	}
	if($guige['guige_xuanze']){
		foreach($guige['guige_xuanze'] as $k=>$z){
			$guige_xuanze[$z['guige_xuanze_id']]=$z;
		}
	}
	

	unset($guige);	

  $quanXian=iS($shangpin,$_W); 	
	
  
  if($shangpin['jieshushijian']<SHIJIAN){
		 $shangpin['jieshu']=1;
	}
	
	if($shangpin['jieshushijian']){
		$shangpin['jieshushijian']=date('m月d日H:i',$shangpin["jieshushijian"]); 
	}
	if($shangpin['fahuoshijian']){
		$shangpin['fahuoshijian']=date('Y年m月d日H:i',$shangpin["fahuoshijian"]); 
	}
	if(empty($shangpin['xijietu'])){
    	$a[]=$shangpin['tu'];
    	$shangpin['xijietu']=$a;
    }  
    $shoucang=Qu('zw_shangcheng_shoucang',array('danyuan'=>$_W['danyuan'],'huiyuan'=>$_W['huiyuan']['id'],'shangpin'=>$shangpin['id']),'id');   	
	  $shangpin['shuxing']='';
    
		
	$s=array(
	  'shangpin'=>$shangpin,
		'guige'=>$g,
		'guige_xuanze'=>$guige_xuanze,
		'shoucang'=>$shoucang,
		'shanghu'=>$shanghu,
		'kefu'=>$_W['shezhi']['shezhi']['dianhua']
		);		
	json($s,$quanXian);
} 
mb('xiangqing');

//$quanXian = 1; // 1.正常,-1.未登录 ,-2.库存不足,-3.购买权限角色不够，-4.超过购买数量,-5.兑换商品 -6.预售时间结束,
function iS($shangpin,$_W){ 
	
	//未登录
	if(!DengLu(true)){
		return -10;
	}	
	
	//库存不足
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
  
	if($shangpin['cuxiao']==2){
		return -5;
	}
	
	if($shangpin['jieshushijian']<SHIJIAN && $shangpin['cuxiao']==3){
		 return  -6;
	}
   return 1; 
	
}
?>