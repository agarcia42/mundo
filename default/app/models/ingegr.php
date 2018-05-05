<?php
class Ingegr extends ActiveRecord
	{
	public function initialize ()
    {
        $this->primary_key=array('numingegr');
    }
		public function Maxingegr(){
			return $this->find_first("order: numingegr desc");
		}
	
	
}
?>