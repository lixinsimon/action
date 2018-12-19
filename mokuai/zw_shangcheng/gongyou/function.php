<?php
function FenLeiXiaLaLieBiao($lie=array(),$yiji=0,$erji=0,$ji=2){	
	$d=array();
	if($lie){
	foreach($lie as $z){
		foreach($z['haizi'] as $zz){
			$h=$zz;
			unset($h['haizi']);
			$d['p_'.$z['id']][]=$h;			
			foreach($zz['haizi'] as $zzz){
				unset($zzz['haizi']);
				$d['p_'.$zz['id']][]=$zzz;
				
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
	    $html.='<select id="'.$random.$i.'" name="fenlei['.$i.']" class="form-control" onchange="fenleinext_'.$random.'('.($i+1).',this)">';
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

function shiFenXiaoShang(){
	global $_W;		
	$huiyuan=Qu('zw_shangcheng_huiyuan',array('hyid'=>$_W['huiyuan']['id'],'danyuan'=>$_W['danyuan']),'fenxiaozhuangtai');	
	if(empty($huiyuan['fenxiaozhuangtai']) || $huiyuan['fenxiaozhuangtai']<1){
		if($_W['ispost']){
		  json(array('feiFenXiaoShang'=>1),0);	
		}else{			
		   TiaoZhuan(UAK('fenxiao/yindaogoumai'));
		}
		
	}
	return $huiyuan;
	
}


?>