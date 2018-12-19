<?php	
$caidandaohang=array();
//入口
//商品管理
$caidandaohang['shangpin']=array('ming'=>'商品管理','url'=>US('shangpin'));
$caidandaohang['shangpin']['erji'][]=array('ming'=>'商品管理','url'=>US('shangpin/index/zw_jifen'));
$caidandaohang['shangpin']['erji'][]=array('ming'=>'分类管理','url'=>US('shangpin/fenlei/zw_jifen'));
$caidandaohang['shangpin']['erji'][]=array('ming'=>'快递模板','url'=>US('shangpin/kuaidi/zw_jifen'));

//订单管理
$caidandaohang['dingdan']=array('ming'=>'订单管理','url'=>US('dingdan/index/zw_jifen'));
$caidandaohang['dingdan']['erji'][]=array('ming'=>'全部订单','url'=>US('dingdan/index/zw_jifen'));
$caidandaohang['dingdan']['erji'][]=array('ming'=>'待付款','url'=>US('dingdan/index/zw_jifen',array('zhuangtai'=>'daifu')));
$caidandaohang['dingdan']['erji'][]=array('ming'=>'待发货','url'=>US('dingdan/index/zw_jifen',array('zhuangtai'=>'daifa')));
$caidandaohang['dingdan']['erji'][]=array('ming'=>'待收货','url'=>US('dingdan/index/zw_jifen',array('zhuangtai'=>'daishou')));
$caidandaohang['dingdan']['erji'][]=array('ming'=>'已完成','url'=>US('dingdan/index/zw_jifen',array('zhuangtai'=>'wancheng')));
$caidandaohang['dingdan']['erji'][]=array('ming'=>'已关闭','url'=>US('dingdan/index/zw_jifen',array('zhuangtai'=>'quxiao')));
$caidandaohang['dingdan']['erji'][]=array('ming'=>'退款中','url'=>US('dingdan/index/zw_jifen',array('zhuangtai'=>'tuikuan')));
$caidandaohang['dingdan']['erji'][]=array('ming'=>'已退款','url'=>US('dingdan/index/zw_jifen',array('zhuangtai'=>'yituikuan')));

//财务管理
$caidandaohang['caiwu']=array('ming'=>'财务统计','url'=>US('caiwu'));
$caidandaohang['caiwu']['erji'][]=array('ming'=>'充值记录','url'=>US('caiwu/index/zw_jifen'));
$caidandaohang['caiwu']['erji'][]=array('ming'=>'余额提现','url'=>US('caiwu/index/zw_jifen',array('c'=>'tixian')));
$caidandaohang['caiwu']['erji'][]=array('ming'=>'下载对账单','url'=>US('caiwu/index/zw_jifen',array('c'=>'xiazai')));

?>