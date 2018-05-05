<?php
class Parroquia extends ActiveRecord
	{
	public function initialize ()
    {
        $this->primary_key=array('id_entidad', 'id_municipio', 'id_parroquia');
    }
	public function obtener_parroquias($id_entidad, $id_municipio)
		{return $this->find("conditions: id_entidad = {$id_entidad} and id_municipio = {$id_municipio}","order: parroquia");}

	public function busca_una($id)
		{return $this->find_first("conditions: id = {$id}");}
	}
?>
