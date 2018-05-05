<?php
class ExportarController extends AppController{
	
	protected function before_filter(){
      if(Load::model('usuarios')->logged()==true){
         $this->cedusu = Session::get('cedusu');
      }else{
        return Redirect::route_to("controller: index", "action: logout");
      }
    }
		
		
	
	public function seccion($codper="0",$ano="0"){
		View::template(NULL);
		$this->codper=$codper;
		$this->ano=$ano;
			
		if(Input::hasPost("seccion")){
			$this->codper = Input::request("codper");
			$this->ano = Input::request("ano");
			if($this->codper=="0"){
				Flash::error("Error: debe seleccionar el año de inicio");
			}elseif($this->ano=="0"){
				Flash::error("Error: debe seleccionar el año de fin");
			}else{
			
					if(!load::model('seccion')->find_first("codper='$this->ano'") and load::model('seccion')->find_first("codper='$this->codper'")){
							load::model('seccion')->find_all_by_sql("INSERT INTO seccion SELECT codsec, codcur, '$this->ano', numcup, codsal, codniv, ususis, fecreg, horreg FROM seccion WHERE codper='$this->codper'");
							flash::warning("Notice: Proceso realizado exitosamente");
					}else{
						flash::error("Error: existen secciones en ese periodo académico");
					}
							
			}
			
		}
	}
	

	public function tarifa($codper="0",$ano="0"){
		View::template(NULL);
		$this->codper=$codper;
		$this->ano=$ano;
			
		if(Input::hasPost("tarifa")){
			$this->codper = Input::request("codper");
			$this->ano = Input::request("ano");
			if($this->codper=="0"){
				Flash::error("Error: debe seleccionar el año de inicio");
			}elseif($this->ano=="0"){
				Flash::error("Error: debe seleccionar el año de fin");
			}else{
			
					if(!load::model('monto')->find_first("codper='$this->ano'") and load::model('monto')->find_first("codper='$this->codper'")){
							load::model('monto')->find_all_by_sql("INSERT INTO monto SELECT '$this->ano', codesq, codcon, codniv, codtar, monto, ususis, fecreg, horreg FROM monto WHERE codper='$this->codper'");
							flash::warning("Notice: Proceso realizado exitosamente");
					}else{
						flash::error("Error: existen monto de Tarifas en ese periodo académico");
					}
				
			}
			
		}
	}	 
		
	
}
	
?>