<?php
DengLu();
if (empty($_J['d'])) {
    XiaoXi('您的权限不够！');
}
$cao = empty($_J['c']) ? 'moren' : $_J['c'];
if ($cao == 'ccb') {
    if ($_J['val'] == 1) {
        echo 0;
        $val = 0;
    } else {
        $val = 1;
        $result=ChaQuan('select id from ims_zw_shangcheng_haibao where leixing ='.$_J['leixing']);
        $res1=json_encode($result);
        echo $res1;
        foreach ($result as $k=>$v){
            YunSQL('update ims_zw_shangcheng_haibao set moren ="' . $_J['val'] . '" where id=' . $v['id']);
        }
    }

    $res = YunSQL('update ims_zw_shangcheng_haibao set moren ="' . $val . '" where id=' . $_J['id']);
} elseif ($cao == "shanchu") {
    $id=array('id'=>$_J['id']);
    $table="zw_shangcheng_haibao";
    $res=ShanChu($table,$id);
    XiaoXi("清理成功");
}