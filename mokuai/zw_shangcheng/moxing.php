<?php
/**
 * [商城开源系统] Copyright (c) 2014 ZhiWi.COM
 *  商城群QQ：628361862  进群下载更新包 交流技术   http://www.ZhiWi.com/.
 */
class zw_shangcheng_moxing{
	private $zhuangtai_wenzi=array('0'=>'待付款','5'=>'已取消','6'=>'申请退款','7'=>'已退款','10'=>'待发货','15'=>'退换货中','20'=>'待收货','30'=>'完成','40'=>'已评价'); 
	private $zhifuqudao=array('weixin'=>'微信支付','duihuan'=>'礼券兑换','zhifubao'=>'支付宝','yu_e'=>'余额支付','houtai'=>'后台支付','yinlian'=>'银联支付','daofu'=>'货到付款','shangpiao'=>'商票支付'); 	
	
	public function quQuanFenLei($id=0,$tianjian=''){		
		global $_W;		
		if(!empty($tianjian)){
			$tianjian=' and '.$tianjian;
		}			
		$feileilie=ChaQuan('select * from '.BM('zw_shangcheng_feilei').' where danyuan='.$_W['danyuan'].$tianjian.' order by shunxu ASC,id ASC');
	    $DuoWei=false;
	    if($feileilie){
	    	$DuoWei=$this->DuoWeiFeiLei($feileilie,'haizi',$id);
	    }	    	  
	    return $DuoWei;
	}
	public function quQuanShangHuFenLei($id=0,$tianjian=''){		
		global $_W;		
		if(!empty($tianjian)){
			$tianjian.=' and '.$tianjian;
		}			
		$feileilie=ChaQuan('select * from '.BM('zw_shangcheng_fenlei_xiaozhan').' where shanghu='.$_W['shanghu']['id'].' and danyuan='.$_W['danyuan'].$tianjian.' order by shunxu ASC,id ASC');
	    $DuoWei=false;
	    if($feileilie){
	    	$DuoWei=$this->DuoWeiFeiLei($feileilie,'haizi',$id);
	    }	    	  
	    return $DuoWei;
	}
	
	public function quFenLei($id,$ZiDuan='*'){		
		global $_W;
		$ZiDuan=empty($ZiDuan)?'*':$ZiDuan;
		$feilei=Cha('select '.$ZiDuan.' from '.BM('zw_shangcheng_feilei').' where danyuan='.$_W['danyuan'].' and id='.$id);	       	  
	    return $feilei;
	}
	public function quShangHuFenLei($id,$ZiDuan='*'){		
		global $_W;
		$ZiDuan=empty($ZiDuan)?'*':$ZiDuan;
		$feilei=Cha('select '.$ZiDuan.' from '.BM('zw_shangcheng_feilei').' where danyuan='.$_W['danyuan'].' and shanghu='.$id);	       	  
	    return $feilei;
	}
	//小站分类 是指商家的自定义分类
	public function QuanFenLei_XiaoZhan($id=0){		
		global $_J;		
		if(!empty($tianjian)){
			$tianjian.=' and '.$tianjian;
		}			
		$feileilie=Cha('select fenlei from '.BM('zw_shangcheng_fenlei_xiaozhan').' where shanghu='.$_J['sh']);
		$fenlei=trim($feileilie['fenlei'],'_');		
		$ids=str_replace('__',",",$fenlei);
		
	    $DuoWei=false;
	    if($ids){
	    	$feileilie=ChaQuan('select * from '.BM('zw_shangcheng_feilei').' where id in('.$ids.') and zhuangtai=1 order by shunxu ASC,id ASC');    	
	    	$DuoWei=$this->DuoWeiFeiLei($feileilie,'haizi',$id);
	    }	    	  
	    return $DuoWei;
	}
	//一维数组
     static public function YiWeiFeiLei($lie,$html='|---',$fuji_id=0,$cengci=0){
	     $arr=array();
		 foreach($lie as $v){
		    if($v['fuji_id']==$fuji_id){
			   $v['cengci']=$cengci+1;			   
			   $v['html']=str_repeat($html,$cengci);			  
			   $arr[]=$v;
			   $arr=array_merge($arr,self::YiWeiFeiLei($lie,$html,$v['id'],$cengci+1));
			} 			
		}		 
	    return $arr;
	 }
	 //无级限分类
    static public function DuoWeiFeiLei ($lie,$haizi='haizi',$fuji_id=0){
	    $arr=array();
		foreach($lie as $v){			
			$v['tu']=JueDuiUrl($v['tu']);
			if($v['zhiurl']){
				$v['url']=$v['zhiurl'];
			}elseif(RUKOUMULU=='xiaozhan'){				
				$v['url']=UXK('liebiao/lie',array('id'=>$v['id']));
			}else{
				$v['url']=UAK('liebiao/lie',array('id'=>$v['id']));
			}
		   if($v['fuji_id']==$fuji_id){
		        $v[$haizi]=self::DuoWeiFeiLei($lie,$haizi,$v['id']);
			    $arr[]=$v;		   
		   }
		
		}
	   return $arr;
	}
	public function quShangPin($id,$ZiDuan='*'){
		global $_W; 
		$id=intval($id);
		if(empty($id)){return false;}		
		$TiaoJian='danyuan='.$_W['danyuan'].' and id='.$id;		
		$shangpin=Cha("select ".$ZiDuan." from ".BM('zw_shangcheng_shangpin')." where ".$TiaoJian);	
		$shangpin['xiangqing']=htmlspecialchars_decode($shangpin['xiangqing']);
		$shangpin['tu']=JueDuiUrl($shangpin['tu']);
		$shangpin['xijietu']=ZiFuChuan_Zhuan_ShuZu($shangpin['xijietu']);
		if($shangpin['xijietu']){			
			foreach($shangpin['xijietu'] as $k=>$xj){
                 $shangpin['xijietu'][$k+1]=JueDuiUrl($xj);
			}
		}
		$shangpin['xijietu'][0]=$shangpin['tu'];
		$shangpin['shuxing']=ZiFuChuan_Zhuan_ShuZu($shangpin['shuxing']);		
		$shangpin['zhekou']=ZiFuChuan_Zhuan_ShuZu($shangpin['zhekou']);
		$shangpin['yingxiao']=ZiFuChuan_Zhuan_ShuZu($shangpin['yingxiao']);	
		$shangpin['duliyongjin']=ZiFuChuan_Zhuan_ShuZu($shangpin['duliyongjin']);		
		$shangpin['xianzhi']=ZiFuChuan_Zhuan_ShuZu($shangpin['xianzhi']);		
		$xianzhidiqu=ltrim($shangpin['xianzhidiqu'],'|');			
		$shangpin['xianzhidiqu_zu']=explode('|',$xianzhidiqu);					
		return $shangpin;
	}
	public function quQuanShangPin($quTiaoShu=20,$DangQianYe=1,$ZiDuan='*',$TiaoJian=array(),$PaiXu='shunxu ASC,shijian DESC'){
		global $_W; 
		$TiaoJian[':danyuan']=$_W['danyuan'];
		$ZiDuan=empty($ZiDuan)?'*':$ZiDuan;
		$DangQianYe=empty($DangQianYe)?1:$DangQianYe;
		$quTiaoShu=empty($quTiaoShu)?20:$quTiaoShu;
		$sql="select ".$ZiDuan." from ".BM('zw_shangcheng_shangpin').' where 1 ';
		foreach($TiaoJian as $k=>$tj){
			if(is_numeric($tj)){
				$sql.=" and ".ltrim($k,':').'='.$tj;
			}elseif(is_array($tj)){
				$sql.=" and ".$tj[0];
			}else{
				$sql.=" and ".ltrim($k,':')."='".$tj."'";
			}			
		}				
		$sql.=" order by ".$PaiXu;
		$sql.=' Limit '. ($DangQianYe - 1) * $quTiaoShu . ',' . $quTiaoShu;			
		$sp=ChaQuan($sql);	
		if($sp){
			foreach($sp as $k=>$s){
				if($s['fenlei_yiji']){
					$fenlei_yiji_ming=$this->quFenLei($s['fenlei_yiji'],'ming');
					$sp[$k]['fenlei_yiji_ming']=$fenlei_yiji_ming['ming'];
				}
				if($s['fenlei_erji']){
				   $fenlei_erji_ming=$this->quFenLei($s['fenlei_erji'],'ming');				
				   $sp[$k]['fenlei_erji_ming']=$fenlei_erji_ming['ming'];
				}
				if($s['tu']){
					$sp[$k]['tu']=JueDuiUrl($s['tu']);		
				}				
			}
		}		
		return $sp;
	}
	public function JiaGaiShangPin($shu){		
		global $_W;
		if(empty($shu['ming'])){
			XiaoXi('标题不为空！');
		}
		if(empty($shu['fenlei'][0])){
			//XiaoXi('一级分类不为空！');
		}
		if(empty($shu['tu'])){
			XiaoXi('商品图不为空！');
		}
		if($shu['jiage']<0){
			XiaoXi('商品价格不能为负！');
		}
		if($shu['yuanjia']<0){
			XiaoXi('商品原价不能为负！');
		}
		if($shu['chengben']<0){
			XiaoXi('商品VIP价不能为负！');
		}
		if($shu['zhongliang']<0){
			XiaoXi('商品重量不能为负！');
		}
		$id=$shu['id'];		
		$pregRule = "/<[img|IMG].*?src=[\'|\"](.*?(?:[\.jpg|\.jpeg|\.png|\.gif|\.bmp]))[\'|\"].*?[\/]?>/";
		$shu['xiangqing']= preg_replace($pregRule, '<img src="${1}" style="max-width:100%">',$shu['xiangqing']); 
	  
		if($shu['jiage']<$shu['jifen']){
			  XiaoXi('赠送和券不能小于大价格');
		}	
		$this->GuiGe_YanZheng($shu);	
	  
		$sp=array(
		    "danyuan"     =>$_W['danyuan'],
		    "shunxu"     =>intval($shu['shunxu']),
		    "ming"       =>trim($shu['ming']),
		    "fenlei_yiji"=>intval($shu['fenlei'][0]),
		    "fenlei_erji"=>intval($shu['fenlei'][1]),
		    "leixing"    =>intval($shu['leixing']),
		    "danwei"     =>empty($shu['danwei'])?'个':trim($shu['danwei']),
		    "xinpin"     =>empty($shu['xinpin'])?0:$shu['xinpin'],	   
		    "remai"      =>empty($shu['remai'])?0:$shu['remai'],	
		    "tuijian"    =>empty($shu['tuijian'])?0:$shu['tuijian'],	
		    "cuxiao"     =>empty($shu['cuxiao'])?0:$shu['cuxiao'],	
		    "baoyou"     =>empty($shu['baoyou'])?0:$shu['baoyou'],	
		    "miaosha"    =>empty($shu['miaosha'])?0:$shu['miaosha'],	
		    "kaishishijian"=>strtotime($shu['kaishi']),
		    "jieshushijian"=>strtotime($shu['jieshu']),
		    "tu"         =>trim($shu['tu']),
		    "xijietu"    =>ShuZu_Zhuan_ZiFuChuan($shu['xijietu']),
		    "jiage"      =>round($shu['jiage'],2),
		    "yuanjia"    =>round($shu['yuanjia'],2),
		    "chengben"   =>round($shu['chengben'],2),
		    "zhongliang" =>$shu['zhongliang'],
		    "kucun"      =>intval($shu['kucun']),
		    "jiankucun"  =>intval($shu['jiankucun']),
		    "yicizuiduomai"=>intval($shu['yicizuiduomai']),
		    "zuiduomai"  =>intval($shu['zuiduomai']),
		    "chushoushu" =>intval($shu['chushoushu']),
		    "jifen"      =>intval($shu['jifen']),
		    "yu_e"      =>round($shu['yu_e'],2),
		    "yunfeishezhi"=>intval($shu['yunfeishezhi']),
		    "kuaidi"     =>intval($shu['kuaidi']),
		    "kuaidifei"  =>round($shu['kuaidifei'],2),
		    "daofu"      =>intval($shu['daofu']),
		    "zhuangtai"  =>intval($shu['zhuangtai']),
		    "xiangqing"  =>$shu['xiangqing'],
		    "shuxing"    =>ShuZu_Zhuan_ZiFuChuan($shu['shuxing']),
		    "kaiqiguige" =>intval($shu['kaiqiguige']),
		    "liulanquanxian"=>$shu['liulanquanxian'],
		    "goumaiquanxian"=>$shu['goumaiquanxian'],
		    "zhekou"     =>ShuZu_Zhuan_ZiFuChuan($shu['zhekou']),
		    "yingxiao"   =>ShuZu_Zhuan_ZiFuChuan($shu['yingxiao']),
		    "canyufenxiao"=>intval($shu['canyufenxiao']),
		    "fenxiaodengji"=>intval($shu['fenxiaodengji']),
		    "huiyuandengji"=>intval($shu['huiyuandengji']),
		    "dulifenyong"=>intval($shu['dulifenyong']),	
		    "duliyongjin"=>ShuZu_Zhuan_ZiFuChuan($shu['duli']),
		    "gengxinshijian"=>SHIJIAN,
		    "yu_e_zhifu"=>intval($shu['yu_e_zhifu']),		  
		    'xianzhidiqu'=>trim($shu['xianzhidiqu']),
		    "shanghu"=>intval($shu['dianpuId']),	
		    
		    "liquan"=>intval($shu['liquan']),	
		    "xunzhang"=>intval($shu['xunzhang']),	
		    "jifenman"=>intval($shu['jifenman']),	
		  	"jifenkou"=>intval($shu['jifenkou']),	
		    'xianzhi'=>ShuZu_Zhuan_ZiFuChuan($shu['xianzhi']),	   
		    'songliquan'=> intval($shu['songliquan']),
		    'fahuoshijian'=>strtotime($shu['fahuo']),
		    'xinpintu'=>$shu['xinpintu']	
		);
		
		if($sp['kaiqiguige']){$this->ChaRuGuiGe($shu,$id);}				
		if(empty($id)){
			$sp['shijian']=SHIJIAN;
			ChaRu('zw_shangcheng_shangpin',$sp);
			$Cid=ChaRuID();
			$id=($Cid>0)?$Cid:false;
		}else{
			Gai('zw_shangcheng_shangpin',$sp,array('id'=>$id,'danyuan'=>$_W['danyuan']));
		}
		$this->	ChaRuGuiGe($shu,$id);
		return $id;
	}
	public function GuiGe_YanZheng($shu){
		if(empty($shu['guige_xuanze_id']) || empty($shu['jifen'])){
			 return false;
		}
		foreach($shu['guige_xuanze_id'] as $gixz){		
				if($shu['guige_xuanze_jiage_'.$gixz][0]<$shu['jifen']){
						XiaoXi('赠送和券不能小于出售价格');
				}	

		}	
	}
	public function ChaRuGuiGe($shu,$shangpin_id){
		global $_W;	
		$data=array('shangpin_id'=>$shangpin_id,'danyuan'=>$_W['danyuan']);	
		ShanChu('zw_shangcheng_shangpin_guige_zu',$data);
		ShanChu('zw_shangcheng_shangpin_guige',$data);						
		if(empty($shangpin_id) || empty($shu['guigezu_id'])){
			ShanChu('zw_shangcheng_shangpin_guige_xuanze',$data);				
			return false;
		}		
		foreach($shu['guigezu_id'] as $k=>$gzi){
			$guigezu=$data;
			$guigezu['guigezu_id']=	$gzi;
			$guigezu['guigezu_ming']=$shu['guigezu_ming'][$gzi];
			if(empty($shu['guige_id_'.$gzi])){return false;}
			$guigezu['guigeshu']=count($shu['guige_id_'.$gzi]);			
			foreach($shu['guige_id_'.$gzi] as $kk=>$gi){
				$guige=$data;
				$guige['guige_id']=$gi;
				$guige['guigezu_id']=$gzi;
				$guige['guige_ming']=$shu['guige_ming_'.$gzi][$kk];
				$guige['guige_tu']=$shu['guige_tu_'.$gzi][$kk];
				$guige['guige_show']=$shu['guige_show_'.$gzi][$kk];
				ChaRu('zw_shangcheng_shangpin_guige',$guige);	
				unset($guige);
			}
			ChaRu('zw_shangcheng_shangpin_guige_zu',$guigezu);
			unset($guigezu);
		}
		if(empty($shu['guige_xuanze_id'])){return false;}
		$shanchuid='';
		foreach($shu['guige_xuanze_id'] as $gixz){
			$guigexuanze=$data;
			$guigexuanze['guige_xuanze_id']=$gixz;
			$guigexuanze['guige_xuanze_ming']=$shu['guige_xuanze_ming_'.$gixz][0];
			$guigexuanze['guige_xuanze_kucun']=$shu['guige_xuanze_kucun_'.$gixz][0];
			$guigexuanze['guige_xuanze_jiage']=$shu['guige_xuanze_jiage_'.$gixz][0];
			$guigexuanze['guige_xuanze_yuanjia']=$shu['guige_xuanze_yuanjia_'.$gixz][0];
			$guigexuanze['guige_xuanze_chengben']=$shu['guige_xuanze_chengben_'.$gixz][0];
			$guigexuanze['guige_xuanze_zhongliang']=$shu['guige_xuanze_zhongliang_'.$gixz][0];					
			$cz=Qu('zw_shangcheng_shangpin_guige_xuanze',array('shangpin_id'=>$shangpin_id,'id'=>$shu['guige_xuanze_id_'.$gixz][0]),'id');		
			if($cz){				
				$shanchuid.=$shu['guige_xuanze_id_'.$gixz][0].',';
				unset($guigexuanze['shangpin_id'],$guigexuanze['danyuan']);				
				Gai('zw_shangcheng_shangpin_guige_xuanze',$guigexuanze,array('id'=>$cz['id']));	
			}else{				
			    ChaRu('zw_shangcheng_shangpin_guige_xuanze',$guigexuanze);	
			    $shanchuid.=ChaRuID().',';				 
			}			
		    unset($guigexuanze);		
		}	
		$shanchuid=rtrim($shanchuid,',');	
		$oo=YunSQL('delete from '.BM('zw_shangcheng_shangpin_guige_xuanze').' where danyuan='.$_W['danyuan'].' and shangpin_id='.$shangpin_id.' and id not in('.$shanchuid.')');	   
		return true;
	}
	
    public function quGuiGe($id=''){
    	if(empty($id)){return false;}
    	$gg=array();
    	$gg['guige_zu']=ChaQuan('select * from '.BM('zw_shangcheng_shangpin_guige_zu').' where shangpin_id='.$id.' order by id ASC');    	
        $gg['guige']=ChaQuan('select * from '.BM('zw_shangcheng_shangpin_guige').' where shangpin_id='.$id.' order by id ASC');
        $gg['guige_xuanze']=ChaQuan('select * from '.BM('zw_shangcheng_shangpin_guige_xuanze').' where shangpin_id='.$id.' order by id ASC');
    	return $gg;
    }
    public function quGuiGeXuanZe_html($shu){
    	if(empty($shu['guige'])){
    		return '';
    	}
    	$guige=array();    	
    	
    	foreach($shu['guige'] as $l){
    		$guige[$l['guige_id']]=$l;    		
    	}   	
    	$html ='<table class="table table-bordered table-condensed spectable"><thead><tr class="active">';    		
    	foreach($shu['guige_zu'] as $ids){
    		$html .= "<th style='width:80px;line-height: 80px;'>" . $ids['guigezu_ming'] . "</th>";
    	}	
    	$html.='<th class="info" style="width:130px;"><div class=""><div style="padding-bottom:10px;text-align:center;font-size:16px;">库存</div><div class="input-group"><input type="text" class="form-control option_stock_all"VALUE=""/><span class="input-group-addon"><a href="javascript:;" class="fa fa-hand-o-down" title="批量设置" onclick="setCol(\'option_stock\');"></a></span></div></div></th>';
		$html.='<th class="success" style="width:150px;"><div class=""><div style="padding-bottom:10px;text-align:center;font-size:16px;">销售价格</div><div class="input-group"><input type="text" class="form-control option_marketprice_all"VALUE=""/><span class="input-group-addon"><a href="javascript:;" class="fa fa-hand-o-down" title="批量设置" onclick="setCol(\'option_marketprice\');"></a></span></div></div></th>';
		$html.='<th class="warning" style="width:150px;"><div class=""><div style="padding-bottom:10px;text-align:center;font-size:16px;">市场价格</div><div class="input-group"><input type="text" class="form-control option_productprice_all"VALUE=""/><span class="input-group-addon"><a href="javascript:;" class="fa fa-hand-o-down" title="批量设置" onclick="setCol(\'option_productprice\');"></a></span></div></div></th>';
		$html.='<th class="danger" style="width:150px;"><div class=""><div style="padding-bottom:10px;text-align:center;font-size:16px;">VIP价价格</div><div class="input-group"><input type="text" class="form-control option_costprice_all"VALUE=""/><span class="input-group-addon"><a href="javascript:;" class="fa fa-hand-o-down" title="批量设置" onclick="setCol(\'option_costprice\');"></a></span></div></div></th>';		
		$html.='<th class="info" style="width:150px;"><div class=""><div style="padding-bottom:10px;text-align:center;font-size:16px;">重量（克）</div><div class="input-group"><input type="text" class="form-control option_weight_all"VALUE=""/><span class="input-group-addon"><a href="javascript:;" class="fa fa-hand-o-down" title="批量设置" onclick="setCol(\'option_weight\');"></a></span></div></div></th>';
		$html.='</tr></thead>';

		$hh='';	
	
		foreach($shu['guige_xuanze'] as $b){
			$ids=$b['guige_xuanze_id'];
			$guigexiabian = explode("_", $b['guige_xuanze_id']);
			$hh   .="<tr>";
			foreach($guigexiabian as $a){				
			     $hh .= "<td rowspan=1>" . $guige[$a]['guige_ming'] . "</td>";
			}
			$hh .= '<td class="info">';
	        $hh .= '<input name="guige_xuanze_kucun_' . $ids . '[]"  type="text" class="form-control option_stock option_stock_' . $ids . '" value="' . $b['guige_xuanze_kucun'] . '"/>';
	       
	        $hh .= '<input name="guige_xuanze_id_' . $ids . '[]"  type="hidden" class="form-control option_id option_id_' . $ids . '" value="' . $b['id'] . '"/>';
	        $hh .= '<input name="guige_xuanze_id[]"  type="hidden" class="form-control option_ids option_ids_' . $ids . '" value="' . $ids . '"/>';
	        
	        $hh .= '<input name="guige_xuanze_ming_' . $ids . '[]"  type="hidden" class="form-control option_title option_title_' . $ids . '" value="' . $b['guige_xuanze_ming'] . '"/>';
	        // $hh .= '<input name="option_virtual_' . $ids . '[]"  type="hidden" class="form-control option_title option_virtual_' . $ids . '" value="' . $val['virtual'] . '"/>';
	        $hh .= '</td>';
	        $hh .= '<td class="success"><input name="guige_xuanze_jiage_' . $ids . '[]" type="text" class="form-control option_marketprice option_marketprice_' . $ids . '" value="' . $b['guige_xuanze_jiage'] . '"/></td>';
	        $hh .= '<td class="warning"><input name="guige_xuanze_yuanjia_' . $ids . '[]" type="text" class="form-control option_productprice option_productprice_' . $ids . '" " value="' . $b['guige_xuanze_yuanjia'] . '"/></td>';
	        $hh .= '<td class="danger"><input name="guige_xuanze_chengben_' . $ids . '[]" type="text" class="form-control option_costprice option_costprice_' . $ids . '" " value="' . $b['guige_xuanze_chengben'] . '"/></td>';
	        //$hh .= '<td class="primary"><input name="option_goodssn_' . $ids . '[]" type="text" class="form-control option_goodssn option_goodssn_' . $ids . '" " value="' . $val['goodssn'] . '"/></td>';
	        //$hh .= '<td class="danger"><input name="option_productsn_' . $ids . '[]" type="text" class="form-control option_productsn option_productsn_' . $ids . '" " value="' . $val['productsn'] . '"/></td>';
	        $hh .= '<td class="info"><input name="guige_xuanze_zhongliang_' . $ids . '[]" type="text" class="form-control option_weight option_weight_' . $ids . '" " value="' . $b['guige_xuanze_zhongliang'] . '"/></td>';
	        $hh .= '</tr>';
        }
		$html.= $hh;
		$html.= "</table>";
		return $html;
    }
    public function quSheZhi(){
    	global $_W;		
    	$sz=Cha("select * from ".BM('zw_shangcheng_shezhi')." where danyuan=".$_W['danyuan']);
    	if($sz){
    		$sz['shezhi']=ZiFuChuan_Zhuan_ShuZu($sz['shezhi']);
	    	$sz['fenxiang']=ZiFuChuan_Zhuan_ShuZu($sz['fenxiang']);
	    	$sz['tongzhi']=ZiFuChuan_Zhuan_ShuZu($sz['tongzhi']);
	    	$sz['jiaoyi']=ZiFuChuan_Zhuan_ShuZu($sz['jiaoyi']);  
    	}    	   	
    	return $sz;
    }
     public function quHuiYuan($id='',$ziduan="*"){
    	global $_W;    	  		
    	if(empty($id)){
    		$id=$_W['huiyuan']['id'];
    	}     	
    	$huiyuan=MX('huiyuan','he')->qu_huiyuan($id);    	
    	$hy=Qu('zw_shangcheng_huiyuan',array('hyid'=>$id));			
    	if(empty($hy)){
    		$charu['danyuan']=$_W['danyuan'];
    		$charu['hyid']=$id;			
    		$charu['huiyuanshijian']=SHIJIAN;
    		ChaRu('zw_shangcheng_huiyuan',$charu); 
    	}
    	if($hy['fenxiaodengji']>0){   	
    		$fx=Qu('zw_shangcheng_fenxiao_dengji','id='.$hy['fenxiaodengji'],'ming');
    		$huiyuan['fenxiaodengjiming']=$fx['ming']; 	
    	}  	
    	
    	if($huiyuan && $hy){			
    		$huiyuan=array_merge($hy,$huiyuan);
    	}    	
    	$huiyuan['dengjiid']=empty($hy['huiyuandengji'])?0:$hy['huiyuandengji'];
    	$huiyuan['dengjiming']=empty($dengji['ming'])?'普通会员':$dengji['ming'];  
    	$huiyuan['nicheng']=empty($huiyuan['nicheng'])?$huiyuan['xingming']:$huiyuan['nicheng'];     	
    	return $huiyuan;
    }
    public function quDengJiLie(){
    	global $_W;
    	$dj=ChaQuan("select * from ".BM('zw_shangcheng_huiyuan_dengji')." where danyuan=".$_W['danyuan']." order by dengji ASC,id ASC");		
        return $dj;
    }
    public function quDengJi($id){
    	global $_W;
    	$dj=Cha("select * from ".BM('zw_shangcheng_huiyuan_dengji')." where danyuan=".$_W['danyuan'].' and id='.intval($id));    	
    	return $dj;		
    }
    public function quHuiyuanLie($quTiaoShu=20,$DangQianYe=1,$ZiDuan='*',$TiaoJian=array(),$PaiXu='shijian DESC'){
    	global $_W; 
		$TiaoJian[':danyuan']=$_W['danyuan'];
		$ZiDuan=empty($ZiDuan)?'*':$ZiDuan;
		$DangQianYe=empty($DangQianYe)?1:$DangQianYe;
		$quTiaoShu=empty($quTiaoShu)?20:$quTiaoShu;
		$sql="select ".$ZiDuan." from ".BM('zw_shangcheng_huiyuan').' where 1 ';
		foreach($TiaoJian as $k=>$tj){
			if(is_numeric($tj)){
				$sql.=" and ".ltrim($k,':').'='.$k;
			}else{
				$sql.=" and ".ltrim($k,':')."='".$k."'";
			}			
		}
		$sql.=" order by ".$PaiXu;
		$sql.=' Limit '. ($DangQianYe - 1) * $quTiaoShu . ',' . $quTiaoShu;		
		$sp=ChaQuan($sql,$TiaoJian);
		
    }
    function ZhiGou($shangpinid=Null,$guigeid='',$shuliang=Null,$dizhi=''){
    	global $_W;
    	if(empty($shangpinid)){
    		return false;
    	}
    	$shuliang=empty($shuliang)?1:$shuliang;
    	$sqlsp='select * from '.BM('zw_shangcheng_shangpin').' where danyuan='.$_W['danyuan'].' and id='.$shangpinid;
    	$shangpin=Cha($sqlsp); 
    	$shangpin['tu']=JueDuiUrl($shangpin['tu']);

    	if($guigeid>0){
    		$sqlgg='select * from '.BM('zw_shangcheng_shangpin_guige_xuanze').' where shangpin_id='.$shangpin['id'].' and id='.$guigeid;
    	    $guige=Cha($sqlgg);
    	}     	

    	if($guige && $guige['guige_xuanze_jiage']>0){
    		$shangpin['ming'].=' '.$guige['guige_xuanze_ming'];
			$shangpin['kucun']=$guige['guige_xuanze_kucun'];
			$shangpin['jiage']=$guige['guige_xuanze_jiage'];
		    $shangpin['zhongliang']=$guige['guige_xuanze_zhongliang'];	
		    $shangpin['yuanjia']=$guige['guige_xuanze_yuanjia'];
		    $shangpin['chengben']=$guige['guige_xuanze_chengben'];
		    $g1=explode("_",$guige['guige_xuanze_id']);	
		    $g2=Cha('select guige_tu from '.BM('zw_shangcheng_shangpin_guige').' where guige_id="'.$g1[0].'"');
		    if($g2['guige_tu']){
		    	 $shangpin['tu']=JueDuiUrl($g2['guige_tu']);	    	
		    }
		   
    	}		
    	if($shangpin['kucun']<$shuliang){
    		json('库存不足',0);
    	}
    	$shangpin['shuliang']=$shuliang;
    	$shijia= $shangpin['jiage']* $shuliang;
    	$shangpin['shangpin']=$shangpin['id'];   	
    	$shangpin['duliyongjin']=ZiFuChuan_Zhuan_ShuZu($shangpin['duliyongjin']);    	 
    	$gouwuchelie=array('0'=>$shangpin);
		
    	$shu['gouwuchelie']=$this->FenDan($gouwuchelie,$dizhi);
    	
		if(empty($_W['shezhi']['jiaoyi']['jifenzhuanhua'])){
			$_W['shezhi']['jiaoyi']['jifenzhuanhua']=1;
		}
    	
		foreach($shu['gouwuchelie'] as $c){
			$shu['zongjia']+=$c['zongjia'];
			$shu['yunfei']+=$c['yunfei'] ;
			$shu['jifendikou']+=$c['jifendikou'];	
			$shu['jifendikou_e']+=$c['jifendikou']/intval($_W['shezhi']['jiaoyi']['jifenzhuanhua']);
		}		
		
		return $shu;
    	
    }
    function quGouWuCheLie($ids,$dizhi=''){
		global $_W;
		if(empty($ids)){
			return false;
		}
		$ziduan="gwc.*,sp.ming,sp.cuxiao,sp.jiage,sp.kucun,sp.tu,sp.yuanjia,sp.yunfeishezhi,sp.kuaidi,sp.kuaidifei,sp.songliquan,sp.shanghu,sp.zhongliang,sp.canyufenxiao,sp.dulifenyong,sp.duliyongjin,sp.jiankucun,sp.jifen,sp.yu_e,sp.yu_e_zhifu,sp.baoyou,sp.chengben,sp.yingxiao,gg.*";
		$sql='select '.$ziduan.' from '.BM('zw_shangcheng_gouwuche').'gwc left join ';
		$sql.=BM('zw_shangcheng_shangpin').' sp on gwc.shangpin=sp.id left join ';
		$sql.=BM('zw_shangcheng_shangpin_guige_xuanze').' gg on gwc.guige=gg.id';
		$sql.=' where gwc.danyuan='.$_W['danyuan'].' and gwc.huiyuan='.$_W['huiyuan']['id'].' and gwc.id IN('.$ids.') order by shijian DESC';
		$gouwuchelie=ChaQuan($sql);	
		$zongjia=$yunfei=0;		
		foreach($gouwuchelie as $k=>$g){						
			$gouwuchelie[$k]['duliyongjin']=ZiFuChuan_Zhuan_ShuZu($g['duliyongjin']); 		
			if($g['guige']>0){
				$gouwuchelie[$k]['ming'].=' '.$g['guige_xuanze_ming'];
				$gouwuchelie[$k]['kucun']=$g['guige_xuanze_kucun'];
				$gouwuchelie[$k]['jiage']=$g['guige_xuanze_jiage'];
				$gouwuchelie[$k]['chengben']=$g['guige_xuanze_chengben'];
			  $gouwuchelie[$k]['zhongliang']=$g['guige_xuanze_zhongliang'];	
			  $gouwuchelie[$k]['yuanjia']=$g['guige_xuanze_yuanjia'];	    
			}
			$gouwuchelie[$k]['tu']=JueDuiUrl($g['tu']);
			$gouwuchelie[$k]['yuanjia']=empty($gouwuchelie[$k]['yuanjia'])?$gouwuchelie[$k]['jiage']:$gouwuchelie[$k]['yuanjia'];    				
			unset($gouwuchelie[$k]['guige_xuanze_yuanjia'],$gouwuchelie[$k]['guige_xuanze_chengben'],$gouwuchelie[$k]['guige_xuanze_jiage'],$gouwuchelie[$k]['guige_xuanze_zhongliang'],$gouwuchelie[$k]['guige_xuanze_kucun'],$gouwuchelie[$k]['guige_xuanze_ming']);	     		    
		}
		$shu['gouwuchelie']=$this->FenDan($gouwuchelie,$dizhi);
		$jifenzhuanhua=$_W['shezhi']['jiaoyi']['jifenzhuanhua']?$_W['shezhi']['jiaoyi']['jifenzhuanhua']:1;
		foreach($shu['gouwuchelie'] as $c){
			$shu['zongjia']+=$c['zongjia'];
			$shu['yunfei']+=$c['yunfei'];
			$shu['jifendikou']+=$c['jifendikou'];	
			$shu['jifendikou_e']+=$c['jifendikou']/intval($jifenzhuanhua);
		}		
		
	
		return $shu;
    } 
    
    public function FenDan($gouwuche,$dizhiid){
    	global $_W;    	
    	if(empty($gouwuche)){
    		json('订单为空',-2);
    	}	
	   	foreach($gouwuche as $l){
    		$sh[$l['shanghu']]['shangpin'][]=$l;    		
    	}
    	
		$zhekou = Cha('select a.*,b.zhekou from'.BM('zw_shangcheng_huiyuan').' a,'.BM('zw_shangcheng_fenxiao_dengji').' b where a.fenxiaodengji=b.id and a.hyid='.$_W['huiyuan']['id']);
    
    	$hy=Qu('zw_shangcheng_huiyuan',array('hyid'=>$_W['huiyuan']['id']));
    	
    	$dizhi=Qu('zw_shangcheng_dizhi',array('id'=>$dizhiid));
    	
    	
    	$array=explode(' ', $dizhi['shengshiqu']);
    	
    	$di=$array[0].' '.$array[1];
    	
   
    	foreach($sh as $shid=>$c){ 
    		$a= $c['shangpin'];  	
	        $yunfei=0;	     
	        foreach($a as $x=>$b){        	
	        	$shijia=$b['jiage']*$b['shuliang'];   	
	        	$sh[$shid]['shijia']+=$shijia;
	        	$yingxiao=ZiFuChuan_Zhuan_ShuZu($b['yingxiao']);			
		        $sh[$shid]['jifendikou']+=intval($yingxiao['jifen']);         	
		        $pianyuan=0;
		        if($yingxiao['diqu']){      
			        if(array_search($di,$yingxiao['diqu'])){
			        		$pianyuan=1;
			        }			        
		        }		        
		       	if($pianyuan==1){
		       		$y=Qu('zw_shangcheng_kuaidi',array('id'=>$yingxiao['pianyuan']));
		       		if($y){
		       			$xzj=$b['zhongliang']*$b['shuliang']-$y['shouzhong'];
			            $yunfei+=$y['shoujia'];
			            if($xzj>0){          
							$yunfei+=(intval($xzj/$y['xuzhong'])+1)*$y['xujia'];
			            }
		       		}else{
		       			 $yunfei+=0;
		       		}
		       		
		       	}else{
		       		$y=Qu('zw_shangcheng_kuaidi',array('id'=>$yingxiao['changgui']));
		       		
		       		if($yingxiao['danpinman_e']<=$shijia && $yingxiao['danpinman_e']>0){
		       			 $yunfei+=0;
		       		}else{
		       			if($y){
			       			$xzj=$b['zhongliang']*$b['shuliang']-$y['shouzhong'];
				            $yunfei+=$y['shoujia'];
				            if($xzj>0){          
								$yunfei+=(intval($xzj/$y['xuzhong'])+1)*$y['xujia'];
				            }
		       			}else{
		       				 $yunfei+=0;
		       			}
		       			
		       		}
		       		
		       	}
		        

	    	
	        	$sh[$shid]['yunfei']=$yunfei;
	        }
//			$zhekoujiage=$sh[$shid]['zongjia'];
//			if($zhekou['zhekou']){
//		        $sh[$shid]['zongjia']=($sh[$shid]['shijia']*($zhekou['zhekou']/10))+$yunfei;
//				$sh[$shid]['zhekou']=$sh[$shid]['zongjia']-$zhekoujiage;
//			}else{
		        $sh[$shid]['zongjia']=$sh[$shid]['shijia']+$yunfei;
//			}

	        $shanghuming=Qu('he_shanghu',array('id'=>$shid),'ming,hyid');	 
	        $sh[$shid]['shanghuming']=empty($shanghuming)?'自营':$shanghuming['ming']; 
	        $sh[$shid]['shanghu']= $shid;  
					$sh[$shid]['huiyuan']= $shanghuming['huiyuan']; 

	    }    	
	    return 	$sh;
	}
    public function JianKuCun($shangpin,$shuliang,$guige,$fangshi){
    	$jk=$this->ZhiGou($shangpin,$shuliang,$guige);
    	$kucun=$jk['gouwuchelie'][0]['kucun'];    	
    	$kc=intval($kucun)-$shuliang;
    	if($kc<0 && $jk['gouwuchelie'][0]['jiankucun']==2){
    		$kc=0;    		
    	}    	
    	if($kc>=0 && $jk['gouwuchelie'][0]['jiankucun']==$fangshi){    		
    		if($guige>0){
    			Gai('zw_shangcheng_shangpin_guige_xuanze',array('guige_xuanze_kucun'=>$kc),array('id'=>$guige));    			
    		}else{
    			Gai('zw_shangcheng_shangpin',array('kucun'=>$kc),array('id'=>$shangpin)); 
    		}
    		return true;
    	}elseif($kc>=0){
    		return true;    		
    	}   	
    	return false;
    }
    public function isKuCun($dingdanid){
    	$is=false;
    	$ddsp=$this->quDingDanShangpin($dingdanid);
    	foreach($ddsp as $d){
    		if($d['kucun']<$d['shuliang'] && $d['jiankucun']==2){
    			$is=$d;
    			break;
    		}   		
    	}
    	return $is;   	
    }
    public function quDingDan($id,$wei='yiweishuzu'){    
    	if($wei=='yiweishuzu'){
    		$dingdan=$this->DingDanYiWeiShuZu($id);
    	}else{
    		$dingdan=$this->DingDanErWeiShuZu($id);
    	}    	    	
    	return $dingdan;
    }
    public function DingDanYiWeiShuZu($id){
    	global $_W;    	
    	$sql="select d.*,ds.ming,ds.shangpin,ds.jiage,ds.shuliang,ds.guige,d.yongjin from ".BM('zw_shangcheng_dingdan').' d left join '.BM('zw_shangcheng_dingdan_shangpin').' ds on d.id=ds.dingdanid';
    	$sql.=" where d.danyuan=:danyuan and d.id=:id ";
    	$tianjian=array(':danyuan'=>$_W['danyuan'],':id'=>$id);    	
    	$dd=ChaQuan($sql,$tianjian);     
    	foreach($dd as $k=>$d){
    		$sp=$this->quShangPin($d['shangpin'],'tu,yuanjia,yu_e_zhifu');
    		$dd[$k]['yu_e_zhifu']=$sp['yu_e_zhifu'];
    		if($d['guige']){
    			$guige=Cha('select * from '.BM('zw_shangcheng_shangpin_guige_xuanze').' where id='.$d['guige']);
    		    $dd[$k]['guige']=$guige;    		   
    			$xuanze=explode('_',$guige['guige_xuanze_id']);
    			$tu=Cha('select guige_tu from '.BM('zw_shangcheng_shangpin_guige').' where guige_id="'.$xuanze[0].'"');
    		    $dd[$k]['tu']=JueDuiUrl($tu['guige_tu']);    		  
			    $dd[$k]['yuanjia']=$guige['guige_xuanze_yuanjia'];	    		    
    		}else{    			
    			$dd[$k]['tu']=JueDuiUrl($sp['tu']);
    			$dd[$k]['yuanjia']=$sp['yuanjia'];	
    		}
    	}    	
    	return $dd;
    }
    public function DingDanErWeiShuZu($id,$ziduan='*'){
    	global $_W;   	
    	if(intval($id)){    		
    		$tj=' and id='.$id;    	
    	} else{
    		$tj=' and dingdanhao="'.$id.'"';    		
    	}       
        $dd=Cha('select '.$ziduan.' from '.BM('zw_shangcheng_dingdan').' where danyuan='.$_W['danyuan'].$tj);   
        $dd['dingdan_shangpin']=$this->quDingDanShangpin($id);  
    	$dd['zhuangtai_wenzi']=$this->zhuangtai_wenzi[$dd['zhuangtai']];    
    	$dd['zhifushijian']=date('Y-m-d H:i:s',$dd['zhifushijian']);
    	$dd['xiadanshijian']=date('Y-m-d H:i:s',$dd['xiadanshijian']);
    	$dd['huiyuanzhi']=Cha('select * from '.BM('he_huiyuan').' where id='.$dd['huiyuan']);
    	
    	
    	
    	return $dd;
    }
    public function quDingDanShangpin($dingdanid,$ziduan=''){
    	$ziduan=empty($ziduan)?'ds.id,ds.ming,ds.shangpin,ds.jiage,ds.shuliang,ds.guige,ds.jifendikou,gg.guige_xuanze_id,gg.guige_xuanze_yuanjia,gg.guige_xuanze_zhongliang,gg.guige_xuanze_kucun,sp.tu,sp.yuanjia,sp.zhongliang,sp.kucun,sp.jiankucun,sp.zhuangtai':$ziduan;
    	$sql="select ".$ziduan." from ".BM('zw_shangcheng_dingdan_shangpin'); 
    	$sql.=' ds left join '.BM('zw_shangcheng_shangpin_guige_xuanze').' gg on ds.guige=gg.id left join '.BM('zw_shangcheng_shangpin').' sp on sp.id=ds.shangpin';    	
    	if(intval($dingdanid)){
    		$sql.=' where ds.dingdanid='.$dingdanid;
    	}else{
    	   $sql.=' where ds.dingdanhao="'.$dingdanid.'"' ;	
    	}    	    	
    	$ds=ChaQuan($sql);
    	foreach($ds as $k=>$d){   
    		$ds[$k]['tu']=JueDuiUrl($d['tu']);      
    		if($d['guige']){
    			$xuanze=explode('_',$d['guige_xuanze_id']);
    			$tu=Cha('select guige_tu from '.BM('zw_shangcheng_shangpin_guige').' where guige_id="'.$xuanze[0].'"');
    			if($tu['guige_tu']){
    				 $ds[$k]['tu']=JueDuiUrl($tu['guige_tu']);   				
    			}    		    		  
			    $ds[$k]['yuanjia']=$d['guige_xuanze_yuanjia'];
			    $ds[$k]['zhongliang']=$d['guige_xuanze_zhongliang'];	
			    $ds[$k]['kucun']=$d['guige_xuanze_kucun'];		  
    		} 
    				   
    		unset($ds[$k]['guige_xuanze_yuanjia'],$ds[$k]['guige_xuanze_id'],$ds[$k]['guige_xuanze_zhongliang'],$ds[$k]['guige_xuanze_kucun'],$tu);
    	
    	}

    	return $ds;
    }   
    public function quDingDanLie($DangQianYe=1,$quTiaoShu=10,$tiaojian=array()){
    	global $_W;
    	$zhuangtai_wenzi=$this->zhuangtai_wenzi;   	
    	$tj='danyuan='.$_W['danyuan'];
    	foreach($tiaojian as $k=>$t){
    		if(is_numeric($t)){
    		    $tj.=' and '.$k.'='.$t;
    		}elseif(is_array($t)){
				$tj.=" and ".$t[0];    			
    		}else{
    		    $tj.=' and '.$k.'="'.$t.'"';
    		}    		
    	}   
    	$dingdan_sql="select * from ".BM('zw_shangcheng_dingdan').' where '.$tj.' order by xiadanshijian DESC';   	
    	$dingdan_sql.=' Limit '. ($DangQianYe - 1) * $quTiaoShu . ',' . $quTiaoShu;	     
    	$dingdan=ChaQuan($dingdan_sql);   	 
    	if(empty($dingdan)){
    			return false;
    	}	   
    	$zongshu=ChaZongShu("select count(*) from ".BM('zw_shangcheng_dingdan').' where '.$tj); 
    	$zong_e=ChaZongShu("select sum(zongjia) from ".BM('zw_shangcheng_dingdan').' where '.$tj);      	  	
    	foreach($dingdan as $dk=>$d){  
    		    if($d['zhuangtai']<6){ 		
    			    $dd[$d['dingdanhao']]=$d; 
    			}else{
    				 $dd[$dk+1]=$d; 
    			}    			  		
    	}      	
    	unset($dingdan);
    	foreach($dd as $dk=>$d){     		 		    		
    		if(is_numeric($dk)){
    			$TJ=' dingdanid='.$d['id'];
    		}else{
    			$dd[$dk]=Qu('zw_shangcheng_dingdan_jichu',array('dingdanhao'=>$d['dingdanhao']));
    			$dd[$dk]['id']=$d['dingdanhao'];
    			$TJ=' dingdanhao="'.$d['dingdanhao'].'"';
    		}
    		$dd[$dk]['peisong_wenzi']=empty($d['peisong'])?'快递配送':'到店自提';
    		$dd[$dk]['zhuangtai_wenzi']=$zhuangtai_wenzi[intval($d['zhuangtai'])]; 
    		$dd[$dk]['zhuangtai']=intval($d['zhuangtai']); 
    		$dd[$dk]['zhifuqudao']=$this->zhifuqudao[$d['zhifuqudao']]; 
    		$dingdan_shangpin=ChaQuan("select * from ".BM('zw_shangcheng_dingdan_shangpin').' where'.$TJ);  		
    		
    		$zs=0;
    		foreach($dingdan_shangpin as $k=>$ds){    			
	    		if($ds['guige']){
	    			$guige=Cha('select * from '.BM('zw_shangcheng_shangpin_guige_xuanze').' where id='.$ds['guige']);
	    		    //$dingdan_shangpin[$k]['guige']=$guige;    		   
	    			$xuanze=explode('_',$guige['guige_xuanze_id']);
	    			$tu=Cha('select guige_tu from '.BM('zw_shangcheng_shangpin_guige').' where guige_id="'.$xuanze[0].'"');
	    		    $dingdan_shangpin[$k]['tu']=JueDuiUrl($tu['guige_tu']);    		  
				    $dingdan_shangpin[$k]['yuanjia']=$guige['guige_xuanze_yuanjia'];	    		    
	    		}
	    		if(empty($dingdan_shangpin[$k]['tu'])){
	    			$tu=$this->quShangPin($ds['shangpin'],'tu,yuanjia');	    			
	    			$dingdan_shangpin[$k]['tu']=JueDuiUrl($tu['tu']);
	    			$dingdan_shangpin[$k]['yuanjia']=$tu['yuanjia'];	
	    		}
	    		$zs+=$ds['shuliang'];
    	    } 
    	    $dd[$dk]['dingdan_shangpin']=$dingdan_shangpin;    	    
    	    
    	   $dd[$dk]['zongshu']=$zs;	
    	   
    	    $lie[]=$dd[$dk];     	        		
    	}  	
    	unset($dd);   	   
    	return array('dingdan'=>$lie,'zongshu'=>$zongshu,'zong_e'=>$zong_e);
    	
    }
    public function gaiDingDanZhuangTai($shu=array(),$tiaojian=array(),$liyou=''){
    	global $_W;    		
    	$shuju=array();
    	$shijian=time();
    	if(is_array($shu)){
    		$zhuangtai=$shu['zhuangtai'];    	
    		foreach($shu as $k=>$z){
    		    $shuju[$k]=$z;
    	   	}    	
    	}else{
    		$zhuangtai=$shu; 
    	}
    	$zt=array(
    	      'daifu'=>array('zhuangtai'=>'0'),
    	      'quxiao'=>array('zhuangtai'=>5),
    	      'tuikuan'=>array('zhuangtai'=>6),
    	      'yituikuan'=>array('zhuangtai'=>7),
    	      'fukuan'=>array('zhuangtai'=>10,'zhifushijian'=>$shijian),
    	      'jujuetuikuan'=>array('zhuangtai'=>10),
    	      'tuihuo'=>array('zhuangtai'=>15), 
    	      'fahuo'=>array('zhuangtai'=>20,'fahuoshijian'=>$shijian),  
    	      'hexiao'=>array('zhuangtai'=>30,'wanchengshijian'=>$shijian,'fahuoshijian'=>$shijian),   	         
    	      'shouhuo'=>array('zhuangtai'=>30,'wanchengshijian'=>$shijian),    	      	      
    	      'pinglun'=>array('zhuangtai'=>40)
    	); 
    	
    	
    	
    	
    	if(empty($tiaojian) || empty($zt[$zhuangtai]) || empty($tiaojian['id'])){    		
    		return false;
    	}       
    	foreach($zt[$zhuangtai] as $k=>$z){
    		$shuju[$k]=$z;
    	}  
			

        $tiaojian['danyuan']=$_W['danyuan'];       
        if($tiaojian['id']>0){
        	 $dd=Qu('zw_shangcheng_dingdan',$tiaojian); 
        }else{        	
        	$tiaojian['dingdanhao']=$tiaojian['id'];   
        	unset($tiaojian['id']);     	
        	$dd=Qu('zw_shangcheng_dingdan_jichu',$tiaojian); 
        }        
     
        if(empty($dd)){
        	return false;
        } 
        
        
        if($zhuangtai=='jujuetuikuan'){
       		//$jiudan=Qu('zw_shangcheng_dingdan',array('dingdanhao'=>$dd['dingdanhao']));
       		$shuju['zhuangtai']=(floatval($dd['zhuangtai'])-6)*100;      		
       		MX('api')->JuJueTuiKuanTiXing($dd);
       		
       }
       
        if($shuju['zhuangtai']==5){
        	ShanChu('he_huiyuan_yongjin',array('dingdanhao'=>$dd['dingdanhao']));
        	ShanChu('he_huiyuan_liquan',array('dingdanhao'=>$dd['dingdanhao']));
        	ShanChu('he_huiyuan_jifen',array('dingdanhao'=>$dd['dingdanhao']));
        	ShanChu('he_huiyuan_xunzhang',array('dingdanhao'=>$dd['dingdanhao']));  
        	        					
        } 
         
        if($shuju['zhuangtai']==6){
        	$shuju['liyou']=$liyou;
        	
        	$jiudan=Qu('zw_shangcheng_dingdan',array('dingdanhao'=>$dd['dingdanhao']));
        	$shuju['zhuangtai']=6+($jiudan['zhuangtai']/100);
        	
        	$dingsp=ChaQuan('select * from '.BM('zw_shangcheng_dingdan_shangpin').' where dingdanhao="'.$dd['dingdanhao'].'"');
        	foreach($dingsp as $dins){
        		  $dd['shangpin_ming'].=$dins['ming'].'x'.$dins['shuliang'].$dins['danwei'].' ';
        	}
        	MX('api')->TuiKuanTiXing($dd);
        	
        }
//      if($shuju['zhuangtai']==7 && $dd['zhuangtai']==15){
//      	$songliquan=ChaZongShu('select sum(ddsp.songliquan*ddsp.shuliang) from '.BM('zw_shangcheng_dingdan_shangpin').' ddsp left join '.BM('zw_shangcheng_dingdan_jichu').' dd on dd.dingdanhao=ddsp.dingdanhao  where ddsp.dingdanhao="'.$dd['dingdanhao'].'" and dd.zhuangtai=15');
//	    	if($songliquan>0){
//	    	   MX('huiyuan','he')->BiZong_JiaJian('liquan',$dd['huiyuan'],-$songliquan,'订单退换货',$dd['dingdanhao']);	
//	    	}
//	    	$songjifen=ChaZongShu('select sum(ddsp.songjifen*ddsp.shuliang) from '.BM('zw_shangcheng_dingdan_shangpin').' ddsp left join '.BM('zw_shangcheng_dingdan_jichu').' dd on dd.dingdanhao=ddsp.dingdanhao where ddsp.dingdanhao="'.$dd['dingdanhao'].'" and dd.zhuangtai=15');
//	    	if($songjifen>0){
//	    	   MX('huiyuan','he')->gai_jifen($dd['huiyuan'],-$songjifen,'订单退换货');	
//	    	} 
//      }
        if($shuju['zhuangtai']==15){
        	$shuju['liyou']=$liyou;
        }
      

        Gai('zw_shangcheng_dingdan_jichu',$shuju,array('dingdanhao'=>$dd['dingdanhao']));
        Gai('zw_shangcheng_dingdan',$shuju,$tiaojian);    
						 
						 
						 
        $dd['url']=UAK('dingdan/dingdanxiangqing',array('id'=>$dd['id']));     
        if($shuju['zhuangtai']==10){   
						Gai('he_huiyuan_yongjin',array('zhuangtai'=>0),array('dingdanhao'=>$dd['dingdanhao']));
						Gai('he_huiyuan_liquan',array('zhuangtai'=>0),array('dingdanhao'=>$dd['dingdanhao']));
						Gai('he_huiyuan_jifen',array('zhuangtai'=>0),array('dingdanhao'=>$dd['dingdanhao']));      	          	
						$this->ShengJiDengJi($dd['dingdanhao']);	
						$this->ZhiFuJianKuCun($dd['dingdanhao']);
        	 //提醒     
    		    $dd['shijian']=$shijian;    				
            MX('api')->FuKuanTiXing($dd);
        }elseif($shuju['zhuangtai']==15){        	
          	//提醒     
    		    $dd['shijian']=$shijian;    				
            MX('api')->TuiHouTiXing($dd);             
        }elseif($shuju['zhuangtai']==20){       	
        	$dd['kuaidihao']=$shuju['kuaidihao'];
        	$dd['kuaidiming']=$shuju['kuaidiming'];
        	MX('api')->FaHuoTiXing($dd); 
        }elseif($shuju['zhuangtai']==30){        	
						$dd['wanchengshijian']=$shuju['wanchengshijian'];        	
						if($dd['zhuangtai']==15){
							MX('api')->TuiHouJieGuoTiXing($dd);	
						}else{
							MX('api')->ShouHuoTiXing($dd);	
						}
        	
						Gai('he_huiyuan_yongjin',array('zhuangtai'=>1),array('dingdanhao'=>$dd['dingdanhao']));
						Gai('he_huiyuan_liquan',array('zhuangtai'=>1),array('dingdanhao'=>$dd['dingdanhao']));
						Gai('he_huiyuan_jifen',array('zhuangtai'=>1),array('dingdanhao'=>$dd['dingdanhao']));
						if($dd['leixing']==1){
							Gai('zw_shangcheng_huiyuan',array('huiyuandengji'=>0),array('hyid'=>$dd['huiyuan']));
							$dingsp=ChaQuan('select * from '.BM('zw_shangcheng_dingdan_shangpin').' where dingdanhao="'.$dd['dingdanhao'].'"');
						
							foreach($dingsp as $dins){
								if($dins['shengji']==1){
									$fuid=MX('huiyuan','he')->qu_huiyuan($dd['huiyuan'],'fuji_id');   
									$fuji=MX('moshi_chaoshi')->quFuji($fuid['fuji_id']); 
									foreach($fuji as $f){
										MX('moshi_chaoshi')->ShengJi($f['id']);
									}
								}  
							}
						
						}
        }
        if($shuju['zhuangtai']==7){        	
        	if($dd['zhifuqudao']=='yu_e'){						   
						   MX('huiyuan','he')->TuiBi('yongjin',$dd['huiyuan'],'订单退款',$dd['dingdanhao']);	        	
        	}elseif($dd['zhifuqudao']=='weixin'){
        		  MX('zhifu','he')->TuiKuan($dd);
        	}elseif($dd['zhifuqudao']=='jifen'){
        		  MX('huiyuan','he')->TuiBi('jifen',$dd['huiyuan'],'订单退款',$dd['dingdanhao']);	       		 
        	} 	
          Shanchu('he_huiyuan_yongjin',array('dingdanhao'=>$dd['dingdanhao'],'zhuangtai'=>0)); 
          Shanchu('he_huiyuan_jifen',array('dingdanhao'=>$dd['dingdanhao'],'zhuangtai'=>0)); 
        } 									 
	   
    	return 1;
    }    

    public function ZhiFuYiBuFanHui($shu='',$qudao=''){
    	global $_W;  				
		
    	$sql='select id,zongjia,zhuangtai,jifendikou,huiyuan,dingdanhao,leixing from '.BM('zw_shangcheng_dingdan_jichu').' where danyuan=:danyuan and dingdanhao=:dingdanhao and zhuangtai=0';    	
    	$tianjian=array(':danyuan'=>$_W['danyuan'],':dingdanhao'=>$shu['dingdanhao']); 
    	$dingdan=Cha($sql,$tianjian);    
		
    	if($dingdan['zongjia']==$shu['zongjia'] && empty($dingdan['zhuangtai'])  && $dingdan){    		 		
    		$dd=array('zhuangtai'=>10,'zhifushijian'=>SHIJIAN,'zhifuqudao'=>$qudao,'jiaoyihao'=>$shu['jiaoyihao']);    		
    		$gai=Gai('zw_shangcheng_dingdan_jichu',$dd,array('id'=>$dingdan['id']));
    		$gai=Gai('zw_shangcheng_dingdan',$dd,array('dingdanhao'=>$shu['dingdanhao']));	
					
					
			  Gai('he_huiyuan_yongjin',array('zhuangtai'=>0),array('dingdanhao'=>$shu['dingdanhao']));			
		  	Gai('he_huiyuan_jifen',array('zhuangtai'=>0),array('dingdanhao'=>$shu['dingdanhao']));       		     		   		   		
    		$this->ShengJiDengJi($shu['dingdanhao']);
    		$this->ZhiFuJianKuCun($shu['dingdanhao'],$dingdan['huiyuan']);        
    		//提醒     
    		$dingdan['shijian']=$dd['zhifushijian'];    	
    		MX('api')->FuKuanTiXing($dingdan);              
    		return $gai;    		      		  
    	}
    	return false;
    }
    public function ZhiFuJianKuCun($dingdanhao='',$huiyuan=''){    
    	if(empty($dingdanhao)){
    		return false;    		 
    	}
    	$dingdan_shangpin=ChaQuan('select shangpin,shuliang,guige,ming from '.BM('zw_shangcheng_dingdan_shangpin').' where dingdanhao="'.$dingdanhao.'"');
		if($dingdan_shangpin){			
			foreach($dingdan_shangpin as $lie){			
			    $sp=Qu('zw_shangcheng_shangpin',array('id'=>$lie['shangpin'],'jiankucun'=>2),'kucun');			   
			    $k=$sp['kucun']-$lie['shuliang']; 
			    $g="chushoushu=chushoushu+".$lie['shuliang'];
			    if($k>=0){
			    	 $g.=',kucun='.$k;			    
			    }			   
			   	Gai('zw_shangcheng_shangpin',$g,array('id'=>$lie['shangpin']));			   	
			}
		} 
		return true;   			
    }   
    public function ShengJiDengJi($dingdanhao=Null){   		
    	if(empty($dingdanhao)){
    		return false;
    	}
    	$ddsp=Cha('select dd.dingdanid,sp.fenxiaodengji,sp.huiyuandengji,dd.danyuan,dd.huiyuan from '.BM('zw_shangcheng_dingdan_shangpin').' dd left join '.BM('zw_shangcheng_shangpin').' sp on sp.id=dd.shangpin where (sp.fenxiaodengji>0 or sp.leixing=2) and dd.dingdanhao="'.$dingdanhao.'"');
    	if(empty($ddsp)){
    		return false;
    	}
    	$shu=array();
    	$shijian=time();    	    		
		if($ddsp['fenxiaodengji']){
			$shu['fenxiaodengji']=$ddsp['fenxiaodengji'];
			$shu['fenxiaozhuangtai']=1;
			$shu['fenxiaoshijian']=$shijian;
		}
		if($ddsp['huiyuandengji']){
		    $shu['huiyuandengji']=$ddsp['huiyuandengji'];
		}    	
    	$dd=array('zhuangtai'=>30,'fahuoshijian'=>$shijian,'wanchengshijian'=>$shijian);
    	$gai=Gai('zw_shangcheng_dingdan',$dd,array('id'=>$ddsp['dingdanid'])); 
    
    	if($shu){
    		$T=array('danyuan'=>$ddsp['danyuan'],'hyid'=>$ddsp['huiyuan']);
    		$g=Gai('zw_shangcheng_huiyuan',$shu,$T);
    	}   	
    	return $g;    	
    }
    public function FenXiaoPeiZhi(){
    	global $_W;
    	$jichu=Qu('zw_shangcheng_fenxiao_peizhi',array('danyuan'=>$_W['danyuan']),'jichupeizhi');
	    return ZiFuChuan_Zhuan_ShuZu($jichu['jichupeizhi']);	
    }
    public function FenXiaoDengJiLie(){
    	global $_W;
    	$lie=ChaQuan('select * from '.BM('zw_shangcheng_fenxiao_dengji').' where danyuan='.$_W['danyuan'].' order by paixu ASC,id ASC');
    	foreach($lie as $k=>$l){
    		$lie[$k]['cenji']=ZiFuChuan_Zhuan_ShuZu($l['cenji']);	
    		$lie[$k]['qita']=ZiFuChuan_Zhuan_ShuZu($l['qita']);	
    	}    	
    	return $lie;
    }
    public function FenXiaoDengJi($id=''){
    	$dj=Qu('zw_shangcheng_fenxiao_dengji',array('id'=>$id));
    	$dj['cenji']=ZiFuChuan_Zhuan_ShuZu($dj['cenji']);	
    	$dj['qita']=ZiFuChuan_Zhuan_ShuZu($dj['qita']);	
    	return $dj;
    }
    public function JiSuanYongJin($dingdan,$cengci=0){
    	global $_W;    
    	
    	if(empty($dingdan)){
    		return false;
    	}
    	if(empty($cengci)){
	     	$pz=$this->FenXiaoPeiZhi();
	        $cengci=$pz['cenji'];
	    } 	
	   
    	$fuid=MX('huiyuan','he')->qu_huiyuan($_W['huiyuan']['id'],'fuji_id');    	
		$fu=$this->quHuiYuanFuji($fuid['fuji_id'],$cengci,1); 		
    	if(empty($fu)){
            return false;
    	}  
    	$fy=array();        
    	foreach($dingdan as $dd){    			    			  			
    		if($dd['canyufenxiao'] && $dd['dulifenyong']>0){    			
    			foreach($fu as $k=>$f){
    				if($f['cenji'] && $dd['jiage']>0){     				
    					if($dd['duliyongjin']['bilie'][$k+1]>0){
    						$bili=$dd['duliyongjin']['bilie'][$k+1]/100;    					
    						$qian=$dd['jiage']*$bili*$dd['shuliang'];    				
    					}elseif($dd['duliyongjin']['guding'][$k+1]>0){
    						$qian=$dd['duliyongjin']['guding'][$k+1]*$dd['shuliang'];
    					}else{
    						$qian=0;
    					}   						  		
	    			    $fy['yongjin'][$f['id']]+=round($qian,2); 
	    			    if(empty($F[$f['id']])){	    			    	
	    			    	$F[$f['id']]=1;
	    			    	$fy['ids'].='_'.$f['id'].'_';  
	    			    }
    				}    				
    			}    			
    		}elseif($dd['canyufenxiao']){			
	    		foreach($fu as $k=>$f){
	    			if($f['cenji'] && $dd['jiage']>0){    					
	    			    $qian=$dd['jiage']*$dd['shuliang']*$f['cenji'][$k+1]['bilie']/100;				
	    			    $fy['yongjin'][$f['id']]+=round($qian,2);  
	    			     if(empty($F[$f['id']])){	    			    	
	    			    	$F[$f['id']]=1;
	    			    	$fy['ids'].='_'.$f['id'].'_';  
	    			    }
	    			}    			
	    		}
    		}    		
    	}         
    	$fy['yongjin']=ShuZu_Zhuan_ZiFuChuan($fy['yongjin']);    	 
    	return $fy;
    }    
    static public function quHuiYuanFuji($fuid,$cengci=0,$zhuangtai=''){     	
        if(empty($fuid)){
        	return array();
        }        
    	if(empty($cengci)){
	     	$pz=MX('moxing','zw_shangcheng')->FenXiaoPeiZhi();
	        $cengci=$pz['cenji'];
	    }
    	$shifenxiaoshang='';
    	if($zhuangtai){
    		$shifenxiaoshang=' and gh.fenxiaozhuangtai='.$zhuangtai;
    	}    	
    	$hy=Cha('select h.id,h.fuji_id,h.nicheng,gfd.ming,gfd.cenji from '.BM('he_huiyuan').' h left join '.BM('zw_shangcheng_huiyuan').' gh on h.id=gh.hyid left join '.BM('zw_shangcheng_fenxiao_dengji').' gfd on gh.fenxiaodengji=gfd.id where h.id='.$fuid.$shifenxiaoshang ); 

       	$arr=array();
    	if($hy && $cengci>0){
    		$arr[$cengci]['id']=$hy['id'];
    		$arr[$cengci]['ming']=$hy['nicheng'];
    		$arr[$cengci]['dengjiming']=$hy['ming'];
    		$arr[$cengci]['cenji']=ZiFuChuan_Zhuan_ShuZu($hy['cenji']);    		
    		$cengci--;    		   		
    		$arr=array_merge($arr,self::quHuiYuanFuji($hy['fuji_id'],$cenji,$zhuangtai));
    	}
    	return $arr;
    }
    public function FenXiaoYongJin($huiyuanid=Null){
    	global $_W;
    	if(empty($huiyuanid)){
    		$huiyuanid=$_W['huiyuan']['id'];
    	}
    	$yj=ChaQuan('select id,yongjin,zhuangtai,wanchengshijian from '.BM('zw_shangcheng_dingdan').' where danyuan='.$_W['danyuan'].' and zhuangtai>=10 and dailiren like "%_'.$huiyuanid.'_%"');
    	$y=array();
    	$y['zong_e']=0.00;
    	$y['ketixian']=0.00;
    	$shijian=time();  
    	$pz=MX('moxing','zw_shangcheng')->FenXiaoPeiZhi();
        if(empty($pz['jiesuantian'])){
        	$pz['jiesuantian']=0;
        }
             
    	foreach($yj as $j){
    		$j['yongjin']=ZiFuChuan_Zhuan_ShuZu($j['yongjin']);
    		$y['zong_e']+=round($j['yongjin'][$huiyuanid],2);    		
    		$wanchengshijian=empty($j['wanchengshijian'])?$shijian:$j['wanchengshijian'];
    		$sj=$shijian-$wanchengshijian;    				
    		$jiesuan=86400*$pz['jiesuantian'];    		
    		if($j['zhuangtai']>=30 && empty($j['yongjin']['zhuangtai'.$huiyuanid]) && $sj>=$jiesuan){
    		   $y['ketixian']+=round($j['yongjin'][$huiyuanid],2);	
    		}
    	}     	 	
    	
    	return $y;
    }
    static public function XiaXian($id,$cengci=1,$cc=0,$ShangHuoKe=1){
    	global $_W;    	
	     $arr=array();
	      
	     $where="h.fuji_id=".$id;
//	     if($ShangHuoKe){
//	     	$where.=' and gh.fenxiaozhuangtai=1';
//	     }else{
//	     	$where.=' and (gh.fenxiaozhuangtai=0 or gh.fenxiaozhuangtai is null)';
//	     }		
		 $huiyuan=ChaQuan('select h.id,h.touxiang,h.nicheng,h.zhanghao,h.shijian,h.fuji_id,gh.fenxiaodengji,gh.fenxiaoshijian,gh.fenxiaozhuangtai from '.BM('zw_shangcheng_huiyuan').' gh left join '.BM('he_huiyuan').' h on gh.hyid=h.id where '.$where.' order by gh.fenxiaoshijian DESC,gh.huiyuanshijian DESC');		 		 
		 if($huiyuan)foreach($huiyuan as $v){		 	
		    if($cengci>$cc || empty($cengci)){
			   $v['nicheng']=empty($v['nicheng'])?$v['zhanghao']:$v['nicheng'];
			   $v['nicheng']=empty($v['nicheng'])?'未知':$v['nicheng'];
			   $v['touxiang']=JueDuiUrl($v['touxiang']);   
			   $v['cengci']=$cc+1; 			   
			   $arr[]=$v;
			   $arr=array_merge($arr,self::XiaXian($v['id'],$cengci,$cc+1,$ShangHuoKe));	
		    }					
		}		 
	    return $arr;
	 }
	 public function KuaiDiLei(){	
	     global $_W; 
		 $TJ='danyuan='.$_W['danyuan'];
		 if($_W['shanghu']['id']){
		 	$TJ.=' and shanghu = '.$_W['shanghu']['id'];
		 }   	 
	 	 $kuaidi=ChaQuan('select * from '.BM('zw_shangcheng_kuaidi').' where '.$TJ.' order by id ASC');
	 	 return  $kuaidi;
	 }
	 public function QuanLie($DangQianYe=1,$quTiaoShu = 10,$tiaojian=''){
	 	global $_W; 	 	   
	    $tj='danyuan='.$_W['danyuan'];
	    if($tiaojian){
	    	$tj.=' and '.$tiaojian;
	    }
	    $sql="select * from ".BM('zw_shangcheng_quan')." where {$tj} order by shijian
	     DESC Limit ".($DangQianYe - 1) * $quTiaoShu.','.$quTiaoShu;  
	    $juan=ChaQuan($sql);  
	    return $juan;
	}
	
	
	public function ChuangJianDingDan($gwl='',$dingdanhao='',$dizhi=''){
		global $_W;
		  $dingdan = array(
	        'danyuan' => $_W['danyuan'],
	        'huiyuan' => $_W['huiyuan']['id'],
	        'dingdanhao' => $dingdanhao,
	        'shijia' => $gwl['zongjia'] - $gwl['yunfei'],
//	        'zongjia' => $gwl['zongjia']-$gwl['jifendikou']-$gwl['quan_e'],
	        'jifendikou'=>$gwl['jifendikou'],
	        'quan_e'=>$gwl['quan_e'],
	        'yunfei' => $gwl['yunfei'],
	        'dizhiid' => $dizhi['id'],
	        'shouhuoren' => $dizhi['ming'],
	        'shouhuodianhua' => $dizhi['dianhua'],
	        'shouhuoshengshiqu' => $dizhi['shengshiqu'],
	        'shouhuodizhi' => $dizhi['dizhi'],
	        'shanghu'=>$gwl['shanghu'],
	        'xiadanshijian' => SHIJIAN,    
	        'peisong'=>$dizhi['peisongfangshi'],    
	        'zhuangtai' => 0,
	        'zhekou'=>$gwl['zhekou'],
	        'liuyan'=>$gwl['liuyan'],
	        'leixing'=>$gwl['leixing']
	    );   
		
		
		if($gwl['jifen']==1){
			$dingdan['jifendikou_e']=$dingdan['jifendikou']/intval($_W['shezhi']['jiaoyi']['jifenzhuanhua']);
			$dingdan['zongjia']=$gwl['zongjia']-$dingdan['jifendikou_e']-$gwl['quan_e'];
		}else{
			$dingdan['zongjia']=$gwl['zongjia']-$gwl['quan_e'];
			$dingdan['jifendikou_e']=0;
		}
		

	    ChaRu('zw_shangcheng_dingdan', $dingdan);
	    $dingdanid = ChaRuID();	  
	    foreach ($gwl['shangpin'] as $lie){
	        $dingdan_shangpin = array();
	        $dingdan_shangpin['dingdanid'] = $dingdanid;
	        $dingdan_shangpin['danyuan'] = $_W['danyuan'];
	        $dingdan_shangpin['huiyuan'] = $_W['huiyuan']['id'];
	        $dingdan_shangpin['dingdanhao'] = $dingdanhao;
	        $dingdan_shangpin['shangpin'] = $lie['shangpin'];
	        $dingdan_shangpin['ming'] = $lie['ming'];
	        $dingdan_shangpin['jiage'] = $lie['jiage'];
	        $dingdan_shangpin['shuliang'] = $lie['shuliang'];
	        $dingdan_shangpin['zhekou'] = $lie['zhekou'];
	        $dingdan_shangpin['songjifen'] = $lie['jifen'];
					
					$jifen+= $lie['jifen']*$lie['shuliang'];
	        $dingdan_shangpin['songyu_e'] = $lie['yu_e'];
	        $dingdan_shangpin['guige'] = $lie['guige'];
	        $dingdan_shangpin['yunfei'] = $lie['yunfei'];
	        
	        $dingdan_shangpin['liquan'] = $lie['liquan'];
	        $dingdan_shangpin['xunzhang'] = $lie['xunzhang'];
	        $dingdan_shangpin['jifenkou'] = $lie['jifenkou'];
	        $dingdan_shangpin['jifenman'] = $lie['jifenman'];
	        $dingdan_shangpin['songliquan'] = $lie['songliquan'];	        
	        $dingdan_shangpin['fahuoshijian'] = $lie['fahuoshijian'];
	        
	        if(intval($_J['isJiFenDiKou'])){  
	            $dingdan_shangpin['jifendikou'] =$lie['jifendikou'];  
	        }    
	        ChaRu('zw_shangcheng_dingdan_shangpin', $dingdan_shangpin);        
	        $TiXing['shangpin_ming'].=$lie['ming'].'x'.$lie['shuliang'].$lie['danwei'].' ';	 
	        if($lie['jifen']>0){
	        	MX('huiyuan','he')->BiZong_JiaJian('jifen',$_W['huiyuan']['id'],$lie['jifen']*$lie['shuliang'],'购物赠送和券',$dingdanhao,-1,'song');						
	        }			        
	    }
			$shanghu=Qu('he_shanghu',array('id'=>$dingdan['shanghu'],'zhuangtai'=>1),'hyid');				
			$jin_e=$dingdan['zongjia']-$jifen;		
			if($jin_e>0){				 
				  MX('huiyuan','he')->BiZong_JiaJian('yongjin',$shanghu['hyid'],$jin_e,"顾客消费".$dingdan['zongjia']."元赠出和券".$jifen,$dingdanhao,-1,'zengchu');
			}			
	    return $TiXing;
	}


   public function MaiZiGe($shu){		
	    $shangji=Qu('he_huiyuan',array('id'=>$shu['hyid']),'fuji_id');		          
		$fu=$this->quHuiYuanFuji($shangji['fuji_id'],1);		     				
        foreach($fu as $k=>$f){
			if($f['cenji'] && $shu['jin_e']>0){    					
			    $qian=round($shu['jin_e']*$f['cenji'][$k+1]['bilie']/100,2);		    		  
			    MX('huiyuan','he')->BiZong_JiaJian('yongjin',$f['id'],$qian,'推荐人获得余额',$shu['dingdanhao']);
			}    			
		}   
		Gai('zw_shangcheng_huiyuan',array('fenxiaodengji'=>$shu['qita']['id'],'fenxiaozhuangtai'=>1,'fenxiaoshijian'=>SHIJIAN),array('hyid'=>$shu['hyid']));	
	}


	public function ZiDingYi($id){
		global $_W;
		if(is_array($id)){
			$tj=$id;
		}elseif(intval($id)>0){
			$tj['id']=$id;
		}else{
			$tj['leixing']=$id;
			$tj['zhuangtai']=1;
		}		
		$tj['danyuan']=$_W['danyuan'];		
	
		$zdy=Qu('zw_shangcheng_zidingyi',$tj);
		$zdy['shuju']=ZiFuChuan_Zhuan_ShuZu($zdy['shuju']);	
		if($zdy['shuju']){
			foreach($zdy['shuju'] as $k=>&$s){
				$zujian=explode('_',$k);				
				$s['zujian']=$zujian[0];			
			}
		}
		return $zdy;
	}
}

?>