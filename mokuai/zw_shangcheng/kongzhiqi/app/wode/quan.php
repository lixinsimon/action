<?php 
DengLu();
$cao=empty($_J['c'])?'moren':$_J['c'];	
if ($cao == 'moren' && $_W['ispost']){
	$shijian=time();
  	 $DangQianYe = max(1, $_J['ye']);
     $quTiaoShu =  max(1, $_J['jitiao']);
     $tj='';
     if($_J['cha']=='weiyong'){
     	 $tj='huiyuan='.$_W['huiyuan']['id'].' and danyuan='.$_W['danyuan'].' and  zhuangtai=0 and jieshu_shijian >'.$shijian;
     }elseif($_J['cha']=='yiyong'){
     	 $tj='huiyuan='.$_W['huiyuan']['id'].' and danyuan='.$_W['danyuan'].' and zhuangtai !=0';
     }elseif($_J['cha']=='guoqi'){
     	 $tj='huiyuan='.$_W['huiyuan']['id'].' and danyuan='.$_W['danyuan'].' and jieshu_shijian <='.$shijian;
     }
    
     
     $sql='select * from '.BM('zw_shangcheng_quan_wode').' where '. $tj.' order by lingqu_shijian DESC Limit '.($DangQianYe - 1) * $quTiaoShu.','.$quTiaoShu; 
   
     $quan=ChaQuan($sql);
    if($quan){
    	foreach($quan as $k=>$y){
	    	$quan[$k]['jieshu_shijian']=date('Y-m-d ',$y['jieshu_shijian']);
	    	$quan[$k]['kaishi_shijian']=date('Y-m-d ',$y['kaishi_shijian']);
	    }  
	    json($quan);
    }
     json('没有了',0);
}
mb('quan');
?>