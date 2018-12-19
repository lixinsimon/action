<?php
$daohang=array(
    'jichu'=>array(
            'ming'=>'基本功能',
            'tubiao'=>' fa-gift text-primary',
            'url'=>'',
            'erji'=>array(
                    'shanghu'=>array('ming'=>'商户资料','url'=>US('jichu/shanghu')), 
                    'huiyuan'=>array('ming'=>'会员中心','url'=>US('fensi/huiyuan')),                    
                    'hexiao'=>array('ming'=>'O2O核销','url'=>US('hexiao/index')), 
                    'tixian'=>array('ming'=>'提现管理','url'=>US('tixian/index')),   
                                   
                    ),
            ),
    'weixin'=>array(
            'ming'=>'微信设置',
            'tubiao'=>' fa-cog text-success',
            'url'=>'',
            'erji'=>array(
                    'weixin'=>array('ming'=>'微信菜单','url'=>US('jichu/zidingyi')),
                    'wenzi'=>array('ming'=>'文字回复','url'=>US('jichu')),
                    'tuwen'=>array('ming'=>'图文回复','url'=>US('jichu/tuwen')),
                    'xitonghuifu'=>array('ming'=>'系统回复','url'=>US('jichu/huifu'))                 
                    ),              
            ),
    'weizan'=>array(
            'ming'=>'文章管理',
            'tubiao'=>' fa-chain text-info',
            'url'=>'',
            'erji'=>array(
                    'wenzhang'=>array('ming'=>'文章列表','url'=>US('weizhan')),
//                  'fenlei'=>array('ming'=>'分类设置','url'=>US('weizhan/fenlei')),
                    ),
            ),



    'zw_shangcheng'=>array(
            'ming'=>'知微商城',
            'tubiao'=>' icon-home text-success',
            'url'=>US('shangpin/index/zw_shengxian')
            ),
//  'zw_duobao'=>array(
//          'ming'=>'知微夺宝',
//          'tubiao'=>' icon-home text-success',
//          'url'=>US('shangpin/index/zw_duobao')
//  ),

//   'zw_riji'=>array(
//          'ming'=>'装修',
//          'tubiao'=>' icon-home text-success',
//          'url'=>'',
//          'erji'=>array(
//                  'weixin'=>array('ming'=>'装修管理','url'=>US('zhuangxiu/index/zw_zhuangxiu')),
//                  'duanxin'=>array('ming'=>'设计师管理','url'=>US('zhuangxiu/shejishi/zw_zhuangxiu')),
//                  ),
//          ),

//
//  'pintuan'=>array(
//          'ming'=>'拼团商城',
//          'tubiao'=>' icon-home text-success',
//          'url'=>US('shangpin/index/zw_pintuan')
//          ),    
// 
//  'jifen'=>array(
//          'ming'=>'积分商城',
//          'tubiao'=>' icon-home text-success',
//          'url'=>US('shangpin/index/zw_jifen')
//          ),
// 	'zhuangxiu'=>array(
//          'ming'=>'装修设计',
//          'tubiao'=>' icon-home text-success',
//          'url'=>US('zhuangxiu/index/zw_zhuangxiu')
//          ),  
);
?>