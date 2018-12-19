<?php
//检验是否登录
function DengLu($fanhuizhi=false){
	global $_W;
	session_start();
	$heyan=md5($_SESSION['yonghu']['id'].$_SESSION['yonghu']['yonghuming'].$_SESSION['yonghu']['denglushijian']);	
	if($_SESSION['yonghu'] && $_SESSION['yonghu']['id']>0 && $_SESSION['yonghu']['yonghuming'] && $_SESSION['yonghu']['md5']==$heyan){
		$_W['yonghu']['id']=$_SESSION['yonghu']['id'];
		$_W['yonghu']['yonghuming']=$_SESSION['yonghu']['yonghuming'];
		$_W['yonghu']['md5']=$_SESSION['yonghu']['md5'];
		$_W['yonghu']['shenfen']=$_SESSION['yonghu']['shenfen'];
		return true;
	}else{
		if($fanhuizhi){
		   return false;
		}else{
		   XiaoXi('未登录',UH('denglu'));
		}
		
	}
}


function QuanXian($zhi='',$bufanhui=true){
	global $_W;	
	if($_W['yonghu']['shenfen']<3){
		return true;
	}
	session_start();
    //if(empty($_SESSION['yonghu']['quanxian']) || $_SESSION['danyuan']!=$_W['danyuan']){			
		$guanliyuan=Qu('he_danyuan_guanliyuan',array('guanliyuanid'=>$_SESSION['yonghu']['id']));
		$_SESSION['yonghu']['quanxian']=explode('|',$guanliyuan['quanxian']);
		$_SESSION['danyuan']=$guanliyuan['danyuanid'];		
   // }
     
    $q=$_W['kong'].'_'.$_W['xing'];  
  
    $q=empty($_W['mo'])?$q:$_W['mo'].'_'.$q;
    if(!empty($zhi)){
    	$q.='_'.$zhi;
    } 
  
    if(in_array($q,$_SESSION['yonghu']['quanxian'])){
    	return true;
    }
    if($bufanhui){
    	XiaoXi('您的权限不够！','',1);
    }
    return false;
}
function ShangTu($name='', $value = '',$meiyuming=0){	
	if(empty($name)){
		return 'name值没有';
	}
    if(empty($value)){
    	$val = '../gongyong/images/nopic.jpg';	
    }else{
    	$val = JueDuiURL($value);
    }
	
	
	$s = '<div class="shangtu_zujian">
		<div class="input-group " onclick="$ShangTu(this)" meiyuming="'.$meiyuming.'">
			<input type="text" name="' . $name . '" value="' . $value . '"  class="form-control st_img" readonly="readonly"  autocomplete="off">
			<span class="input-group-btn">
				<button class="btn btn-default" type="button" ">选择图片</button>
			</span>
		</div>
		<div class="input-group  style="margin-top:.5em;">
			<img src="' . $val . '" class="img-responsive img-thumbnail st_img" width="150" />
			<em class="close" style="position:absolute; top: 0px; right: -14px;" title="删除这张图片" onclick="$ShanChuTu(this)">×</em>
		</div></div>';
	return $s;

}
function ShangDuoTu($name, $value = array(), $options = array()) {
	global $_W;
	$default = '../gongyong/images/nopic.jpg';		
	
    $ShangDuoTu='$ShangDuoTu';
   
	$s = <<<EOF
<div class="input-group" onclick="$ShangDuoTu(this)" name='{$name}[]'>
	<input type="text" class="form-control" readonly="readonly" value="" placeholder="批量上传图片" autocomplete="off">
	<span class="input-group-btn">
		<button class="btn btn-default" type="button" >选择图片</button>		
	</span>
</div>
<div class="input-group multi-img-details">
EOF;

   
	if (is_array($value) && count($value) > 0) {
		foreach ($value as $row) {
			$s .= '
<div class="multi-item" style="float:left;margin-top:10px;"><img src="' . JueDuiUrl($row) . '"  class="img-responsive img-thumbnail" style="width:150px"><input type="hidden" name="' . $name . '[]" value="' . $row . '" ><em class="close" title="删除这张图片" onclick="$ShanChuDuoTu(this)">×</em>
</div>';
		}
	}
	$s .= '</div>';

	return $s;
}
function YanSe($name, $value = '') {
	$s = '';
	if (!defined('TPL_INIT_COLOR')) {
		$s = '
		<script type="text/javascript">
			require(["jquery", "util"], function($, util){
				$(function(){
					$(".colorpicker").each(function(){
						var elm = this;
						util.colorpicker(elm, function(color){
							$(elm).parent().prev().find(":text").val(color.toHexString());
						});
					});
					$(".colorclean").click(function(){
						$(this).parent().prev().val("");
						var $container = $(this).parent().parent().parent().next();
						$container.find(".colorpicker").val("");
						$container.find(".sp-preview-inner").css("background-color","#000000");
					});
				});
			});
		</script>';
		define('TPL_INIT_COLOR', true);
	}
	$s .= '
		<div class="row row-fix">
			<div class="col-xs-6 col-sm-4" style="padding-right:0;">
				<div class="input-group">
					<input class="form-control" type="text" placeholder="请选择颜色" value="'.$value.'">
					<span class="input-group-btn">
						<button class="btn btn-default colorclean" type="button">
							<span><i class="fa fa-remove"></i></span>
						</button>
					</span>
				</div>
			</div>
			<div class="col-xs-2" style="padding:2px 0;">
				<input class="colorpicker" type="text" name="'.$name.'" value="'.$value.'" placeholder="">
			</div>
		</div>
		';
	return $s;
}
//后台操作记录
function CaoZuoJiLu($jilu=''){	
	global $_W;
	
	$s['danyuan']=$_W['danyuan'];
	$s['hyid']=$_W['yonghu']['id'];
	$s['zhanghao']=$_W['yonghu']['yonghuming'];	
    $s['jilu']=$jilu;
    $s['url']=$_W['url'];
    $s['shijian']=SHIJIAN;
	return ChaRu('he_caozuojilu',$s);
}
function ShangShiPin($name, $value = '') {

	$s.='<div class="input-group" >		
		<input type="text" value="'.$value.'" name="'.$name.'" class="form-control img_url" autocomplete="off">		
		<span class="input-group-btn" >
			<button class="btn btn-default audio-player-play" type="button" style="display:none;"><i class="fa fa-play"></i></button>
			<button class="btn btn-default ShangShiPin" type="button" >选择媒体文件</button>			
		</span>
	</div>';
	return $s;
}

function ShangWenJian($name, $value = '') {

	$s.='<div class="input-group" >		
		<input type="text" value="'.$value.'" name="'.$name.'" class="form-control img_url" autocomplete="off">		
		<span class="input-group-btn" >
			<button class="btn btn-default audio-player-play" type="button" style="display:none;"><i class="fa fa-play"></i></button>
			<button class="btn btn-default ShangWenJian" type="button" >选择文件</button>			
		</span>
	</div>';
	return $s;
}
?>