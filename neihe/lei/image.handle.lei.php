<?php


class ImageHandle{
    private $tmpdir='.';
    private $font = array("family" => "./simkai.ttf", "color" => array(0, 0, 0), "size" => 16);
 
    public function SetTmpDir($tdir = ""){
        if(empty($tdir)){
            $tdir=GENMULU . "/huancun/tmp/"; 
        }
       if (!file_exists($tdir)) {
            mkdir($tdir,0777);
            chmod($tdir,0777);
        } 
        $this->tmpdir = $tdir; 

    }


    public function SetFont($font){
        foreach ($this->font as $key => $value) {
            if (array_key_exists($key, $font)) {
                $this->font[$key] = $font[$key];
            }
        }
    }   
    public function isType($image){
        $imageinfo = getimagesize($image);
        $former = false;
        switch (end($imageinfo)) {
            case 'image/jpeg':
                $former = imagecreatefromjpeg($image);
                break;
            case 'image/png':
                $former = imagecreatefrompng($image);
                break;
            default:
                break;

        }           
        return $former;
    }
    public function wpjam_hex2rgb($hex){
        $hex = str_replace("#", "", $hex);

        if (strlen($hex) == 3) {
            $r = hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
            $g = hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
            $b = hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
        } else {
            $r = hexdec(substr($hex, 0, 2));
            $g = hexdec(substr($hex, 2, 2));
            $b = hexdec(substr($hex, 4, 2));
        }

        return array($r, $g, $b);
    }

   
    public function heChengHaiBao($beijing = null, $hy=array(), $erweima = null, $data = null,$lujing=null){      
        global $_W;  	
		 
        if(substr($hy['touxiang'], 0, 4) == "http"){
            $touxiang= GENMULU . "/huancun/touxiang/"; 
            if (!file_exists($touxiang)) {
                mkdir($touxiang,0777);
                chmod($touxiang,0777);
            }
           $ming= md5($hy['touxiang']).".jpg";  
           $hy['touxiang']=XiaZaiTu($hy['touxiang'],$ming,$touxiang);         
         }       
       
        if (!file_exists($beijing) ||  empty($hy['id'])) {
            return false;
        }   
       
        $bj = $this->isType($beijing); 
        $x=  imagesx($bj);
        $y=  imagesy($bj);
          
        $new = imagecreatetruecolor(640, 1008);
        imagecopyresampled($new, $bj, 0, 0, 0, 0,640, 1008,$x,$y);     
        foreach ($data as $k => $v) {   
            if ($v['type'] == 'head' && file_exists($hy['touxiang'])) {             
                $width = explode('p', $v['width']);
                $height = explode('p', $v['height']);
                $left = explode('p', $v['left']);
                $top = explode('p', $v['top']);
                $x=$left[0] * 2;
                $y=$top[0] * 2;
                $w=$width[0] * 2;
                $h=$height[0] * 2;
                $t =  $this->isType($hy['touxiang']);
                $gox=  imagesx($t);
                $goy=  imagesy($t);
                $new = imagecreatetruecolor($w,$h);
                imagecopyresampled($new,$t, 0, 0, 0, 0, $w,$h, $gox,$goy);
                imagecopymerge($bj, $new, $x, $y, 0, 0, $w,$h, 100);
              
            }          
            if ($v['type'] == 'qr' && file_exists($erweima)) {
                $width = explode('p', $v['width']); 
                $height = explode('p', $v['height']);
                $left = explode('p', $v['left']);
                $top = explode('p', $v['top']);
                $x=$left[0] * 2;
                $y=$top[0] * 2;
                $w=$width[0] * 2;
                $h=$height[0] * 2;
                $ew =  $this->isType($erweima);
                $gox=  imagesx($ew);
                $goy=  imagesy($ew);
                $new = imagecreatetruecolor($w,$h);
                imagecopyresampled($new,$ew, 0, 0, 0, 0, $w,$h, $gox,$goy);
                imagecopymerge($bj, $new, $x, $y, 0, 0, $w,$h, 100);

            }           
            if ($v['type'] == 'nickname' && $hy['nicheng']) {
                $left = explode('p', $v['left']);
                $top = explode('p', $v['top']);
                $size = explode('p', $v['size']);
                $x=$left[0] * 2;
                $y= $top[0] * 2;
               
                $fontcolor= $v['color'];
                $fontsize= $size[0];
                $text=$hy['nicheng'];
                $color1= $this->wpjam_hex2rgb($fontcolor);
                $color = imagecolorallocate($bj, $color1[0], $color1[1], $color1[2]);              
                $fontbox = imageftbbox($this->font['size'], 0, $this->font['family'], $text);
                imagettftext($bj, $fontsize, 0, ceil((imagesx($bj) - $fontbox[2]) / 2), $y, $color, $this->font['family'], $text);
            }
            if ($v['type'] == 'img' && !empty($v['src'])) {
                $img=GENMULU . '/gongyong/shangchuan/' . $v['src'];
                if(file_exists($img)){          
                    $width = explode('p', $v['width']);
                    $height = explode('p', $v['height']);
                    $left = explode('p', $v['left']);
                    $top = explode('p', $v['top']);              
                    $x=$left[0] * 2;
                    $y=$top[0] * 2;
                    $w=$width[0] * 2;
                    $h=$height[0] * 2;
                    $ew =  $this->isType($img);
                    $gox=  imagesx($ew);
                    $goy=  imagesy($ew);
                    $new = imagecreatetruecolor($w,$h);
                    imagecopyresampled($new,$ew, 0, 0, 0, 0, $w,$h, $gox,$goy);
                    imagecopymerge($bj, $new, $x, $y, 0, 0, $w,$h, 100);                  
                }
               
            }
//          $yaoqingma = $hy['id'];
//          if ($yaoqingma < 1000) {
//              $yaoqingma = sprintf('%04d', $yaoqingma);
//          }
         
//          $fontcolor= '#FFFFFF';           
//          $text="我的邀请码: " . $yaoqingma;         
//          $color1= $this->wpjam_hex2rgb($fontcolor);
//          $color = imagecolorallocate($bj, $color1[0], $color1[1], $color1[2]);          
//          $fontbox = imageftbbox($this->font['size'], 0, $this->font['family'], $text);
//          imagettftext($bj, 16, 0, ceil((imagesx($bj) - $fontbox[2]) / 2), 350, $color, $this->font['family'], $text);          
          
        }
           

        imagejpeg($bj, $lujing, 100);
        imagedestroy($bj);
        imagedestroy($new);   
         
        return $lujing;
    }

}

