<?php
/**
 * [商城开源系统] Copyright (c) 2014 ZhiWi.COM
 *  商城群QQ：628361862  进群下载更新包 交流技术   http://www.ZhiWi.com/.
 */
DengLu();
$cao = empty($_J['c']) ? 'moren' : $_J['c'];
if ($cao == 'moren' && $_W['ispost']) {
	
    $ids = intval($_J['ids']);
    if(empty($ids)) {
        $ids = ltrim($_J['ids'], '_');
        $ids = str_replace('_', ',', $ids);
        $shu = MX()->quGouWuCheLie($ids);
        $gouwuchelie =  $shu['gouwuchelie'];   
    }else{
    	$shu = MX()->ZhiGou($ids, $_J['guigeid'], $_J['shuliang']);
//  	dump($shu);die;  
		
        $gouwuchelie =  $shu['gouwuchelie']; 

    }
    if(empty($gouwuchelie)){    	
        json('无订单',-2);
    }    

	
    if ($_W['danyuan'] > 0 && $_W['huiyuan']['id'] > 0) {    	
        $shu['dizhi'] = Cha('select * from ' . BM('zw_shangcheng_dizhi') . ' where danyuan=' . $_W['danyuan'] . ' and huiyuan=' . $_W['huiyuan']['id']. ' order by moren DESC');
    }       

	 
    
//   $shu['zongjia']-=$shu['jifendikou'];
	 $tj='huiyuan='.$_W['huiyuan']['id'].' and danyuan='.$_W['danyuan'].' and zhuangtai=0 and kaishi_shijian<='.SHIJIAN.' and jieshu_shijian>='.SHIJIAN.' and (tiaojian<='.$shu['zongjia'].' or tiaojian=0)';
	
	 $sql='select count(*) from '.BM('zw_shangcheng_quan_wode').' where '. $tj; 
	 $shu['keyongquan']=ChaZongShu($sql); 
		
	$sq='select * from '.BM('zw_shangcheng_quan_wode').' where '. $tj; 
	$shu['quan']=ChaQuan($sq); 
	
	foreach($shu['quan'] as $k=>$y){
	    	$shu['quan'][$k]['jieshu_shijian']=date('Y-m-d ',$y['jieshu_shijian']);
	    	$shu['quan'][$k]['kaishi_shijian']=date('Y-m-d ',$y['kaishi_shijian']);
	}  
	
	 
	 $shu['ids']=$_J['ids'];
	 $shu['shuliang']=$_J['shuliang'];
	 $shu['guigeid']=$_J['guigeid'];	 
     json($shu);
} elseif ($cao == 'xuanzedizhi' && $_W['ispost']) {
    $dizhilie = ChaQuan('select * from ' . BM('zw_shangcheng_dizhi') . ' where danyuan=' . $_W['danyuan'] . ' and huiyuan=' . $_W['huiyuan']['id']);
    if ($dizhilie) {      
        json($dizhilie);
    }
    json('没地址', 0);
} elseif ($cao == 'shengchengdingdan' && $_W['ispost']) {					
    $ids = intval($_J['ids']);    
    if ($ids>0) {  
    	 $gwl = MX()->ZhiGou($ids, $_J['guigeid'], $_J['shuliang']); 
    } else{       
        $ids = ltrim($_J['ids'], '_');
        $ids = str_replace('_', ',', $ids);  	
        $gwl = MX()->quGouWuCheLie($ids);      
    }  	

    if(empty($gwl['gouwuchelie'])){json('下单错误', 0);} 
    
    if ($_J['dizhi_id'] && empty($_J['peisongfangshi'])) {
    	$dizhi = Cha('select * from ' . BM('zw_shangcheng_dizhi') . ' where id=' . $_J['dizhi_id']);
    	$dizhi['peisongfangshi']=0;     	
    }elseif($_J['peisongfangshi']){
    	$dizhi['id']=$_J['ziti_id'];    	
    	if(empty($_J['ziti_xingming'])){
    		json('姓名不能为空', 0); 
    	}
    	if(!preg_match("/1[34578]{1}\d{9}$/", $_J['ziti_dianhua'])){
    		json('请输入正确手机号', 0); 
    	}
    	$dizhi['ming']=$_J['ziti_xingming'];
    	$dizhi['dianhua']=$_J['ziti_dianhua'];
    	$dizhi['shengshiqu']=$_J['ziti_shengshixian'];
    	$dizhi['dizhi']=$_J['ziti_dizhi'];
    	$dizhi['peisongfangshi']=1;
    }else{
    	json('收货地址不为空', 0); 
    }      
//  $zong_jifen = MX('huiyuan', 'he')->qu_jifen($_W['huiyuan']['id']);  
//  if($gwl['jifendikou']>=$zong_jifen || empty($zong_jifen)){    	
//  	$gwl['jifendikou']=0;    	
//  }
    $quan_e=0;
    if($_J['quan']>0){
    	 $quantj='id='.$_J['quan'].' and huiyuan='.$_W['huiyuan']['id'].' and danyuan='.$_W['danyuan'].' and zhuangtai=0 and kaishi_shijian<='.SHIJIAN.' and jieshu_shijian>='.SHIJIAN.' and (tiaojian<='.$gwl['zongjia'].' or tiaojian=0)';
	     $quan = Cha('select * from ' . BM('zw_shangcheng_quan_wode') . ' where ' .$quantj);    
    	 if($quan){
    	 	$quan_e=$quan['e'];
      	    Gai('zw_shangcheng_quan_wode',array('zhuangtai'=>1),array('id'=>$_J['quan']));
    	 }    	 
    }   
  
    //生成订单号
    $dingdanhao = ShengChengDingDanHao('zw_shangcheng_dingdan', 'dingdanhao', 'DG');     
    $dingdan_jichu = array(
        'danyuan' => $_W['danyuan'],
        'huiyuan' => $_W['huiyuan']['id'],
        'dingdanhao' => $dingdanhao,
        'shijia' => $gwl['zongjia'] - $gwl['yunfei'],
//      'zongjia' => $gwl['zongjia']-$gwl['jifendikou']-$quan_e+$gwl['yunfei'],
        'jifendikou'=>$gwl['jifendikou'],
        'quan_e'=>$quan_e,
        'quan_id'=>$quan['id'],
        'yunfei' => $gwl['yunfei'],
        'dizhiid' => $dizhi['id'],
        'shouhuoren' => $dizhi['ming'],
        'shouhuodianhua' => $dizhi['dianhua'],
        'shouhuoshengshiqu' => $dizhi['shengshiqu'],
        'shouhuodizhi' => $dizhi['dizhi'],
        'xiadanshijian' =>SHIJIAN,
        'liuyan' => $_J['liuyan'],
        'peisong'=>$dizhi['peisongfangshi'],
        'zhuangtai' => 0,
    ); 

	if($_J['jifendikou']=='true'){
		$dingdan_jichu['jifendikou_e']=$gwl['jifendikou']/intval($_W['shezhi']['jiaoyi']['jifenzhuanhua']);
		$dingdan_jichu['zongjia']=$gwl['zongjia']-$dingdan_jichu['jifendikou_e']-$quan_e+$gwl['yunfei'];
	}else{
		$dingdan_jichu['zongjia']=$gwl['zongjia']-$quan_e+$gwl['yunfei'];
		$dingdan_jichu['jifendikou_e']=0;
	}
    ChaRu('zw_shangcheng_dingdan_jichu', $dingdan_jichu);  
    $dingdanid = ChaRuID();        
    foreach($gwl['gouwuchelie'] as $g){
		if($_J['jifendikou']=='true'){
			$g['jifen']=1;
		}else{
			$g['jifen']=0;
		}
    	 $bili=round($g['zongjia']/$gwl['zongjia'],2);
    	 $g['quan_e']=$quan_e*$bili;
    	 $cj=MX()->ChuangJianDingDan($g,$dingdanhao,$dizhi);
    	 $TiXing['shangpin_ming'].=$cj['shangpin_ming'];
    }    
    $TiXing=array();
    $TiXing['dianpu']=$_W['shezhi']['shezhi']['ming'];
    $TiXing['shijian']=date('Y-m-d H:i:s',SHIJIAN);
    $TiXing['jin_e']=$dingdan_jichu['zongjia'];
    $TiXing['url']=UXK('dingdan/zhifu',array('dingdanid'=>$dingdanid));	   
    //下单提醒      
    if($_W['huiyuan']['openid']){    	
    	MX('api')->XiaDanTiXing($_W['huiyuan']['openid'],$TiXing);  
    }    
    $shu = array('dingdanid' => $dingdanid);    
    if(!empty($ids)){
    	$ids=explode(',',$ids);
        ShanChu('zw_shangcheng_gouwuche', array('id' => $ids));  	
    }   
    json($shu, 1);
} elseif ($cao == 'dizhitianjia' && $_W['ispost']) {
    $shu = MB('biaoqian/dizhitianjia', 'TEMPLATE_FETCH');
    json($shu);
} elseif($cao == 'quan' && $_W['ispost']){
     $DangQianYe = max(1, $_J['ye']);
     $quTiaoShu = 10;
     $time=SHIJIAN;
     $tj='huiyuan='.$_W['huiyuan']['id'].' and danyuan='.$_W['danyuan'].' and zhuangtai=0 and kaishi_shijian<='.$time.' and jieshu_shijian>='.$time.' and (tiaojian>='.$_J['zongjia'].' or tiaojian=0)';
     $sql='select * from '.BM('zw_shangcheng_quan_wode').' where '. $tj.' order by lingqu_shijian DESC Limit '.($DangQianYe - 1) * $quTiaoShu.','.$quTiaoShu; 
    $quan=ChaQuan($sql);
    if($quan){
      $shu = MB('biaoqian/quan', 'TEMPLATE_FETCH');
      json($shu);
    }
    json('没有了',0);
}elseif($cao=='dianpu'){
	$DangQianYe = max(1, $_J['ye']);
    $quTiaoShu = 10;
    $hexiao=ChaQuan('select id,logo,sheng,shi,xian,xiangxidizhi,nicheng from '.BM('he_hexiao').' where danyuan='.$_W['danyuan'].' order by shijian DESC Limit '.($DangQianYe - 1) * $quTiaoShu.','.$quTiaoShu);
    if(empty($hexiao)){
    	json('没有了',0);
    }
    foreach($hexiao as $k=>$l){    	
    	$hexiao[$k]['logo']=JueDuiUrl($l['logo']);
    	$hexiao[$k]['shengquxian']=$l['sheng'].$l['shi'].$l['xian'];
    	$hexiao[$k]['dizhi']=$hexiao[$k]['shengquxian'].$l['xiangxidizhi'];    
    }
    json($hexiao);	
}elseif($cao=='jifen'){
	$zong_jifen = MX('huiyuan', 'he')->qu_jifen($_W['huiyuan']['id']);  
    json($zong_jifen);
}
mb('querendingdan');







