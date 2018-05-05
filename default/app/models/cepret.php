<?php
class Cepret extends ActiveRecord 
	{
	public function initialize ()
    {
        $this->primary_key=array('numcar', 'codcar', 'codmat', 'numper', 'numano', 'codsed', 'tiphor');
		
    }

    public function codpln($numcar,$codcar,$codsed,$tiphor,$numano,$numper){
		$cepret=$this->find_first("conditions: numcar='$numcar' and codcar='$codcar' and codsed='$codsed' and tiphor='$tiphor'  and numano='$numano' and numper='$numper' and status='A' ");
		if($cepret){
			$codpln=$cepret->codpln;
		}else{
			$codpln = (($this->maximum('codpln'))+1);
			self::enviarmail($numcar,$codpln);
		}
		return $codpln;

	}
	
	public function planilla($numcar,$codcar,$codsed,$tiphor,$numano,$numper,$codpln){
		return $this->find_first("conditions: numcar='$numcar' and codcar='$codcar' and codsed='$codsed' and tiphor='$tiphor' and numano='$numano' and numper='$numper' and codpln='$codpln' and status='A'");
	}

	public function pr_retiro($numcar,$codcar,$codsed,$tiphor,$numano,$numper){
		return $this->find("conditions: numcar='$numcar' and codcar='$codcar' and codsed='$codsed' and tiphor='$tiphor' and numano='$numano' and numper='$numper' and status='A'");
	}

	public function selecciona($numcar,$codcar,$codsed,$tiphor,$numano,$numper,$codmat){
		$cepret=$this->find_first("conditions: numcar='$numcar' and codcar='$codcar' and codsed='$codsed' and tiphor='$tiphor' and numano='$numano' and numper='$numper' and codmat='$codmat'");
		return ($cepret) ? true : false;
	}

	public function inserta($numcar,$codcar,$codsed,$tiphor,$numano,$numper,$codmat){
		$fecreg=date('Y-m-d');
		$codpln=self::codpln($numcar,$codcar,$codsed,$tiphor,$numano,$numper);
		$cepret=$this->find_all_by_sql("INSERT INTO cepret(numcar,codcar,codmat,status,codpln,numper,numano,codsed,tiphor,fecreg,nomuse) VALUES ('$numcar','$codcar','$codmat','A',$codpln,'$numper','$numano','$codsed','$tiphor','$fecreg','$numcar')");
		return ($cepret) ? true : false;
	}

	public function elimina($numcar,$codcar,$codsed,$tiphor,$numano,$numper,$codmat){
		$fecreg=date('Y-m-d');
		$cepret=$this->find_all_by_sql("delete from cepret where numcar='$numcar' and codcar='$codcar' and codsed='$codsed' and tiphor='$tiphor' and numano='$numano' and numper='$numper' and codmat='$codmat'");
		return ($cepret) ? true : false;
	}

	public function suma($numcar,$codcar,$codsed,$tiphor,$numano,$numper){
		$sql = ("select sum(numcre) as creditos from cepret where numcar='$numcar' and codcar='$codcar' and codsed='$codsed' and tiphor='$tiphor' and numano='$numano' and numper='$numper'");
	    $a = $this->find_all_by_sql($sql);
    	foreach ($a as $k)
         {return $k->creditos;}  
	}

	public function cuenta($numcar,$codcar,$codsed,$tiphor,$numano,$numper){
		$sql = ("select count(codmat) as creditos from cepret where numcar='$numcar' and codcar='$codcar' and codsed='$codsed' and tiphor='$tiphor' and numano='$numano' and numper='$numper' group by numcar");
	    $a = $this->find_all_by_sql($sql);
    	foreach ($a as $k)
         {return $k->creditos;}  
	}

	public function enviarmail($numcar,$codpln=""){
		$x=load::model('ceestpt')->busca_uno($numcar);
			$nombre=NULL;
			if($x){
				$email= $x->correo;
				$y=load::model('ceestp')->busca_uno($numcar);
				if($y){
					$nombre = $y->nomest." ".$y->apeest;
				}
				$title="Retiro de Unudades Curriculares estudiantes(UNEFM)";
				$body="<b>Para procesar retiro de la(s) Unidade(s)
			  	Curriculare(s), <br><br>Codigo de Validación.: <b>".$codpln."</b> <br><br>(Debes Introducir el codigo para
			  	realizar el proceso formal de retiro)";
				Conests::email($email,$title,$body,$nombre);
		}

	}
}

	
?>
