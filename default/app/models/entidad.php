<?php
class Entidad extends ActiveRecord
	{
	public function initialize ()
    {
        $this->primary_key=array('id_entidad');
    }
	public function todas()
		{return $this->find("order: entidad");}

	public function busca_una($id)
		{return $this->find_first($id);}

	public function busca($id){
		$deslug="";
		$x=$this->find_first("conditions: id_entidad = {$id}");
		if($x){
			$deslug=$x->entidad;
		}
		return $deslug;
	}
	public function ent_pais($pais)
		{return $this->find("conditions: id_pais ={$pais}","order: entidad");}

	}
?>
