<?php
DengLu();
$cao=empty($_J['c'])?'moren':$_J['c'];
if($cao=='moren' && $_W['ispost']){	
	$dizhilie=ChaQuan('select * from '.BM('zw_shangcheng_dizhi').' where danyuan='.$_W['danyuan'].' and huiyuan='.$_W['huiyuan']['id']);
	json($dizhilie);
}elseif($cao=='dizhi_add' || $cao=='dizhi_edit'){
	$id=$_J['id'];
	if($id>0){
		$dizhi=Cha('select * from '.BM('zw_shangcheng_dizhi').' where danyuan='.$_W['danyuan'].' and huiyuan='.$_W['huiyuan']['id'].' and id='.$id);	
	    if($_W['ispost']){
	    	if($dizhi){
	    		json($dizhi);
	    	}else{
	    		json('没找到地址',0);
	    	}
		     
	   }
	}
		
	mb('dizhi_add');exit;
}elseif($cao=='post'){
	if(empty($_J['ming'])){
		json('收货人不能空',0);;
	}
	if(!preg_match("/1{1}\d{10}$/", $_J['dianhua'])){
		json('手机号错误!',0);
	}
	if(empty($_J['shengshiqu']) || $_J['shengshiqu']=='请选择'){
		json('所在地区不能为空',0);;
	}
	if(empty($_J['dizhi'])){
		json('详细地址不能空',0);;
	}
	$dizhi=array(
	      'danyuan'=>$_W['danyuan'],
	      'huiyuan'=>$_W['huiyuan']['id'],
	      'ming'=>GuoLvTeShuZiFu($_J['ming']),
	      'dianhua'=>$_J['dianhua'],
	      'shengshiqu'=>$_J['shengshiqu'],
	      'dizhi'=>GuoLvTeShuZiFu($_J['dizhi']),
	      'moren'=>0
    );
	$id=intval($_J['id']);
	

	
	if($id>0){
       Gai('zw_shangcheng_dizhi',$dizhi,array('id'=>$id,'huiyuan'=>$_W['huiyuan']['id']));    
       
	}else{
	   ChaRu('zw_shangcheng_dizhi',$dizhi);
	   $id=ChaRuID();
	}
	json($id);
}elseif($cao=='shanchu'){
	$sc=ShanChu('zw_shangcheng_dizhi',array('id'=>$_J['id'],'huiyuan'=>$_W['huiyuan']['id'],'danyuan'=>$_W['danyuan']));
	if($sc){
		json('删除成功');
	}
	json('删除失败',0);
}elseif($cao=='shezhimoren'){
	Gai('zw_shangcheng_dizhi',array('moren'=>0),array('moren'=>1,'huiyuan'=>$_W['huiyuan']['id'],'danyuan'=>$_W['danyuan']));
	Gai('zw_shangcheng_dizhi',array('moren'=>1),array('id'=>$_J['id'],'huiyuan'=>$_W['huiyuan']['id'],'danyuan'=>$_W['danyuan']));
    json('OK');
}
mb('dizhi');
?>