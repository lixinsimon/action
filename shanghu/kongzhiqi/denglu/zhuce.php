<?php
if($cao=='moren' && $_W['ispost']){
	$dizhi = ChaQuan('select * from'.BM('he_dizhiku').' order by id ASC');
	if(empty($dizhi)){
		json('没有地址选择器',0);
	}
	$dizhiku = array();
	for($a=0,$l=count($dizhi);$a<$l;$a++){
		if(empty($dizhi[$a]['fuji'])){
			$sheng[] = $dizhiku;
			$dizhiku=[];
			$dizhiku['sheng']['ming']=$dizhi[$a]['ming'];
//			$dizhiku['sheng']['shi'][]=''; 	
			$dizhiku['sheng']['id']=$dizhi[$a]['id'];
			continue;
		}
		if($dizhiku['sheng']['id']==$dizhi[$a]['fuji']){
			$dizhiku['sheng']['shi'][$dizhi[$a]['id']]['ming']=$dizhi[$a]['ming']; 
			$shiID=$dizhi[$a]['id'];
		}
//		if($dizhi[$a]['fuji']==$shiID){
//			$dizhiku['sheng']['shi'][$shiID]['xian'][]=$dizhi[$a]['ming'];
//		}
	} 
	array_shift($sheng);
	json($sheng);
}elseif($_W['ispost'] && $cao=='zhuce'){
	
	dump($_J);DIE;
	
	$zhanghao=trim($_J['zhanghao']);
	if(empty($_J['zhanghao'])){
		XiaoXi('用户名不能为空');		
	}
	if(empty($_J['mima'])){ 
		XiaoXi('密码不能为空');
	}
	if(empty($_J['shi'])){
		XiaoXi('市区不能为空');
	}
	$shanghu = Qu('he_shanghu',array('zhanghao'=>$zhanghao,'danyuan'=>$_W['danyuan']));
	if($shanghu){
		XiaoXi('用户名已存在');
	}
	if(empty($_W['danyuan'])){
		XiaoXi('注册失败');
	}
	$mima = md5($_J['mima']);
	$daibiao = ChaQuan('select shiqudaili from'.BM('he_shanghu').' where zhuangtai=1');
	foreach($daibiao as $k=>$l){
		if($_J['xuanze']==$l['shiqudaili']){
			XiaoXi('该市区已有代表');
		}
	}
	
	$shu=array(
	    'zhanghao'=>$zhanghao,
	    'mima'=>$mima,
	    'dengji'=>0,
	    'zhuangtai'=>0,
	    'danyuan'=>$_W['danyuan'],
	    'zhuceshijian'=>SHIJIAN,
	    'shiqu'=>intval($_J['shi'])
	    );
	
	ChaRu('he_shanghu',$shu);
	XiaoXi('注册成功！等待市区管理者审核',UD('denglu/index'));
}
mb('zhuce');
?>