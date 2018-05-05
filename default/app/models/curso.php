<?php
class Curso extends ActiveRecord
	{
	public function initialize ()
    {
        $this->primary_key=array('codniv','codcur');
    }
	
	public function busca_curso ($codcur=0)
    {
       $this->find_first("conditions: codcur='$codcur'");
	   return $this->descur;

    }

    public function paginar($conditions=NULL,$page=1,$perpage=25){
		return $this->paginate("page: $page","per_page: $perpage",$conditions,"order: codniv asc");
	}
	
	
}
?>
  
