<?php
class Esquema extends ActiveRecord
	{
	public function initialize ()
    {
        $this->primary_key=array('codesq');
    }
	
	public function busca(){
		$y=$this->find_first("order: codesq asc");
		$codesq=($y)? $y->codesq : 0;
		return $codesq;
	}
	
}
?>
  
