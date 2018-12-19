<?php
if($cao=='moren' && $_W['ispost']){	
	$zhanghao=$_J['shouji'];
	
	$peizhi = Cha('select duanxin from ' . BM('he_peizhi') . " where danyuan=" . $_W['danyuan']);	
   	$duanxin = ZiFuChuan_Zhuan_ShuZu($peizhi['duanxin']);
	
	
	if(empty($_W['danyuan'])){
		json('缺少D值',0);
	}
	if(!preg_match("/1{1}\d{10}$/", $_J['shouji'])){
		json('手机号错误!',0);
	}
	if(empty($_J['yanzheng'])){
		json('不能为空！',0);
	}
	if($duanxin['dayu']['zhuce']['kaiguan']==1){
		$shijian=time()-1800;
		$ma=Cha('select neirong from '.BM('he_duanxin').' where shouji='.$_J['shouji'].' and shijian>'.$shijian.' order by shijian DESC');
		if($_J['yanzheng']!=$ma['neirong']){
			json('验证码不正确',0);
		}
	}
	
	
	
	$is_zhanghao=Cha('select * from '.BM('he_huiyuan').' where danyuan='.$_W['danyuan'].' and zhanghao="'.$zhanghao.'"');	
	if($is_zhanghao){
		
			$shu=array('zhanghao'=>trim($zhanghao),'shebeihao'=>$_J['shebeihao']);
			$mx=MX('huiyuan','he');	
			$denglu=$mx->AppDengLu($shu);	
			if($denglu){
				json($denglu,1);
			}else{		
				json('错误！',0);
			}
		
	}

	$zhuce=array(
	      'danyuan'=>$_W['danyuan'],
	      'zhanghao'=>$zhanghao,
	      'shouji'=>$_J['shouji'],
	);
	
	
		  
	if(DengLu(true) && $_W['zhongduan']=='weixin'){	
	    Gai('he_huiyuan',$zhuce,array('id'=>$_W['huiyuan']['id'],'danyuan'=>$_W['danyuan']));
	    
	}else{
	    $zhuce['shijian']=time();
	    $zhuce['ip']=GetIp();
	    $zhuce['fuji_id'] = intval($_J['t']);
	    ChaRu('he_huiyuan',$zhuce);
	    $cid=ChaRuId();
	    
	    $schy=array('danyuan'=>$_W['danyuan'],'hyid'=>$cid,'huiyuanshijian'=>SHIJIAN);		
		  ChaRu('zw_shangcheng_huiyuan',$schy); 
	    
	    $s['hyid']=$cid;
	    $s['leixing']=1;
	  	$s['danyuan']=$_W['danyuan'];
	    $s['neirong']='恭喜您成功注册为斑马会员';
	    $s['shijian']=SHIJIAN;
	    ChaRu('he_huiyuan_xiaoxi',$s);		
	}	

	$peizhi = Cha('select app from ' . BM('he_peizhi') . " where danyuan=" . $_W['danyuan']);	
//	$pz = ZiFuChuan_Zhuan_ShuZu($peizhi['app']);
	
	$shu=array('zhanghao'=>trim($zhanghao),'shebeihao'=>$_J['shebeihao']);
	$mx=MX('huiyuan','he');	
	$denglu=$mx->AppDengLu($shu);	
	if($denglu){
		json($denglu,1);
	}else{		
		json('错误！',0);
	}
	
	
}elseif($cao=='yanzhengma' && $_W['ispost']){	
	if(!preg_match("/1[34578]{1}\d{9}/", $_J['shouji'])){
		json('手机号错误!',0);
	}	
	$f=MX('duanxin','he')->YanZhengMa($_J['shouji']);	
	if($f){
		json('发送成功');
	}
	json('发送失败',0);
}elseif($cao=='shezhi' && $_W['ispost']){	
	$peizhi = Cha('select duanxin from ' . BM('he_peizhi') . " where danyuan=" . $_W['danyuan']);	
	if(empty($peizhi)){
		ChaRu('he_peizhi',array('danyuan'=>$_W['danyuan']));
	}	
    $shu['duanxin'] = ZiFuChuan_Zhuan_ShuZu($peizhi['duanxin']);
    $shu['tu']=$_W['shezhi']['shezhi']['logo'];
    
	json($shu);
}
mb('bangding');
?>