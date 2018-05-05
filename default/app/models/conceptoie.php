<?php
class Conceptoie extends ActiveRecord
	{
	public function initialize ()
    {
        $this->primary_key=array('codingegr');
    }
	
	public function paginar($conditions=NULL,$page=1,$perpage=25){
		return $this->paginate("page: $page","per_page: $perpage",$conditions,"order: codingegr asc");
	}
	
}
?>