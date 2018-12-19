<?php	
$mokuaiming='商城商城';
$caidan=array();
//商品管理
$caidan['shangpin']=array('ming'=>'商品管理','url'=>USK('shangpin'));
$caidan['shangpin']['erji'][]=array('ming'=>'商品管理','url'=>USK('shangpin'));
$caidan['shangpin']['erji'][]=array('ming'=>'商品分类','url'=>USK('shangpin/fenlei'));
$caidan['shangpin']['erji'][]=array('ming'=>'快递模板','url'=>USK('shangpin/kuaidi'));


//会员管理
$caidan['huiyuan']=array('ming'=>'会员管理','url'=>USK('huiyuan'));
$caidan['huiyuan']['erji'][]=array('ming'=>'会员管理','url'=>USK('huiyuan'));
$caidan['huiyuan']['erji'][]=array('ming'=>'会员角色','url'=>USK('huiyuan',array('c'=>'dengji')));
//$caidan['huiyuan'][]=array('ming'=>'会员分组','url'=>'#');
//订单管理
$caidan['dingdan']=array('ming'=>'订单管理','url'=>USK('dingdan'));
$caidan['dingdan']['erji'][]=array('ming'=>'全部订单','url'=>USK('dingdan'));
$caidan['dingdan']['erji'][]=array('ming'=>'待付款','url'=>USK('dingdan',array('zhuangtai'=>'daifu')));
$caidan['dingdan']['erji'][]=array('ming'=>'待发货','url'=>USK('dingdan',array('zhuangtai'=>'daifa')));
$caidan['dingdan']['erji'][]=array('ming'=>'待收货','url'=>USK('dingdan',array('zhuangtai'=>'daishou')));
$caidan['dingdan']['erji'][]=array('ming'=>'已完成','url'=>USK('dingdan',array('zhuangtai'=>'wancheng')));
$caidan['dingdan']['erji'][]=array('ming'=>'已关闭','url'=>USK('dingdan',array('zhuangtai'=>'quxiao')));
$caidan['dingdan']['erji'][]=array('ming'=>'退款中','url'=>USK('dingdan',array('zhuangtai'=>'tuikuan')));
$caidan['dingdan']['erji'][]=array('ming'=>'已退款','url'=>USK('dingdan',array('zhuangtai'=>'yituikuan')));
//财务管理
//$caidan['caiwu']=array('ming'=>'财务管理','url'=>USK('caiwu'));
//$caidan['caiwu']['erji'][]=array('ming'=>'充值记录','url'=>USK('caiwu'));
//$caidan['caiwu']['erji'][]=array('ming'=>'余额提现','url'=>USK('caiwu',array('c'=>'tixian')));
//$caidan['caiwu']['erji'][]=array('ming'=>'下载对账单','url'=>USK('caiwu',array('c'=>'xiazai')));

//统计中心
$caidan['tongji']=array('ming'=>'统计中心','url'=>USK('tongji'));
$caidan['tongji']['erji'][]=array('ming'=>'全部订单','url'=>USK('tongji'));


//插件中心
//
//$caidan['fenxiao']=array('ming'=>'创客中心','url'=>USK('fenxiao'));
//$caidan['fenxiao']['erji'][]=array('ming'=>'创客商管理','url'=>USK('fenxiao'));
//$caidan['fenxiao']['erji'][]=array('ming'=>'余额提现','url'=>USK('fenxiao',array('c'=>'tixian')));
//$caidan['fenxiao']['erji'][]=array('ming'=>'入口设置','url'=>USK('fenxiao',array('c'=>'rukou')));
//$caidan['fenxiao']['erji'][]=array('ming'=>'创客角色','url'=>USK('fenxiao',array('c'=>'dengji')));
//$caidan['fenxiao']['erji'][]=array('ming'=>'基础设置','url'=>USK('fenxiao',array('c'=>'jichu')));

//营销插件
//$caidan['yingxiao']=array('ming'=>'营销插件','url'=>USK('quan'));
//$caidan['yingxiao']['erji'][]=array('ming'=>'优惠券','url'=>USK('quan'));
//$caidan['yingxiao']['erji'][]=array('ming'=>'超级海报','url'=>USK('fenxiao/haibao'));
//$caidan['yingxiao']['erji'][]=array('ming'=>'签到','url'=>USK('qiandao'));
//$caidan['yingxiao']['erji'][]=array('ming'=>'淘宝导入','url'=>USK('taobao'));
//$caidan['yingxiao']['erji'][]=array('ming'=>'当面付','url'=>USK('dangmianfu'));

//系统管理
//$caidan['xitong']=array('ming'=>'系统管理','url'=>USK('xitong'));
//$caidan['xitong']['erji'][]=array('ming'=>'商城设置','url'=>USK('xitong'));
//$caidan['xitong']['erji'][]=array('ming'=>'引导及分享设置','url'=>USK('xitong',array('c'=>'fenxiang')));
//$caidan['xitong']['erji'][]=array('ming'=>'通知消息','url'=>USK('xitong',array('c'=>'tongzhi')));
//$caidan['xitong']['erji'][]=array('ming'=>'交易设置','url'=>USK('xitong',array('c'=>'jiaoyi')));
//$caidan['xitong']['erji'][]=array('ming'=>'入口/模板','url'=>USK('xitong',array('c'=>'muban')));
//$caidan['xitong']['erji'][]=array('ming'=>'首页分类','url'=>USK('xitong',array('c'=>'fenlei')));
?>