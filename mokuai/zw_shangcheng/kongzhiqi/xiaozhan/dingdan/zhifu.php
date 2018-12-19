<?php
/**
 * [商城开源系统] Copyright (c) 2014 ZhiWi.COM
 *  商城群QQ：628361862  进群下载更新包 交流技术   http://www.ZhiWi.com/.
 */
DengLu(true);
$cao = empty($_J['c']) ? 'moren' : $_J['c'];
if($cao=='moren' && $_W['ispost']){			
	if(intval($_J['dingdanid'])){
		$tiaojian=' and id='.$_J['dingdanid'];
	}else{
		$tiaojian=' and dingdanhao="'.$_J['dingdanid'].'"';
	}
	
	$shu['dingdan'] = Cha('select id,dingdanhao,zongjia,shijia,jifendikou from ' . BM('zw_shangcheng_dingdan_jichu') . ' where   danyuan='. $_W['danyuan'].' and zhuangtai=0'.$tiaojian);
     if(empty($shu['dingdan'])){
    	json('订单无效',0);
    }
    DingDan_ShangPin($shu['dingdan']['dingdanhao']);
    $shu['zhifu'] = MX('zhifu', 'he')->PeiZhi();          
    $shu['zong_yu_e'] = MX('huiyuan', 'he')->qu_yu_e($_W['huiyuan']['id']);
    json($shu);    
}else if($cao=='zhifu'){	
	if(intval($_J['dingdanid'])){
		$tiaojian=' and id='.$_J['dingdanid'];
	}else{
		$tiaojian=' and dingdanhao="'.$_J['dingdanid'].'"';
	}
    $dingdan = Cha('select id,dingdanhao,zongjia,shijia,jifendikou,zhuangtai from ' . BM('zw_shangcheng_dingdan_jichu') . ' where  danyuan='. $_W['danyuan'].' and zhuangtai=0'.$tiaojian);     
    DingDan_ShangPin($dingdan['dingdanhao']);
    
    if($dingdan['zhuangtai']>0){
    	json('已支付',0);
    }	
	
    if($_J['jifendikou']){
	    $zong_jifen = MX('huiyuan', 'he')->qu_jifen($_W['huiyuan']['id']);  
	    if($dingdan['jifendikou']>=$zong_jifen || empty($zong_jifen)){    	
	       json('积分不足',0);
	    }
    }
   
    if($_J['zhifuqudao']=='weixin'){     	   	
    	if($_W['zhongduan']=='xiaochengxu'){
    		$zhifu = MX('zhifu', 'he')->XiaoChengXu_WXZhiFu($dingdan);  
    		json($zhifu);
    	}   
    	$zhifu = MX('zhifu', 'he')->WeiXin($dingdan);      	
        $tiaozhuan = UXK('dingdan/dingdan');    
    	mb('zhifu','APP');exit;
    }else{    	
    	 $_J['zhifuqudao']($dingdan);
    }
	exit;
}elseif($cao == 'fanhui'){
	$dingdan = Qu('zw_shangcheng_dingdan_jichu', array('dingdanhao' => $_J['out_trade_no']), 'id');
    TiaoZhuan(UXK('dingdan/dingdan'));
    exit;
}
mb('zhifu');


function DingDan_ShangPin($dingdanid){
	$DingDanShangpin = MX()->quDingDanShangpin($dingdanid);
	foreach ($DingDanShangpin as $k => $v) {
	     if (empty($v['zhuangtai'])) {	    
	        json('订单无效', 0);		     
	    }
	    if ($v['kucun'] < $v['shuliang']) {      
	        json('库存不足', 0);		    
	    }
	    
	}  
}

function zhifubao($dingdan){	
     return MX('zhifu', 'he')->ZhiFuBao($dingdan);	
}
function daofu($dingdan){	
	global $_W;	
    $zf=MX('zhifu', 'he')->DaoFu($dingdan);	
    if($_W['zhongduan']=='app' || $_W['zhongduan']=='xiaochengxu'){
        if($zf){
            json($zf);
         }
         json('不支持货到付款',0);
    }   
    if ($zf) {       
        XiaoXi('货到付款下单成功', UXK('dingdan/dingdan'));
    } else {       
        XiaoXi('不支持货到付款', UXK('dingdan/dingdan'));
    }
}
function appzhifubao($dingdan){
	$zf = MX('zhifu', 'he')->APPZhiFuBao($dingdan); 
	return json($zf, 1);
}

function yu_e($dingdan){
	global $_W;		
	$zf = MX('zhifu', 'he')->YuE($dingdan);		
    if($_W['zhongduan']=='app' || $_W['zhongduan']=='xiaochengxu'){
        if($zf){
            json($zf);
         }
         json('余额不足',0);
    }   
    if ($zf) {       
        XiaoXi('余额支付成功', UXK('dingdan/dingdan'));
    } else {       
        XiaoXi('余额支付失败', UXK('dingdan/dingdan'));
    }
}
function appweixin($dingdan){
	if ($dingdan) {
    	$zhifu = MX('zhifu', 'he')->APPWXZhiFu($dingdan);
        json($zhifu, 1);
    }
    json('没此订单', 0);
}
function jifen($dingdan){	
	$zf = MX('zhifu', 'he')->JiFen($dingdan);	
    if($_W['zhongduan']=='app'  || $_W['zhongduan']=='xiaochengxu'){
        if($zf){
            json($zf);
         }
         json('积分不足',0);
    }     
    if ($zf) {
        if (isset($_J['comeform']) && $_J['comeform'] == 'app') {
            json(array("code" => 1));
        }
        XiaoXi('积分支付成功', UXK('dingdan/dingdan'));
    } else {
        if (isset($_J['comeform']) && $_J['comeform'] == 'app') {
            json(array("code" => 0));
        }
        XiaoXi('积分支付不足', UXK('dingdan/dingdan'));
    }
}

?>