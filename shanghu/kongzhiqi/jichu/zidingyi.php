<?php
	

if($cao=='moren'){
	if($_W['ispost']){
		$peizhi=MX('moxing','zw_shanghu')->PeiZhi($_W['shanghu']['id']); 
        $appid=$peizhi['xiaochengxu']['appid'];		
	    $b=array();		 
		foreach ($_J['name'] as $k=>$v) {				
		    if(empty($v['name'])){
		    	XiaoXi('菜单名称不能为空!');exit;
		    }		  
		    $b['button'][$k]['name']=$v['name'];
            unset($v['name']);
            if(empty($v)){
                if(empty($_J['url'][$k]) && ($_J['type'][$k]!='scancode_push' || $_J['type'][$k]!='miniprogram')){
					 XiaoXi('请设置链接或关键词');exit;
				}
				if(empty($appid) && $_J['type'][$k]!='miniprogram'){
					 XiaoXi('小程序appid没配置');exit;
				}
								
		        $b['button'][$k]['type']=$_J['type'][$k];
		        if($_J['type'][$k]=='view'){		        	
		           $b['button'][$k]['url']=$_J['url'][$k]; 
		        }elseif ($_J['type'][$k]=='click') {
		        	$b['button'][$k]['key']=$_J['url'][$k]; 
		        }elseif($_J['type'][$k]=='scancode_push'){
		        	$b['button'][$k]['key']='rselfmenu_0_1';		          
		        }elseif($_J['type'][$k]=='miniprogram'){
		        	$b['button'][$k]['appid']=$appid;
		        	$b['button'][$k]['pagepath']=$_J['url'][$k];
		        	$b['button'][$k]['url']='miniprogram'; 
		        }		  
		        
            }else{
            	$i=0;
            	foreach ($v as $kk => $vv) {
            		if(empty($vv)){
				    	XiaoXi('菜单名称不能为空!');exit;
				    }
                    if(empty($_J['url'][$k][$kk]) && ($_J['type'][$k][$i]!='scancode_push' || $_J['type'][$k][$kk]=='miniprogram')){
					    XiaoXi('请设置链接或关键词');exit;
				     }
				    if(empty($appid) && $_J['type'][$k][$kk]=='miniprogram'){
					 XiaoXi('小程序appid没配置');exit;
				    }
			    	$b['button'][$k]['sub_button'][$i]['name']=$vv;
			    	$b['button'][$k]['sub_button'][$i]['type']=$_J['type'][$k][$kk];
			    	if($_J['type'][$k][$kk]=='view'){
			           $b['button'][$k]['sub_button'][$i]['url']=$_J['url'][$k][$kk]; 
			        }elseif ($_J['type'][$k][$kk]=='click') {
			        	$b['button'][$k]['sub_button'][$i]['key']=$_J['url'][$k][$kk]; 
			        }elseif($_J['type'][$k][$kk]=='scancode_push'){
			        	$b['button'][$k]['sub_button'][$i]['key']='rselfmenu_0_1';		          
			        }elseif($_J['type'][$k][$kk]=='miniprogram'){
			        	$b['button'][$k]['sub_button'][$i]['appid']=$appid;	
			        	$b['button'][$k]['sub_button'][$i]['pagepath']=$_J['url'][$k][$kk];	
			        	$b['button'][$k]['sub_button'][$i]['url']='miniprogram';           
			        }			        
			        $i++;
			    }
            }
        }  
        $c=array(); 
        foreach($b['button'] as $o){
        	$c['button'][]=$o;
        }           
        $token=MX('weixin_shanghu','he')->AccessToken();
        if(empty($token)){
        	XiaoXi('更新菜单失败',USK('jichu/zidingyi'));exit;
        }
      
        $u="https://api.weixin.qq.com/cgi-bin/menu/create?access_token={$token}";      
        $d=jsonFormat($c);          
		$shu=ihttp_post($u,$d);		
		$s=json_decode($shu['content']);
		if($s->errmsg=='ok'){
			XiaoXi('更新菜单成功',USK('jichu/zidingyi'));exit;
		}else{			
			dump($shu);die;
		}
	}
	$cd=MX('weixin_shanghu','he')->quCaiDan();
//	dump($cd);die;
	
}
mb("zidingyi");
?>