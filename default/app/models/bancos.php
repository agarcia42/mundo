<?php
class Bancos extends ActiveRecord
	{
	public function initialize ()
    {
        $this->primary_key=array('id');
    }
	
	public function paginar($conditions=NULL,$page=1,$perpage=25){
		return $this->paginate("page: $page","per_page: $perpage",$conditions,"order: id asc");
	}
	
}
?>
  
