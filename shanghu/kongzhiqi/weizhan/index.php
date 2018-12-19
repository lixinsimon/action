<?php
DengLu();
//if (empty($_J['d'])) {
//  XiaoXi('您的权限不够！');
//}
QuanXian();
   $fenlei=ChaQuan('select * from '.BM('zw_shanghu_zixunfenlei'),$cen); 
$cao = empty($_J['c']) ? 'moren' : $_J['c'];
if ($cao == 'moren') {
    $search = "";
    if(array_key_exists('search', $_J) && $_J['search'] == 'wenzhang'){
        $search = " and guanjianzi=".trim($_J['guanjianzi']);
    }
   $DangQianYe = max(1, intval($_J['page']));
   $XianJiLu = 20;
   $where=' and shanghu=:shanghu '.$search;
   $cen =array(':shanghu'=>$_W['shanghu']['id']);
   $sql='select * from '.BM('zw_shanghu_zixun').' where 1 '.$where.' order by shijian DESC '; 
   $sql .= "LIMIT " . ($DangQianYe - 1) * $XianJiLu . ',' . $XianJiLu;  
   $wenzhang=ChaQuan($sql,$cen); 
   foreach($wenzhang as $k=>$l){
   		$a = ZiFuChuan_Zhuan_ShuZu($l['suoluetu']);
	    $wenzhang[$k]['suoluetu'] = $a;
   }
   $shu=ChaZongShu('select count(*) from '.BM('zw_shanghu_zixun').' where 1 '.$where.'',$cen); 
   $fenye=FenYe($shu,$DangQianYe,$XianJiLu); 
} elseif ($cao == 'tianjia' && $_W['ispost']) {
    if (empty($_J['biaoti'])) {
        XiaoXi('标题不能为空！');
    }
    if (empty($_J['guanjianzi'])) {
        XiaoXi('关键词不能为空！');
    }
    if (empty($_J['neirong'])) {
        XiaoXi('内容不能为空！');
    }
    $wenzhang = array(
        'danyuan' => $_W['danyuan'],
        'paixu' => intval($_J['paixu']),
        'biaoti' => trim($_J['biaoti']),
        'guanjianzi' => trim($_J['guanjianzi']),
        'zidingyishuxing' => trim($_J['zidingyishuxing']),
        'laiyuan' => trim($_J['laiyuan']),
        'zuozhe' => trim($_J['zuozhe']),
        'jianjie' => trim($_J['jianjie']),
        'suoluetu' => trim($_J['suoluetu']),
        'zhengwenxianshi' => intval($_J['zhengwenxianshi']),
        'leibie' => intval($_J['leibie']),
        'neirong' => $_J['neirong'],
        'zhijielianjie' => trim($_J['zhijielianjie']),
        'yueducishu' => intval($_J['yueducishu']),
        'shijian' => SHIJIAN,
        'shanghu'=>$_W['shanghu']['id']
    );
    ChaRu('zw_shanghu_zixun', $wenzhang);
    XiaoXi('添加成功！', US('weizhan'));
}elseif ($cao == 'bianji_') {
    $where=' and shanghu=:shanghu and id=:id';
    $cen =array(':shanghu'=>$_W['shanghu']['id'],':id'=>intval($_J['wenzhang_id']));
    $wenzhang=Cha('select * from '.BM('zw_shanghu_zixun').' where 1 '.$where.' ',$cen);   
    $fenlei=ChaQuan('select * from '.BM('zw_shanghu_zixunfenlei').' where danyuan='.$_W['danyuan']);  
}else if($cao == "shanchu"){
    ShanChu('zw_shanghu_zixun', array("shanghu"=>$_W['shanghu']['id'], "id"=>intval($_J['wenzhang_id'])));
    XiaoXi('删除成功！', US('weizhan'));
}else if($cao == "xiugai"){
    $wenzhang = array(
         'danyuan' => $_W['danyuan'],
        'paixu' => intval($_J['paixu']),
        'biaoti' => trim($_J['biaoti']),
        'guanjianzi' => trim($_J['guanjianzi']),
        'zidingyishuxing' => trim($_J['zidingyishuxing']),
        'laiyuan' => trim($_J['laiyuan']),
        'zuozhe' => trim($_J['zuozhe']),
        'jianjie' => trim($_J['jianjie']),
        'suoluetu' => trim($_J['suoluetu']),
        'zhengwenxianshi' => intval($_J['zhengwenxianshi']),
        'leibie' => intval($_J['leibie']),
        'neirong' => $_J['neirong'],
        'zhijielianjie' => trim($_J['zhijielianjie']),
        'yueducishu' => intval($_J['yueducishu']),
        'shijian' => SHIJIAN,
        'shanghu'=>$_W['shanghu']['id']
    );
    Gai('zw_shanghu_zixun', $wenzhang, array('id' => $_J['id']));
    XiaoXi('修改成功！', US('weizhan'));
}

mb("wenzhang");
