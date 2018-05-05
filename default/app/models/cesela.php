<?php
class Cesela extends ActiveRecord
	{
	public function initialize (){
        $this->primary_key=array('codcar', 'tiphor', 'codsed','indsig','numano','numper','codmat','codsec','codlab','seclab');
    }

 	}
?>
