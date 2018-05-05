<?php
class Ceactn extends ActiveRecord 
	{
	public function initialize ()
    {
        $this->primary_key=array('numcar', 'codcar', 'codsed', 'tiphor', 'codmat', 'numano', 'numper');
		
    }
    public function nota($numcar,$codcar,$codsed,$tiphor,$numano,$numper,$codmat){
		$ceactn=$this->find_first("conditions: numcar='$numcar' and codcar='$codcar' and codsed='$codsed' and tiphor='$tiphor' and numano='$numano' and numper='$numper' and codmat='$codmat'");
		$notas= ($ceactn) ? $ceactn->notper : '-';
		return $notas;
	}
 }