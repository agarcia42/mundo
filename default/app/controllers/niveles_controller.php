<?php
class NivelesController extends AppController{
	
	protected function before_filter(){
      if(Load::model('usuarios')->logged()==true){
         $this->cedusu = Session::get('cedusu');
      }else{
        return Redirect::route_to("controller: index", "action: logout");
      }
    }
		
		
	
	public function actualizacion($codniv="0",$accion="N",$page=1,$perpage=50){
	View::template(NULL);
	if($accion=="E"){
			if(!load::model('inscripcion')->find_first("codniv='$codniv'")){
				load::model('nivel')->find_all_by_sql("delete from nivel where codniv='$codniv'"); 
				Flash::success("Noticia: Registro Eliminado...");
			}else {
				Flash::error('Error: Existe una relación Nivel-Alumno inscrito');
			}
		}
	
	if(Input::hasPost("nivel")){
			$this->codniv = input::request("codniv");
			$this->desniv = input::request("desniv");
			$this->fecreg=date("Y-m-d");
			$this->horreg=date("H:i:s");
	 		$this->ususis=trim(strtoupper(Session::get('ceusualogin')));
			$fields="Codigo de Nivel=>{$this->codniv},Descripción de nivel=>{$this->desniv}";
				$valida = Conests::validate($fields);
				if($valida!="0"){
					flash::error("Error: el campo {$valida} es obligatorio");
				}else{
					if(!load::model('nivel')->find_first("codniv='$this->codniv'")){
						load::model('nivel')->find_all_by_sql("INSERT INTO nivel(codniv, desniv , ususis, fecreg, horreg) VALUES ('$this->codniv', '$this->desniv', '$this->ususis', '$this->fecreg', '$this->horreg')");
						flash::warning("Registro Insertado Correctamente");
					}else{
						load::model('nivel')->find_all_by_sql("update NIVEL set  desniv='$this->desniv', ususis='$this->ususis', fecreg='$this->fecreg', horreg='$this->horreg' where codniv='$this->codniv'");
						flash::warning("Registro Modificado Correctamente");
					}
				}

	}
	
	$this->paginar($codniv,$page,$perpage);
	}
	
	
	public function paginar($codniv="0",$page=1,$perpage=50){
		$this->page=$page;
		$this->perpage=$perpage;
	/*$buscar =load::model('nivel')->find("order: codniv");
	if ($buscar){
			$_REQUEST['tabla'] = $buscar;
			$_REQUEST['page']   = 1;
			$this->encontro=1;
		}else{
			Flash::error("No Existen Resultados");
			$this->encontro=0;
		}*/
		
	$busc = load::model('nivel')->find_first("codniv='$codniv'");
	if ($busc){
		$this->codniv=$busc->codniv;
		$this->desniv=$busc->desniv;
	}else{
		$this->codniv = input::request("codniv");
		$this->desniv = input::request("desniv");
	}
	
	}
		 
		
	
	}
	
?>