<?php
class Cenoti extends ActiveRecord 
	{
	public function initialize ()
    {
        $this->primary_key=array('idtab','noticia');
		
    }
    
 }