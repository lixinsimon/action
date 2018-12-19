<?php
/**
 * [商城开源系统] Copyright (c) 2014 ZhiWi.CN
 *  商城群QQ：628361862  进群下载更新包 交流技术   http://www.ZhiWi.cn/.
 */
lei('image.handle');
class zw_shangcheng_api{	
	public function HaiBao($id='',$TJ='',$cao=''){
		global $_W;         
		$ih = new ImageHandle();		
        $tianjian=array('danyuan'=>$_W['danyuan']);
        if(empty($id)){
           return false;
        }if(intval($id)){
            $tianjian['id']=$id;
        }else{
           $tianjian['openid']=$id;
        }

        $hy=Qu('he_huiyuan',$tianjian);
        if(empty($hy)){
        	return false;
        }
			$l="huancun/haibao/". $_W['danyuan'].$_W['zhongduan'] . '_' . $hy['id'] . '.jpeg';
	    $lujing = GENMULU .'/'.$l;
	    $tu = $_W['yuming']. $l;				
			
        if (!file_exists($lujing)) {
            if($TJ){
                $TJ='and '.$TJ;
            }
            $haibao1 = Cha('select bg,data from ims_zw_shangcheng_haibao where status = 1 and  danyuan=' . $_W['danyuan'] . $TJ.' order by moren DESC ');
            if (empty($haibao1)) {
                json('请先创建一个海报模板',0);
               
            }          
            $haibao1['data'] = json_decode(htmlspecialchars_decode($haibao1['data']), true);           
            $beijing = GENMULU .'/gongyong/shangchuan/'. $haibao1['bg'];   
									 
				 
            if (empty($haibao1['bg']) && !file_exists($beijing)) {
                json('没找到海报背景图',0);
            }             
            if($hy['openid'] && $cao=='guanzhu'){ 		
				       $erweima=MX('weixin','he')->ErWeiMa($hy['id'],$_W['mo'].'|api|TuiJian|'.$hy['id']);				
            }elseif($cao=='xiazhai'){	
						 
            	$url = $_W['yuming'] . 'app/index.php?d=' . $_W['danyuan'] .'&k=denglu&x=xiazhai&t=' . $hy['id'];						
            	$erweima = MX('erweima', 'he')->ShengCheng($url);
            	$erweima = GENMULU . '/' . $erweima;    
            } else{
							$url = $_W['yuming'] . 'app/index.php?d=' . $_W['danyuan'] . '&m='.$_W['mo'].'&k=index&t=' . $hy['id'];
							$erweima = MX('erweima', 'he')->ShengCheng($url);
							$erweima = GENMULU . '/' . $erweima; 
						}           
            if(!file_exists($erweima)){
            	json('二维码生成失败',0);
            }
            $ih->SetTmpDir(GENMULU . "/huancun/haibao/"); //图片生成目录 
            $Font=array(
               "color" => array(255, 255, 255), 
               "size" => 20, 
               "family" => GENMULU . "/gongyong/fonts/simkai.ttf"
               ) ;     
            $ih->SetFont($Font);        
            $ih->heChengHaiBao($beijing,$hy, $erweima, $haibao1['data'],$lujing);           
        }      
        return  $tu;
	}
	public function XiaoChengXuHaiBao($id='',$TJ=''){
		global $_W;         
		$ih = new ImageHandle();		
        $tianjian=array('danyuan'=>$_W['danyuan']);
        if(empty($id)){
           return false;
        }if(intval($id)){
            $tianjian['id']=$id;
        }else{
           $tianjian['xcx_openid']=$id;
        }

        $hy=Qu('he_huiyuan',$tianjian);
        if(empty($hy)){
        	return false;
        }
	    $lujing = GENMULU . "/huancun/haibao/xcx" . $_W['danyuan'] . '_' . $hy['id'] . '.jpeg';
	    $tu = $_W['yuming']. "/huancun/haibao/xcx" . $_W['danyuan'] . '_' . $hy['id'] . '.jpeg';	    
        if (!file_exists($lujing)) {
            if($TJ){
                $TJ='and '.$TJ;
            }
            $haibao1 = Cha('select bg,data from ims_zw_shangcheng_haibao where status = 1 and  danyuan=' . $_W['danyuan'] . $TJ.' order by moren DESC ');
            if (empty($haibao1)) {
                json('请先创建一个海报模板');
                die;
            }          
            $haibao1['data'] = json_decode(htmlspecialchars_decode($haibao1['data']), true);
            $beijing = GENMULU . '/gongyong/shangchuan/' . $haibao1['bg'];
            if (empty($haibao1['bg']) && !file_exists($beijing)) {
                $beijing = GENMULU . "/gongyong/images/moban.jpg";
            }                                   
            $erweima = MX('xiaochengxu','he')->ErWeiMa($_W['huiyuan']['id']);
            $erweima = GENMULU . '/' . $erweima;    
            $ih->SetTmpDir(GENMULU . "/huancun/haibao/"); //图片生成目录 
            $Font=array(
               "color" => array(255, 255, 255), 
               "size" => 20, 
               "family" => GENMULU . "/gongyong/fonts/simkai.ttf"
               ) ;     
            $ih->SetFont($Font);        
            $ih->heChengHaiBao($beijing,$hy, $erweima, $haibao1['data'],$lujing);           
        }
        return  $tu;
	}
    public function quHaiBao($shu,$js){
        global $_W;      
        $TJ=' and guanjianci="'.$shu['ci'].'"';
        $haibao = Cha('select dengdaitishi,kaifang,bukaifangtishi from '.BM('zw_shangcheng_haibao').' where status = 1 and  danyuan=' . $_W['danyuan'] . $TJ.' order by moren DESC ');
       
        $hy=Cha('select hy.fenxiaozhuangtai from '.BM('he_huiyuan').' h left join '.BM('zw_shangcheng_huiyuan').' hy on h.id=hy.hyid where h.danyuan='.$_W['danyuan'].' and h.openid="'.$js['FromUserName'].'"');
       
        
        if($haibao['kaifang'] || $hy['fenxiaozhuangtai']==1){
           $dengdaitisi=$haibao['dengdaitishi'];
        }else{
           $dengdaitisi=$haibao['bukaifangtishi'];
        }
        if(empty($dengdaitisi)){
            $dengdaitisi='正在拼命生成海报二维码..';
        }
        MX('weixin','he')->HFWenZi($dengdaitisi,$js);
        if($haibao['kaifang'] || $hy['fenxiaozhuangtai']==1){
            $tu=$this->HaiBao($js['FromUserName']);          
            MX('weixin','he')->KeFuFaSong($js['FromUserName'],$tu,'image');          
        }       
        return  true;
     }
     public function HaiBaoTongZhi($ziji,$fu){
        global $_W;       
        $hb=Qu('zw_shangcheng_haibao','danyuan='.$_W['danyuan'].' and status=1 order by moren DESC');
        $hb['tuisong']=ZiFuChuan_Zhuan_ShuZu($hb['tuisong']);       
        $hb['tongzhi']=ZiFuChuan_Zhuan_ShuZu($hb['tongzhi']);
        $hb['song']=ZiFuChuan_Zhuan_ShuZu($hb['song']);        
       	$_W['shezhi']=MX()->quSheZhi();	 
        	   
        if(empty($hb['tuisong']['url'])){
    		$hb['tuisong']['url']=UAK('index');
    	}	   
    	$TX['shijian']=Date('Y-m-d H:i:s',SHIJIAN);
	
//		if($_W['shezhi']['tongzhi']['huiyuanshengji'] && $ziji['openid'] && $hb['tuisong']){
//			$N['first']['value']=$hb['tuisong'];
//			$N['keyword1']['value']=$ziji['id'];
//			$N['keyword2']['value']=$TX['shijian'];
//			MX('weixin','he')->MuBanXiaoXi($ziji['openid'],$_W['shezhi']['tongzhi']['huiyuanshengji'],$N,$hb['tuisong']['url']);	
//		}else
		
		if($hb['tuisong']['biaoti']&& $ziji['openid'] && $hb['tuisong']){
			MX('weixin','he')->KeFuFaSong($ziji['openid'],$hb['tuisong'],'news');        
        } 
          
      
        if($hb['tongzhi']['tuijianren'] && $fu['openid'] && $fu['guanzhu']){        	
            $tuijianren = preg_replace('/\[jifen\]/', $hb['song']['jifen'], $hb['tongzhi']['tuijianren']);
            $tuijianren = preg_replace('/\[jin_e\]/', $hb['song']['jin_e'], $tuijianren);
            $tuijianren = preg_replace('/\[nicheng\]/',$ziji['nicheng'], $tuijianren); 
         
            if($hb['song']['jifen']>0){
                MX('huiyuan','he')->gai_jifen($fu['id'],$hb['song']['jifen'],$tuijianren);                 
            }
          
            if($_W['shezhi']['tongzhi']['huiyuanshengji'] && $fu['openid']){
				$N['first']['value']= $tuijianren;
				$N['keyword1']['value']=$ziji['id'];
				$N['keyword2']['value']=$TX['shijian'];
				
				$url=UAK('fenxiao/wodetuandui');
				MX('weixin','he')->MuBanXiaoXi($fu['openid'],$_W['shezhi']['tongzhi']['huiyuanshengji'],$N,$url);	
			}else{
           	 	MX('weixin','he')->KeFuFaSong($fu['openid'],$tuijianren);
           	}
            
            $tj=$hb['tongzhi']['tuijianrenjiangliruzhangmiaoshu'];           
            if($tj && $hb['song']['jin_e']>0){
                  $tjm=preg_replace('/\[nicheng\]/',$ziji['nicheng'], $tj);
                  if($hb['song']['dakuanfangshi']=='weixin'){

                  }else{
                     MX('huiyuan','he')->gai_yu_e($fu['id'],$hb['song']['jin_e'],'推荐赠余额'); 
                  }
            }     
        }
      
        if($hb['tongzhi']['guanzhuzhe'] && $ziji['openid']){
             $guanzhuzhe = preg_replace('/\[jifen\]/', $hb['song']['jifen'], $hb['tongzhi']['guanzhuzhe']);
             $guanzhuzhe = preg_replace('/\[jin_e\]/', $hb['song']['jin_e'], $guanzhuzhe);
             $guanzhuzhe = preg_replace('/\[nicheng\]/',$fu['nicheng'], $guanzhuzhe);
             if($hb['song']['jifen']>0){
                MX('huiyuan','he')->gai_jifen($ziji['id'],$hb['song']['jifen'],$guanzhuzhe);               
            }
            
//          if($_W['shezhi']['tongzhi']['huiyuanshengji'] && $ziji['openid']){
//				$N['first']['value']= $guanzhuzhe;
//				$N['keyword1']['value']=$ziji['id'];
//				$N['keyword2']['value']=$TX['shijian'];
//				
//				$url=UAK('index');				
//				MX('weixin','he')->MuBanXiaoXi($ziji['openid'],$_W['shezhi']['tongzhi']['huiyuanshengji'],$N,$url);	
//			}else{
//          	MX('weixin','he')->KeFuFaSong($ziji['openid'],$guanzhuzhe);
//        	}
           
           
            $gz=$hb['tongzhi']['guanzhuzhejiangliruzhangmiaoshu'];
            if($gz && $hb['song']['jin_e']>0){
                  $gzm = preg_replace('/\[nicheng\]/',$fu['nicheng'],$gz);
                  if($hb['song']['dakuanfangshi']=='weixin'){

                  }else{
                     MX('huiyuan','he')->gai_yu_e($ziji['id'],$hb['song']['jin_e'],'关注赠余额'); 
                  }
             }
       
        }
       return true;
     }
	public function XiaDanTiXing($openid,$TX){
		global $_W;		
		if(empty($openid)|| empty($TX)){
			return false;
		}
		if($TX['jin_e']>0){
			$TX['jin_e']=$TX['jin_e'].'元';
		}
				
		if($_W['shezhi']['tongzhi']['tijiaodingdan']){
			$N['first']['value']='您有一单未付款';
			$N['keyword1']['value']=$TX['dianpu'];
			$N['keyword2']['value']=$TX['shijian'];
			$N['keyword3']['value']=$TX['shangpin_ming'];
			$N['keyword4']['value']=$TX['jin_e'];
			$N['remark']['value']='我要去付款';
			MX('weixin','he')->MuBanXiaoXi($openid,$_W['shezhi']['tongzhi']['tijiaodingdan'],$N,$TX['url']);	
		}else{
			$t="您的订单已提交成功\r
			店铺：{$TX['dianpu']}\r
			下单时间：{$TX['shijian']}\r
			商品：{$TX['shangpin_ming']}\r
			金额：{$TX['jin_e']}\r			
			<a href='{$TX['url']}'>我要付款</a>";
			MX('weixin','he')->KeFuFaSong($openid,$t);	
		}
		$n=$_W['huiyuan']['nicheng'];	

		//客服的接信的信息
		$tixing=$_W['shezhi']['jiaoyi']['tixing'];
		if(empty($tixing)){
				return;
		}
		if($_W['shezhi']['tongzhi']['tijiaodingdan']){
			$N['first']['value']='会员【'.$n.'】下单啦~~';
			$N['keyword1']['value']=$TX['dianpu'];
			$N['keyword2']['value']=$TX['shijian'];
			$N['keyword3']['value']=$TX['shangpin_ming'];
			$N['keyword4']['value']=$TX['jin_e'];
			$N['remark']['value']='';
			
			$Tx=ChaQuan('select id,nicheng,openid from '.BM('he_huiyuan').' where id in ('.$tixing.')');
			foreach($Tx as $T){	
				if($T['openid']){
					MX('weixin','he')->MuBanXiaoXi($T['openid'],$_W['shezhi']['tongzhi']['tijiaodingdan'],$N,'');	
				}
			}
			
		}else{
			$kf="【{$n}】下单啦~~\r
			店铺：{$TX['dianpu']}\r
			下时间：{$TX['shijian']}\r
			商品：{$TX['shangpin_ming']}\r
			金额：{$TX['jin_e']}\r	";			
			$this->KeFuDingDanTongzhi($kf);
		}
		
	}
	public function TuiKuanTiXing($TX){
		global $_W;	
		if(!is_array($TX)){
			return false;
		}	
		if($TX['zongjia']>0){
			$TX['zongjia']=$TX['zongjia'].'元';
		}				
		$hy=Qu('he_huiyuan',array('id'=>$TX['huiyuan']),'openid,nicheng');	
		if(empty($hy['openid'])){
			 return false;			
		}		
		if($_W['shezhi']['tongzhi']['tuikuanshenqing']){
			$N['first']['value']='您已申请退款，等待商家确认退款信息。';
			$N['orderProductPrice']['value']=$TX['zongjia'];
			$N['orderProductName']['value']=$TX['shangpin_ming'];
			$N['orderName']['value']=$TX['dingdanhao'];
			$N['remark']['value']='';
			MX('weixin','he')->MuBanXiaoXi($hy['openid'],$_W['shezhi']['tongzhi']['tuikuanshenqing'],$N,$TX['url']);	
		}else{
			$t="您已申请退款，等待商家确认退款信息。\r
			退款金额：{$TX['zongjia']}\r
			商品详情：{$TX['shangpin_ming']}\r
			订单编号：{$TX['dingdanhao']}\r
			<a href='{$TX['url']}'>查看详情</a>";
			MX('weixin','he')->KeFuFaSong($hy['openid'],$t);	
		}
		$n=$_W['huiyuan']['nicheng'];	

		//客服的接信的信息
		$tixing=$_W['shezhi']['jiaoyi']['tixing'];
		if(empty($tixing)){
				return;
		}
		if($_W['shezhi']['tongzhi']['tuikuanshenqing']){
			$N['first']['value']='会员【'.$n.'】申请退款，尽快去处理吧。';
			$N['orderProductPrice']['value']=$TX['zongjia'];
			$N['orderProductName']['value']=$TX['shangpin_ming'];
			$N['orderName']['value']=$TX['dingdanhao'];
			$N['remark']['value']='';
			$Tx=ChaQuan('select id,nicheng,openid from '.BM('he_huiyuan').' where id in ('.$tixing.')');
			foreach($Tx as $T){	
				if($T['openid']){
					MX('weixin','he')->MuBanXiaoXi($T['openid'],$_W['shezhi']['tongzhi']['tuikuanshenqing'],$N,'');	
				}
			}
		}else{
			$kf="会员【{$n}】申请退款，尽快去处理吧。\r
				退款金额：{$TX['zongjia']}\r
				商品详情：{$TX['shangpin_ming']}\r
				订单号：{$TX['dingdanhao']}\r";			
			$this->KeFuDingDanTongzhi($kf);
		}
	}
	public function TuiKuanChengTiXing($TX){
		global $_W;	
		if(!is_array($TX)){
			return false;
		}	
		if($TX['zongjia']>0){
			$TX['zongjia']=$TX['zongjia'].'元';
		}				
		$hy=Qu('he_huiyuan',array('id'=>$TX['huiyuan']),'openid,nicheng');	
		if(empty($hy['openid'])){
			 return false;			
		}		
		if($_W['shezhi']['tongzhi']['tuikuanchenggong']){
			$N['first']['value']='您的退款申请已受理，已成功为您退款';
			$N['orderProductPrice']['value']=$TX['zongjia'];
			$N['orderProductName']['value']=$TX['shangpin_ming'];
			$N['orderName']['value']=$TX['dingdanhao'];
			$N['remark']['value']='';
			MX('weixin','he')->MuBanXiaoXi($hy['openid'],$_W['shezhi']['tongzhi']['tuikuanchenggong'],$N,$TX['url']);	
		}else{
			$t="您的订单已经完成退款。\r
			退款金额：{$TX['zongjia']}\r
			商品详情：{$TX['shangpin_ming']}\r
			订单编号：{$TX['dingdanhao']}\r
			<a href='{$TX['url']}'>查看详情</a>";
			MX('weixin','he')->KeFuFaSong($hy['openid'],$t);	
		}
		$n=$hy['nicheng'];	

		//客服的接信的信息
		$tixing=$_W['shezhi']['jiaoyi']['tixing'];
		if(empty($tixing)){
				return;
		}
		if($_W['shezhi']['tongzhi']['tuikuanchenggong']){
			$N['first']['value']='会员【'.$n.'】的退款申请，已成功退款。';
			$N['orderProductPrice']['value']=$TX['zongjia'];
			$N['orderProductName']['value']=$TX['shangpin_ming'];
			$N['orderName']['value']=$TX['dingdanhao'];
			$N['remark']['value']='';
			$Tx=ChaQuan('select id,nicheng,openid from '.BM('he_huiyuan').' where id in ('.$tixing.')');
			foreach($Tx as $T){	
				if($T['openid']){
					MX('weixin','he')->MuBanXiaoXi($T['openid'],$_W['shezhi']['tongzhi']['tuikuanchenggong'],$N,'');	
				}
			}
		}else{
			$kf="会员【{$n}】的退款申请，已成功退款。\r
				退款金额：{$TX['zongjia']}\r
				商品详情：{$TX['shangpin_ming']}\r
				订单号：{$TX['dingdanhao']}\r";			
			$this->KeFuDingDanTongzhi($kf);
		}
	}
	public function PinTuanTiXing($TX){
		
	}
	
	public function JuJueTuiKuanTiXing($TX){
		global $_W;	
		if(!is_array($TX)){
			return false;
		}	
		if($TX['zongjia']>0){
			$TX['zongjia']=$TX['zongjia'].'元';
		}	
		$TX['shijian']=Date('Y-m-d H:i:s',SHIJIAN);					
		$hy=Qu('he_huiyuan',array('id'=>$TX['huiyuan']),'openid,nicheng');	
		if(empty($hy['openid'])){
			 return false;			
		}	
		$TX['url']=UAK('dingdan/dingdanxiangqing',array('id'=>$TX['dingdanhao']));	
		
		$jujuetuikuan=trim($_W['shezhi']['tongzhi']['jujuetuikuan']);	
		
		$ddsp=ChaQuan('select ming,shuliang from '.BM('zw_shangcheng_dingdan_shangpin').' where dingdanid='.$TX['id']);
		foreach($ddsp as $d){
			$ming.=$d['ming'].'x'.$d['shuliang'].'~';
			$shuliang+=$d['shuliang'];
		}
		
		if($jujuetuikuan){
			$N['first']['value']='';
			$N['keyword1']['value']=$ming;
			$N['keyword2']['value']=$shuliang;
			$N['keyword3']['value']=$TX['zongjia'];
			$N['keyword4']['value']='退款被驳回';		
			$N['remark']['value']='';
			MX('weixin','he')->MuBanXiaoXi($hy['openid'],$jujuetuikuan,$N,$TX['url']);	
		}
	}
	public function FuKuanTiXing($TX){
		global $_W;	
		if(!is_array($TX)){
			return false;
		}	
		if($TX['zongjia']>0){
			$TX['zongjia']=$TX['zongjia'].'元';
		}	
		$TX['shijian']=Date('Y-m-d H:i:s',$TX['shijian']);
		if($_W['shezhi']['tongzhi']['zhifu_shanghu']){
			$shanghu=ChaQuan('select id,dingdanhao,zongjia,shanghu,shouhuoren,shouhuodianhua  from '.BM('zw_shangcheng_dingdan').' where dingdanhao="'.$TX['dingdanhao'].'"');
			foreach($shanghu as $s){
				$s['shijian']=$TX['shijian'];
				$s['url']=UAK('index');				
				$this->ShangHuFuKuanTiXing($s);
			}
		}			
		$hy=Qu('he_huiyuan',array('id'=>$TX['huiyuan']),'openid,nicheng');	
		if(empty($hy['openid'])){
			 return false;			
		}	
		$TX['url']=UAK('dingdan/dingdanxiangqing',array('id'=>$TX['dingdanhao']));		
		if($_W['shezhi']['tongzhi']['zhifu']){
			$N['first']['value']='您已支付成功订单';
			$N['keyword1']['value']=$TX['dingdanhao'];
			$N['keyword2']['value']='待发货';
			$N['keyword3']['value']=$TX['shijian'];
			$N['keyword4']['value']=$_W['shezhi']['shezhi']['ming'];
			$N['keyword5']['value']=$TX['zongjia'];
			$N['remark']['value']='我尽快为您发货..';
			MX('weixin','he')->MuBanXiaoXi($hy['openid'],$_W['shezhi']['tongzhi']['zhifu'],$N,$TX['url']);	
		}else{			
			$t="您已支付成功订单\r
			订单：{$TX['dingdanhao']}\r			
			时间：{$TX['shijian']}\r
			商户：{$_W['shezhi']['shezhi']['ming']}\r
			金额：{$TX['zongjia']}\r			
			欢迎您的再次到来！<a href='{$TX['url']}'>查看</a>";		
			MX('weixin','he')->KeFuFaSong($hy['openid'],$t);	
		}
		$n=$hy['nicheng'];	
		//客服的接信的信息
		$tixing=$_W['shezhi']['jiaoyi']['tixing'];
		if(empty($tixing)){
				return;
		}
		if($_W['shezhi']['tongzhi']['zhifu']){
			$N['first']['value']='会员【'.$n.'】已付款~尽快去发货吧~';
			$N['keyword1']['value']=$TX['dingdanhao'];
			$N['keyword2']['value']='待发货';
			$N['keyword3']['value']=$TX['shijian'];
			$N['keyword4']['value']=$_W['shezhi']['shezhi']['ming'];
			$N['keyword5']['value']=$TX['zongjia'];
			$N['remark']['value']='快去发货吧';
			$Tx=ChaQuan('select id,nicheng,openid from '.BM('he_huiyuan').' where id in ('.$tixing.')');
			foreach($Tx as $T){	
				if($T['openid']){
					MX('weixin','he')->MuBanXiaoXi($T['openid'],$_W['shezhi']['tongzhi']['zhifu'],$N,'');	
				}
			}
		}else{	
		$kf="【{$n}】已付款~尽快去发货吧~\r
		       订单：{$TX['dingdanhao']}\r			
			时间：{$TX['shijian']}\r
			商户：{$_W['shezhi']['shezhi']['ming']}\r
			金额：{$TX['zongjia']}\r";			
			$this->KeFuDingDanTongzhi($kf);
		}
	}
	
	public function TiXianTiXing($TX){
		global $_W;	
		if(!is_array($TX)){
			return false;
		}		
		$TX['shijian']=Date('Y-m-d H:i:s',$TX['shijian']);
				
		$hy=Qu('he_huiyuan',array('id'=>$TX['huiyuan']),'openid,nicheng');	
		if(empty($hy['openid'])){
			 return false;			
		}	
		$TX['url']=UAK('fenxiao/tixianmingxi');		
			
	
		if($_W['shezhi']['tongzhi']['tixiantijiao']){
			$N['first']['value']='您已成功申请提现';
			$N['money']['value']=$TX['jin_e'].'元';
			$N['timet']['value']=$TX['shijian'];
			$N['remark']['value']='我们会尽快为您处理..';
			MX('weixin','he')->MuBanXiaoXi($hy['openid'],$_W['shezhi']['tongzhi']['tixiantijiao'],$N,$TX['url']);	
		}else{		
			$t="您已成功申请提现\r
			订单：{$TX['dingdanhao']}\r			
			申请时间：{$TX['shijian']}\r
			金额：¥{$TX['jin_e']}元\r			
			如需查看提现进度！<a href='{$TX['url']}'>点击查看</a>";		
			MX('weixin','he')->KeFuFaSong($hy['openid'],$t);	
		}
		$n=$hy['nicheng'];	
		//客服的接信的信息
		$tixing=$_W['shezhi']['jiaoyi']['tixing'];
		if(empty($tixing)){
				return;
		}
		if($_W['shezhi']['tongzhi']['tixiantijiao']){
			$N['first']['value']='会员【'.$n.'】有提现申请~尽快去处理吧~';
			$N['money']['value']=$TX['jin_e'].'元';
			$N['timet']['value']=$TX['shijian'];
			$N['remark']['value']='';
			$Tx=ChaQuan('select id,nicheng,openid from '.BM('he_huiyuan').' where id in ('.$tixing.')');
			foreach($Tx as $T){	
				if($T['openid']){
					MX('weixin','he')->MuBanXiaoXi($T['openid'],$_W['shezhi']['tongzhi']['tixiantijiao'],$N,'');	
				}
			}
		}else{	
			$kf="会员【{$n}】有提现申请~尽快去处理吧~\r
			订单：{$TX['dingdanhao']}\r			
			时间：{$TX['shijian']}\r
			金额：¥{$TX['jin_e']}元\r";			
			$this->KeFuDingDanTongzhi($kf);
		}
	}
	public function ShenHeTiXing($TX){
		global $_W;	
		if(!is_array($TX)){
			return false;
		}		
		$TX['shijian']=Date('Y-m-d H:i:s',$TX['shijian']);
				
		$hy=Qu('he_huiyuan',array('id'=>$TX['huiyuan']),'openid,nicheng');	
		
		if(empty($hy['openid'])){
			 return false;			
		}	
		$TX['url']=UAK('fenxiao/tixianmingxi');	
			
		if($_W['shezhi']['tongzhi']['tixiantijiao']){
			$N['first']['value']='您的提现申请已审核';
			$N['money']['value']=$TX['jin_e'].'元';
			$N['timet']['value']=$TX['shijian'];
			$N['remark']['value']='我们会尽快为您打款..';
			MX('weixin','he')->MuBanXiaoXi($hy['openid'],$_W['shezhi']['tongzhi']['tixiantijiao'],$N,$TX['url']);	
		}else{		
			$t="您的提现申请已审核\r
			订单：{$TX['dingdanhao']}\r			
			审核时间：{$TX['shijian']}\r
			金额：¥{$TX['jin_e']}元\r			
			如需查看提现进度！<a href='{$TX['url']}'>点击查看</a>";		
		}
		MX('weixin','he')->KeFuFaSong($hy['openid'],$t);	
		
		
		$n=$hy['nicheng'];	
		//客服的接信的信息
		$tixing=$_W['shezhi']['jiaoyi']['tixing'];
		if(empty($tixing)){
				return;
		}
		if($_W['shezhi']['tongzhi']['tixiantijiao']){
			$N['first']['value']='会员【'.$n.'】的提现申请已审核~尽快去处理吧~';
			$N['money']['value']=$TX['jin_e'].'元';
			$N['timet']['value']=$TX['shijian'];
			$N['remark']['value']='';
			$Tx=ChaQuan('select id,nicheng,openid from '.BM('he_huiyuan').' where id in ('.$tixing.')');
			foreach($Tx as $T){	
				if($T['openid']){
					MX('weixin','he')->MuBanXiaoXi($T['openid'],$_W['shezhi']['tongzhi']['tixiantijiao'],$N,$TX['url']);	
				}
			}
		}else{	
			$kf="会员【{$n}】的提现申请已审核~尽快去处理吧~\r
			订单：{$TX['dingdanhao']}\r			
			时间：{$TX['shijian']}\r
			金额：¥{$TX['jin_e']}元\r";			
			$this->KeFuDingDanTongzhi($kf);
		}
	}
	public function DaKuanTiXing($TX){
		global $_W;	
		if(!is_array($TX)){
			return false;
		}		
		$TX['shijian']=Date('Y-m-d H:i:s',$TX['shijian']);
				
		$hy=Qu('he_huiyuan',array('id'=>$TX['huiyuan']),'openid,nicheng');	
		if(empty($hy['openid'])){
			 return false;			
		}	
		$TX['url']=UAK('fenxiao/tixianmingxi');		
		if($_W['shezhi']['tongzhi']['tixianchenggong']){
			$N['first']['value']='您的提现申请已打款';
			$N['money']['value']=$TX['jin_e'].'元';
			$N['timet']['value']=$TX['shijian'];
			$N['remark']['value']='点击查看提现详情';
			MX('weixin','he')->MuBanXiaoXi($hy['openid'],$_W['shezhi']['tongzhi']['tixianchenggong'],$N,$TX['url']);	
		}else{	
			$t="您的提现申请已打款\r
			订单：{$TX['dingdanhao']}\r			
			打款时间：{$TX['shijian']}\r
			金额：¥{$TX['jin_e']}元\r			
			如需查看提现详情！<a href='{$TX['url']}'>点击查看</a>";		
			MX('weixin','he')->KeFuFaSong($hy['openid'],$t);	
		}
		
		$n=$hy['nicheng'];	
		//客服的接信的信息
		$tixing=$_W['shezhi']['jiaoyi']['tixing'];
		if(empty($tixing)){
				return;
		}
		if($_W['shezhi']['tongzhi']['tixianchenggong']){
			$N['first']['value']='会员【'.$n.'】的提现申请已打款~';
			$N['money']['value']=$TX['jin_e'].'元';
			$N['timet']['value']=$TX['shijian'];
			$N['remark']['value']='点击查看提现详情';
			$Tx=ChaQuan('select id,nicheng,openid from '.BM('he_huiyuan').' where id in ('.$tixing.')');
			foreach($Tx as $T){	
				if($T['openid']){
					MX('weixin','he')->MuBanXiaoXi($T['openid'],$_W['shezhi']['tongzhi']['tixianchenggong'],$N,$TX['url']);	
				}
			}
		}else{	
			$kf="会员【{$n}】的提现申请已打款~\r
			订单：{$TX['dingdanhao']}\r			
			时间：{$TX['shijian']}\r
			金额：¥{$TX['jin_e']}元\r";			
			$this->KeFuDingDanTongzhi($kf);
		}
	}
	public function WuXiaoTiXing($TX){
		global $_W;	
		if(!is_array($TX)){
			return false;
		}		
		$TX['shijian']=Date('Y-m-d H:i:s',$TX['shijian']);
				
		$hy=Qu('he_huiyuan',array('id'=>$TX['huiyuan']),'openid,nicheng');	
		if(empty($hy['openid'])){
			 return false;			
		}	
		$TX['url']=UAK('fenxiao/tixianmingxi');		
		if($_W['shezhi']['tongzhi']['tixianshibai']){
			$N['first']['value']='余额提现无效，已将资金退回至余额';
			$N['money']['value']=$TX['jin_e'].'元';
			$N['time']['value']=$TX['shijian'];
			$N['remark']['value']='无效原因:'.$TX['wuxiao'];
			MX('weixin','he')->MuBanXiaoXi($hy['openid'],$_W['shezhi']['tongzhi']['tixianshibai'],$N,$TX['url']);	
		}else{	
			$t="您的提现申请无效\r
			订单：{$TX['dingdanhao']}\r			
			无效时间：{$TX['shijian']}\r
			金额：¥{$TX['jin_e']}元\r
			无效原因：{$TX['wuxiao']}\r			
			如需查看提现详情！<a href='{$TX['url']}'>点击查看</a>";		
			MX('weixin','he')->KeFuFaSong($hy['openid'],$t);	
		}
		
		$n=$hy['nicheng'];	
		//客服的接信的信息
		$tixing=$_W['shezhi']['jiaoyi']['tixing'];
		if(empty($tixing)){
				return;
		}
		if($_W['shezhi']['tongzhi']['tixianshibai']){
			$N['first']['value']='会员【'.$n.'】的提现申请无效';
			$N['money']['value']=$TX['jin_e'].'元';
			$N['time']['value']=$TX['shijian'];
			$N['remark']['value']='无效原因:'.$TX['wuxiao'];
			
			$Tx=ChaQuan('select id,nicheng,openid from '.BM('he_huiyuan').' where id in ('.$tixing.')');
			foreach($Tx as $T){	
				if($T['openid']){
					MX('weixin','he')->MuBanXiaoXi($T['openid'],$_W['shezhi']['tongzhi']['tixianshibai'],$N,'');	
				}		
			}
		}else{	
			$kf="会员【{$n}】的提现申请无效~\r
			订单：{$TX['dingdanhao']}\r			
			时间：{$TX['shijian']}\r
			金额：¥{$TX['jin_e']}元\r
			无效原因：{$TX['wuxiao']}\r";			
			$this->KeFuDingDanTongzhi($kf);
		}
	}
	
	public function TiXingTiXing($TX){
		global $_W;	
		if(!is_array($TX)){
			return false;
		}		
		$TX['shijian']=Date('Y-m-d H:i:s',$TX['zhifushijian']);
				
		$hy=Qu('he_huiyuan',array('id'=>$TX['huiyuan']),'openid,nicheng');	
		if(empty($hy['openid'])){
			 return false;			
		}	
	
		if($TX['zongjia']>0){
			$TX['zongjia']=$TX['zongjia'].'元';
		}
		$n=$hy['nicheng'];	
		//客服的接信的信息
		$tixing=$_W['shezhi']['jiaoyi']['tixing'];
		if(empty($tixing)){
				return;
		}
		if($_W['shezhi']['tongzhi']['cuidan']){
		
			$N['first']['value']='会员【'.$n.'】催您发货，快去处理下吧';
			$N['keyword1']['value']=$TX['dingdanhao'];
			$N['keyword2']['value']='待发货';
			$N['keyword3']['value']=$TX['zongjia'];
			$N['remark']['value']='请您尽快发货!';
			
			$Tx=ChaQuan('select id,nicheng,openid from '.BM('he_huiyuan').' where id in ('.$tixing.')');
			foreach($Tx as $T){	
				if($T['openid']){
				    MX('weixin','he')->MuBanXiaoXi($T['openid'],$_W['shezhi']['tongzhi']['cuidan'],$N,'');
				}		
			}
			
		}else{	
			$kf="会员【{$n}】催您发货，快去处理下吧~\r
			订单：{$TX['dingdanhao']}\r			
			支付时间：{$TX['shijian']}";		
			$this->KeFuDingDanTongzhi($kf);
		}		
		
	}
	
	
	public function ShenFenTiXing($TX){
		global $_W;	
		if(!is_array($TX)){
			return false;
		}		
		$TX['shijian']=Date('Y-m-d H:i:s',$TX['shijian']);
				
		$hy=Qu('he_huiyuan',array('id'=>$TX['huiyuan']),'openid,nicheng');	
		if(empty($hy['openid'])){
			 return false;			
		}	
		$TX['url']=UAK('index');		
		
		if($_W['shezhi']['tongzhi']['huiyuanshengji']){
			$N['first']['value']='恭喜您升级为'.$TX['ming'];
			$N['keyword1']['value']=$TX['huiyuan'];
			$N['keyword2']['value']=$TX['shijian'];
			$N['remark']['value']='各种超值商品等您来选';
			MX('weixin','he')->MuBanXiaoXi($hy['openid'],$_W['shezhi']['tongzhi']['huiyuanshengji'],$N,$TX['url']);	
		}else{	
			$t="恭喜您升级为{$TX['ming']}\r
			时间：{$TX['shijian']}";
			MX('weixin','he')->KeFuFaSong($hy['openid'],$t);	
		}
		
		$n=$hy['nicheng'];	
		//客服的接信的信息
		$tixing=$_W['shezhi']['jiaoyi']['tixing'];
		if(empty($tixing)){
				return;
		}
		if($_W['shezhi']['tongzhi']['huiyuanshengji']){
			$N['first']['value']='会员【'.$n.'】升级为'.$TX['ming'];
			$N['keyword1']['value']=$TX['huiyuan'];
			$N['keyword2']['value']=$TX['shijian'];
			$N['remark']['value']='';
			$Tx=ChaQuan('select id,nicheng,openid from '.BM('he_huiyuan').' where id in ('.$tixing.')');
			foreach($Tx as $T){	
				if($T['openid']){
					MX('weixin','he')->MuBanXiaoXi($T['openid'],$_W['shezhi']['tongzhi']['huiyuanshengji'],$N,'');	
				}
			}
		}else{	
			$kf="会员【{$n}】升级为{$TX['ming']} \r
			时间：{$TX['shijian']}\r";
		
			$this->KeFuDingDanTongzhi($kf);
		}
	}
	
	
	
	
	
	public function FaHuoTiXing($TX){
		global $_W;	
		if(!is_array($TX)){
			return false;
		}	
		$hy=Qu('he_huiyuan',array('id'=>$TX['huiyuan']),'openid,nicheng');
		if(empty($hy['openid'])){
			 return false;			
		}		
	
		if($_W['shezhi']['tongzhi']['fahuo']){
			$N['first']['value']="【{$_W['shezhi']['shezhi']['ming']}】您的订单已发出,保持手机畅通..";
			$N['keyword1']['value']=$TX['dingdanhao'];
			$N['keyword2']['value']=$TX['kuaidiming'];
			$N['keyword3']['value']=$TX['kuaidihao'];
			$N['keyword4']['value']="{$TX['shouhuoshengshiqu']}{$TX['shouhuodizhi']}【电话：{$TX['shouhuodianhua']}】";		
			$N['remark']['value']='查看详情！';		
			MX('weixin','he')->MuBanXiaoXi($hy['openid'],$_W['shezhi']['tongzhi']['fahuo'],$N,$TX['url']);	
		}else{
			$t="【{$_W['shezhi']['shezhi']['ming']}】您的订单已发出,保持手机畅通..\r
			订单号：{$TX['dingdanhao']}\r	
			物流服务：{$TX['kuaidiming']}\r
			快递单号：{$TX['kuaidihao']}\r
			收货信息：{$TX['shouhuoshengshiqu']}{$TX['shouhuodizhi']}【电话：{$TX['shouhuodianhua']}】\r			
			<a href='{$TX['url']}'>查看详情</a>";
			MX('weixin','he')->KeFuFaSong($hy['openid'],$t);	
		}
		//客服的接信的信息
		$tixing=$_W['shezhi']['jiaoyi']['tixing'];
		if(empty($tixing)){
				return;
		}
		$n=$hy['nicheng'];	
		if($_W['shezhi']['tongzhi']['huiyuanshengji']){
			$N['first']['value']="会员【".$n."】的订单已发出..";
			$N['keyword1']['value']=$TX['dingdanhao'];
			$N['keyword2']['value']=$TX['kuaidiming'];
			$N['keyword3']['value']=$TX['kuaidihao'];
			$N['keyword4']['value']="{$TX['shouhuoshengshiqu']}{$TX['shouhuodizhi']}【电话：{$TX['shouhuodianhua']}】";		
			$N['remark']['value']='';		
		
			$Tx=ChaQuan('select id,nicheng,openid from '.BM('he_huiyuan').' where id in ('.$tixing.')');
			foreach($Tx as $T){	
				if($T['openid']){
						MX('weixin','he')->MuBanXiaoXi($T['openid'],$_W['shezhi']['tongzhi']['fahuo'],$N,'');	
				}
			}
		}
	}
	public function ShouHuoTiXing($TX){
		global $_W;	
		if(!is_array($TX)){
			return false;
		}	
		$hy=Qu('he_huiyuan',array('id'=>$TX['huiyuan']),'openid,nicheng');
		if(empty($hy['openid'])){
			 return false;			
		}
		$ddsp=ChaQuan('select ming,shuliang from '.BM('zw_shangcheng_dingdan_shangpin').' where dingdanid='.$TX['id']);
		foreach($ddsp as $d){
			$ming.=$d['ming'].'x'.$d['shuliang'].'~';
		}
		$TX['xiadanshijian']=date('Y-m-d H:i:s',$TX['xiadanshijian']);
		$TX['fahuoshijian']=date('Y-m-d H:i:s',$TX['fahuoshijian']);
		$TX['wanchengshijian']=date('Y-m-d H:i:s',$TX['wanchengshijian']);	
		if($_W['shezhi']['tongzhi']['wancheng']){
			$N['first']['value']="【{$_W['shezhi']['shezhi']['ming']}】亲：您在我们商城买的宝贝已经确认收货。";
			$N['keyword1']['value']=$TX['dingdanhao'];
			$N['keyword2']['value']=$ming;
			$N['keyword3']['value']=$TX['xiadanshijian'];
			$N['keyword4']['value']=$TX['fahuoshijian'];
			$N['keyword5']['value']=$TX['wanchengshijian'];	
			$N['remark']['value']='查看详情！';	
			MX('weixin','he')->MuBanXiaoXi($hy['openid'],$_W['shezhi']['tongzhi']['wancheng'],$N,$TX['url']);	
		}else{
			$t="【{$_W['shezhi']['shezhi']['ming']}】亲：您在我们商城买的宝贝已经确认收货。\r
				订单号：{$TX['dingdanhao']}\r	
				商品名称：{$ming}\r
				下单时间：{$TX['xiadanshijian']}\r
				发货时间：{$TX['fahuoshijian']}\r	
				收货时间：{$TX['wanchengshijian']}\r		
				<a href='{$TX['url']}'>查看详情</a>";
			MX('weixin','he')->KeFuFaSong($hy['openid'],$t);	
		}
		$n=$hy['nicheng'];	
		//客服的接信的信息
		$tixing=$_W['shezhi']['jiaoyi']['tixing'];
		if(empty($tixing)){
				return;
		}
		if($_W['shezhi']['tongzhi']['wancheng']){
			$N['first']['value']="【".$n."】确认收货~";
			$N['keyword1']['value']=$TX['dingdanhao'];
			$N['keyword2']['value']=$ming;
			$N['keyword3']['value']=$TX['xiadanshijian'];
			$N['keyword4']['value']=$TX['fahuoshijian'];
			$N['keyword5']['value']=$TX['wanchengshijian'];	
			$N['remark']['value']='';	
			$Tx=ChaQuan('select id,nicheng,openid from '.BM('he_huiyuan').' where id in ('.$tixing.')');
			
			foreach($Tx as $T){	
				if($T['openid']){
					MX('weixin','he')->MuBanXiaoXi($T['openid'],$_W['shezhi']['tongzhi']['wancheng'],$N,'');	
				}
			}
		}else{
			$kf="【{$n}】确认收货~\r
		       订单号：{$TX['dingdanhao']}\r	
			商品名称：{$ming}\r
			下单时间：{$TX['xiadanshijian']}\r
			发货时间：{$TX['fahuoshijian']}\r	
			收货时间：{$TX['wanchengshijian']}\r	";			
			$this->KeFuDingDanTongzhi($kf);
		}
		
	}	
	public function TuiJian($E,$shu){
		global $_W;			
		if(empty($shu) || empty($E)){
			return false;
		}
		$_W['tui']=$E[3];		
		MX('weixin','he')->ZhuCe($shu['FromUserName']);		
	}
	
	public function KeFuDingDanTongzhi($n){
		global $_W;
		$tixing=$_W['shezhi']['jiaoyi']['tixing'];
		if(empty($tixing)){
				return;
		}
		$Tx=ChaQuan('select id,nicheng,openid from '.BM('he_huiyuan').' where id in ('.$tixing.')');
		foreach($Tx as $T){	
			if($T['openid']){
			    MX('weixin','he')->KeFuFaSong($T['openid'],$n);
			}		
		}
		
	}
	
	//商家付款
	public function ShangHuFuKuanTiXing($TX){
		global $_W;	
		if(!is_array($TX)){
			return false;
		}			
		$hy=Cha('select h.openid,h.nicheng from '.BM('he_huiyuan').' h left join '.BM('he_shanghu').' s on h.id=s.hyid where s.id='.$TX['shanghu']);		
		if(empty($hy['openid'])){
			 return false;			
		}		
		$N['first']['value']='收到新订单已支付成功,待发货';
		$N['keyword1']['value']=$TX['dingdanhao'];
		$N['keyword2']['value']=$TX['zongjia'].'元';
		$N['keyword3']['value']=$TX['shouhuoren'];
		$N['keyword4']['value']=$TX['shouhuodianhua'];
		$N['keyword5']['value']=$TX['shijian'];
		$N['remark']['value']='快去为他发货..';				
		MX('weixin','he')->MuBanXiaoXi($hy['openid'],$_W['shezhi']['tongzhi']['zhifu_shanghu'],$N,$TX['url']);		
	
	}
	
	public function XCX_FuKuai(){
		$N['keyword1']['value']='2016年8月8日';
		$N['keyword2']['value']='银行转账';
		$N['keyword3']['value']='100';
		$N['keyword4']['value']='财付通';	
		MX('xiaochengxu','he')->MuBanXiaoXi($_W['huiyuan']['xcx_openid'],'PJ5TJ6D14q8mBrwgZXS-kX3y2TJ0rETX_CqeJz2aE_E',$N,'',$_J['form_id']);	
	}
	public function TuiHouTiXing($TX){
		global $_W;	
		if(!is_array($TX)){
			return false;
		}	
		
		$hy=Qu('he_huiyuan',array('id'=>$TX['huiyuan']),'openid,nicheng');
		if(empty($hy['openid'])){
			 return false;			
		}
		if($TX['zongjia']>0){
			$TX['zongjia']=$TX['zongjia'].'元';
		}
		$ddsp=ChaQuan('select ming,shuliang from '.BM('zw_shangcheng_dingdan_shangpin').' where dingdanid='.$TX['id']);
		foreach($ddsp as $d){
			$ming.=$d['ming'].'x'.$d['shuliang'].'~';
		}	
		$tongzhi=trim($_W['shezhi']['tongzhi']['tuihuo']);	
		if($tongzhi){
			$N['first']['value']="【{$_W['shezhi']['shezhi']['ming']}】亲：申请退货,请耐心等待..";
			$N['keyword1']['value']=$TX['dingdanhao'];
			$N['keyword2']['value']=$ming;
			$N['keyword3']['value']=$TX['zongjia'];		
			$N['remark']['value']='查看详情！';	
			MX('weixin','he')->MuBanXiaoXi($hy['openid'],$tongzhi,$N,$TX['url']);	
		}
		$n=$hy['nicheng'];	
		//客服的接信的信息
		$tixing=$_W['shezhi']['jiaoyi']['tixing'];
		if(empty($tixing)){
				return;
		}
		
		if($tongzhi){
			$N['first']['value']="【".$n."】申请退货";
			$N['keyword1']['value']=$TX['dingdanhao'];
			$N['keyword2']['value']=$ming;
			$N['keyword3']['value']=$TX['zongjia'];
			$N['remark']['value']='';	
			$Tx=ChaQuan('select id,nicheng,openid from '.BM('he_huiyuan').' where id in ('.$tixing.')');			
			foreach($Tx as $T){	
				if($T['openid']){
					MX('weixin','he')->MuBanXiaoXi($T['openid'],$tongzhi,$N,'');	
				}
			}
		}
	}
	public function TuiHouJieGuoTiXing($TX){
		global $_W;	
		if(!is_array($TX)){
			return false;
		}	
		if($TX['zongjia']>0){
			$TX['zongjia']=$TX['zongjia'].'元';
		}
		$hy=Qu('he_huiyuan',array('id'=>$TX['huiyuan']),'openid,nicheng');
		if(empty($hy['openid'])){
			 return false;			
		}
		$ddsp=ChaQuan('select ming,shuliang from '.BM('zw_shangcheng_dingdan_shangpin').' where dingdanid='.$TX['id']);
		foreach($ddsp as $d){
			$ming.=$d['ming'].'x'.$d['shuliang'].'~';
			$shuliang+=$d['shuliang'];
		}
		$tuihuojieguo=trim($_W['shezhi']['tongzhi']['tuihuojieguo']);
		
		if($tuihuojieguo){
			$N['first']['value']="【{$_W['shezhi']['shezhi']['ming']}】拒绝退货";
			$N['keyword1']['value']=$TX['dingdanhao'];
			$N['keyword2']['value']=$ming;
			$N['keyword3']['value']=$shuliang;		
			$N['keyword4']['value']=$TX['zongjia'];		
			$N['remark']['value']='';	
			MX('weixin','he')->MuBanXiaoXi($hy['openid'],$tuihuojieguo,$N,$TX['url']);	
		}
		
	}
}
?>