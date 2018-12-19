<?php
QuanXian();
if ($cao == 'moren') {
    if ($_J['haibaoming']) {
        $hblie = ChaQuan('select * from '.BM('zw_shangcheng_haibao').' where danyuan='.$_W['danyuan'].' and ming like "%' . $_J['haibaoming'] . '%"');
        $hblienum = ChaQuan('select count(*) from '.BM('zw_shangcheng_haibao').' where  danyuan='.$_W['danyuan'].' and ming like "%' . $_J['haibaoming'] . '%"');
    } else {
        $hblie = ChaQuan('select * from '.BM('zw_shangcheng_haibao').' where  danyuan='.$_W['danyuan']);
        $hblienum = ChaQuan('select count(*) from  '.BM('zw_shangcheng_haibao'). 'where  danyuan='.$_W['danyuan']);
    }


} elseif ($cao == 'post') {
    if (intval($_J['id'])) {
        $map = array('id' => $_J['id'],'danyuan'=>$_W['danyuan']);
        $hb = Qu('zw_shangcheng_haibao', $map);
        if(empty($hb)){
            XiaoXi('不存在');exit;
        }
        
        $hb['tuisong'] = unserialize($hb['tuisong']);
        $hb['song'] = unserialize($hb['song']);
        $hb['tongzhi'] = unserialize($hb['tongzhi']);
        $hb['data'] = json_decode(htmlspecialchars_decode($hb['data']), true);
		}

} elseif ($cao == 'tijiao' && $_W['ispost']) {
    if (empty($_J['ming'])) {
        XiaoXi("请输入海报名称");
        exit;
    }
    if ($_J['ming']) {
        $datas['ming'] = $_J['ming'];
        $datas['leixing'] = $_J['leixing'];
        $datas['guanjianci'] = $_J['guanjianci'];
        $datas['moren'] = $_J['moren'];
        $datas['bg'] = $_J['bg'];
        $datas['img'] = $_J['img'];
        $datas['dengdaitishi'] = $_J['dengdaitishi'];
        $datas['kaifang'] = $_J['kaifang'];
        $datas['bukaifangtishi'] = $_J['bukaifangtishi'];
        $datas['bukaifangurl'] = $_J['bukaifangurl'];
        $datas['tuisong'] = serialize($_J['tuisong']);
        $datas['song'] = serialize($_J['song']);
        $datas['tongzhi'] = serialize($_J['tongzhi']);
        $datas['data'] = $_J['data'];
        $huifu=array();
        $huifu['guanjianci']= $datas['guanjianci'];
        $huifu['lei']='api';
        $huifu['fangfa']='quHaiBao';
        if ($_J['id']) {
            $map['id'] = $_J['id'];
            $map['danyuan'] = $_W['danyuan'];
            Gai('zw_shangcheng_haibao', $datas, $map);
            $huifu['id']= $_J['id'];                 
            $ts='修改成功';
            CaoZuoJiLu('修改海报'); 
        } else {
            $datas['danyuan'] = $_W['danyuan'];
            $datas['status'] = 1;
            $datas['time'] = time();
            ChaRu('zw_shangcheng_haibao', $datas);
            $huifu['id']=ChaRuId();          
            $ts='插入成功';
            CaoZuoJiLu('新增海报'); 
        }
        MX('weixin','he')->ChaRu_Gai($huifu);   
       
        XiaoXi($ts);
    }

} elseif ($cao == 'guanzhu') {
    mb('biaoqian/haibao_guanzhu');
    exit;
} elseif ($cao == 'delCache') {
    $fileName = GENMULU . "/huancun/haibao/";
    Han('wenjian');
    rmdirs($fileName);
    CaoZuoJiLu('清理海报缓存'); 
    XiaoXi('清理成功');
}elseif($cao=='shanchu'){
    ShanChu('zw_shangcheng_haibao',array('id'=>$_J['id'],'danyuan'=>$_W['danyuan']));
    MX('weixin','he')->ShanChu($_W['mo'].'|api|quHaiBao|'.$_J['id']);  
    CaoZuoJiLu('删除海报'); 
    XiaoXi('删除成功！'); 
}

mb("haibao");
?>