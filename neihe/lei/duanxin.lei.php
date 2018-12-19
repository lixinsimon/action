<?php
class duanxin{
	private $peizhi;
    private $danyuan;
    public function __construct(){
        global $_W;
        $this->danyuan = $_W['danyuan'];
        $this->PeiZhi();

    }
    public function PeiZhi(){
    	  if(empty($this->peizhi)){
	          $peizhi = Cha('select duanxin from ' . BM('he_peizhi') . " where danyuan=" . $this->danyuan);
	          if(empty($peizhi)){
	              return false;
	          }
	          $pz = ZiFuChuan_Zhuan_ShuZu($peizhi['duanxin']);
	          $this->peizhi=$pz['dayu'];
	       } 
          return $this->peizhi;
    }
    public function FaSong($shouji=Null,$leixing=''){
        //发送信息统一接口	
    }
    public function _Song($shouji='',$shu=array(),$leixing=''){      
    	if(empty($shouji)){	XiaoXi('手机号不正确');}
    	if(is_array($shouji)){    	
    		$sj='';
    		foreach($shouji as $s){
    			$sj.=$s.',';
    		}
    		$shouji=rtrim($sj,',');
    	}
    	
    	$p=$this->peizhi;    	
    	$bao=array();
    	$bao['method']='alibaba.aliqin.fc.sms.num.send';
    	$bao['app_key']=$p['key'];
    	$bao['sign_method']='md5';
    	$bao['timestamp']=date('Y-m-d H:i:s',time());
    	$bao['v']='2.0';
    	$bao['sms_type']='normal';
    	$bao['sms_free_sign_name']=$p[$leixing]['qianming'];
    	$bao['sms_param']=json_encode($shu);
    	$bao['rec_num']=$shouji;
    	$bao['sms_template_code']=$p[$leixing]['id'];    	
    	ksort($bao, SORT_STRING);     		
    	$zihuzifuchuan =$p['secret'];    	
         foreach ($bao as $key => $v) {
            if (empty($v)) {
                continue;
            }
            $zihuzifuchuan .= "{$key}{$v}";
         }
        $zihuzifuchuan .= $p['secret'];       
        $bao['sign'] = strtoupper(md5($zihuzifuchuan));
        Han('curl');       
    	$fhshu= ihttp_request('http://gw.api.taobao.com/router/rest', $bao);     	
    	$fanhuishu= @simplexml_load_string($fhshu['content'], 'SimpleXMLElement', LIBXML_NOCDATA);       	    	
    	$fanhuishu=ZhuanShuZu($fanhuishu);     	   
    	if(empty($fanhuishu['code'])){
    		$jilu=array(
    	      'danyuan'=>$this->danyuan,
    	      'shouji'=>$shouji,
    	      'neirong'=>empty($shu['code'])?json_encode($shu):$shu['code'],
    	      'shijian'=>time(),
    	      'request_id'=>$fanhuishu['request_id'],
    	      'leixing'=>$p[$leixing]['qianming'],
    	      'zhuangtai'=>0
    	      ); 
    	    ChaRu('he_duanxin',$jilu);  
    	}    	 	   	
    	return $fanhuishu;
    }
    public function alidayu($shouji='',$shu=array(),$leixing=''){
    	global $_W;
    	if(empty($shouji)){	XiaoXi('手机号不正确');}
    	if(is_array($shouji)){    	
    		$sj='';
    		foreach($shouji as $s){
    			$sj.=$s.',';
    		}
    		$shouji=rtrim($sj,',');
    	}
    	require_once GENMULU . '/neihe/ku/alidayu/api_demo/SmsDemo.php';    	
    	$p=$this->peizhi;    
    	$demo = new SmsDemo($p['key'],"".$p['secret']);
    	$fanhuishu = $demo->sendSms($p[$leixing]['qianming'], $p[$leixing]['id'],$shouji,$shu);	
    	if(is_object($fanhuishu)) {  
	        $fanhuishu = (array)$fanhuishu;  
	    }	    
		if($fanhuishu['Code']=="OK"){			
    		$jilu=array(
    	      'danyuan'=>$this->danyuan,
    	      'shouji'=>$shouji,
    	      'neirong'=>empty($shu['code'])?json_encode($shu):$shu['code'],
    	      'shijian'=>time(),
    	      'request_id'=>$fanhuishu['RequestId'],
    	      'leixing'=>$p[$leixing]['qianming'],
    	      'zhuangtai'=>0
    	      );      	      
    	    ChaRu('he_duanxin',$jilu);  
    	    return true;
        }else{    		
    		return false;
    	}  
		
    }
    public function YanZhengMa($shouji=Null,$leixing='zhuce',$ming=''){
    	global $_W;    	
    	if(empty($ming)){
    		$ming=$_W['dy']['mingcheng'];
    	}
    	$shu=array(
    	     'code'=>random(4,true),
					 'product'=>' '.$ming.' '
    	     ); 
    	
    	//$fanhuishu= $this->_Song($shouji,$shu,$leixing); 
    	 $fanhuishu= $this->alidayu($shouji,$shu,$leixing); 
	  	
    	return $fanhuishu;
    }
    
}
?>