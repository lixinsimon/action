<?php
class weixin_shanghu{
	private $peizhi;
    private $shanghu;
    public function __construct(){
        global $_W;
        $this->shanghu =$_W['xiaozhan'];       
        $this->peizhi=$this->PeiZhi();       
    } 	
	public function PeiZhi($shanghu='',$ziduan='*'){
    	if($shanghu){
    		$this->shanghu=$shanghu;
    	}    	
    	$sz=Cha("select ".$ziduan." from ".BM('zw_shanghu_peizhi')." where shanghu=".$this->shanghu);
    	if($sz['weixin']){
    		 $weixin=ZiFuChuan_Zhuan_ShuZu($sz['weixin']); 
    	}       	   	
    	return $weixin;
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
			Gai('zw_shanghu_peizhi',array('yanzheng'=>1),array('shanghu'=>$this->shanghu));	
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
	public function quOpenId($token){
		global $_W;	
		if(empty($token['openid'])){
			XiaoXi('登录失败',UA('denglu'));exit;
		}	
		$url='https://api.weixin.qq.com/sns/userinfo?access_token='.$token['access_token'].'&openid='.$token['openid'].'&lang=zh_CN';		
		Han('curl');
		$huiyuan=get($url);			
		if(empty($huiyuan['nickname']) && empty($huiyuan['sex'])){
			$this->quCode(true);
		}		   
		$hy=array(
		     'danyuan'=>$_W['danyuan'],		    
		     'nicheng'=>$huiyuan['nickname'],		     
		     'xingbie'=>empty($huiyuan['sex'])?'女':'男',
		     'chengshi'=>$huiyuan['city']?$huiyuan['city'].'市':'',
		     'shengfen'=>$huiyuan['province'],
		     'ip'=>GetIp(),		    
		     'zhuangtai'=>1,		     
		     'touxiang'=>$huiyuan['headimgurl'],
		     'unionid'=>$huiyuan['unionid']
		    );	
		$c=MX('huiyuan','he')->qu_huiyuan($huiyuan['openid']);			
		if($c){
			$fu=MX('huiyuan','he')->qu_huiyuan($c['fuji_id']);				
			$id=$c['id'];
		}else{
			$hy['shijian']=SHIJIAN;
			if($_W['tui']){
				$fu=MX('huiyuan','he')->qu_huiyuan($c['fuji_id']);			
                if($fu){
                   $hy['fuji_id']=$_W['tui'];                                        	
                }
			}				
			ChaRu('he_huiyuan',$hy);
			$id=$hy['id']=ChaRuId();
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
		
		$_SESSION['openid']=$huiyuan['openid'];		
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
		TiaoZhuan($url);			
		return 	$hy['openid'];	
	}
	
	public function AccessToken(){		
		$token=$this->peizhi['access_token'];		
		if($this->peizhi['expires_in']<time() || empty($token)){			
			$url='https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$this->peizhi['appid'].'&secret='.$this->peizhi['appsecret'];
			Han('curl');
		    $AccessToken=get($url);			   
		    $token=$AccessToken['access_token'];		    
		    if($token){
		       $expires_in=$AccessToken['expires_in']+time();
		       $shu=array('access_token'=>$token,'expires_in'=>$expires_in);
		       Gai('zw_shanghu_peizhi',$shu,array('shanghu'=>$this->shanghu));
		    }else{
		    	XiaoXi($AccessToken['errmsg']);
		    }
	   } 	
	   return $token;
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
    	if( $shu['errmsg']=='OK'){
       	  return true;
       }
       return false;
    }
	/*	 
	 * @ 二维码类型$changduan：QR_SCENE为临时的整型参数值，QR_STR_SCENE为临时的字符串参数值，QR_LIMIT_SCENE为永久的整型参数值，QR_LIMIT_STR_SCENE为永久的字符串参数值 
	 * @ 生成二维码
	 * */
	public function ErWeiMa($shu,$changduan='QR_LIMIT_STR_SCENE',$changjiag=1,$youxiaoqi=''){
		if(!is_array($shu)){
    		return false;
        }    	   	
    	$data['action_name']='QR_LIMIT_STR_SCENE';
    	if($youxiaoqi){
    		$data['expire_seconds']=$youxiaoqi;
    	}    	
    	$data['action_info']['scene']=$shu;    	
    	$url='https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token='.$this->AccessToken();
    	$data=jsonFormat($data);     	
    	$s=post($url,$data);      	
    	if($s['ticket']){
       	   return $s;
        }
		
        return false;		
	}
	
	public function ZhuCe($openid){
		global $_W;				
		if(empty($openid)){			
			return false;
		}
				
		$url='https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$this->AccessToken().'&openid='.$openid.'&lang=zh_CN';	
		Han('curl');
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
		     'ip'=>GetIp(),		    
		     'zhuangtai'=>1,		     
		     'touxiang'=>$huiyuan['headimgurl'],
		     'unionid'=>$huiyuan['unionid'],
		     'guanzhu'=>$huiyuan['subscribe'],
		    );
		
		$c=Qu('he_huiyuan',array('openid'=>$hy['openid'],'danyuan'=>$_W['danyuan']),'id,zhanghao,guanzhu,fuji_id,nicheng');					
		ChaRu('test',array('neirong'=>ShuZu_Zhuan_ZiFuChuan($c)));
		if($c){
			//$fu=Qu('he_huiyuan',array('id'=>$c['fuji_id'],'danyuan'=>$_W['danyuan']),'id,openid,guanzhu,nicheng');
			Gai('he_huiyuan',$hy,array('id'=>$c['id']));		
		}else{
			$hy['shijian']=time();
			if($_W['tui']){
				$fu=Qu('he_huiyuan',array('id'=>$_W['tui'],'danyuan'=>$_W['danyuan']),'id,openid,guanzhu,nicheng');
                if($fu){
                   $hy['fuji_id']=$fu['id'];                                        	
                }
			}									
			ChaRu('he_huiyuan',$hy);
			$id=$hy['id']=ChaRuId();
			if(!empty($hy['fuji_id'])){			
		       MX('api','zw_shangcheng')->HaiBaoTongZhi($hy,$fu); 
		    }
		}		
		
	}
	
}
?>