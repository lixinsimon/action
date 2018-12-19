<?php
DengLu();
$s = time();
	if($cao=='moren' && $_W['ispost']){
		$y=date('Y-m-01 H:h:s',$s);
//		dump($y);die;
//		$yiqianlie=ChaQuan('select shijian  from '.BM('zw_shangcheng_qiandao').'where hyid = '.$id.' and danyuan='.$_W['danyuan'].' and shijian>='.$y);
	}elseif($cao=='cha'  && $_W['ispost']){
		$shijian = $_J['shijian'];   	
		$id=$_W['huiyuan']['id'];
		$yiqianlie=ChaQuan('select * from '.BM('zw_shangcheng_qiandao').'where hyid = '.$id.' and danyuan='.$_W['danyuan']);
		$zongjifen = 0;
		$shu="";
		$a=0;
		$shu['leiqian'] = sizeof($yiqianlie);
		$jilu = Qu('zw_shangcheng_qiandao','danyuan='.$_W['danyuan'].' and hyid='.$_W['huiyuan']['id'].' order by shijian DESC');
		$shu['lianqian'] = $jilu['lianqian'];
		$jintianshijan=time();
	    foreach($yiqianlie as $k=>$y){    	
	    	if(date('Y-m-d',$y['shijian'])== date('Y-m-d',$s)){
	    		$shu['pan']=true;
				$shu['jifen'] = $y['jifen'];
				$shu['lianqian'] = $y['lianqian'];
	    	};
			$zongjifen +=$yiqianlie[$k]['jifen'];
	    	if(date('Y-m',$y['shijian']) == $shijian ){
	    		$shu['qiandao'][$a++]=date('Y-m-d',$y['shijian']);
	    	};
	    }
		$shu['louqian'] = intval(date('d',$jintianshijan))-sizeof($shu['qiandao']);
		$shu['zongjifen'] = $zongjifen;
		$pz=Cha('select * from' .BM('zw_shangcheng_qiandao_peizhi').' where danyuan='.$_W['danyuan']);
		$shu['guizhe']= htmlspecialchars_decode($pz['guizhe']);
		
		if($shu){
	       json($shu);
	    }else{
	    	json('今日未签到',0);
	    }    	
	}elseif($cao=='qiandao'  && $_W['ispost']){		
		$jilu = Qu('zw_shangcheng_qiandao','danyuan='.$_W['danyuan'].' and hyid='.$_W['huiyuan']['id'].' order by shijian DESC');
		$zuixinshijian = date('Ymd',$jilu['shijian']);
		$dangqianshijian = date('Ymd',$s);
		if($zuixinshijian == $dangqianshijian){
			json('已签到',0);			
		}

		$lianqian=$jilu['lianqian']; 
		if($jilu['lianqian'] == 7 || empty($jilu['lianqian'])){
			$lianqian = 0;
		}
		
		$pz=Cha('select * from' .BM('zw_shangcheng_qiandao_peizhi').' where danyuan='.$_W['danyuan']);
		$zhengsongjifen=ZiFuChuan_Zhuan_ShuZu($pz['peizhi']);	
		
		$qiandao_jilu = array();
		$qiandao_jilu['jifen'] = $zhengsongjifen[$lianqian];
        $qiandao_jilu['danyuan'] = $_W['danyuan'];
        $qiandao_jilu['hyid'] = $_W['huiyuan']['id'];
		$qiandao_jilu['lianqian'] = $lianqian + 1;
        $qiandao_jilu['shijian'] = $s;
        $qiandao_jilu['leixing'] = $_J['leixing'];
        $qiandao_jilu['url'] = $_J['url'];
		ChaRu('zw_shangcheng_qiandao', $qiandao_jilu);
		MX('huiyuan','he')->gai_jifen( $qiandao_jilu['hyid'],$qiandao_jilu['jifen'],"签到赠送积分");
	 	json('成功');
	}
mb('index');
?>