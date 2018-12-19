<?php
$daohang=array(
    'jichu'=>array(
            'ming'=>'基本功能',
            'tubiao'=>' fa-gift text-primary',
            'url'=>'',
            'erji'=>array(
//                  'fensi'=>array('ming'=>'粉丝管理','url'=>UH('fensi')),
//                  'huiyuan'=>array('ming'=>'会员中心','url'=>UH('fensi/huiyuan')),
                    'liuyan'=>array('ming'=>'会员留言','url'=>UH('fensi/liuyan')),
                 'shanghu'=>array('ming'=>'商户管理','url'=>UH('shanghu/index')), 
//                  'daili'=>array('ming'=>'市级代理管理','url'=>UH('daili/index')), 
//                  'hexiao'=>array('ming'=>'O2O核销','url'=>UH('hexiao/index')), 
               
//                  'tixian'=>array('ming'=>'提现管理','url'=>UH('tixian/index')),   
                  
//                  'yutixian'=>array('ming'=>'余额提现','url'=>UH('yutixian/index')), 
//                  'zhifu'=>array('ming'=>'支付记录','url'=>UH('jilu/index')),                
                    ),
            ),
    'weixin'=>array(
            'ming'=>'微信设置',
            'tubiao'=>' fa-cog text-success',
            'url'=>'',
            'erji'=>array(
                    'weixin'=>array('ming'=>'微信菜单','url'=>UH('jichu/zidingyi')),
                    'wenzi'=>array('ming'=>'文字回复','url'=>UH('jichu')),
                    'tuwen'=>array('ming'=>'图文回复','url'=>UH('jichu/tuwen')),
                    'xitonghuifu'=>array('ming'=>'系统回复','url'=>UH('jichu/huifu'))                 
                    ),              
            ),
    'weizan'=>array(
            'ming'=>'文章管理',
            'tubiao'=>' fa-chain text-info',
            'url'=>'',
            'erji'=>array(
                    'wenzhang'=>array('ming'=>'文章列表','url'=>UH('weizhan')),
                    'fenlei'=>array('ming'=>'分类设置','url'=>UH('weizhan/fenlei')),
                    ),
            ),

    'xuanxiang'=>array(
            'ming'=>'API接口',
            'tubiao'=>' fa-umbrella text-info',
            'url'=>'',
            'erji'=>array(
                    'weixin'=>array('ming'=>'支付参数','url'=>UH('xuanxiang')),
                    'duanxin'=>array('ming'=>'短信接口','url'=>UH('xuanxiang/duanxin')),
                    'app'=>array('ming'=>'APP配置','url'=>UH('xuanxiang/app')),
//                  'email'=>array('ming'=>'邮箱接口','url'=>UH('xuanxiang/email')),
//                  'qunfa'=>array('ming'=>'群发功能','url'=>UH('xuanxiang/qunfa')),                
                    ),
            ),
  
    'zw_shangcheng'=>array(
	    'ming'=>'和万家',
	    'tubiao'=>' icon-home text-success',
	    'url'=>UH('shangpin/index/zw_shangcheng')
    ),
   
    'xitong'=>array(
            'ming'=>'系统设置',
            'tubiao'=>' fa-laptop text-success',
            'url'=>'',
            'erji'=>array(
//                  'kuozhan'=>array('ming'=>'扩展','url'=>UH('xitong/kuozhan')),
                    'gongzhonghao'=>array('ming'=>'公众号管理','url'=>UH('danyuan')),
                    'caozuojilu'=>array('ming'=>'操作记录','url'=>UH('xitong/caozuojilu')),
//                  'guanliyuan'=>array('ming'=>'管理员','url'=>UH('xitong/guanliyuan')),
//                  'xitong'=>array('ming'=>'系统配置','url'=>''),
                    ),
            ),    
);
?>