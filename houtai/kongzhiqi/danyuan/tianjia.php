<?php
DengLu();

if($_W['yonghu']['shenfen']>3){
	XiaoXi('权限不够，请联系管理员！');
}

if($_W['danyuan']>0){
	 $dy=Cha('select * from '.BM('he_danyuan').' where id='.$_W['danyuan']);
     $dy['url']=$_W['yuming'].'wxapi.php?d='.$dy['id'];
}

if($cao=='moren'){	
	if($_W['ispost']){
		
		if(empty($_J['mingcheng'])){
			XiaoXi('公众号名称');
		}
		$danyuan=array(
		        'mingcheng'=>trim($_J['mingcheng']),
		        'miaoshu'=>trim($_J['"miaoshu']),
		        'zhanghao'=>trim($_J['zhanghao']),
		        'yuanshiid'=>trim($_J['yuanshiid']),
		        'leixing'=>trim($_J['leixing']),
		        'appid'=>trim($_J['appid']),
		        'appsecret'=>trim($_J['appsecret']),
		        'erweima'=>trim($_J['erweima']),
		        'touxiang'=>trim($_J['touxiang']),
		        'token'=>trim($_J['token']),
		        'encodingaeskey'=>trim($_J['encodingaeskey']),
		        'zuid'=>intval($_J['zuid']),
		        'shijian'=>time(),
		        'zhuangtai'=>1
		);
		
		if($_FILES['yanzhengwenjian']['name']){
			han('wenjian');		
			YanZhengWenJian($_FILES['yanzhengwenjian']);
		}
			
		if($_W['danyuan']>0){	
			unset($danyuan['shijian']);		
			Gai('he_danyuan',$danyuan,array('id'=>$_W['danyuan']));
			XiaoXi('公众号更新成功',UH('danyuan/tianjia',array('c'=>'step3','d'=>$_W['danyuan'])));
		}else{
		ChaRu('he_danyuan',$danyuan);
		$id=ChaRuID();
		$danyuan_guanliyuan=array('danyuanid'=>$id,'guanliyuanid'=>$_W['yonghu']['id']);
		ChaRu('he_danyuan_guanliyuan',$danyuan_guanliyuan);
		
		CaoZuoJiLu('新增公众号');
		XiaoXi('新增公众号成功',UH('danyuan/tianjia',array('c'=>'step3','d'=>$id)));
		}
	}
}elseif($cao=='yanzheng'){
   $yanzheng=ChaZongShu('select count(*) from '.BM('he_danyuan').' where yanzheng=1 and id='.$_W['danyuan']);
   if($yanzheng){
   	  XiaoXi('接入成功',UH('danyuan/xinxi'));
   }else{
   	  XiaoXi('接入失败');
   }
}

mb('tianjia');
?>