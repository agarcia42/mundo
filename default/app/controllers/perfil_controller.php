<?php

/**
 * Controller datapers: maestro de datos personales
 * 
 */
class PerfilController extends AppController
{
	protected function before_filter()
	{
	    if(Load::model('ceestpt')->logged()==true){
			$datos = Session::get('su');
			$this->numcar=$datos['numcar'];
			$this->codsed=$datos['codsed'];
			$this->codcar=$datos['codcar']; 
			$this->tiphor=$datos['tiphor']; 
			$this->numano=$datos['numano']; 
			$this->numper=$datos['numper']; 
			$this->possrt=$datos['possrt'];
			$this->codpln=$datos['codpln'];
		}
    }
	
    public function personal(){
		View::template(NULL);
		if(!isset($this->numcar)){
				return Redirect::route_to("controller: index", "action: logout");
		}
		$this->data=Load::model('ceestp')->busca_uno($this->numcar);
			if(!$this->data){
				Flash::error("Ha Ocurrido un Error en la Aplicación, y se Cerrará");
				return Redirect::route_to("controller: index", "action: logout");
			}else{
				$this->dat=Load::model('ceestpt')->busca_uno($this->numcar);
			}
	}
			 
	  public function academico($page=1,$perpage=25,$codcar="0"){
		View::template(NULL);
		$this->page=$page;
		$this->perpage=$perpage;
		if(!isset($this->numcar)){
				return Redirect::route_to("controller: index", "action: logout");
		}
		$this->data=Load::model('ceesta')->busca_uno($this->numcar,$codcar);
			if(!$this->data){
				Flash::error("Ha Ocurrido un Error en la Aplicación, y se Cerrará");
				return Redirect::route_to("controller: index", "action: index");
			}
	}

	public function notas(){
 		View::template(NULL); 
 		if(!isset($this->numcar)){
				return Redirect::route_to("controller: index", "action: logout");
		}
        $this->datos = Load::model('ceinse')->todos_te($this->numcar,$this->codcar,$this->codsed,$this->tiphor,$this->numano,$this->numper);
     }

     public function finiquito(){
 		View::template(NULL); 
 		if(!isset($this->numcar)){
				return Redirect::route_to("controller: index", "action: logout");
		}
     }

}