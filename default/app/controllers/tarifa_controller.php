<?php
class TarifaController extends AppController{
	
	protected function before_filter(){
      if(Load::model('usuarios')->logged()==true){
         $this->cedusu = Session::get('cedusu');
      }else{
        return Redirect::route_to("controller: index", "action: logout");
      }
    }
		
		
		
	
	public function actualizacion($codniv="0",$codtar="0",$accion="N",$page=1,$perpage=50){
	View::template(NULL);
	if($accion=="E"){
			if(!load::model('inscripcion')->find_first("codniv='$codniv' and codcur='$codtar'") and !load::model('concepto')->find_first("codniv='$codniv' and codtar='$codtar'")){
				load::model('tarifa')->find_all_by_sql("delete from tarifa where codniv='$codniv' and codtar='$codtar'"); 
				Flash::success("Noticia: Registro Eliminado...");
			}else {
				Flash::error('Error: Existe una relación Tarifa-Inscripción');
			}
		}
	
	if(Input::hasPost("tarifa")){
			$codniv = input::request("codniv");
			$codtar = input::request("codtar");
			$destar = input::request("destar");
			$fecreg=date("Y-m-d");
			$horreg=date("H:i:s");
	 		$ususis=trim(strtoupper(Session::get('ceusualogin')));
			$fields="Codigo de Nivel=>{$codniv},Codigo de Tarifa=>{$codtar},Descripción de Tarifa=>{$destar}";
				$valida = Conests::validate($fields);
				if($valida!="0"){
					flash::error("Error: el campo {$valida} es obligatorio");
				}else{
					if(!load::model('tarifa')->find_first("codniv='$codniv' and codtar='$codtar'")){
						load::model('tarifa')->find_all_by_sql("INSERT INTO tarifa(codniv, codtar, destar , ususis, fecreg, horreg) VALUES ('$codniv','$codtar', '$destar', '$ususis', '$fecreg', '$horreg')");
						flash::warning("Registro Insertado Correctamente");
					}else{
						load::model('tarifa')->find_all_by_sql("update tarifa set  destar='$destar', ususis='$ususis', fecreg='$fecreg', horreg='$horreg' where codniv='$codniv' and codtar='$codtar'");
						flash::warning("Registro Modificado Correctamente");
					}
				}

	}
	
	$this->paginar($codniv,$codtar,$page,$perpage);
	}
	
	
	public function paginar($codniv="0",$codtar="0",$page=1,$perpage=50){
	$this->page=$page;
	$this->perpage=$perpage;
			
	$busc = load::model('tarifa')->find_first("codniv='$codniv' and codtar='$codtar'");
		if ($busc){
			$this->codniv=$busc->codniv;
			$this->codtar=$busc->codtar;
			$this->destar=$busc->destar;
		}else{
			$this->codniv = $codniv;
			$this->codtar = input::request("codtar");
			$this->destar = input::request("destar");
		}
	
	}
		 
		
	
	}
	
?>