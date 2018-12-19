<?php
DengLu();
if(empty($_J['d'])){
   XiaoXi('您的权限不够！');
}
$cao=empty($_J['c'])?'moren':$_J['c'];
if($cao=='moren'){
   $DangQianYe = max(1, intval($_J['page']));
   $XianJiLu = 2;
   $where='mokuai="jichu_tuwen" and danyuan='.$_W['danyuan']; 
   $sql='select * from '.BM('he_huifu').' where '.$where.' order by shijian DESC '; 
   $sql .= "LIMIT " . ($DangQianYe - 1) * $XianJiLu . ',' . $XianJiLu;  
   $tuwen=ChaQuan($sql); 
   $ZongShu=ChaZongShu('select count(*) from '.BM('he_huifu').' where  '.$where);
   $fenye=FenYe($ZongShu,$DangQianYe,$XianJiLu);
	
}elseif($cao=='post' && $_W['ispost']){
	 if(empty($_J['ming'])){
	   	  XiaoXi('名称不能为空！');
	   }
	   if(empty($_J['ci'])){
	   	  XiaoXi('关键词不能为空！');
	   }

	   $ids=''	;
	   foreach ($_J['ids'] as $v) {
	         if($v){
	         	$ids.=$v.',';
	         }
	      }
	    if(empty($ids)){
	    	 XiaoXi('回复内容不为空！');
	    }   
	    $weizi=array(
	        'danyuan'=>$_W['danyuan'],  
	        'ming'=>trim($_J['ming']),  
	        'ci'=>trim($_J['ci']), 
	        'leixing'=>'tuwen', 	        
	        'zhuangtai'=>intval($_J['zhuangtai']),   
	        'neirong'=>rtrim($ids,','),
	        'mokuai'=>'jichu_tuwen',
	        'shijian'=>time()   
	        );
	    $id=intval($_J['id']);	  
	    if($id>0){    
	    	unset($weizi['shijian']);
	    	Gai('he_huifu',$weizi,array('id'=>$id,'danyuan'=>$_W['danyuan']));
	        XiaoXi('更新成功！',UH('jichu/tuwen'));
	    }else{
	        ChaRu('he_huifu',$weizi);
	        XiaoXi('添加成功！',UH('jichu/tuwen'));
	    }
}elseif ($cao=="bianji") {	
    $tw=Qu('he_huifu',array('id'=>$_J['id'],'danyuan'=>$_W['danyuan']));

    $wz=ChaQuan('select * from '.BM('he_wenzhang').' where danyuan='.$_W['danyuan'].' and id in('.$tw['neirong'].')');    
	mb("biaoqian/tuwen_2");exit;
}elseif($cao=='daoru'){
   $DangQianYe = max(1, intval($_J['page']));
   $XianJiLu = 2;
   $where='danyuan='.$_W['danyuan']; 
   $sql='select * from '.BM('he_wenzhang').' where '.$where.' order by shijian DESC '; 
   $sql .= "LIMIT " . ($DangQianYe - 1) * $XianJiLu . ',' . $XianJiLu;  
   $wenzhang=ChaQuan($sql); 

   $ZongShu=ChaZongShu('select count(*) from '.BM('he_wenzhang').' where  '.$where);

   $fenye=FenYe($ZongShu,$DangQianYe,$XianJiLu);
   $html='';
   foreach ($wenzhang as $v) {
     $html.="<tr>
            <td><img src='".JueDuiUrl($v['suoluetu'])."' style='width:40px;height:40px;'/></td> 
            <td>".$v['biaoti']."</td>
            <td>".date('Y-m-d H:i:s',$v['shijian'])."</td>
            <td onclick='xuanze(".$v['id'].",this)'><button type='button' class='btn btn-default' data-dismiss='modal'>选择</button></td>
        </tr>"; 
    }     
    $shu=array('lie'=>$html,'fenye'=>$fenye);
    json($shu);
}elseif($cao=='shanchu'){	
	ShanChu('he_huifu',array('id'=>$_J['id'],'danyuan'=>$_W['danyuan']));
	XiaoXi('删除成功！',UH('jichu/tuwen'));
}

mb("tuwen");
?>