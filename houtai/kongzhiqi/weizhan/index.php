<?php
DengLu();
if (empty($_J['d'])) {
    XiaoXi('您的权限不够！');
}
QuanXian();
   $fenlei=ChaQuan('select * from '.BM('he_wenzhang_fenlei').' where danyuan='.$_W['danyuan']); 
   $feileilie=ChaQuan('select * from '.BM('he_wenzhang_fenlei').' where danyuan='.$_W['danyuan'].' and fuji_id=0  order by shunxu ASC');
	foreach($feileilie as $k=>$feil){
		$feileilie[$k]['haizi']=ChaQuan('select * from '.BM('he_wenzhang_fenlei').' where danyuan='.$_W['danyuan'].' and fuji_id='.$feil['id'].' order by shunxu ASC');
	} 

$cao = empty($_J['c']) ? 'moren' : $_J['c'];
if ($cao == 'moren') {
    $search = "";
    if(array_key_exists('search', $_J) && $_J['search'] == 'wenzhang'){
        $search = " and guanjianzi like '%".trim($_J['guanjianzi']."%'");
    }
   $DangQianYe = max(1, intval($_J['page']));
   $XianJiLu = 20;
   $where=' and danyuan=:danyuan '.$search;
   $cen =array(':danyuan'=>$_W['danyuan']);
   $sql='select * from '.BM('he_wenzhang').' where 1 '.$where.' order by shijian DESC '; 
   $sql .= "LIMIT " . ($DangQianYe - 1) * $XianJiLu . ',' . $XianJiLu;  
   $wenzhang=ChaQuan($sql,$cen); 
   
   foreach($fenlei as $fl){
   		$fenlei[$fl['id']]=$fl;
   }

   foreach($wenzhang as $k=>$l){
	    $wenzhang[$k]['suoluetu'] =JueDuiUrl($l['suoluetu']);
   }
   
        
   $shu=ChaZongShu('select count(*) from '.BM('he_wenzhang').' where 1 '.$where.'',$cen); 
   $fenye=FenYe($shu,$DangQianYe,$XianJiLu); 

  
} elseif ($cao == 'tianjia' && $_W['ispost']) {
    if (empty($_J['biaoti'])) {
        XiaoXi('标题不能为空！');
    }
    if (empty($_J['guanjianzi'])) {
        XiaoXi('关键词不能为空！');
    }
    if (empty($_J['neirong'])) {
        XiaoXi('内容不能为空！');
    }
    $wenzhang = array(
        'danyuan' => $_W['danyuan'],
        'paixu' => intval($_J['paixu']),
        'biaoti' => trim($_J['biaoti']),
        'guanjianzi' => trim($_J['guanjianzi']),
        'zidingyishuxing' => trim($_J['zidingyishuxing']),
        'laiyuan' => trim($_J['laiyuan']),
        'zuozhe' => trim($_J['zuozhe']),
        'jianjie' => trim($_J['jianjie']),
        'suoluetu' => trim($_J['suoluetu']),
        'zhengwenxianshi' => intval($_J['zhengwenxianshi']),
        'leibie' => intval($_J['leibie']),
        'neirong' => $_J['neirong'],
        'tiquneirongtu' => intval($_J['tiquneirongtu']),
        'zhijielianjie' => trim($_J['zhijielianjie']),
        'yueducishu' => intval($_J['yueducishu']),
        'jifenzhi' => intval($_J['jifenzhi']),
        'shifouzengsongjifen' => intval($_J['shifouzengsongjifen']),
        'shijian' => time(),
    );
    ChaRu('he_wenzhang', $wenzhang);
    CaoZuoJiLu('新增文章'); 
    XiaoXi('添加成功！', UH('weizhan'));

}elseif ($cao == 'bianji_') {
    $where=' and danyuan=:danyuan and id=:id';
    $cen =array(':danyuan'=>$_W['danyuan'],':id'=>intval($_J['wenzhang_id']));
    $wenzhang=Cha('select * from '.BM('he_wenzhang').' where 1 '.$where.' ',$cen);   
}else if($cao == "shanchu"){
    ShanChu('he_wenzhang', array("danyuan"=>$_W['danyuan'], "id"=>intval($_J['wenzhang_id'])));
     CaoZuoJiLu('删除文章'); 
    XiaoXi('删除成功！', UH('weizhan'));
}else if($cao == "xiugai"){
    $wenzhang = array(
        'paixu' => intval($_J['paixu']),
        'biaoti' => trim($_J['biaoti']),
        'guanjianzi' => trim($_J['guanjianzi']),
        'zidingyishuxing' => trim($_J['zidingyishuxing']),
        'laiyuan' => trim($_J['laiyuan']),
        'zuozhe' => trim($_J['zuozhe']),
        'jianjie' => trim($_J['jianjie']),
        'suoluetu' => trim($_J['suoluetu']),
        'zhengwenxianshi' => intval($_J['zhengwenxianshi']),
        'leibie' => intval($_J['leibie']),
        'neirong' => $_J['neirong'],
        'tiquneirongtu' => intval($_J['tiquneirongtu']),
        'zhijielianjie' => trim($_J['zhijielianjie']),
        'yueducishu' => intval($_J['yueducishu']),
        'jifenzhi' => intval($_J['jifenzhi']),
        'shifouzengsongjifen' => intval($_J['shifouzengsongjifen']),
        'shijian' => time(),
       	'erji' => intval($_J['erji'])
    );
    Gai('he_wenzhang', $wenzhang, array('id' => $_J['id']));
    CaoZuoJiLu('更新文章'); 
    XiaoXi('修改成功！', UH('weizhan'));
}else if($cao == 'gaizhuangtai'){
		Gai('he_wenzhang',array('_zhuangtai' => 0),array('danyuan'=>$_W['danyuan']));
		Gai('he_wenzhang',array('_zhuangtai' => $_J['_zhuangtai']), array('id' => $_J['id']));
		
}

mb("wenzhang");
function FenLeiXiaLaLieBiao($lie=array(),$yiji=0,$erji=0,$ji=2){	
	$d=array();
	if($lie){
	foreach($lie as $z){
		foreach($z['haizi'] as $zz){
			$h=$zz;
			unset($h['haizi']);
			$d['p_'.$z['id']][]=$h;			
			if($zz['haizi']){
				foreach($zz['haizi'] as $zzz){
					unset($zzz['haizi']);
					$d['p_'.$zz['id']][]=$zzz;
					
				}
			}
			
		}
	}	
	}
	$json=json_encode($d);	
	$random=random(10);
	$html='<script>function fenleinext_'.$random.'(i,e){';
	$html.=' var d='.$json.';';
	$html.=' var id=$(e).val();var html="";var c=Number(i)+Number(1);';
	$html.=' html+="<option value=0>请选择"+c+"级分类</option>";  
	         if(id>0){ 		    
		       for(var b=0;b < d["p_"+id].length;b++){ 		  
	         	   html+="<option value="+ d["p_"+id][b].id +">"+ d["p_"+id][b].ming +"</option>"; 	
		       }
	         }';	
	$html.=' $("#'.$random.'"+i).html(html);';
	$html.='}</script>';
	
	for($i=0;$i<$ji;$i++){
		$html.='<div class="col-sm-5">';
	    $html.='<select id="'.$random.$i.'" name="';
	    if($i==0){
	    	 $html.='leibie';
	    }else{
	    	 $html.='erji';
	    }
	    
	    $html.='" class="form-control" onchange="fenleinext_'.$random.'('.($i+1).',this)">';
	    $html.='<option value=0>请选择'.($i+1).'级分类</option>';	  
	    if(empty($i)){
	    	if($lie){  
			    foreach($lie as $l){
			    	$html.='<option value="'.$l['id'].'" ';
			    	if($l['id']==$yiji){
			    		$html.='selected';
			    	}		    	
			    	$html.='>'.$l['ming'].'</option>';
			    }
		    }
	    }elseif($i==1){
	    	if($lie){    	
		    	foreach($lie as $l){
		    		if($l['id']==$yiji){
		    			foreach($l['haizi'] as $ll){
		    				$html.='<option value="'.$ll['id'].'" ';
					    	if($ll['id']==$erji){
					    		$html.='selected';
					    	}		    	
					    	$html.='>'.$ll['ming'].'</option>';
		    			}
				    	
			    	}
			    }
		    }
	    }
	    $html.='</select>';
	    $html.='</div>';
	}	
	return $html;
}
