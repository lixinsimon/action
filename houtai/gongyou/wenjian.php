<?php
defined('IN_IA') or exit('Access Denied');
error_reporting(0);
global $_W;


han('wenjian');
DengLu(true);
$shangchuanmulu=GENMULU.'/gongyong/shangchuan';
$do=$_J['c'];
if (!in_array($do, array('upload', 'fetch', 'browser', 'delete', 'local'))) {
	exit('Access Denied');
}


$result = array(
	'error' => 1,
	'message' => '',
	'data' => ''
);
$type = $_J['leixing'] ? $_J['leixing'] : 'image';
$option =$_POST;


$option['width'] = intval($option['width']);

$dest_dir = '';

$setting = $_W['config']['upload'][$type];
$uniacid =$_W['danyuan'];

$setting['folder'] .= "{$type}s/{$uniacid}/".date('Y_m/');

if ($do == 'fetch') {
	$url = trim($_J['url']);
	load()->func('communication');
	$resp = ihttp_get($url);
	if (is_error($resp)) {
		$result['message'] = '提取文件失败, 错误信息: '.$resp['message'];
		die(json_encode($result));
	}
	if (intval($resp['code']) != 200) {
		$result['message'] = '提取文件失败: 未找到该资源文件.';
		die(json_encode($result));
	}
	$ext = '';
	if ($type == 'image') {
		switch ($resp['headers']['Content-Type']){
			case 'application/x-jpg':
			case 'image/jpeg':
				$ext = 'jpg';
				break;
			case 'image/png':
				$ext = 'png';
				break;
			case 'image/gif':
				$ext = 'gif';
				break;
			default:
				$result['message'] = '提取资源失败, 资源文件类型错误.';
				die(json_encode($result));
				break;
		}
	} else {
		$result['message'] = '提取资源失败, 仅支持图片提取.';
		die(json_encode($result));
	}
	
	if (intval($resp['headers']['Content-Length']) > $setting['limit'] * 1024) {
		$result['message'] = '上传的媒体文件过大('.sizecount($size).' > '.sizecount($setting['limit'] * 1024);
		die(json_encode($result));
	}
	$originname = pathinfo($url, PATHINFO_BASENAME);
	$filename = file_random_name($shangchuanmulu .'/'. $setting['folder'], $ext);
	$pathname = $setting['folder'] . $filename;
	$fullname = $shangchuanmulu . '/' . $pathname;
	if (file_put_contents($fullname, $resp['content']) == false) {
		$result['message'] = '提取失败.';
		die(json_encode($result));
	}
}

if ($do == 'upload') {	
	if (empty($_FILES['file']['name'])) {
		$result['message'] = '上传失败, 请选择要上传的文件！';
		die(json_encode($result));
	}
	
	if ($_FILES['file']['error'] != 0) {
		$result['message'] = '上传失败, 请重试.';
		die(json_encode($result));
	}
	
	$ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);	
	$ext = strtolower($ext);
	$size = intval($_FILES['file']['size']);
	$originname = $_FILES['file']['name'];	
	$filename = file_random_name($shangchuanmulu .'/'. $setting['folder'], $ext); 	
	$filename=$setting['folder'] . $filename;
	$guid=$_J['guid'];
	$id=$_J['id'];
	$chunk=$_J['chunk'];
	if($_J['chunks']>$_J['chunk']){
		$L="linshi/{$guid}{$id}{$chunk}.{$ext}";
	}else{
		$L=$filename;
	}
	
	$file = file_upload($_FILES['file'], $type, $L); 
	$isQuan=true;
	
	for($i=0;$i<$_J['chunks'];$i++){		
		$w[$i]="gongyong/shangchuan/linshi/{$guid}{$id}{$i}.{$ext}";
		$s=GENMULU.'/'.$w[$i];		
		if(!is_file($s) && $isQuan){			
			$isQuan=false;		
		}
	}
	if($isQuan){		
		$L='gongyong/shangchuan/'.$filename;	
		HeBingWenJian($L,$w);
	}		
	$pathname =$filename;  
	$fullname = $shangchuanmulu . '/' . $pathname;	
}

if ($do == 'fetch' || $do == 'upload') {
	if($type == 'image'){
		$thumb = empty($setting['thumb']) ? 0 : 1; 		
		$width = intval($setting['width']); 
		if(isset($option['thumb'])){
			$thumb = empty($option['thumb']) ? 0 : 1;
		}
		if (isset($option['width']) && !empty($option['width'])) {
			$width = intval($option['width']);
		}
		if ($thumb == 1 && $width > 0) {
			$thumbnail = file_image_thumb($fullname, '', $width);
			@unlink($fullname);
			if (is_error($thumbnail)) {
				$result['message'] = $thumbnail['message'];
				die(json_encode($result));
			} else {
				$filename = pathinfo($thumbnail, PATHINFO_BASENAME);
				$pathname = $thumbnail;
				$fullname = $shangchuanmulu .'/'.$pathname;
			}
		}
	}
   
	$info = array(
		'name' => $originname,
		'ext' => $ext,
		'filename' => $pathname,
		'attachment' => $pathname,
		'url' => JueDuiUrl($pathname),
		'is_image' => $type == 'image' ? 1 : 0,
		'filesize' => filesize($fullname),
	);

    ChaRu('he_shangchuan',array('danyuan'=>$_W['danyuan'],'yid'=>$_W['yonghu']['id'],'mingcheng'=>$originname,'lujing'=>$pathname,'leixing'=>'image' ? 1 : 2,'shijian'=>SHIJIAN));
	die(json_encode($info));
}

if ($do == 'delete') {
	$id = intval($_J['id']);
	$media = pdo_get('he_shangchuan', array('danyuan' => $_W['danyuan'], 'id' => $id));
	if(empty($media)) {
		exit('文件不存在或已经删除');
	}
	if(empty($_W['isfounder']) && $_W['role'] != 'manager') {
		exit('您没有权限删除该文件');
	}
	
	if (!empty($_W['config']['remote']['type'])) {
		$status = file_remote_delete($media['lujing']);
	} else {
		$status = file_delete($media['lujing']);
	}
	if(is_error($status)) {
		exit($status['message']);
	}
	pdo_delete('he_shangchuan', array('danyuan' => $_W['danyuan'], 'id' => $id));
	exit('success');
}

if ($do == 'local') {
	$types = array('image', 'audio');
	$type = in_array($_J['type'], $types) ? $_J['type'] : 'image';
	$typeindex = array('image' => 1, 'audio' => 2);
	$condition = ' WHERE danyuan = :danyuan AND leixing = :type';
	$params = array(':danyuan' => $_W['danyuan'], ':type' => $typeindex[$type]);
	$year = intval($_J['year']);
	$month = intval($_J['month']);
	if($year > 0 || $month > 0) {
		if($month > 0 && !$year) {
			$year = date('Y');
			$starttime = strtotime("{$year}-{$month}-01");
			$endtime = strtotime("+1 month", $starttime);
		} elseif($year > 0 && !$month) {
			$starttime = strtotime("{$year}-01-01");
			$endtime = strtotime("+1 year", $starttime);
		} elseif($year > 0 && $month > 0) {
			$year = date('Y');
			$starttime = strtotime("{$year}-{$month}-01");
			$endtime = strtotime("+1 month", $starttime);
		}
		$condition .= ' AND shijian >= :starttime AND shijian <= :endtime';
		$params[':starttime'] = $starttime;
		$params[':endtime'] = $endtime;
	}

	$page = intval($_J['page']);
	$page = max(1, $page);
	$size = $_J['pagesize'] ? intval($_J['pagesize']) : 32;

	$remote = $_W['config']['remote'];   
	$sql = 'SELECT * FROM '.BM('he_shangchuan')." {$condition} ORDER BY id DESC LIMIT ".(($page-1)*$size).','.$size;
	$list = pdo_fetchall($sql, $params, 'id');    
	foreach ($list as &$item) {
		$item['filename']=$item['lujing'];
		$item['url'] = jueDuiURL($item['lujing']);
		$item['createtime'] = date('Y-m-d', $item['shijian']);
		$item['attachment']=$item['lujing'];
		unset($item['yid']);
	}
	
	$total = pdo_fetchcolumn('SELECT count(*) FROM '.BM('he_shangchuan') ." {$condition}", $params);	
	XiaoXi(array('page'=> FenYe($total, $page, $size, '', array('before' => '2', 'after' => '2', 'ajaxcallback'=>'null')), 'items' => $list), '', 'ajax');
}