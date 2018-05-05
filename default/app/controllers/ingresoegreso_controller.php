<?php
class IngresoegresoController extends AppController{
	
	protected function before_filter(){
      if(Load::model('usuarios')->logged()==true){
         $this->cedusu = Session::get('cedusu');
      }else{
        return Redirect::route_to("controller: index", "action: logout");
      }
    }
		
	
		
		
	
	public function actualizacion($codingegr="0",$accion="N",$page=1,$perpage=50){
	View::template(NULL);
	if($accion=="E"){
			if(!load::model('ingegr')->find_first("codingegr='$codingegr'")){
				load::model('conceptoie')->find_all_by_sql("delete from Conceptoie where codingegr='$codingegr'");
				Flash::success("Noticia: Registro Eliminado...");
			}else {
				Flash::error('Error: Existe una relación con Ingresos y Egresos');
			}
		}
	
	if(Input::hasPost("conceptoie")){
			$this->codingegr = Input::request("codingegr");
			$this->desingegr = Input::request("desingegr");
			$this->fecreg=date("Y-m-d");
			$this->horreg=date("H:i:s");
	 		$this->ususis=trim(strtoupper(Session::get('ceusualogin')));
			$fields="Codigo de Concepto=>{$this->codingegr},Descripcion de Concepto=>{$this->desingegr}";
				$valida = Conests::validate($fields);
				if($valida!="0"){
					flash::error("Error: el campo {$valida} es obligatorio");
				}else{
					if(!load::model('conceptoie')->find_first("codingegr='$this->codingegr'")){
						load::model('conceptoie')->find_all_by_sql("INSERT INTO Conceptoie(codingegr, desingegr , ususis, fecreg, horreg) VALUES ('$this->codingegr', '$this->desingegr', '$this->ususis', '$this->fecreg', '$this->horreg')");
						flash::warning("Registro Insertado Correctamente");
					}else{
						load::model('conceptoie')->find_all_by_sql("update Conceptoie set  desingegr='$this->desingegr', ususis='$this->ususis', fecreg='$this->fecreg', horreg='$this->horreg' where codingegr='$this->codingegr'");
						flash::warning("Registro Modificado Correctamente");
					}
				}

	}
	
	$this->paginar($codingegr,$page,$perpage);
	}
	
	
	public function paginar($codingegr="0",$page=1,$perpage=50){
		$this->page=$page;
		$this->perpage=$perpage;
	
	$busc = load::model('conceptoie')->find_first("codingegr='$codingegr'");
	if ($busc){
		$this->codingegr=$busc->codingegr;
		$this->desingegr=$busc->desingegr;
	}else{
		$this->codingegr = Input::request("codingegr");
		$this->desingegr = Input::request("desingegr");
	}
	
	}
		 
		
	
	}
	
?>