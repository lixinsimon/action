<?php
/**
 * [商城开源系统] Copyright (c) 2014 ZhiWi.COM
 *  商城群QQ：628361862  进群下载更新包 交流技术   http://www.ZhiWi.com/.
 */
DengLu();
$fxpz=MX()->FenXiaoPeiZhi();

$FenXiaoDengJi=MX()->FenXiaoDengJiLie();
foreach($FenXiaoDengJi as $x){	
   $DengJi[$x['id']]=$x;		

}
$xiaxian=MX()->XiaXian($_W['huiyuan']['id']);
$ye=max(1,$_J['ye']);	
foreach($xiaxian as &$x){	
   $x['shijian']=date('Y-m-d H:i',$x['shijian']);		
   $x['dengjiming']=$DengJi[$x['fenxiaodengji']]['ming'];

}


	
if($xiaxian){
   $count=$_J['jitiao']?$_J['jitiao']:6;	
   $h=array_slice($xiaxian, $count*($ye-1),$count);	
}else{
   $h=[];
}



$shu['lie']=$h;	


$huiyuan=MX()->quHuiYuan($_W['huiyuan']['id']);			
$huiyuan['touxiang']=empty($huiyuan['touxiang'])?$_W['yuming'].'/gongyong/images/morentu.png':JueDuiUrl($huiyuan['touxiang']);	
$shu['huiyuan']=$huiyuan;	
if(empty($h)){
   json($shu,0);
}
json($shu);
	
	

?>