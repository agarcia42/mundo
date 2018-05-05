<?php
class Cecagr extends ActiveRecord 
	{
		public function initialize ()
    {
        $this->primary_key=array('acto','fecgra','codcar','codsed','tiphor');
    }

    public function acto_activo ($codcar,$codsed,$tiphor,$acto){
    	$fecgra="";
        $y=$this->find_first("conditions: acto='$acto' and codcar='$codcar' and codsed='$codsed' and tiphor='$tiphor' and acto||fecgra in (select acto||fecgra from cegrpa where acto='$acto' and status='A')","order: acto,fecgra desc");
    	if($y){
    		$fecgra=$y->fecgra;
    	}   
    	return $fecgra; 

    }

	}
?>