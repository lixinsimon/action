<?php
Han('curl');
class weixin{
	private $peizhi;
    private $danyuan;
    public function __construct(){
        global $_W;
        $this->danyuan = $_W['danyuan'];
        $this->peizhi=$this->quGongZhongHao();       
    } 	
	public function quGongZhongHao($id='',$ziduan='*'){	   
	    $id=empty($id)?$this->danyuan:$id;	
	    $dy=Qu('he_danyuan',array('id'=> $id),$ziduan);	   
		return $dy;
	}
	public function quSHA1($token, $timestamp, $nonce, $encrypt_msg){
		//排序
		try {
			$array = array($encrypt_msg, $token, $timestamp, $nonce);
			sort($array, SORT_STRING);
			$str = implode($array);
			return array(sha1($str),true);
		} catch (Exception $e) {			
			return array('sha加密生成签名失败',false);
		}
	}
	public function JieRuYanZheng($shu){
		$gzh=$this->peizhi;
		$jr=$this->quSHA1($gzh['token'],$shu['timestamp'],$shu['nonce'],'');
		if($jr[0]==$shu['signature']){	
			Gai('he_danyuan',array('yanzheng'=>1),array('id'=>$gzh['id']));	
			return $shu['echostr'];
		}
		return false;
		
	}
	public function quCode($userinfo=false){
		global $_W;
		$gongzhonghao=$this->peizhi;
		$scope='snsapi_base';		
		if($userinfo){
			$scope='snsapi_userinfo';
		}
		$url="https://open.weixin.qq.com/connect/oauth2/authorize?";		
		$url.="appid=".$gongzhonghao['appid']."&redirect_uri=".urlEncode($_W['url'])."&response_type=code&scope=".$scope."#wechat_redirect ";
	    TiaoZhuan($url);
	    return true;
	}
	public function quToken($code){		
		$gongzhonghao=$this->peizhi;		
		$url="https://api.weixin.qq.com/sns/oauth2/access_token?";
		$url.="appid=".$gongzhonghao['appid']."&secret=".$gongzhonghao['appsecret']."&code=".$code."&grant_type=authorization_code";		
		Han('curl');
		$token=get($url);		
        $openid=$this->quOpenId($token);
	    return $openid;
	}
	public function JianChaGuanZhu($openid,$chongxing=false){
		
			if(empty($openid)){
				return false;
			}
			
			$hy=Qu('he_huiyuan',array('openid'=>$openid),'guanzhu');
			if($hy['guanzhu']==1){
				return $hy;
			}
		
			Han('curl');
	
			
			$guanzhu=get('https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$this->AccessToken($chongxing).'&openid='.$openid.'&lang=zh_CN');	
			ChaRu('test',array('neirong'=>ShuZu_Zhuan_ZiFuChuan($guanzhu)));
			if($guanzhu['subscribe']==1){
				Gai('he_huiyuan',array('guanzhu'=>$guanzhu['subscribe']),array('openid'=>$openid));	 
			}elseif($guanzhu['subscribe']==0){
				
			}else{
				return false;
			}
			$hy['guanzhu']=$guanzhu['subscribe'];
			
			return $hy;
			
	}
	
	
	
	public function quOpenId($token){
		global $_W;	
		$url='https://api.weixin.qq.com/sns/userinfo?access_token='.$token['access_token'].'&openid='.$token['openid'].'&lang=zh_CN';		
		Han('curl');
		$huiyuan=get($url);			
		if(empty($huiyuan['nickname']) && empty($huiyuan['sex'])){
			$this->quCode(true);
		}		
		$guanzhu=get('https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$this->AccessToken().'&openid='.$token['openid'].'&lang=zh_CN');		   
	
		$hy=array(
		     'danyuan'=>$_W['danyuan'],
		     'openid'=>$huiyuan['openid'],
		     'nicheng'=>$huiyuan['nickname'],		     
		     'xingbie'=>empty($huiyuan['sex'])?'女':'男',
		     'chengshi'=>$huiyuan['city']?$huiyuan['city'].'市':'',
		     'shengfen'=>$huiyuan['province'],
		     'ip'=>GetIp(),		    
		     'zhuangtai'=>1,		     
		     'touxiang'=>$huiyuan['headimgurl'],
		     'unionid'=>$huiyuan['unionid']
		);		
		if($guanzhu['subscribe']){
			$hy['guanzhu']=1;
		}
		$c=Qu('he_huiyuan',array('openid'=>$hy['openid'],'danyuan'=>$_W['danyuan']),'id,zhanghao,guanzhu,fuji_id,nicheng');			
		if($c){
			$fu=Qu('he_huiyuan',array('id'=>$c['fuji_id'],'danyuan'=>$_W['danyuan']),'id,openid,guanzhu,nicheng');
			Gai('he_huiyuan',array('guanzhu'=>$hy['guanzhu']),array('id'=>$c['id']));
			$id=$c['id'];
		}else{
			$hy['shijian']=time();
			if($_W['tui']){
				$fu=Qu('he_huiyuan',array('id'=>$_W['tui'],'danyuan'=>$_W['danyuan']),'id,openid,guanzhu,nicheng');
                if($fu){
                   $hy['fuji_id']=$_W['tui'];                                        	
                }
			}				
			ChaRu('he_huiyuan',$hy);
			
			$id=$hy['id']=ChaRuId();
			
			$schy=array('danyuan'=>$_W['danyuan'],'hyid'=>$id,'huiyuanshijian'=>SHIJIAN);		
			ChaRu('zw_shangcheng_huiyuan',$schy); 
			
			
			if(!empty($hy['fuji_id'])){					
				$mo=empty($_W['mo'])?'zw_shangcheng':$_W['mo'];		
				MX('api',$mo)->HaiBaoTongZhi($hy,$fu); 
			}
		}		
		session_start();
		$ip=GetIp();
		$time=time();
		$_SESSION['id']=$id;
		$_SESSION['danyuan']=$_W['danyuan'];
		$_SESSION['xingming']=$c['xingming'];
		$_SESSION['nicheng']=$hy['nicheng'];
		$_SESSION['touxiang']=$hy['touxiang'];
		$_SESSION['zhanghao']=$c['zhanghao'];
		
		$_SESSION['openid']=$hy['openid'];		
		$_SESSION['ip']=$ip;
		$_SESSION['shijian']=$time;
		$_SESSION['kouling']=md5($_SESSION['id'].$_SESSION['danyuan']);      
		$url=$_W['url'].'&t='.$id;
		$denglujilu=array(
			        'danyuan'=>$_W['danyuan'],
			        'huiyuan'=>$id,
			        'shijian'=>$time,
			        'ip'=>$ip,
			        'zongduan'=>$_W['zhongduan'],
			        'xitong'=>$_W['os'],
			        'url'=>$_W['url'],
			        'openid'=>$token['openid']		        
			    );
	    ChaRu('he_denglu_jilu',$denglujilu);
	    
	  
		TiaoZhuan($url);exit;	
		return 	$hy['openid'];	
	}
	public function AccessToken($chongxing=false){			
		$pz=$this->peizhi;
		
		if(empty($pz)){
			return false;
		}
		 // jsapi_ticket 应该全局存储与更新，以下代码以写入到文件中做示例
	    han('wenjian');
	    han('curl');	    
	    $file=$this->danyuan.'_WeiXin_token.json';
	    $data=file_read($file);
	    if($data){
	    	$data=json_decode($data);	
	    	$data=(array)$data;
	    }else{
	    	$data=array();
	    }	  	
	    if ($data['expire_time']< SHIJIAN || empty($data) || $chongxing) {
	    	$url='https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$pz['appid'].'&secret='.$pz['appsecret'];
		    $AccessToken=get($url);			   
		    $access_token=$AccessToken['access_token'];	
	    	 if($access_token){
		        $data['expire_time'] =SHIJIAN + 1000;	  
		        $data['access_token'] = $access_token;	 
		        file_write($file,json_encode($data));
		    }else{
		    	XiaoXi($AccessToken['errmsg']);
		    }
	    	
	    }else {
	        $access_token = $data['access_token'];
	    }		   	
	   return $access_token;
	}
	public function quCaiDan(){
		$url='https://api.weixin.qq.com/cgi-bin/menu/get?access_token='.$this->AccessToken();		
		$cd=get($url);  		
		return $cd['menu']['button'];		
	}
	public function JieShouXinXi($shu){				
        $tw=Qu('he_huifu','danyuan='.$this->danyuan.' and ci ="'.$shu['Content'].'"'); 
        if(empty($tw)){
        	$x=Qu('he_huifu_xitong',array('danyuan'=>$this->danyuan),'moren');
        	if($x){
        	   $shu['Content']=$x['moren'];
        	   $tw=Qu('he_huifu','danyuan='.$this->danyuan.' and ci ="'.$shu['Content'].'"'); 
        	}       	
        }         
        if($tw){
           $s=$this->BeiDongHuiFu($tw,$shu);          
        }
		return true;
	}
	public function BeiDongHuiFu($shu,$js){
		global $_W;			
        if($shu['leixing']=='wenzi'){        	      
           $this-> HFWenZi($shu['neirong'],$js);     
        }elseif($shu['mokuai']=='jichu_tuwen'){                  	
	    	$wz=ChaQuan('select * from '.BM('he_wenzhang').' where danyuan='.$this->danyuan.' and id in('.$shu['neirong'].')');

	    	if(!is_array($wz)){
	    	     return false;
	    	}         	 
	    	foreach($wz as $k=>$z){	    	  
	            $wz[$k]['tu']=JueDuiUrl($z['suoluetu']);
	            $wz[$k]['url']=$z['zhijielianjie'];
	            if(empty($z['zhijielianjie'])){
	                $wz[$k]['url']=UA('xinwen/xinwen-xq',array('id'=>$z['id']));
	            }                  
    	    }           
    	    $this->HFTuWen($wz,$js);        	
        }else{
        	$L=explode('|',$shu['mokuai']);           
        	if($L){
        		$shu['m']=$L;         		       
        		MX($L[1],$L[0])->$L[2]($shu,$js);
        	}
        	
        } 
       return true;
	}
    public function HFWenZi($neirong,$js){
    	if(empty($neirong) || empty($js)){
            return false;
    	}
    	$s=array();
		$s['FromUserName']=$js['ToUserName'];
		$s['ToUserName']=$js['FromUserName'];
		$s['CreateTime']=time();
		$s['MsgType']='text';
        $s['Content']=htmlspecialchars_decode($neirong); 
        echo (ShuZu_XML($s));
        return true; 
    }
    public function HFTuWen($shu,$js){
        $s=array();
		$s['FromUserName']=$js['ToUserName'];
		$s['ToUserName']=$js['FromUserName'];
		$s['CreateTime']=time();       
    	$s['MsgType']='news';
    	$s['ArticleCount']=1;  
    	$s['ArticleCount']=count($shu);
    	foreach($shu as $z){
    	   	$a['item']['Title']=$z['biaoti'];
            $a['item']['Description']=$z['jianjie'];
            $a['item']['PicUrl']=JueDuiUrl($z['tu']);
            $a['item']['Url']=$z['url'];            
            $s['Articles'][]=$a;           
    	}    
    	echo (ShuZu_XML($s));
    	return true;
    }
    public function HFTu($js){
    	$s=array();
		$s['FromUserName']=$js['ToUserName'];
		$s['ToUserName']=$js['FromUserName'];
		$s['CreateTime']=time();
		$s['MsgType']='image';
        $s['Image']['MediaId']=$js['MediaId'];        
        echo (ShuZu_XML($s));
        return true; 
    }
	public function ChaRu_Gai($shu){
		  global $_W;
		  $s=array();
          $s['danyuan']=$this->danyuan;         
          if(empty($shu['guanjianci']) || empty($shu['lei']) || empty($shu['fangfa'])){
          	return false;
          }
          $s['ming']=$shu['guanjianci'];
          $s['ci']=$shu['guanjianci'];
          //模块|类|方法|标示号(id) 
          $s['mokuai']=$_W['mo'].'|'.$shu['lei'].'|'.$shu['fangfa'].'|'.$shu['id'];
          $s['leixing']='tuwen';
          if($shu['leixing']){
               $s['leixing']=$shu['leixing'];
          }
         
          $s['zhuangtai']=1;
          $c=QU('he_huifu',array('mokuai'=>$s['mokuai']),'id');
          if($c){
             $id=$c['id'];
             unset($s['mokuai']);
             Gai('he_huifu',$s,array('id'=>$id));
          }else{
          	$s['shijian']=time();          
          	ChaRu('he_huifu',$s);
          	$id=ChaRuId();
          }
          return $id;
	}
	public function ShanChu($tianjian){
		if(empty($tianjian)){
			return false;
		}
        ShanChu('he_huifu',array('mokuai'=>$tianjian));
        return true;
	}
	public function jiaLinShiSuCai($shucai='',$leixing='image'){
		global $_W;
       $url='https://api.weixin.qq.com/cgi-bin/media/upload?access_token='.$this->AccessToken().'&type='.$leixing;
       if(strstr($shucai,$_W['yuming'])){
       	 $shucai=str_replace($_W['yuming'],GENMULU,$shucai);
       }      
        $data=array('file1'=>'@'.$shucai);     
        $ch  = curl_init();
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER , true);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST , false);
	    curl_setopt($ch, CURLOPT_POST, 1);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	    $res  = curl_exec($ch);	  
	    $curlStatus = curl_getinfo($ch);
	    curl_close($ch);
	    $res=json_decode($res);	  
        return $res->media_id;
	}

	public function KeFuFaSong($openid='',$neirong='',$leixing='text'){
		if(empty($openid) || empty($neirong)){
			return false;
		}
		$s=array('touser'=>$openid,'msgtype'=>$leixing);
		if($leixing=='image'){
           $s['msgtype']  ='image'; 
           $s['image']['media_id']  =$this->jiaLinShiSuCai($neirong);   
		}elseif($leixing=='news' && is_array($neirong)){
			 $s['msgtype']  ='news';
			 $n=array(); 
			 if(empty($neirong[0])){
                $nr=array($neirong);
			 }else{
			 	$nr=$neirong;
			 }			
			 foreach ($nr as $k => $v) {
			 	 $n[$k]['title']=$v['biaoti'];
			 	 $n[$k]['description']=$v['miaoshu'];
			 	 $n[$k]['url']=$v['url'];
			 	 $n[$k]['picurl']=JueDuiUrl($v['tu']);			 	
			 }
			$s['news']['articles']= $n;          
		}else{
		   $s['msgtype']  ='text';
		   $s["text"]['content'] = $neirong;
		}
       
        $data=jsonFormat($s);       
        $url='https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token='.$this->AccessToken();
       
        
        $shu=post($url,$data);     
  
       if( $shu['errmsg']=='OK'){
       	  return true;
       }
       return false;
	}
    public function MuBanXiaoXi($openid,$template_id,$n,$url){
    	if(empty($openid) || !is_array($n) || empty($template_id)){
    		return false;
    	}    	
    	$data['touser']=$openid;
    	$data['template_id']=$template_id;	
    	$data['url']=$url; 
    	$data['data']=$n;   	
    	$url='https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$this->AccessToken();
    	$data=jsonFormat($data);    	
    	
    	$shu=post($url,$data);     	

    	if($shu['errmsg']=='OK'){
       	  return true;
       	}
       return false;
    }
	/*	 
	 * @ 二维码类型$changduan：QR_SCENE为临时的整型参数值，QR_STR_SCENE为临时的字符串参数值，QR_LIMIT_SCENE为永久的整型参数值，QR_LIMIT_STR_SCENE为永久的字符串参数值 
	 * @ 生成二维码
	 * */
	public function ErWeiMa($hyid='',$shu='',$changduan='QR_LIMIT_STR_SCENE',$changjiag=1,$youxiaoqi=''){
	    global $_W; 
	    $MULU=GENMULU.'/huancun/erweima';	   
	    if(!is_dir($MULU)){	    	
	    	mkdir($MULU,0777);
	    	chmod($MULU,0777);	
	    } 
	    $QR=$MULU.'/wx_'.$hyid.'.png';     
		if(file_exists($QR)){            	
			return $QR;	
		}	      
		if(empty($shu)){
    		$shu=$_W['mo'].'|api|TuiJian|'.$_W['huiyuan']['id'];
        }    	   	
    	$data['action_name']='QR_LIMIT_STR_SCENE';
    	if($youxiaoqi){
    		$data['expire_seconds']=$youxiaoqi;
    	}    	
    	$data['action_info']['scene']['scene_str']=$shu;  
    	$data=jsonFormat($data);      	
    	$url='https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token='.$this->AccessToken();    	 	
    	$s=post($url,$data);     
    	if($s['ticket']){   		
   	        $content = file_get_contents('https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket='.$s['ticket']);
            if(file_put_contents($QR, $content)){
            	return $QR;
            };
          
	    }
        return false;		
	}

	public function ZhuCe($openid){
		global $_W;						
		if(empty($openid)){			
			return false;
		}
		Han('curl');
		$url='https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$this->AccessToken().'&openid='.$openid.'&lang=zh_CN';		
		$huiyuan=get($url);		   
		if(empty($huiyuan['nickname']) && empty($huiyuan['sex'])){
			  return false;
		}		
		$hy=array(
		     'danyuan'=>$_W['danyuan'],
		     'openid'=>$huiyuan['openid'],
		     'nicheng'=>$huiyuan['nickname'],		     
		     'xingbie'=>empty($huiyuan['sex'])?'女':'男',
		     'chengshi'=>$huiyuan['city'],
		     'shengfen'=>$huiyuan['province'],		        
		     'zhuangtai'=>1,		     
		     'touxiang'=>$huiyuan['headimgurl'],
		     'unionid'=>$huiyuan['unionid'],
		     'guanzhu'=>$huiyuan['subscribe'],
		    );

		$c=MX('huiyuan','he')->qu_huiyuan($hy['openid']);			
		if($c){			
			Gai('he_huiyuan',$hy,array('id'=>$c['id']));		
		}else{
			$hy['shijian']=SHIJIAN;
			$hy['ip']=GetIp();	
			if($_W['tui']){
				$fu=MX('huiyuan','he')->qu_huiyuan($_W['tui']);
						
                if($fu){
                   $hy['fuji_id']=$fu['id'];                                        	
                }
			}		 					
			ChaRu('he_huiyuan',$hy);
			$id=$hy['id']=ChaRuId();
			
			$schy=array('danyuan'=>$_W['danyuan'],'hyid'=>$id,'huiyuanshijian'=>SHIJIAN);		
			ChaRu('zw_shangcheng_huiyuan',$schy); 
			
			if(!empty($hy['fuji_id'])){			
		       MX('api',$_W['mo'])->HaiBaoTongZhi($hy,$fu); 
		    }
		}		
		
	}
	
	private function getJsApiTicket() {
	    // jsapi_ticket 应该全局存储与更新，以下代码以写入到文件中做示例
	    han('wenjian');
	    han('curl');	    
	    $file=$this->danyuan.'_jsapi_ticket.json';
	    $data=json_decode(file_read($file));		    
	    if ($data->expire_time < SHIJIAN || empty($data)) {
	      $accessToken = $this->AccessToken();
	      $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=$accessToken";
	      $res = get($url);	    
	      $ticket = $res['ticket'];
	      if ($ticket) {	      	
	        $data->expire_time =SHIJIAN + 7000;	       
	        $data->jsapi_ticket = $ticket;	       
	        file_write($file,json_encode($data));
	      }
	    } else {
	        $ticket = $data->jsapi_ticket;
	    }	 
	    return $ticket;
	  }
	
	    //获取分享签名包
	 public function FenXiang($url) {	 
	    $jsapiTicket = $this->getJsApiTicket();	
	    // 注意 URL 一定要动态获取，不能 hardcode.
//	    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
//	    $url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	   
	    $timestamp =SHIJIAN.'';
	    $nonceStr =random(8).'';	
	    // 这里参数的顺序要按照 key 值 ASCII 码升序排序
	    $string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";	
	    $signature = sha1($string);	    
	    $signPackage = array(
	      "appId"     => $this->peizhi['appid'],
	      "nonceStr"  => $nonceStr,
	      "timestamp" => $timestamp,
	      "url"       => $url,
	      "signature" => $signature,
	      "rawString" => $string
	    );	   
	    return $signPackage; 
	  }
	
}
?>