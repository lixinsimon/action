<?php
Denglu();
$cao = empty($_J['c']) ? 'moren' : $_J['c'];
if ($cao == 'moren') {
    $huiyuan=MX()->quHuiYuan();
     $zhi = array('xingming', 'xingbie', 'nicheng', 'shouji','dizhi');
    foreach($zhi as $k=>$y){
    	if(empty($huiyuan[$y])){
    		$huiyuan[$y]="";
    	}
    	
    }
    $huiyuan['touxiang']=empty($huiyuan['touxiang'])?'../gongyong/images/morentu.png':JueDuiUrl($huiyuan['touxiang']); 	
	if(empty($huiyuan['shengfen'])){
		$huiyuan['shengfen']='湖南';
	}
	if(empty($huiyuan['chengshi'])){
		$huiyuan['chengshi']='长沙市';
	}
	if(empty($huiyuan['quxian'])){
		$huiyuan['quxian']='芙蓉区';
	}
    if($_W['ispost']){
        json($huiyuan);
    }
} else if ($cao == 'xiugaixinxi') {
	$shengshiqu=trim($_J['shengshiqu']);
	$ssq=explode(' ',$shengshiqu);	
	$qita['yingyezhizhao']=$_J['yingyezhizhao'];
	$qita['dianzhao']=$_J['dianzhao'];
    $canshu = array(
        "xingming" => trim($_J["xingming"]),
        "nicheng" => trim($_J["nicheng"]),
        "xingbie" => trim($_J["sex"]),
        "shouji" => trim($_J["shouji"]),
        "shengfen" =>$ssq[0],
        "chengshi" => $ssq[1],
        "quxian" => $ssq[2],
        "dizhi" => trim($_J["dizhi"]),
        "shijian" => time(),
        "qita"=>ShuZu_Zhuan_ZiFuChuan($qita),
    );
    Gai('he_huiyuan', $canshu, array('id' => $_W['huiyuan']['id'], 'danyuan' => $_W['danyuan']));
    json('信息修改成功', 1);
}
mb('xiugaixinxi');
