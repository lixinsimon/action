<?php
	if($cao=='moren' && $_W['ispost']){
		if( empty($_J["minid"]) || empty($_J["maxid"])){
			json("没传ID",0);
		}
		$shangping =ChaQuan("select * from ".BM("zw_shangcheng_shangpin")." where id>".$_J["minid"]." and id<".$_J["maxid"]." and danyuan=".$_W["danyuan"]);
		if(empty($shangping)){
			json("没有数据",0);
		}
		foreach($shangping as $k=>$leis){
			$shangping[$k]["tu"]=JueDuiUrl($leis["tu"]);
		}
		json($shangping);
	}
	mb("index2");
?>
