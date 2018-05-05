<?php
class MatriculaController extends AppController{
	
	protected function before_filter(){
      if(Load::model('usuarios')->logged()==true){
         $this->cedusu = Session::get('cedusu');
      }else{
        return Redirect::route_to("controller: index", "action: logout");
      }
    }

	public function actualizacion($codniv='0',$codcur='0',$codper='0',$codsec1='0',$codsec2='0'){
		View::template(NULL);
		$this->codniv=$codniv;
		$this->codcur=$codcur;
		$this->codsec1=$codsec1;
		$this->codsec2=$codsec2;
		$this->codper=$codper;
		if(Input::hasPost("inscripcion")){
			$this->codniv = Input::request("codniv");
			$this->codcur = Input::request("codcur");
			$this->codsec1= Input::request("codsec");
			$this->codsec2= Input::request("codsec2");
			$this->codper = Input::request("codper");
			//echo $this->codniv.'-'.$this->codcur.'-'.$this->codsec1.'-'.$this->codsec2.'-'.$this->codper;

			$fields="Codigo de Nivel=>{$this->codniv},Codigo de Curso=>{$this->codcur},Seccion 1=>{$this->codsec1},Seccion 2=>{$this->codsec2}";
				$valida = Conests::validate($fields);
				if($valida!="0"){
					flash::error("Error: el campo {$valida} es obligatorio");
				}else{
					if(!Input::request("list1")){
						flash::error("Error: Debe Seleccionar Alumno de la Lista");
					}else{
						foreach(Input::request("list1") as $r){
							load::model('inscripcion')->find_all_by_sql("update inscripcion set codsec='$this->codsec2' where cedrep||codalu='$r'");
						}
						flash::warning("Noticia: Proceso Realizado...");
					}
				}
		}
	
	}

}