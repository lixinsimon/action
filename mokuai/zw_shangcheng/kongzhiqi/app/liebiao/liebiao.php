<?php
/**
 * [商城开源系统] Copyright (c) 2014 ZhiWi.COM
 *  商城群QQ：628361862  进群下载更新包 交流技术   http://www.ZhiWi.com/.
 */
DengLu(true);
function quQuanShangPin($quTiaoShu = 20, $DangQianYe = 1, $ZiDuan = '*', $TiaoJian = '', $PaiXu = 'shijian DESC')
{
    global $_W;
    $ZiDuan = empty($ZiDuan) ? '*' : $ZiDuan;
    $DangQianYe = empty($DangQianYe) ? 1 : $DangQianYe;
    $quTiaoShu = empty($quTiaoShu) ? 20 : $quTiaoShu;
    $sql = "select " . $ZiDuan . " from " . BM('zw_shangcheng_shangpin') . ' where 1 and ' . $TiaoJian . " and danyuan=" . $_W['danyuan'];
    // foreach($TiaoJian as $k=>$tj){
    //     if(is_numeric($tj)){
    //         $sql.=" and ".ltrim($k,':').'='.$tj;
    //     }elseif(is_array($tj)){
    //         $sql.=" and ".$tj[0];
    //     }else{
    //         $sql.=" and ".ltrim($k,':')."='".$tj."'";
    //     }
    // }
    $sql .= " order by " . $PaiXu;
    $sql .= ' Limit ' . ($DangQianYe - 1) * $quTiaoShu . ',' . $quTiaoShu;
    $sp = ChaQuan($sql);
    if ($sp) {
        foreach ($sp as $k => $s) {
            if ($s['fenlei_yiji']) {
                $fenlei_yiji_ming = MX()->quFenLei($s['fenlei_yiji'], 'ming');
                $sp[$k]['fenlei_yiji_ming'] = $fenlei_yiji_ming['ming'];
            }
            if ($s['fenlei_erji']) {
                $fenlei_erji_ming = MX()->quFenLei($s['fenlei_erji'], 'ming');
                $sp[$k]['fenlei_erji_ming'] = $fenlei_erji_ming['ming'];
            }
            if ($s['tu']) {
                $sp[$k]['tu'] = JueDuiUrl($s['tu']);
            }
        }
    }
    return $sp;
}

$cao = empty($_J['c']) ? 'moren' : $_J['c'];
$search = '';
if (array_key_exists('search', $_J)) {
    $search = trim($_J['search']);
}
if ($_W['ispost']) {
    if ($search) {
        $ye = max(1, $_J['ye']);
        $ziduan = "id,ming,fenlei_yiji,fenlei_erji,shunxu,danwei,xinpin,tuijian,cuxiao,baoyou,miaosha,kaishishijian,jieshushijian,tu,xijietu,jiage,yuanjia,kucun";
        $shangpinlie = quQuanShangPin(10, $ye, $ziduan, "ming like '%{$search}%' and zhuangtai=1");
        if ($shangpinlie) {
            $shu = array('shangpinlie' => $shangpinlie);
            json($shu);
        } else {
            json('没有了', 0);
        }
    }
    json('请输入关键字', 0);
}
mb('liebiao');
