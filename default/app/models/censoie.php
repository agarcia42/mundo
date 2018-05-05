<?php
class Censoie extends ActiveRecord 
	{
	public function initialize ()
    {
        $this->primary_key=array('numcar', 'codcar', 'codsed', 'tiphor', 'codmat', 'numano', 'numper');
		
    }
	
	public function selecciona($numcar,$codcar,$codsed,$tiphor,$numano,$numper,$codmat){
		$censoie=$this->find_first("conditions: numcar='$numcar' and codcar='$codcar' and codsed='$codsed' and tiphor='$tiphor' and numano='$numano' and numper='$numper' and codmat='$codmat'");
		return ($censoie) ? true : false;
	}

	public function inserta($numcar,$codcar,$codsed,$tiphor,$numano,$numper,$codmat){
		$fecreg=date('Y-m-d');
		$censoie=$this->find_all_by_sql("INSERT INTO censoie(numcar, codcar, codmat, codsed, tiphor, numper, numano, fecreg, nomuse) VALUES ('$numcar','$codcar','$codmat','$codsed','$tiphor','$numper','$numano','$fecreg','$numcar')");
		return ($censoie) ? true : false;
	}

	public function elimina($numcar,$codcar,$codsed,$tiphor,$numano,$numper,$codmat){
		$fecreg=date('Y-m-d');
		$censoie=$this->find_all_by_sql("delete from censoie where numcar='$numcar' and codcar='$codcar' and codsed='$codsed' and tiphor='$tiphor' and numano='$numano' and numper='$numper' and codmat='$codmat'");
		return ($censoie) ? true : false;
	}

	public function todos($numcar,$codcar){
		return $this->find("conditions: numcar='$numcar' and codcar='$codcar' and codmat!='0'");
	}
	
}

	
?>
