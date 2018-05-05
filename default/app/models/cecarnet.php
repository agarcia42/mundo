<?php
class Cecarnet extends ActiveRecord
	{
	public function initialize ()
    {
   		$this->primary_key=array('numcar', 'codcar', 'fecreg','nomuse','mes','ano','solicitud');
    }
		
	}
?>
