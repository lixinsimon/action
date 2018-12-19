<?php
/**
 * [商城开源系统] Copyright (c) 2014 ZhiWi.COM
 *  商城群QQ：628361862  进群下载更新包 交流技术   http://www.ZhiWi.com/.
 */
DengLu();
$cao=empty($_J['c'])?'moren':$_J['c'];
if($cao=='moren' && $_W['ispost']){	
	$pj=Qu('zw_shangcheng_pingjia',array('dingdan'=>$_J['dingdan'],'shangpin'=>$_J['shangpin']));
    $shangpin=MX()->quShangPin($_J['shangpin']);    
    if($pj){
	   $shangpin['pingjia']=1;
    }
    json($shangpin);
}elseif($cao=='tianjia'){
	$s=array();	
	$pj=Qu('zw_shangcheng_pingjia',array('dingdan'=>$_J['dingdan'],'shangpin'=>$_J['shangpin']));
	if($pj){
	json('已经评论过了',0);
    }
	$s['danyuan']=$_W['danyuan'];
	$s['hyid']=$_W['huiyuan']['id'];
	$s['dingdan']=$_J['dingdan'];
	$s['shangpin']=$_J['shangpin'];
	$s['xingji']=$_J['xingji'];
	$s['neirong']=$_J['neirong'];
	$s['tu']=ShuZu_Zhuan_ZiFuChuan($_J['tu']);
	$s['shijian']=time();
	ChaRu('zw_shangcheng_pingjia',$s);
	json('评论成功');
}elseif($cao=='lie'){
    $DangQianYe=max(1,$_J['ye']);
	$quTiaoShu=1;	
	$lie=ChaQuan('select p.*,h.touxiang,h.nicheng from '.BM('zw_shangcheng_pingjia').'p left join '.BM('he_huiyuan').' h on p.hyid=h.id where p.danyuan='.$_W['danyuan'].' and p.shangpin='.$_J['id'].' order by p.shijian DESC  Limit '. ($DangQianYe - 1) * $quTiaoShu . ',' . $quTiaoShu);
	if(empty($lie)){
		json('没有了',0);
	}
	foreach ($lie as &$v) {
		$v['tu']=ZiFuChuan_Zhuan_ShuZu($v['tu']);
		if($v['tu']){
			foreach ($v['tu'] as &$k) {
			   $k=JueDuiUrl($k);
		    }
		}		
		$v['touxiang']=JueDuiUrl($v['touxiang']);
	}
	json($lie);
}

mb("pingjia");
?>