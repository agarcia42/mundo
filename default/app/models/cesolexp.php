<?php
class Cesolexp extends ActiveRecord{

	public function initialize (){
        $this->primary_key=array('numcar','nroacto','numano');
		
    }

	
    public function insert($numcar,$codcar,$fecgra){
        $fecreg=date('Y-m-d');
        $numano=substr($fecgra,0,4);
        $mes=Conests::mes(substr($fecgra,5,2));
        $fecact=strtoupper($mes)."-".$numano;
        $horreg=date("H:i:s");
        if(!load::model('cesolexp')->find_first("numcar='$numcar' and codcar='$codcar'")){
            return $this->find_all_by_sql("INSERT INTO cesolexp(
            numcar, codcar, nroact, numano, fecact, dessol, status, fecreg, 
            nomuse, fecrev, horreg, posact, fecrdo, horrdo, nomrdo, nrorev)
            VALUES ('$numcar', '$codcar', '1', '$numano', '$fecact', 'ACTO DE GRADO', 'A', '$fecreg', 
            '$numcar', NULL, '$horreg', 0, NULL, NULL, NULL, 0);");
        }else{
            return $this->find_all_by_sql("UPDATE cesolexp SET numano='$numano', fecact='$fecact', dessol='ACTO DE GRADO', status='S', 
            fecreg='$fecreg', nomuse='$numcar', horreg='$horreg', fecrev=null WHERE numcar='$numcar' 
            and codcar='$codcar'");
        }

    }
}
?>
