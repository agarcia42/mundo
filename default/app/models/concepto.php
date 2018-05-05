<?php
class Concepto extends ActiveRecord
	{
	public function initialize ()
    {
        $this->primary_key=array('codcon', 'codniv', 'codtar', 'codesq');
    }
	
	public function busca_uno($id=0){
			return $this->find_first("codcon='$id'");
		}
	
	public function busc($codniv=0,$codtar=0,$codcon=0){
		$codesq=0;
			if($this->find_first("conditions: codniv='$codniv' and codtar='$codtar' and codcon='$codcon'")){
			  $codesq=$this->codesq;
			}
		return $codesq;
	}
	
	public function paginar($conditions=NULL,$page=1,$perpage=25){
		return $this->paginate("page: $page","per_page: $perpage",$conditions,"order: codniv asc");
	}
}
?>
  
