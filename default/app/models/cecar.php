<?php
class Cecar extends ActiveRecord
	{
public function initialize ()
    {
    $this->primary_key=array('codcar');
    }
	
	//Devuelve el registro cuya cedula sea $numced
	public function busca_una($id)
		{
		return $this->find_first("conditions: codcar = '$id'","order: codcar");
		}
	
	//Devuelve la descripcion de la carrera	
	public function bus_descar($codcar='0')
		{ 
		//echo $codcar;
		$ce=$this->find_first("codcar='$codcar'");
		return $ce->descar;
		}
		
	//Devuelve la descripcion del título	
	public function bus_titulo($codcar)
		{
		$cec=$this->find_first("conditions: codcar='$codcar'");
		return $cec->titlar;
		}
		
	}
?>
