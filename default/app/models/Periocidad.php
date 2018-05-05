<?php
class Periocidad extends ActiveRecord
	{
	public function initialize ()
    {
        $this->primary_key=array('codcon','codpep');
    }
	
	public function busca_uno($id=0){
			return $this->find_first("codcon='$id'");
		}
}
?>
  
