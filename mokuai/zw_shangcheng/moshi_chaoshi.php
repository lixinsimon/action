<?php
//共享超市模式
class zw_shangcheng_moshi_chaoshi{
	private $danyuan;
	private $hyid;
    public function __construct() {
		global $_W;		
		$this->danyuan = $_W['danyuan'];	
		$this->hyid = $_W['huiyuan']['id'];		
	}
	
    public function ShengJi($id){    	
    	//直推满足条件人数
    	$fxdengji=ChaQuan('select * from '.BM('zw_shangcheng_fenxiao_dengji').' where danyuan='.$this->danyuan.' and id>12 order by id desc');
    	$fx=Qu('zw_shangcheng_huiyuan',array('hyid'=>$id));
    	
    	foreach($fxdengji as $dj){
    		$where="h.danyuan=".$this->danyuan." and h.fuji_id=".$id.' and gh.huiyuandengji=0  and  gh.fenxiaodengji='.$dj['fenxiaodengji'];	    
			$zhitui=ChaZongShu('select count(*) from '.BM('zw_shangcheng_huiyuan').' gh left join '.BM('he_huiyuan').' h on gh.hyid=h.id where '.$where);	
	   		if($zhitui>=$dj['zhitui']){
	   			
	   			if($dj['id']>$fx['fenxiaodengji']){
	   				Gai('zw_shangcheng_huiyuan',array('fenxiaodengji'=>$dj['id']),array('hyid'=>$id));	
	   			
		   			$hy=Qu('he_huiyuan',array('id'=>$id));
		   			MX('huiyuan','he')->BiZong_JiaJian('xunzhang',$hy['fuji_id'],1,'推荐创客获得');
		   			
		   			
		   			$tixing=array(
						'danyuan'=>$this->danyuan,
						'hyid'=>$id,
						'neirong'=>'恭喜您正式成为斑马'.$dj['ming'].'，超值商品等您来选！',
						'leixing'=>1,
						'shijian'=>SHIJIAN
					);
					ChaRu('he_huiyuan_xiaoxi',$tixing);
		   			
		   			$tx['shijian']=SHIJIAN;
					$tx['huiyuan']=$id;    		
					$tx['ming']=$dj['ming'];		
					MX('api')->ShenFenTiXing($tx);
	   			}
	   			
	   			return false;
	   		}
    	}
    } 
  
	public function geiyongjin($hyid='',$qian=0,$dingdanhao='',$leixing=1){  
    	global $_W;  	
    	
    	$fuid=MX('huiyuan','he')->qu_huiyuan($hyid,'fuji_id'); 
    	
		$fuji=$this->quFuji($fuid['fuji_id']); 
		$tuandui=1;
		$fenxiang=1;
		foreach($fuji as $hy){
			if($tuandui==1){
				if($hy['fenxiaodengji']==12 && $fenxiang==1){
					if($leixing==1){
						MX('huiyuan','he')->BiZong_JiaJian('yongjin',$hy['id'],$qian*$hy['fenxiang']/100,'订单收益F',$dingdanhao,-1,1);
						$fenxiang=0;
					}else{
						MX('huiyuan','he')->BiZong_JiaJian('liquan',$hy['id'],10,'订单收益F',$dingdanhao,0,1);
						$fenxiang=0;
					}
				}elseif($hy['fenxiaodengji']==13 ){
					if($leixing==1){
						if($fenxiang==1){
							MX('huiyuan','he')->BiZong_JiaJian('yongjin',$hy['id'],$qian*$hy['fenxiang']/100,'订单收益F',$dingdanhao,-1,1);
							$fenxiang=0;	
						}
						MX('huiyuan','he')->BiZong_JiaJian('yongjin',$hy['id'],$qian*$hy['tuandui']/100,'订单收益T',$dingdanhao,-1,2);
						$tuandui=0;	
					}else{
						if($fenxiang==1){
							MX('huiyuan','he')->BiZong_JiaJian('liquan',$hy['id'],10,'订单收益F',$dingdanhao,0,1);
							$fenxiang=0;	
						}
						MX('huiyuan','he')->BiZong_JiaJian('liquan',$hy['id'],1,'订单收益T',$dingdanhao,0,2);
						$tuandui=0;	
					}
					
				}
			}
		}
	}
	public function tuigaiyongjin($dingdanhao=''){  
    	global $_W;  	
    	
    	$hydd=Cha('select dd.shijia,hy.hyid,dd.zhifushijian,huiyuandengji from '.BM('zw_shangcheng_dingdan').' dd left join '.BM('zw_shangcheng_huiyuan').' hy on hy.hyid=dd.huiyuan where dd.dingdanhao="'.$dingdanhao.'"');
    	$hyid=$hydd['hyid'];
    	
    	
		if($hydd['huiyuandengji']==10){
		    	$fuid=MX('huiyuan','he')->qu_huiyuan($hyid,'fuji_id');   
				$fuji=$this->quFuji($fuid['fuji_id']); 
				foreach($fuji as $hy){
						if($hy['fenxiaodengji']==12 || $hy['fenxiaodengji']==13){
							$shanvip=$hy['id'];
							break;
						}
				}
				
		    	 
		    	 
		    	$quyonjin=ChaQuan('select id from '.BM('he_huiyuan_yongjin').' where huiyuan_id='.$hyid.' and shijian>'.$hydd['zhifushijian'].' and shuoming="订单收益F"');
		    	$quliquan=ChaQuan('select id from '.BM('he_huiyuan_liquan').' where huiyuan_id='.$hyid.'  and shijian>'.$hydd['zhifushijian'].' and shuoming="订单收益F"');
		    	
				if($shanvip){
					foreach($quyonjin as $yj){
						Gai('he_huiyuan_yongjin',array('huiyuan_id'=>$shanvip),array('id'=>$yj['id']));
					}
					foreach($quliquan as $lq){
						Gai('he_huiyuan_liquan',array('huiyuan_id'=>$shanvip),array('id'=>$lq['id']));
					}
				}else{
					foreach($quyonjin as $yj){
						ShanChu('he_huiyuan_yongjin',array('id'=>$yj['id']));
					}
					foreach($quliquan as $lq){
						ShanChu('he_huiyuan_liquan',array('id'=>$lq['id']));
					}
				}
				Gai('zw_shangcheng_huiyuan',array('fenxiaodengji'=>11,'huiyuandengji'=>0),array('hyid'=>$hyid));		
		}
		
//		ShanChu('he_huiyuan_liquan',array('dingdanhao'=>$dingdanhao,'leixing'=>-1));
//		ShanChu('he_huiyuan_jifen',array('dingdanhao'=>$dingdanhao,'leixing'=>-1));
//		ShanChu('he_huiyuan_xunzhang',array('dingdanhao'=>$dingdanhao));
		
		$tuijf=ChaQuan('select * from '.BM('he_huiyuan_jifen').' where  leixing=-1 and dingdanhao="'.$dingdanhao.'"');
		if($tuijf){
			foreach($tuijf as $tyj){
					MX('huiyuan','he')->BiZong_JiaJian('jifen',$tyj['huiyuan_id'],-$tyj['zhi'],'订单退换货',$tyj['dingdanhao'],$tyj['zhuangtai'],$tyj['leixing']);
			}
		}
		
		
		
		
		
		$tuiyj=ChaQuan('select * from '.BM('he_huiyuan_yongjin').' where  (leixing=1 or leixing=2) and dingdanhao="'.$dingdanhao.'"');
		if($tuiyj){
			foreach($tuiyj as $tyj){
					MX('huiyuan','he')->BiZong_JiaJian('yongjin',$tyj['huiyuan_id'],-$tyj['zhi'],'订单退换货',$tyj['dingdanhao'],$tyj['zhuangtai'],$tyj['leixing']);
			}
		}
		
		$tuilq=ChaQuan('select * from '.BM('he_huiyuan_liquan').' where  (leixing=1 or leixing=2 or leixing=-1) and dingdanhao="'.$dingdanhao.'"');
		if($tuilq){
			foreach($tuilq as $tyj){
					MX('huiyuan','he')->BiZong_JiaJian('liquan',$tyj['huiyuan_id'],-$tyj['zhi'],'订单退换货',$tyj['dingdanhao'],$tyj['zhuangtai'],$tyj['leixing']);
			}
		}
		
	}
	
	
	
	static public function quFuji($fuid,$cengci=0){     	
        if(empty($fuid)){
        	return array();
        }        
    	$hy=Cha('select h.id,h.fuji_id,h.nicheng,gfd.ming,gfd.fenxiang,gfd.tuandui,gh.fenxiaodengji from '.BM('he_huiyuan').' h left join '.BM('zw_shangcheng_huiyuan').' gh on h.id=gh.hyid left join '.BM('zw_shangcheng_fenxiao_dengji').' gfd on gh.fenxiaodengji=gfd.id where h.id='.$fuid.$shifenxiaoshang ); 
       	$arr=array();
    	if($hy){
    		$arr[$cengci]['id']=$hy['id'];
    		$arr[$cengci]['ming']=$hy['nicheng'];
    		$arr[$cengci]['dengjiming']=$hy['ming'];
    		
    		$arr[$cengci]['fenxiang']=$hy['fenxiang'];
    		$arr[$cengci]['tuandui']=$hy['tuandui'];
    		$arr[$cengci]['fenxiaodengji']=$hy['fenxiaodengji'];
    		
    		$cengci++;    		   		
    		$arr=array_merge($arr,self::quFuji($hy['fuji_id'],$cengci));
    	}
    	return $arr;
    }
}
?>