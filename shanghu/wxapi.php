<?php
/**
 * [知微开源系统] Copyright (c) 2014 ZhiWi.COM
 *  知微群QQ：628361862  进群下载更新包 交流技术   http://www.ZhiWi.com/.
 */
require '../neihe/he.php';
$input = file_get_contents('php://input');
if (!empty($input)) {
	if (preg_match('/(\<\!DOCTYPE|\<\!ENTITY)/i', $input)) {
		exit('fail');
	}
	libxml_disable_entity_loader(true);
	$obj = simplexml_load_string($input, 'SimpleXMLElement', LIBXML_NOCDATA);
	$shu = json_decode(json_encode($obj), true);	
}
//
$wx=MX('weixin_shanghu');
//$uu=Qu('test',array('id'=>378));
//$_J=ZiFuChuan_Zhuan_ShuZu($uu['neirong']);
$tj=array('shanghu'=>$_J['sh'],'openid'=>$shu['FromUserName']);
//ChaRu('test',array('neirong'=>ShuZu_Zhuan_ZiFuChuan($_J)));



if($shu['MsgType']=='text' || $shu['MsgType']=='image' || $shu['MsgType']=='voice' || $shu['MsgType']=='video'){	
    $wx->JieShouXinXi($shu);
    exit('SUCCESS');
}elseif($shu['Event']=='CLICK'){
	$shu['MsgType']='text';
	$shu['Content']=$shu['EventKey'];	
	$wx->JieShouXinXi($shu);
	exit('SUCCESS');
}elseif($shu['Event']=='unsubscribe'){	
    Gai('he_huiyuan',array('guanzhu'=>0),$tj);
    ShanChu('he_fensi',$tj);
    exit('SUCCESS');
}elseif($shu['Event']=='subscribe'){		
	if(empty($shu['EventKey'])){
		Gai('he_huiyuan',array('guanzhu'=>1),$tj);   
	    $x=Qu('he_huifu_xitong',array('danyuan'=>$_W['danyuan']),'guanzhu');	
	    if($x){
	       $shu['MsgType']='text';
	       $shu['Content']=$x['guanzhu'];
	       $wx->JieShouXinXi($shu); 
	    }  	   
	}else{
		$shu['EventKey']=ltrim($shu['EventKey'],'qrscene_');
	    $E=explode('|',$shu['EventKey']);
	    $_W['mo']=$E[0];
		MX($E[1],$E[0])->$E[2]($E,$shu);		    
	}  
    exit('SUCCESS');
}elseif($shu['Event']=='SCAN'){
	$E=explode('|',$shu['EventKey']);	
	$_W['mo']=$E[0];
	MX($E[1],$E[0])->$E[2]($E,$shu);
	exit('SUCCESS');
}
$jieruyanzhen=$wx->JieRuYanZheng($_J);
if($jieruyanzhen){
	echo $jieruyanzhen;
}
?>