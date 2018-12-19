<?php
/**
 * [商城开源系统] Copyright (c) 2014 ZhiWi.CN
 * 商城群QQ：628361862  进群下载更新包 交流技术   http://www.ZhiWi.cn/.
 */
Denglu(true);
$cao = empty($_J['c']) ? 'moren' : $_J['c'];
$tiaojian = array();
$biaoti = array("ming" => "");

if ($cao == 'moren') {
    $biaoti = array("ming" => "全部");
} 
if ($_W['ispost']) {
    $ye = max(1, $_J['ye']);
    $ziduan = "id,ming,fenlei_yiji,fenlei_erji,shunxu,danwei,xinpin,tuijian,cuxiao,baoyou,miaosha,kaishishijian,jieshushijian,tu,xijietu,jiage,yuanjia,kucun";
    $tiaojian[':zhuangtai']=1;    
    $tiaojian[':shanghu']=$_J['sh'];
    if($_J['paixu']){    	
    	$paixu=$_J['paixu'];
    }else{
    	$paixu='shunxu DESC,shijian DESC';
    }
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
    $shangpinlie = MX()->quQuanShangPin(6, $ye, $ziduan, $tiaojian,$paixu);
    foreach($shangpinlie as $k=>$s){
    	$shangpinlie[$k]['href']=UXK("xiangqing",array("id"=>$s["id"]));
    	$shangpinlie[$k]['tu']=JueDuiUrl($s["tu"]);   
    }
    $shu = array('shangpinlie' => $shangpinlie, 'biaoti' => $biaoti);
    if ($shangpinlie) {       
        json($shu);
    }  
    json($shu, 0);
}
mb('lie');
