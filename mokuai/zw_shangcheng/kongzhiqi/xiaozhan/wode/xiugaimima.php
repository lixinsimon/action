<?php

Denglu();

$cao = empty($_J['c']) ? 'moren' : $_J['c'];
if ($cao == 'xiugaimima') {
	$oldpass = trim($_J['oldpass']);
	$newpass = trim($_J['newpass']);
	$newpass_len = mb_strlen($newpass, 'UTF8');
	if ($newpass_len < 6 || $newpass_len > 20) {
		json('密码6-20个！', 0);
	}
	$mima = Cha('select mima from ' . BM('he_huiyuan') . ' where danyuan=' . $_W['danyuan'] . ' and id=' . $_W['huiyuan']['id']);
	if ($mima['mima'] != md5($oldpass)) {
		json('旧密码错误！', 0);
	}
	$xiugai = array(
		'danyuan' => $_W['danyuan'],
		'mima' => md5($newpass),
		'shijian' => time(),
		'ip' => GetIp(),
	);
	Gai('he_huiyuan', $xiugai, array('id' => $_W['huiyuan']['id'], 'danyuan' => $_W['danyuan']));
	json('修改成功', 1);
}
mb('xiugaimima');

?>