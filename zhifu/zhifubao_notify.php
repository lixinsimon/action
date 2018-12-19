<?php
/* *
 * 功能：支付宝服务器异步通知页面
 * 版本：2.0
 * 修改日期：2016-11-01
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。

 *************************页面功能说明*************************
 * 创建该页面文件时，请留心该页面文件中无任何HTML代码及空格。
 * 该页面不能在本机电脑测试，请到服务器上做测试。请确保外部可以访问该页面。
 * 如果没有收到该页面返回的 success 信息，支付宝会在24小时内按一定的时间策略重发通知
 */

require '../neihe/he.php';
require_once GENMULU.'/neihe/ku/zhifubao/wappay/service/AlipayTradeService.php';

//$uu=Cha('select * from '.BM('test').' where id=6');
//$_POST=ZiFuChuan_Zhuan_ShuZu($uu['neirong']);
$fanhuishu=$_POST;
$body= explode(":",$fanhuishu['body']);
$_W['danyuan']=$body[0];
$_W['mo']=$body[1];
$leixing=$body[2];
if(empty($_POST)){
	echo fail;die;
}
$pz=MX('zhifu','he')->PeiZhi();
$peizhi['app_id']=$pz['alipay']['app_id'];
$peizhi['merchant_private_key']=$pz['alipay']['apprsa'];
$peizhi['charset']= "UTF-8";
$peizhi['sign_type']="RSA2";
$peizhi['gatewayUrl']="https://openapi.alipay.com/gateway.do";
$peizhi['alipay_public_key']=$pz['alipay']['alipay_public_key'];
$alipaySevice = new AlipayTradeService($peizhi); 
$alipaySevice->writeLog(var_export($_POST,true));
$result = $alipaySevice->check($fanhuishu);

/* 实际验证过程建议商户添加以下校验。
1、商户需要验证该通知数据中的out_trade_no是否为商户系统中创建的订单号，
2、判断total_amount是否确实为该订单的实际金额（即商户订单创建时的金额），
3、校验通知中的seller_id（或者seller_email) 是否为out_trade_no这笔单据的对应的操作方（有的时候，一个商户可能有多个seller_id/seller_email）
4、验证app_id是否为该商户本身。
*/
if($result) {//验证成功
	//ChaRu('test',array('name'=>'通过'));
	$out_trade_no = $_POST['out_trade_no'];
	//支付宝交易号  
	$trade_no = $_POST['trade_no'];
	//交易状态
	$trade_status = $_POST['trade_status'];	
	$shu=array('dingdanhao'=>$out_trade_no,'jiaoyihao'=>$trade_no,'zongjia'=>$_POST['total_amount']);	
    if($_POST['trade_status'] == 'TRADE_FINISHED') {
        //MX()->ZhiFuYiBuFanHui($_POST,'zhifubao');
    }else if ($_POST['trade_status'] == 'TRADE_SUCCESS') {
    	if($leixing=='dingdan'){     	     	
	       MX()->ZhiFuYiBuFanHui($shu,'zhifubao');
	    }
    }	
	echo "success";		//请不要修改或删除
		
}else {
    //验证失败
    echo "fail";	//请不要修改或删除

}

?>

