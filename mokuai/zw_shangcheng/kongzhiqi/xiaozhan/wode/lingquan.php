<?php
DengLu();
$cao=empty($_J['c'])?'moren':$_J['c'];	
if ($cao == 'moren' && $_W['ispost']){
	$DangQianYe = max(1, $_J['ye']);
    $quTiaoShu = 10;
   
	
//  $sql="select * from ".BM('zw_shangcheng_quan')." where ".$tj.' and id not in (select quan_id from '.BM('zw_shangcheng_quan_wode').' ) order by shijian';
//	$s['quan']=ChaQuan($sql);  
	

 	$tj='jieshu>='.time().' and (zongshu>0 or zongshu=-1)  and danyuan='.$_W['danyuan'];
	$sql="select * from ".BM('zw_shangcheng_quan')." where ".$tj.' order by shijian';
	
	$s['quan']=ChaQuan($sql);
//	dump($s);
	

	foreach($s['quan'] as $i=>$q){
		$tj='danyuan='.$_W['danyuan'].' and quan_id='.$q['id'].' and huiyuan='.$_W['huiyuan']['id'];
		$sql_shu='select count(*) from '.BM('zw_shangcheng_quan_wode').' where '.$tj;
		$zong=ChaZongShu($sql_shu);	
		if($zong == $q['xianling']){  
            unset($s['quan'][$i]);  
        }elseif($zong >= $q['xianling']){
        	json('数据有误',0);
        }  
	}
	
    $s['zong']= count($s['quan']);  
    
    if($s['quan']){
    	foreach($s['quan'] as $k=>$y){
	    	$s['quan'][$k]['kaishi']=date('Y-m-d ',$y['kaishi']);
	    	$s['quan'][$k]['jieshu']=date('Y-m-d ',$y['jieshu']);
	    }   	
      json($s);
    }
    json('没有了',0);
}elseif($cao == 'lingqu' && $_W['ispost']){	
	$tj="id=".$_J['id'].' and (zongshu>0 or zongshu=-1) and jieshu>='.time();
    $quan=Qu('zw_shangcheng_quan',$tj);  
    $xian='danyuan='.$_W['danyuan'].' and quan_id='.$_J['id'].' and huiyuan='.$_W['huiyuan']['id'];
    $sql_shu='select count(*) from '.BM('zw_shangcheng_quan_wode').' where '.$xian;
	$zong=ChaZongShu($sql_shu);	
	if($zong == $quan['xianling']){
		json('已经不能再领了',-1);
	}
    if($quan){
    	$s=array();
    	$s['danyuan']=$_W['danyuan'];
    	$s['huiyuan']=$_W['huiyuan']['id'];
    	$s['quan_id']=$quan['id'];
    	$s['lingqu_shijian']=time();
    	$s['kaishi_shijian']=$quan['kaishi'];
    	$s['jieshu_shijian']=$quan['jieshu'];
    	$s['e']=$quan['e'];
    	$s['tiaojian']=$quan['tiaojian'];
    	$s['biaoti']=$quan['biaoti'];
    	$s['zhuangtai']=0;
    	$s['shuliang']=1;
    	ChaRu('zw_shangcheng_quan_wode',$s);
		if($quan['zongshu']!=-1){
	    	Gai('zw_shangcheng_quan',array('zongshu'=>$quan['zongshu']-1),array('id'=>$quan['id']));
		}
    	json('领取成功');
    }
    json('领取失败',0);
}

mb('lingquan');
?>