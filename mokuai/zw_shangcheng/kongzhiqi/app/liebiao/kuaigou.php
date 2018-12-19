<?php
	/**
 * [商城开源系统] Copyright (c) 2014 ZhiWi.COM
 *  商城群QQ：628361862  进群下载更新包 交流技术   http://www.ZhiWi.com/.
 */
DengLu();

$cao=empty($_J['c'])?'moren':$_J['c'];
if($cao=='moren' && $_W['ispost']){	
	$shu['fenlei']=MX()->quQuanFenLei(0);		
	if(empty($shu['fenlei'])){
		json('没有分类',0);
	}else{
		json($shu);
	}
}elseif($cao=='shangpin' && $_W['ispost']){
	$fenlei=MX()->quQuanFenLei(0);	
	$ye = max(1, $_J['ye']);
    $ziduan = "id,ming,tu,jiage,kucun,chushoushu";
    $tiaojian[':zhuangtai']=1;   
   
    if($_J['shou']){
    	$ss='ming like "%'.$_J['shou'].'%"';
    	$tiaojian[':ming']=array($ss);   
    }else{
    	 if($_J['id']>0){
	    	$FL='(fenlei_yiji='.$_J['id'].' or fenlei_erji='.$_J['id'].')';
	    	$tiaojian[':fenlei']=array($FL);    
	    }else{
	    	$FL='(fenlei_yiji='.$fenlei[0]['id'].' or fenlei_erji='.$fenlei[0]['id'].')';
	    	$tiaojian[':fenlei']=array($FL);    
	    }
    }
	
	$shangpinlie = MX()->quQuanShangPin(6, $ye, $ziduan, $tiaojian);
    foreach($shangpinlie as $k=>$s){
    	$shangpinlie[$k]['href']=UAK("xiangqing",array("id"=>$s["id"]));
    	$shangpinlie[$k]['tu']=JueDuiUrl($s["tu"]); 
    	$sl=Cha('select shuliang from '.BM('zw_shangcheng_gouwuche').' where huiyuan='.$_W['huiyuan']['id'].' and danyuan='.$_W['danyuan'].' and shangpin='.$s['id']);
    	if($sl){
    		$shangpinlie[$k]['shuliang']=$sl['shuliang'];
    	}else{
    		$shangpinlie[$k]['shuliang']=0;
    	}  
    }
    json($shangpinlie);
}elseif($cao=='qingkong' && $_W['ispost']){
	ShanChu('zw_shangcheng_gouwuche',array('danyuan'=>$_W['danyuan'],'huiyuan'=>$_W['huiyuan']['id']));
	json('清空成功');
}elseif($cao=='jia' || $cao=='jian'){
	$kucun=intval($_J['kucun']);
	$you=Cha('select id from '.BM('zw_shangcheng_gouwuche').' where  shangpin='.$_J['id'].' and danyuan='.$_W['danyuan'].' and huiyuan='.$_W['huiyuan']['id']);
	
	if($you){
		$gid=$you['id'];
	}else{
		$canshu=array(
			'danyuan'=>$_W['danyuan'],
			'huiyuan'=>$_W['huiyuan']['id'],
			'shangpin'=>$_J['id'],
			'shuliang'=>1,
			'shijian'=>SHIJIAN
		);	
	
		ChaRu('zw_shangcheng_gouwuche', $canshu);
	   	$gid = ChaRuID();    
	}
	
	
	$ziduan="gwc.*,sp.kucun,sp.yicizuiduomai,sp.zuiduomai,gg.guige_xuanze_kucun";
	$sql='select '.$ziduan.' from '.BM('zw_shangcheng_gouwuche').'gwc left join ';
	$sql.=BM('zw_shangcheng_shangpin').' sp on gwc.shangpin=sp.id left join ';
	$sql.=BM('zw_shangcheng_shangpin_guige_xuanze').' gg on gwc.guige=gg.id';
	$sql.=' where gwc.danyuan=:danyuan and gwc.huiyuan=:huiyuan and gwc.id=:id';
	$tiaojian=array(':danyuan'=>$_W['danyuan'],':huiyuan'=>$_W['huiyuan']['id'],':id'=>$gid);
	$gouwuchelie=Cha($sql,$tiaojian);	
	if($gouwuchelie['guige']>0 && $gouwuchelie['guige_xuanze_kucun']>0){		
		$gouwuchelie['kucun']=$gouwuchelie['guige_xuanze_kucun'];			    
	}	
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
	if($gouwuchelie['kucun']<=0){
		json('库存不足',0);
	}
	
	if($gouwuchelie['kucun']>=$kucun && $_J['kucun']>0 && $kucun>0){
		Gai('zw_shangcheng_gouwuche',array('shuliang'=>$kucun),array('id'=>$gid,'danyuan'=>$_W['danyuan']));
		json($kucun);
	}else{
		ShanChu('zw_shangcheng_gouwuche',array('danyuan'=>$_W['danyuan'],'huiyuan'=>$_W['huiyuan']['id'],'id'=>$gid));
		json(0);
	}	
}
mb('kuaigou');
?>