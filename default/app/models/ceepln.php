<?php
class Ceepln extends ActiveRecord
	{
	public function initialize ()
    {
        $this->primary_key=array('codpln','codcar','codmat');
    }
    public function selecciona($codcar,$codpln,$codmat){
    	return $this->find_first("codcar='$codcar' and codpln='$codpln' and conmat in('D','O') and codmat='$codmat' and codmat not like '%L%'");
    }
    
	}
?>