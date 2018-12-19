<?php
DengLu();

QuanXian();

$he_huiyuan=MX('huiyuan','he');
$xianzhi=' limit 5';
if($cao=='moren'){
	
	$tiaojian="danyuan=".$_W['danyuan'];
	if($_J['id']>0){
		$tiaojian.=' and id='.$_J['id'];
	}	
	if($_J['yonghu']){
		$yonghu=trim($_J['yonghu']);
		$tiaojian.=' and (nicheng like "%'.$yonghu.'%" or xingming like "%'.$yonghu.'%" or shouji like "%'.$yonghu.'%")';
	}	
	$DangQianYe = max(1, intval($_J['page']));
    $XianJiLu = 20;
	$huiyuan=ChaQuan('select * from '.BM('he_huiyuan').'where '.$tiaojian.' order by id DESC limit '. ($DangQianYe - 1) * $XianJiLu . ',' . $XianJiLu);
	foreach($huiyuan as $k=>$h){
		$huiyuan[$k]['fu']=Qu('he_huiyuan',array('id'=>$h['fuji_id'],'danyuan'=>$_W['danyuan']),'touxiang,nicheng');
		$huiyuan[$k]['xunzhang']=$he_huiyuan->BiZongE('xunzhang',$h['id']);  
		$huiyuan[$k]['liquan']=$he_huiyuan->BiZongE('liquan',$h['id']);  
		$huiyuan[$k]['jifen']=$he_huiyuan->BiZongE('jifen',$h['id']);  
		$huiyuan[$k]['yongjin']=$he_huiyuan->BiZongE('yongjin',$h['id']);  
	}
	$shu=ChaZongShu('select count(*) from '.BM('he_huiyuan').' where  '.$tiaojian); 
	$fenye=FenYe($shu,$DangQianYe,$XianJiLu); 	
}elseif ($cao=="bianji") {
	if($_W['ispost']){
		if($_J['zhanghao']){
			$check=Cha('select * from '.BM('he_huiyuan')." where zhanghao='".trim($_J['zhanghao'])."' and id<>".intval($_J['id'])." and danyuan=".$_W['danyuan']);
			if($check['id']){
				XiaoXi('账号已存在了！');
			}
		}
		$gai_huiyuan=array(
		            'touxiang' =>trim($_J['touxiang']),		         
		            'zhanghao' =>trim($_J['zhanghao']),
		            'nicheng'  =>trim($_J['nicheng']),
		            'xingming' =>trim($_J['xingming']),
		            'xingbie'  =>trim($_J['xingbie']),
		            'shengfen' =>($_J['sheng']=='' || empty($_J['sheng']))?'':trim($_J['sheng']),
		            'chengshi' =>($_J['shi']=='' || empty($_J['shi']))?'':trim($_J['shi']),
		            'quxian'   =>($_J['xian']=='' || empty($_J['xian']))?'':trim($_J['xian']),
		            'dizhi'    =>trim($_J['dizhi']),
		            'shouji'   =>trim($_J['shouji']),
		            'qq'       =>intval($_J['qq']),
		            'email'    =>trim($_J['email']),
		            'fuji_id' => intval($_J['shangjiId']),
		            'guanzhu'=>intval($_J['guanzhu'])          
		);
		    
		if(!empty($_J['mima'])){
			$gai_huiyuan['mima']=md5($_J['mima']);
		}
		$he_huiyuan->gai_huiyuan($gai_huiyuan,$_J['id']);
		
		CaoZuoJiLu('修改会员信息'); 
		XiaoXi('更新成功',UH('fensi/huiyuan'));
    }	
	$huiyuan=$he_huiyuan->qu_huiyuan(intval($_J['id']));	
	$nicheng=Qu('he_huiyuan',array('id'=>$huiyuan['fuji_id']),'nicheng');	
	$huiyuan['fuji_nicheng']=$nicheng['nicheng'];
	
}elseif($cao=="chongzhi"){	
	if($_W['ispost']){
		$shouming=empty($_J['shouming'])?'平台充值':$_J['shouming'];	
		$shouming=$_W['yonghu']['yonghuming'].$shouming;	
		$he_huiyuan->gai_jifen($_J['id'],$_J['jifen'],$shouming);		
		$he_huiyuan->BiZong_JiaJian('yongjin',$_J['id'],$_J['yu_e'],$shouming);
		$he_huiyuan->BiZong_JiaJian('liquan',$_J['id'],$_J['liquan'],$shouming);
		$he_huiyuan->BiZong_JiaJian('xunzhang',$_J['id'],$_J['xunzhang'],$shouming);	
		CaoZuoJiLu('操作充值 '); 	
		XiaoXi('更新成功','shuaxin');
	}
}elseif($cao=="shanchu"){
	//http://www.banmapc.com/houtai/index.php?d=12&k=fensi&x=huiyuan&c=shanchu&id=100000779
    if($_J['id']>0){    
    	ShanChu('he_huiyuan',array('id'=>$_J['id'],'danyuan'=>$_W['danyuan']));		
		ShanChu('he_huiyuan_jifen',array('huiyuan_id'=>$_J['id']));
		ShanChu('he_huiyuan_liquan',array('huiyuan_id'=>$_J['id']));
		ShanChu('he_huiyuan_tixian',array('huiyuan_id'=>$_J['id']));
		ShanChu('he_huiyuan_xiaoxi',array('hyid'=>$_J['id']));
		ShanChu('he_huiyuan_xunzhang',array('huiyuan_id'=>$_J['id']));
		ShanChu('he_huiyuan_yongjin',array('huiyuan_id'=>$_J['id']));
		ShanChu('he_huiyuan_yu_e',array('huiyuan_id'=>$_J['id']));
		
		ShanChu('zw_shangcheng_huiyuan',array('hyid'=>$_J['id']));
		ShanChu('zw_shangcheng_dingdan',array('huiyuan'=>$_J['id']));
		ShanChu('zw_shangcheng_dingdan_jichu',array('huiyuan'=>$_J['id']));
		ShanChu('zw_shangcheng_dingdan_shangpin',array('huiyuan'=>$_J['id']));
		ShanChu('zw_shangcheng_dizhi',array('huiyuan'=>$_J['id']));
		ShanChu('zw_shangcheng_gouwuche',array('huiyuan'=>$_J['id']));
		
		ShanChu('zw_shangcheng_liuyan',array('hyid'=>$_J['id']));
		ShanChu('zw_shangcheng_pingjia',array('hyid'=>$_J['id']));
		ShanChu('zw_shangcheng_qiandao',array('hyid'=>$_J['id']));
		ShanChu('zw_shangcheng_quan_wode',array('huiyuan'=>$_J['id']));
		ShanChu('zw_shangcheng_shoucang',array('huiyuan'=>$_J['id']));
		ShanChu('zw_shangcheng_tixian',array('huiyuan'=>$_J['id']));
		CaoZuoJiLu('删除会员 '); 
		XiaoXi('删除成功');
    }
    XiaoXi('删除失败');
	
	
	
	
}elseif($cao=='xuanshangji'){	
	$shangjilie1 = ChaQuan('select * from'.BM('he_huiyuan') .$xianzhi);
	json($shangjilie1);
	
}elseif($cao=='sousuo'){
	if($_J['txt']){		
		$tiaojian.=' where (nicheng like "%'.$_J['txt'].'%" or xingming like "%'.$_J['txt'].'%" or zhanghao like "%'.$_J['txt'].'%")';
		$shangjilie1 = ChaQuan('select * from'.BM('he_huiyuan') .$tiaojian);
		json($shangjilie1);	
    }
}


mb("huiyuan");
?>