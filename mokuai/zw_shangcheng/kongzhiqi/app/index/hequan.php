<?php
DengLu();
if($cao=='moren' && $_W['ispost']){	
	$shu=$_W['huiyuan'];
	$shu['touxiang']=$shu['touxiang']?$shu['touxiang']:$_W['yuming'].'gongyong/images/touxiang.png';
	$shu['jifen']=100;
	$shu['fenxiaodengjiming']='默认等级';
	json($shu);
	
}elseif($cao=='shangpin'){
	$ye=max(1,$_J['ye']);
	$jiazaishu=intval($_J['jiazaishu']);
	$tiaojian=array(':zhuangtai'=>1,":cuxiao"=>2);
	$shangpinlie=MX()->quQuanShangPin($jiazaishu,$ye,"*",$tiaojian);
	if(empty($shangpinlie)){
		json('没有了',0);
	}
	foreach($shangpinlie as $k=>$s){
		$shangpinlie[$k]['href']=UAK("xiangqing",array("id"=>$s["id"]));
		$shangpinlie[$k]['tu']=JueDuiUrl($s["tu"]);  
		$shangpinlie[$k]['yuanjia']=intval($s["yuanjia"]);    
		if(floatval($s["yuanjia"])>10000){
			$shangpinlie[$k]['yuanjia']=($s["yuanjia"]/10000).'万';    
		}	
		if(floatval($s["jifenman"])>10000){
			$shangpinlie[$k]['jifenman']=($s["jifenman"]/10000).'万';    
		}		
	}
	json($shangpinlie);	
}

mb('dianquan');
?>