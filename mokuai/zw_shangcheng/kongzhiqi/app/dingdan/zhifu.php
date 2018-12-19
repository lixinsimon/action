<?php
/**
 * [商城开源系统] Copyright (c) 2014 ZhiWi.COM
 *  商城群QQ：628361862  进群下载更新包 交流技术   http://www.ZhiWi.com/.
 */
DengLu(true);
if($cao=='moren' && $_W['ispost']){			
		if(intval($_J['dingdanid'])){ 
			$tiaojian=' and id='.$_J['dingdanid'];
		}else{
			$tiaojian=' and dingdanhao="'.$_J['dingdanid'].'"';
		}
	
	  $shu['dingdan'] = Cha('select id,dingdanhao,zongjia,shijia,jifendikou,leixing from ' . BM('zw_shangcheng_dingdan_jichu') . ' where   danyuan='. $_W['danyuan'].' and zhuangtai=0'.$tiaojian);
    if(empty($shu['dingdan'])){
    	json('订单无效',0);
    }
    if($shu['dingdan']['leixing']==2){
    	$ddsp=Qu('zw_shangcheng_dingdan_shangpin',array('dingdanhao'=>$shu['dingdan']['dingdanhao']));
    	$shu['dingdan']['liquan']=$ddsp['liquan'];
    	$shu['dingdan']['xunzhang']=$ddsp['xunzhang'];
    	$shu['dingdan']['jifenkou']=$ddsp['jifenkou'];
    	
    	$shu['jifen']=MX('huiyuan','he')->BiZongE('jifen',$_W['huiyuan']['id']);

	    if($ddsp['jifenkou']>	$shu['jifen']){
	    	 json('和券不足',0);
	    }		 
    }
    
    
    DingDan_ShangPin($shu['dingdan']['dingdanhao']);
    $shu['zhifu'] = MX('zhifu', 'he')->PeiZhi();  
		if($_W['zhongduan']=='app'){       
			$shu['zhifu']['wechat']['kaiguan']=$shu['zhifu']['appwechat']['kaiguan'];
		}elseif($_W['zhongduan']=='xiaochengxu'){
			$shu['zhifu']['wechat']['kaiguan']=$shu['zhifu']['xiaochengxu']['appwechat'];	
			$shu['zhifu']['alipay']['kaiguan']=0;			
		}					
    $shu['zong_yu_e'] = MX('huiyuan', 'he')->BiZongE('yongjin',$_W['huiyuan']['id']);
  
    $hy=Qu('he_huiyuan',array('id'=>$_W['huiyuan']['id']));
    if(empty($hy['mima'])){
    	$shu['mima']=1; 
    }
  
    
    json($shu);    
}else if($cao=='zhifu'){	
	
// 	if(empty($_J['mima'])&&	$_J['zhifuqudao']=="yu_e" ){
// 		json('请输入密码',0);
// 	}
// 	if(empty($_J['mima'])&&	$_J['zhifuqudao']=="duihuan" ){
// 		json('请输入密码',0);
// 	}
// 	
// 	$hy=Qu('he_huiyuan',array('id'=>$_W['huiyuan']['id']));
//     if($hy['mima']!=md5($_J['mima']) &&	$_J['zhifuqudao']=="yu_e"){
//     	json('密码有误，请重新输入，忘记密码请到个人中心修改密码',2);
//     }
//    
//     if($hy['mima']!=md5($_J['mima']) &&	$_J['zhifuqudao']=="duihuan"){
//     	json('密码有误，请重新输入，忘记密码请到个人中心修改密码',2);
//     }
// 	
	
	if(intval($_J['dingdanid'])){
		$tiaojian=' and id='.$_J['dingdanid'];
	}else{
		$tiaojian=' and dingdanhao="'.$_J['dingdanid'].'"';
	}
    $dingdan = Cha('select id,dingdanhao,zongjia,shijia,jifendikou,zhuangtai,leixing from ' . BM('zw_shangcheng_dingdan_jichu') . ' where  danyuan='. $_W['danyuan'].' and zhuangtai=0'.$tiaojian);     
   
		if(empty($dingdan)){
    	json('不存在此单或已支付',0);
    }	
		DingDan_ShangPin($dingdan['dingdanhao']);					
   	$_J['zhifuqudao']($dingdan);    
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
	  global $_W;
	  if($_W['zhongduan']=='app'){		
			$zf = MX('zhifu', 'he')->APPZhiFuBao($dingdan); 
      json($zf);
		}else{
			return  MX('zhifu', 'he')->ZhiFuBao($dingdan);	
		}
     
}
function daofu($dingdan){	
	global $_W;	
    $zf=MX('zhifu', 'he')->DaoFu($dingdan);	
    if($zf){
    		json($zf);
    }
    json('不支持货到付款',0);

}
function appzhifubao($dingdan){

	json($zf);
}

function yu_e($dingdan){
	$zf = MX('zhifu', 'he')->YuE($dingdan);	
	
  json($zf);
}

function weixin($dingdan){
   json(MX('zhifu', 'he')->WeiXin($dingdan));  
}

function appweixin($dingdan){	   
  json(MX('zhifu', 'he')->APPWXZhiFu($dingdan));   
}

function jifen($dingdan){	
	$zf = MX('zhifu', 'he')->JiFen($dingdan);	
	json($zf);
}

?>