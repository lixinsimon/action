<?php
DengLu();
if (empty($_J['d'])) {
    XiaoXi('您的权限不够！');
}
QuanXian();
$cao = empty($_J['c']) ? 'moren' : $_J['c'];
if ($cao == 'moren') {
    $DangQianYe = max(1, $_J['page']);
    $quTiaoShu = 20;
    $tiaojian = 'h.danyuan=' . $_W['danyuan'];
    if (is_numeric($_J['zhuangtai'])) {
        $tiaojian .= ' and gh.fenxiaozhuangtai=' . $_J['zhuangtai'];
    } else {
        $tiaojian .= ' and gh.fenxiaozhuangtai>=0';
    }
    if ($_J['id'] > 0) {
        $tiaojian .= ' and h.id=' . $_J['id'];
    }
    if ($_J['dengji'] > 0) {
        $tiaojian .= ' and gh.fenxiaodengji=' . $_J['dengji'];
    }
    if ($_J['kaishi'] && $_J['jieshu'] && !empty($_J['shijian'])) {
        $tiaojian .= ' and gh.fenxiaoshijian>=' . strtotime($_J['kaishi']);
        $tiaojian .= ' and gh.fenxiaoshijian<=' . strtotime($_J['jieshu']);
    }
    if ($_J['yonghu']) {
        $yonghu = trim($_J['yonghu']);
        $tiaojian .= ' and (h.nicheng like "%' . $yonghu . '%" or h.xingming like "%' . $yonghu . '%" or h.shouji like "%' . $yonghu . '%")';
    }
    $ziduan = 'h.id,h.zhanghao,h.touxiang,h.fuji_id,h.nicheng,h.xingming,h.shouji,h.shijian,h.zhuangtai,gh.fenxiaodengji,gh.fenxiaozhuangtai,gh.fenxiaoshijian';
    $hy = ChaQuan('select ' . $ziduan . ' from ' . BM('he_huiyuan') . 'h left join ' . BM('zw_shangcheng_huiyuan') . ' gh on h.id=gh.hyid where ' . $tiaojian . ' order by h.shijian DESC Limit ' . ($DangQianYe - 1) * $quTiaoShu . ',' . $quTiaoShu);
    $dengji = ChaQuan('select id,ming from ' . BM('zw_shangcheng_fenxiao_dengji') . ' where danyuan=' . $_W['danyuan']);
    $dengjiming = array();
    foreach ($dengji as $d) {
        $dengjiming[$d['id']] = $d['ming'];
    }
    foreach ($hy as $k => $h) {
        $hy[$k]['touxiang'] = JueDuiUrl($h['touxiang']);
        $hy[$k]['nicheng'] = empty($h['nicheng']) ? $h['zhanghao'] : $h['nicheng'];
        $hy[$k]['shijian'] = date('Y-m-d H:i:s', $h['shijian']);
        $hy[$k]['fenxiaoshijian'] = date('Y-m-d H:i:s', $h['fenxiaoshijian']);
        $hy[$k]['yongjin'] = MX()->FenXiaoYongJin($h['id']);
        $hy[$k]['yongjin']['tixian'] = ChaZongShu('select sum(jin_e) from ' . BM('zw_shangcheng_tixian') . ' where zhuangtai>5 and huiyuan=' . $h['id']);
        if ($h['fuji_id'] > 0) {
            $hy[$k]['fu'] = Cha('select id,touxiang,zhanghao,nicheng from ' . BM('he_huiyuan') . ' where id=' . $h['fuji_id']);
            $hy[$k]['fu']['touxiang'] = JueDuiUrl($hy[$k]['fu']['touxiang']);
            $hy[$k]['fu']['nicheng'] = empty($hy[$k]['fu']['nicheng']) ? $hy[$k]['fu']['zhanghao'] : $hy[$k]['fu']['nicheng'];
        }
        $hy[$k]['dengjiming'] = $dengjiming[$h['fenxiaodengji']];
    }
    $zongshu = ChaZongShu('select count(*) from ' . BM('he_huiyuan') . 'h left join ' . BM('zw_shangcheng_huiyuan') . ' gh on h.id=gh.hyid where ' . $tiaojian);
    $fenye = FenYe($zongshu, $DangQianYe, $quTiaoShu);
} elseif ($cao == "tixian") {
    QuanXian('tixian');
    $DangQianYe = max(1, $_J['page']);
    $quTiaoShu = 20;
    $zhuangtai_text = array(0 => '待核审', 10 => '待打款', 20 => '已打款', 5 => '无效');
    $tixianfangshi_text = array('yinhang' => '银行卡', 'weixin' => '微信', 'zhifubao' => '支付宝','yu_e' => '余额');
    $tiaojian = 't.danyuan=' . $_W['danyuan'];
    if ($_J['dingdanhao']) {
        $tiaojian .= ' and t.dingdanhao like "%' . trim($_J['dingdanhao']) . '%"';
    }
    if (is_numeric($_J['zhuangtai'])) {
        $tiaojian .= ' and t.zhuangtai=' . $_J['zhuangtai'];
    }
    if ($_J['yonghu']) {
        $yonghu = trim($_J['yonghu']);
        $tiaojian .= ' and (h.nicheng like "%' . $yonghu . '%" or h.xingming like "%' . $yonghu . '%" or h.shouji like "%' . $yonghu . '%")';
    }
    $lie = ChaQuan('select t.*,h.nicheng,h.touxiang,h.zhanghao from ' . BM('zw_shangcheng_tixian') . ' t left join ' . BM('he_huiyuan') . ' h on t.huiyuan=h.id where ' . $tiaojian . ' order by t.shenqingshijian DESC Limit ' . ($DangQianYe - 1) * $quTiaoShu . ',' . $quTiaoShu);
    $zongshu = ChaZongShu('select count(*) from ' . BM('zw_shangcheng_tixian') . ' t left join ' . BM('he_huiyuan') . ' h on t.huiyuan=h.id where ' . $tiaojian);
    $fenye = FenYe($zongshu, $DangQianYe, $quTiaoShu); 
} elseif ($cao == "tongzhi") {
    QuanXian('tongzhi');
} elseif ($cao == "rukou") {
    QuanXian('rukou');
} elseif ($cao == "dengji") {
    QuanXian('dengji');
    $dengjilie = MX()->FenXiaoDengJiLie();
} elseif ($cao == "jichu" && !$_W['ispost']) {
    $jichupeizhi = MX()->FenXiaoPeiZhi();
} elseif($cao == "gonggao"){
	$gg=Qu('zw_shangcheng_fenxiao_peizhi',array('danyuan'=>$_W['danyuan']),'gonggao');
	$gonggao=ZiFuChuan_Zhuan_ShuZu($gg['gonggao']);
	if($_W['ispost']){	
	   $g=array('gonggao'=>ShuZu_Zhuan_ZiFuChuan($_J['gonggao']));
	   Gai('zw_shangcheng_fenxiao_peizhi',$g,array('danyuan'=>$_W['danyuan']));
	   XiaoXi('公告更新成功');
	}	
} elseif ($cao == "xiangq") {
    $tiaojian = 't.danyuan=' . $_W['danyuan'] . ' and t.id=' . intval($_J['id']);
    $tixian = Cha('select t.*,h.nicheng,h.touxiang,h.zhanghao,h.xingming,h.shouji,sh.kaihuming,sh.yinhang,sh.kahao,sh.kaihuhang,sh.zhifubao_zhanghao,sh.zhifubao_ming from ' . BM('zw_shangcheng_tixian') . ' t left join ' . BM('he_huiyuan') . ' h on t.huiyuan=h.id left join ' . BM('zw_shangcheng_huiyuan') . ' sh on t.huiyuan=sh.hyid   where ' . $tiaojian);
    $zhuangtai_text = array(0 => '待核审', 10 => '待打款', 20 => '已打款', 5 => '无效');
    $tixianfangshi_text = array('yinhang' => '银行卡', 'weixin' => '微信', 'zhifubao' => '支付宝','yu_e' => '余额');
    if($tixian['dingdanids']){
	    $dingdanids=rtrim($tixian['dingdanids'],','); 
	    $tj = 'id in(' . $dingdanids. ')';
	    $dingdan_sql = "select id,dingdanhao,zongjia,yongjin,xiadanshijian from " . BM('zw_shangcheng_dingdan') . ' where ' . $tj . ' order by xiadanshijian DESC';
	    $dingdan = ChaQuan($dingdan_sql);	    
	    $yongjinzong_e=0;
	    foreach ($dingdan as $k => $d) {
	        $yongjin = ZiFuChuan_Zhuan_ShuZu($d['yongjin']);
	        if($yongjin[$tixian['huiyuan']]>0){
	            $dingdan[$k]['yj']=round($yongjin[$tixian['huiyuan']],2);
	            $yongjinzong_e += round($yongjin[$tixian['huiyuan']],2);         
	            $dingdan[$k]['shangpin'] = MX()->quDingDanShangpin($d['id']);
	        }else{
	           unset($dingdan[$k]);
	        }
	    }
    }
    if($tixian['duihuan_dingdanids']){
	    $duihuan_dingdan=MX('moxing','zw_duihuan')->TiXianDingDan($tixian);	   
    }  
   
} elseif ($cao == 'xingqingpost') {
    $tiaojian = 'danyuan=' . $_W['danyuan'] . ' and id=' . intval($_J['id']);
    $tixian = Cha('select * from ' . BM('zw_shangcheng_tixian') . 'where ' . $tiaojian);
    $zhuangtai_text = array('shenhe' => 10, 'dakuan' => 20, 'wuxiao' => 5);
    if ($zhuangtai_text[$_J['zhuangtai']] && $tixian) {
        $shu = array();
        $fan = array();
        $shu['zhuangtai'] = $zhuangtai_text[$_J['zhuangtai']];
        if ($shu['zhuangtai'] == 10) {
            $shu['shenheshijian'] = time();
            $tishi = '通过审核';
        }
        if ($shu['zhuangtai'] == 20) {
            $shu['dakuanshijian'] = time();
            $tishi = '打款成功';
            if($tixian['tixianfangshi']=='yu_e'){
        	   MX('huiyuan','he')->gai_yu_e($tixian['huiyuan'],$tixian['jin_e'],'余额提现');
            }
        }
        if ($shu['zhuangtai'] == 5) {
            $shu['wuxiaoshijian'] = time();
            $tishi = '更新成功';
        }
        
        Gai('zw_shangcheng_tixian', $shu, array('id' => $tixian['id']));
        XiaoXi($tishi, USK('fenxiao', array('c' => 'xiangq', 'id' => $tixian['id'])));
        exit;
    }
    XiaoXi('失败', USK('fenxiao', array('c' => 'xiangq', 'id' => $tixian['id'])));
    exit;
} elseif ($cao == "add") {
    $jichupeizhi = MX()->FenXiaoPeiZhi();
    $dengji = MX()->FenXiaoDengJi($_J['id']);
    mb("biaoqian/fenxiao_xindengji");
    exit;
} elseif ($cao == "xiaxian") {
    QuanXian($cao);
    $DangQianYe = max(1, $_J['page']);
    $quTiaoShu = 20;
    $tiaojian = 'h.danyuan=' . $_W['danyuan'];
    if (is_numeric($_J['zhuangtai'])) {
        $tiaojian .= ' and gh.fenxiaozhuangtai=' . $_J['zhuangtai'];
    } else {
        $tiaojian .= ' and gh.fenxiaozhuangtai>=0';
    }
    if ($_J['id'] > 0) {
        $xiaxian = MX()->XiaXian($_J['id']);
        $meijirenshu = array();
        foreach ($xiaxian as $x) {
            $ids .= $x['id'] . ',';
            $meijirenshu[$x['cengci']]++;
        }       
        $wodetuandui = count($xiaxian);
        $kehu = MX()->XiaXian($_J['id'], 1, 0, 0);
        $wodekehu = count($kehu);
        foreach ($kehu as $k) {
            $ids .= $k['id'] . ',';
        }
        if(empty($ids)){
        	XiaoXi('没有下线');
        }
        
        $ids=rtrim($ids, ',');      
        $tiaojian .= ' and h.id in (' .$ids. ')';
        $fenxiaoshang = MX()->quHuiYuan($_J['id']);
    }
    if ($_J['dengji'] > 0) {
        $tiaojian .= ' and gh.fenxiaodengji=' . $_J['dengji'];
    }
    if ($_J['kaishi'] && $_J['jieshu'] && !empty($_J['shijian'])) {
        $tiaojian .= ' and gh.fenxiaoshijian>=' . strtotime($_J['kaishi']);
        $tiaojian .= ' and gh.fenxiaoshijian<=' . strtotime($_J['jieshu']);
    }
    if ($_J['yonghu']) {
        $yonghu = trim($_J['yonghu']);
        $tiaojian .= ' and (h.nicheng like "%' . $yonghu . '%" or h.xingming like "%' . $yonghu . '%" or h.shouji like "%' . $yonghu . '%")';
    }
    $ziduan = 'h.id,h.zhanghao,h.touxiang,h.fuji_id,h.nicheng,h.xingming,h.shouji,h.shijian,h.zhuangtai,gh.fenxiaodengji,gh.fenxiaozhuangtai,gh.fenxiaoshijian';
    $hy = ChaQuan('select ' . $ziduan . ' from ' . BM('he_huiyuan') . 'h left join ' . BM('zw_shangcheng_huiyuan') . ' gh on h.id=gh.hyid where ' . $tiaojian . ' order by h.shijian DESC Limit ' . ($DangQianYe - 1) * $quTiaoShu . ',' . $quTiaoShu);
    $dengji = ChaQuan('select id,ming from ' . BM('zw_shangcheng_fenxiao_dengji') . ' where danyuan=' . $_W['danyuan']);
    $dengjiming = array();
    foreach ($dengji as $d) {
        $dengjiming[$d['id']] = $d['ming'];
    }
    foreach ($hy as $k => $h) {
        $hy[$k]['touxiang'] = JueDuiUrl($h['touxiang']);
        $hy[$k]['nicheng'] = empty($h['nicheng']) ? $h['zhanghao'] : $h['nicheng'];
        $hy[$k]['shijian'] = date('Y-m-d H:i:s', $h['shijian']);
        $hy[$k]['fenxiaoshijian'] = date('Y-m-d H:i:s', $h['fenxiaoshijian']);
        $hy[$k]['yongjin'] = MX()->FenXiaoYongJin($h['id']);
        $hy[$k]['yongjin']['tixian'] = ChaZongShu('select sum(jin_e) from ' . BM('zw_shangcheng_tixian') . ' where zhuangtai>5 and huiyuan=' . $h['id']);
        if ($h['fuji_id'] > 0) {
            $hy[$k]['fu'] = Cha('select id,touxiang,zhanghao,nicheng from ' . BM('he_huiyuan') . ' where id=' . $h['fuji_id']);
            $hy[$k]['fu']['touxiang'] = JueDuiUrl($hy[$k]['fu']['touxiang']);
            $hy[$k]['fu']['nicheng'] = empty($hy[$k]['fu']['nicheng']) ? $hy[$k]['fu']['zhanghao'] : $hy[$k]['fu']['nicheng'];
        }
        $hy[$k]['dengjiming'] = $dengjiming[$h['fenxiaodengji']];
    }
    $zongshu = ChaZongShu('select count(*) from ' . BM('he_huiyuan') . 'h left join ' . BM('zw_shangcheng_huiyuan') . ' gh on h.id=gh.hyid where ' . $tiaojian);
    $fenye = FenYe($zongshu, $DangQianYe, $quTiaoShu);
} elseif ($cao == "fenxiaoshang") {
    $id = intval($_J['id']);
    $fenxiaoshang = MX()->quHuiYuan($id);
    $fenxiaoshang['yongjin'] = MX()->FenXiaoYongJin($id);
  
    $fenxiaoshang['yongjin']['tixian'] = ChaZongShu('select sum(jin_e) from ' . BM('zw_shangcheng_tixian') . ' where zhuangtai>5 and huiyuan=' . $id);
    $dengjilie = MX()->FenXiaoDengJiLie();
} elseif ($cao == "fenxiaoshangpost") {
    $shu = array(
        'kaihuming' => trim($_J['kaihuming']),
        'kahao' => trim($_J['kahao']),
        'yinhang' => trim($_J['yinhang']),
        'kaihuhang' => trim($_J['kaihuhang']),
        'fenxiaodengji' => intval($_J['fenxiaodengji']),
        'fenxiaozhuangtai' => intval($_J['fenxiaozhuangtai']),       
    );
    if(empty($_J['fenxiaoshijian']) && $_J['fenxiaozhuangtai']==1){
    	$shu['fenxiaoshijian']=time();
    }
    Gai('zw_shangcheng_huiyuan', $shu, array('danyuan' => $_W['danyuan'], 'hyid' => intval($_J['id'])));
    XiaoXi('更新成功', USK('fenxiao', array('c' => 'fenxiaoshang', 'id' => intval($_J['id']))));
} elseif ($cao == 'shanchufenxiaoshang') {
    $shu = array('fenxiaozhuangtai' => -1);
    Gai('zw_shangcheng_huiyuan', $shu, array('danyuan' => $_W['danyuan'], 'hyid' => intval($_J['id'])));
    XiaoXi('删除成功', USK('fenxiao'));
} elseif ($cao == "jichu" && $_W['ispost']) {
    QuanXian($cao);
    $shu = array(
        'cenji' => $_J['cenji'],
        'moshi' => $_J['moshi'],
        'tiaojian' => $_J['tiaojian'],
        'wanshanziliao' => $_J['wanshanziliao'],
        'shenhe' => $_J['shenhe'],
        'tixian_e' => $_J['tixian_e'],
        'tixiandaoyu_e' => $_J['tixiandaoyu_e'],
        'jiesuantian' => $_J['jiesuantian'],
        'fenxiaoyindao' => $_J['fenxiaoyindao'],
        'xieyi' => $_J['xieyi'],
    );
    $shu = ShuZu_Zhuan_ZiFuChuan($shu);
    $g = Qu('zw_shangcheng_fenxiao_peizhi', array('danyuan' => $_W['danyuan']));
    if ($g) {
        Gai('zw_shangcheng_fenxiao_peizhi', array('jichupeizhi' => $shu), array('danyuan' => $_W['danyuan']));
    } else {
        ChaRu('zw_shangcheng_fenxiao_peizhi', array('jichupeizhi' => $shu, 'danyuan' => $_W['danyuan']));
    }
    XiaoXi('更新成功', USK('fenxiao', array('xx' => 'jichu')));
} elseif ($cao == "postdengji" && $_W['ispost']) {
    if (empty($_J['ming'])) {
        XiaoXi('名称不能为空');
    }
    $shu = array(
        'danyuan' => $_W['danyuan'],
        'ming' => trim($_J['ming']),
        'tiaojian' => trim($_J['tiaojian']),
        'cenji' => ShuZu_Zhuan_ZiFuChuan($_J['cenji']),
        'paixu' => intval($_J['paixu'])
    );
    if (intval($_J['id']) > 0) {
        Gai('zw_shangcheng_fenxiao_dengji', $shu, array('id' => $_J['id']));
        XiaoXi('更新角色成功', USK('fenxiao', array('xx' => 'dengji')));
    } else {
        ChaRu('zw_shangcheng_fenxiao_dengji', $shu);
        XiaoXi('新增角色', USK('fenxiao', array('xx' => 'dengji')));
    }
} elseif ($cao == "shanchudengji") {
    QuanXian($cao);
    if (empty($_J['id'])) {
        XiaoXi('缺ID');
    }
    ShanChu('zw_shangcheng_fenxiao_dengji', array('id' => $_J['id'], 'danyuan' => $_W['danyuan']));
    XiaoXi('删除成功', USK('fenxiao', array('xx' => 'dengji')));
} elseif ($cao == "tixiandaochu") {
    $sql1 = "";
    if ($_J['shijian'] == 1) {
        $kaishitime = strtotime($_J['kaishi']);
        $jieshutime = strtotime($_J['jieshu']) + 24 * 60 * 60;
        $sql1 .= " and a.shenqingshijian between " . $kaishitime . " and " . $jieshutime;
    }
    if ($_J['dingdanhao'] != "") {
        $sql1 .= " and a.dingdanhao='" . $_J['dingdanhao'] . "'";
    }
    if ($_J['yonghu']) {
        $sql2 = 'select * from ims_he_huiyuan where shouji like "%' . $_J['yonghu'] . '%" or nicheng like "%' . $_J['yonghu'] . '%" or xingming like "%' . $_J['yonghu'] . '%"';
        $res = ChaQuan($sql2);
        $sql1 .= " and a.huiyuan =(";
        foreach ($res as $k => $v) {
            if (empty($res[$k + 1])) {
                $sql1 .= $v['id'];
            } else {
                $sql1 .= $v['id'] . ' or ';
            }
        }
        $sql1 .= ")";
    }

    if ($_J['zhuangtai'] != "") {
        $sql1 .= " and a.zhuangtai='" . $_J['zhuangtai'] . "'";
    }
    /* $zhuangtai_text=array(0=>'待核审',10=>'待打款',20=>'已打款',5=>'无效');*/
    /*$tixianfangshi_text=array('yinhang'=>'银行卡','weixin'=>'微信','zhifubao'=>'支付宝');*/
    $sql = "select a.dingdanhao '提现单号',a.jin_e '金额',a.dingdanids '订单id',b.nicheng '昵称',b.shouji '手机',a.tixianfangshi '提现方式',a.shenqingshijian '申请时间',a.kaihuming '开户名',a.kahao '卡号',a.yinhang '银行',a.kaihuhang '开户行',a.zhuangtai '提现状态'  from ims_zw_shangcheng_tixian a inner join ims_he_huiyuan b on a.huiyuan=b.id where 1 " . $sql1 . " order by a.id desc";
    $data = ChaQuan($sql);
    foreach ($data as $k => $v) {
        $data[$k]['卡号'] = "卡号:" . $v['卡号'];
        $data[$k]['订单id'] = "订单id:" . $v['订单id'];
        $data[$k]['申请时间'] = date('Y-m-d H:i:s', $v['申请时间']);
        if ($v['提现方式'] == 'yinhang') {
            $data[$k]['提现方式'] = "银行卡";
        } elseif ($v['提现方式'] == 'weixin') {
            $data[$k]['提现方式'] = "微信";
        } elseif ($v['提现方式'] == 'zhifubao') {
            $data[$k]['提现方式'] = "支付宝";
        }
        if ($v['提现状态'] == 0) {
            $data[$k]['提现状态'] = "待核审";
        } elseif ($v['提现状态'] == 10) {
            $data[$k]['提现状态'] = "待打款";
        } elseif ($v['提现状态'] == 20) {
            $data[$k]['提现状态'] = "已打款";
        } elseif ($v['提现状态'] == 5) {
            $data[$k]['提现状态'] = "无效";
        }
    }


    if ($data !== array()) {
        $res = MX('daochu', 'he')->daochu1($data);
    } else {
        //当条件查询结果为空时提示
        XiaoXi('查询结果为空，请重新查询');
    }
    die();
}

mb("fenxiao");
?>