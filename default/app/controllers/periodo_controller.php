<?php
class PeriodoController extends AppController{
	
	protected function before_filter(){
      if(Load::model('usuarios')->logged()==true){
         $this->cedusu = Session::get('cedusu');
      }else{
        return Redirect::route_to("controller: index", "action: logout");
      }
    }
		
		
	
	public function actualizacion($codper="0",$accion="N",$page=1,$perpage=50){
	View::template(NULL);
	if($accion=="E"){
			if(!load::model('inscripcion')->find_first("codper='$codper'")){
				load::model('periodo')->find_all_by_sql("delete from periodo where codper='$codper'");
				Flash::success("Noticia: Registro Eliminado...");
			}else {
				Flash::error('Error: Existe una relación Periodo-Inscripción');
			}
		}
	
	if(Input::hasPost("periodo")){
			$this->codper = input::request("codper");
			$this->desper = input::request("desper");
			$this->feciniper = input::request("feciniper");
			$this->fecfinper = input::request("fecfinper");
			$this->status = input::request("status");
			$this->fecreg=date("Y-m-d");
			$this->horreg=date("H:i:s");
	 		$this->ususis=trim(strtoupper(Session::get('ceusualogin')));
			$fields="Periodo=>{$this->codper},Descripción de Periodo=>{$this->desper},Fecha de Inicio=>{$this->feciniper},Fecha Fin de Periodo=>{$this->fecfinper},Estado=>{$this->status}";
				$valida = Conests::validate($fields);
				if($valida!="0"){
					flash::error("Error: el campo {$valida} es obligatorio");
				}else{
					if(Conests::valid_todate($this->feciniper)==1){
							flash::error("Fecha Invalidad");
					}elseif(Conests::valid_todate($this->fecfinper)==1){
						flash::error("Fecha Invalidad");
					}else{
						$this->feciniper=date("Y-m-d",strtotime($this->feciniper));
						$this->fecfinper=date("Y-m-d",strtotime($this->fecfinper));
						if(!load::model('periodo')->find_first("codper='$this->codper'")){
							load::model('periodo')->find_all_by_sql("INSERT INTO periodo(codper, desper , feciniper, fecfinper, ususis, fecreg, horreg, estado) VALUES ('$this->codper', '$this->desper','$this->feciniper', '$this->fecfinper', '$this->ususis', '$this->fecreg', '$this->horreg','$this->status')");
							flash::warning("Registro Insertado Correctamente");
						}else{
							Load::model('periodo')->find_all_by_sql("UPDATE periodo SET  desper='$this->desper', feciniper='$this->feciniper', fecfinper='$this->fecfinper', ususis='$this->ususis', fecreg='$this->fecreg', horreg='$this->horreg',estado='$this->status' WHERE codper='$codper'");
							flash::warning("Registro Modificado Correctamente");
						}
						//$this->feciniper=date("d-m-Y",strtotime($this->feciniper));
						//$this->fecfinper=date("d-m-Y",strtotime($this->fecfinper));
					}
				}

	}
	
	$this->paginar($codper,$page,$perpage);
	}
	
	
	public function paginar($codper="0",$page=1,$perpage=50){
		$this->page=$page;
		$this->perpage=$perpage;
		
	$busc = load::model('periodo')->find_first("codper='$codper'");
	if ($busc){
		$this->codper=$busc->codper;
		$this->desper=$busc->desper;
		$this->feciniper=date("d-m-Y",strtotime($busc->feciniper));
		$this->fecfinper=date("d-m-Y",strtotime($busc->fecfinper));
		$this->status=$busc->estado;
	}else{
		$this->codper = Input::request("codper");
		$this->desper = Input::request("desper");
		$this->feciniper =Input::request("feciniper");
		$this->fecfinper =Input::request("fecfinper");
		$this->status = Input::request("status");
	}
	
	}
		 
		
	
	}
	
?>