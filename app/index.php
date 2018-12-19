<?php

require '../neihe/he.php';
require 'gongyou/hanshu.php';
if(empty($_W['danyuan'])){
	XiaoXi('链接错误');exit;
}
$_W['dy']=Qu('he_danyuan',array('id'=>$_W['danyuan'],'Zhuangtai'=>1));
if(!is_array($_W['dy'])){
	XiaoXi('此网站不存在或关闭');die;
}

$shezhi=Cha('select shezhi from '.BM('zw_shangcheng_shezhi').' where danyuan='.$_W['danyuan']);
$shezhi['shezhi']=ZiFuChuan_Zhuan_ShuZu($shezhi['shezhi']);
$shezhi['shezhi']['logo']=JueDuiUrl($shezhi['shezhi']['logo']);
global $_W;
$_W['shezhi']['shezhi']=$shezhi['shezhi'];
$cao=$_J['c']?$_J['c']:'moren';
DengLu(true);
// if($_W['zhongduan']=='weixin' && !DengLu(true)){
// 		$wx=MX('weixin');	
// 		if(empty($_J['code'])){
// 			$wx->quCode();
// 		}else{
// 			$wx->quToken($_J['code']);			
// 		}	
// }
// if($_W['huiyuan']['id'] && empty($_J['t']) && !$_W['ispost']){
// 	$url=$_W['url'].'&t='.$_W['huiyuan']['id'];	
// 	TiaoZhuan($url);exit;	
// }



if($_W['kong']=='gongyou'){ 			
  require QuXiang('app/'.$_W['kong'].'/'.$_W['xing'].'.php');	
}elseif(empty($_W['mo'])){	
	require QuXiang('app/kongzhiqi/'.$_W['kong'].'/'.$_W['xing'].'.php');	
}else{
  require QuXiang('mokuai/'.$_W['mo'].'/index.php');	
}
?>
