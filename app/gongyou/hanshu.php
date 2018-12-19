<?php

//检验是否登录
function DengLu($fanhuizhi=false){	
	global $_W,$_J;	
	Han('wenjian');	
	session_start(); 	
	if($_SESSION['id']>0 && file_read('HuanCunShiJian')<$_SESSION['shijian']){				
		$_W['huiyuan']['id']=$_SESSION['id'];	
		$_W['huiyuan']['zhanghao']=$_SESSION['zhanghao'];
		$_W['huiyuan']['nicheng']=empty($_SESSION['xingming'])?$_SESSION['nicheng']:$_SESSION['xingming'];
		$_W['huiyuan']['touxiang']=$_SESSION['touxiang'];
		$_W['huiyuan']['openid']=$_SESSION['openid'];	
		$_W['danyuan']=$_SESSION['danyuan'];
		$_W['tui']=$_SESSION['id'];				
		return true;
	}elseif($fanhuizhi){
		 return false;
	}else{							
		json('未登录',-1);
	}
		
	
}
/**
* $str  微信昵称
**/
function GuoLv($str) {     
    if($str){
        $name = $str;
        $name = preg_replace('/\xEE[\x80-\xBF][\x80-\xBF]|\xEF[\x81-\x83][\x80-\xBF]/', '', $name);
        $return = preg_replace('/xE0[x80-x9F][x80-xBF]‘.‘|xED[xA0-xBF][x80-xBF]/S','?', $name);
        
        //$return = json_decode(preg_replace("#(\\\ud[0-9a-f]{3})#ie","",json_encode($name)));
        if(!$return){
            return $return;
        }
    }else{
        $return = '';
    }    
    return $return;

}
?>