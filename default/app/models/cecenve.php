<?php
class Cecenve extends ActiveRecord 
	{
	public function initialize ()
    {
        $this->primary_key=array('id');
		
    }
	
	public function selecciona($numcar,$codcar,$codsed,$tiphor,$numano,$numper,$codmat){
		$cecen=$this->find_first("conditions: numcar='$numcar' and codcar='$codcar' and codsed='$codsed' and tiphor='$tiphor' and numano='$numano' and numper='$numper' and codmat='$codmat'");
		return ($cecen) ? true : false;
	}

	public function inserta($numcar,$codcar,$codsed,$tiphor,$numano,$numper,$codmat,$numcre){
		$fecreg=date('Y-m-d');
		$cecen=$this->find_all_by_sql("INSERT INTO cecenve(numcar, codcar, codmat, codsed, tiphor, numper, numano, fecreg, nomuse,numcre) VALUES ('$numcar','$codcar','$codmat','$codsed','$tiphor','$numper','$numano','$fecreg','$numcar','$numcre')");
		return ($cecen) ? true : false;
	}

	public function elimina($numcar,$codcar,$codsed,$tiphor,$numano,$numper,$codmat){
		$fecreg=date('Y-m-d');
		$cecen=$this->find_all_by_sql("delete from cecenve where numcar='$numcar' and codcar='$codcar' and codsed='$codsed' and tiphor='$tiphor' and numano='$numano' and numper='$numper' and codmat='$codmat'");
		return ($cecen) ? true : false;
	}

	public function suma($numcar,$codcar,$codsed,$tiphor,$numano,$numper){
		$sql = ("select sum(numcre) as creditos from cecenve where numcar='$numcar' and codcar='$codcar' and codsed='$codsed' and tiphor='$tiphor' and numano='$numano' and numper='$numper'");
	    $a = $this->find_all_by_sql($sql);
    	foreach ($a as $k)
         {return $k->creditos;}  
	}
	public function cuenta($numcar,$codcar,$codsed,$tiphor,$numano,$numper){
		$sql = ("select count(codmat) as creditos from cecenve where numcar='$numcar' and codcar='$codcar' and codsed='$codsed' and tiphor='$tiphor' and numano='$numano' and numper='$numper' group by numcar");
	    $a = $this->find_all_by_sql($sql);
    	foreach ($a as $k)
         {return $k->creditos;}  
	}

}

	
?>
