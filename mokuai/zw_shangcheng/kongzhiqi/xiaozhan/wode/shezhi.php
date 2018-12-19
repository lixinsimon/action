<?php

DengLu();

$cao = empty($_J['c']) ? 'moren' : $_J['c'];
if ($cao == 'moren') {
	$huiyuan = MX()->quHuiYuan();
	$huiyuan['touxiang'] = empty($huiyuan['touxiang']) ? '../gongyong/images/morentu.png' : JueDuiUrl($huiyuan['touxiang']);
	if ($_W['ispost']) {
		json($huiyuan);
	}
}
mb('shezhi');
?>