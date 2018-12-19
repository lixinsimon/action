<?php

class excel{  
	public function __construct() {
	         /*导入phpExcel核心类    注意 ：你的路径跟我不一样就不能直接复制*/
	         include_once(GENMULU . '/neihe/ku/phpexcel/PHPExcel.php');
	         require_once GENMULU . '/neihe/ku/phpexcel/PHPExcel/IOFactory.php'; 
	         require_once GENMULU . '/neihe/ku/phpexcel/PHPExcel/Reader/Excel5.php'; 
    }  
    public function DaoChu($mb='daochu'){
		header("Content-type:application/vnd.ms-excel");
		header("Content-Disposition:filename=" . date('Y-m-d H:i:s', SHIJIAN). ".xls");
	    echo mb($mb,'TEMPLATE_FETCH');
	    return true;
    }
    public function DaoRu($wenjian=''){
    	if(empty($wenjian)){
    		return false;
    	}
    	$cellName = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ');  
    	$objReader = PHPExcel_IOFactory::createReader('Excel5');
    	$objPHPExcel = $objReader->load($wenjian); 
    	$sheet = $objPHPExcel->getSheet(0);  
    	$highestRow = $sheet->getHighestRow(); 
    	$highestColumn = $sheet->getHighestColumn(); // 取得总列数 $k = 0;    
    	 $getActiveSheet=$objPHPExcel->getActiveSheet()->getCell()->getValue(); 
    	
        $columnCnt = array_search($highestColumn, $cellName); 
      
       for($_row=1;$_row<=$highestRow;$_row++) {   
	       	 for($_column=0; $_column<=$columnCnt; $_column++){  
	            $cellId = $cellName[$_column].$_row;  	          
	            $cellValue =$objPHPExcel->getActiveSheet()->getCell($cellId)->getValue();  
	           
	            if($cellValue instanceof PHPExcel_RichText){   //富文本转换字符串  
	                $cellValue = $cellValue->__toString();  
	            }  	  
	            $data[$_row][$cellName[$_column]] = $cellValue;  
	        }  
       	      	 
       }      
        return $data;   	 
    
    }
}