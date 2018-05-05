<?php
class Representante extends ActiveRecord
	{
	public function initialize ()
    {
        $this->primary_key=array('cedrep');
    }
	
	public function busca_uno($id=0){
			return $this->find_first("conditions: cedrep='$id'");
	}
	
	public function nroest($cedrep){
		return $this->count("conditions: cedrep='$cedrep'");
	}

	public function recibe(){
			$cedrep = Input::request("cedrep");
			$nomrep = Input::request("nomrep"); 
			$aperep = Input::request("aperep");
			$fields="cedrep:{$cedrep},nomrep:{$nomrep},aperep:{$aperep}";
			return Conests::conditions($fields);
	}
	
	public function buscar($conditions=NULL,$page=1,$perpage=10){
		return $this->paginate("page: $page","per_page: $perpage",$conditions,"order: aperep asc,nomrep asc");
	}

	public function tipo($id=0){
			$tip=$this->find_first("conditions: cedrep='$id'");
			return $tipo = ($tip) ? 'F': 'P';
	}
}
?>
  
