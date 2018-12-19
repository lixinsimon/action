<?php
DengLu();
$cao=empty($_J['c'])?'moren':$_J['c'];

if($cao=='moren'){
	$tj='where danyuan ='.$_W['danyuan'];
	if($_J['nicheng']){
		$tj.=' and nicheng='.$_J['nicheng'].' and ';
	}
	$hexiaolie=ChaQuan('select * from '.BM('he_hexiao') .$tj);
}elseif($cao=='xiugai' && $_W['ispost']){	
	if(empty($_J['nicheng'])){		
		XiaoXi('店铺名称不能空');
	}

	$l = array(
	    'danyuan'=>$_W['danyuan'],
		'logo'=>$_J['logo'],		
		'nicheng'=>$_J['nicheng'],
		'dianhua'=>$_J['dianhua'],
		'shanghu'=>$_J['shanghu'],		
		'nicheng'=>trim($_J['nicheng']),
		'xiangxidizhi'=>$_J['xiangxidizhi'],
		'sheng'=>$_J['sheng'],
		'shi'=>$_J['shi'],
		'xian'=>$_J['xian'],	
	);
	if($_J['id']>0){		
		Gai('he_hexiao',$l,array("danyuan" => $_W['danyuan'],'id'=>$_J['id']));
	    XiaoXi('修改成功',USK('hexiao/index'));exit;
	}
	$l['ming']=trim($_J['nicheng']);
	$l['shijian']=SHIJIAN;					
	ChaRu('he_hexiao',$l);		
	XiaoXi('添加成功',USK('hexiao/index'));
}elseif($cao=='shanchu'){
	if(empty($_J['hexiao_id'])){
		XiaoXi('删除失败');
	}
	ShanChu('he_hexiao',array('id'=>$_J['hexiao_id']));
	XiaoXi('删除成功');
	
}elseif($cao=='bianji_' || $cao=='tianjia'){
	if($_J['hexiao_id']){
		 $hexiao = Cha('select hx.*,sh.nicheng as shanghuming from '.BM('he_hexiao').' hx left join '.BM('he_shanghu').' sh on hx.shanghu=sh.id where hx.id='.$_J['hexiao_id'].' and hx.danyuan = '.$_W['danyuan']);	 
	
	}	
   
}elseif($cao=='kefu'){	
	 $tj="hx.danyuan=".$_W['danyuan'].' and hx.hexiao='.$_J['hexiao_id'];	
	 $huiyuan=ChaQuan('select * from '.BM('he_huiyuan').' h left join '.BM('he_hexiaoyuan').' hx on h.id=hx.hyid where '.$tj);

}elseif($cao=='so_shanghu'){
	$g=trim($_J['guanjianci']);
	$tj='danyuan='.$_W['danyuan'];
	if($g){
		$tj.=' and nicheng like "%'.$g.'%"';
	}	
	$huiyuan=ChaQuan('select * from '.BM('he_shanghu').' where '.$tj.' order by zhuceshijian DESC limit 10');
	json($huiyuan);
}elseif($cao=='so_kefu'){
	$tiaojian="danyuan=".$_W['danyuan'];
	if($_J['guanjianci']){
		$yonghu=trim($_J['guanjianci']);
		$tiaojian.=' and (nicheng like "%'.$yonghu.'%" or xingming like "%'.$yonghu.'%" or shouji like "%'.$yonghu.'%")';
	}
	$huiyuan=ChaQuan('select * from '.BM('he_huiyuan').'where '.$tiaojian.' order by shijian DESC limit 10');
	json($huiyuan);

}elseif($cao=='tianjiankefu'){
	if(empty($_J['id'])|| empty($_J['hyid'])){
		XiaoXi('添加失败');
	}
	$if=Qu('he_hexiaoyuan',array('hyid'=>$_J['hyid'],'danyuan'=>$_W['danyuan']));
	if($if){
		XiaoXi('已存在此店铺或其他店铺了');
	}
	
	$shu['hyid']=$_J['hyid'];
	$shu['danyuan']=$_W['danyuan'];
	$shu['hexiao']=$_J['id'];
	$shu['shijian']=SHIJIAN;
	ChaRu('he_hexiaoyuan',$shu);	
    XiaoXi('添加成功',US('hexiao',array('c'=>'kefu','hexiao_id'=>$_J['id'])));exit;	
}elseif($cao=='shanchu_kefu'){
	if(empty($_J['hexiao_id'])|| empty($_J['hyid'])){
		XiaoXi('添加失败');
	}
	
	ShanChu('he_hexiaoyuan',array('hyid'=>$_J['hyid'],'danyuan'=>$_W['danyuan']));
    XiaoXi('删除成功',US('hexiao',array('c'=>'kefu','hexiao_id'=>$_J['hexiao_id'])));exit;
}

mb('index')
?>