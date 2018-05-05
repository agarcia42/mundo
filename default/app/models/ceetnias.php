<?php
class Ceetnias extends ActiveRecord
	{
	public function initialize ()
    {
        $this->primary_key=array('id');
    }
	public function todas()
		{return $this->find("order: etnias");}

	public function busca_una($id)
		{return $this->find_first($id);}
	}
?>
