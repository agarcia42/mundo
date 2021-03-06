<?php
class Ciudades extends ActiveRecord
	{
	public function initialize ()
    {
        $this->primary_key=array('id_ciudad');
    }
	public function obtener_municipios($id_entidad)
		{return $this->find("conditions: id_entidad = {$id_entidad}", "order: municipio");}

	public function busca_una($id)
		{return $this->find_first("conditions: id_municipio = {$id}");}
	
	public function busca($id){
		$deslug="";
		$x=$this->find_first("conditions: to_number(id_entidad||'0'||id_ciudad,'9999999999') = '$id'");
		if($x){
			$deslug=$x->ciudad;
		}
		return $deslug;
	}
	
	}

?>
