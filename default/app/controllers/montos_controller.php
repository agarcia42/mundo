<?php
class MontosController extends AppController{
	
	protected function before_filter(){
      if(Load::model('usuarios')->logged()==true){
         $this->cedusu = Session::get('cedusu');
      }else{
        return Redirect::route_to("controller: index", "action: logout");
      }
    }
		
		
	
	public function actualizacion($codper="0",$codniv="0",$codtar="0",$codesq="0",$codcon="0",$accion="N",$page=1,$perpage=50){
	View::template(NULL);
	$this->accion=$accion;
	if($accion=="E"){
			if(!load::model('detalle')->find_first("codniv='$codniv' and codtar='$codtar' and codcon='$codcon' and codper='$codper'")){
				load::model('monto')->find_all_by_sql("delete from monto where codniv='$codniv' and codtar='$codtar' and codcon='$codcon' and codper='$codper'");
				Flash::success("Noticia: Registro Eliminado...");
			}else {
				Flash::error('Error: Existe una relación Concepto-Detalle');
			}
		}
	
	if(Input::hasPost("monto")){
			$codper = Input::request("codper");
			$codniv = Input::request("codniv");
			$codtar = Input::request("codtar");
			$codesq = Input::request("codesq");
			$codcon = Input::request("codcon");
			$montos = Input::request("montos");
			$fecreg=date("Y-m-d");
			$horreg=date("H:i:s");
	 		$ususis=trim(strtoupper(Session::get('ceusualogin')));
			$fields="Año=>{$codper},Codigo de Nivel=>{$codniv},Codigo de Tarifa=>{$codtar},Codigo de Esquema=>{$codesq},Codigo de Concepto=>{$codcon},Monto de Pago=>{$montos}";
				$valida = Conests::validate($fields);
				if($valida!="0"){
					flash::error("Error: el campo {$valida} es obligatorio");
				}else{
						if(!load::model('monto')->find_first("codniv='$codniv' and codtar='$codtar' and codesq='$codesq' and codcon='$codcon' and codper='$codper'")){
							load::model('monto')->find_all_by_sql("INSERT INTO monto(codper,codniv, codtar, codesq, codcon, monto, ususis, fecreg, horreg) VALUES ('$codper','$codniv','$codtar', '$codesq', '$codcon', '$montos', '$ususis', '$fecreg', '$horreg')");
							flash::warning("Registro Insertado Correctamente");
						}else{
							load::model('monto')->find_all_by_sql("update monto set  monto='$montos', ususis='$ususis', fecreg='$fecreg', horreg='$horreg' where codper='$codper' and codniv='$codniv' and codtar='$codtar' and codesq='$codesq' and codcon='$codcon'");
							flash::warning("Registro Modificado Correctamente");
						}
				}

	}
	
	$this->paginar($codper,$codniv,$codtar,$codesq,$codcon,$page,$perpage);
	}
	
	
	public function paginar($codper="0",$codniv="0",$codtar="0",$codesq="0",$codcon="0",$page=1,$perpage=50){
		$obser="";
		if($codper!="0"){$obser ="codper='$codper'";}
		if($codniv!="0"){$obser .=" and codniv='$codniv'";}
		if($codtar!="0"){$obser .=" and codtar='$codtar'";}
		if($codesq!="0"){$obser .=" and codesq='$codesq'";}
		$this->page=$page;
		$this->perpage=$perpage;
		$this->obser=$obser;

	
	$busc = load::model('monto')->find_first("codniv='$codniv' and codtar='$codtar' and codesq='$codesq' and codcon='$codcon' and codper='$codper'");
	if ($busc){
		$this->codper=$busc->codper;
		$this->codniv=$busc->codniv;
		$this->codtar=$busc->codtar;
		$this->codesq=$busc->codesq;
		$this->codcon=$busc->codcon;
		$this->montos=$busc->monto;
	}else{
		$this->codper = $codper;
		$this->codniv = $codniv;
		$this->codtar = $codtar;
		$this->codesq = $codesq;
		$this->codcon = $codcon;
		$this->montos = input::request("montos");
	}
	
	}
		 
		
	
	}
	
?>