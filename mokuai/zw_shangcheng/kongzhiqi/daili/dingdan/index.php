<?php
DengLu();
if (empty($_J['d'])) {
    XiaoXi('您的权限不够！');
}
$cao = empty($_J['c']) ? 'moren' : $_J['c'];
QuanXian();

if ($cao == 'moren') {
    $zhuantai_bianqian = array('daifu' => 0, 'quxiao' => 5, 'tuikuan' => 6, 'yituikuan' => 7, 'daifa' => 10, 'daishou' => 20,'tuihuo'=>15,'wancheng' => 30);

    $TiaoJian = array('shanghu'=>$_W['shanghu']['id']);
    if (!empty($_J['zhuangtai'])) {
        $TiaoJian = array('zhuangtai' => $zhuantai_bianqian[$_J['zhuangtai']]);
    };
    $DangQianYe = max(1, $_J['page']);
    $XianJiLu = 5;
    if ($_J['dingdanhao']) {
        $TiaoJian['dingdanhao'] = array('dingdanhao like "%' . $_J['dingdanhao'] . '%"');
    }
    if ($_J['xuanze'] == 1) {
        $starttime = strtotime($_J['kaishi']);
        $endtime = strtotime($_J['jieshu']) + 24 * 60 * 60;
        $TiaoJian['xiadanshijian'] = array('xiadanshijian <' . $endtime . ' and xiadanshijian >' . $starttime);
    }
    if ($_J['zhifuqudao']) {
        $TiaoJian['zhifuqudao'] = $_J['zhifuqudao'];
    }
    if ($_J['kuaidihao']) {
        $TiaoJian['kuaidihao'] = array('kuaidihao like "%' . $_J['kuaidihao'] . '%"');
    }
    if ($_J['yongfu']) {
        $yf = ChaQuan('select id from ' . BM('he_huiyuan') . ' where danyuan=' . $_W['danyuan'] . ' and (shouji like "%' . $_J['yongfu'] . '%" or nicheng like "%' . $_J['yongfu'] . '%" or xingming like "%' . $_J['yongfu'] . '%")');
        $ids = '';
        if (empty($yf)) {
            XiaoXi('找不到相关信息');
        }
        foreach ($yf as $y) {
            $ids .= $y['id'] . ',';
        }
        $ids = rtrim($ids, ',');
        $TiaoJian['huiyuan'] = array('huiyuan in(' . $ids . ')');
    }
    $dingdan = MX()->quDingDanLie($DangQianYe, $XianJiLu, $TiaoJian);  
    if($dingdan) {
	    foreach ($dingdan['dingdan'] as $k => $d) {
	        $h = MX('huiyuan', 'he')->qu_huiyuan($d['huiyuan'], 'zhanghao,nicheng');
	        $dingdan['dingdan'][$k]['huiyuanming'] = empty($h['nicheng']) ? $h['zhanghao'] : $h['nicheng'];
	        $dingdan['dingdan'][$k]['yongjin'] = ZiFuChuan_Zhuan_ShuZu($d['yongjin']);
	    }
    }
    $fenye = FenYe($dingdan['zongshu'], $DangQianYe, $XianJiLu);
    $daifuzongshu = ChaZongShu("select count(*) from " . BM('zw_shangcheng_dingdan_jichu') . ' where zhuangtai=0 and shanghu=' . $_W['shanghu']['id']);
    $quxiaozongshu = ChaZongShu("select count(*) from " . BM('zw_shangcheng_dingdan') . ' where zhuangtai=5 and shanghu=' . $_W['shanghu']['id']);
    $tuikuanzongshu = ChaZongShu("select count(*) from " . BM('zw_shangcheng_dingdan') . ' where zhuangtai=6 and shanghu=' . $_W['shanghu']['id']);
    $yituikaunzongshu = ChaZongShu("select count(*) from " . BM('zw_shangcheng_dingdan') . ' where zhuangtai=7 and shanghu=' . $_W['shanghu']['id']);
    $daifazongshu = ChaZongShu("select count(*) from " . BM('zw_shangcheng_dingdan') . ' where zhuangtai=10 and shanghu=' . $_W['shanghu']['id']);
    $daishouzongshu = ChaZongShu("select count(*) from " . BM('zw_shangcheng_dingdan') . ' where zhuangtai=20 and shanghu=' . $_W['shanghu']['id']);
    $tuihuo= ChaZongShu("select count(*) from " . BM('zw_shangcheng_dingdan') . ' where zhuangtai=15 and shanghu=' . $_W['shanghu']['id']);
    $wanchengzongshu = ChaZongShu("select count(*) from " . BM('zw_shangcheng_dingdan') . ' where zhuangtai=30 and shanghu=' . $_W['shanghu']['id']);
    $zongshu = ChaZongShu("select count(*) from " . BM('zw_shangcheng_dingdan') . ' where shanghu=' . $_W['shanghu']['id']);

} elseif ($cao == "dingdan_xq") {
    $zhifuqudao = array('weixin' => '微信支付', 'zhifubao' => '支付宝', 'yu_e' => '余额支付', 'houtai' => '后台支付', 'yinlian' => '银联支付', 'daofu' => '货到付款');
    $dingdan = MX()->DingDanErWeiShuZu($_J['id']);    
    $dingdan['yongjin'] = ZiFuChuan_Zhuan_ShuZu($dingdan['yongjin']);
    if ($dingdan['yongjin'] != null) {
        foreach ($dingdan['yongjin'] as $k => $y) {
            $h = MX('huiyuan', 'he')->qu_huiyuan($k, 'zhanghao,nicheng');
            $dingdan['fenxiaoshang'][$k]['ming'] = empty($h['nicheng']) ? $h['zhanghao'] : $h['nicheng'];
            $dingdan['fenxiaoshang'][$k]['yongjin'] = $y;
        }
    }

    mb("biaoqian/dingdan_xq");
    exit;
} elseif ($cao == 'gaizhuanitai') {
    if (empty($_J['id']) || empty($_J['zhuangtai'])) {
        XiaoXi('无法修改');
        exit;
    }
    $tiaojian = array();
    $tiaojian['shanghu'] = $_W['shanghu']['id'];
    $tiaojian['id'] = $_J['id'];   
    if ($_J['zhuangtai'] == 'fahuo') {
        $shu = array('zhuangtai' => $_J['zhuangtai'], 'kuaidihao' => $_J['kuaidihao'], 'kuaidiming' => $_J['kuaidiming'], 'kuaidiid' => $_J['kuaidiid']);
    } elseif ($_J['zhuangtai'] == 'fukuan') {
        $shu = array('zhuangtai' => $_J['zhuangtai'], 'zhifuqudao' => 'houtai');
    } else {
        $shu = array('zhuangtai' => $_J['zhuangtai']);

    }
    $dingdan = MX()->gaiDingDanZhuangTai($shu, $tiaojian);
    XiaoXi('操作成功');
    exit;
} elseif ($cao == 'kuaidi') {
    $kuaidi = ChaKuaiDi($_J['kuaidiid'], $_J['kuaidihao']);
    mb('biaoqian/kuaidi');
    exit;
} elseif ($cao == "daochudingdan") {	
    $id = $_J['ddid'];   
    $sql = "select * from ".BM('zw_shangcheng_dingdan_shangpin')." sp left join ".BM('zw_shangcheng_dingdan')." dd on sp.dingdanid=dd.id where sp.dingdanid=" . $id.' and sp.shanghu='.$_W['shanghu']['id'];
    $res = ChaQuan($sql);
    foreach ($res as $k => $v) {
        $res[$k]['jine'] = $v['shuliang'] * $v['jiage'];
        $res[$k]['xuhao'] = $k + 1;
        $res[$k]['xiadanshijian'] = date('Y-m-d H:i:s', $v['xiadanshijian']);
        $res1 = explode(' ', $v['ming']);
        $res[$k]['wuliaoming'] = $res1[0];
        $res[$k]['guigeyue'] = $res1[1];
    }

}

mb("dingdan");
?>