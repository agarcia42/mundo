<?php
class Ceplnp extends ActiveRecord
	{
	public function initialize ()
    {
        $this->primary_key=array('codcar', 'codpln', 'codmat', 'tiphor');
    }
	}
?>