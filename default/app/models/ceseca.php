<?php
class Ceseca extends ActiveRecord
	{
	public function initialize ()
    	{$this->primary_key=array('codcar', 'tiphor', 'codsed');}

  public function retornaSeccion($datos, $numano=0, $numper='', $codmat='')
    	  {
	  	  $codcar = $datos["codcar"];	
      	$codsed = $datos["codsed"];	
      	$tiphor = $datos["tiphor"];	
	  	  $conditions = "SELECT * FROM  CESECA 
                                WHERE codcar = '$codcar' and tiphor = '$tiphor' and codsed = '$codsed' and 
                                      numano = '$numano' and numper = '$numper' and codmat = '$codmat'";
	  	  if($lado = $this->find_all_by_sql($conditions))                                          
	       		return $lado;
	  	  else
      	  	return false;
      	}
 	}
?>
