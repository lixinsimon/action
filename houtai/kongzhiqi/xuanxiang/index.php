<?php
DengLu();

if(empty($_J['d'])){
   XiaoXi('您的权限不够！');
}
QuanXian();
$cao=empty($_J['c'])?'moren':$_J['c'];
$peizhi=Cha('select * from '.BM('he_peizhi')." where danyuan=".$_W['danyuan']);
if($cao=='moren'){
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
			     ShangZhengShu($wenwenjian[$k][$kk],$k,$kk);				
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
		$_J['alipay']['apprsa'] = trimall($_J['alipay']['apprsa']);			
		$config['alipay']=$_J['alipay']	;
		$config['wechat']=$_J['wechat']	;	
		$config['appwechat']=$_J['appwechat'];
		$config['yinlian']=$_J['yinlian'];
		$config['baifubao']=$_J['baifubao'];
	    $config['xiaochengxu']=$_J['xiaochengxu'];
		$zhifupeizhi=ShuZu_Zhuan_ZiFuChuan($config);
		$peizhi_cha=array('danyuan'=>$_W['danyuan'],'zhifu'=>$zhifupeizhi);		
		CaoZuoJiLu('更新支付配置'); 
		if($peizhi){
			unset($peizhi_cha['danyuan']);
			Gai('he_peizhi',$peizhi_cha,array('danyuan'=>$_W['danyuan']));	
		    XiaoXi('更新成功',UH('xuanxiang'));
		}else{
			ChaRu('he_peizhi',$peizhi_cha);	
		    XiaoXi('提交成功',UH('xuanxiang'));
		}
		
	}
}
$zhifu=ZiFuChuan_Zhuan_ShuZu($peizhi['zhifu']);
$path = GENMULU . "/gongyong/shangchuan/zhengshu/";
$wx_apiclient_cert=$path.'wechat/apiclient_cert_'.$_W['danyuan'].'.pem';
$wx_apiclient_key=$path.'wechat/apiclient_key_'.$_W['danyuan'].'.pem';
$wx_rootca=$path.'wechat/rootca_'.$_W['danyuan'].'.pem';
if(is_file($wx_apiclient_cert)){
	$zhifu['wechat']['apiclient_cert']=true;
}
if(is_file($wx_apiclient_key)){
	$zhifu['wechat']['apiclient_key']=true;
}
if(is_file($wx_rootca)){
	$zhifu['wechat']['rootca']=true;
}

$app_apiclient_cert=$path.'appwechat/apiclient_cert_'.$_W['danyuan'].'.pem';
$app_apiclient_key=$path.'appwechat/apiclient_key_'.$_W['danyuan'].'.pem';
$app_rootca=$path.'appwechat/rootca_'.$_W['danyuan'].'.pem';

if(is_file($app_apiclient_cert)){
	$zhifu['appwechat']['apiclient_cert']=true;
}
if(is_file($app_apiclient_key)){
	$zhifu['appwechat']['apiclient_key']=true;
}
if(is_file($app_rootca)){
	$zhifu['appwechat']['rootca']=true;
}

$app_apiclient_cert=$path.'xiaochengxu/apiclient_cert_'.$_W['danyuan'].'.pem';
$app_apiclient_key=$path.'xiaochengxu/apiclient_key_'.$_W['danyuan'].'.pem';
$app_rootca=$path.'xiaochengxu/rootca_'.$_W['danyuan'].'.pem';

if(is_file($app_apiclient_cert)){
	$zhifu['xiaochengxu']['apiclient_cert']=true;
}
if(is_file($app_apiclient_key)){
	$zhifu['xiaochengxu']['apiclient_key']=true;
}
if(is_file($app_rootca)){
	$zhifu['xiaochengxu']['rootca']=true;
}
if(empty($zhifu)){
	$zhifu=array();
}

if(empty($zhifu['wechat']['appid'])){
	$zhifu['wechat']['appid']=$_W['dy']['appid'];
	$zhifu['wechat']['appsecret']=$_W['dy']['appsecret'];
}
mb("index");

function trimall($str){  
    $qian=array("-----BEGIN PRIVATE KEY-----","-----END PRIVATE KEY-----"," ","　","\t","\n","\r");  
    return str_replace($qian, '', $str);    
}  
?>