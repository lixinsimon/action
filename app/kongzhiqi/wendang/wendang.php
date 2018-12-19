<?php
if($cao == 'moren' && $_W['ispost']){		
	$l = Chaquan('select * from '.BM('zw_wendang'));	
	foreach ($l as $k => $value) {
		$l[$k]['neirong'] = htmlspecialchars_decode($l[$k]['neirong']);
	}	
	json($l);	
}
mb('wendang')
?>
