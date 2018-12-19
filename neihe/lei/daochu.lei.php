<?php
class daochu{    
    public function DC($mb='daochu'){
		header("Content-type:application/vnd.ms-excel");
		header("Content-Disposition:filename=" . date('Y-m-d H:i:s', SHIJIAN). ".xls");
	    echo mb($mb,'TEMPLATE_FETCH');
	    return true;
    }
}