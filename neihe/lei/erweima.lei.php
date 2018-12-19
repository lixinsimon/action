<?php
Zai('neihe/ku/erweima/phpqrcode.php');
class erweima{
	public function shengcheng($zhi='',$ming='',$logo=false){
		$zhi=urldecode($zhi); 
		if(empty($zhi)){
			return false;
		}	   
	    $errorCorrectionLevel="L"; 
	    $matrixPointSize=20; 	
	    if(empty($ming)){
	    	$ming=md5($zhi);
	    }
	    $MULU=GENMULU.'/huancun/erweima';
	    if(!is_dir($MULU)){	    	
	    	mkdir($MULU,0777);
	    	chmod($MULU,0777);	
	    }
	    $QR=$MULU.'/'.$ming.'.png';
	    QRcode::png($zhi,$QR,$errorCorrectionLevel,$matrixPointSize,2);    
		if ($logo !== FALSE) {   
			$QR = imagecreatefromstring(file_get_contents($QR));   
			$logo = imagecreatefromstring(file_get_contents($logo));   
			$QR_width = imagesx($QR);//二维码图片宽�?   
			$QR_height = imagesy($QR);//二维码图片高�?   
			$logo_width = imagesx($logo);//logo图片宽度   
			$logo_height = imagesy($logo);//logo图片高度   
			$logo_qr_width = $QR_width / 5;   
			$scale = $logo_width/$logo_qr_width;   
			$logo_qr_height = $logo_height/$scale;   
			$from_width = ($QR_width - $logo_qr_width) / 2; //重新组合图片并调整大�?   
			imagecopyresampled($QR, $logo, $from_width, $from_width, 0, 0, $logo_qr_width,   
			$logo_qr_height, $logo_width, $logo_height);
			$filename=urldecode($ming.'_logo');
			if(strpos($_SERVER["HTTP_USER_AGENT"],"Trident")){
				$filename=iconv('UTF-8', 'gbk', $filename);
			}
			imagepng($QR, $MULU.'/'.$filename.'.png');
			$dailogo='huancun/erweima/'.$ming.'.png';   
		}else{
			$dailogo='huancun/erweima/'.$ming.'.png';
		}			
		return $dailogo;	
		
	}
	
}
?>