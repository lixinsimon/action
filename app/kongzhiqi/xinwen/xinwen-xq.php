<?php
$cao = empty($_J['c']) ? 'moren' : $_J['c'];
if ($cao == 'moren') {
    pdo_query("update " . BM('he_wenzhang') . " set yueducishu=yueducishu+1 where id=".intval($_J['id']));

    $tj = " and id=".intval($_J['id']);
    $wenzhang_sql = "select * from " . BM('he_wenzhang') . ' where 1 ' . $tj ;

    $wenzhang = ChaQuan($wenzhang_sql);
    $wenzhang = $wenzhang[0];
} else if($cao=='app'){
    pdo_query("update " . BM('he_wenzhang') . " set yueducishu=yueducishu+1 where id=".intval($_J['id']));

    $tj = " and id=".intval($_J['id']);
    $wenzhang_sql = "select * from " . BM('he_wenzhang') . ' where 1 ' . $tj ;

    $wenzhang = ChaQuan($wenzhang_sql);
    $wenzhang = $wenzhang[0];
    $wenzhang['shijian'] = date("Y-m-d h:i:s", $wenzhang['shijian']);
    $wenzhang['neirong'] = htmlspecialchars_decode($wenzhang['neirong']);
    json($wenzhang);
}
mb('xinwen-xq');
?>