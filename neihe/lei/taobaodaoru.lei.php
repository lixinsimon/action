<?php
Han('curl');
class taobaodaoru{
   function get_item_taobao($itemid = '', $taobaourl = '', $pcate = 0, $ccate = 0, $tcate = 0){
            global $_W;
            set_time_limit(0);
            $g =Qu('zw_shangcheng_shangpin', array('danyuan' => $_W['danyuan'], "taobaoid" => $itemid));               
           
            $data = get($taobaourl,false);    
            $data=iconv("GB2312","UTF-8//IGNORE",$data) ;
            $shu['tu']=$this->quTu($data);
            preg_match('/<title>([^<>]*)<\/title>/', $data,$biaoti);	
            $shu['biaoti']=	$biaoti[1];
            
            preg_match('/<([a-z]+)[^i]*id=\"J_StrPrice\"[^>]*>([^<]*)<\/\\1>/is', $data,$shu['jiage']);	
            	
            	
            //属性
           preg_match('/<(div)[^c]*class=\"attributes\"[^>]*>.*<\/\\1>/is', $text, $text0);	
	       $text1=preg_replace("/<\/div>[^<]*<(div)[^c]*id=\"description\"[^>]*>.*<\/\\1>/is","",$text0);	  
	       $shu['shuxing']=preg_replace("/<\/div>[^<]*<(div)[^c]*class=\"box J_TBox\"[^>]*>.*<\/\\1>/is","",$text1);	
	      
            dump($shu);die;
            
           
           
            return $this -> save_goods($item, $taobaourl);
        }
        function quTu($text){
           preg_match('/<img[^>]*id="J_ImgBooth"[^r]*rc=\"([^"]*)\"[^>]*>/', $text, $tu);          
           if(is_array($tu[0])){
           	 foreach($tu as $t){
              	$ts[]=$t[1];
             }	
           }else{
           	  $ts[]=$tu[1];
           }          	           	
           return $ts;
        }
        function save_image($url = '', $config){
            global $_W;
            if ($config){
                return p('qiniu') -> save($url, $config);
            }
            return $this -> saveToLocal($url);
        }
        function get_info_url($itemid){
            return "http://hws.m.taobao.com/cache/wdetail/5.0/?id=" . $itemid;
        }
        function get_detail_url($itemid){
            return 'http://hws.m.taobao.com/cache/wdesc/5.0/?id=' . $itemid;
        }
        function check_remote_file_exists($url){
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_NOBODY, true);
            $result = curl_exec($curl);
            $found = false;
            if ($result !== false){
                $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
                if ($statusCode == 200){
                    $found = true;
                }
            }
            curl_close($curl);
            return $found;
        }
        function saveToLocal($url){
            global $_W;
            if (empty($url)){
                return '';
            }
            if (!$this -> check_remote_file_exists($url)){
                return "";
            }
            $ext = strrchr($url, ".");
            if ($ext != ".jpeg" && $ext != ".gif" && $ext != ".jpg" && $ext != ".png"){
                return '';
            }
            $apath = $_W['config']['upload']['attachdir'] . "/";
            $path = "images/ewei_shop/" . $_W['uniacid'] . "/" . date('Y') . "/" . date('m') . "/";
            load() -> func('file');
            mkdirs(IA_ROOT . "/" . $apath . $path);
            do{
                $filename = random(30) . $ext;
            }while (file_exists(IA_ROOT . "/" . $apath . $path . '/' . $filename));
            $path .= $filename;
            $opts = array('http' => array('method' => "GET", 'timeout' => 7200,));
            $data = file_get_contents($url, false, stream_context_create($opts));
            $fp2 = @fopen(IA_ROOT . "/" . $apath . $path, "w");
            fwrite($fp2, $data);
            fclose($fp2);
            load() -> func('file');
            $remote = file_remote_upload($path);
            if($remote == true){
                file_delete($path);
            }
            return $path;
        }
        function get_pageno_url($url = '', $pageNo = 1){
            $url .= "/search.htm?pageNo=" . $pageNo;
            return $url;
        }
        function get_total_page($url = '', $taobao = false){
            if (empty($url)){
                return array("totalpage" => 0);
            }
            $content = $this -> get_page_content($url);
            die($content);
            $str = "";
            if ($taobao){
                $str = "/<span class=\"page-info\">(.*)<\/span>/";
            }else{
                $str = "/<b class=\"ui-page-s-len\">(.*)<\/b>/";
            }
            preg_match($str, $content, $p);
            if (is_array($p)){
                $pages = explode("/", $p[1]);
                return array('totalpage' => $pages[1]);
            }
            return array('totalpage' => 0);
        }
        function httpGet($url){
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_TIMEOUT, 500);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl, CURLOPT_URL, $url);
            $res = curl_exec($curl);
            curl_close($curl);
            return $res;
        }
        function get_page_content($url = '', $pageNo = 1){
            if (empty($url)){
                return array("totalpage" => 0);
            }
            $url = $this -> get_pageno_url($url, $pageNo);
            load() -> func('communication');
            $response = ihttp_get($url);
            if (!isset($response['content'])){
                return array("result" => 0);
            }
            return $response['content'];
        }
        function getRealURL($url){
            if (function_exists("stream_context_set_default")){
                stream_context_set_default(array('http' => array('method' => 'HEAD')));
            }
            $header = get_headers($url, 1);
            if (strpos($header[0], '301') || strpos($header[0], '302')){
                if (is_array($header['Location'])){
                    return $header['Location'][count($header['Location']) - 1];
                }else{
                    return $header['Location'];
                }
            }else{
                return $url;
            }
        }
        function get_pag_items($pageContent = ''){
            $str = '/data-id="(.*)"/U';
            preg_match_all($str, $pageContent, $items);
            if (isset($items[1])){
                return $items[1];
            }
            return array();
        }
        function perms(){
            return array('taobao' => array('text' => $this -> getName(), 'isplugin' => true, 'fetch' => '抓取宝贝-log'));
        }
}

