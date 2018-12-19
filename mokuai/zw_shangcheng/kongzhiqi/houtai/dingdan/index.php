<?php
DengLu();
if (empty($_J['d'])) {
    XiaoXi('您的权限不够！');
}
$cao = empty($_J['c']) ? 'moren' : $_J['c'];
QuanXian();



if ($cao == 'moren') {
    $zhuantai_bianqian = array('daifu' => 0, 'quxiao' => 5, 'tuikuan' => 6, 'yituikuan' => 7, 'daifa' => 10, 'daishou' => 20,'tuihuo'=>15,'wancheng' => 30);

    $TiaoJian = array();
    if (!empty($_J['zhuangtai'])) {
    	if($_J['zhuangtai']=='tuikuan'){
    		$TiaoJian['zhuangtai'] = array('zhuangtai>=6 and zhuangtai<7');
    	}else{
    		 $TiaoJian = array('zhuangtai' => $zhuantai_bianqian[$_J['zhuangtai']]);
    	}
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
    $daifuzongshu = ChaZongShu("select count(*) from " . BM('zw_shangcheng_dingdan') . ' where zhuangtai=0 and danyuan=' . $_W['danyuan']);
    
    
    
    
    $quxiaozongshu = ChaZongShu("select count(*) from " . BM('zw_shangcheng_dingdan') . ' where zhuangtai=5 and danyuan=' . $_W['danyuan']);
    $tuikuanzongshu = ChaZongShu("select count(*) from " . BM('zw_shangcheng_dingdan') . ' where zhuangtai>=6 and zhuangtai<7 and danyuan=' . $_W['danyuan']);
    $yituikaunzongshu = ChaZongShu("select count(*) from " . BM('zw_shangcheng_dingdan') . ' where zhuangtai=7 and danyuan=' . $_W['danyuan']);
    $daifazongshu = ChaZongShu("select count(*) from " . BM('zw_shangcheng_dingdan') . ' where zhuangtai=10 and danyuan=' . $_W['danyuan']);
    $daishouzongshu = ChaZongShu("select count(*) from " . BM('zw_shangcheng_dingdan') . ' where zhuangtai=20 and danyuan=' . $_W['danyuan']);
    $tuihuo= ChaZongShu("select count(*) from " . BM('zw_shangcheng_dingdan') . ' where zhuangtai=15 and danyuan=' . $_W['danyuan']);
    $wanchengzongshu = ChaZongShu("select count(*) from " . BM('zw_shangcheng_dingdan') . ' where zhuangtai=30 and danyuan=' . $_W['danyuan']);
    $zongshu = ChaZongShu("select count(*) from " . BM('zw_shangcheng_dingdan') . ' where danyuan=' . $_W['danyuan']);

} elseif ($cao == "dingdan_xq") {
	QuanXian('dingdan_xq');
	
    $zhifuqudao = array('weixin' => '微信支付', 'zhifubao' => '支付宝', 'yu_e' => '余额支付', 'houtai' => '后台支付', 'yinlian' => '银联支付', 'daofu' => '货到付款');
    $dingdan = MX()->DingDanErWeiShuZu($_J['id']);    
    $dingdan['yongjin'] = ZiFuChuan_Zhuan_ShuZu($dingdan['yongjin']);
//  if ($dingdan['yongjin'] != null) {
//      foreach ($dingdan['yongjin'] as $k => $y) {
//          $h = MX('huiyuan', 'he')->qu_huiyuan($k, 'zhanghao,nicheng');
//          $dingdan['fenxiaoshang'][$k]['ming'] = empty($h['nicheng']) ? $h['zhanghao'] : $h['nicheng'];
//          $dingdan['fenxiaoshang'][$k]['yongjin'] = $y;
//      }
//  }
	$dingdan['yongjin']=ChaQuan('select yj.*,h.nicheng from '.BM('he_huiyuan_yongjin').' yj left join '.BM('he_huiyuan').' h on  h.id=yj.huiyuan_id  where yj.dingdanhao="'.$dingdan['dingdanhao'].'" and yj.zhi>0 and yj.zhuangtai>-1');
	$dingdan['liquan']=ChaQuan('select yj.*,h.nicheng from '.BM('he_huiyuan_liquan').' yj left join '.BM('he_huiyuan').' h on  h.id=yj.huiyuan_id  where yj.dingdanhao="'.$dingdan['dingdanhao'].'" and yj.zhi>0 and yj.zhuangtai>-1');
	

    mb("biaoqian/dingdan_xq");
    exit;
} elseif ($cao == 'gaizhuanitai') {
    if (empty($_J['id']) || empty($_J['zhuangtai'])) {
        XiaoXi('无法修改');
        exit;
    }
	QuanXian($_J['zhuangtai']);    
    $tiaojian = array();
    $tiaojian['danyuan'] = $_W['danyuan'];
    $tiaojian['id'] = $_J['id'];   
    if ($_J['zhuangtai'] == 'fahuo') {
        $shu = array('zhuangtai' => $_J['zhuangtai'], 'kuaidihao' => $_J['kuaidihao'], 'kuaidiming' => $_J['kuaidiming'], 'kuaidiid' => $_J['kuaidiid']);
    } elseif ($_J['zhuangtai'] == 'fukuan') {
        $shu = array('zhuangtai' => $_J['zhuangtai'], 'zhifuqudao' => 'houtai');
    } else {
        $shu = array('zhuangtai' => $_J['zhuangtai']);

    }

    $dingdan = MX()->gaiDingDanZhuangTai($shu, $tiaojian);
    CaoZuoJiLu('操作订单ID:'.$_J['id']);
    XiaoXi('操作成功');
    exit;
} elseif ($cao == 'kuaidi') {
    $kuaidi = ChaKuaiDi($_J['kuaidiid'], $_J['kuaidihao']);
    mb('biaoqian/kuaidi');
    exit;
} elseif ($cao == 'daochu') {
    $sql1 = "and a.danyuan=".$_W['danyuan'];
    if ($_J['dingdanhao'] != "") {
        $sql1 .= " and a.dingdanhao like  '%" . $_J['dingdanhao'] . "%'";
    }
    if ($_J['kuaidihao'] != "") {
        $sql1 .= " and a.kuaidihao like  '%" . $_J['kuaidihao'] . "%'";
    }
    if ($_J['yongfu'] != "") {
        $sql2 = 'select * from '.BM('he_huiyuan').' where (shouji like "%' . $_J['yongfu'] . '%" or nicheng like "%' . $_J['yongfu'] . '%" or xingming like "%' . $_J['yongfu'] . '%") and danyuan='.$_W['danyuan'];
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
    if ($_J['zhifuqudao'] != "") {
        $sql1 .= " and a.zhifuqudao= '" . $_J['zhifuqudao'] . "'";
    }

    if ($_J['xuanze'] == 1) {
        $starttime = strtotime($_J['starttime']);
        $endtime = strtotime($_J['endtime']) + 24 * 60 * 60;
        $sql1 .= " and a.xiadanshijian > " . $starttime . " and a.xiadanshijian < " . $endtime;

    }
    if ($_J['zhuangtai'] == "daifu") {

        $sql = 'select a.id "编号",a.dingdanhao "订单号",b.ming "商品名",b.jiage "单价",b.shuliang "数量",a.shouhuoren  "收货人",a.shouhuodianhua  "收货电话",a.shouhuoshengshiqu  "收货省市区",a.shouhuodizhi "收货地址",a.danyuan "商品总价",a.zongjia "订单总价",a.zhuangtai "状态",a.xiadanshijian "下单时间",a.zhifushijian "支付时间", a.zhifuqudao "支付渠道",a.liuyan "留言",a.huiyuan "会员" from '.BM('zw_shangcheng_dingdan').' a Left  JOIN  '.BM('zw_shangcheng_dingdan_shangpin').' b on a.id=b.dingdanid where  a.zhuangtai = 0 ' . $sql1 . '  order by a.id  desc';

    } elseif ($_J['zhuangtai'] == "daifa") {
        $sql = 'select a.id "编号",a.dingdanhao "订单号",b.ming "商品名",b.jiage "单价",b.shuliang "数量",a.shouhuoren  "收货人",a.shouhuodianhua  "收货电话",a.shouhuoshengshiqu  "收货省市区",a.shouhuodizhi "收货地址",a.danyuan "商品总价",a.zongjia "订单总价",a.zhuangtai "状态",a.xiadanshijian "下单时间",a.zhifushijian "支付时间", a.zhifuqudao "支付渠道",a.liuyan "留言",a.huiyuan "会员" from '.BM('zw_shangcheng_dingdan').' a Left  JOIN  '.BM('zw_shangcheng_dingdan_shangpin').' b on a.id=b.dingdanid where a.zhuangtai = 10  ' . $sql1 . ' order by a.id  desc';
    } elseif ($_J['zhuangtai'] == "daishou") {
        $sql = 'select a.id "编号",a.dingdanhao "订单号",b.ming "商品名",b.jiage "单价",b.shuliang "数量",a.shouhuoren  "收货人",a.shouhuodianhua  "收货电话",a.shouhuoshengshiqu  "收货省市区",a.shouhuodizhi "收货地址",a.danyuan "商品总价",a.zongjia "订单总价",a.zhuangtai "状态",a.xiadanshijian "下单时间",a.zhifushijian "支付时间", a.zhifuqudao "支付渠道",a.liuyan "留言",a.huiyuan "会员" from '.BM('zw_shangcheng_dingdan').' a Left  JOIN  '.BM('zw_shangcheng_dingdan_shangpin').' b on a.id=b.dingdanid where a.zhuangtai = 20  ' . $sql1 . ' order by a.id  desc';

    } elseif ($_J['zhuangtai'] == "wancheng") {
        $sql = 'select a.id "编号",a.dingdanhao "订单号",b.ming "商品名",b.jiage "单价",b.shuliang "数量",a.shouhuoren  "收货人",a.shouhuodianhua  "收货电话",a.shouhuoshengshiqu  "收货省市区",a.shouhuodizhi "收货地址",a.danyuan "商品总价",a.zongjia "订单总价",a.zhuangtai "状态",a.xiadanshijian "下单时间",a.zhifushijian "支付时间", a.zhifuqudao "支付渠道",a.liuyan "留言",a.huiyuan "会员" from '.BM('zw_shangcheng_dingdan').' a Left  JOIN  '.BM('zw_shangcheng_dingdan_shangpin').' b on a.id=b.dingdanid where a.zhuangtai = 30 ' . $sql1 . '  order by a.id  desc';

    } elseif ($_J['zhuangtai'] == "quxiao") {
        $sql = 'select a.id "编号",a.dingdanhao "订单号",b.ming "商品名",b.jiage "单价",b.shuliang "数量",a.shouhuoren  "收货人",a.shouhuodianhua  "收货电话",a.shouhuoshengshiqu  "收货省市区",a.shouhuodizhi "收货地址",a.danyuan "商品总价",a.zongjia "订单总价",a.zhuangtai "状态",a.xiadanshijian "下单时间",a.zhifushijian "支付时间", a.zhifuqudao "支付渠道",a.liuyan "留言",a.huiyuan "会员" from '.BM('zw_shangcheng_dingdan').' a Left  JOIN  '.BM('zw_shangcheng_dingdan_shangpin').' b on a.id=b.dingdanid where a.zhuangtai = 5 ' . $sql1 . '  order by a.id  desc';

    } elseif ($_J['zhuangtai'] == "tuikuan") {
        $sql = 'select a.id "编号",a.dingdanhao "订单号",b.ming "商品名",b.jiage "单价",b.shuliang "数量",a.shouhuoren  "收货人",a.shouhuodianhua  "收货电话",a.shouhuoshengshiqu  "收货省市区",a.shouhuodizhi "收货地址",a.danyuan "商品总价",a.zongjia "订单总价",a.zhuangtai "状态",a.xiadanshijian "下单时间",a.zhifushijian "支付时间", a.zhifuqudao "支付渠道",a.liuyan "留言",a.huiyuan "会员" from '.BM('zw_shangcheng_dingdan').' a Left  JOIN  '.BM('zw_shangcheng_dingdan_shangpin').' b on a.id=b.dingdanid where a.zhuangtai = 6 ' . $sql1 . '  order by a.id  desc';

    } elseif ($_J['zhuangtai'] == "yituikuan") {
        $sql = 'select a.id "编号",a.dingdanhao "订单号",b.ming "商品名",b.jiage "单价",b.shuliang "数量",a.shouhuoren  "收货人",a.shouhuodianhua  "收货电话",a.shouhuoshengshiqu  "收货省市区",a.shouhuodizhi "收货地址",a.danyuan "商品总价",a.zongjia "订单总价",a.zhuangtai "状态",a.xiadanshijian "下单时间",a.zhifushijian "支付时间", a.zhifuqudao "支付渠道",a.liuyan "留言",a.huiyuan "会员" from '.BM('zw_shangcheng_dingdan').' a Left  JOIN  '.BM('zw_shangcheng_dingdan_shangpin').' b on a.id=b.dingdanid where a.zhuangtai = 7 ' . $sql1 . '  order by a.id  desc';

    }elseif ($_J['zhuangtai'] == "tuihuo") {
        $sql = 'select a.id "编号",a.dingdanhao "订单号",b.ming "商品名",b.jiage "单价",b.shuliang "数量",a.shouhuoren  "收货人",a.shouhuodianhua  "收货电话",a.shouhuoshengshiqu  "收货省市区",a.shouhuodizhi "收货地址",a.danyuan "商品总价",a.zongjia "订单总价",a.zhuangtai "状态",a.xiadanshijian "下单时间",a.zhifushijian "支付时间", a.zhifuqudao "支付渠道",a.liuyan "留言",a.huiyuan "会员" from '.BM('zw_shangcheng_dingdan').' a Left  JOIN  '.BM('zw_shangcheng_dingdan_shangpin').' b on a.id=b.dingdanid where a.zhuangtai = 15 ' . $sql1 . '  order by a.id  desc';

    } else {
        $sql = 'select a.id "编号",a.dingdanhao "订单号",b.ming "商品名",b.jiage "单价",b.shuliang "数量",a.shouhuoren  "收货人",a.shouhuodianhua  "收货电话",a.shouhuoshengshiqu  "收货省市区",a.shouhuodizhi "收货地址",a.danyuan "商品总价",a.zongjia "订单总价",a.zhuangtai "状态",a.xiadanshijian "下单时间",a.zhifushijian "支付时间", a.zhifuqudao "支付渠道",a.liuyan "留言",a.huiyuan "会员" from '.BM('zw_shangcheng_dingdan').' a Left  JOIN  '.BM('zw_shangcheng_dingdan_shangpin').' b on a.id=b.dingdanid  where 1  ' . $sql1 . '   order by a.id  desc';
    }
    $data = ChaQuan($sql);
    foreach ($data as $k => $v) {
        $data[$k]['商品总价'] = $v['单价'] * $v['数量'];

        $data[$k]['下单时间'] = date('Y-m-d H:i:s', $v['下单时间']);
        if ($v['支付时间'] != null) {
            $data[$k]['支付时间'] = date('Y-m-d H:i:s', $v['支付时间']);
        } else {
            $data[$k]['支付时间'] = '未支付';
        }

        if ($v['支付渠道'] == "weixin") {
            $data[$k]['支付渠道'] = "微信支付";
        } elseif ($v['支付渠道'] == "zhifubao") {
            $data[$k]['支付渠道'] = "支付宝";
        } elseif ($v['支付渠道'] == "yu_e") {
            $data[$k]['支付渠道'] = "余额支付";
        } elseif ($v['支付渠道'] == "houtai") {
            $data[$k]['支付渠道'] = "后台支付";
        } elseif ($v['支付渠道'] == "yinlian") {
            $data[$k]['支付渠道'] = "银联支付";
        } elseif ($v['支付渠道'] == "daofu") {
            $data[$k]['支付渠道'] = "货到付款";
        } else {
            $data[$k]['支付渠道'] = "未支付";
        }
        if ($v['状态'] == 0) {
            $data[$k]['状态'] = "待付";
        } elseif ($v['状态'] == 10) {
            $data[$k]['状态'] = "待发";
        } elseif ($v['状态'] == 20) {
            $data[$k]['状态'] = "待收";
        } elseif ($v['状态'] == 30) {
            $data[$k]['状态'] = "完成";
        } elseif ($v['状态'] == 5) {
            $data[$k]['状态'] = "取消";
        } elseif ($v['状态'] == 6) {
            $data[$k]['状态'] = "申请退款";
        } elseif ($v['状态'] == 7) {
            $data[$k]['状态'] = "已退款";
        }
        if ($data[$k]['编号'] === $data[$k - 1]['编号']) {
            $data[$k]['订单总价'] = "";
            $data[$k]['订单号'] = "";
            $data[$k]['收货人'] = "";
            $data[$k]['收货电话'] = "";
            $data[$k]['收货省市区'] = "";
            $data[$k]['收货地址'] = "";
            $data[$k]['状态'] = "";
            $data[$k]['下单时间'] = "";
            $data[$k]['支付时间'] = "";
            $data[$k]['支付渠道'] = "";
            $data[$k]['留言'] = "";
            $data[$k]['会员'] = "";
        }
    }
     CaoZuoJiLu('导出订单');
    if ($data !== array()) {
        $res = MX('daochu', 'he')->DC('daochu');
        die();
    } else {       
        XiaoXi('查询结果为空，请重新查询');
    }
    die();
} elseif ($cao == "daochudingdan") {	
    $id = $_J['ddid'];   
    $sql = "select * from ".BM('zw_shangcheng_dingdan_shangpin')." sp left join ".BM('zw_shangcheng_dingdan')." dd on sp.dingdanid=dd.id where sp.dingdanid=" . $id.' and sp.danyuan='.$_W['danyuan'];
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