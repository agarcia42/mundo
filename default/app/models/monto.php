<?php
class Monto extends ActiveRecord
	{
	public function initialize ()
    {
        $this->primary_key=array('codper', 'codcon', 'codniv', 'codtar', 'codesq');
    }
	
	public function paginar($conditions=NULL,$page=1,$perpage=25){
		return $this->paginate("page: $page","per_page: $perpage",$conditions,"order: codper,codniv,codtar,codesq asc");
	}
}
?>
  
