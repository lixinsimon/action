<?php
/**
 * [商城开源系统] Copyright (c) 2014 ZhiWi.CN
 *  商城群QQ：628361862  进群下载更新包 交流技术   http://www.ZhiWi.cn/.
 */
DengLu();
if($cao=='moren' && $_W['ispost']){
	$ziduan="gwc.*,sp.ming,sp.jiage,sp.cuxiao,sp.chengben,sp.kucun,sp.tu,sp.kuaidifei,sp.zhongliang,sp.zhuangtai,sp.danwei,gg.guige_xuanze_ming,gg.guige_xuanze_chengben,gg.guige_xuanze_kucun,gg.guige_xuanze_jiage,gg.guige_xuanze_zhongliang";
	$sql='select '.$ziduan.' from '.BM('zw_shangcheng_gouwuche').'gwc left join ';
	$sql.=BM('zw_shangcheng_shangpin').' sp on gwc.shangpin=sp.id left join ';
	$sql.=BM('zw_shangcheng_shangpin_guige_xuanze').' gg on gwc.guige=gg.id';
	$sql.=' where gwc.danyuan=:danyuan and gwc.huiyuan=:huiyuan order by shijian DESC';
	$tiaojian=array(':danyuan'=>$_W['danyuan'],':huiyuan'=>$_W['huiyuan']['id']);
	$gouwuchelie=ChaQuan($sql,$tiaojian);

	$hy=Qu('zw_shangcheng_huiyuan',array('hyid'=>$_W['huiyuan']['id']));
	foreach($gouwuchelie as $k=>$g){
		if($g['guige']>0 &&  $g['guige_xuanze_jiage']>0){
			$gouwuchelie[$k]['ming'].=' '.$g['guige_xuanze_ming'];
			$gouwuchelie[$k]['kucun']=$g['guige_xuanze_kucun'];
			$gouwuchelie[$k]['jiage']=$g['guige_xuanze_jiage'];
		    $gouwuchelie[$k]['zhongliang']=$g['guige_xuanze_zhongliang'];	
		    if($hy['fenxiaodengji']>11){
		    	$gouwuchelie[$k]['jiage']=$g['guige_xuanze_chengben'];
		    }	    
		}
		$gouwuchelie[$k]['tu']=JueDuiUrl($g['tu']);		
		if(empty($gouwuchelie[$k]['jiage']) || empty($g['zhuangtai']) || $gouwuchelie[$k]['kucun']<=0){
			ShanChu('zw_shangcheng_gouwuche',array('id'=>$g['id']));
			$gouwuchelie[$k]['zhuangtai']=0;		
		}
		unset($gouwuchelie[$k]['guige_xuanze_jiage'],$gouwuchelie[$k]['guige_xuanze_zhongliang'],$gouwuchelie[$k]['guige_xuanze_kucun'],$gouwuchelie[$k]['guige_xuanze_ming']);
	}	
	
	$shu['ming']=$_W['shezhi']['shezhi']['ming'];
	$shu['lie']=$gouwuchelie;
	
	
	json($shu);
}elseif($cao=='tianjia' && $_W['ispost']){
	$shangpinid=intval($_J['ids']);
	$shuliang=empty($_J['shuliang'])?1:intval($_J['shuliang']);
	$guige=empty($_J['guigeid'])?0:intval($_J['guigeid']);
	if(empty($shangpinid)){
		json('您牛B!是黑客吧！',0);
	}
	if(empty($shuliang)){
		json('您要买多少件啊，没有数量',0);
	}	
	$cunzaiguige=Cha('select x.id from '.BM('zw_shangcheng_shangpin_guige_xuanze').' x left join '.BM('zw_shangcheng_shangpin').' s on x.shangpin_id=s.id where x.shangpin_id='.$shangpinid.' and s.kaiqiguige=1');
	
	if($cunzaiguige && empty($guige)){
		json('请选择规格',0);
	}
	
	$gouwuceh=array(
	          'danyuan'=>$_W['danyuan'],
	          'huiyuan'=>$_W['huiyuan']['id'],
	          'shangpin'=>$shangpinid,
	          'guige'=>$guige,
	          'shijian'=>time()	                    
	          );
	$cunzai=Cha('select * from '.BM('zw_shangcheng_gouwuche').' where danyuan='.$_W['danyuan'].' and huiyuan='.$_W['huiyuan']['id'].' and shangpin='.$shangpinid.' and guige='.$guige);
	if($cunzai){		
		Gai('zw_shangcheng_gouwuche',array('shuliang'=>$shuliang+$cunzai['shuliang']),array('id'=>$cunzai['id']));
	}else{
		$gouwuceh['shuliang']=$shuliang;
		$gouwuceh['zhiboren']=empty($_J['zhiboren'])?0:intval($_J['zhiboren']);
		ChaRu('zw_shangcheng_gouwuche',$gouwuceh);
	}
	json('已加入购物袋');
}elseif($cao=='jia' || $cao=='jian'){
	$kucun=intval($_J['kucun']);
	if($kucun<0 || empty($kucun)){	
		 json('错误',0);
	}
	$ziduan="gwc.*,sp.kucun,sp.yicizuiduomai,sp.zuiduomai,gg.guige_xuanze_kucun";
	$sql='select '.$ziduan.' from '.BM('zw_shangcheng_gouwuche').'gwc left join ';
	$sql.=BM('zw_shangcheng_shangpin').' sp on gwc.shangpin=sp.id left join ';
	$sql.=BM('zw_shangcheng_shangpin_guige_xuanze').' gg on gwc.guige=gg.id';
	$sql.=' where gwc.danyuan=:danyuan and gwc.huiyuan=:huiyuan and gwc.id=:id';
	$tiaojian=array(':danyuan'=>$_W['danyuan'],':huiyuan'=>$_W['huiyuan']['id'],':id'=>$_J['id']);
	$gouwuchelie=Cha($sql,$tiaojian);	
	if($gouwuchelie['guige']>0 && $gouwuchelie['guige_xuanze_kucun']>0){		
		$gouwuchelie['kucun']=$gouwuchelie['guige_xuanze_kucun'];			    
	}	
	
	
//	if($cao=='jia'){
//		$kucun=intval($_J['kucun']);
//	}elseif($cao=='jian'){
//		$kucun=intval($_J['kucun']);
//		
//	}	
	if($gouwuchelie['yicizuiduomai']<$kucun && $gouwuchelie['yicizuiduomai']>0){
		json('单次最多购买'.$gouwuchelie['yicizuiduomai'].'件',0);
	};
	$maishu=ChaZongShu('select sum(shuliang) from '.BM('zw_shangcheng_dingdan_shangpin').' where danyuan='.$_W['danyuan'].' and shangpin='.$gouwuchelie['shangpin'].' and huiyuan='.$_W['huiyuan']['id']);
	if($gouwuchelie['zuiduomai']<=$maishu && $gouwuchelie['zuiduomai']>0){
		json('您最多购买'.$gouwuchelie['zuiduomai'].'件',0);
	}
	$haikeyimai=$gouwuchelie['zuiduomai']-$maishu;
	if($haikeyimai<$kucun && $gouwuchelie['zuiduomai']>0){
		json('您最多购买'.$haikeyimai.'件',0);
	}		
	if($gouwuchelie['kucun']>=$kucun && $_J['kucun']>0 && $kucun>0){
		Gai('zw_shangcheng_gouwuche',array('shuliang'=>$kucun),array('id'=>$_J['id']));
		json($kucun);
	}else{
		json('库存不足',0);
	}	
}elseif($cao=='shanchu' && $_W['ispost']){		
	$ids=$_POST['ids'];		
	 $ids = explode(',', $ids);
	if($ids){
		foreach($ids as $id){
		     ShanChu('zw_shangcheng_gouwuche',array('danyuan'=>$_W['danyuan'],'huiyuan'=>$_W['huiyuan']['id'],'id'=>$id));
	  	}
	  	json('删除成功');	
	}
	json('删除失败',0);
}
mb('gouwuche');
?>