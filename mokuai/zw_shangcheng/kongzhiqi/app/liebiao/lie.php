<?php

$tiaojian = array();
$biaoti = array("ming" => "");

if ($cao == 'moren') {
    $biaoti = array("ming" => "全部");
} 
if ($_W['ispost']) {
    $ye = max(1, $_J['ye']);
  	$_J['jitiao']=$_J['jitiao']?$_J['jitiao']:6;
    $ziduan = "id,ming,songliquan,danwei,xinpin,tuijian,chengben,cuxiao,baoyou,miaosha,kaishishijian,jieshushijian,tu,jiage,yuanjia,kucun,chushoushu";
    $tiaojian[':zhuangtai']=1;  
	  
	$paixu_zu=array('shunxu DESC,shijian DESC','chushoushu DESC','chushoushu ASC','shijian DESC','jiage DESC','jiage ASC'); 
  $_J['paixu']=intval($_J['paixu']);
	$paixu=$paixu_zu[$_J['paixu']];
	
    if($_J['id']>0){
    	$FL='(fenlei_yiji='.$_J['id'].' or fenlei_erji='.$_J['id'].')';
    	$tiaojian[':fenlei']=array($FL);    
    }
    $bq='';
    $bq.=$_J['xinpin']?'or xinpin=1 ':'';
    $bq.=$_J['tuijian']?'or tuijian=1 ':'';
    $bq.=$_J['cuxiao']?'or cuxiao=1 ':'';
    $bq.=$_J['baoyou']?'or baoyou=1 ':'';
    $bq.=$_J['miaosha']?'or miaosha=1 ':'';
    if(trim($bq)){
    	$bq=ltrim($bq,'or ');
    	$tiaojian[':biaoqian']=array('('.$bq.')'); 
    }
    if($_J['so']){
    	$tiaojian[':ming']=array('ming like "%'.trim($_J['so']).'%"');
    }      
    $shangpinlie = MX()->quQuanShangPin($_J['jitiao'], $ye, $ziduan, $tiaojian,$paixu);
    foreach($shangpinlie as $k=>$s){
    	$shangpinlie[$k]['href']=UAK("xiangqing",array("id"=>$s["id"]));
    	$shangpinlie[$k]['tu']=JueDuiUrl($s["tu"]);   
    }
    $shu = array('shangpinlie' => $shangpinlie, 'biaoti' => $biaoti);
    if ($shangpinlie) {        
        json($shu);
    }  
    json($shu, 0);
}
mb('lie');
