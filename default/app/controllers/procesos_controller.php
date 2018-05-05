<?php

/**
 * Controller datapers: maestro de datos personales
 * 
 */
class ProcesosController extends AppController
{
	public function before_filter(){                                       
		if(Load::model('ceestpt')->logged()==true){
			$datos = Session::get('su');
			$this->numcar=$datos['numcar'];
			$this->codsed=$datos['codsed'];
			$this->codcar=$datos['codcar']; 
			$this->tiphor=$datos['tiphor']; 
			$this->numano=$datos['numano']; 
			$this->numper=$datos['numper']; 
			$this->possrt=$datos['possrt'];
		}
	}


    public function censo($codmat='0',$accion='N'){
		View::template(NULL);
		if(!isset($this->numcar)){
				return Redirect::route_to("controller: index", "action: logout");
		}
		$this->cremax = Load::model('ceesta')->creditos_maximos($this->numcar, $this->codcar);
		if($accion=='E'){
			if(load::model('cecen')->selecciona($this->numcar,$this->codcar,$this->codsed,
												$this->tiphor,$this->numano,$this->numper,$codmat)){	
				if(load::model('cecen')->elimina($this->numcar,$this->codcar,$this->codsed,
												$this->tiphor,$this->numano,$this->numper,$codmat)){
					flash::notice("Proceso Exitoso");
				}
			}
		}
		if(Input::hasPost("cecen")){
			$l = Input::request("l");
				$c = 0;
				$c2= 0;
				for($i=0;$i<$l;$i++){
					$codigo = Input::request("codmat$i");	
					$credit = Input::request("credit$i");	
					$materi = Input::request("materi$i");
				
					if($materi==1){	
						$sum=load::model('cecen')->suma($this->numcar,$this->codcar,$this->codsed,
												$this->tiphor,$this->numano,$this->numper);
						if($sum+$credit<=$this->cremax){
							if(!load::model('cecen')->selecciona($this->numcar,$this->codcar,$this->codsed,
												$this->tiphor,$this->numano,$this->numper,$codigo)){	
								if(load::model('cecen')->inserta($this->numcar,$this->codcar,$this->codsed,
												$this->tiphor,$this->numano,$this->numper,$codigo,$credit)){
									$c++;
								}
							}
						}else{
							$c2++;
						}
					}
				}
				if($c>=1){
					Flash::notice("Proceso exitoso");
				}
				if($c2>=1){
					Flash::error("Error: Exceso de Creditos");
				}
		}
	}
		

	 public function inscripcion($codmat="0",$accion='N'){
	 	View::template(NULL);
	 	if(!isset($this->numcar)){
				return Redirect::route_to("controller: index", "action: logout");
		}
		$this->letoca=Load::model('cepoin')->le_toca($this->codcar,$this->codsed,
												$this->tiphor,$this->possrt,'stains'); 

		if($this->letoca){
			if($accion=='E'){
				load::model('ceinse')->del($this->numcar,$this->codcar,$this->codsed,
												$this->tiphor,$this->numano,$this->numper,$codmat);
				$cetel=load::model('cetela')->seleted($this->codcar,$this->codsed,$this->tiphor,$codmat);
				if($cetel){
					foreach($cetel as $xx){
					load::model('ceinse')->del($this->numcar,$this->codcar,$this->codsed,$this->tiphor,$this->numano,$this->numper,$xx->codequ);
					echo "$this->numcar,$this->codcar,$this->codsed,$this->tiphor,$this->numano,$this->numper,$xx->codequ";
					}
				}
			}
			if(Input::hasPost("cecen")){
				load::model('cemacu')->find_all_by_sql("update cemacu set indins='PS',inderr=0 where codcar='$this->codcar' and numcar='$this->numcar'");
				load::model('ceinse')->find_all_by_sql("SELECT public.validar_materias_cursar_regulares_a('$this->codcar','$this->numcar')");
					//actualizar archivo
					$counter_file=APP_PATH . 'contador/archivo.txt';
						$text="";
						if (file_exists($counter_file)) {
							$file = fopen($counter_file, 'w+');
							foreach($this->Cepoin->find_all_by_sql("select a.codcar,b.descar,a.codsed,c.dessed,a.tiphor,a.posact,(select count(distinct numcar) from ceinse where codcar=a.codcar and codsed=a.codsed and tiphor=a.tiphor) as totins from cepoin a,cecar b,cepsed c where a.codcar=b.codcar and a.codsed=c.codsed and a.stains='1' and a.codsed in('01','02')
") as $ce){
								$text .=$ce->codcar.";".$ce->descar.";".$ce->posact.";".$ce->dessed.";".$ce->tiphor.";".$ce->totins."\n";
							}
							fwrite($file, $text);
							fclose($file);

						}
			}
			load::model('ceinse')->elimina($this->numcar,$this->codcar,$this->codsed,
											$this->tiphor,$this->numano,$this->numper);
		
		}	
	}


	public function labteo($codmat=0,$name=0,$codsec=0){
		View::template(NULL);
		if(!isset($this->numcar)){
				return Redirect::route_to("controller: index", "action: logout");
		}
		$this->datos = $d = Session::get('su');
		$this->name  = $name;
		$this->codmat= $codmat;
		$this->codsec= $codsec;
		load::model('ceinse')->actualiza($d['numcar'],$d['codcar'],$d['codsed'],
										$d['tiphor'],$d['numano'],$d['numper'],
										$codmat,$codsec);

		
	}	 


 	public function solicitud_grado(){
 		View::template(NULL); 
 		if(!isset($this->numcar)){
				return Redirect::route_to("controller: index", "action: logout");
		}
         $this->datos = Load::model('ceestp')->find_first("numcar = ".Session::get('numcar'));
         $numcar = Session::get('numcar');
         $this->carreras = Load::model('ceesta')->find("conditions: numcar = '$numcar' and status ='A'");
     }



 	public function censoex($codmat='0',$numano='0',$numper='0',$accion='N'){
 		View::template(NULL); 
		if(!isset($this->numcar)){
				return Redirect::route_to("controller: index", "action: logout");
		}
		$this->codmat=$codmat;
 		$this->numano=$numano;
 		$this->numper=$numper;
		if($accion=='E'){
			if(load::model('censoie')->selecciona($this->numcar,$this->codcar,$this->codsed,
												$this->tiphor,$this->numano,$this->numper,$codmat)){	
				if(load::model('censoie')->elimina($this->numcar,$this->codcar,$this->codsed,
												$this->tiphor,$this->numano,$this->numper,$codmat)){
					flash::notice("Proceso Exitoso");
				}
			}
		}
		if(Input::hasPost("censoie")){
			$codmat = Input::request("codmat");
			$numano = Input::request("numano");
			$numper = Input::request("numper");
			if($codmat!='0' and $numano!='0' and $numper!='0'){
				if(!load::model('censoie')->selecciona($this->numcar,$this->codcar,$this->codsed,
												$this->tiphor,$numano,$numper,$codmat)){	
					load::model('censoie')->inserta($this->numcar,$this->codcar,$this->codsed,
												$this->tiphor,$numano,$numper,$codmat);
				}
			}else{
				flash::error("Error: los datos son obligatorios");
			}
		}

	}

	public function censove($codmat='0',$accion='N'){
		View::template(NULL);
		if(!isset($this->numcar)){
				return Redirect::route_to("controller: index", "action: logout");
		}
		$this->cremax = Load::model('ceesta')->creditos_maximos($this->numcar, $this->codcar);
		if($accion=='E'){
			if(load::model('cecenve')->selecciona($this->numcar,$this->codcar,$this->codsed,
												$this->tiphor,$this->numano,$this->numper,$codmat)){	
				if(load::model('cecenve')->elimina($this->numcar,$this->codcar,$this->codsed,
												$this->tiphor,$this->numano,$this->numper,$codmat)){
					flash::notice("Proceso Exitoso");
				}
			}
		}
		if(Input::hasPost("cecen")){
			$l = Input::request("l");
				$c = 0;
				$c2= 0;
				for($i=0;$i<$l;$i++){
					$codigo = Input::request("codmat$i");	
					$credit = Input::request("credit$i");	
					$materi = Input::request("materi$i");
				
					if($materi==1){	
						$sum=load::model('cecenve')->suma($this->numcar,$this->codcar,$this->codsed,
												$this->tiphor,$this->numano,$this->numper);
						if($sum+$credit<=$this->cremax){
							if(!load::model('cecenve')->selecciona($this->numcar,$this->codcar,$this->codsed,
												$this->tiphor,$this->numano,$this->numper,$codigo)){	
								if(load::model('cecenve')->inserta($this->numcar,$this->codcar,$this->codsed,
												$this->tiphor,$this->numano,$this->numper,$codigo,$credit)){
									$c++;
								}
							}
						}else{
							$c2++;
						}
					}
				}
				if($c>=1){
					Flash::notice("Proceso exitoso");
				}
				if($c2>=1){
					Flash::error("Error: Exceso de Creditos");
				}
		}
	}
	

	 public function retiro($codmat='0',$accion='N'){
		View::template(NULL);
		if(!isset($this->numcar)){
				return Redirect::route_to("controller: index", "action: logout");
		}
		if($accion=='E'){
			if(load::model('cepret')->selecciona($this->numcar,$this->codcar,$this->codsed,
												$this->tiphor,$this->numano,$this->numper,$codmat)){	
				if(load::model('cepret')->elimina($this->numcar,$this->codcar,$this->codsed,
												$this->tiphor,$this->numano,$this->numper,$codmat)){
					flash::notice("Proceso Exitoso");
				}
			}
		}
		if(Input::hasPost("cecen")){
			$l = Input::request("l");
				$c = 0;
				for($i=0;$i<$l;$i++){
					$codigo = Input::request("codmat$i");	
					$materi = Input::request("materi$i");
					if($materi==1){	
							if(!load::model('cepret')->selecciona($this->numcar,$this->codcar,$this->codsed,
												$this->tiphor,$this->numano,$this->numper,$codigo)){	
								if(load::model('cepret')->inserta($this->numcar,$this->codcar,$this->codsed,
												$this->tiphor,$this->numano,$this->numper,$codigo)){
									$c++;
								}
							}
						
					}
				}
				if($c>=1){
					Flash::notice("Proceso exitoso");
				}
		}unset($_POST["aceptar"]); 
	}

	public function validar(){
		View::template(NULL);
		if(!isset($this->numcar)){
				return Redirect::route_to("controller: index", "action: logout");
		}
		if(Input::hasPost("cecen")){
			$codigo = Input::request("cv");	
			if(is_numeric($codigo)){ 
				if(load::model('cepret')->planilla($this->numcar,$this->codcar,$this->codsed,
										$this->tiphor,$this->numano,$this->numper,$codigo)){	
					
					load::model('ceinse')->retiro($this->numcar,$this->codcar,$this->codsed,
												$this->tiphor,$this->numano,$this->numper,$codigo);
				}else{
					flash::error("Error: Código Incorrecto");
				}
			}else{
				flash::error("Error: Código Incorrecto");
			}
			return Redirect::route_to("controller: procesos", "action: retiro");
		}
		unset($_POST["aceptar"]); 
	}

	
}