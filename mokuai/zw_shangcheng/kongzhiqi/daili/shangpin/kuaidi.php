<?php
$cao=empty($_J['c'])?'moren':$_J['c'];
if($cao=='moren'){
	 $kuaidi=MX()->KuaiDiLei();

}elseif ($cao=="bianji") {
  $kd=Cha('select * from '.BM('zw_shangcheng_kuaidi').' where danyuan='.$_W['danyuan'].'  and id='.$_J['id']);		
}elseif ($cao=="post" && $_W['ispost']) {
    $shu=array();
    $shu['ming']=trim($_J['ming']);
    if(empty($shu['ming'])){
    	XiaoXi('名称不能为空');exit;
    }
    $shu['leixing']=intval($_J['leixing']);	
    $shu['shouzhong']=intval($_J["shouzhong"]);	
    if(empty($shu['shouzhong'])){
    	XiaoXi('首重不能为空');exit;
    }
    $shu['xuzhong']=intval($_J['xuzhong']);
    if(empty($shu['xuzhong'])){
    	XiaoXi('续重不能为空');exit;
    }	
    $shu['shoujia']=round($_J['shoujia'],2);
    if(empty($shu['shoujia'])){
    	XiaoXi('首重价格不能为空');exit;
    }

    $shu['xujia']=round($_J['xujia'],2);
    if(empty($shu['xujia'])){
    	XiaoXi('续重价格不能为空');exit;
    }	
    $shu['zhuangtai']=$_J['zhuangtai'];
    if(intval($_J['id'])){
         Gai('zw_shangcheng_kuaidi',$shu,array('id'=>$_J['id'],'danyuan'=>$_W['danyuan']));
          XiaoXi('更新成功',USK('shangpin/kuaidi'));
    }else{
    	$shu['danyuan']=$_W['danyuan'];    	
    	ChaRu('zw_shangcheng_kuaidi',$shu);
        XiaoXi('添加成功',USK('shangpin/kuaidi'));
    }	
}elseif($cao=='shanchu'){
	ShanChu('zw_shangcheng_kuaidi',array('id'=>$_J['id'],'danyuan'=>$_W['danyuan']));
	XiaoXi('删除成功',USK('shangpin/kuaidi'));
}
mb("kuaidi");
?>