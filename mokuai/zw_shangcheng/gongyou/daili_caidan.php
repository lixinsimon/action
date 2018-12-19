<?php	
$mokuaiming='商城商城';
$caidan=array();
//入口
//$caidan['rukou']=array('ming'=>'商城入口','url'=>'#');
//$caidan['rukou']['erji'][]=array('ming'=>'商城入口','url'=>'#');
//$caidan['rukou']['erji'][]=array('ming'=>'订单入口','url'=>'#');
//$caidan['rukou']['erji'][]=array('ming'=>'会员入口','url'=>'#');
//商品管理
$caidan['shangpin']=array('ming'=>'商品管理','url'=>UHK('shangpin'));
$caidan['shangpin']['erji'][]=array('ming'=>'商品管理','url'=>UHK('shangpin'));
$caidan['shangpin']['erji'][]=array('ming'=>'分类管理','url'=>UHK('shangpin/fenlei'));
$caidan['shangpin']['erji'][]=array('ming'=>'快递模板','url'=>UHK('shangpin/kuaidi'));
//$caidan['shangpin']['erji'][]=array('ming'=>'评价管理','url'=>UHK('shangpin/pingjia'));

//会员管理
$caidan['huiyuan']=array('ming'=>'会员管理','url'=>UHK('huiyuan'));
$caidan['huiyuan']['erji'][]=array('ming'=>'会员管理','url'=>UHK('huiyuan'));
$caidan['huiyuan']['erji'][]=array('ming'=>'会员角色','url'=>UHK('huiyuan',array('c'=>'dengji')));
$caidan['huiyuan'][]=array('ming'=>'会员分组','url'=>'#');
//订单管理
$caidan['dingdan']=array('ming'=>'订单管理','url'=>UHK('dingdan'));
$caidan['dingdan']['erji'][]=array('ming'=>'全部订单','url'=>UHK('dingdan'));
$caidan['dingdan']['erji'][]=array('ming'=>'待付款','url'=>UHK('dingdan',array('zhuangtai'=>'daifu')));
$caidan['dingdan']['erji'][]=array('ming'=>'待发货','url'=>UHK('dingdan',array('zhuangtai'=>'daifa')));
$caidan['dingdan']['erji'][]=array('ming'=>'待收货','url'=>UHK('dingdan',array('zhuangtai'=>'daishou')));
$caidan['dingdan']['erji'][]=array('ming'=>'已完成','url'=>UHK('dingdan',array('zhuangtai'=>'wancheng')));
$caidan['dingdan']['erji'][]=array('ming'=>'已关闭','url'=>UHK('dingdan',array('zhuangtai'=>'quxiao')));
$caidan['dingdan']['erji'][]=array('ming'=>'退款中','url'=>UHK('dingdan',array('zhuangtai'=>'tuikuan')));
$caidan['dingdan']['erji'][]=array('ming'=>'已退款','url'=>UHK('dingdan',array('zhuangtai'=>'yituikuan')));
//财务管理
//$caidan['caiwu']=array('ming'=>'财务管理','url'=>UHK('caiwu'));
//$caidan['caiwu']['erji'][]=array('ming'=>'充值记录','url'=>UHK('caiwu'));
//$caidan['caiwu']['erji'][]=array('ming'=>'余额提现','url'=>UHK('caiwu',array('c'=>'tixian')));
//$caidan['caiwu']['erji'][]=array('ming'=>'下载对账单','url'=>UHK('caiwu',array('c'=>'xiazai')));

//统计中心
$caidan['tongji']=array('ming'=>'统计中心','url'=>UHK('tongji'));
$caidan['tongji']['erji'][]=array('ming'=>'全部订单','url'=>UHK('tongji'));


//插件中心

$caidan['fenxiao']=array('ming'=>'创客中心','url'=>UHK('fenxiao'));
$caidan['fenxiao']['erji'][]=array('ming'=>'创客管理','url'=>UHK('fenxiao'));
$caidan['fenxiao']['erji'][]=array('ming'=>'余额提现','url'=>UHK('fenxiao',array('c'=>'tixian')));
$caidan['fenxiao']['erji'][]=array('ming'=>'入口设置','url'=>UHK('fenxiao',array('c'=>'rukou')));
$caidan['fenxiao']['erji'][]=array('ming'=>'创客角色','url'=>UHK('fenxiao',array('c'=>'dengji')));
$caidan['fenxiao']['erji'][]=array('ming'=>'基础设置','url'=>UHK('fenxiao',array('c'=>'jichu')));

//营销插件
$caidan['yingxiao']=array('ming'=>'营销插件','url'=>UHK('quan'));
$caidan['yingxiao']['erji'][]=array('ming'=>'优惠券','url'=>UHK('quan'));
$caidan['yingxiao']['erji'][]=array('ming'=>'超级海报','url'=>UHK('fenxiao/haibao'));
//$caidan['yingxiao']['erji'][]=array('ming'=>'签到','url'=>UHK('qiandao'));
//$caidan['yingxiao']['erji'][]=array('ming'=>'淘宝导入','url'=>UHK('taobao'));
//$caidan['yingxiao']['erji'][]=array('ming'=>'当面付','url'=>UHK('dangmianfu'));
//$caidan['yingxiao']['erji'][]=array('ming'=>'店铺装修','url'=>UHK('zidingyi'));

//系统管理
$caidan['xitong']=array('ming'=>'系统管理','url'=>UHK('xitong'));
$caidan['xitong']['erji'][]=array('ming'=>'商城设置','url'=>UHK('xitong'));
$caidan['xitong']['erji'][]=array('ming'=>'引导及分享设置','url'=>UHK('xitong',array('c'=>'fenxiang')));
$caidan['xitong']['erji'][]=array('ming'=>'通知消息','url'=>UHK('xitong',array('c'=>'tongzhi')));
$caidan['xitong']['erji'][]=array('ming'=>'交易设置','url'=>UHK('xitong',array('c'=>'jiaoyi')));
$caidan['xitong']['erji'][]=array('ming'=>'入口/模板','url'=>UHK('xitong',array('c'=>'muban')));
$caidan['xitong']['erji'][]=array('ming'=>'首页分类','url'=>UHK('xitong',array('c'=>'fenlei')));
?>