<?php
/**
 * [商城开源系统] Copyright (c) 2014 ZhiWi.COM
 *  商城群QQ：628361862  进群下载更新包 交流技术   http://www.ZhiWi.com/.
 */
DengLu();

if ($cao == 'moren' && $_W['ispost']) {
    $lujing=MX('api')->HaiBao($_W['huiyuan']['id']);
    if(empty($lujing)){
        json('推广二维码海报生成失败',0);
    }
    $fenxiang = array();
    $fenxiang['bianti'] = empty($_W['shezhi']["fenxiang"]['ming']) ? $_W['shezhi']["shizhi"]['ming'] : $_W['shezhi']["fenxiang"]['ming'];
    $fenxiang['miaoshu'] = empty($_W['shezhi']["fenxiang"]['miaoshu']) ? '' : $_W['shezhi']["fenxiang"]['miaoshu'];
    if ($_W['shezhi']["fenxiang"]['tubiao']) {
        $fenxiang['tu'] = JueDuiUrl($_W['shezhi']["fenxiang"]['tubiao']);
    } else {
        $fenxiang['tu'] = $_W['shezhi']["shizhi"]['logo'];
    }
    $url=UAK('index');
    $fenxiang['url'] = empty($_W['shezhi']["fenxiang"]['url']) ? $url : $_W['shezhi']["fenxiang"]['url'];
    $shu = MB('biaoqian/tuiguang', 'TEMPLATE_FETCH');
    json($shu);
}elseif($cao=='xiaocheng'){
	$S['img']=MX('api')->XiaoChengXuHaiBao($_W['huiyuan']['id']);	
    if(empty($S['img'])){
        json('推广二维码海报生成失败',0);
    }  
    $S['bianti'] = empty($_W['shezhi']["fenxiang"]['ming']) ? $_W['shezhi']["shizhi"]['ming'] : $_W['shezhi']["fenxiang"]['ming'];
    $S['miaoshu'] = empty($_W['shezhi']["fenxiang"]['miaoshu']) ? '' : $_W['shezhi']["fenxiang"]['miaoshu'];
    if ($_W['shezhi']["fenxiang"]['tubiao']) {
        $S['tu'] = JueDuiUrl($_W['shezhi']["fenxiang"]['tubiao']);
    } else {
        $S['tu'] = $_W['shezhi']["shizhi"]['logo'];
    }
    $url=UAK('index');
    $S['url'] = empty($_W['shezhi']["fenxiang"]['url']) ? $url : $_W['shezhi']["fenxiang"]['url'];   
    json($S);
}elseif($cao=='xiazhai'){
	
	
	$lujing=MX('api')->HaiBao($_W['huiyuan']['id'],'','xiazhai');
	if(empty($lujing)){
		json('生成失败',0);
	}
	json($lujing."?v=".SHIJIAN);
}

mb('tuiguang');
