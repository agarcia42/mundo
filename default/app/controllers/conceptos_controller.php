<?php
class ConceptosController extends AppController{
	
	protected function before_filter(){
      if(Load::model('usuarios')->logged()==true){
         $this->cedusu = Session::get('cedusu');
      }else{
        return Redirect::route_to("controller: index", "action: logout");
      }
    }
		
	
		
		
	
	public function actualizacion($codniv="0",$codtar="0",$codesq="0",$codcon="0",$accion="N",$page=1,$perpage=50){
	View::template(NULL);
	$this->accion=$accion;
	if($accion=="E"){
			if(!load::model('detalle')->find_first("codniv='$codniv' and codtar='$codtar' and codcon='$codcon'")){
				load::model('concepto')->find_all_by_sql("delete from concepto where codniv='$codniv' and codtar='$codtar' and codcon='$codcon'");
				Flash::success("Noticia: Registro Eliminado...");
			}else {
				Flash::error('Error: Existe una relación Concepto-Detalle');
			}
		}
	
	if(Input::hasPost("concepto")){
			$codniv = Input::request("codniv");
			$codtar = Input::request("codtar");
			$codesq = Input::request("codesq");
			$codcon = Input::request("codcon");
			$descon = Input::request("descon");
			$fecreg=date("Y-m-d");
			$horreg=date("H:i:s");
	 		$ususis=trim(strtoupper(Session::get('ceusualogin')));
			$fields="Codigo de Nivel=>{$codniv},Codigo de Tarifa=>{$codtar},Codigo de Esquema=>{$codesq},Codigo de Concepto=>{$codcon},Descripción de Concepto=>{$descon}";
				$valida = Conests::validate($fields);
				if($valida!="0"){
					flash::error("Error: el campo {$valida} es obligatorio");
				}else{
						if(!load::model('concepto')->find_first("codniv='$codniv' and codtar='$codtar' and codesq='$codesq' and codcon='$codcon'")){
							load::model('concepto')->find_all_by_sql("INSERT INTO Concepto(codniv, codtar, percon, codesq, codcon, descon, ususis, fecreg, horreg) VALUES ('$codniv','$codtar', '1', '$codesq', '$codcon', '$descon', '$ususis', '$fecreg', '$horreg')");
							flash::warning("Registro Insertado Correctamente");
						}else{
							load::model('concepto')->find_all_by_sql("update Concepto set  descon='$descon', ususis='$ususis', fecreg='$fecreg', horreg='$horreg' where codniv='$codniv' and codtar='$codtar' and codesq='$codesq' and codcon='$codcon'");
							flash::warning("Registro Modificado Correctamente");
						}
				}

	}
	
	$this->paginar($codniv,$codtar,$codesq,$codcon,$page,$perpage);
	}
	
	
	public function paginar($codniv="0",$codtar="0",$codesq="0",$codcon="0",$page=1,$perpage=50){
		$obser="";
		if($codniv!="0"){$obser ="codniv='$codniv'";}
		if($codtar!="0"){$obser .=" and codtar='$codtar'";}
		if($codesq!="0"){$obser .=" and codesq='$codesq'";}
		$this->obser=$obser;
		$this->page=$page;
		$this->perpage=$perpage;
		
		
	$busc = load::model('concepto')->find_first("codniv='$codniv' and codtar='$codtar' and codesq='$codesq' and codcon='$codcon'");
	if ($busc){
		$this->codniv=$busc->codniv;
		$this->codtar=$busc->codtar;
		$this->codesq=$busc->codesq;
		$this->codcon=$busc->codcon;
		$this->descon=$busc->descon;
	}else{
		$this->codniv = $codniv;
		$this->codtar = $codtar;
		$this->codesq = $codesq;
		$this->codcon = Input::request("codcon");
		$this->descon = Input::request("descon");
	}
	
	}
		 
		
	
	}
	
?>