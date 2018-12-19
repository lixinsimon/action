<?php
require '../../neihe/he.php';

$_W['mo']='zw_shangcheng';




$jiesuanbao=ChaQuan('select * from '.BM('zw_shangcheng_jiesuanbao')." where danyuan=".$_W['danyuan']);
if($jiesuanbao)foreach($jiesuanbao as $l){
	$jsb[$l['id']]=$l;
	$shouyi=ZiFuChuan_Zhuan_ShuZu($l['shouyi']);
	$jilu=ChaQuan('select sum(shuliang) as shuliang,hyid from '.BM('zw_shangcheng_jiesuanbao_jilu')." where tian>0 and danyuan=".$_W['danyuan'].' and jiesuanbao='.$l['id']." GROUP BY hyid");

	if($jilu)foreach($jilu as $h){	
		$zuigao=0;
		$shu[$h['hyid'].$l['id']]['yuan']=$h['shuliang'];
		$shu[$h['hyid'].$l['id']]['biaoti']=$l['biaoti'];
		$shu[$h['hyid'].$l['id']]['jiesuanbao']=$l['id'];
		$shu[$h['hyid'].$l['id']]['hyid']=$h['hyid'];
		foreach($shouyi as $s){		
			if($s['yuan']<$h['shuliang'] && $zuigao<$s['yuan']){
				$shu[$h['hyid'].$l['id']]['bilie']=$s['bilie'];				
				$zuigao=$s['yuan'];
			}
		}
	}	
}


if($shu)foreach($shu as $k=>$s){	
	$jine=$s['yuan']*$s['bilie'];
	MX('huiyuan','he')->BiZong_JiaJian('jifen',$s['hyid'],$jine,$s['biaoti'].'每日收益','jsb'.$s['jiesuanbao'],1,'jiesuanbao');	
}

$shengyitian=ChaQuan('select shuliang,hyid,jiesuanbao,dingdanhao from '.BM('zw_shangcheng_jiesuanbao_jilu')." where tian=1 and danyuan=".$_W['danyuan']);
if($shengyitian)foreach($shengyitian as $s){	
	MX('huiyuan','he')->BiZong_JiaJian('jifen',$s['hyid'],$s['shuliang'],$jsb[$s['jiesuanbao']]['biaoti'].'出局',$s['dingdanhao'],1,'chuji');
   	$fuji=fuji($s['hyid']);	
	if($fuji[0] && $fuji[1]){	
		MX('huiyuan','he')->BiZong_JiaJian('jifen',$fuji[0]['id'],$s['shuliang']*0.05,$jsb[$s['jiesuanbao']]['biaoti'].'出局直推奖',$s['dingdanhao'],1,'jiesuanbao');
		MX('huiyuan','he')->BiZong_JiaJian('jifen',$fuji[1]['id'],$s['shuliang']*0.02,$jsb[$s['jiesuanbao']]['biaoti'].'出局间推奖',$s['dingdanhao'],1,'jiesuanbao');
	}elseif($fuji[0]){
		MX('huiyuan','he')->BiZong_JiaJian('jifen',$fuji[0]['id'],$s['shuliang']*0.07,$jsb[$s['jiesuanbao']]['biaoti'].'出局直推奖',$s['dingdanhao'],1,'jiesuanbao');
	}
}
Gai('zw_shangcheng_jiesuanbao_jilu','tian=tian-1','tian>0');


$_W['shezhi']=MX()->quSheZhi();	

$shijian=SHIJIAN-1800;
$TJ='danyuan='.$_W['danyuan'].' and zhuangtai=0 and xiadanshijian <'.$shijian;
Gai('zw_shangcheng_dingdan',array('zhuangtai'=>5),$TJ);	



$zidongshouhuo=intval($_W['shezhi']['jiaoyi']['zidongshouhuo']);
if($zidongshouhuo>0){
	$shijian15=SHIJIAN-(86400*$zidongshouhuo);
	$zidongshouhuo=ChaQuan('select * from '.BM('zw_shangcheng_dingdan').' where zhuangtai=20 and fahuoshijian<'.$shijian15);
		
	$tiaojian['danyuan'] = $_W['danyuan']; 
	if($zidongshouhuo)foreach($zidongshouhuo as $z){  
		$tiaojian['id'] = $z['id']; 
		MX()->gaiDingDanZhuangTai('shouhuo',$tiaojian);
	}
}




function fuji($hyid){
	global $_W;
	if($_W['fuji'][$hyid]){
		return $_W['fuji'][$hyid];
	}

	$a=Qu('he_huiyuan',array('id'=>$hyid),'fuji_id');	
	if($a['fuji_id']){
		$b=$_W['fuji'][$hyid][0]=Qu('he_huiyuan',array('id'=>$a['fuji_id']),'id,fuji_id');
	} 

	if($b['fuji_id']){
		$_W['fuji'][$hyid][1]=Qu('he_huiyuan',array('id'=>$b['fuji_id']),'id,fuji_id');	
	}	
	
	return $_W['fuji'][$hyid];	
	
}


echo '成功';
?>