<?php
DengLu();
if(empty($_J['d'])){
   XiaoXi('您的权限不够！');
}
QuanXian();
$cao=empty($_J['c'])?'moren':$_J['c'];

$feileilie=ChaQuan('select * from '.BM('he_wenzhang_fenlei').' where danyuan='.$_W['danyuan'].' and fuji_id=0  order by shunxu ASC');
foreach($feileilie as $k=>$feil){
	$feileilie[$k]['haizi']=ChaQuan('select * from '.BM('he_wenzhang_fenlei').' where danyuan='.$_W['danyuan'].' and fuji_id='.$feil['id'].' order by shunxu ASC');
}

if($cao=='moren'){
	
}elseif ($cao=="add") {	
	$add_id=empty($_J['id'])?'':$_J['id'];			
	mb("biaoqian/fenlei2");exit;
}elseif ($cao=="edit") {
	$feilei=Cha('select * from '.BM('he_wenzhang_fenlei').' where danyuan='.$_W['danyuan'].' and id='.$_J['id'].' order by shunxu ASC');	
	mb("biaoqian/fenlei2");exit;
}elseif($cao=='post' && $_W['ispost']){
	if(empty($_J['ming'])){
		XiaoXi('名称不为空！');
	}
	$fl=array(
	     'danyuan'=>$_W['danyuan'],
	     'ming'=>trim($_J['ming']),
	     'fuji_id'=>intval($_J['fuji_id']),
	     'shunxu'=>$_J['shunxu'],
	     'tu'=>$_J['tu']
	);
	if(!empty($_J['fid']) && $_J['fid']>0){
		Gai('he_wenzhang_fenlei',$fl,array('id'=>intval($_J['fid']),'danyuan'=>$_W['danyuan']));
		 CaoZuoJiLu('更新文章分类');  
	    XiaoXi('更新成功');exit;
	}else{
		ChaRu('he_wenzhang_fenlei',$fl);
		 CaoZuoJiLu('新增文章分类'); 
	    XiaoXi('新增成功');exit;
	}
}elseif($cao=='shanchu'){
	ShanChu('he_wenzhang_fenlei',array('id'=>$_J['id'],'danyuan'=>$_W['danyuan']));
	ShanChu('he_wenzhang_fenlei',array('fuji_id'=>$_J['id'],'danyuan'=>$_W['danyuan']));	
	CaoZuoJiLu('删除文章分类'); 
	XiaoXi('删除成功');exit;
}

mb("fenlei");
?>