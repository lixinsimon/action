<?php
require '../neihe/he.php';
$input = file_get_contents('php://input');
if (!empty($input) && empty($_GET['out_trade_no'])) {
	if (preg_match('/(\<\!DOCTYPE|\<\!ENTITY)/i', $input)) {
		exit('fail');
	}
	libxml_disable_entity_loader(true);
	$obj = simplexml_load_string($input, 'SimpleXMLElement', LIBXML_NOCDATA);
	$data = json_decode(json_encode($obj), true);
	if (empty($data)) {
		exit('fail');
	}
	if ($data['result_code'] != 'SUCCESS' || $data['return_code'] != 'SUCCESS') {
		exit('fail');
	}
	$shu = $data;
} else {
	$shu = $_GET;
}
$attach=explode(":",$shu['attach']);
$_W['danyuan']=$attach[0];
$_W['mo']=$attach[1];
$leixing=$attach[2];
$peizhi=MX('zhifu','he')->PeiZhi();
$pz=$peizhi['xiaochengxu'];
$_W['shezhi']=MX()->quSheZhi();	
if(is_array($pz)) {
	ksort($shu);
	$string1 = '';
	foreach($shu as $k => $v) {
		if($v != '' && $k != 'sign') {
			$string1 .= "{$k}={$v}&";
		}
	}
	$sign = strtoupper(md5($string1 . "key={$pz['apikey']}"));
	if($sign==$shu['sign']){		
		$out_trade_no = $shu['out_trade_no'];	
		$transaction_id = $shu['transaction_id'];	
		$total_amount = $shu['total_fee']/100;	
		$data=array('dingdanhao'=>$out_trade_no,'jiaoyihao'=>$transaction_id,'zongjia'=>$total_amount);
		if($leixing=='dingdan'){     	     	
	       MX()->ZhiFuYiBuFanHui($data,'weixin');
	    }elseif($leixing){		 
		 	MX('zhifu','he')->ChiLiZhiFu($data,'weixin',$leixing);
		 }
	    exit('success');	
	}
	
	
}
exit('fail');

