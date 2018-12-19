<?php
$cao = empty($_J['c']) ? 'moren' : $_J['c'];	
if($cao=='moren' && $_W['ispost']){
	 $yu_e=MX('huiyuan','he')->BiZongE('yu_e');	
	 $shouxu=$_W['shezhi']['jiaoyi']['shouxu'];
	 $shu['ketixian']=round($yu_e,2);	 	  
	 $yitixian=ChaZongShu('select sum(zhi) from '.BM('he_huiyuan_tixian').' where danyuan='.$_W['danyuan'].' and huiyuan_id='.$_W['huiyuan']['id'].' and zhuangtai=10');
	 $shu['yitixian']=round($yitixian,2); 
	 $shu['shouxu']=$shouxu; 
	 json($shu);
}elseif($cao=='jilu'){
	$where="and danyuan=:danyuan and huiyuan_id=:huiyuan_id order by shijian DESC";
	$cen=array(':danyuan'=>$_W['danyuan'],':huiyuan_id'=>$_W['huiyuan']['id']);
	$DangQianYe = max(1, intval($_J['ye']));
	$XianJiLu = 10;   
	$yu_elie=ChaQuan('select * from '.BM('he_huiyuan_tixian').'where 1 '.$where.' limit '. ($DangQianYe - 1) * $XianJiLu . ',' . $XianJiLu,$cen);
    foreach($yu_elie as $k=>$y){
    	$fuhao=($y['zhi']<0)?"":'+';
    	$yu_elie[$k]['zhi']=$fuhao.$y['zhi'];
    	$yu_elie[$k]['shijian']=date('Y-m-d H:i:s',$y['shijian']);
    }    
    if($yu_elie){
       json($yu_elie,1);
    }else{
    	json('没有了',0);
    }
}elseif($cao=='tixian' && $_W['ispost']){	
	$dk=$_J['dakuaifangshi'];
	if(empty($dk)){
		json('选择打款方式',0);
	}
	if(!is_numeric($_J['jin_e'])){
		json('请输入金额',0);
	}
	$zongE=MX('huiyuan','he')->BiZongE('yu_e');	
	 $shouxu=$_W['shezhi']['jiaoyi']['shouxu'];
	$zongE=$zongE-$_J['jin_e'];
	if($zongE<0){
		json('余额不足',0);
	}
	
	if($dk!='weixin'){	
		if(empty($_J['zhanghao'])){
		   json('账号',0);
		}	
		if(empty($_J['kaifuhang'])){
		   $dk='zhifubao';
		}
		if(empty($_J['ming'])){
		   json('姓名',0);
		}		
	}	
	$yu=Cha('select yu_e from '.BM('he_huiyuan').' where id='.$_W['huiyuan']['id']);
	Gai('he_huiyuan',array('yu_e'=>$yu['yu_e']-$_J['jin_e']),array('id'=>$_W['huiyuan']['id']));
	
	$h['danyuan']=$_W['danyuan'];
	$h['huiyuan_id']=$_W['huiyuan']['id'];
	$h['zhi']=-$_J['jin_e'];
	$h['shuoming']='提现 ('.$_J['jin_e'].'元)';
	$h['shijian']=time();
	$h['rukouUrl']='http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];	
	ChaRu('he_huiyuan_yu_e',$h);
	$id=ChaRuID();
	
	//生成订单号
    $dingdanhao = ShengChengDingDanHao('he_huiyuan_tixian', 'dingdanhao', 'TX');
	$s['danyuan']=$_W['danyuan'];
	$s['huiyuan_id']=$_W['huiyuan']['id'];
	$s['dingdanhao']=$dingdanhao;
	$s['zhi']=$_J['jin_e']*(1-(floatval($shouxu)/100));
	$s['shuoming']='提现消耗余额 '.$_J['jin_e'];
	$s['shijian']=time();	
	$s['dakuanfangshi']=$dk;
	$s['yinhang']=trim($_J['yinhang']);	
	$s['ming']=trim($_J['ming']);
	$s['kaifuhang']=trim($_J['kaifuhang']);
	$s['zhuangtai']=1;
	$s['leixing']='yu_e';	
	$s['laiyuan']=$id;
	ChaRu('he_huiyuan_tixian',$s);
	json('申请成功,等待打款..');	
	
}	
	
mb('tixian');
?>