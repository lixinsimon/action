<?php
DengLu();
if($_W['yonghu']['shenfen']!=1){
	$where=" and dg.guanliyuanid=:guanliyuanid";
	$cen=array(':guanliyuanid'=>$_W['yonghu']['id']);	
	$dy['fenlei']=Cha('select d.* from '.BM('he_danyuan')." d left join ".BM('he_danyuan_guanliyuan')." dg on d.id=dg.danyuanid where 1 ".$where.' ',$cen);
//	dump($dy);
}else{
	$dy=ChaQuan('select * from '.BM('he_danyuan')." order by shijian DESC");	
}


mb('index');
?>