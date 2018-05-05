<?php
class Ceusua extends ActiveRecord 
	{
	public function initialize ()
    {
        $this->primary_key=array('cedusu');
    }
	public function logeo($usuario=0,$clave=0){
			return $this->find_first("conditions: login = '$usuario' and password = '$clave'");
		}
		
		public function busca_uno($id=0){
			return $this->find_first("conditions: cedusu='$id'");
		}
	}
	
?>
