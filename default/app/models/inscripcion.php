<?php
class Inscripcion extends ActiveRecord
	{
	public function initialize ()
    {
        $this->primary_key=array('codaul');
    }
	public function busca_uno($cedrep=0,$codalu=0){
			return $this->find_first("conditions: cedrep='$cedrep' and codalu='$codalu'");
	}

	public function encuentra($cedrep=0,$codalu=0){
			return $this->find_first("conditions: cedrep='$cedrep' and codalu='$codalu'");
	}
	
}
?>
  
