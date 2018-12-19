<?php
DengLu();
$cao=empty($_J['c'])?'moren':$_J['c'];
$b=empty($_J['b'])?'moren':$_J['b'];
if($_W['yonghu']['shenfen']>3 || empty($_W['yonghu']['shenfen'])){
		XiaoXi('你的权限不够');
}
$shenfenming=array('1'=>'超级管理员','2'=>'代理人','3'=>'管理员','4'=>'操作员');
$zu_lie=ChaQuan('select * from '.BM('he_guanliyuan_zu').' order by id ASC');

$danyuan_lie=ChaQuan('select * from '.BM('he_danyuan').' order by id ASC');

if($cao=='moren'){	
    $where='';
	if($_W['yonghu']['shenfen']>0 && $_J['d']>0){		
		$where=" and danyuanid=:danyuanid";
	    $cen=array(':danyuanid'=>$_J['d']);	
	     $ids=$_W['yonghu']['id'].',';
	    $dygl=ChaQuan('select guanliyuanid from '.BM('he_danyuan_guanliyuan')." where 1 ".$where,$cen);
	    foreach($dygl as $d){
	    	$ids.=$d['guanliyuanid'].',';
	    }	  
	    $where=' where id in('.rtrim($ids,',').') and shenfen>='.$_W['yonghu']['shenfen'];
	}	
	$gl=ChaQuan('select * from '.BM('he_guanliyuan').$where." order by zhuceshijian DESC");  
	
	
   
}elseif($cao=='bianji'){	
	$gl=Qu('he_guanliyuan',array('id'=>$_J['id']));	
	if($_W['danyuan'] && $_J['id']){
	  $dy=Qu('he_danyuan_guanliyuan',array('guanliyuanid'=>$_J['id'],'danyuanid'=>$_W['danyuan']));	
	  $danyuanid=$dy['danyuanid'];	
	}	
	
}elseif($cao=='guanliyuan_tianjia'){
	$yonghuming=trim($_J['yonghuming']);
	if(empty($yonghuming)){
		XiaoXi('用户不能为空');
	}
	if(empty($_J['mima'])){
		XiaoXi('用户不能为空');
	}
	$cunzai=Qu('he_guanliyuan',array('yonghuming'=>$yonghuming));
	if($cunzai){
		XiaoXi('用户已存在');
	}
	if($_W['yonghu']['shenfen']>3 || empty($_W['yonghu']['shenfen'])){
		XiaoXi('你的权限不够');
	}
	if($_W['yonghu']['shenfen']==3){
		$_J['shenfen']=4;
	}
	$shu=array(
	     'yonghuming'=>$yonghuming,
	     'mima'=>md5($_J['mima']),
	     'zhuceshijian'=>time(),
	     'kaishishijian'=>time(),
	     'jieshushijian'=>strtotime($_J['jieshushijian']),	     
	     'yonghuzu'=>empty($_J['yonghuzu'])?1:$_J['yonghuzu'],
	     'miaoshu'=>$_J['miaoshu'],
	     'zhuangtai'=>1
	     );
	if($_J['shenfen']>2){
		$shu['shenfen']=$_J['shenfen'];
	}
		  
	ChaRu('he_guanliyuan',$shu);
	$id=ChaRuID();
	$_J['danyuanid']=empty($_J['danyuanid'])?$_W['danyuan']:$_J['danyuanid'];
	 CaoZuoJiLu('添加管理员'); 
	if($_J['danyuanid']>0 && $id>0){
		$s=array('danyuanid'=>$_J['danyuanid'],'guanliyuanid'=>$id);
		ChaRu('he_danyuan_guanliyuan',$s);
	};	
	XiaoXi('添加成功',UH('xitong/guanliyuan'));
}elseif($cao=='guanliyuan_bianji'){		
	if(empty($_J['id'])){
		XiaoXi('修改对象错误');
	}	
	if($_W['yonghu']['shenfen']>2 || empty($_W['yonghu']['shenfen'])){
		XiaoXi('你的权限不够');
	}
	$shu=array(    
	     'jieshushijian'=>strtotime($_J['jieshushijian']),	   
	     'yonghuzu'=>empty($_J['yonghuzu'])?1:$_J['yonghuzu'],
	     "miaoshu"=>$_J['miaoshu'],	    
	     );
	if($_J['shenfen']>2){
		$shu['shenfen']=$_J['shenfen'];
	}     
	
	if($_J['mima']){
		$shu['mima']=md5($_J['mima']) ;
	}	
	 CaoZuoJiLu('修改管理员'); 
	Gai('he_guanliyuan',$shu,array('id'=>$_J['id']));
	$s=array('danyuanid'=> $_J['jiudanyuanid'],'guanliyuanid'=>$_J['id']);	
	if($_J['id'] && $_J['danyuanid']){
		$dd=Qu('he_danyuan_guanliyuan',$s);
		if($dd){
		   Gai('he_danyuan_guanliyuan',array('danyuanid'=>$_J['danyuanid']),$s);	
		}else{		
			$s['danyuanid']=$_J['danyuanid'];			
			ChaRu('he_danyuan_guanliyuan',$s);
		}
		
	}elseif(empty($_J['danyuanid'])){		
		ShanChu('he_danyuan_guanliyuan',$s);
	}
	
	
	XiaoXi('修改成功',UH('xitong/guanliyuan'));
}elseif($cao=='shanchu'){		
	ShanChu('he_guanliyuan',array('id'=>$_J['id']));
	ShanChu('he_danyuan_guanliyuan',array('guanliyuanid'=>$_J['id']));
	 CaoZuoJiLu('删除管理员'); 
	XiaoXi('删除成功',UH('xitong/guanliyuan'));exit;	
}elseif($cao=='zu_post'){  
	if($_W['ispost']){
		if(empty($_J['zuming'])){
			XiaoXi('用户组名称不能为空！');
		}
		$zu_=array(
		     'zuming'=>trim($_J['zuming']),
		     'gongzhonghao_shu'=>intval($_J['gongzhonghao_shu']),
		     'youxiao_tian'=>intval($_J['youxiao_tian']),
		    );
		 CaoZuoJiLu('管理组'); 
		if(!empty($_J['id'])){
			Gai('he_guanliyuan_zu',$zu_,array('id'=>$_J['id']));	
		    XiaoXi('更新管理组成功！',UH('xitong/guanliyuan',array('b'=>'zulie')));	
		}else{
			ChaRu('he_guanliyuan_zu',$zu_);	
			XiaoXi('添加管理组成功！',UH('xitong/guanliyuan',array('b'=>'zulie')));		
		}
		
	}	
	
}elseif($cao=='zu_bianji'){
	$zu_edit=Cha('select * from '.BM('he_guanliyuan_zu').' where id='.$_J['id']);
	mb('biaoqian/guanliyuan_zu_post');exit;
}elseif($cao=='zu_shanchu'){
	if($_W['yonghu']['shenfen']!=1){
		XiaoXi('权限不够！');
	}
	ShanChu('he_guanliyuan_zu',array('id'=>$_J['id']));
	CaoZuoJiLu('删除管理组'); 
	XiaoXi('删除成功！',UH('xitong/guanliyuan',array('b'=>'zulie')));
}
mb('guanliyuan');
?>