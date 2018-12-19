<?php
/**
 * [商城开源系统] Copyright (c) 2014 ZhiWi.COM
 *  商城群QQ：628361862  进群下载更新包 交流技术   http://www.ZhiWi.com/.
 */
DengLu();
if($cao=='moren'  && $_W['ispost']){
	if(empty($_J['ming'])){
		json('请输入店铺名',0);
	}
	if(empty($_J['dianhua'])){
		json('请输入电话',0);
	}
	if(empty($_J['gongsiming'])){
		json('请输入公司名',0);
	}
	if(empty($_J['dizhi'])){
		json('请输入详细地址',0);
	}
	if(empty($_J['zhizhao'])){
		json('请上传营业执照',0);
	}
	if(empty($_J['shengshiqu'])){
		json('请选择省市区',0);
	}
   $jifen=intval(MX('huiyuan','he')->BiZongE('jifen',$_W['huiyuan']['id']));
   if($jifen<200){
   	 json('和券不足200',0);
   }

	$shu=array();
	$shu['hyid']=$_W['huiyuan']['id'];
	$shu['danyuan']=$_W['danyuan'];
	$shu['logo'] = $_J['logo'];
	$shu['ming'] = $_J['ming'];
	$shu['gongsiming'] = $_J['gongsiming'];
	$shu['dianhua'] = $_J['dianhua'];
	$shu['dizhi'] = $_J['dizhi'];	
	$shu['shijian'] = SHIJIAN;
	
	
	$shu['shengshiqu'] =$_J['shengshiqu'];
	$qita['yingyezhao'] = $_J['zhizhao'];
	$shu['qita']=ShuZu_Zhuan_ZifuChuan($qita);

	$shu['zhuangtai']=0;
	$k=ChaRu("he_shanghu",$shu);
	MX('huiyuan','he')->BiZong_JiaJian('jifen',$s['hyid'],-200,'店铺入驻费','DP'.ChaRuID());
	if($k){
		json("成功");
	}else{
		json("失败",0);
	}

}else if($cao == 'panduan'){
	$k=Cha('select * from '.BM('he_shanghu').' where hyid= '.$_W['huiyuan']['id']);
	if($k){		
		json($k);
	}else{
		json("未申请",0);
	}

}else if($cao == 'goumaizige'){
// 		if(!$_J['dengji']){
// 			json("请选择等级",0);
// 		}
		if(!$_J['dianpuming']){
			json("请添加店铺名",0);
		}
// 		if(!$_J['miaoshu']){
// 			json("请添加描述",0);
// 		}
	
		$shu=array();
	
		// $shu['dengji'] = $_J['dengji'];
		// $shu['miaosu'] = $_J['miaoshu'];
		$shu['ming'] = $_J['dianpuming'];
		// $shu['danyuan'] = $_W['danyuan'];
		// $shu['hyid'] = $_W['huiyuan']['id'];
		// $shu['shijian'] = SHIJIAN;
		$k=Gai("he_shanghu",$shu,array('hyid' => $_W['huiyuan']['id']));
		if($k){
			json("成功",1);
		}else{
			json("失败",0);
		}
}
mb('shenqingruzhu');
?>