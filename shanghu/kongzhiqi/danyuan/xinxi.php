<?php
DengLu();

$cao=empty($_J['c'])?'moren':$_J['c'];
if($cao=='moren'){	
	$xiaochengxu_erweima=MX('xiaochengxu','he')->ErWeiMa();	
}
mb('xinxi');
?>