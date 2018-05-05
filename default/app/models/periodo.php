<?php
class Periodo extends ActiveRecord
	{
	public function initialize ()
    {
        $this->primary_key=array('codper');
    }
	
	public function busca_uno($codper=0){
			 $this->find_first("order: codper desc,estado asc");
			 return $this->codper;
		}
		
		public function busca_per($codper=0)
    {
       $this->find_first("conditions: codper='$codper'");
	   return $this->desper;

    }

    public function paginar($conditions=NULL,$page=1,$perpage=25){
		return $this->paginate("page: $page","per_page: $perpage",$conditions,"order: codper asc");
	}
}
?>
  
