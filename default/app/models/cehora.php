<?php
class Cehora extends ActiveRecord
	{
	public function initialize ()
    	{$this->primary_key=array('codcar','codsed', 'tiphor');}


    public function hora($codcar,$codsed,$tiphor,$codhor,$field='horini'){
            $y=0;
            $hora=$this->find_first("conditions: codcar='$codcar' and codsed='$codsed' and tiphor='$tiphor' and codhor='$codhor'");
            if($hora){
            	$y=$hora->$field;
            }
            return $y;
        }

	}

?>
