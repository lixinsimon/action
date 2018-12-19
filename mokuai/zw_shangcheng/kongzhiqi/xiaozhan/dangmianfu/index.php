<?php



if($cao=='moren' && $_W['ispost']){
	if(empty($_J['sh'])){
		json('请扫描正确的二维码');
	}else{
		$shuju=Cha('select * from'.BM('he_shanghu').' where danyuan='.$_W['danyuan'].' and id='.$_J['sh']);
	}	
	$shuju['logo']=JueDuiUrl($shuju['logo']);
	$shuju['shid']=$_J['sh'];
	json($shuju);
}elseif($cao=='zhifu' && $_W['ispost']){
    $shu['dingdanhao'] = ShengChengDingDanHao('he_zhifu_jilu', 'dingdanhao', 'BM');
	$shu['zongjia'] = $_J['jin_e'];
	$shu['shid'] = $_J['shid'];
	
	$jifen=Cha('select * from'.BM('zw_dangmianfu_zhuanhua').' where danyuan='.$_W['danyuan'].' and shid='.$_J['shid']);	
	$xin=array(
	'jin_e'=>$_J['jin_e'],
	'zhifuqudao'=>$_J['zhifuqudao'],
	'shanghuid'=>$_J['shid'],
	);

	if($jifen['id']>0){
		$jifenbi = ZiFuChuan_Zhuan_ShuZu($jifen['zhuanhua']);
		rsort($jifenbi);
		foreach($jifenbi as $l){
			if($_J['jin_e']>$l['jin_e']){
				$yonghuxinxi=Qu('he_huiyuan',array('id'=>$_W['huiyuan']['id'],'danyuan'=>$_W['danyuan']));
				$yonghuxinxi['jifen'] = $yonghuxinxi['jifen']+$l['jifen'];
				$xin['zengsongjifen']=$l['jifen'];
				Gai('he_huiyuan',array('jifen'=>$yonghuxinxi['jifen']),array('id'=>$_W['huiyuan']['id'],'danyuan'=>$_W['danyuan']));
				break;
			}
		}
	}
	//缓存充值信息，用于支付核验
	$l=array(
		'hyid'=>$_W['huiyuan']['id'],
		'jin_e'=>$_J['jin_e'],
		'dingdanhao'=>$shu['dingdanhao'],
		'danyuan'=>$_W['danyuan'],
		'shijian'=>time(),
		'qita'=>ShuZu_Zhuan_ZiFuChuan($xin),
		'zhuangtai'=>0
	);
	ChaRu('he_zhifu_jilu',$l);
	if($_J['zhifuqudao']=='weixin'){
		if($_W['zhongduan']=='xiaochengxu'){
    		$zhifu = MX('zhifu', 'he')->XiaoChengXu_WXZhiFu($shu,'','NaiCha');  
    		json($zhifu);
    	}
    	$zhifu = MX('zhifu', 'he')->WeiXin($shu,'','NaiCha');     	   
        $tiaozhuan = UXK('dangmianfu/zhifujieshu',array('shid'=>$_J['shid']));    
    	mb('zhifu','APP');exit;
    }else{
    	$_J['zhifuqudao']($shu);   
    }
}


mb('index');

function yu_e($dingdan){
	global $_W;		
	$zf = MX('zhifu', 'he')->YuE($dingdan,'NaiCha');		
    if($_W['zhongduan']=='app' || $_W['zhongduan']=='xiaochengxu'){
        if($zf){
            json($zf);
         }
         json('余额不足',0);
    }   
    if ($zf) {
        XiaoXi('余额支付成功', UXK('dangmianfu/zhifujieshu',array('shid'=>$dingdan['shid'])));
    } else {       
        XiaoXi('余额支付失败');
    }
}

?>