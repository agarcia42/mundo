<?php
class Seccion extends ActiveRecord
	{
	public function initialize ()
    {
        $this->primary_key=array('codniv','codcur','codsec','codper');
    }

	public function paginar($conditions=NULL,$page=1,$perpage=25){
		return $this->paginate("page: $page","per_page: $perpage",$conditions,"order: codper,codniv,codcur asc");
	}
	
}
?>
  
