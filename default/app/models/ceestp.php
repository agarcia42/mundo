<?php
class Ceestp extends ActiveRecord{
	
	public function initialize (){
        $this->primary_key=array('numcar');
    }

	//Devuelve el registro cuya cedula sea $numcar
	
	public function busca_uno($id){
		return $this->find_first("numcar='$id'");
	}
	public function dato($id,$field){
		echo $field.$id;
		$x=$this->find_first("numcar='$id'");
		return $x->$field;
	}
	
	 public function datos($numcar = ''){
    	$sql = "select  a.numcar, a.tiphor, a.codsed, a.status, a.codpln, a.condac, a.indic1, a.codcar, 
                      a.indic2, a.indic3, a.indic4, a.creaap, a.totpcu, a.peract, a.totrpr, a.possrt,
                      a.condac, b.apeest, b.nomest, b.direc1, b.telef1, b.lugnac, b.fecnac, b.codsex, 
                      c.descar, c.titulo, d.usuario, d.correo,e.deshor,f.dessed,g.indsig,g.numano,g.numper
              from 
                      ceesta as a,ceestp as b,cecar as c,ceestpt as d,ceptur as e,cepsed as f,cepara as g
              where 
                      a.numcar = '$numcar' and 
                      a.numcar = b.numcar and 
                      a.codcar = c.codcar and 
                      a.numcar = d.numcar and
                      a.tiphor = e.tiphor and
                      a.codsed = f.codsed and
					  a.codcar = g.codcar and
					  a.codsed = g.codsed and
					  a.tiphor = g.tiphor
              order by status,codcar limit 1";
			  
      return $this->find_all_by_sql($sql);	
    }

    public function modificar($numcar,$descom,$lugnac,$ciudad,$municipio,$estado){
      	$telef1=Input::request("telefono1"); 
    	$telef2=Input::request("telefono2"); 
    	$estciv=Input::request("estciv"); 
    	$codsex=Input::request("codsex"); 
    	$desciu=Load::model('ciudades')->busca($ciudad);
    	$desmun=Load::model('municipio')->busca($municipio);
    	$desest=Load::model('entidad')->busca($estado);
		 return $this->find_all_by_sql("update ceestp set telef1='$telef1',telef2='$telef2',estciv='$estciv',	
		 codsex='$codsex',descom='$descom',lugnac='$lugnac',ciudad='$desciu',municipio='$desmun',estado='$desest'
		 where numcar='$numcar'");
    }
	
	 public function actualiza($numcar,$codnac,$fecnac,$codsex,$estciv,$direc1,$telef1,$direc2,$telef2){
     	
		return $this->find_all_by_sql("UPDATE ceestp SET fecnac='$fecnac', codsex='$codsex', estciv='$estciv', direc1='$direc1', telef1='$telef1', direc2='$direc2', telef2='$telef2', codnac='$codnac' where numcar='$numcar'");	
    }
	

}
?>
