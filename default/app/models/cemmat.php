<?php
class Cemmat extends ActiveRecord{
	
	
	public function initialize (){
        $this->primary_key=array('numcar','codcar','codsed','tiphor','indsig','numano','numper','codmat');
    }
		
	public function busca_uno($codcar,$codmat){
				return $this->find_first("conditions: codcar='$codcar' and codmat='$codmat'");
	}
	
	
}
?>
