<?php
class huiyuan{	
	public function qu_huiyuan($id,$ziduan='*'){
		global $_W;	
		$tiaojian='h.danyuan='.$_W['danyuan'];
		if(intval($id)>0){
			$tiaojian.=' and h.id='.$id;
		}else{
			$tiaojian.=' and h.openid="'.$id.'"';
		}		
		$huiyuan=Cha('select h.* from '.BM('he_huiyuan_openid').' o right join '.BM('he_huiyuan').' h on o.hyid=h.id where '.$tiaojian);	
		if(empty($huiyuan)){
			 return false;
		}
		//查询上级		
		if($huiyuan['fuji_id']>0){
			$cen=array(':id'=>$huiyuan['fuji_id'],':danyuan'=>$_W['danyuan']);				
		    $fuji=Cha('select nicheng,xingming,touxiang from '.BM('he_huiyuan').' where 1 '.$where,$cen);		   
			$huiyuan['fuji_nicheng']=$fuji['nicheng'];
			$huiyuan['fuji_xingming']=$fuji['xingming'];
			$huiyuan['fuji_touxiang']=$fuji['touxiang'];	
			unset($fuji);
		}
		if($huiyuan['qita']){
		   $huiyuan['qita']=ZiFuChuan_Zhuan_ShuZu($huiyuan['qita']);	
		}
		
		$huiyuan['yu_e']=empty($huiyuan['yu_e'])?'0.00':$huiyuan['yu_e'];
		$huiyuan['jifen']=empty($huiyuan['jifen'])?'0':$huiyuan['jifen'];				
	    return $huiyuan;
	}
	
	public function gai_huiyuan($gai_huiyuan,$id,$teshu=false){
		global $_W;
		if(!$teshu){
			unset($gai_huiyuan['jifen'],$gai_huiyuan['yu_e']);
		}
		$cen=array('id'=>intval($id),'danyuan'=>$_W['danyuan']);
		Gai('he_huiyuan',$gai_huiyuan,$cen);
		return true;
	}
	public function gai_jifen($id,$val=0,$shuoming=''){
		global $_W;
		if(!is_numeric($val)){
			return false;
		}	
		$jifen=$this->qu_jifen($id);
		$Zong=$jifen+$val;		
		if($Zong<0 || empty($val)){
			return false;
		};
		//添加积分记录
		$rukouUrl='http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];
		$jilu=array('danyuan'=>$_W['danyuan'],'huiyuan_id'=>$id,'zhi'=>$val,'zong_e'=>$Zong,'shuoming'=>$shuoming,'shijian'=>time(),'zhuangtai'=>1,'rukouUrl'=>$rukouUrl);	
		
		
		ChaRu('he_huiyuan_jifen',$jilu);
		$gai_huiyuan=array('jifen'=>$Zong);	
		return $this->gai_huiyuan($gai_huiyuan,$id,true);
	}
	public function qu_jifen($id){
		$jifen=$this->qu_huiyuan($id,'jifen');
		return $jifen['jifen'];
	}

	public function gai_yu_e($id,$val=0,$shuoming='',$dingdanhao=''){
		global $_W;		
		if(!is_numeric($val)){
			return false;
		}				
		$yu_e=$this->qu_yu_e($id);
		$Zong=$yu_e['yu_e']+$val;		
		if($Zong<0 || empty($val)){
			return false;
		};
		//添加余额记录
		$rukouUrl='http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];
		$jilu=array('danyuan'=>$_W['danyuan'],'huiyuan_id'=>$id,'zhi'=>$val,'zong_e'=>$Zong,'shuoming'=>$shuoming,'shijian'=>time(),'zhuangtai'=>1,'rukouUrl'=>$rukouUrl,'dingdanhao'=>$dingdanhao);		
     	ChaRu('he_huiyuan_yongjin',$jilu);
					
		$gai_huiyuan=array('yu_e'=>$Zong);	
		return $this->gai_huiyuan($gai_huiyuan,$id,true);
	}
	public function qu_yu_e($id){
		return $this->qu_huiyuan($id,'yu_e');
	}
	public function BiZongE($bi='',$hyid='',$zhuangtai=1){
		global $_W;
		if(empty($bi)){
			return 0;
		}	
		if(empty($hyid)){
			$hyid=$_W['huiyuan']['id'];
		}	
		$h=ChaZongShu('select sum(zhi) from '.BM('he_huiyuan_'.$bi).' where danyuan='.$_W['danyuan'].' and huiyuan_id='.$hyid.' and zhuangtai='.$zhuangtai);	
		return  $h?$h:0;
		
	}
	public function BiLeiJi($bi='',$hyid=''){
		global $_W;
		if(empty($bi)){
			return 0;
		}	
		if(empty($hyid)){
			$hyid=$_W['huiyuan']['id'];
		}	
		$h=ChaZongShu('select sum(zhi) from '.BM('he_huiyuan_'.$bi).' where danyuan='.$_W['danyuan'].' and huiyuan_id='.$hyid.' and zhi>0');	
		return  $h?$h:0;
	}
	
	
	public function BiZong_JiaJian($bi='',$hyid='',$val=0,$shuoming='',$dingdanhao='',$zhuangtai=1,$leixing=''){
		global $_W;	
		if(empty($bi) || empty($hyid) || empty($val) || !is_numeric($val)){
			return false;
		}					
	
		$zong=ChaZongShu('select sum(zhi) from'.BM('he_huiyuan_'.$bi).' where danyuan='.$_W['danyuan'].' and huiyuan_id='.$hyid.' and zhuangtai=1');
		if($zhuangtai==1){
			$Zong=$zong+$val;	
		}else{
			$Zong=$zong;
		}
		
		if($Zong<0 || empty($val)){
			return false;
		};	
		$rukouUrl='http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];		
		$jilu=array('danyuan'=>$_W['danyuan'],'huiyuan_id'=>$hyid,'zhi'=>$val,'zong_e'=>$Zong,'shuoming'=>$shuoming,'shijian'=>SHIJIAN,'rukouUrl'=>$rukouUrl,'dingdanhao'=>$dingdanhao,'zhuangtai'=>$zhuangtai,'leixing'=>$leixing);	
	  return ChaRu('he_huiyuan_'.$bi,$jilu);
		
	}
	
	public function TuiBi($bi='',$hyid='',$shuoming='',$dingdanhao=''){
		global $_W;
		if(empty($bi)){
			 return 0;
		}		
		$h=ChaZongShu('select sum(zhi) from '.BM('he_huiyuan_'.$bi).' where danyuan='.$_W['danyuan']." and huiyuan_id=$hyid and dingdanhao='$dingdanhao'");			
		if($h<0){			
			$this->BiZong_JiaJian($bi,$hyid,-$h,$shuoming,$dingdanhao);	
		}
		
		
	}
	
	public function AppDengLu($shu=array(),$ziduan='*'){
		global $_W;	
		if(empty($shu)){
			return false;
		}		
		
		$where=" zhanghao=".$shu['zhanghao']."  and danyuan=".$_W['danyuan'];
		if($shu['mima']){
			 $where.=' and mima="'.md5($shu['mima']).'"';
		}								
										
		$huiyuan=Cha('select '.$ziduan.' from '.BM('he_huiyuan').' where  '.$where);		
		//查询上级
		if($huiyuan['dongjie']==1){
			json('已冻结',0);
		}	
		if($huiyuan['fuji_id']>0){		
		    $fuji=Cha('select nicheng,xingming,touxiang from '.BM('he_huiyuan').' where id='.$huiyuan['fuji_id']);		
				$huiyuan['fuji_nicheng']=$fuji['nicheng'];
				$huiyuan['fuji_xingming']=$fuji['xingming'];
				$huiyuan['fuji_touxiang']=$fuji['touxiang'];	
				unset($fuji);
		}		
		
		if($huiyuan){
			if($_W['zhongduan'] == 'app' || $_W['zhongduan'] == 'xiaochengxu'){
				ini_set("session.gc_maxlifetime","259200");
				ini_set("session.cookie_lifetime","259200");
			}
			session_start();				
			$_SESSION['id']=$huiyuan['id'];
			$_SESSION['danyuan']=$huiyuan['danyuan'];
			$_SESSION['xingming']=$huiyuan['xingming'];
			$_SESSION['nicheng']=$huiyuan['nicheng'];
			$_SESSION['touxiang']=$huiyuan['touxiang'];
			$_SESSION['zhanghao']=$huiyuan['zhanghao'];	
			$_SESSION['openid']=$huiyuan['openid'];			
			$_SESSION['ip']=GetIp();
			$_SESSION['shijian']=SHIJIAN;
			$_SESSION['kouling']=session_id();		
			
			$denglujilu['danyuan']=$huiyuan['danyuan'];
			$denglujilu['huiyuan']=$huiyuan['id'];
			$denglujilu['shijian']=SHIJIAN;
			$denglujilu['ip']=$_SESSION['ip'];
			
			$denglujilu['zongduan']=$_W['zhongduan'];
			$denglujilu['xitong']=$_W['os'];
			$denglujilu['url']=$_W['url'];
			ChaRu('he_denglu_jilu',$denglujilu);
		
		}		
	  return $_SESSION;
	}
	public function KouLing($zhi){
		$ip=GetIp();			
		$huiyuan=$this->YanZhengKouLing(array(':kouling'=>$zhi['kouling'],':danyuan'=>$zhi['danyuan']));			
		if($huiyuan){			
			$time=time();
			$md5kouling=md5($huiyuan['id'].$huiyuan['danyuan']);	
			$koulingbao=array('kouling'=>$md5kouling,'id'=>$huiyuan['id'],'danyuan'=>$huiyuan['danyuan'] ,'shebeihao'=>$huiyuan['shebeihao']);
			//$koulingbao=array('kouling'=>$md5kouling,'id'=>$huiyuan['id'],'danyuan'=>$huiyuan['danyuan'] ,'shebeihao'=>$huiyuan['shebeihao']);
			$kouling=JiaMi64(ShuZu_Zhuan_ZiFuChuan($koulingbao));
			$dl=array(			     		      
			       'kouling'=>$md5kouling,
			       'ip'=>$ip,
			       'shijian'=>$time			       
			       );			
			$f=Gai('he_denglu',$dl,array('id'=>$huiyuan['id']));			
			return 	$kouling;
		}
		return false;
	}
	public function YanZhengKouLing($zhi){
		$shijian=time()-900;		
		//$tianjian="kouling=:kouling and danyuan=:danyuan and shijian >".$shijian;
		$tianjian="kouling=:kouling and danyuan=:danyuan";
		$huiyuan=Cha('select * from '.BM('he_denglu').' where '.$tianjian, $zhi);	
		return 	$huiyuan;
	}
	
    static public function XiaXian($id,$cengci=0,$cc=0){    	
	     $arr=array();
	     $where=" and fuji_id=:fuji_id";
		 $cen=array(':fuji_id'=>$id);		
		 $huiyuan=ChaQuan('select id,touxiang,nicheng,zhanghao,shijian,fuji_id from '.BM('he_huiyuan').' where 1 '.$where,$cen);		 		 
		 foreach($huiyuan as $v){		 
		   if($cengci>$cc || empty($cengci)){
			   $v['nicheng']=empty($v['nicheng'])?$v['zhanghao']:$v['nicheng'];
			   $v['nicheng']=empty($v['nicheng'])?'未知':$v['nicheng'];
			   $v['touxiang']=JueDuiUrl($v['touxiang']);   
			   $v['cengci']=$cc+1; 			   
			   $arr[]=$v;
			   $arr=array_merge($arr,self::XiaXian($v['id'],$cengci,$cc+1));	
		   }					
		}		 
	    return $arr;
	 }
	 
	public function ShangHu($hyid,$zhuangtai=1){
		if(empty($hyid)){
			 return 0;
		}		
		$shanghu=Qu('he_shanghu',array('hyid'=>$hyid,'zhuangtai'=>$zhuangtai));
		if(empty($shanghu)){
		   json('还没有开通店铺',-2);
		}
		return $shanghu;
	}
}

?>