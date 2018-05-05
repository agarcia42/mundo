<?php
class Menu extends ActiveRecord 
	{
	public function initialize ()
    {
        $this->primary_key=array('codmen');
    }
	public function buscar(){
			return $this->find("order: codmen,codmsp");
	}


	public function buscar_uno($id=0){
			return $this->find_first("conditions: codmen='$id'","order: codmen,codmsp");
		}
		
	public function buscar_uno_superior($id=0){
			return $this->find_first("conditions: codmsp='$id'","order: codmen,codmsp");
		}
	
	}
	
?>

