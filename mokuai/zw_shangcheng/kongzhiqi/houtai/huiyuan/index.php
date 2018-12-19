<?php
DengLu();
QuanXian();

$mx=MX();
if($cao=='moren'){	
	$DangQianYe=max(1,$_J['page']);
	$quTiaoShu=10;	
	$tiaojian='h.danyuan='.$_W['danyuan'];	
	if($_J['id']>0){
		$tiaojian.=' and h.id='.$_J['id'];
	}
	if($_J['dengji']>0){
		$tiaojian.=' and g.huiyuandengji='.$_J['dengji'];
	}
	if($_J['kaishi'] && $_J['jieshu'] && !empty($_J['shijian'])){
		$tiaojian.=' and g.huiyuanshijian>='.strtotime($_J['kaishi']);
		$tiaojian.=' and g.huiyuanshijian<='.strtotime($_J['jieshu']);
	}
	if($_J['yonghu']){
		$yonghu=trim($_J['yonghu']);
		$tiaojian.=' and (h.nicheng like "%'.$yonghu.'%" or h.xingming like "%'.$yonghu.'%" or h.shouji like "%'.$yonghu.'%")';
	}
	$ziduan="h.*,g.huiyuandengji,g.huiyuanshijian";	
	$sql='select '.$ziduan.' from '.BM('zw_shangcheng_huiyuan')." g left join ".BM('he_huiyuan').' h on h.id=g.hyid where '.$tiaojian.' order by shijian DESC';
	$sql.=' Limit '. ($DangQianYe - 1) * $quTiaoShu . ',' . $quTiaoShu;		
	$huiyuanlie=ChaQuan($sql);	
	foreach($huiyuanlie as $k=>$hyl){
	    if($hyl['fuji_id']>0){	    
		    $fuji=Cha('select nicheng,xingming,touxiang from '.BM('he_huiyuan').' where id=:id',array(':id'=>$hyl['fuji_id']));		  
			$huiyuanlie[$k]['fuji_nicheng']=$fuji['nicheng'];
			$huiyuanlie[$k]['fuji_xingming']=$fuji['xingming'];
			$huiyuanlie[$k]['fuji_touxiang']=$fuji['touxiang'];	
			unset($fuji);
		}
		$huiyuanlie[$k]['hongjifen']=ChaZongShu('select sum(zhi) from '.BM('he_huiyuan_hongjifen')." where  huiyuan_id=".$hyl['id']);
		
    }
	$sql_shu='select count(*) from '.BM('zw_shangcheng_huiyuan')." g left join ".BM('he_huiyuan').' h on h.id=g.hyid where  '.$tiaojian;
	$shu=ChaZongShu($sql_shu);	
	$dengji=$mx->quDengJiLie();
	foreach($dengji as $dj){
		$dengjilie[$dj['id']]=$dj['ming'];
	}
	$fenye=FenYe($shu,$DangQianYe,$quTiaoShu);	
}elseif ($cao=="add") {	
	if(!QuanXian('tianjia')){
		XiaoXi('您的权限不够！');
	}
    $dengji=$mx->quDengJi($_J['id']);
	mb("biaoqian/huiyuan_adddengji");exit;
}elseif ($cao=="xiangqing"){
	mb("biaoqian/huiyuan_xiangqing");exit;
}elseif($cao=="shanchu"){	
	QuanXian('shanchu');
	ShanChu('zw_shangcheng_huiyuan',array('hyid'=>intval($_J['id']),'danyuan'=>$_W['danyuan']));	
	CaoZuoJiLu('删除会员成功');
	XiaoXi('删除成功',UHK('huiyuan'));	
}elseif($cao=="dengji"){
	QuanXian('dengji');
	$dengji=$mx->quDengJiLie();
}elseif($cao=="dengji_post" && $_W['ispost']){
	if(empty($_J['ming'])){
		XiaoXi('角色名称不能为空！');		
	}
	$dj=array('danyuan'=>$_W['danyuan'],
	          'dengji'=>$_J['dengji'],
	          'ming'=>trim($_J['ming']),
	          'tiaojian'=>$_J['tiaojian'],
	          'zhekou'=>$_J['zhekou'],
	          'zhuangtai'=>1,
	          );
	if(empty($_J['id'])){
		
		CaoZuoJiLu('添加等级');
		ChaRu('zw_shangcheng_huiyuan_dengji',$dj);
		XiaoXi('添加成功',UHK('huiyuan',array('c'=>'dengji')));		
	}else{
		
		Gai('zw_shangcheng_huiyuan_dengji',$dj,array('id'=>intval($_J['id']),'danyuan'=>$_W['danyuan']));		
		CaoZuoJiLu('更新等级');
		XiaoXi('更新成功',UHK('huiyuan',array('c'=>'dengji')));	
		
	}
}elseif($cao=="dengji_shanchu"){	
	ShanChu('zw_shangcheng_huiyuan_dengji',array('id'=>intval($_J['id']),'danyuan'=>$_W['danyuan']));
	CaoZuoJiLu('删除等级');
	XiaoXi('删除成功',UHK('huiyuan',array('c'=>'dengji')));	
}elseif($cao=='tixian'){
	$DangQianYe=max(1,$_J['page']);
	$quTiaoShu=10;
	$tiaojian='t.danyuan='.$_W['danyuan'];
	if(intval($_J['id'])){
		$tiaojian.=' and t.huiyuan_id='.$_J['id'];
	}
	$sql='select t.*,h.nicheng,h.touxiang,h.yu_e,h.jifen  from '.BM('he_huiyuan_tixian').' t left join '.BM('he_huiyuan').' h on t.huiyuan_id=h.id where '.$tiaojian.' order by t.shijian DESC';
	$sql.=' Limit '. ($DangQianYe - 1) * $quTiaoShu . ',' . $quTiaoShu;		
	$lie=ChaQuan($sql);	
	
	$sql='select count(*)  from '.BM('he_huiyuan_tixian').' t left join '.BM('he_huiyuan').' h on t.huiyuan_id=h.id where '.$tiaojian.' order by t.shijian DESC';
	$shu=ChaZongShu($sql);
    $fenye=FenYe($shu,$DangQianYe,$quTiaoShu);	
}elseif($cao=='tixian_dakuan'){
	if(empty($_J['id'])){
		XiaoXi('缺少ID');
	}
	$tj=array('danyuan'=>$_W['danyuan'],'id'=>$_J['id']);
	$t=Qu('he_huiyuan_tixian',$tj);
	if(empty($t)){
		XiaoXi('找不到');
	}elseif($t['dakuanfangshi']=='weixin'){
		$t['e']=$t['zhi'];			
		MX('zhifu','he')->QiYeZhiFu($t['huiyuan_id'],$t);		
	}	
	$shu['zhuangtai']=1;
	$shu['dakuanshijian']=time();
	Gai('he_huiyuan_tixian',$shu,$tj);
	
	CaoZuoJiLu('提现打款成功');
	XiaoXi('打款成功');
}elseif($cao=='jifen'){
	$where="and danyuan=:danyuan and huiyuan_id=:huiyuan_id order by shijian DESC";
	$cen=array(':danyuan'=>$_W['danyuan'],':huiyuan_id'=>$_J['id']);
	$DangQianYe = max(1, intval($_J['page']));
    $XianJiLu = 20;   
	$lie=ChaQuan('select * from '.BM('he_huiyuan_jifen').'where 1 '.$where.' limit '. ($DangQianYe - 1) * $XianJiLu . ',' . $XianJiLu,$cen);
	$shu=ChaZongShu('select count(*) from '.BM('he_huiyuan_jifen').' where 1 '.$where.'',$cen);	 	
	$zong_e=ChaZongShu('select sum(zhi) from '.BM('he_huiyuan_jifen').' where 1 '.$where.'',$cen);		
	$fenye=FenYe($shu,$DangQianYe,$XianJiLu);
}elseif($cao=='hongjifen'){
	$where="and danyuan=:danyuan and huiyuan_id=:huiyuan_id order by shijian DESC";
	$cen=array(':danyuan'=>$_W['danyuan'],':huiyuan_id'=>$_J['id']);
	$DangQianYe = max(1, intval($_J['page']));
    $XianJiLu = 20;   
	$lie=ChaQuan('select * from '.BM('he_huiyuan_hongjifen').'where 1 '.$where.' limit '. ($DangQianYe - 1) * $XianJiLu . ',' . $XianJiLu,$cen);
	$shu=ChaZongShu('select count(*) from '.BM('he_huiyuan_hongjifen').' where 1 '.$where.'',$cen);		
	$zong_e=ChaZongShu('select sum(zhi) from '.BM('he_huiyuan_hongjifen').' where 1 '.$where.'',$cen);	 	
	$fenye=FenYe($shu,$DangQianYe,$XianJiLu);
}elseif($cao=='jifen_post'){
   if(!intval($_J['jifen'])){
   	  XiaoXi('不允许为空');
   }elseif($_J['jifen']>0){
     	$sm='充值';
   }else{
      	$sm='扣除';
   }
   
   
   MX('huiyuan','he')->gai_jifen($_J['id'],$_J['jifen'],$sm);
   
   CaoZuoJiLu($sm.'积分');
   XiaoXi('更新成功','shuaxin');exit;
   
}elseif($cao=='hongjifen_post'){
   if(!intval($_J['jifen'])){
   	  XiaoXi('不允许为空');
   }elseif($_J['jifen']>0){
     	$sm='充值';
   }else{
      	$sm='扣除';
   } 
   MX('huiyuan','he')->BiZong_JiaJian('hongjifen',$_J['id'],$_J['jifen'],$sm);
   XiaoXi('更新成功','shuaxin');
   exit;
}
mb("huiyuan");
?>