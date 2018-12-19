<?php

if($cao=='moren'){
	$fenlei=ChaQuan('select * from'.BM('zw_shangcheng_feilei').' where fuji_id=0 and danyuan='.$_W['dy']['id']);
	$shanghu = Cha('select * from '.BM('he_shanghu').' where id = '.$_W['shanghu']['id']);
	$shanghu['kaxinxi']=ZiFuChuan_Zhuan_ShuZu($shanghu['kaxinxi']);	
	$hy=Qu('he_huiyuan',array('id'=>$shanghu['hyid']),'nicheng');
	if(empty($shanghu['kaxinxi'])){
		$shanghu['kaxinxi']=[];
	}
}elseif($cao=='bianji'){
	$kaxinxi = array(
		'ka'=>$_J['ka'],
		'bao'=>$_J['bao'],		
	);
	if(empty($_J['ming'])){		
		XiaoXi('店铺名称不能空');
	}
	if(empty($_J['ids'])){
		XiaoXi('修改失败');
	}
	if($_J['jingweidu']){
		$jingweidu = explode(',',$_J['jingweidu']);
	}else{
		$jingweidu = [];
	}
	
	$l = array(
	    'danyuan'=>$_W['danyuan'],
		'logo'=>$_J['logo'],
		'yingyezhao'=>$_J['yingyezhao'],
		'nicheng'=>$_J['nicheng'],
		'dianhua'=>$_J['dianhua'],
		'hyid'=>$_J['hyid'],
		'kaxinxi'=>ShuZu_Zhuan_ZiFuChuan($kaxinxi),
		'QQ'=>$_J['QQ'],
		'youxiang'=>$_J['youxiang'],
		'ming'=>$_J['ming'],
		'xiangxidizhi'=>$_J['xiangxidizhi'],
		'sheng'=>$_J['sheng'],
		'shi'=>$_J['shi'],
		'xian'=>$_J['xian'],	
		'miaosu'=>$_J['miaosu'],
		'jingdu'=>$jingweidu[0],
		'weidu'=>$jingweidu[1],
		'fenlei'=>$_J['leibie'],
	);
	Gai('he_shanghu',$l,array("id" => $_W['shanghu']['id']));
	XiaoXi('修改成功');
}elseif($cao=='weixin' || $cao=='xiaochengxu'){
	if($_W['ispost']){
		if($_J['weixin']){
		   $shu['weixin']=ShuZu_Zhuan_ZiFuChuan($_J['weixin']);
		}
		if($_J['xiaochengxu']){
		   $shu['xiaochengxu']=ShuZu_Zhuan_ZiFuChuan($_J['xiaochengxu']);
		}	
		Gai('zw_shanghu_peizhi',$shu,array('shanghu'=>$_W['shanghu']['id'])); 
		XiaoXi('更新成功');exit;
	}
	$pz=MX('moxing','zw_shanghu')->PeiZhi($_W['shanghu']['id'],$cao);	
	if(empty($pz)){
		$s['danyuan']=$_W['dy']['id'];
		$s['shanghu']=$_W['shanghu']['id'];
		ChaRu('zw_shanghu_peizhi',$s);
		$pz=array();
	}	
	
}elseif($cao=='zhifu'){	
	if($_W['ispost']){
		han('wenjian');
		$wenwenjian=array();		
		foreach($_FILES as $k=>$f){			
			foreach($f["name"] as $kk=>$ff){				
				$wenwenjian[$k][$kk]["name"]=$ff;
				$wenwenjian[$k][$kk]["type"]=$f['type'][$kk];
				$wenwenjian[$k][$kk]["tmp_name"]=$f['tmp_name'][$kk];
				$wenwenjian[$k][$kk]["error"]=$f['error'][$kk];
				$wenwenjian[$k][$kk]["size"]=$f['size'][$kk];
				if($ff){
				 $ming=$kk.'_'.$_W['shanghu']['id'];			
			     ShangZhengShu($wenwenjian[$k][$kk],$k,$ming);				
		       }			   
			}		
			
		}
		$config=array();
		$config['huodao']=$_J['huodao']	;
		$config['yu_e']['kaiguan']=$_J['yu_e']['kaiguan'];
		if($_J['yu_e']['recharge']){
			foreach($_J['yu_e']['recharge'] as $k=>$r){
			$config['yu_e']['recharge'][$k]=$r;
			$config['yu_e']['back'][$k]=$_J['yu_e']['back'][$k];
		    }
		}
				
		$config['alipay']=$_J['alipay']	;
		$config['wechat']=$_J['wechat']	;	
		$config['appwechat']=$_J['appwechat'];	
	    $config['xiaochengxu']=$_J['xiaochengxu'];
	    
	
		$shu['zhifu']=ShuZu_Zhuan_ZiFuChuan($config);			
		Gai('zw_shanghu_peizhi',$shu,array('shanghu'=>$_W['shanghu']['id'])); 
	    XiaoXi('更新成功');
		
		
	}	
	$peizhi=MX('moxing','zw_shanghu')->PeiZhi($_W['shanghu']['id'],$cao);	
	if(empty($peizhi)){
		$s['danyuan']=$_W['dy']['id'];
		$s['shanghu']=$_W['shanghu']['id'];
		ChaRu('zw_shanghu_peizhi',$s);
		$zhifu=array();
	}
	$zhifu=$peizhi['zhifu'];
	$path = GENMULU . "/gongyong/shangchuan/zhengshu/";
	$wx_apiclient_cert=$path.'wechat/apiclient_cert_'.$_W['shanghu']['id'].'_'.$_W['dy']['id'].'.pem';
	$wx_apiclient_key=$path.'wechat/apiclient_key_'.$_W['shanghu']['id'].'_'.$_W['dy']['id'].'.pem';
	$wx_rootca=$path.'wechat/rootca_'.$_W['shanghu']['id'].'_'.$_W['dy']['id'].'.pem';
	if(is_file($wx_apiclient_cert)){
		$zhifu['wechat']['apiclient_cert']=true;
	}
	if(is_file($wx_apiclient_key)){
		$zhifu['wechat']['apiclient_key']=true;
	}
	if(is_file($wx_rootca)){
		$zhifu['wechat']['rootca']=true;
	}
	
	$app_apiclient_cert=$path.'appwechat/apiclient_cert_'.$_W['shanghu']['id'].'_'.$_W['dy']['id'].'.pem';
	$app_apiclient_key=$path.'appwechat/apiclient_key_'.$_W['shanghu']['id'].'_'.$_W['dy']['id'].'.pem';
	$app_rootca=$path.'appwechat/rootca_'.$_W['shanghu']['id'].'_'.$_W['dy']['id'].'.pem';
	
	if(is_file($app_apiclient_cert)){
		$zhifu['appwechat']['apiclient_cert']=true;
	}
	if(is_file($app_apiclient_key)){
		$zhifu['appwechat']['apiclient_key']=true;
	}
	if(is_file($app_rootca)){
		$zhifu['appwechat']['rootca']=true;
	}
	
	$app_apiclient_cert=$path.'xiaochengxu/apiclient_cert_'.$_W['shanghu']['id'].'_'.$_W['dy']['id'].'.pem';
	$app_apiclient_key=$path.'xiaochengxu/apiclient_key_'.$_W['shanghu']['id'].'_'.$_W['dy']['id'].'.pem';
	$app_rootca=$path.'xiaochengxu/rootca_'.$_W['shanghu']['id'].'_'.$_W['dy']['id'].'.pem';
	
	if(is_file($app_apiclient_cert)){
		$zhifu['xiaochengxu']['apiclient_cert']=true;
	}
	if(is_file($app_apiclient_key)){
		$zhifu['xiaochengxu']['apiclient_key']=true;
	}
	if(is_file($app_rootca)){
		$zhifu['xiaochengxu']['rootca']=true;
	}
	
		
	
		
}elseif($cao=='xiugaixinxi'){
	$p=array(
	'lunbo'=>ShuZu_Zhuan_ZiFuChuan($_J['banner'])
	);
	Gai('he_shanghu',$p,array("danyuan" => $_W['danyuan'],'id'=>$_W['shanghu']['id']));
	XiaoXi('修改成功');
}elseif($cao=='xinxi'){
	$shanghu = Cha('select * from '.BM('he_shanghu').' where id='.$_W['shanghu']['id'].' and danyuan = '.$_W['danyuan']);
	$shanghu['lunbo'] = ZiFuChuan_Zhuan_ShuZu($shanghu['lunbo']);
	if(empty($shanghu['lunbo'])){ 	
		$shanghu['lunbo']=[];
	}

}
mb('shanghu');



?>