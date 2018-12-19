<?php
DengLu();
if(empty($_J['d'])){
   XiaoXi('您的权限不够！');
}
QuanXian();
$cao=empty($_J['c'])?'moren':$_J['c'];
$he_huiyuan=MX('huiyuan','he');
$xianzhi=' limit 5';
if($cao=='moren'){
	$tiaojian="ly.danyuan=".$_W['danyuan'];
	if($_J['id']>0){
		$tiaojian.=' and hy.id='.$_J['id'];
	}	
	if($_J['yonghu']){
		$yonghu=trim($_J['yonghu']);
		$tiaojian.=' and (hy.nicheng like "%'.$yonghu.'%" or hy.xingming like "%'.$yonghu.'%" or hy.shouji like "%'.$yonghu.'%")';
	}	
	$DangQianYe = max(1, intval($_J['page']));
    $XianJiLu = 20;
	$huiyuan=ChaQuan('select hy.nicheng,hy.touxiang,hy.zhanghao,ly.* from '.BM('zw_shangcheng_liuyan').' ly left join '.BM('he_huiyuan').' hy on hy.id=ly.hyid where '.$tiaojian.' order by ly.id DESC limit '. ($DangQianYe - 1) * $XianJiLu . ',' . $XianJiLu);
	foreach($huiyuan as $k=>$hy){
		$huiyuan[$k]['tu']=ZiFuChuan_Zhuan_ShuZu($hy['tu']);
	}
	
	
	$shu=ChaZongShu('select count(*) from '.BM('zw_shangcheng_liuyan').' where  danyuan='.$_W['danyuan']); 
	$fenye=FenYe($shu,$DangQianYe,$XianJiLu); 	
}elseif ($cao=="bianji" && $_W['ispost']) {
	$huiyuan=$he_huiyuan->qu_huiyuan(intval($_J['id']));	
	$nicheng=Qu('he_huiyuan',array('id'=>$huiyuan['fuji_id']),'nicheng');	
	$huiyuan['fuji_nicheng']=$nicheng['nicheng'];
	mb("biaoqian/huiyuan_4");exit;
}elseif($cao=="chongzhi"){	
	if($_W['ispost']){
		$shouming=empty($_J['shouming'])?'平台充值':$_J['shouming'];	
		$shouming=$_W['yonghu']['yonghuming'].$shouming;	
		$he_huiyuan->gai_jifen($_J['id'],$_J['jifen'],$shouming);
		$he_huiyuan->gai_yu_e($_J['id'],$_J['yu_e'],$shouming);
		XiaoXi('更新成功','shuaxin');
	}
}elseif($cao=="shanchu"){
	if(is_array($_J['id'])){
		ShanChu('he_huiyuan',array('id'=>$_J['id'],'danyuan'=>$_W['danyuan']));
		XiaoXi('删除成功');
	}
	
}elseif($cao=='xuanshangji'){	
	$shangjilie1 = ChaQuan('select * from'.BM('he_huiyuan') .$xianzhi);
	json($shangjilie1);
	
}elseif($cao=='sousuo'){
	if($_J['txt']){		
		$tiaojian.=' where (nicheng like "%'.$_J['txt'].'%" or xingming like "%'.$_J['txt'].'%" or shouji like "%'.$_J['txt'].'%")';
		$shangjilie1 = ChaQuan('select * from'.BM('he_huiyuan') .$tiaojian);
		json($shangjilie1);	
    }
}


mb("liuyan");
?>