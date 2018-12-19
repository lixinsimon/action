<?php
/**
 * [商城开源系统] Copyright (c) 2014 ZhiWi.COM
 *  商城群QQ：628361862  进群下载更新包 交流技术   http://www.ZhiWi.com/.
 */
DengLu();
if($cao=='moren' && $_W['ispost']){
	$shu['huiyuan']=$_W['huiyuan'];
	$shu['huiyuan']['yu_e']=MX('huiyuan','he')->BiZongE('yu_e',$_W['huiyuan']['id']);
	$huiyuan=Qu('zw_shangcheng_huiyuan',array('hyid'=>$_W['huiyuan']['id']),'fenxiaodengji');
	$shu['huiyuan']['fenxiaodengji']=$huiyuan['fenxiaodengji'];
	$shu['fenxiao']=MX()->FenXiaoPeiZhi();
	$shu['dengji']=MX()->FenXiaoDengJiLie();
	$shu['fenxiao']['fenxiaoyindao']= JueDuiUrl($shu['fenxiao']['fenxiaoyindao']);	
	
	$shu['fenxiao']['xieyi']=htmlspecialchars_decode($shu['fenxiao']['xieyi']);
	json($shu);
}elseif($cao=='zhifu'  && $_W['ispost']){	
	if(empty($_J["zhifuqudao"])){
		json('支付方式',0);
	}
	$dengji=intval($_J["dengji"]);	
	if(empty($dengji)){
		 json('错误',0);
	}
	$dj=MX()->FenXiaoDengJi($dengji);   
	if(empty($dj)){
		json('升级失败',0);
	}
    $tiaojian=round($dj["tiaojian"],2);
	//生成订单号
    $shu['dingdanhao'] = ShengChengDingDanHao('he_zhifu_jilu', 'dingdanhao', 'JB');
    $shu['zongjia'] =$tiaojian;  
    //缓存充值信息，用于支付核验； 
    $cz['danyuan']=$_W['danyuan'];    
    $cz['hyid']=$_W['huiyuan']['id']; 
    $cz['dingdanhao']=$shu['dingdanhao'];
    $cz['jin_e']=$tiaojian;
    $cz['shijian']=SHIJIAN;
    $cz['zhuangtai']=0;
    $cz['qita']=ShuZu_Zhuan_ZiFuChuan($dj);     
    ChaRu('he_zhifu_jilu',$cz);      
    $_J['zhifuqudao']($shu);
}



function yu_e($dingdan){
	global $_W;	  
	$zf = MX('zhifu', 'he')->YuE($dingdan,'MaiZiGe');	
	
    if($zf){
        json($zf);
     }
     json('余额不足',0);  
}
function weixin($dingdan){
	if ($dingdan) {
    	$zhifu = MX('zhifu', 'he')->WeiXin($dingdan,'','MaiZiGe');
        json($zhifu, 1);
    }
    json('没此订单', 0);
}

function appweixin($dingdan){
	if ($dingdan) {
    	$zhifu = MX('zhifu', 'he')->APPWXZhiFu($dingdan,'','MaiZiGe');
        json($zhifu, 1);
    }
    json('没此订单', 0);
}

function zhifubao($dingdan){
	global $_W;	
    if($_W['zhongduan']=='app'){
		$zhifu = MX('zhifu', 'he')->APPZhiFuBao($dingdan,'MaiZiGe');
	}
    if($zhifu){
		json($zhifu);   
	}	
    json('支付失败',0);   
}
?>