<?php
if($cao=='moren' && $_W['ispost']){
	$ye=max(1,$_J['ye']);
	$jiazaishu=intval($_J['jiazaishu']);
	$ziduan="*";
	$tiaojian=array(':zhuangtai'=>1,":xinpin"=>1);
	$shangpinlie=MX()->quQuanShangPin($jiazaishu,$ye,$ziduan,$tiaojian);
	if(empty($shangpinlie)){
		json('没有了',0);
	}
    foreach($shangpinlie as $k=>$s){
    	$shangpinlie[$k]['href']=UAK("xiangqing",array("id"=>$s["id"]));
    	$shangpinlie[$k]['tu']=JueDuiUrl($s["tu"]);    	
    	$shangpinlie[$k]['xinpintu']=JueDuiUrl($s["xinpintu"]);  
    	$shangpinlie[$k]['jiage']=intval($s["jiage"]);
    	$shangpinlie[$k]['yuanjia']=intval($s["yuanjia"]);
    	$shangpinlie[$k]['chengben']=intval($s["chengben"]);
    	if(floatval($s["yuanjia"])>10000){
    		$shangpinlie[$k]['yuanjia']=intval($s["yuanjia"]/10000).'万';    
    	}
    }
    json($shangpinlie);	
}

mb('xinpin');
?>