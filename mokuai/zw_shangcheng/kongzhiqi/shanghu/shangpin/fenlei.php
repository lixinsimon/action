<?php
DengLu();
if(empty($_J['d'])){
   XiaoXi('您的权限不够！');
}
QuanXian();
$cao=empty($_J['c'])?'moren':$_J['c'];
$feilei_mx=MX();
$feileilie=$feilei_mx->quQuanShangHuFenLei();	
if($cao=='moren'){
	
	
	
}elseif ($cao=="add") {	
	$add_id=empty($_J['id'])?'':$_J['id'];			
	mb("biaoqian/fenlei2");exit;
}elseif ($cao=="edit") {
	$feilei=$feilei_mx->quFenLei($_J['id']);	
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
	     'tu'=>$_J['tu'],
	     'zhiurl'=>$_J['zhiurl'],
	     'shouye'=>intval($_J['shouye']),
	     'zhuangtai'=>intval($_J['zhuangtai']),
		 'shanghu'=>$_W['shanghu']['id']	     
	     );
	if(!empty($_J['fid']) && $_J['fid']>0){
		Gai('zw_shangcheng_fenlei_xiaozhan',$fl,array('id'=>intval($_J['fid']),'danyuan'=>$_W['danyuan']));
	    XiaoXi('更新成功');exit;
	}else{
		ChaRu('zw_shangcheng_fenlei_xiaozhan',$fl);
	    XiaoXi('添加成功');exit;
	}
	
}elseif($cao=='shanchu'){
	ShanChu('zw_shangcheng_fenlei_xiaozhan',array('id'=>$_J['id'],'danyuan'=>$_W['danyuan'],'shanghu'=>$_W['shanghu']['id']));
	ShanChu('zw_shangcheng_fenlei_xiaozhan',array('fuji_id'=>$_J['id'],'danyuan'=>$_W['danyuan'],'shanghu'=>$_W['shanghu']['id']));	
	XiaoXi('删除成功');exit;
}elseif ($cao=="shanghu") {
	$feilei=$feilei_mx->quShangHuFenLei($_W['shanghu']['id']);
	$shanghulie=ChaQuan('select * from '.BM('he_shanghu').' where caidantuijian='.$_J['id'].' and danyuan='.$_W['danyuan']);
	$shanghu=ChaQuan('select * from '.BM('he_shanghu').' where danyuan='.$_W['danyuan'].' and caidantuijian=0');
	mb("biaoqian/fenlei3");exit;
}elseif ($cao=="oopp") {
	if($_J['id']>0){
		Gai('he_shanghu',array('caidantuijian'=>$_J['id']),array('id'=>$_J['dianpuId']));	
		XiaoXi('添加成功');
	}
		XiaoXi('添加失败');
}elseif ($cao=="yichu") {
	if($_J['dianpuId']>0){
		Gai('he_shanghu',array('caidantuijian'=>0),array('id'=>$_J['dianpuId']));	
		XiaoXi('移除成功');
	}
		XiaoXi('移除失败');
}

mb("fenlei");
?>