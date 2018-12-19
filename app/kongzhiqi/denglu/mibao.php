<?php
DengLu();
$cao=empty($_J['c'])?'moren':$_J['c'];
if($_W['ispost'] && $cao=='moren'){	
	$qita=Qu('he_huiyuan',array('id'=>$_W['huiyuan']['id']),'qita');
  	json(ZiFuChuan_Zhuan_ShuZu($qita['qita']));
}elseif($cao=='gai'&& $_W['ispost']){
 	if(empty($_J['wen']) || empty($_J['da'])){
   		json('不为空',0);
   	}
   	$qita=Qu('he_huiyuan',array('id'=>$_W['huiyuan']['id']),'qita');
  	$qt=ZiFuChuan_Zhuan_ShuZu($qita['qita']);
  	$qt['wen']=$_J['wen'];
  	$qt['da']=$_J['da'];
		  	
  	$q=ShuZu_Zhuan_ZiFuChuan($qt);
  	Gai('he_huiyuan',array('qita'=>$q),array('id'=>$_W['huiyuan']['id']));
  	json('修改成功');
}	
	
mb('mibao');
?>