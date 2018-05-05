<?php
class CursoController extends AppController{
	
	protected function before_filter(){
      if(Load::model('usuarios')->logged()==true){
         $this->cedusu = Session::get('cedusu');
      }else{
        return Redirect::route_to("controller: index", "action: logout");
      }
    }
		
		
	
	public function actualizacion($codniv="0",$codcur="0",$accion="N",$page=1,$perpage=50){
	View::template(NULL);
	if($accion=="E"){
			if(!load::model('inscripcion')->find_first("codniv='$codniv' and codcur='$codcur'") and !load::model('seccion')->find_first("codniv='$codniv' and codcur='$codcur'")){
				Load::model('curso')->find_all_by_sql("delete from curso where codniv='$codniv' and codcur='$codcur'");
				Flash::success("Noticia: Registro Eliminado...");
			}else {
					Flash::error('Error: Existe una relación Curso-Inscripción');
			}
		}
	
	if(Input::hasPost("curso")){
			$codniv = input::request("codniv");
			$codcur = input::request("codcur");
			$descur = input::request("descur");
			$fecreg=date("Y-m-d");
			$horreg=date("H:i:s");
	 		$ususis=trim(strtoupper(Session::get('ceusualogin')));
			$fields="Codigo de Nivel=>{$codniv},Codigo de Curso=>{$codcur},Descripción de Curso=>{$descur}";
				$valida = Conests::validate($fields);
				if($valida!="0"){
					flash::error("Error: el campo {$valida} es obligatorio");
				}else{
					if(!Load::model('curso')->find_first("codniv='$codniv' and codcur='$codcur'")){
						Load::model('curso')->find_all_by_sql("INSERT INTO Curso(codniv, codcur, descur , ususis, fecreg, horreg) VALUES ('$codniv','$codcur', '$descur', '$ususis', '$fecreg', '$horreg')");
						flash::warning("Registro Insertado Correctamente");
					}else{
						Load::model('curso')->find_all_by_sql("update Curso set  descur='$descur', ususis='$ususis', fecreg='$fecreg', horreg='$horreg' where codniv='$codniv' and codcur='$codcur'");
						flash::warning("Registro Modificado Correctamente");
					}
				}

	}
	
	$this->paginar($codniv,$codcur,$page,$perpage);
	}
	
	
	public function paginar($codniv="0",$codcur="0",$page=1,$perpage=50){
		$this->page=$page;
		$this->perpage=$perpage;
	
		
	$busc = Load::model('curso')->find_first("codniv='$codniv' and codcur='$codcur'");
	if ($busc){
		$this->codniv=$busc->codniv;
		$this->codcur=$busc->codcur;
		$this->descur=$busc->descur;
	}else{
		$this->codniv = $codniv;
		$this->codcur = input::request("codcur");
		$this->descur = input::request("descur");
	}
	
	}
		 
		
	
	}
	
?>