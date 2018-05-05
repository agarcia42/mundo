<?php
class Cerror extends ActiveRecord
	{
		public function initialize ()
    	{
    	    $this->primary_key=array('coderr');
    	}
    	public function selecciona($coderr=0,$deserr=""){
    		$coderr=(isset($coderr) or $coderr!="") ? $coderr : 0;
    		$cerror=$this->find_first("conditions: coderr='$coderr'");
    		if($cerror){
    			$deserr=$cerror->deserr;
    		}
    		return $deserr;
    	}
	}
?>
  
