<?php
			
	class Cefper extends ActiveRecord {
	public function initialize ()
    {
        $this->primary_key=array('codcar', 'codsed', 'tiphor', 'indsig', 'numper', 'numano');
    }
	}
	
?>
