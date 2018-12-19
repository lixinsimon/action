<?php
/**
 * [商城开源系统] Copyright (c) 2014 ZhiWi.COM
 *  商城群QQ：628361862  进群下载更新包 交流技术   http://www.ZhiWi.com/.
 */
DengLu();
$cao=empty($_J['c'])?'moren':$_J['c'];
if($cao=='moren' && $_W['ispost']){
	$ye=Max(1,$_J['ye']);
	$quTiaoShu=$_J['jitiao'];
	$dingdan_sql='select d.id,d.huiyuan,d.dingdanhao,d.xiadanshijian,d.zhuangtai,d.shijia,d.yongjin,h.nicheng from '.BM('zw_shangcheng_dingdan').' d left join '.BM('he_huiyuan').' h on d.huiyuan=h.id where d.dailiren like "%_'.$_W['huiyuan']['id'].'_%" and d.danyuan='.$_W['danyuan'];
	$dingdan_sql.=' order by d.xiadanshijian DESC  Limit '. ($ye - 1) * $quTiaoShu . ',' . $quTiaoShu;	
	$yongjin=ChaQuan($dingdan_sql);
	$zhuangtai_wenzi=array('0'=>'待付款','5'=>'已取消','10'=>'待发货','20'=>'待收货','25'=>'退换货中','30'=>'完成','40'=>'已评价');
	foreach($yongjin as $k=>$yj){
		$yongjin[$k]['yongjin']=ZiFuChuan_Zhuan_ShuZu($yj['yongjin']);
		$yongjin[$k]['zhuangtai_wenzi']=$zhuangtai_wenzi[$yj['zhuangtai']];		
		$yongjin[$k]['shijian']=date('Y-m-d H:i',$yj['xiadanshijian']);
		$yongjin[$k]['nicheng']=$yj['nicheng']?$yj['nicheng']:'无名';		
		$b=0;
		foreach($yongjin[$k]['yongjin'] as $l=>$j){
			$b++;
			if($l==$_W['huiyuan']['id']){
				$yongjin[$k]['cengji']=$b;
				$yongjin[$k]['jin_e']=$j;
			}		
		}
	}	
	$shu['lie']=$yongjin;
	$shu['zongshu']=0;
	$shu['zongyongjin']=00.00;
	json($shu);
}	
mb('yongjinmingxi');
?>