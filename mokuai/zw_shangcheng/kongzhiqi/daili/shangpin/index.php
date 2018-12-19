<?php
/**
 * [商城开源系统] Copyright (c) 2014 ZhiWi.COM
 *  商城群QQ：628361862  进群下载更新包 交流技术   http://www.ZhiWi.com/.
 */
DengLu();
$mx=MX();
if($cao=='moren'){
	$DangQianYe=max(1,$_J['page']);
	$quTiaoShu=30;	
	$feileilie=$mx->quQuanFenLei();
	$TiaoJian[':danyuan']=$_W['danyuan'];
	$tj=' danyuan='.$_W['danyuan'];
	
	if($_J['guanjianci']){
		$TiaoJian[':guanjianci']=' ming like "%'.trim($_J['guanjianci']).'%"';
		$tj.=' and ming like "%'.trim($_J['guanjianci']).'%"';
	}
	if(is_numeric($_J['zhuangtai'])){
		$TiaoJian[':zhuangtai']=$_J['zhuangtai'];
		$tj.=' and zhuangtai='.$_J['zhuangtai'];
	}
//	if($_J['fenlei'][0]>0){
//		$TiaoJian[':fenlei_yiji']=$_J['fenlei'][0];
//		$tj.=' and fenlei_yiji='.$_J['fenlei'][0];
//	}
//	if($_J['fenlei'][1]>0){
//		$TiaoJian[':fenlei_erji']=$_J['fenlei'][1];
//		$tj.=' and fenlei_erji='.$_J['fenlei'][1];
//	}	
	$shiqu = ChaQuan('select * from'.BM('he_shanghu').' where shiqu='.$_W['daili']['shiqudaili']);
	foreach($shiqu as $l){
		$q.='shanghu='.$l['id'].' or ';		
	}
	$TiaoJian[':shanghu']= array(' ('.substr($q,0,strlen($str)-3).')');
	$tj.=' and ('.substr($q,0,strlen($str)-3).')';
	$shangpinlie=$mx->quQuanShangPin($quTiaoShu,$DangQianYe,'*',$TiaoJian);	
	$sql="select count(*) from ".BM('zw_shangcheng_shangpin').' where '.$tj;	
    $zongshu=ChaZongShu($sql);
    $FenYe=FenYe($zongshu,$DangQianYe,$quTiaoShu); 	
}elseif($cao=='spec'){
	$zu = array("guigezu_id" => random(32),"guigezu_ming" => $_J['guigezu_ming']);
    mb("guige_muban/spec");exit;
}elseif($cao=='specitem'){
	$zu     = array("guigezu_id" => $_J['guigezu_id']);
    $gg = array("guige_id" => random(32),"guige_ming" => $_J['guige_ming'],"guige_show" => 1);
    mb("guige_muban/spec_item");exit;
}elseif($cao=='erjilei'){
	$feileilie=$mx->quQuanFenLei($_J['id']);
	echo json_encode($feileilie);exit;
}elseif($cao=='post' && $_W['ispost']){
	$_J['dianpuId']=$_W['shanghu']['id'];
	$id=$mx->JiaGaiShangPin($_J);
	if(empty($id)){
		XiaoXi('操作失败');exit;
	}			
	$FL=Qu('zw_shangcheng_feilei_xiaozhan',array('shanghu'=>$_J['dianpuId']),'fenlei');
	foreach($_J['fenlei'] as $f){
		$f='_'.$f.'_';		
		if(strpos($FL['fenlei'],$f)===false){		
			$FL['fenlei'].=$f;	
		}
	}
	$FL['shanghu']=$_J['dianpuId'];
	$FL['danyuan']=$_W['danyuan'];
    ChaRu('zw_shangcheng_feilei_xiaozhan',$FL,true);	
	XiaoXi('操作成功');exit;	
}elseif($cao=='bianji'){
	QuanXian('bianji');
	$shangpin=$mx->quShangPin($_J['id']);
	//编辑时需要去掉$shangpin['xijietu'][0]这个是：$shangpin['tu'];
	unset($shangpin['xijietu'][0]);		
	$guige=$mx->quGuiGe($_J['id']);
	$guige_xuanze=$mx->quGuiGeXuanZe_html($guige);
	$feileilie=$mx->quQuanFenLei();
	$fenxiaodengji=$mx->FenXiaoDengJiLie();	
	$jichupeizhi = MX()->FenXiaoPeiZhi();
	$huiyuandengji=$mx->quDengJiLie();	
}elseif($cao=='tianjia'){
	QuanXian('tianjia');	
	$feileilie=$mx->quQuanFenLei();	
	$jichupeizhi = MX()->FenXiaoPeiZhi();
	$fenxiaodengji=$mx->FenXiaoDengJiLie();	
	$huiyuandengji=$mx->quDengJiLie();	
}elseif($cao=='shanchu'){
	QuanXian('shanchu');	
	ShanChu('zw_shangcheng_shangpin',array('id'=>$_J['id'],'danyuan'=>$_W['danyuan']));
	ShanChu('zw_shangcheng_shangpin_guige',array('shangpin_id'=>$_J['id'],'danyuan'=>$_W['danyuan']));
	ShanChu('zw_shangcheng_shangpin_guige_xuanze',array('shangpin_id'=>$_J['id'],'danyuan'=>$_W['danyuan']));
	ShanChu('zw_shangcheng_shangpin_guige_zu',array('shangpin_id'=>$_J['id'],'danyuan'=>$_W['danyuan']));
	XiaoXi('删除成功');exit;
}elseif($cao=='zhuangtai'){
	if(is_numeric($_J['zhuangtai'])){
		$sp = array();
		$sp[trim($_J['column'])] = $_J['zhuangtai'];
		Gai('zw_shangcheng_shangpin',$sp,array('id'=>$_J["id"],'danyuan'=>$_W['danyuan']));
		json("修改成功！");
	}
	json("修改失败！", 0);	
}

mb("shangpin");

//function array_unset_tt($arr,$key){     
//      //建立一个目标数组  
//      $res = array();        
//      foreach ($arr as $value) {           
//         //查看有没有重复项  
//         if(isset($res[$value[$key]])){  
//               //有：销毁  
//               unset($value[$key]);  
//         }  
//         else{  
//              $res[$value[$key]] = $value;  
//         }    
//      }  
//      return $res;  
//  } 
?>