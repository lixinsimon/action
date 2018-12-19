<?php
	if($_W['huiyuan']['openid']){
		$FenXiang_peizhe=MX('weixin','he')->FenXiang($_J['fxurl']);
   		json($FenXiang_peizhe);
	}else{
		json('没有openid',0);
	}
 
?>