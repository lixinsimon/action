<?php
DengLu();
$cao = empty($_J['c']) ? 'moren' : $_J['c'];
if ($cao == 'moren' && $_W['ispost']) {
    $tiaojian = array(':danyuan' => $_W['danyuan'], ':huiyuan' => $_W['huiyuan']['id']);
    $shoucanglie = ChaQuan('select sc.id as scid,sp.* from ims_zw_shangcheng_shoucang as sc left join ims_zw_shangcheng_shangpin as sp on sc.shangpin=sp.id where sc.danyuan=:danyuan and sc.huiyuan=:huiyuan', $tiaojian);
    if($shoucanglie){
    	foreach($shoucanglie as $k=>$lie ){
    		$shoucanglie[$k]['href']=UAK("xiangqing",array("id"=>$lie["id"]));
    		$shoucanglie[$k]['tu']=JueDuiUrl($lie['tu']);
    	};
    	
    	json($shoucanglie);
    }
    json('没有了',0);
} else if ($cao == 'shoucang') {  
    $shoucang = Cha('select * from ' . BM('zw_shangcheng_shoucang') . ' where danyuan=' . $_W['danyuan'] . ' and huiyuan=' . $_W['huiyuan']['id'] . ' and shangpin=' . $_J['shangpin']);   
    if ($shoucang) {
        ShanChu('zw_shangcheng_shoucang', array('shangpin' => $_J['shangpin'], 'huiyuan' => $_W['huiyuan']['id'], 'danyuan' => $_W['danyuan']));
        json('取消收藏成功',2);        
    } 
    $shoucangshuju = array(
        'danyuan' => $_W['danyuan'],
        'huiyuan' => $_W['huiyuan']['id'],
        'shangpin' => $_J['shangpin'],
        'shijian' => time(),
    );
    ChaRu('zw_shangcheng_shoucang', $shoucangshuju);
    json('收藏成功');  

} elseif ($cao == 'shanchu') {
    $ids = rtrim($_J['ids'], '_');
    $ids = explode('_', $ids);
   
    if ($ids) {
    	foreach($ids as $id){
    		ShanChu('zw_shangcheng_shoucang', array('danyuan' => $_W['danyuan'], 'huiyuan' => $_W['huiyuan']['id'], 'shangpin' => $id));
    	}
        
        json('删除成功');
    }
    json('删除失败', 0);
}
mb('shoucang');
