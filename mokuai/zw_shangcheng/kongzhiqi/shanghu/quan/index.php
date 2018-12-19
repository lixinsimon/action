<?php 
$cao = empty($_J['c']) ? 'moren' : $_J['c'];
if ($cao == 'moren') {
	$DangQianYe = max(1, $_J['page']);
    $quTiaoShu = 10;
    $tj='danyuan='.$_W['danyuan'];   
    $juan=MX()->QuanLie($DangQianYe,$quTiaoShu);
    $zongshu=ChaZongShu("select count(*) from ".BM('zw_shangcheng_quan')." where {$tj} ");
    $fenye = FenYe($zongshu, $DangQianYe, $quTiaoShu);
}elseif($cao=='bianji'){
	$juan=Qu('zw_shangcheng_quan',array('id'=>$_J['id'],'danyuan'=>$_W['danyuan']));
}elseif($cao=='post' && $_W['ispost']){
     $shu=array();
   
     $shu['biaoti']=trim($_J['biaoti']);
     $shu['tu']=$_J['tu'];
    
     $shu['kaishi']=strtotime($_J['kaishi']);
     $shu['jieshu']=strtotime($_J['jieshu']);
     $shu['e']=round($_J['e'],2);
     $shu['zongshu']=intval($_J['zongshu']);
     $shu['xianling']=intval($_J['xianling']);
     $tishi=array();
     $tishi['biaoti']='标题不能为空';
     $tishi['tu']='推送图片不能空';    
     $tishi['kaishi']='使用开始时间不能空';
     $tishi['jieshu']='使用结束时间不能空';
     $tishi['e']='优惠额度错误，必须是大于0';
     $tishi['zongshu']='发放总数';
     foreach ($shu as $k=>$v) {
     	if(empty($v)){
             XiaoXi($tishi[$k]);eixt;
     	}
     }  
     $shu['tiaojian']=intval($_J['tiaojian']);
     if(intval($_J['id'])){
        Gai('zw_shangcheng_quan',$shu,array('id'=>$_J['id'],'danyuan'=>$_W['danyuan']));
        XiaoXi('修改成功',USK('quan'));eixt;	
     }else{
     	$shu['danyuan']=$_W['danyuan'];
        $shu['shijian']=time();
        ChaRu('zw_shangcheng_quan',$shu);	
        XiaoXi('添加成功',USK('quan'));eixt;
     }   
}elseif ($cao=='shanchu') {
	 ShanChu('zw_shangcheng_quan',array('id'=>$_J['id'],'danyuan'=>$_W['danyuan']));
	  XiaoXi('删除成功',USK('quan'));eixt;
}
mb('index');
?>