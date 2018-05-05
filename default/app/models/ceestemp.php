<?php
class Ceestemp extends ActiveRecord{
	
	public function initialize (){
        $this->primary_key=array('id');
    }
	
	//Devuelve el total de registros para generar el número de la planilla
	public function nroregistros(){
		return $this->count("control>=1");
	}
	
	public function actualiza($numced,$planilla,$correcto,$conomest,$coapeest,$codnac,$idnac,$etnia,$fecnac,$codsex,$estciv,$pais,$entidad,$ciudad,$municipio,$parroquia,$lugnac,$fecha,$codpos,$direc1,$telef1,$direc2,$telef2,$plantel,$anogra,$promed,$correo)
	{
		if($pais==232){
            $ciudad=substr($ciudad,strlen($entidad)+1,strlen($ciudad));
            $municipio=substr($municipio,strlen($entidad)+1,strlen($municipio));
         }
		 
		return $this->find_all_by_sql("UPDATE ceestemp SET planilla='$planilla', codetn='$etnia', fecnac='$fecnac', codsex='$codsex', estciv='$estciv', codpai='$pais', codent='$entidad', codciu='$ciudad', codmun='$municipio', codpar='$parroquia', correcto='$correcto', lugnac='$lugnac', conomest='$conomest', coapeest='$coapeest', fecha='$fecha', codpos='$codpos', direc1='$direc1', telef1='$telef1', direc2='$direc2', telef2='$telef2', liceos='$plantel', anogra='$anogra', prombc='$promed', codnac='$codnac', id_nacionalidad=$idnac, correo='$correo',control='2' where numced=$numced and status='A'");	
	}
	
	public function actualizaControl($numcar,$control){
         return $this->find_all_by_sql("update ceestemp set control=$control where numced='$numcar'");
    }
}
?>
