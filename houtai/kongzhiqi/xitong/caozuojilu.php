<?php
if($cao=='moren'){
   $DangQianYe = max(1, intval($_J['page']));
   $XianJiLu = 20;
 
  
   $sql='select * from '.BM('he_caozuojilu').' where danyuan='.$_W['danyuan'].' order by shijian DESC '; 
   $sql .= "LIMIT " . ($DangQianYe - 1) * $XianJiLu . ',' . $XianJiLu;  
   $jilu=ChaQuan($sql,$cen);      
   $shu=ChaZongShu('select count(*) from '.BM('he_caozuojilu').' where  danyuan='.$_W['danyuan']); 
   $fenye=FenYe($shu,$DangQianYe,$XianJiLu); 
}	
	
mb('caozuojilu');
?>