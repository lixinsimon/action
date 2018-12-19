<?php
/**
 * [商城开源系统] Copyright (c) 2014 ZhiWi.COM
 *  商城群QQ：628361862  进群下载更新包 交流技术   http://www.ZhiWi.com/.
 */
DengLu();
if($cao=='moren'  && $_W['ispost']){
	
	$shuju=json_decode($_POST['shu'],true);

	

// 	if(!$shuju['shuxing']){
// 		 json("请添加属性",0);
// 	}
	if(!$shuju['ming']){
		json("请输入商品标题",0);
	}
 if(empty($shuju['tu'])){
 	json("请上传图片",0);
 }

 if(empty($shuju['danwei'])){
		json("请输入单位",0);
 }
 if(!is_numeric($shuju['jiage'])){
 	json("请输入价格",0);
 }
//  if(empty($shuju['yuanjia'])){
// 		json("请输入原价",0);
//  }
 if(!is_numeric($shuju['kucun'])){
   	json("请输入库存",0);
 }
 if(!is_numeric($shuju['zhongliang'])){
	   json("请输入重量",0);
 }
 if(!$shuju['fenlei']){
 	json("请选择分类",0);
 }
	$shanghu=Qu('he_shanghu',array('hyid'=>$_W['huiyuan']['id']),'id');	
	if(empty($shanghu)){
		json('你还没有申请店铺',0);
	}
	
	$shu['ming'] = $shuju['ming'];
	$shu['yuanjia'] = $shuju['yuanjia'];
	$shu['zhongliang'] = $shuju['zhongliang'];
	$shu['danwei'] = $shuju['danwei'];
	$shu['jifen'] = $shuju['hequan'];

	$fenlei = explode(",",$shuju['fenlei']);
	$shu['fenlei'][0] = $fenlei[0];
	$shu['fenlei'][1] = $fenlei[1];
	
	
	// $shu['shuxing'] = json_decode($shuju['shuxing'],true);
	$shu['shuxing'] =$shanghu['shuxing'];
	
  $shu['dianpuId'] =$shanghu['id'];
	$shu['jiage'] = $shuju['jiage'];
	$shu['kucun'] = $shuju['kucun'];		
	
	$shu['tu'] = $shuju['tu'][0];	
	unset($shuju['tu'][0]);
	if($shuju['tu'][1])foreach($shuju['tu'] as $l){	
		 if($l){
			 $shu['xijietu'][]=$l;
		 }
		    
	}
	$shu['xiangqing'] = $shuju['xiangqing'];
	$id=MX()->JiaGaiShangPin($shu);
	if(empty($id)){
	   json("失败",0);
	}
	json("成功");

}else if($cao == 'zhuanqu'){
	$shu=Cha('select putongqu,hequanqu from '.BM(he_shanghu).' where hyid='.$_W['huiyuan']['id']);
	if(($shu['putongqu'] != 1) && ($shu['hequanqu'] != 1)){
			json('没有购买资格',0);
	}else if(($shu['putongqu'] == 1) && ($shu['hequanqu'] != 1)){
			json('已购买普通区资格',1);
	}else if(($shu['hequanqu'] == 1) && ($shu['putongqu'] != 1)){
			json('已购买和券区资格',2);
	}else if(($shu['putongqu'] == 1) && ($shu['hequanqu'] == 1)){
			json('已购买普通区与和券区资格',3);
	}
}

?>