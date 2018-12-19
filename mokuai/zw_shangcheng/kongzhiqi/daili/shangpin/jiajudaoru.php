<?php
//$f0731=ChaQuan('select * from '.BM('0731_product_category'));
//
//foreach($f0731 as $f){
//	$FL['id']=$f['product_category_id'];
//	$FL[$l'danyuan']=$_W['danyuan'];
//	$FL['ming']=$f['category_name'];
//	$FL['fuji_id']=$f['parent_id'];
//	$FL['shunxu']=$f['order_by'];
//	$FL['zhuangtai']=1;
//	ChaRu('zw_shangcheng_feilei',$FL);
//}

$F=ChaQuan('select * from '.BM('zw_shangcheng_feilei'));

foreach($F as $l){
	$FL[$l['id']]=$l['fuji_id'];
}

$DangQianYe=3;
$quTiaoShu=10000;
$p0731=ChaQuan('select * from '.BM('0731_product').' where yprice>0  limit '. ($DangQianYe - 1) * $quTiaoShu . ',' . $quTiaoShu);

foreach($p0731 as $k=>$p){
	$p['editor_img']=ZiFuChuan_Zhuan_ShuZu($p['editor_img']);
	$p['img_url']=ZiFuChuan_Zhuan_ShuZu($p['img_url']);	
	$sp['danyuan']=$_W['danyuan'];
	$sp['ming']=$p['product_name'];	
	$sp['tu']='http://img1.0731jiaju.com/'.str_replace(".","_b.",$p['img_url'][0]['url']);
	unset($p['img_url'][0]);
	if($p['img_url']){
	    $xjt=array();
		foreach($p['img_url'] as $img){
			
			$xjt[]='http://img1.0731jiaju.com/'.str_replace(".","_b.",$img['url']);
		}	
	    $sp['xijietu']=ShuZu_Zhuan_ZiFuChuan($xjt);	
	}
	
	$sp['jiage']=round($p['yprice'],0);
	$sp['yuanjia']=round($p['sprice'],0);
	$sp['chengben']=0;
	$sp['zhongliang']=0;
	$sp['kucun']=999;
	$sp['jiankucun']=1;
	
	$pregRule = "/<[img|IMG].*?src=[\'|\"](.*?(?:[\.jpg|\.jpeg|\.png|\.gif|\.bmp]))[\'|\"].*?[\/]?>/";    
	$sp['xiangqing']=preg_replace($pregRule, '<img src="http://www.0731jiaju.com${1}">', $p['description']);
		
	$sp['shijian']=$p['date'];	
	$sp['gengxinshijian']=$p['date'];
	
	if($FL[$p['product_category_id']]>0){
		$sp['fenlei_yiji']=$FL[$p['product_category_id']];
	    $sp['fenlei_erji']=$p['product_category_id'];	
	}else{
		$sp['fenlei_yiji']=$p['product_category_id'];
	}
	$sp['shanghu']=$p['user_id'];
	
	$d[]=$sp;
	if(Qu('zw_shangcheng_shangpin',array('id'=>$p['product_id']),'id')){
			Gai('zw_shangcheng_shangpin',$sp,array('id'=>$p['product_id']));
	}else{	
		$sp['id']=$p['product_id'];
		ChaRu('zw_shangcheng_shangpin',$sp);
	}
//	
};


?>