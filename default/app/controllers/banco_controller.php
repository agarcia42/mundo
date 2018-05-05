<?php
class BancoController extends AppController{
	
	protected function before_filter(){
      if(Load::model('usuarios')->logged()==true){
         $this->cedusu = Session::get('cedusu');
      }else{
        return Redirect::route_to("controller: index", "action: logout");
      }
    }
		
		
		
	
	public function actualizacion($id="0",$accion="N",$page=1,$perpage=50){
	View::template(NULL);
	if($accion=="E"){
			if(!load::model('factura')->find_first("bandep='$id' or banche='$id' ")){
				load::model('bancos')->find_all_by_sql("delete from bancos where id='$id'");
				Flash::success("Noticia: Registro Eliminado...");
			}else {
				Flash::error('Error: Existe una relación Banco-Factura');
			}
		}
	
	if(Input::hasPost("banco")){
			$this->id = Input::request("id");
			$this->desban = Input::request("desban");
			$this->status = Input::request("status");
			$this->fecreg=date("Y-m-d");
			$this->horreg=date("H:i:s");
	 		$this->ususis=trim(strtoupper(Session::get('ceusualogin')));
			$fields="Codigo de Banco=>{$this->id},Noombre de Banco=>{$this->desban}";
				$valida = Conests::validate($fields);
				if($valida!="0"){
					flash::error("Error: el campo {$valida} es obligatorio");
				}else{
					if(!load::model('bancos')->find_first("id='$this->id'")){
						load::model('bancos')->find_all_by_sql("INSERT INTO bancos(id, desban , ususis, fecreg, horreg, status) VALUES ('$this->id', '$this->desban', '$this->ususis', '$this->fecreg', '$this->horreg','$this->status')");
						flash::warning("Registro Insertado Correctamente");
					}else{
						load::model('bancos')->find_all_by_sql("update BANCOS set  desban='$this->desban', ususis='$this->ususis', fecreg='$this->fecreg', horreg='$this->horreg', status='$this->status' where id='$this->id'");
						flash::warning("Registro Modificado Correctamente");
					}
				}

	}
	
	$this->paginar($id,$page,$perpage);
	}
	
	
	public function paginar($id="0",$page=1,$perpage=50){
	$this->page=$page;
	$this->perpage=$perpage;
		
	$busc = load::model('bancos')->find_first("id='$id'");
	if ($busc){
		$this->id=$busc->id;
		$this->desban=$busc->desban;
		$this->status=$busc->status;
	}else{
		$this->id = Input::request("id");
		$this->desban = Input::request("desban");
		$this->status = Input::request("status");
	}
	
	}
		 
		
	
	}
	
?>