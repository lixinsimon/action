<?php
	
	

$_GPC['url']='https://item.taobao.com/item.htm?id=557648964600';
set_time_limit(0);
$ret = array();
$url = $_GPC['url'];
$pcate = intval(2);
$ccate = intval(3);
if (is_numeric($url)) {
	$itemid = $url;
} else {
	preg_match('/id\\=(\\d+)/i', $url, $matches);
	if (isset($matches[1])) {
		$itemid = $matches[1];
	}
}
if (empty($itemid)) {
	die(json_encode(array("result" => 0, "error" => "未获取到 itemid!")));
}
$ret =MX('taobaodaoru','he')->get_item_taobao($itemid, $_GPC['url'], $pcate, $ccate);
die(json_encode($ret));



//dump($tb);die;
//
////mb('index');
//
//
//
//function taobao($text){
//	
//	//获取图片
//		
//		
//	//标题
//	preg_match('/<title>([^<>]*)<\/title>/', $text,$shu['biaoti']);			
//		
//	//价格
//	preg_match('/<([a-z]+)[^i]*id=\"J_StrPrice\"[^>]*>([^<]*)<\/\\1>/is', $text,$shu['jiage']);	
//	$shu['jiage']=floatval($shu['jiage']);
//	
//	//属性
//  preg_match('/<(div)[^c]*class=\"attributes\"[^>]*>.*<\/\\1>/is', $text, $text0);	
//	$text1=preg_replace("/<\/div>[^<]*<(div)[^c]*id=\"description\"[^>]*>.*<\/\\1>/is","",$text0);	  
//	$shu['shuxing']=preg_replace("/<\/div>[^<]*<(div)[^c]*class=\"box J_TBox\"[^>]*>.*<\/\\1>/is","",$text1);
//	
//	//详情
//	preg_match_all('/<script[^>]*>[^<]*<\/script>/is', $text, $content);//页面js脚本
//	  $content=$content[0];
//	  $description='<div id="detail"> </div>
//	   <div id="description">
//	    <div id="J_DivItemDesc">描述加载中</div>
//	   </div>';
//	 foreach ($content as &$v){
//	 	  $description.=$v;
//	 };
//	 $shu['neirong']=$description;
//	 
//	 dump($shu);die;
//	 
//}
?>