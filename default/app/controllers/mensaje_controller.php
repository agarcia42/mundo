<?php

/*** Controller datapers: maestro de datos personales ***/

class MensajeController extends AppController
{
	protected function before_filter()
	{
	    if(Load::model('usuarios')->logged()==true){
			$this->cedusu = Session::get('cedusu');
		}else{
			return Redirect::route_to("controller: index", "action: logout");
		}
    }
	
    public function msg($x='0',$pag=1,$perpag=50,$cedrep=0,$accion='N'){
		if($x=='1'){
		View::template('default');}else{View::template(NULL);
		}
		if($accion=="E"){ //elimina un registro
			if(!load::model('alumno')->find_first("cedrep='$cedrep'")){
				if (load::model('representante')->find_all_by_sql("delete from representante where cedrep='$cedrep'")) { 
					Flash::notice("Noticia: Registro Eliminado...");
				}else {
					Flash::error('Error: Desconocido');
				}
			}else {
					Flash::error('Error: Existe una relación Represerntante-Alumno');
			}
		}

		if(Input::hasPost("representante")){
			$conditions= load::model('representante')->recibe();
			$nro=load::model('representante')->count("{$conditions}");
			if($nro==1){
				$rep=load::model('representante')->find_first("{$conditions}");
				Session::set('cedrep',$rep->cedrep);
				return Redirect::route_to("controller: representante", "action: portal","id: {$rep->cedrep}");
			}
			flash::notice($nro." registros encontrados");
			Session::set('conditions',$conditions);
		}
		$this->conditions=Session::get('conditions');
		$this->pag=$pag;
		$this->perpag=$perpag;

	}
	
		
}