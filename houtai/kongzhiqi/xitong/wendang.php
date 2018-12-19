<?php
DengLu();
if (empty($_J['d'])) {
    XiaoXi('您的权限不够！');
}
QuanXian();

if ($cao == 'moren') {	
    $search = "";   
   $DangQianYe = max(1, intval($_J['page']));
   $XianJiLu = 20;
   $where=' and danyuan=:danyuan '.$search;
   $cen =array(':danyuan'=>$_W['danyuan']);
   $sql='select * from '.BM('zw_wendang').' where 1 '.$where.' order by shijian DESC '; 
   $sql .= "LIMIT " . ($DangQianYe - 1) * $XianJiLu . ',' . $XianJiLu;  
   $wendang=ChaQuan($sql,$cen);      
   $shu=ChaZongShu('select count(*) from '.BM('zw_wendang').' where 1 '.$where.'',$cen); 
   $fenye=FenYe($shu,$DangQianYe,$XianJiLu); 
   $fenlei=ChaQuan('select * from '.BM('zw_wendang_fenlei'),$cen); 
  
} elseif ($cao == 'tianjia' && $_W['ispost']) {
    if (empty($_J['biaoti'])) {
        XiaoXi('标题不能为空！');
    }   
    if (empty($_J['neirong'])) {
        XiaoXi('内容不能为空！');
    }
    $wendang = array(
        'danyuan' => $_W['danyuan'],
        'paixu' => intval($_J['paixu']),
        'biaoti' => trim($_J['biaoti']),
        'jianjie' => trim($_J['jianjie']),
        'leibie' => intval($_J['leibie']),
        'neirong' => $_J['neirong'],
        'shijian' => time(),
    );
    ChaRu('zw_wendang', $wendang);
    CaoZuoJiLu('新增文档'); 
    XiaoXi('添加成功！', UH('xitong/wendang'));

}elseif ($cao == 'bianji_') {
    $where=' and danyuan=:danyuan and id=:id';
    $cen =array(':danyuan'=>$_W['danyuan'],':id'=>intval($_J['wendang_id']));
    $wendang=Cha('select * from '.BM('zw_wendang').' where 1 '.$where.' ',$cen);   
    $fenlei=ChaQuan('select * from '.BM('zw_wendang_fenlei').' where danyuan='.$_W['danyuan']);  
}else if($cao == "shanchu"){
    ShanChu('zw_wendang', array("danyuan"=>$_W['danyuan'], "id"=>intval($_J['wendang_id'])));
     CaoZuoJiLu('删除文档'); 
    XiaoXi('删除成功！', UH('xitong/wendang'));
}else if($cao == "xiugai"){
    $wendang = array(
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
    Gai('zw_wendang', $wendang, array("danyuan" => $_W['danyuan'], 'id' => $_J['id']));
    CaoZuoJiLu('修改文档'); 
    XiaoXi('修改成功！', UH('xitong/wendang'));
}

mb("wendang");
