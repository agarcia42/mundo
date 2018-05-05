<?php
class Cepoin extends ActiveRecord {
	
	public function initialize (){
        $this->primary_key=array('codcar','codsed','tiphor');
		
    }
	

	public function proceso($codcar,$codsed,$tiphor){
		return $this->find_first("conditions: codcar='$codcar' and codsed='$codsed' and tiphor='$tiphor'");
	}

	public function aperturado($codcar,$codsed,$tiphor,$status='stacen'){
		$cepo=self::proceso($codcar,$codsed,$tiphor);
		if ($cepo){
			return ($cepo->posact!='0' and $cepo->$status!='0') ? true : false;
		}else{
			return false;
		}
			
	}
	
	public function le_toca($codcar,$codsed,$tiphor,$possrt=0,$status){
		$cepo=self::proceso($codcar,$codsed,$tiphor);
		if ($cepo){
			return ($possrt <= $cepo->posact and $cepo->$status!='0') ? true : false;
		}else{
			return false;
		}
			
	}

	public function posicion($codcar,$codsed,$tiphor,$posact=0){
		$cepo=self::proceso($codcar,$codsed,$tiphor);
		if ($cepo){
			return $cepo->posact;
		}else{
			return $posact;
		}
			
	}

	public function rt_fecha($codcar,$codsed,$tiphor){
		$fecha=date('Y-m-d');
		$cepo=self::proceso($codcar,$codsed,$tiphor);
		if ($cepo){
			return ($cepo->fecret<=$fecha) ? true : false;
		}else{
			return false;
		}
			
	}

}
	
?>
