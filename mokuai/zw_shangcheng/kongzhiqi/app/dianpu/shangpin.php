<?php
/**
 * [商城开源系统] Copyright (c) 2014 ZhiWi.COM
 *  商城群QQ：628361862  进群下载更新包 交流技术   http://www.ZhiWi.com/.
 */
DengLu();
if($cao=='moren'  && $_W['ispost']){	
	  $shanghu=MX('huiyuan','he')->ShangHu($_W['huiyuan']['id']);
	  $DangQianYe=max(1,$_J['ye']);	
		$TiaoJian=array(':danyuan'=>$_W['danyuan'],'shanghu'=>$shanghu['id']);
		$tj=' danyuan='.$_W['danyuan'].' and shanghu='.$shanghu['id'];
		
		if($_J['guanjianci']){
			$TiaoJian[':guanjianci']=array('ming like "%'.trim($_J['guanjianci']).'%"');
			$tj.=' and ming like "%'.trim($_J['guanjianci']).'%"';
		}
		if($_J['shuxing']){
			$aa=$shuxing[$_J['shuxing']];
			$TiaoJian[':shuxing']= array($aa);
			$tj.=' and '.$shuxing[$_J["shuxing"]];
		}
		if(is_numeric($_J['zhuangtai'])){
			$TiaoJian[':zhuangtai']=$_J['zhuangtai'];
			$tj.=' and zhuangtai='.$_J['zhuangtai'];
		}
		$_J['fenlei']=explode(',',$_J['fenlei']);
		if($_J['fenlei'][0]>0){
			$TiaoJian[':fenlei_yiji']=$_J['fenlei'][0];
			$tj.=' and fenlei_yiji='.$_J['fenlei'][0];
		}
		if($_J['fenlei'][1]>0){
			$TiaoJian[':fenlei_erji']=$_J['fenlei'][1];
			$tj.=' and fenlei_erji='.$_J['fenlei'][1];
		}	

		$shu['lie']=MX()->quQuanShangPin($_J['jitiao'],$DangQianYe,'*',$TiaoJian,'shijian DESC');		
		
		if($DangQianYe==1){
			$sql="select count(*) from ".BM('zw_shangcheng_shangpin').' where '.$tj;	
			$shu['zongshu']=ChaZongShu($sql);  
			$shu['zongshu']=$shu['zongshu']?$shu['zongshu']:0;
		}
		if(empty($shu['lie'])){
			json('没有了',0);
		}
		
		
		$fenlei=MX()->quQuanFenLei(0,'zhuangtai=1');
		foreach($fenlei as $k=>$l){
			if(empty($k)){
				$u['id']=0;
				$u['ming']='全部';
				$u['haizi'][0]['id']=0;
				$u['haizi'][0]['ming']='全部';				
				$shu['fenlei'][]=$u;
			}
			$shu['fenlei'][]=$l;
		}
		json($shu);
	
}else if($cao == 'xiajia'){	
	$k=Gai("zw_shangcheng_shangpin",array('zhuangtai' => 0),array('id' => $_J['id']));
	if($k){
		json('下架成功',1);
	}
	json('下架失败',0);
	
}else if($cao == 'shangjia'){
	$k=Gai("zw_shangcheng_shangpin",array('zhuangtai' => 1),array('id' => $_J['id']));
	if($k){
		json('上架成功',1);
	}
	json('上架失败',0);
}

// else if($cao == 'sousuo'){
// 		if(empty($_J['fenlei_erji'])){
// 			$shu=ChaQuan('select B.* from '.BM('he_shanghu').' A,'
// 					.BM('zw_shangcheng_shangpin').' B WHERE A.hyid = '
// 					.$_W['huiyuan']['id'].' AND A.id = B.shanghu AND B.ming LIKE "%'.$_J['ming'].'%"' );
// 		}else if(empty($_J['ming'])){
// 				$shu=ChaQuan('select B.* from '.BM('he_shanghu').' A,'
// 					.BM('zw_shangcheng_shangpin').' B WHERE A.hyid = '
// 					.$_W['huiyuan']['id'].' AND A.id = B.shanghu AND B.fenlei_erji = '.$_J['fenlei_erji']);
// 		}else if($_J['ming'] && $_J['fenlei_erji']){
// 				$shu=ChaQuan('select B.* from '.BM('he_shanghu').' A,'
// 					.BM('zw_shangcheng_shangpin').' B WHERE A.hyid = '
// 					.$_W['huiyuan']['id'].' AND A.id = B.shanghu AND B.fenlei_erji = '.$_J['fenlei_erji'].' AND B.ming LIKE "%'.$_J['ming'].'%"');
// 		}
// 		if(!empty($shu)){
// 				json($shu,1);
// 		}
// 		json('没有结果',0);
// }
?>