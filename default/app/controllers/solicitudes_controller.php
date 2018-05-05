<?php

/**
 * Controller datapers: maestro de datos personales
 * 
 */
class SolicitudesController extends AppController
{
	protected function before_filter()
	{
	    if(Load::model('ceestpt')->logged()==true){
			$datos = Session::get('su');
			$this->numcar=$datos['numcar'];
			$this->codsed=$datos['codsed'];
			$this->codcar=$datos['codcar']; 
			$this->tiphor=$datos['tiphor']; 
			$this->numano=$datos['numano']; 
			$this->numper=$datos['numper']; 
			$this->possrt=$datos['possrt'];
			$this->codpln=$datos['codpln'];
		}
    }
	

	public function grado(){
 		View::template(NULL);
 		if(!isset($this->numcar)){
				return Redirect::route_to("controller: index", "action: logout");
		}
 		if(Input::hasPost("cesolexp")){
 		$x=Load::model('cesolgra')->insert($this->numcar);
 			$idpais=Input::request("pais"); 
 			if($idpais!='232'){
 				$descom='1';
 				$lugnac=Input::request("lugnac");
 				$idents="0"; 
 				$idcius="0"; 
 				$idmuns="0"; 
 				$idpars="0"; 
 			}else{
 				$idents=Input::request("entidades"); 
 				$idcius=Input::request("ciudades"); 
 				$idmuns=Input::request("municipio"); 
 				$idpars=Input::request("parroquia"); 
 				$descom='0';
 				$lugnac="";
 			}
 			$y=Load::model('ceestp')->modificar($this->numcar,$descom,$lugnac,$idcius,$idmuns,$idents);
			$correo=Input::request("correo"); 
			Load::model('ceestpt')->modificar($this->numcar,$idpais,$idents,$idcius,$idmuns,$idpars);
 		}
     }

    public function gradof($acto='0'){
 		View::template(NULL);
 		if(!isset($this->numcar)){
				return Redirect::route_to("controller: index", "action: logout");
		}
 		$this->fecgra=load::model('cecagr')->acto_activo($this->codcar,$this->codsed,$this->tiphor,$acto);
     }





}