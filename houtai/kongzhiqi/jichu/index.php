<?php
DengLu();
if(empty($_J['d'])){
   XiaoXi('您的权限不够！');
}
$cao=empty($_J['c'])?'moren':$_J['c'];
if($cao=='moren'){
	if($_W['ispost']){
	   if(empty($_J['ming'])){
	   	  XiaoXi('名称不能为空！');
	   }
	   if(empty($_J['ci'])){
	   	  XiaoXi('关键词不能为空！');
	   }
	   if(empty($_J['neirong'])){
	   	  XiaoXi('内容不能为空！');
	   }
	    $weizi=array(
	        'danyuan'=>$_W['danyuan'],  
	        'ming'=>trim($_J['ming']),  
	        'ci'=>trim($_J['ci']), 
	        'leixing'=>'wenzi', 
	        'shunxu'=>intval($_J['shunxu']), 
	        'zhuangtai'=>intval($_J['zhuangtai']),   
	        'neirong'=>$_J['neirong'],
	        'shijian'=>time()   
	        );
	    $id=intval($_J['id']);	  
	    if($id>0){    
	    	unset($weizi['shijian']);
	    	Gai('he_huifu',$weizi,array('id'=>$id,'danyuan'=>$_W['danyuan']));
	        XiaoXi('更新成功！',UH('jichu'));
	    }else{
	        ChaRu('he_huifu',$weizi);
	        XiaoXi('添加成功！',UH('jichu'));
	    }
   }
   $DangQianYe = max(1, intval($_J['page']));
   $XianJiLu = 20;
   $where=' and danyuan=:danyuan and leixing="wenzi"';
   $cen =array(':danyuan'=>$_W['danyuan']);
   $sql='select * from '.BM('he_huifu').' where 1 '.$where.' order by shijian DESC '; 
   $sql .= "LIMIT " . ($DangQianYe - 1) * $XianJiLu . ',' . $XianJiLu;  
   $huifu=ChaQuan($sql,$cen);      
   $shu=ChaZongShu('select count(*) from '.BM('he_huifu').' where 1 '.$where.'',$cen); 
   $fenye=FenYe($shu,$DangQianYe,$XianJiLu); 
}elseif ($cao=="bianji") {
	$where=' and danyuan=:danyuan and leixing="wenzi" and id=:id';
    $cen =array(':danyuan'=>$_W['danyuan'],':id'=>intval($_J['id']));
	$huifu=Cha('select * from '.BM('he_huifu').' where 1 '.$where.' ',$cen);	
	mb("biaoqian/wenzi_2");exit;
}elseif($cao=='shanchu'){	
	ShanChu('he_huifu',array('id'=>$_J['id'],'danyuan'=>$_W['danyuan']));
	CaoZuoJiLu('删除自定义回复'); 
	XiaoXi('删除成功！',UH('jichu'));
}
mb("wenzi");
?>