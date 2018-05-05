<?php
class Cetela extends ActiveRecord
	{
public function initialize ()
    {
    $this->primary_key=array('codcar','codsed','tiphor','codmat');
    }
	
	//Devuelve el registro cuya cedula sea $numced
	public function selecciona($codcar,$codsed,$tiphor,$codmat)
		{
		return $this->find_first("conditions: codcar = '$codcar' and codsed='$codsed' and tiphor='$tiphor' and codmat='$codmat'");
		}
	

	public function seleted($codcar,$codsed,$tiphor,$codmat){
		 return $this->find("conditions: codcar='$codcar' and codsed='$codsed' and tiphor='$tiphor' and codmat='$codmat'");
	}
		
	}
?>