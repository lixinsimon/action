<?php
DengLu();
if(empty($_J['d'])){
   XiaoXi('您的权限不够！');
}
QuanXian();
$cao=empty($_J['c'])?'moren':$_J['c'];
if($cao=='moren'){
	$DangQianYe = max(1, intval($_J['page']));
   $XianJiLu = 20;
   $where=' and danyuan=:danyuan ';
   $cen =array(':danyuan'=>$_W['danyuan']);
   $sql='select * from '.BM('zw_shanghu_zixunfenlei').' where 1 '.$where.' order by id DESC '; 
   $sql .= "LIMIT " . ($DangQianYe - 1) * $XianJiLu . ',' . $XianJiLu;  
   $fenlei=ChaQuan($sql,$cen);   
   $shu=ChaZongShu('select count(*) from '.BM('zw_shanghu_zixunfenlei').' where 1 '.$where.'',$cen); 
   $fenye=FenYe($shu,$DangQianYe,$XianJiLu); 
}else if ($cao == 'tianjia') {
    if (empty($_J['ming'])) {
        XiaoXi('名称不能为空！');
    }
    $fenlei = array(
        'danyuan' => $_W['danyuan'],
        'shuxu' => intval($_J['shuxu']),
        'ming' => trim($_J['ming']),
    );
    ChaRu('zw_shanghu_zixunfenlei', $fenlei);
    XiaoXi('添加成功！', US('weizhan/fenlei'));
}else if ($cao == 'bianji') {
    $where=' and danyuan=:danyuan and id=:id';
    $cen =array(':danyuan'=>$_W['danyuan'],':id'=>intval($_J['id']));
    $fenlei=Cha('select * from '.BM('zw_shanghu_zixunfenlei').' where 1 '.$where.' ',$cen);    
    mb("biaoqian/fenlei_edit");exit;
}else if ($cao == 'bianji_tijiao') {
    $fenlei = array(
        'shuxu' => intval($_J['shuxu']),
        'ming' => trim($_J['ming']),
    );
    Gai('zw_shanghu_zixunfenlei', $fenlei, array("danyuan" => $_W['danyuan'], 'id' => $_J['id']));
    XiaoXi('修改成功！', US('weizhan/fenlei'));
}else if ($cao == 'shanchu') {
    ShanChu('zw_shanghu_zixunfenlei', array("danyuan"=>$_W['danyuan'], "id"=>intval($_J['fenlei_id'])));
    XiaoXi('删除成功！', US('weizhan/fenlei'));
}

mb("fenlei");
?>