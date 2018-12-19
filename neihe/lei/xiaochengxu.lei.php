<?php
Han('curl');
class xiaochengxu{
	private $peizhi;
    private $danyuan;
    private $appid;
	private $sessionKey;
	public static $OK = 0;
	public static $IllegalAesKey = -41001;
	public static $IllegalIv = -41002;
	public static $IllegalBuffer = -41003;
	public static $DecodeBase64Error = -41004;
    public function __construct(){
        global $_W;
        $this->danyuan = $_W['danyuan'];
        $this->peizhi=$this->PeiZhi();       
    } 	
	public function PeiZhi($id='',$ziduan='*'){	   
	    $id=empty($id)?$this->danyuan:$id;	
	    $dy=Qu('he_peizhi',array('danyuan'=> $id),$ziduan);	
	    if($dy['zhifu']){ 
	         $dy['zhifu'] =ZiFuChuan_Zhuan_ShuZu($dy['zhifu']);
	    }
	    if($dy['access_token']){
	       $dy['access_token'] =ZiFuChuan_Zhuan_ShuZu($dy['access_token']);
	    }
		return $dy;
	}
	public function AccessToken(){			
		$pz=$this->peizhi['zhifu']['xiaochengxu'];	
		
		if(empty($pz)){
			return false;
		}
		
		$token=$this->peizhi['access_token']['xiaochengxu'];
		$access_token=$token['access_token'];		
		if($token['expires_in']<time() || empty($token)){				
			$url='https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$pz['appid'].'&secret='.$pz['secret'];
		    $AccessToken=get($url);			   
		    $access_token=$AccessToken['access_token'];		  
		    if($access_token){
		       $expires_in=$AccessToken['expires_in']+time();
		       $shu['xiaochengxu']=array('access_token'=>$access_token,'expires_in'=>$expires_in);	       
		       $s['access_token']=ShuZu_Zhuan_ZiFuChuan($shu);
		       Gai('he_peizhi',$s,array('danyuan'=>$this->danyuan));
		    }else{
		    	XiaoXi($AccessToken['errmsg']);
		    }
	   } 	   	
	   return $access_token;
	}
	public function ErWeiMa($ming='',$lujing='pages/zw_shangcheng/index/index',$kuan=430,$Lei='linshi'){
		global $_W;	
		$pz=$this->peizhi['zhifu']['xiaochengxu'];		
		if(empty($pz['kaiguan'])){
			return false;
		}
		
	    $ming='xiaochengxu'.$this->danyuan.'_'.$ming;
		
		$MULU=GENMULU.'/huancun/erweima';
		if(!is_dir($MULU)){	    	
	    	mkdir($MULU,0777);
	    	chmod($MULU,0777);	
	    }
		$QR=$MULU.'/'.$ming.'.png'; 
		$huancun='huancun/erweima/'.$ming.".png";
		$img=$_W['yuming'].$huancun;

		
		if(file_exists($QR)){

	    	return $huancun;
	    }
		 		
		$access_token=$this->AccessToken();
		if(empty($access_token)){
			return false;
		}
		$shu['path']=$lujing;
		$shu['width']=$kuan;		
		//$shu['auto_color']=false;
		//$shu['line_color']='{"r":"0","g":"0","b":"0"}';
		if($Lei=='yongjiu'){			
			$url='https://api.weixin.qq.com/wxa/getwxacode?access_token='.$access_token;
		}elseif($Lei=='linshi'){
			$shu['scene']=empty($_W['huiyuan']['id'])?0:$_W['huiyuan']['id'];
			$url='https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token='.$access_token;
		}		
		$data=jsonFormat($shu);     	
    	$e=ihttp_request($url,$data);      	
    	if(empty($e['content'])){
    		json($e,0);    		
    	}     	
    	$file = fopen($QR,"w");
    	fwrite($file,$e['content']);//写入  
        fclose($file);//关闭 
	   
	    if(!file_exists($QR)){
	    	json('生成失败',0);
	    }		


		return $huancun;		
	}
	//获取openid
	public function OpenID($code){
		$pz=$this->peizhi['zhifu']['xiaochengxu'];
		Han('curl');		
		$url="https://api.weixin.qq.com/sns/jscode2session?appid=".$pz['appid']."&secret=".$pz['secret']."&js_code=".$code."&grant_type=authorization_code";
		$get_openid=get($url);				
		if(empty($get_openid['openid'])){
			json('获取openid失败',0);
		}	
		return $get_openid;
	
	}
	
	public function decryptData($encryptedData, $iv )
	{
		if (strlen($this->sessionKey) != 24) {
			return $this->$IllegalAesKey;
		}
		$aesKey=base64_decode($this->sessionKey);
        
		if (strlen($iv) != 24) {
			return $this->$IllegalIv;
		}
		$aesIV=base64_decode($iv);

		$aesCipher=base64_decode($encryptedData);

		$result=openssl_decrypt( $aesCipher, "AES-128-CBC", $aesKey, 1, $aesIV);

		$dataObj=json_decode( $result );
		if( $dataObj  == NULL )
		{
			return $this->$IllegalBuffer;
		}
		if( $dataObj->watermark->appid != $this->appid )
		{
			return $this->$IllegalBuffer;
		}		
		return $result;
	}
	//解密rawdata 数据 
	public function encryptData($shu,$session_key){		
		$pz=$this->peizhi['zhifu']['xiaochengxu'];	
		$this->sessionKey =  $session_key;
		$this->appid = $pz['appid'];				
		$data = $this->decryptData($shu['encryptedData'],$shu['iv'], $data);			
		if ($errCode == 0) {
		   return json_decode($data);
		} else {
		   json($errCode,0);
		}
	}
	//登录
	public function DengLu($shu){	
		global $_W;	
		Han('curl');			
		if(empty($this->peizhi['zhifu']['xiaochengxu']['kaiguan'])){
		 	json('小程序关闭',0);
		}		
		$get_openid=$this->OpenID($shu['code']);		 	
		$huiyuan=$this->encryptData($shu,$get_openid['session_key']);		
	  $huiyuan=ZhuanShuZu($huiyuan);		   
		if($huiyuan['unionid']){
				$where=" unionid='".$huiyuan['unionid']."'";	
		}elseif($huiyuan['openId']){
			$where=" xcx_openid='".$huiyuan['openId']."'";	
		}
		if(empty($where)){
			json('获取信息失败',0);
		}	 
		$h=Cha('select * from '.BM('he_huiyuan').' where danyuan='.$this->danyuan.' and '.$where);		
		//获取用户信息
	
		$C['nicheng']=GuoLv($huiyuan['nickName']);		     
		$C['xingbie']=empty($huiyuan['gender'])?'女':'男';						      
		$C['touxiang']=$huiyuan['avatarUrl'];			
		if(empty($h)){	
			$C['danyuan']=$this->danyuan;
			$C['xcx_openid']=$huiyuan['openId'];
			$C['unionid']=$huiyuan['unionid'];
			$C['fuji_id']=$shu['t'];
			$C['shijian']=SHIJIAN;
			$C['ip']=GetIp();		    
			$C['zhuangtai']=1;	
			$C['chengshi']=$huiyuan['city'];
			$C['shengfen']=$huiyuan['province'];			
			ChaRu('he_huiyuan',$C);
			$h=$C;
			$h['id']=ChaRuId();
		}else{
		    Gai('he_huiyuan',$C,$where);
		}
		//产生返回值 		
		ini_set("session.gc_maxlifetime","259200");
		ini_set("session.cookie_lifetime","259200");		
		session_start();				
		$_SESSION['id']=$h['id'];
		$_SESSION['danyuan']=$_W['danyuan'];
		$_SESSION['xingming']=$h['xingming'];
		$_SESSION['nicheng']=$C['nicheng'];
		$_SESSION['touxiang']=$C['touxiang'];
		$_SESSION['zhanghao']=$h['zhanghao'];	
		$_SESSION['openid']=$huiyuan['openId'];	
		$_SESSION['shijian']=SHIJIAN;
		$_SESSION['kouling']=session_id();
		//登录记录
		$denglujilu['danyuan']=$_W['danyuan'];
		$denglujilu['huiyuan']=$h['id'];
		$denglujilu['shijian']=SHIJIAN;
		$denglujilu['ip']=$C['ip'];		
		$denglujilu['zongduan']=$_W['zhongduan'];
		$denglujilu['xitong']=$_W['os'];
		$denglujilu['url']=$_W['url'];
		$denglujilu['openid']=$_SESSION['openid']; 
		ChaRu('he_denglu_jilu',$denglujilu);	
		return $_SESSION;
	}
	
	public function MuBanXiaoXi($leixing='zhifu',$openid='',$template_id='',$n='',$form_id='',$url='',$color=''){
		
    	if(empty($openid) || !is_array($n) || empty($template_id)){
    		return false;
    	}
//		if($leixing=='zhifu'){
//  		$data['prepay_id']=$form_id;
//		}else{
//  		$data['form_id']=$form_id;
//		} 	
		$data['form_id']=$form_id;
    	$data['touser']=$openid;
    	$data['template_id']=$template_id;	
    	$data['page']=$url;
    	$data['color']=$color;
    	$data['data']=$n;
    	$url="https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=".$this->AccessToken();
    	$data=jsonFormat($data);
    	$shu=post($url,$data);  
    	if( $shu['errmsg']=='OK'){
       	  return true;
       }
       return false;
    }
	
}
?>