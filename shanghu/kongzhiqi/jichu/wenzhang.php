<?php
DengLu();
if (empty($_J['d'])) {
    XiaoXi('您的权限不够！');
}
QuanXian();
$cao = empty($_J['c']) ? 'moren' : $_J['c'];
$fenlei1=ChaQuan('select * from '.BM('he_wenzhang_fenlei').' where danyuan='.$_W['danyuan']); 
if ($cao == 'moren') {
    $search = "";
    if(array_key_exists('search', $_J) && $_J['search'] == 'wenzhang'){
        $search = " and (guanjianzi like '%".trim($_J['guanjianzi'])."%' or biaoti like '%".trim($_J['guanjianzi'])."%')";
    }
   $DangQianYe = max(1, intval($_J['page']));
   $XianJiLu = 20;
   $where='and shanghu = '.$_W['shanghu']['id'].' and danyuan=:danyuan '.$search;
   $cen =array(':danyuan'=>$_W['danyuan']);
   $sql='select * from '.BM('he_wenzhang').' where 1 '.$where.' order by shijian DESC '; 
   $sql .= "LIMIT " . ($DangQianYe - 1) * $XianJiLu . ',' . $XianJiLu;  
   $wenzhang=ChaQuan($sql,$cen);      
   $shu=ChaZongShu('select count(*) from '.BM('he_wenzhang').' where 1 '.$where.'',$cen); 
   $fenye=FenYe($shu,$DangQianYe,$XianJiLu); 
//  $fenlei=ChaQuan('select * from '.BM('he_wenzhang_fenlei').' where danyuan='.$_W['danyuan']);
} elseif ($cao == 'tianjia' && $_W['ispost']) {

	
    if (empty($_J['biaoti'])) {
        XiaoXi('标题不能为空！');
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
        'tiquneirongtu' => intval($_J['tiquneirongtu']),
        'zhijielianjie' => trim($_J['zhijielianjie']),
        'yueducishu' => intval($_J['yueducishu']),
        'jifenzhi' => intval($_J['jifenzhi']),
        'shifouzengsongjifen' => intval($_J['shifouzengsongjifen']),
        'shijian' => time(),
        'shanghu'=>$_W['shanghu']['id']
    );
    ChaRu('he_wenzhang', $wenzhang);
    XiaoXi('添加成功！', US('jichu/wenzhang'));

}elseif ($cao == 'bianji_') {
    $where=' and danyuan=:danyuan and id=:id';
    $cen =array(':danyuan'=>$_W['danyuan'],':id'=>intval($_J['wenzhang_id']));
    $wenzhang=Cha('select * from '.BM('he_wenzhang').' where 1 '.$where.' ',$cen);   
    $fenlei=ChaQuan('select * from '.BM('he_wenzhang_fenlei').' where danyuan='.$_W['danyuan']);  
}else if($cao == "shanchu"){
    ShanChu('he_wenzhang', array("danyuan"=>$_W['danyuan'], "id"=>intval($_J['wenzhang_id'])));
    XiaoXi('删除成功！', US('jichu/wenzhang'));
}else if($cao == "xiugai"){
    $wenzhang = array(
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
        'tiquneirongtu' => intval($_J['tiquneirongtu']),
        'zhijielianjie' => trim($_J['zhijielianjie']),
        'yueducishu' => intval($_J['yueducishu']),
        'jifenzhi' => intval($_J['jifenzhi']),
        'shifouzengsongjifen' => intval($_J['shifouzengsongjifen']),
        'shijian' => time(),
    );
    Gai('he_wenzhang', $wenzhang, array("danyuan" => $_W['danyuan'], 'id' => $_J['id']));
    XiaoXi('修改成功！', US('jichu/wenzhang'));
}

mb("wenzhang");
