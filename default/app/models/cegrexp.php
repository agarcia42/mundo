<?php
class Cegrexp extends ActiveRecord 
	{
	public function initialize ()
    {
        $this->primary_key=array('acto','fecgra','codcar','numcar');
    }
	}
	
?>
