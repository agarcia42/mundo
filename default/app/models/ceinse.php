<?php
class Ceinse extends ActiveRecord 
	{
	public function initialize ()
    {
        $this->primary_key=array('id');
		
    }
	
	public function selecciona($numcar,$codcar,$codsed,$tiphor,$numano,$numper,$codmat){
		$ceinse=$this->find_first("conditions: numcar='$numcar' and codcar='$codcar' and codsed='$codsed' and tiphor='$tiphor' and numano='$numano' and numper='$numper' and codmat='$codmat'");
		return ($ceinse) ? true : false;
	}


	public function todos_te($numcar,$codcar,$codsed,$tiphor,$numano,$numper){
		return $this->find("conditions: numcar = '$numcar' and codcar='$codcar' and codsed='$codsed' and tiphor='$tiphor' and numano='$numano' and numper='$numper' and indins like 'I%'");
	}


	public function actualiza($numcar,$codcar,$codsed,$tiphor,$numano,$numper,$codmat,$codsec){
		if($codsec != '0'){
			$sql = $this->find_first("conditions: numcar='$numcar' and codcar='$codcar' and codsed='$codsed' and tiphor='$tiphor' and codmat='$codmat' and numano='$numano' and numper='$numper'");
			if($sql){
				return $this->find_all_by_sql("update ceinse set codsec='$codsec' where numcar='$numcar' and codcar='$codcar' and codsed='$codsed' and tiphor='$tiphor' and codmat='$codmat' and numano='$numano' and numper='$numper'");
			}else{
				return $this->find_all_by_sql("insert into ceinse SELECT numcar, codcar, codsed, codmat, '$codsec', NULL, indsig, numano, 
      											numper, tiphor, 'PS', numpla, NULL, current_date, '$numcar'
  												FROM cemacu where numcar='$numcar' and codcar='$codcar' and codsed='$codsed' and tiphor='$tiphor' and codmat='$codmat' and numano='$numano' and numper='$numper'");
			}
		}else{
			return $this->delete("numcar='$numcar' and codcar='$codcar' and codsed='$codsed' and tiphor='$tiphor' and codmat='$codmat' and numano='$numano' and numper='$numper'");
		}
	}


	public function elimina($numcar,$codcar,$codsed,$tiphor,$numano,$numper){
		return $this->delete("numcar='$numcar' and codcar='$codcar' and codsed='$codsed' and tiphor='$tiphor' and numano='$numano' and numper='$numper' and indins not like 'I%'");
	}

	public function del($numcar,$codcar,$codsed,$tiphor,$numano,$numper,$codmat){
		return $this->delete("numcar='$numcar' and codcar='$codcar' and codsed='$codsed' and tiphor='$tiphor' and numano='$numano' and numper='$numper' and codmat='$codmat'");
	}


}

	
?>
