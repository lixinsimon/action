<?php
	
if($_W['ispost']){	
	Han('wenjian');
	$wenjian=GENMULU.'/huancun/zhiwi/'.SHIJiAN.'.zip';
	mkdirs(dirname($wenjian)); 
	$str = file_get_contents('http://banma.heodo.com/zhiwi.v1.0.zip');
	if(empty($str)){		
		json('下载失败',0);
	}
	$shu=file_put_contents($wenjian,$str);
    if(!is_file($wenjian)){    	
    	json('权限不足',0);
    }   
    exec('chown -R www:www '.GENMULU);
    MX('zip','he')->unzip($wenjian,GENMULU.'/');
    @unlink($wenjian);  
    json('更新成功');
}	
mb('index');
?>