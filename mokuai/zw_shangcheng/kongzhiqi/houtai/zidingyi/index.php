<?php 
$cao = empty($_J['c']) ? 'moren' : $_J['c'];
QuanXian();
if ($cao == 'moren') { 
    $shu=ChaQuan("select * from ".BM('zw_shangcheng_zidingyi')." where danyuan=".$_W['danyuan']);
//  foreach($shu as &$s){
//  	$s['shuju']=ZiFuChuan_Zhuan_ShuZu($s['shuju']);
//  }
// 
}elseif($cao=='bianji'){
	$shu=Qu('zw_shangcheng_zidingyi',array('id'=>$_J['id'],'danyuan'=>$_W['danyuan']));
	$z=ZiFuChuan_Zhuan_ShuZu($shu['shuju']);	
	if($z){
		foreach($z as $k=>$s){
			$zujian=explode('_',$k);
			$z[$k]['zujian']=$zujian[0];			
		}
	}	
	if($_W['ispost']){
		json($z);
	}
	
}elseif($cao=='post' && $_W['ispost']){
	if(empty($_J['biaoti'])){
		XiaoXi('标题不能为空',UHK('zidingyi/index',array('id'=>$s['id'],'c'=>'bianji')));
	}
	$shunxu = explode(',', $_J['shunxu']);
	array_pop($shunxu);
	$s['danyuan']=$_W['danyuan'];
	$s['biaoti']=trim($_J['biaoti']);
	if($_J['jiazaishangpin']){
		$s['jiazaishangpin']=$_J['jiazaishangpin'];
	}else{
		$s['jiazaishangpin']=0;
	}
	$z=$_J['z'];
	$ppp = array();
	$shuju=array();
	foreach($shunxu as $sx){
		$shuju[$sx]=$z[$sx];
		$ppp[]=$sx;
	}
	

	foreach($ppp as $i){
		$he = array();
		if($z[$i]['geshi']==1){
			if($z[$i]['ming']){
				foreach($z[$i]['ming'] as $k=>$l){
					$p=array();
					$p['ming']=$l;
					$p['tu']=$z[$i]['tu'][$k];
					$p['jiage']=$z[$i]['jiage'][$k];
					$p['yuanjia']=$z[$i]['yuanjia'][$k];
					$p['chengben']=$z[$i]['chengben'][$k];
					$p['jifen']=$z[$i]['jifen'][$k];
					$p['id']=$z[$i]['id'][$k];
					$he[]=$p;
				}
				unset($shuju[$i]['tu']);
				unset($shuju[$i]['ming']);
				unset($shuju[$i]['jiage']);
				unset($shuju[$i]['yuanjia']);
				unset($shuju[$i]['chengben']);
				unset($shuju[$i]['jifen']);
				unset($shuju[$i]['id']);
				$shuju[$i]['shangpin']=$he;
			}
		}elseif($z[$i]['geshi']==2){
			if($z[$i]['tu']){
				foreach($z[$i]['tu'] as $k=>$l){
					$p=array();
					$p['tu']=$l;
					$p['url']=$z[$i]['url'][$k];
					$he[]=$p;
				}
				unset($shuju[$i]['url']);
				unset($shuju[$i]['tu']);
				$shuju[$i]['lunbo']=$he;
			}
		}elseif($z[$i]['geshi']==3){
			if($z[$i]['ming']){
				foreach($z[$i]['ming'] as $k=>$l){
					$p=array();
					$p['ming']=$l;
					$p['url']=$z[$i]['url'][$k];
					$p['tu']=$z[$i]['tu'][$k];
					$he[]=$p;
				}
				unset($shuju[$i]['url']);
				unset($shuju[$i]['tu']);
				unset($shuju[$i]['ming']);
				$shuju[$i]['fenlei']=$he;
			}
		}
	}
	
	$z=$shuju;

	$s['shuju']=ShuZu_Zhuan_ZiFuChuan($z);	
	if($_J['id']){
		$s['id']=$_J['id'];	
		Gai('zw_shangcheng_zidingyi',$s,array('id'=>$_J['id']));	
	}else{
		$s['zhuangtai']=0;
		$s['shijian']=SHIJIAN;  	
		ChaRu('zw_shangcheng_zidingyi',$s,true);	
		$_J['id']=$s['id']=ChaRuID();
	}	

	
	foreach($z as $k=>$ii){
			$zujian=explode('_',$k);	
			$z[$k]['zujian']=$zujian[0];
	}
	
	
	$shu['post_url']=UAK('index');
	$mb=mb('web/index','TEMPLATE_FETCH');	
  Html('index_'.$_J['id'],$mb);
	//  json($s['id']);  
    CaoZuoJiLu('店铺装修');
	XiaoXi('修改成功',UHK('zidingyi/index',array('id'=>$s['id'],'c'=>'bianji')));
}elseif($cao=='shemo'&& $_W['ispost']){
	Gai('zw_shangcheng_zidingyi',array('zhuangtai'=>0),array('zhuangtai'=>1,'leixing'=>$_J['leixing']));
	Gai('zw_shangcheng_zidingyi',array('zhuangtai'=>1),array('id'=>$_J['id']));
	CaoZuoJiLu('店铺装修默认ID:'.$_J['id']);
	json(1);
	
}elseif ($cao=='shanchu') {
	 ShanChu('zw_shangcheng_zidingyi',array('id'=>$_J['id'],'danyuan'=>$_W['danyuan']));
	 CaoZuoJiLu('删除店铺装修');
	  XiaoXi('删除成功',UHK('zidingyi'));eixt;
}elseif($cao=='zujian'){
	if(empty($_J['zj'])){
		json('组件名不能为空',0);
	}	
	$shu['ming']=$_J['zj']."_".random(10);		
	$shu['zujian']='<li class="zujian" id="'.$shu['ming'].'" draggable="true" onclick="click_zujian(this)">'.mb('zujian/'.$_J['zj'],'TEMPLATE_FETCH').'</li>';		
	$shu['bianji']='<div class="bianji" id="'.$shu['ming'].'" >'.mb('zujian/'.$_J['zj'].'_bianji','TEMPLATE_FETCH').'</div>';
	json($shu);
}elseif($cao=='shengcheng'){
//	$shu=Qu('zw_shangcheng_zidingyi',array('id'=>$_J['id'],'danyuan'=>$_W['danyuan']));	
//	$z=ZiFuChuan_Zhuan_ShuZu($shu['shuju']);	
//	if($z){
//		foreach($z as $k=>$s){
//			$zujian=explode('_',$k);				
//			$z[$k]['zujian']=$zujian[0];			
//		}
//	}
//	$shu['post_url']=UAK('index');
//	$mb=mb('web/index','TEMPLATE_FETCH');	
//	$ff=Html('index',$mb);
//	dump($ff);
//	die;	
}elseif($cao=='sousuoshangpin'){
	
	$sql=' where danyuan='.$_W['danyuan'].' and zhuangtai=1';
	
	if($_J['guanjianzi']){
		$sql.=' and (ming like "%'.$_J['guanjianzi'].'%" or id='.intval($_J['guanjianzi']).')';
	}else{
		$sql.=' and tuijian=1 order by shijian DESC limit 6';
	}
	$shangpin = ChaQuan('select * from '.BM('zw_shangcheng_shangpin').$sql);
	foreach($shangpin as $k=>$l){
		$shangpin[$k]['tu']=JueDuiUrl($l['tu']);
//		if($l['cuxiao']==1){
//			$shangpin[$k]['jiage']=$l['chengben'];
//		}
	}
	json($shangpin);
}
mb('index');
?>