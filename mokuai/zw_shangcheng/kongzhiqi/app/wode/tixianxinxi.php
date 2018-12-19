<?php

DengLu();
if ($cao == 'moren' && $_W['ispost']) {
	$huiyuan=Qu('zw_shangcheng_huiyuan',array('hyid'=>$_W['huiyuan']['id']));
	if($huiyuan['xingming']){
		$huiyuan['renzheng']=1;
	}


	if(empty($huiyuan['weixin_zhanghao']) || $huiyuan['xiugaitixian']!=1){
		$huiyuan['weixinkai']=1;
	}
	if(empty($huiyuan['zhifubao_zhanghao']) || $huiyuan['xiugaitixian']!=1){
		$huiyuan['zhifubaokai']=1;
	} 
	if(empty($huiyuan['xingming']) || $huiyuan['xiugaitixian']!=1){
		$huiyuan['xingmingkai']=1;
	}
	if(empty($huiyuan['shenfenzheng']) || $huiyuan['xiugaitixian']!=1){
		$huiyuan['shenfenzhengkai']=1;
	}
	if(empty($huiyuan['kaihuyinhang']) || $huiyuan['xiugaitixian']!=1){
		$huiyuan['kaihuyinhangkai']=1;
	}
	if(empty($huiyuan['chikaren']) || $huiyuan['xiugaitixian']!=1){
		$huiyuan['chikarenkai']=1;
	}
	
	if(empty($huiyuan['shouji']) || $huiyuan['xiugaitixian']!=1){
		$huiyuan['shoujikai']=1;
	}
	if(empty($huiyuan['kahao']) || $huiyuan['xiugaitixian']!=1){
		$huiyuan['kahaokai']=1;
	}
	
	if(empty($huiyuan['kaihuhang']) || $huiyuan['xiugaitixian']!=1){
		
		$huiyuan['kaihuhangkai']=1;
	}
	 
	
	
	if($huiyuan){
		json($huiyuan);
	}else{
		json('错误',0);
	}
	
}elseif($cao == 'baocun' && $_W['ispost']){

	$huiyuan=Qu('zw_shangcheng_huiyuan',array('hyid'=>$_W['huiyuan']['id']));
	if(empty($huiyuan['xingming'])){
		json('您还未实名认证',0);
	}
	
	if(empty($_J['zhifubao_zhanghao'])){
		json('请输入支付宝',0);
	}
	if(empty($_J['chikaren'])){
		json('请输入持卡人',0);
	}
	if(empty($_J['kahao'])){
		json('请输入卡号',0);
	}
	if(empty($_J['kaihuhang'])){
		json('请输入开户银行',0);
	}
	if(empty($_J['shouji'])){
		json('请输入手机',0);
	}

	
	
	
	$shuzhu=array(
		'zhifubao_zhanghao'=>$_J['zhifubao_zhanghao'],		
		'chikaren'=>$_J['chikaren'],
		'shouji'=>$_J['shouji'],
		'kahao'=>$_J['kahao'],
		'kaihuhang'=>$_J['kaihuhang']
	);
	
	
//	if($huiyuan['xiugaitixian']!=1){
		$shuzhu['xiugaitixian']=1;
		Gai('zw_shangcheng_huiyuan',$shuzhu,array('hyid'=>$_W['huiyuan']['id']));
		json('保存成功');
//	}else{
//		json('您没有修改权限',0);
//	}
	
}

?>