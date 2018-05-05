<?php
			
	class Permisos extends ActiveRecord {
	public function initialize ()
    {
        $this->primary_key=array('codmen','cedusu');
    }
	
	public function buscar(){
			return $this->find("order: codmen,codmsp");
	}


	public function buscar_uno($id=0,$codmen=0){
			return $this->find_first("conditions: cedusu='$id' and codmen='$codmen'","order: codmen");
		}
	}
	
?>
