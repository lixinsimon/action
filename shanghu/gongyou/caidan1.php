<?php	
$caidan1=array();
//入口
//$caidan['rukou']=array('ming'=>'商城入口','url'=>'#');
//$caidan['rukou']['erji'][]=array('ming'=>'商城入口','url'=>'#');
//$caidan['rukou']['erji'][]=array('ming'=>'订单入口','url'=>'#');
//$caidan['rukou']['erji'][]=array('ming'=>'会员入口','url'=>'#');
//商品管理
$caidan['shangpin']=array('ming'=>'商品管理','url'=>US('shangpin'));
$caidan['shangpin']['erji'][]=array('ming'=>'商品管理','url'=>US('shangpin/index/zw_shangcheng'));
$caidan['shangpin']['erji'][]=array('ming'=>'分类管理','url'=>US('shangpin/fenlei/zw_shangcheng'));
$caidan['shangpin']['erji'][]=array('ming'=>'快递模板','url'=>US('shangpin/kuaidi/zw_shangcheng'));
//$caidan['shangpin']['erji'][]=array('ming'=>'评价管理','url'=>US('shangpin/pingjia'));

//会员管理
//$caidan['huiyuan']=array('ming'=>'会员管理','url'=>US('huiyuan'));
//$caidan['huiyuan']['erji'][]=array('ming'=>'会员管理','url'=>US('huiyuan'));
//$caidan['huiyuan']['erji'][]=array('ming'=>'会员等级','url'=>US('huiyuan',array('c'=>'dengji')));
//$caidan['huiyuan'][]=array('ming'=>'会员分组','url'=>'#');
//订单管理
$caidan['dingdan']=array('ming'=>'订单管理','url'=>US('dingdan/index/zw_shangcheng'));
$caidan['dingdan']['erji'][]=array('ming'=>'全部订单','url'=>US('dingdan/index/zw_shangcheng'));
$caidan['dingdan']['erji'][]=array('ming'=>'待付款','url'=>US('dingdan/index/zw_shangcheng',array('zhuangtai'=>'daifu')));
$caidan['dingdan']['erji'][]=array('ming'=>'待发货','url'=>US('dingdan/index/zw_shangcheng',array('zhuangtai'=>'daifa')));
$caidan['dingdan']['erji'][]=array('ming'=>'待收货','url'=>US('dingdan/index/zw_shangcheng',array('zhuangtai'=>'daishou')));
$caidan['dingdan']['erji'][]=array('ming'=>'已完成','url'=>US('dingdan/index/zw_shangcheng',array('zhuangtai'=>'wancheng')));
$caidan['dingdan']['erji'][]=array('ming'=>'已关闭','url'=>US('dingdan/index/zw_shangcheng',array('zhuangtai'=>'quxiao')));
$caidan['dingdan']['erji'][]=array('ming'=>'退款中','url'=>US('dingdan/index/zw_shangcheng',array('zhuangtai'=>'tuikuan')));
$caidan['dingdan']['erji'][]=array('ming'=>'已退款','url'=>US('dingdan/index/zw_shangcheng',array('zhuangtai'=>'yituikuan')));
//财务管理
$caidan['caiwu']=array('ming'=>'财务统计','url'=>US('caiwu'));
$caidan['caiwu']['erji'][]=array('ming'=>'充值记录','url'=>US('caiwu/index/zw_shangcheng'));
$caidan['caiwu']['erji'][]=array('ming'=>'余额提现','url'=>US('caiwu/index/zw_shangcheng',array('c'=>'tixian')));
$caidan['caiwu']['erji'][]=array('ming'=>'下载对账单','url'=>US('caiwu/index/zw_shangcheng',array('c'=>'xiazai')));



//插件中心

$caidan['fenxiao']=array('ming'=>'优惠券','url'=>US('quan'));
?>