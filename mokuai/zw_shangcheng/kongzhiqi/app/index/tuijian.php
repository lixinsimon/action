<?php
if($cao=='moren' && $_W['ispost']){
	$ye=max(1,$_J['ye']);
	$jiazaishu=intval($_J['jiazaishu']);
	$ziduan="*";
	$tiaojian=array(':zhuangtai'=>1,":tuijian"=>1);
	$shangpinlie=MX()->quQuanShangPin($jiazaishu,$ye,$ziduan,$tiaojian);
	if(empty($shangpinlie)){
		json('没有了',0);
	}
    foreach($shangpinlie as $k=>$s){
    	$shangpinlie[$k]['href']=UAK("xiangqing",array("id"=>$s["id"]));
    	$shangpinlie[$k]['tu']=JueDuiUrl($s["tu"]);  
    	$shangpinlie[$k]['yuanjia']=intval($s["yuanjia"]);  
    	$shangpinlie[$k]['jiage']=intval($s["jiage"]);    
    	if(floatval($s["yuanjia"])>10000){
    		$shangpinlie[$k]['yuanjia']=($s["yuanjia"]/10000).'万';    
    	}	
    	if(floatval($s["jifenman"])>10000){
    		$shangpinlie[$k]['jifenman']=($s["jifenman"]/10000).'万';    
    	}
    }
    json($shangpinlie);	
}elseif($cao=='tu' && $_W['ispost']){
	$shezhi=$_W['shezhi']['shezhi'];    
	for($i=1;$i<=5;$i++){
    	if($shezhi['tuijian'.$i]['tu']){
    		$s=array();
	    	$s['tu']=JueDuiUrl($shezhi['tuijian'.$i]['tu']);
	    	$s['url']=$shezhi['tuijian'.$i]['url'];
	    	$shu['tuijian'][]=$s;	
    	}    	
    }
    json($shu);
}

mb('tuijian');
?>