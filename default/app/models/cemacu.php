<?php
class Cemacu extends ActiveRecord{
	
	
	public function initialize (){
        $this->primary_key=array('numcar','codcar','codsed','tiphor','indsig','numano','numper','codmat');
    }
		
	public function uno($numcar,$codcar,$codsed,$tiphor,$numano,$numper){
		$cem=$this->find_first("conditions: numcar = '$numcar' and codcar='$codcar' and codsed='$codsed' and tiphor='$tiphor' and numano='$numano' and numper='$numper'");
		return ($cem) ? true : false;
	}
	
	public function todos($numcar,$codcar,$codsed,$tiphor,$numano,$numper){
		return $this->find("conditions: numcar = '$numcar' and codcar='$codcar' and codsed='$codsed' and tiphor='$tiphor' and numano='$numano' and numper='$numper'");
	}

	public function todos_te($numcar,$codcar,$codsed,$tiphor,$numano,$numper){
		return $this->find("conditions: numcar = '$numcar' and codcar='$codcar' 
									and codsed='$codsed' and tiphor='$tiphor' 
									and numano='$numano' and numper='$numper' 
									and codmat not like '%L%' and codmat not in(select distinct codmat from ceinse where numcar = '$numcar' and codcar='$codcar' 
									and codsed='$codsed' and tiphor='$tiphor' 
									and numano='$numano' and numper='$numper'
									and indins like 'I%')");
	}

	public function todos_lab($numcar,$codcar,$codsed,$tiphor,$numano,$numper,$codmat){
		$codmat=substr($codmat, 2,strlen($codmat))."L";
		return $this->find_first("conditions: numcar = '$numcar' and codcar='$codcar' and codsed='$codsed' and tiphor='$tiphor' and numano='$numano' and numper='$numper' and codmat='$codmat'");
	}
}
?>
