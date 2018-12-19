<?php
/**
 * [商城开源系统] Copyright (c) 2014 ZhiWi.COM
 *  商城群QQ：628361862  进群下载更新包 交流技术   http://www.ZhiWi.cn/.
 */
DengLu();
$cao=empty($_J['c'])?'moren':$_J['c'];
$yh=Qu('zw_shangcheng_huiyuan',array('hyid'=>$_W['huiyuan']['id'],'danyuan'=>$_W['danyuan']));

if($cao=='moren' && $_W['ispost']){
	$huiyuan=Qu('zw_shangcheng_huiyuan',array('hyid'=>$_W['huiyuan']['id'],'danyuan'=>$_W['danyuan']));

	
   if($huiyuan['kahao']){
   	 $huiyuan['kahao']='****************'.substr($yh['kahao'],-4);
   }  
   json($huiyuan);
}elseif($cao=='post' && $_W['ispost']){	
    if(empty($_J['kaihuming'])){
    	json('开户名不能空',0);
    }
    if(empty($_J['kahao'])){
    	json('账号不能空',0);
    }
    if(empty($_J['yinhang']) && empty($yh['yinhang'])){
    	json('请选择银行',0);
    }
    if(empty($_J['kaihuhang'])){
    	json('开户行不能空',0);
    }
    $shu=array(
          'zhifubao_zhanghao'=>trim($_J['zhifubao_zhanghao']),       
          'zhifubao_ming'=>trim($_J['zhifubao_ming']),          
          );
    if(empty($yh['kaihuming'])){
    	 $shu['kaihuming']=$_J['kaihuming'];
    } 
    if(empty($yh['kahao'])){
    	 $shu['kahao']=$_J['kahao'];
    }
    if(empty($yh['yinhang'])){
    	 $shu['yinhang']=$_J['yinhang'];
    }
    if(empty($yh['kaihuhang'])){
    	 $shu['kaihuhang']=$_J['kaihuhang'];
    }         
    Gai('zw_shangcheng_huiyuan',$shu,array('hyid'=>$_W['huiyuan']['id'],'danyuan'=>$_W['danyuan']));
    json('提交成功');
}
mb('wanshanxinxi');
?>