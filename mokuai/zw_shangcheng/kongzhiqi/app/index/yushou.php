<?php

if($cao=='moren' && $_W['ispost']){
	$ye=max(1,$_J['ye']);
	$jiazaishu=intval($_J['jiazaishu']);
	$ziduan="*";
	$tiaojian=array(':zhuangtai'=>1,":cuxiao"=>3);
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
    	if($shangpinlie[$k]['jieshushijian']<SHIJIAN){
    		$shangpinlie[$k]['jieshu']=1;
    	}
    	
    	if($shangpinlie[$k]['jieshushijian']){
    		$shangpinlie[$k]['jieshushijian']=date('m月d日H:i',$s["jieshushijian"]); 
    	}
    	   
    			
    }
    json($shangpinlie);	
}elseif($cao=='tu' && $_W['ispost']){
		$shezhi=$_W['shezhi']['shezhi'];    
		for($i=1;$i<=5;$i++){
	    	if($shezhi['yushou'.$i]['tu']){
	    		$s=array();
		    	$s['tu']=JueDuiUrl($shezhi['yushou'.$i]['tu']);
		    	$s['url']=$shezhi['yushou'.$i]['url'];
		    	$shu['yushou'][]=$s;	
	    	}    	
	    }
	    json($shu);
}

mb('yushou');
?>