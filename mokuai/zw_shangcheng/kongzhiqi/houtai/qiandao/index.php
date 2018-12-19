<?php
DengLu();
if($cao=='moren'){	
	$DangQianYe=max(1,$_J['page']);
	$quTiaoShu=10;	
	
	$leixing=array('1'=>'图片','2'=>"视频");
	
	$tiaojian='q.danyuan='.$_W['danyuan'];	
	if($_J['id']>0){
		$tiaojian.=' and q.id='.$_J['id'];
	}
	if($_J['kaishi'] && $_J['jieshu'] && !empty($_J['shijian'])){
		$tiaojian.=' and q.shijian>='.strtotime($_J['kaishi']);
		$tiaojian.=' and q.shijian<='.strtotime($_J['jieshu']);
	}
	if($_J['yonghu']){
		$yonghu=trim($_J['yonghu']);
		$tiaojian.=' and (h.nicheng like "%'.$yonghu.'%" )';
	}
			
	$jilu=ChaQuan('select q.*,h.nicheng,h.touxiang from '.BM('zw_shangcheng_qiandao').' q left join '.BM('he_huiyuan').' h on q.hyid=h.id where '.$tiaojian.' order by shijian DESC  Limit '. ($DangQianYe - 1) * $quTiaoShu . ',' . $quTiaoShu	);
	
	$shu=ChaZongShu('select count(*) from '.BM('zw_shangcheng_qiandao').' where danyuan='.$_W['danyuan']);
	$fenye=FenYe($shu,$DangQianYe,$quTiaoShu);	
}elseif($cao=="shanchu"){	
	QuanXian('shanchu');
	ShanChu('zw_shangcheng_qiandao',array('id'=>intval($_J['id']),'danyuan'=>$_W['danyuan']));	
	CaoZuoJiLu('删除签到');
	XiaoXi('删除成功',UHK('qiandao'));	
}elseif($cao=='peizhi'){	
	$danyuan=array('danyuan'=>$_W['danyuan']);	
	$pz=Cha('select * from' .BM('zw_shangcheng_qiandao_peizhi').' where danyuan='.$_W['danyuan']);	
	if(empty($pz)){	
		ChaRu('zw_shangcheng_qiandao_peizhi',$danyuan);	
	}else{
		$lianqian=ZiFuChuan_Zhuan_ShuZu($pz['peizhi']);
	}
	
}elseif($cao=='peizhixiugai'){
	$danyuan=array('danyuan'=>$_W['danyuan']);
	$gai_shuju=array('peizhi'=>ShuZu_Zhuan_ZiFuChuan($_J['lian']),"guizhe"=>$_J['guizhe'],'kaiguan'=>$_J['shezhi']);	
	Gai('zw_shangcheng_qiandao_peizhi',$gai_shuju,$danyuan);
	CaoZuoJiLu('更新签到配置');
	XiaoXi('更新成功',UHK('qiandao',array('c'=>'peizhi')));	
	
}


mb('index');
?>