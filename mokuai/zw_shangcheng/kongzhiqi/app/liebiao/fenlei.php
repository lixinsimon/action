<?php
	/**
 * [商城开源系统] Copyright (c) 2014 ZhiWi.COM
 *  商城群QQ：628361862  进群下载更新包 交流技术   http://www.ZhiWi.com/.
 */
$cao=empty($_J['c'])?'moren':$_J['c'];
if($cao=='moren' && $_W['ispost']){	
	$shu=MX()->quQuanFenLei(0,'zhuangtai=1');		
	if(empty($shu)){
		json('没有分类',0);
	}
	json($shu);
	// else{
// 		$tuijian=ChaQuan('select * from'.BM('zw_shangcheng_feilei').' where shouye=1');
// 		foreach($tuijian as $k=>$tj){
// 			$tuijian[$k]['tu']=JueDuiUrl($tj['tu']);
// 			$tuijian[$k]['url']=UAK('liebiao/lie',array('id'=>$tj['id']));
// 		}
// 		
// 		$tj=array('haizi'=>$tuijian,'ming'=>'推荐分类');
// 		$fenlei[]=$tj;
// 
// 
// 		foreach($shu as $k=>$l){
// 			$fenlei[]=$l;
// 		}
		
	// }
}
mb('fenlei');
?>