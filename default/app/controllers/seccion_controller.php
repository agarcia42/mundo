<?php
class SeccionController extends AppController{
	
	protected function before_filter(){
      if(Load::model('usuarios')->logged()==true){
         $this->cedusu = Session::get('cedusu');
      }else{
        return Redirect::route_to("controller: index", "action: logout");
      }
    }
		
		
	
	public function actualizacion($codniv="0",$codcur="0",$codper="0",$codsec="0",$accion="N",$page=1,$perpage=50){
	View::template(NULL);

	$this->accion=$accion;
	if($codper=="0"){
		if($periodo=load::model('periodo')->find_first("estado='A'")){
			$codper=$periodo->codper;
		}
	}
	if($accion=="E"){
			if(!load::model('inscripcion')->find_first("codniv='$codniv' and codcur='$codcur' and codsec='$codsec' and codper='$codper'")){
				load::model('inscripcion')->find_all_by_sql("delete from seccion where codniv='$codniv' and codcur='$codcur' and codsec='$codsec' and codper='$codper'");
				Flash::success("Noticia: Registro Eliminado...");
			}else {
					Flash::error('Error: Existe una relación Sección-Inscripción');
			}
		}
	
	if(Input::hasPost("seccion")){
			$codniv = input::request("codniv");
			$codcur = input::request("codcur");
			$codsec = input::request("codsec");
			$codper = input::request("codper");
			$codsal = input::request("codsal");
			$numcup = input::request("numcup");
			$fecreg=date("Y-m-d");
			$horreg=date("H:i:s");
	 		$ususis=trim(strtoupper(Session::get('ceusualogin')));
			$fields="Codigo de Nivel=>{$codniv},Codigo de Curso=>{$codcur},Codigo de Sección=>{$codsec},Codigo de Período=>{$codper},Codigo de Salón=>{$codsal},Capacidad=>{$numcup}";
				$valida = Conests::validate($fields);
				if($valida!="0"){
					flash::error("Error: el campo {$valida} es obligatorio");
				}else{
					if(!load::model('seccion')->find_first("codniv='$codniv' and codcur='$codcur' and codsec='$codsec' and codper='$codper'")){
						load::model('seccion')->find_all_by_sql("INSERT INTO Seccion(codniv, codcur, codsec, codper, codsal, numcup, ususis, fecreg, horreg) VALUES ('$codniv','$codcur', '$codsec', '$codper', '$codsal', '$numcup', '$ususis', '$fecreg', '$horreg')");
						flash::warning("Registro Insertado Correctamente");
					}else{
						load::model('seccion')->find_all_by_sql("update Seccion set  codsal='$codsal',numcup='$numcup', ususis='$ususis', fecreg='$fecreg', horreg='$horreg' where codniv='$codniv' and codcur='$codcur' and codsec='$codsec' and codper='$codper'");
						flash::warning("Registro Modificado Correctamente");
					}
				}

	}
	
	$this->paginar($codniv,$codcur,$codsec,$codper,$page,$perpage);
	}
	
	
	public function paginar($codniv="0",$codcur="0",$codsec="0",$codper="0",$page=1,$perpage=50){
		$obser="";
		if($codniv!="0"){$obser ="codniv='$codniv'";}
		if($codcur!="0"){$obser .=" and codcur='$codcur'";}
		if($codniv!="0" and $codper!="0"){$obser .=" and codper='$codper'";}
		$this->page=$page;
		$this->perpage=$perpage;
		$this->obser=$obser;
	
		
	$busc = load::model('seccion')->find_first("codniv='$codniv' and codcur='$codcur' and codsec='$codsec' and codper='$codper'");
	if ($busc){
		$this->codniv=$busc->codniv;
		$this->codcur=$busc->codcur;
		$this->codsec=$busc->codsec;
		$this->codper=$busc->codper;
		$this->codsal=$busc->codsal;
		$this->numcup=$busc->numcup;
	}else{
		$this->codniv = $codniv;
		$this->codcur = $codcur;
		$this->codsec = $codsec;
		$this->codper = $codper;
		$this->codsal = Input::request("codsal");
		$this->numcup = Input::request("numcup");
	}
	
	}
		 
		
	
	}
	
?>