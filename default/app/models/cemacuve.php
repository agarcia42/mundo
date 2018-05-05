<?php
class Cemacuve extends ActiveRecord{
	
	
	public function initialize (){
        $this->primary_key=array('codcar','codmat');
    }
		
	public function uno($codcar){
		$cem=$this->find_first("conditions: codcar='$codcar'");
		return ($cem) ? true : false;
	}
		
	public function todos($codcar){
		return $this->find("conditions: codcar='$codcar'");
	}

	
}
?>
