<?php
//	
//	$url="https://api.weixin.qq.com/cgi-bin/user/get?access_token=".MX('weixin','he')->AccessToken();
//	$a= get($url);
//	foreach($a['data']['openid'] as $k=>$id){
//		$int=intval($k/100);
//		$hy[$int][$k-$int*100]['openid']=$id;		
//		$hy[$int][$k-$int*100]['lang']="zh_CN";	
//	}
//		$ip=GetIp();
//	$i=0;
//	foreach($hy as $z){
//		$h['user_list']=$z;
//		$a=jsonFormat($h);
//			
//			
//		$url1="https://api.weixin.qq.com/cgi-bin/user/info/batchget?access_token=".MX('weixin','he')->AccessToken();
//		$b=ihttp_request($url1,$a);
//		$b=json_decode($b['content']);
//		$b=ZhuanShuZu($b);
//	
//	
//	
//		foreach($b['user_info_list'] as $huiyuan){
//				$arr=array(
//			     'danyuan'=>$_W['danyuan'],
//			     'openid'=>$huiyuan['openid'],
//			     'nicheng'=>$huiyuan['nickname'],		     
//			     'xingbie'=>empty($huiyuan['sex'])?'女':'男',
//			     'chengshi'=>$huiyuan['city']?$huiyuan['city'].'市':'',
//			     'shengfen'=>$huiyuan['province'],
//			     'ip'=>$ip,		    
//			     'zhuangtai'=>1,		     
//			     'touxiang'=>$huiyuan['headimgurl'],
//			     'guanzhu'=>1
//			    );
//			$zz=Qu('he_huiyuan',array('openid'=>$huiyuan['openid']));  	
//			
//			if(empty($zz)){
//				$arr['fuji_id']=10000001;
//				ChaRu('he_huiyuan', $arr);
//				$cid=ChaRuID();
//				$hybian=array('danyuan'=>$_W['danyuan'],'hyid'=>$cid,'huiyuanshijian'=>SHIJIAN);	
//				ChaRu('zw_shangcheng_huiyuan',$hybian);
//			}else{
//				Gai('he_huiyuan',$arr,array('openid'=>$huiyuan['openid']));
//			}
//			 $i++;
//		}
//	}
//	echo $i;
?>