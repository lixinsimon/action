<?php

/**
 * 陈金龙改动说明：
 *     已将没用的测试方法删除
 *     新增了2个方法：
 *         这2个方法均是为APiCloud支付支付方案一准备的，
 *         但是没有测试成功，
 *         新版本原生Android程序测试成功，可以保证这个方法的正确性；APiCloud对新版支付接口的支持问题有待验证。
 *         老版本的官方服务端的包已放置在 /public_html/neihe/ku/zhifubao/apppay
 *         
 *         1. LaoBanAppZhiFuBao(); //老版本支付宝接口
 *         2. XinBanAppZhiFuBao(); //新版本支付宝接口
 *     
 *     APiCloud的支付方案二经过测试报错 ALI40247
 *     APiCloud主要应用了alipayPlus接口
 */
require_once GENMULU . '/neihe/ku/zhifubao/wappay/service/AlipayTradeService.php';
require_once GENMULU . '/neihe/ku/zhifubao/wappay/buildermodel/AlipayTradeWapPayContentBuilder.php';

class zhifu
{
    private $peizhi;
    private $danyuan;
    public function __construct()
    {
        global $_W;
        $this->danyuan = $_W['danyuan'];
        $this->PeiZhi();

    }
    public function PeiZhi()
    {
        $peizhi = Cha('select * from ' . BM('he_peizhi') . " where danyuan=" . $this->danyuan);
        $this->peizhi = ZiFuChuan_Zhuan_ShuZu($peizhi['zhifu']);
        return $this->peizhi;
    }
    // 修正了错误，该方法名应该为 ZhiFuBao 
   public function ZhiFuBao($shu = '', $fanhuiurl = '', $leixing = 'dingdan')
    {
        global $_W;
        $shuju = array();
        $shuju['body'] = $_W['danyuan'] . ':' . $_W['mo'] . ':' . $leixing;
        $shuju['subject'] = $_W['shezhi']['shezhi']['ming'];
        $shuju['out_trade_no'] = $shu['dingdanhao'];
        $shuju['total_amount'] = $shu['zongjia'];

        $peizhi = array();
        $peizhi['app_id'] = $this->peizhi['alipay']['app_id'];
        $peizhi['merchant_private_key'] = $this->peizhi['alipay']['apprsa'];
        $peizhi['notify_url'] = $_W['yuming'] . "zhifu/zhifubao_notify.php";
        
        if($fanhuiurl){
        	$peizhi['return_url'] = $fanhuiurl;
        }else{
           $peizhi['return_url'] = UAK('dingdan/zhifu', array('c' => 'fanhui'));	
        }        
        $peizhi['charset'] = "UTF-8";
        $peizhi['sign_type'] = "RSA2";
        $peizhi['gatewayUrl'] = "https://openapi.alipay.com/gateway.do";
        $peizhi['alipay_public_key'] =  $this->peizhi['alipay']['alipay_public_key'];
        return $this->_ZhiFuBao($shuju, $peizhi);
    }
    public function _ZhiFuBao($shu, $peizhi)
    {
        $out_trade_no = $shu['out_trade_no'];
        //订单名称，必填
        $subject = $shu['subject'];
        //付款金额，必填
        $total_amount = $shu['total_amount'];
        //商品描述，可空
        $body = $shu['body'];
        //超时时间
        $timeout_express = "1m";
        $payRequestBuilder = new AlipayTradeWapPayContentBuilder();
        $payRequestBuilder->setBody($body);
        $payRequestBuilder->setSubject($subject);
        $payRequestBuilder->setOutTradeNo($out_trade_no);
        $payRequestBuilder->setTotalAmount($total_amount);
        $payRequestBuilder->setTimeExpress($timeout_express);
        $payResponse = new AlipayTradeService($peizhi);
    
        $result = $payResponse->wapPay($payRequestBuilder, $peizhi['return_url'], $peizhi['notify_url']);
        return $result;
    }    
    public function _APPZhiFuBao($shu, $peizhi){
    	require_once GENMULU . '/neihe/ku/zhifubao/aop/AopClient.php';
    	require_once GENMULU . '/neihe/ku/zhifubao/aop/request/AlipayTradeAppPayRequest.php';    	     
        $aop = new AopClient;
        $aop->gatewayUrl = "https://openapi.alipay.com/gateway.do";
				$aop->appId = $peizhi['app_id'];
				$aop->rsaPrivateKey =  $peizhi['merchant_private_key'];
				$aop->format = "json";
				$aop->charset = "UTF-8";
				$aop->signType = "RSA2";
				$aop->alipayrsaPublicKey =$peizhi['alipay_public_key'];
				$request = new AlipayTradeAppPayRequest();        
				$bizcontent =json_encode($shu);       
				$request->setNotifyUrl($peizhi['notify_url']);
				$request->setBizContent($bizcontent);	
				$response = $aop->sdkExecute($request);		
        return $response;
    }
    public function APPZhiFuBao($shu = '', $fanhuiurl = '', $leixing = 'dingdan'){ 	
    	global $_W;
        $shuju = array();
        $shuju['body'] = $_W['danyuan'] . ':' . $_W['mo'] . ':' . $leixing;
        $shuju['subject'] = $_W['shezhi']['shezhi']['ming'];
        $shuju['out_trade_no'] = $shu['dingdanhao'];
        $shuju['total_amount'] = $shu['zongjia'];

        $peizhi = array();
        $peizhi['app_id'] = $this->peizhi['alipay']['app_id'];
        $peizhi['merchant_private_key'] = $this->peizhi['alipay']['apprsa'];
        $peizhi['notify_url'] = $_W['yuming'] . "zhifu/zhifubao_notify.php";       
        $peizhi['charset'] = "UTF-8";
        $peizhi['sign_type'] = "RSA2";
        $peizhi['gatewayUrl'] = "https://openapi.alipay.com/gateway.do";
        $peizhi['alipay_public_key'] =  $this->peizhi['alipay']['alipay_public_key'];			
				return $this->_APPZhiFuBao($shuju, $peizhi);
    }
     public function WeiXin($shu = '', $fanhuiurl = '', $leixing = 'dingdan'){
     	 global $_W;
     	 if($_W['zhongduan']=='xiaochengxu'){
     	 	return $this->XiaoChengXu_WXZhiFu($shu,$fanhuiurl,$leixing);
     	 }
     	 
     	 $pz=$this->peizhi['wechat'];    
     	 $bao=array();
     	 $bao['appid']= $pz['appid'];
     	 $bao['mch_id']= $pz['mchid'];
     	 $bao['nonce_str']= random(8) . "";
     	 $bao['body'] = $_W['shezhi']['shezhi']['ming'];;
     	 $bao['device_info']= 'shangsheng';
     	 $bao['attach']= $_W['danyuan'] . ':' . $_W['mo'] . ':' . $leixing;
     	 $bao['out_trade_no']= $shu['dingdanhao'];
     	 $bao['total_fee']= $shu['zongjia']*100;
     	 $bao['spbill_create_ip']= GetIp();
     	 $bao['notify_url']= $_W['yuming'] . "zhifu/weixin_notify.php";
     	 if($_W['zhongduan']=='weixin'){
     	 	$bao['trade_type']= 'JSAPI';
     	    $bao['openid']= $_W['huiyuan']['openid'];   
     	 }else{
     	 	//H5支付
     	 	$bao['trade_type']= 'MWEB';
     	    $bao['scene_info']='{"h5_info": {"type":"Wap","wap_url": "'.$_W['yuming'].'","wap_name": "'.$_W['shezhi']['shezhi']['ming'].'"}} ';  
     	 }     	     	       
         ksort($bao, SORT_STRING);                  
         $zihuzifuchuan = '';
         foreach ($bao as $key => $v) {
            if (empty($v)) {
                continue;
            }
            $zihuzifuchuan .= "{$key}={$v}&";
         }
         $zihuzifuchuan .= "key={$pz['apikey']}";        
         $bao['sign'] = strtoupper(md5($zihuzifuchuan));
         $dat = ShuZu_Zhuan_XML($bao);  
         Han('curl');         
         $response= ihttp_request('https://api.mch.weixin.qq.com/pay/unifiedorder', $dat);         
         $xml = @simplexml_load_string($response['content'], 'SimpleXMLElement', LIBXML_NOCDATA);        
         if (strval($xml->return_code) == 'FAIL') {
         	XiaoXi(strval($xml->return_msg));            
         }
         if (strval($xml->result_code) == 'FAIL') {
                XiaoXi(strval($xml->err_code) . ': ' . strval($xml->err_code_des));
            }
        $prepayid= $xml->prepay_id;       
        $wOpt['appId']     = $pz['appid'];
        $wOpt['timeStamp'] = SHIJIAN . "";
        $wOpt['nonceStr']  = random(8) . "";
        $wOpt['package']   = 'prepay_id=' . $prepayid;
        $wOpt['signType']  = 'MD5';
        ksort($wOpt, SORT_STRING);
        foreach ($wOpt as $key => $v) {
            $string .= "{$key}={$v}&";
        }
        $string .= "key={$pz['apikey']}";
        $wOpt['paySign'] = strtoupper(md5($string));
        return $wOpt;
     }
     public function WeiXinH5($shu = '', $fanhuiurl = '', $leixing = 'dingdan'){
     	 global $_W;
     	 $pz=$this->peizhi['wechat'];   
     	 $bao=array();
     	 $bao['appid']= $pz['appid'];
     	 $bao['mch_id']= $pz['mchid'];
     	 $bao['nonce_str']= random(8) . "";
     	 $bao['body'] = $_W['shezhi']['shezhi']['ming'];
     	 $bao['device_info']= 'shangcheng';
     	 $bao['attach']= $_W['danyuan'] . ':' . $_W['mo'] . ':' . $leixing;
     	 $bao['out_trade_no']= $shu['dingdanhao'];
     	 $bao['total_fee']= $shu['zongjia']*100;
     	 $bao['spbill_create_ip']= GetIp();
     	 $bao['notify_url']= $_W['yuming'] . "zhifu/weixin_notify.php";
     	 $bao['trade_type']= 'MWEB';
     	 $bao['scene_info']='{"h5_info": {"type":"Wap","wap_url": "'.$_W['yuming'].'","wap_name": "'.$_W['shezhi']['shezhi']['ming'].'"}} ';       	       
         ksort($bao, SORT_STRING);                  
         $zihuzifuchuan = '';
         foreach ($bao as $key => $v) {
            if (empty($v)) {
                continue;
            }
            $zihuzifuchuan .= "{$key}={$v}&";
         }
         $zihuzifuchuan .= "key={$pz['apikey']}";        
         $bao['sign'] = strtoupper(md5($zihuzifuchuan));
         $dat = ShuZu_Zhuan_XML($bao);  
         Han('curl');         
         $response= ihttp_request('https://api.mch.weixin.qq.com/pay/unifiedorder', $dat);         
         $xml = @simplexml_load_string($response['content'], 'SimpleXMLElement', LIBXML_NOCDATA);        
         if (strval($xml->return_code) == 'FAIL') {
         	XiaoXi(strval($xml->return_msg));            
         }
         if (strval($xml->result_code) == 'FAIL') {
                XiaoXi(strval($xml->err_code) . ': ' . strval($xml->err_code_des));
            }
        $prepayid= $xml->prepay_id;       
        $wOpt['appId']     = $pz['appid'];
        $wOpt['timeStamp'] = SHIJIAN . "";
        $wOpt['nonceStr']  = random(8) . "";
        $wOpt['package']   = 'prepay_id=' . $prepayid;
        $wOpt['signType']  = 'MD5';
        ksort($wOpt, SORT_STRING);
        foreach ($wOpt as $key => $v) {
            $string .= "{$key}={$v}&";
        }
        $string .= "key={$pz['apikey']}";
        $wOpt['paySign'] = strtoupper(md5($string));
        return $wOpt;
     }
     public function APPWXZhiFu($shu = '', $fanhuiurl = '', $leixing = 'dingdan'){
     	global $_W;     	 
     	 $pz=$this->peizhi['appwechat'];       	
     	 $bao=array();
     	 $bao['apiKey']= $pz['key'];
     	 $bao['mchId']= $pz['mchid']; 
     	 $bao['notifyUrl']= $_W['yuming'] . "zhifu/weixin_notify_app.php";  
     	 $bao['partnerKey']= $pz['apikey'];	     	
     	 $bao['description'] = $_W['shezhi']['shezhi']['ming'];
     	 $bao['totalFee']= $shu['zongjia']*100;
     	 $bao['spbillCreateIP']= GetIp();
     	 $bao['deviceInfo']= 'shangsheng';
     	 $bao['attach']= $_W['danyuan'] . '|' . $_W['mo'] . '|' . $leixing;
     	 $bao['tradeNo']= $shu['dingdanhao'];    	 
         return  $bao;
     	
     }  
     
     public function XiaoChengXu_WXZhiFu($shu = '', $fanhuiurl = '', $leixing = 'dingdan'){
     	 global $_W;
     	 $pz=$this->peizhi['xiaochengxu'];   
     	 $bao=array();
     	 $bao['appid']= $pz['appid'];
     	 $bao['mch_id']= $pz['mchid'];
     	 $bao['nonce_str']= random(8) . "";
     	 $bao['body'] = $_W['shezhi']['shezhi']['ming'];;
     	 $bao['device_info']= 'shangsheng';
     	 $bao['attach']= $_W['danyuan'] . ':' . $_W['mo'] . ':' . $leixing;
     	 $bao['out_trade_no']= $shu['dingdanhao'];
     	 $bao['total_fee']= $shu['zongjia']*100;
     	 $bao['spbill_create_ip']= GetIp();
     	 $bao['notify_url']= $_W['yuming'] . "zhifu/weixin_notify.php";
     	 $bao['trade_type']= 'JSAPI';     	
     	 $bao['openid']= $_W['huiyuan']['xcx_openid'];      	       
         ksort($bao, SORT_STRING);                
         $zihuzifuchuan = '';
         foreach ($bao as $key => $v) {
            if (empty($v)) {
                continue;
            }
            $zihuzifuchuan .= "{$key}={$v}&";
         }
         $zihuzifuchuan .= "key={$pz['apikey']}";        
         $bao['sign'] = strtoupper(md5($zihuzifuchuan));
         $dat = ShuZu_Zhuan_XML($bao);  
         Han('curl');         
         $response= ihttp_request('https://api.mch.weixin.qq.com/pay/unifiedorder', $dat);         
         $xml = @simplexml_load_string($response['content'], 'SimpleXMLElement', LIBXML_NOCDATA);        
         if (strval($xml->return_code) == 'FAIL') {
         	XiaoXi(strval($xml->return_msg));            
         }
         if (strval($xml->result_code) == 'FAIL') {
                XiaoXi(strval($xml->err_code) . ': ' . strval($xml->err_code_des));
            }
        $prepayid= $xml->prepay_id;    
		$muban['keyword1']['didian']='TIT造舰厂';
		$muban['keyword2']['shijian']='2016年6月6日';
		$muban['keyword3']['nicheng']='咖啡';
		$muban['keyword4']['danhao']='23432132';
        $wOpt['appId']     = $pz['appid'];
        $wOpt['timeStamp'] = SHIJIAN . "";
        $wOpt['nonceStr']  = random(8) . "";
        $wOpt['package']   = 'prepay_id=' . $prepayid;
        $wOpt['signType']  = 'MD5';
        ksort($wOpt, SORT_STRING);
        foreach ($wOpt as $key => $v) {
            $string .= "{$key}={$v}&";
        }
        $string .= "key={$pz['apikey']}";
        $wOpt['paySign'] = strtoupper(md5($string));
		
		MX('xiaochengxu','he')->MuBanXiaoXi('zhifu',$_W['huiyuan']['xcx_openid'],'za0GvFBfyhXq8dykJuv_ZdZYeTSjoDPvuuom-N6ws7Q',$muban,$prepayid);
		
        return $wOpt;
     }  
     
     public function ChiLiZhiFu($shu,$qudao,$shui){
		global $_W;	 	
    	$jilu=Qu('he_zhifu_jilu',array('danyuan'=>$_W['danyuan'],'dingdanhao'=>$shu['dingdanhao'],'jin_e'=>$shu['zongjia']));     	
    	
    	if($jilu){   		
    		if($shui){ 
    			$jilu['qita']=ZiFuChuan_Zhuan_ShuZu($jilu['qita']);  				
    			MX()->$shui($jilu);	  
    		}  
    		return  Gai('he_zhifu_jilu',array('zhuangtai'=>10),array('id'=>$jilu['id']));      		   		      		  
    	}
    	return false;
		
	}
     
     //$Shui 支付类型：‘ZhiFuYiBuFanHui’默认为订单
     public function YuE($d=array(),$Shui=''){
     	global $_W;     	
     	$zong_yu_e=MX('huiyuan','he')->BiZongE('yongjin',$_W['huiyuan']['id']);
     	$yu_e=$zong_yu_e;        
     	if($yu_e>0 && $yu_e>=$d['zongjia']){     		
     		 $data=array('dingdanhao'=>$d['dingdanhao'],'jiaoyihao'=>'','zongjia'=>$d['zongjia']);   
     		 if(empty($Shui)){
     		 	$z=MX()->ZhiFuYiBuFanHui($data,'yu_e');  
     		 }else{     		 
     		 	$z=$this->ChiLiZhiFu($data,'yu_e',$Shui);  
     		 }     
     		 		    		     		 	
     		 if(empty($z)){
     		   	json('已付款',0);
     		 }  
     		 MX('huiyuan','he')->BiZong_JiaJian('yongjin',$_W['huiyuan']['id'],-$d['zongjia'],'购物消费',$d['dingdanhao']);    		
     		 return true;
     	}     
     	json('余额不足',0);
     	
     }
     public function DuiHuan($d=array(),$Shui=''){
     	global $_W;     	
     	$jifen=MX('huiyuan','he')->BiZongE('jifen',$_W['huiyuan']['id']);
     	$liquan=MX('huiyuan','he')->BiZongE('liquan',$_W['huiyuan']['id']);
     	$xunzhang=MX('huiyuan','he')->BiZongE('xunzhang',$_W['huiyuan']['id']);

      	if($d['jifenkou']>$jifen && $d['jifenkou']>0 ){
	    	json('积分不足',0);
	    }
	     if($d['liquan']>$liquan && $d['liquan']>0 ){
	    	json('礼券不足',0);
	    }
	     if($d['xunzhang']>$xunzhang && $d['xunzhang']>0){
	    	json('勋章不足',0);
	    }
     		
     	
     		     		
     		 $data=array('dingdanhao'=>$d['dingdanhao'],'jiaoyihao'=>'','zongjia'=>$d['zongjia']);   
     		 if(empty($Shui)){
     		 	$z=MX()->ZhiFuYiBuFanHui($data,'duihuan');  
     		 }else{     		 
     		 	$z=$this->ChiLiZhiFu($data,'duihuan',$Shui);  
     		 }     
//   		 	 		     		 	
     		 if(empty($z)){
     		 	return false;
     		 }  
     		 MX('huiyuan','he')->BiZong_JiaJian('xunzhang',$_W['huiyuan']['id'],-$d['xunzhang'],'兑换商品',$d['dingdanhao']);
     		 MX('huiyuan','he')->BiZong_JiaJian('liquan',$_W['huiyuan']['id'],-$d['liquan'],'兑换商品',$d['dingdanhao']);
     		 MX('huiyuan','he')->BiZong_JiaJian('jifen',$_W['huiyuan']['id'],-$d['jifenkou'],'兑换商品',$d['dingdanhao']);
     		 return true;
     		 
     		 
     	
     }
     public function YonJin($d=array(),$Shui=''){
     	global $_W;     	
     	$yu_e=MX('huiyuan','he')->BiZongE('yongjin',$_W['huiyuan']['id']);
           
     	if($yu_e>0 && $yu_e>=$d['zongjia']){     		
     		 $data=array('dingdanhao'=>$d['dingdanhao'],'jiaoyihao'=>'','zongjia'=>$d['zongjia']);   
     		 if(empty($Shui)){
     		 	$z=MX()->ZhiFuYiBuFanHui($data,'yonjin');  
     		 }else{     		 
     		 	$z=$this->ChiLiZhiFu($data,'yonjin',$Shui);  
     		 }     
     		 		    		     		 	
     		 if(empty($z)){
     		 	return false;
     		 }  
     		  MX('huiyuan','he')->BiZong_JiaJian('yongjin',$_W['huiyuan']['id'],-$d['zongjia'],'购物消费'.$d['dingdanhao']);
     		  		
     		 return true;
     	}     
     	return false;
     	
     }
     public function JiFen($d=array()){
     	global $_W;     	
     	$jifen=MX('huiyuan','he')->qu_jifen($_W['huiyuan']['id']);     	
     	if($jifen>0 && $jifen>=$d['zongjia']){   
     		 $data=array('dingdanhao'=>$d['dingdanhao'],'jiaoyihao'=>'','zongjia'=>$d['zongjia']);	 		 
     		 $z=MX()->ZhiFuYiBuFanHui($data,'jifen');    
     		 if(empty($z)){
     		 	return false;
     		 }
     		 MX('huiyuan','he')->gai_jifen($_W['huiyuan']['id'],-$d['zongjia'],'购物消费'.$d['dingdanhao']);     		
     		 return true;
     	}     
     	return false;
     	
    }
    //货到付款
    public function DaoFu($d=array()){
     	$data=array('dingdanhao'=>$d['dingdanhao'],'jiaoyihao'=>'','zongjia'=>$d['zongjia']);	 		 
 		 $z=MX()->ZhiFuYiBuFanHui($data,'daofu'); 
 		 if(empty($z)){
 		 	  return false;
 		 }      		   		
 		return true;    	
     }
    //微信企业支付
    public function QiYeZhiFu($openid='',$shu=''){
    	if(intval($openid)){
    		$op=Qu('he_huiyuan',array('id'=>$openid),'openid');
    		$openid=$op['openid'];
    	}
    	if(empty($openid)){
    		 XiaoXi('此人不是微信用户，无微信打款');
    		return false;
    	}    	
    	$pz=$this->peizhi['wechat'];      	
    	$path = GENMULU . "/gongyong/shangchuan/zhengshu/";
		$wx_apiclient_cert=$path.'wechat/apiclient_cert_'.$this->danyuan.'.pem';
		$wx_apiclient_key=$path.'wechat/apiclient_key_'.$this->danyuan.'.pem';
		$wx_rootca=$path.'wechat/rootca_'.$this->danyuan.'.pem';
		if(!is_file($wx_apiclient_cert) || !is_file($wx_apiclient_key) || !is_file($wx_rootca)){
			 XiaoXi('证书未上传');
			 return false;
		}	
      	$extras['CURLOPT_SSLCERT'] = $wx_apiclient_cert;
		$extras['CURLOPT_SSLKEY'] = $wx_apiclient_key;
		$extras['CURLOPT_CAINFO'] = $wx_rootca;		
    		
		$b['mch_appid']=$pz['appid'];
		$b['mchid']=$pz['mchid'];
		$b['nonce_str']=random(8) . "";
		$b['device_info']='zhiwei';		
		$b['partner_trade_no']=$shu['dingdanhao'];	
		$b['openid']=$openid;
		$b['check_name']='NO_CHECK';
		$b['amount']=intval($shu['e']*100);
		$b['desc']='分配余额';
		$b['spbill_create_ip']=GetIp();
	    ksort($b, SORT_STRING);
        foreach ($b as $key => $v) {
            $string .= "{$key}={$v}&";
        }
        $string .= "key={$pz['apikey']}";
       
        $b['sign'] = strtoupper(md5($string));       
		$dat = ShuZu_Zhuan_XML($b);  	
        Han('curl'); 
        $response= ihttp_request('https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers', $dat,$extras);   
        $xml = @simplexml_load_string($response['content'], 'SimpleXMLElement', LIBXML_NOCDATA); 
        if($xml->result_code=='FAIL'){
        	XiaoXi($xml->err_code_des);
        }       
       return true;
	}
	//微信红包
	public function HongBao($openid='',$shu=''){
		global $_W; 
		if(intval($openid)){
    		$op=Qu('he_huiyuan',array('id'=>$openid),'openid');
    		$openid=$op['openid'];
    	}
    	if(empty($openid)){
    		 XiaoXi('此人不是微信用户，无微信打款');
    		return false;
    	}    	
    	$pz=$this->peizhi['wechat'];      	
    	$path = GENMULU . "/gongyong/shangchuan/zhengshu/";
		$wx_apiclient_cert=$path.'wechat/apiclient_cert_'.$this->danyuan.'.pem';
		$wx_apiclient_key=$path.'wechat/apiclient_key_'.$this->danyuan.'.pem';
		$wx_rootca=$path.'wechat/rootca_'.$this->danyuan.'.pem';
		if(!is_file($wx_apiclient_cert) || !is_file($wx_apiclient_key) || !is_file($wx_rootca)){
			 XiaoXi('证书未上传');
			 return false;
		}	
      	$extras['CURLOPT_SSLCERT'] = $wx_apiclient_cert;
		$extras['CURLOPT_SSLKEY'] = $wx_apiclient_key;
		$extras['CURLOPT_CAINFO'] = $wx_rootca;	
			
		$b['nonce_str']=random(8) . "";
		$b['mch_billno']=$shu['dingdanhao'];
		$b['mchid']=$pz['mchid'];
		$b['mch_appid']=$pz['appid'];		
		$b['send_name']=$_W['shezhi']['shezhi']['ming'];			
		$b['re_openid']=$openid;
		$b['total_amount']=intval($shu['e']*100);		
		$b['total_num']=1;		
		$b['wishing']='红包祝福语';
		$b['act_name']=$_W['shezhi']['shezhi']['ming'].'红包';
		$b['remark']=$_W['shezhi']['shezhi']['ming'].'红包';		
		//PRODUCT_5:渠道分润 
		$b['scene_id']='PRODUCT_5';		
		$b['client_ip']=GetIp();
	    ksort($b, SORT_STRING);
        foreach ($b as $key => $v) {
            $string .= "{$key}={$v}&";
        }
        $string .= "key={$pz['apikey']}";       
        $b['sign'] = strtoupper(md5($string));       
		$dat = ShuZu_Zhuan_XML($b);  	
        Han('curl'); 
        $response= ihttp_request('https://api.mch.weixin.qq.com/mmpaymkttransfers/sendredpack', $dat,$extras);   
        $xml = @simplexml_load_string($response['content'], 'SimpleXMLElement', LIBXML_NOCDATA); 
        if($xml->result_code=='FAIL'){
        	XiaoXi($xml->return_msg);
        }
        return true;       	
	}
	public function TuiKuan($dingdan){
		if(empty($dingdan)){
			return false;
		}
		if($dingdan['zhifuqudao']=='xiaochengxu'){
			$this->XiaoChengXuTuKuai($dingdan);
		}
		if($dingdan['zhifuqudao']=='weixin'){
			$this->WeiXinTuKuai($dingdan);
		}
		
		
	}
	public function XiaoChengXuTuKuai($shu=''){
		 global $_W;
		 if(empty($shu)){
		 	return FALSE;
		 }
     	 $pz=$this->peizhi['xiaochengxu'];   
     	 $bao=array();
     	 $bao['appid']= $pz['appid'];
     	 $bao['mch_id']= $pz['mchid'];
     	 $bao['nonce_str']= random(8) . "";
     	 $bao['out_trade_no']= $shu['dingdanhao'];
     	 $bao['total_fee']= $shu['zongjia']*100;
     	 $bao['refund_fee']= $shu['zongjia']*100;
     	 $bao['out_refund_no']= $shu['jiaoyihao'];
		 
         ksort($bao, SORT_STRING);                
         $zihuzifuchuan = '';
         foreach ($bao as $key => $v) {
            if (empty($v)) {
                continue;
            }
            $zihuzifuchuan .= "{$key}={$v}&";
         }
         $zihuzifuchuan .= "key={$pz['apikey']}";        
         $bao['sign'] = strtoupper(md5($zihuzifuchuan));
         $dat = ShuZu_Zhuan_XML($bao);  
         Han('curl');         
         $response= curl_post_ssl('https://api.mch.weixin.qq.com/secapi/pay/refund',$dat);         
         $xml = @simplexml_load_string($response, 'SimpleXMLElement', LIBXML_NOCDATA); 
		 
		 if($xml->return_code!='SUCCESS'){
		 	json($xml->return_msg,0);
		 }
		  
        return $xml;
	}
	public function WeiXinTuKuai($shu=''){
		 global $_W;
		 if(empty($shu)){
		 	return FALSE;
		 }
     	 $pz=$this->peizhi['wechat'];   
     	 $bao=array();
     	 $bao['appid']= $pz['appid'];
     	 $bao['mch_id']= $pz['mchid'];
     	 $bao['nonce_str']= random(8) . "";
     	 $bao['out_trade_no']= $shu['dingdanhao'];
     	 $bao['total_fee']= $shu['zongjia']*100;
     	 $bao['refund_fee']= $shu['zongjia']*100;
     	 $bao['out_refund_no']= $shu['jiaoyihao'];
		 
         ksort($bao, SORT_STRING);                
         $zihuzifuchuan = '';
         foreach ($bao as $key => $v) {
            if (empty($v)) {
                continue;
            }
            $zihuzifuchuan .= "{$key}={$v}&";
         }
         $zihuzifuchuan .= "key={$pz['apikey']}";        
         $bao['sign'] = strtoupper(md5($zihuzifuchuan));
         $dat = ShuZu_Zhuan_XML($bao);  
         Han('curl');         
         $response= curl_post_ssl('https://api.mch.weixin.qq.com/secapi/pay/refund',$dat);         
         $xml = @simplexml_load_string($response, 'SimpleXMLElement', LIBXML_NOCDATA); 
		 
		 if($xml->return_code!='SUCCESS'){
		 	json($xml->return_msg,0);
		 }
		  
        return $xml;
	}
}
