<?php
class facturasController extends AppController
	{	
	protected function before_filter(){
      if(Load::model('usuarios')->logged()==true){
         $this->cedusu = Session::get('cedusu');
      }else{
        return Redirect::route_to("controller: index", "action: logout");
      }
    }
		
			 
	
	public function actualizacion($cedrep="0",$accion="F"){
		//$this->set_response("view");
		View::template(NULL);
		$this->cedrep=$cedrep;
		$this->valida=0;
		//$this->accion=$accion;
		//$this->data=0;
		$id=Session::get('ceusuacedu');
		if($accion=="F"){
			if($buscar=load::model('representante')->find_first("cedrep='$cedrep'")){
				$this->cedula=$buscar->cedrep;
				$this->nombre=$buscar->aperep.', '.$buscar->nomrep;
				$this->direccion=$buscar->dirrep;
				$this->telefono=$buscar->telcasrep;
				$this->opcion=0;
				$this->efe=input::request("efe");
				$this->deb=input::request("deb");
				$this->dep=input::request("dep");
				$this->che=input::request("che");
				$this->nrodeb=input::request("nrodeb");
				$this->nrodep=input::request("nrodep");
				$this->bandep=0;
				$this->nroche=input::request("nroche");
				$this->banche=0;
				$this->total=0;
			}
		}
		
		
		if(Input::hasPost("factura")){

				//$this->opcion = input::request("opcion");
				//$this->accion = $accion = $this->opcion;
				//$this->codigo = $codalu = input::request("codalu");
					$this->cedrep = input::request("cedrep");
					$this->cedula=input::request("cedula");
					$this->nombre=str_replace(',', '', input::request("nombre"));
					$this->direccion=str_replace(',', '',input::request("direccion"));
					$this->telefono=input::request("telefono");
					$this->efe=Conests::sinblan(input::request("efe"));
					$this->deb=Conests::sinblan(input::request("deb"));
					$this->dep=Conests::sinblan(input::request("dep"));
					$this->che=Conests::sinblan(input::request("che"));
					$this->nrodeb=input::request("nrodeb");
					$this->nrodep=input::request("nrodep");
					$this->bandep=input::request("bandep");
					$this->nroche=input::request("nroche");
					$this->banche=input::request("banche");
					$this->total=input::request("total");
					$nrofact=input::request("nrofact");
					$pagar=input::request("pagar");
					$fecfac=date("Y-m-d",strtotime(input::request("fecfac")));
					$fecreg=date("Y-m-d");
					$horreg=date("H:i:s");
	 				$ususis=trim(strtoupper(Session::get('ceusualogin')));
	 				$tiprep=load::model('representante')->tipo($this->cedula);

					$fields="Cedula=>{$this->cedula},Nombres=>{$this->nombre},Dirección=>{$this->direccion},Telefono=>{$this->telefono}";
					$this->valida = Conests::validate($fields);
					if($this->valida=="0"){
						if($this->total!='' and $this->total>=$pagar){
							//$db = DbBase::raw_connect();
							load::model('factura')->find_all_by_sql("INSERT INTO factura(
            numfact, fecfac, monfac, cedfac, nomfac, dirfac, telfac, efefac, 
            debfac, nrodeb, depfac, nrodep, bandep, chefac, nroche, banche, 
            usasis, fecreg, horreg, tiprep)
    VALUES ('$nrofact', '$fecfac', '$pagar', '$this->cedula', '$this->nombre', '$this->direccion', '$this->telefono', '$this->efe', 
            '$this->deb', '$this->nrodeb', '$this->dep', '$this->nrodep', '$this->bandep', '$this->che', '$this->nroche', '$this->banche', 
            '$ususis', '$fecreg', '$horreg', 'P')");
							load::model('factura')->find_all_by_sql("update detalle set stafac='C' where numfact='$nrofact' and stafac='F'");
							//$this->data=1;
						}else{
							flash::error($this->valida="total a cancelar no puede ser menor al facturado");
						}
						
					}else{
						flash::error($this->valida .= " es obligatorio");
					}
					
				
		}
	
	}
	
	
	
	}
	
?>