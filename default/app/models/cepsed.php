<?php
class Cepsed extends ActiveRecord 
{
	
	public function initialize ()
    {
        $this->primary_key=array('codsed');
    }
	
	public function busca_uno($id=0){
		return $this->find_first("conditions: codsed='$id'");
	}
	
	/*Buscar descripción de la sede*/
	public function bus_dessed($codsed){
		$cepsed=$this->find_first("conditions: codsed='$codsed'");
		return $cepsed->dessed;
	}		
	
	//Método para insertar rgistros
	public function ins($codsed, $dessed, $codpai, $codedo, $codciu, $dirsed, $telfsd, $fecreg, $nomuse, $codpar, $codmun, $tipsed)
		{
		$db = DbBase::raw_connect();
		$sql = "insert into cepsed (codsed, dessed, codpai, codedo, codciu, dirsed, telfsd, fecreg, nomuse, codpar, codmun, id_tipsed) values ('$codsed', '$dessed', '$codpai', '$codedo', '$codciu', '$dirsed', '$telfsd', '$fecreg', '$nomuse', '$codpar', '$codmun', '$tipsed')";
					
		if($db->query($sql)){return true;}
		else{return false;}
	}
}	
?>
