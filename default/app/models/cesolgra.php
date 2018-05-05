<?php
class Cesolgra extends ActiveRecord{

	public function initialize (){
        $this->primary_key=array('id','numcar','codcar','acto','fecgra');
		
    }

	public function personal($numcar){
    	$x=$this->find_all_by_sql("SELECT b.numcar,b.descom,b.lugnac,b.ciudad, b.municipio, b.estado, c.correo, b.codsex,b.estciv,b.telef1,b.telef2, a.acto, a.fecgra, 
    		a.conomest as nomest, a.coapeest as apeest, a.estatus, '1' as solgra, a.titsol
  FROM cesolgra a,ceestp b,ceestpt c where a.numcar=b.numcar and a.numcar=c.numcar and a.numcar=b.numcar and a.numcar='$numcar' limit 1");
    	if(!$x){
    		$x=load::model('ceestp')->find_all_by_sql("SELECT a.correo,b.nomest, b.apeest, b.codsex, b.estciv,b.telef1,b.telef2, 'S' as estatus, '0' as solgra
  ,'0' as titsol FROM ceestp b,ceestpt a where a.numcar=b.numcar and b.numcar='$numcar' limit 1");
    	}
    	foreach($x as $c){
    		$y=$c;
    	}
        return $y;
	}


    public function insert($numcar){
        $codact=Input::request("acto"); 
        $fecgra=Input::request("fecgra");
        $nomest=Input::request("nomest");  
        $apeest=Input::request("apeest"); 
        $titsol=Input::request("titulo"); 
        $nomfot="";
        $profes="ESTUDIANTE";
        $fecreg=date('Y-m-d');
        Load::model('cesolexp')->insert($numcar,$titsol,$fecgra);
        return $this->find_all_by_sql("INSERT INTO cesolgra(
            numcar, acto, fecgra, conomest, coapeest, fecreg, titsol, 
            nomuse, nomfot, fecrev, profes, estatus)
    VALUES ('$numcar', '$codact', '$fecgra', '$nomest', '$apeest', '$fecreg','$titsol', '$numcar', 
            '$nomfot', NULL, '$profes','A')");

    }
}
?>
