<?php

if($cao=='moren' && $_W['ispost']){
	$ye=max(1,$_J['ye']);
	$jiazaishu=intval($_J['jiazaishu']);
	$ziduan="*";
	$tiaojian=array(':zhuangtai'=>1,":cuxiao"=>1);
	$shangpinlie=MX()->quQuanShangPin($jiazaishu,$ye,$ziduan,$tiaojian);
	if(empty($shangpinlie)){
		json('没有了',0);
	}
    foreach($shangpinlie as $k=>$s){
    	$shangpinlie[$k]['href']=UAK("xiangqing",array("id"=>$s["id"]));
    	$shangpinlie[$k]['tu']=JueDuiUrl($s["tu"]);    	
    }
    json($shangpinlie);	
}elseif($cao=='lunbo' && $_W['ispost']){
	
	$shezhi=$_W['shezhi']['shezhi'];    
	for($i=1;$i<=5;$i++){
    	if($shezhi['dianzhao'.$i]['tu']){
    		$s=array();
	    	$s['tu']=JueDuiUrl($shezhi['dianzhao'.$i]['tu']);
	    	$s['url']=$shezhi['dianzhao'.$i]['url'];
	    	$shu['dianzhao'][]=$s;	
    	}    	
    }
    json($shu);
}

mb('vipqu');
?>