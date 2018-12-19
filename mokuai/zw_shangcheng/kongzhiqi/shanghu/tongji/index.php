<?php
/**
 * [商城开源系统] Copyright (c) 2014 ZhiWi.CN
 *  商城群QQ：628361862  进群下载更新包 交流技术   http://www.ZhiWi.cn/.
 */
DengLu();
$cao = empty($_J['c']) ? 'moren' : $_J['c'];

if ($cao == 'moren') {  
    $DangQianYe = max(1, $_J['page']);
    $quTiaoShu = 20;
    $sql = 'select  sp.dingdanhao "订单号",sp.shangpin "商品编号",sp.ming "商品名",sp.jiage "价格",sp.shuliang "数量",dd.zhifushijian "支付时间" from '.BM('zw_shangcheng_dingdan_shangpin').' as sp  left join '.BM('zw_shangcheng_dingdan').' as dd on sp.dingdanid=dd.id where dd.zhuangtai >=10 ';
    $tiaojian = ' and shanghu='.$_W['shanghu']['id'];    

    if ($_J['sousuo'] == 1) {
        $daystart = strtotime($_J['kaishi']);
        $dayend = strtotime($_J['jieshu']) + 24 * 60 * 60;
        if (!empty($daystart) && !empty($dayend)) {
            $tiaojian .= ' and  dd.zhifushijian between ' . $daystart . ' and ' . $dayend;
        }
    }
    if($_J['cho_Province']!=='请选择省份'  && !empty($_J['cho_Province'])){    	
	    	$shouhuoshengshiqu.=$_J['cho_Province'];
	    }
	    if($_J['cho_City']!=='请选择城市'  && !empty($_J['cho_City'])){    	
	    	$shouhuoshengshiqu.=' '.$_J['cho_City'];
	    }
	    if($_J['cho_Area']!=='请选择地区'  && !empty($_J['cho_Area'])){    	
	    	$shouhuoshengshiqu.=' '.$_J['cho_Area'];
	    }
	    if($shouhuoshengshiqu){
	    	$tiaojian.=' and dd.shouhuoshengshiqu like "%'.$shouhuoshengshiqu.'%"';
	    }
    if (!empty($_J['ming'])) {
        $tiaojian .= ' and  sp.ming like "%' . $_J['ming'] . '%"';
    }
    if ($_J['xuanze'] == 1) {
        $tiaojian .= '  order by sp.jiage*sp.shuliang desc';
    } else {
        $tiaojian .= '  order by sp.shuliang desc';
    }
    
	
    $tiaojian1 .= ' Limit ' . ($DangQianYe - 1) * $quTiaoShu . ',' . $quTiaoShu;

    $res = ChaQuan($sql . $tiaojian .$tiaojian1);
    foreach ($res as $k => $v) {
        $data = explode(' ', $v['商品名']);
        $res[$k]['商品名'] = $data[0];
        $res[$k]['支付时间'] = date('Y-m-d H:i:s', $v['支付时间']);
    }
    $zongshu = ChaZongShu('select count(*) from ' . BM('zw_shangcheng_dingdan_shangpin') . 'sp left join ' . BM('zw_shangcheng_dingdan') . ' dd on sp.dingdanid=dd.id where  dd.zhuangtai>=10' . $tiaojian);    
    $zong_E = ChaZongShu('select sum(dd.zongjia) from ' . BM('zw_shangcheng_dingdan_shangpin') . 'sp left join ' . BM('zw_shangcheng_dingdan') . ' dd on sp.dingdanid=dd.id where dd.zhuangtai>=10' . $tiaojian);   
    
    $FenYe = FenYe($zongshu, $DangQianYe, $quTiaoShu);
} elseif ($cao == 'daochu') {
    $sql = 'select sp.dingdanhao "订单号",sp.shangpin "商品编号",sp.ming "商品名",sp.jiage "价格",sp.shuliang "数量",dd.zhifushijian "支付时间" from '.BM('zw_shangcheng_dingdan_shangpin').' as sp  left join '.BM('zw_shangcheng_dingdan').' as dd on sp.dingdanid=dd.id where 1=1  and dd.zhuangtai >=10 ';
      $tiaojian = ' and shanghu='.$_W['shanghu']['id'];    
    if ($_J['sousuo'] == 1) {
        $daystart = strtotime($_J['kaishi']);
        $dayend = strtotime($_J['jieshu']) + 24 * 60 * 60;
        if (!empty($daystart) && !empty($dayend)) {
            $tiaojian .= ' and  dd.zhifushijian between ' . $daystart . ' and ' . $dayend;
        }
    }
    if (!empty($_J['ming'])) {
        $tiaojian .= ' and  sp.ming like "%' . $_J['ming'] . '%"';
    }
    if ($_J['xuanze'] == 1) {
        $tiaojian .= '  order by sp.jiage*sp.shuliang desc';
    } else {
        $tiaojian .= '  order by sp.shuliang desc';
    }

    $data = ChaQuan($sql . $tiaojian);
    foreach ($data as $k => $v) {
        $res = explode(' ', $v['商品名']);
        $data[$k]['商品名'] = $res[0];
        $data[$k]['支付时间'] = date('Y-m-d H:i:s', $v['支付时间']);
    }
    if ($data !== array()) {
        $res = MX('daochu', 'he')->daochu1($data);
    } else {
        //当条件查询结果为空时提示
        XiaoXi('查询结果为空，请重新查询');
    }
    die();
} elseif ($cao == "paihang") {
    $DangQianYe = max(1, $_J['page']);
    $quTiaoShu = 20;
    $tiaojian = ' and shanghu='.$_W['shanghu']['id'];    
    $tiaojian2 = '';
    $tiaojian3="";
    if ($_J['sousuo'] == 1) {
        $daystart = strtotime($_J['kaishi']);
        $dayend = strtotime($_J['jieshu']) + 24 * 60 * 60;
        if (!empty($daystart) && !empty($dayend)) {
            $tiaojian .= ' and  dd.zhifushijian between ' . $daystart . ' and ' . $dayend;
        }
    }
    if (!empty($_J['ming'])) {
        $tiaojian .= ' and  sp.ming like "%' . $_J['ming'] . '%"';
    }
    if ($_J['xuanze'] == 0) {
        $tiaojian2 .= '  order by 销售量 desc';

    } else {
        $tiaojian2 .= '  order by 销售额 desc';
    }
    
    if($_J['cho_Province']!=='请选择省份'  && !empty($_J['cho_Province'])){    	
    	$shouhuoshengshiqu.=$_J['cho_Province'];
    }
    if($_J['cho_City']!=='请选择城市'  && !empty($_J['cho_City'])){    	
    	$shouhuoshengshiqu.=' '.$_J['cho_City'];
    }
    if($_J['cho_Area']!=='请选择地区'  && !empty($_J['cho_Area'])){    	
    	$shouhuoshengshiqu.=' '.$_J['cho_Area'];
    }
    if($shouhuoshengshiqu){
    	$tiaojian.=' and dd.shouhuoshengshiqu like "%'.$shouhuoshengshiqu.'%"';
    }
   
    $tiaojian3 .= ' Limit ' . ($DangQianYe - 1) * $quTiaoShu . ',' . $quTiaoShu;
    $sql = 'select sp.ming "商品名",sum(sp.shuliang) "销售量",sum(sp.jiage*sp.shuliang) "销售额" from '.BM('zw_shangcheng_dingdan_shangpin').' as  sp left join '.BM('zw_shangcheng_dingdan').' as dd on sp.dingdanid=dd.id  where dd.zhuangtai >=10 ' . $tiaojian . '  group by sp.shangpin  ' . $tiaojian2 .$tiaojian3;
    $res = ChaQuan($sql);   
    foreach ($res as $k => $v) {
        $data = explode(' ', $v['商品名']);
        $res[$k]['商品名'] = $data[0];
        $res[$k]['id'] = $k + 1;
    }
    $zongshu = ChaZongShu('select count(*) from (select count(sp.danyuan) from '.BM('zw_shangcheng_dingdan_shangpin').' as  sp left join '.BM('zw_shangcheng_dingdan').' as dd on sp.dingdanid=dd.id    where  dd.zhuangtai>=10 ' . $tiaojian .' group by sp.shangpin) a') ;
    $sql = 'select sum(dd.zongjia) from '.BM('zw_shangcheng_dingdan_shangpin').' as  sp left join '.BM('zw_shangcheng_dingdan').' as dd on sp.dingdanid=dd.id  where dd.zhuangtai >=10 ' . $tiaojian;
    $zong_E= ChaZongShu($sql);     
    $FenYe = FenYe($zongshu, $DangQianYe, $quTiaoShu);
} elseif ($cao == "daochupaihang") {
      $tiaojian = ' and shanghu='.$_W['shanghu']['id'];    
    $tiaojian2 = '';
    if ($_J['sousuo'] == 1) {
        $daystart = strtotime($_J['kaishi']);
        $dayend = strtotime($_J['jieshu']) + 24 * 60 * 60;
        if (!empty($daystart) && !empty($dayend)) {
            $tiaojian .= ' and  dd.zhifushijian between ' . $daystart . ' and ' . $dayend;
        }
    }
    if (!empty($_J['ming'])) {
        $tiaojian .= ' and  sp.ming like "%' . $_J['ming'] . '%"';
    }
    if ($_J['xuanze'] == 0) {
        $tiaojian2 .= '  order by 销售量 desc';

    } else {
        $tiaojian2 .= '  order by 销售额 desc';
    }
    $sql = 'select "排行",sp.ming "商品名",sum(sp.shuliang) "销售量",sum(sp.jiage*sp.shuliang) "销售额" from '.BM('zw_shangcheng_dingdan_shangpin').' as  sp left join '.BM('zw_shangcheng_dingdan').' as dd on sp.dingdanid=dd.id  where 1  and dd.zhuangtai >=10  ' . $tiaojian . '  group by shangpin  ' . $tiaojian2;
    $data = ChaQuan($sql);
    foreach ($data as $k => $v) {
        $res = explode(' ', $v['商品名']);
        $data[$k]['商品名'] = $res[0];
        $data[$k]['排行'] = $k + 1;
    }
     if ($data !== array()) {
         $res = MX('daochu', 'he')->daochu1($data);
     } else {
         //当条件查询结果为空时提示
         XiaoXi('查询结果为空，请重新查询');
     }
    die();
}elseif($cao=='diqu'){
	
}
mb("index");
?>