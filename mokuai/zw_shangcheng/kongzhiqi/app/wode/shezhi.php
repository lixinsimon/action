<?php
DengLu();
$cao = empty($_J['c']) ? 'moren' : $_J['c'];
if ($cao == 'moren') {
	$huiyuan = MX()->quHuiYuan();
	$huiyuan['touxiang'] = empty($huiyuan['touxiang']) ? '../gongyong/images/morentu.png' : JueDuiUrl($huiyuan['touxiang']);
	
	if($huiyuan['fuji_id']){
		$fj=Cha('select nicheng from '.BM('he_huiyuan').' where id='.$huiyuan['fuji_id']);
		$huiyuan['fuji_ming']=$fj['nicheng'];
	}

	
	if ($_W['ispost']) {
		json($huiyuan);
	}
}
mb('shezhi');
?>