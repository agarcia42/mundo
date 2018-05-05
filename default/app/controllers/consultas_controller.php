<?php

/*** Controller Noticias: maestro de noticias ***/

class ConsultasController extends AppController
{
	
    public function constancias(){
		View::template(NULL); 
		if(Input::hasPost("coimes")){
			$id = Input::request("idcons");
			if($id!=""){
				$coimes = Load::model('coimes')->find_first("conditions: id='$id'","order: id");	
				if($coimes){
					$vars = array('1' => 'con_ins',
					  '2' => 'con_est',
					  '3' => 'con_not',
					  '4' => 'con_bue',
					  '5' => 'rec_aca',
					  '7' => 'con_pro',
					  '8' => 'con_san',
					  '9' => 'con_ini'
					  );
					$descon=$vars[$coimes->codcon]; 
					if($coimes->status=='A'){
						Redirect::route_to("controller: reportes", "action: ver", "parameters: $descon/$id");
				 	}else{ Redirect::route_to("controller: reportes", "action: ver", "parameters: $descon/$id/1"); }
				}else{ Flash::error("Código de Constancia No Válido.");}
			}else{ Flash::error("Debe introducir el Código de la Constancia."); }
		}
	}
	
	public function nuevoingreso(){
		View::template(NULL); 
		if(Input::hasPost("ceestema")){
			$numcar = Input::request("numcar");
			if($numcar!=""){
				$ceestema = Load::model('ceestema')->find_first("conditions: numced='$numcar' and status='A'");	
				if($ceestema){
					Flash::notice("Cupo asignado bajo el N° de Resolución ".$ceestema->resolucion); 
				}else{ 
					Flash::error("El aspirante no tiene cupo asignado para ningún Programa.");
				}
			}else{ Flash::error("Debe introducir el Número de Cédula del Aspitante."); }
		}
	}
	
	public function carnet(){
		View::template(NULL); 
		$e="";
		if(Input::hasPost("cecarnet")){
			$numcar = Input::request("numcar");
			if($numcar!=""){
				if(Load::model('ceesta')->find_first("conditions: numcar='$numcar'")){	
					$cecarnet = Load::model('cecarnet')->find_first("conditions: numcar='$numcar'");	
					if($cecarnet){
						if($cecarnet->solicitud==1){$e='Solicitado';}
						elseif($cecarnet->solicitud==2){$e='Impreso';}
						elseif($cecarnet->solicitud==3){$e='Entregado';}
						elseif($cecarnet->solicitud==4){$e='Rechazado';}
						Flash::notice("El carnet del estudiante está <b>".$e."</b>."); 
					}else{ 
						Flash::error("El estudiante no ha solicitado Carnet.");
					}
				}else{ Flash::error("El estudiante no está registrado."); }
			}else{ Flash::error("Debe introducir el Número de Cédula del Estudiante."); }
		}
	}
	
	public function inscripciones(){
		View::template(NULL); 
		if(Input::hasPost("ceinse")){
			$numcar = Input::request("numcar");
			if($numcar!=""){
				if(Load::model('ceesta')->find_first("conditions: numcar='$numcar'")){	
					$ceinse = Load::model('ceinse')->find_first("conditions: numcar='$numcar'");	
					if($ceinse){
						Flash::notice("El estudiante está <b>Inscrito</b>."); 
					}else{ 
						Flash::error("El estudiante no está inscrito.");
					}
				}else{ Flash::error("El estudiante no está registrado."); }
			}else{ Flash::error("Debe introducir el Número de Cédula del Estudiante."); }
		}
	}
}