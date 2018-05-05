<?php
class Mihelper 
	{
		
		
	

	public static function obser($and){
		$obser=NULL;
		if($and!=NULL){
			$obser .= $and;
		}
		return $obser;
	}
	
	public static function DataSelect($campoid,$campodes,$table,$conditions,$width='',$value,$si,$sino,$activo=0,$order='asc')
		{//$obser = ConestsHelper::obser($si);
		 //$cond  = ConestsHelper::obser($sino);
		$Cetable = Load::model($table); 
		$sql1=$Cetable->find_all_by_sql("select distinct ".$campoid.",".$campodes." from ".$table." ".$conditions." order by ".$campoid." ".$order);
		if($activo==0){
		$code = "<select id=\"".$campoid."\" name=\"".$campoid."\" style=\"width: ".$width."px\"  class='form-control'>";
		}else{
			$code = "<select id=\"".$campoid."\" name=\"".$campoid."\" style=\"width: ".$width."px\" disabled='disabled'  class='form-control'>";
		}
		
		if($si){
			foreach($sql1 as $tabla):
				if($campoid!=$campodes){
					$campod=$tabla->$campodes;
				}else{
					$campod="";
				}
				if($value==($tabla->$campoid)){
				 $code .= "<option value=\"".$tabla->$campoid."\" selected=\"selected\">".$tabla->$campoid."  ".$campod." </option>";
				 }else{
					 $code .= "<option value=\"".$tabla->$campoid."\">".$tabla->$campoid."  ".$campod." </option>";
				 }
			endforeach;
		}elseif($sino){
			$code .="<option value=\"0\" selected=\"selected\">Seleccione una...</option>";
			foreach($sql1 as $tabla):
				if($campoid!=$campodes){
					$campod=$tabla->$campodes;
				}else{
					$campod="";
				}
	 		    $code .= "<option value=\"".$tabla->$campoid."\">".$tabla->$campoid."  ".$campod." </option>";
			endforeach;
		}else{
			$code .="<option value=\"0\">Seleccione una...</option>";
		}
		//}
		$code .= "</select>";
		echo $code; 
		}
		
		
		public static function estadoSelect($id, $value=null, $disable=0)
		{
		if($disable==1)
			{$code = "<select name=\"$id\" id=\"$id\" disabled=\"true\" readonly=\"true\">";}
		else{$code = "<select name=\"$id\" id=\"$id\">";}
		if(($value == "0") or ($value == ""))
			{$code .= "<option value=\"0\">Seleccione...</option>";
			 $code .= "<option value=\"A\">ACTIVO</option>";
			 $code .= "<option value=\"I\">INACTIVO</option>";}
		elseif($value=="A")
			{$code .= "<option value=\"A\">ACTIVO</option>";
			 $code .= "<option value=\"I\">INACTIVO</option>";}
		elseif($value=="I")
			{$code .= "<option value=\"I\">INACTIVO</option>";
			 $code .= "<option value=\"A\">ACTIVO</option>";}
		$code .= "</select>";
		echo $code; 
		}	
		
		public static function sinoSelect($id, $value=null, $disable=0)
		{
		if($disable==1)
			{$code = "<select name=\"$id\" id=\"$id\" disabled=\"true\" readonly=\"true\">";}
		else{$code = "<select name=\"$id\" id=\"$id\">";}
		if(($value == "0") or ($value == ""))
			{$code .= "<option value=\"0\">Seleccione...</option>";
			 $code .= "<option value=\"S\">Si</option>";
			 $code .= "<option value=\"N\">No</option>";}
		elseif($value=="S")
			{$code .= "<option value=\"S\">Si</option>";
			 $code .= "<option value=\"N\">No</option>";}
		elseif($value=="N")
			{$code .= "<option value=\"N\">No</option>";
			 $code .= "<option value=\"S\">Si</option>";}
		$code .= "</select>";
		echo $code; 
		}	
		
		public static function Transaccion($id, $value=null, $disable=0)
		{
		if($disable==1)
			{$code = "<select name=\"$id\" id=\"$id\" disabled=\"true\" readonly=\"true\" style=\"width: 85px\">";}
		else{$code = "<select name=\"$id\" id=\"$id\" style=\"width: 85px\">";}
		if(($value == "0") or ($value == ""))
			{$code .= "<option value=\"0\">Seleccione...</option>";
			 $code .= "<option value=\"D\">DEPOSITO</option>";
			 $code .= "<option value=\"C\">CHEQUE</option>";
			 $code .= "<option value=\"E\">EFECTIVO</option>";}
		elseif($value=="D")
			{$code .= "<option value=\"0\">Seleccione...</option>";
			 $code .= "<option value=\"D\" selected=\"selected\">DEPOSITO</option>";
			 $code .= "<option value=\"C\">CHEQUE</option>";
			 $code .= "<option value=\"E\">EFECTIVO</option>";}
		elseif($value=="C")
			{$code .= "<option value=\"0\">Seleccione...</option>";
			 $code .= "<option value=\"D\">DEPOSITO</option>";
			 $code .= "<option value=\"C\" selected=\"selected\">CHEQUE</option>";
			 $code .= "<option value=\"E\">EFECTIVO</option>";}
		elseif($value=="E")
			{$code .= "<option value=\"0\">Seleccione...</option>";
			 $code .= "<option value=\"D\">DEPOSITO</option>";
			 $code .= "<option value=\"C\">CHEQUE</option>";
			 $code .= "<option value=\"E\" selected=\"selected\">EFECTIVO</option>";}
		$code .= "</select>";
		echo $code; 
		}	
		
		public static function ingegrSelect($id, $value=null, $disable=0)
		{
		if($disable==1)
			{$code = "<select name=\"$id\" id=\"$id\" disabled=\"true\" readonly=\"true\">";}
		else{$code = "<select name=\"$id\" id=\"$id\">";}
		if(($value == "0") or ($value == ""))
			{$code .= "<option value=\"0\">Seleccione...</option>";
			 $code .= "<option value=\"E\">EGRESO</option>";
			 $code .= "<option value=\"I\">INGRESO</option>";}
		elseif($value=="E")
			{$code .= "<option value=\"E\">EGRESO</option>";
			 $code .= "<option value=\"I\">INGRESO</option>";}
		elseif($value=="I")
			{$code .= "<option value=\"E\">EGRESO</option>";
			 $code .= "<option value=\"I\">INGRESO</option>";}
		$code .= "</select>";
		echo $code; 
		}	
		
		public static function input($id, $value=null, $disable=false)
		{
			$code= "<td>";
			if($value!=0) { 
				$code .= "<input name=\"$id\" type=\"checkbox\" value=\"1\" checked=\"checked\"  />";
	 		} else {
				$code .= "<input name=\"$id\" type=\"checkbox\" value=\"1\" />";
			}
			$code .="</td>";
		echo $code; 
		}		
        

	public static function nacionalidadSelect($id, $value=null, $disable=0)
		{
		if($disable==1)
			{$code = "<select name=\"$id\" id=\"$id\" disabled=\"true\" readonly=\"true\">";}
		else{$code = "<select name=\"$id\" id=\"$id\">";}
		if(($value == "0") or ($value == ""))
			{$code .= "<option value=\"0\">Seleccione...</option>";
			 $code .= "<option value=\"V\">VENEZOLANO(A)</option>";
			 $code .= "<option value=\"E\">EXTRANJERO(A)</option>";}
		elseif($value=="V")
			{$code .= "<option value=\"V\">VENEZOLANO(A)</option>";
			 $code .= "<option value=\"E\">EXTRANJERO(A)</option>";}
		elseif($value=="E")
			{$code .= "<option value=\"E\">EXTRANJERO(A)</option>";
			 $code .= "<option value=\"V\">VENEZOLANO(A)</option>";}
		$code .= "</select>";
		echo $code; 
		}

	
		
		public static function estcivSelect($id, $value=null, $disable=0)
		{
		if($disable==1)
			{$code = "<select name=\"$id\" id=\"$id\" disabled=\"true\" readonly=\"true\">";}
		else{$code = "<select name=\"$id\" id=\"$id\">";}
		if(($value == "0") or ($value == ""))
		{	$code .= "<option value=\"0\">Seleccione...</option>";
			$code .= "<option value=\"S\">SOLTERO(A)</option>";
			$code .= "<option value=\"C\">CASADO(A)</option>";
			$code .= "<option value=\"D\">DIVORCIADO(A)</option>";
			$code .= "<option value=\"V\">VIUDO(A)</option>";
	   	} elseif($value=="S") { 
			$code .= "<option value=\"S\">Soltero(a)</option>";
			$code .= "<option value=\"C\">CASADO(A)</option>";
			$code .= "<option value=\"D\">DIVORCIADO(A)</option>";
			$code .= "<option value=\"V\">VIUDO(A)</option>";
	   	 } elseif($value=="C") { 
			$code .= "<option value=\"C\">CASADO(A)</option>";
			$code .= "<option value=\"S\">SOLTERO(A)</option>";
			$code .= "<option value=\"D\">DIVORCIADO(A)</option>";
			$code .= "<option value=\"V\">VIUDO(A)</option>";
	   	 } elseif($value=="D") { 
			$code .= "<option value=\"D\">DIVORCIADO(A)</option>";
			$code .= "<option value=\"C\">CASADO(A)</option>";
			$code .= "<option value=\"S\">SOLTERO(A)</option>";
			$code .= "<option value=\"V\">VIUDO(A)</option>";
		}
		$code .= "</select>";
		echo $code; 
		}
		
		public static function MuestraDatos($id)
		{
		$usuario	 = Load::model('usuarios'); 
		$buscar = $usuario->busca_uno($id);
		$code  = '<i>Cédula de Identidad.:</i> <b>'.$buscar->cedusu;
		$code .= ' .::.</b><i> Nombre.:</i> <b>'.$buscar->nomusu.", ".$buscar->apeusu;
		$code .= ' .::.</b><i> Correo Electrónico.:</i><b> '.$buscar->emausu.'</b>';
		echo $code;
		}
		
		public static function MuestraMateria($codcar,$codmat,$codsec)
		{
		$materia	 = Load::model('cemmat'); 
		$buscar = $materia->busca_uno($codcar,$codmat);
		$code  = '<i>Unidad Curricular.:</i> <b>'.$buscar->codmat.'-'.$buscar->nommat;
		$code .= ' .::.</b><i> Sección.:</i> <b>'.$codsec;
		echo $code;
		}
		
		public static function MuestraDatos2($id){
		$profesor	 = Load::model('ceprof'); 
		$buscar = $profesor->busca_uno($id);
		$code ="<table width=\"70%\"  border=\"0\" align=\"center\">";
  		$code .="<tr><td align=\"right\">Cédula.:</td>";
		$code .="<td align=\"left\">".$buscar->numced."</td></tr>";
		$code .="<tr><td align=\"right\">Apellidos.:</td>";
		$code .="<td align=\"left\">".$buscar->apeprf."</td></tr>";
		$code .="<tr><td align=\"right\">Nombres.:</td>";
		$code .="<td align=\"left\">".$buscar->nomprf."</td></tr>";
		$code .="<tr><td align=\"right\">Correo Electrónico.:</td>";
		$code .="<td align=\"left\">".$buscar->emaprf."</td></tr>";
		$code .="<tr><td align=\"right\"> Teléfono.:</td>";
		$code .="<td align=\"left\">".$buscar->telprf."</td></tr></table>";
		echo $code;
		}
		
		public static function MuestraDepartamento()
		{
		$nivel		 = Load::model('cepniv');
		$sede		 = Load::model('cepsed');
		$modalidad	 = Load::model('ceptur');
		$buscar1 = $nivel->busca_uno(Session::get('reg_codniv'));
		$buscar2 = $sede->busca_uno(Session::get('reg_codsed'));
		$buscar3 = $modalidad->busca_uno(Session::get('reg_tiphor'));
		$code = ' <i> Departamento.:</i><b> '.$buscar1->desniv;
		$code .= ' .::.</b><i> Sede.:</i><b> '.$buscar2->dessed;
		$code .= ' .::.</b><i> Modalidad.:</i><b> '.$buscar3->deshor.'</b>';
		echo $code;
		}
		
		public static function consulta($models,$fields,$names,$conditions="",$top=100,$page=1){
		$f = explode(',',$fields); 
		$n = explode(',',$names); 
		if(count($f)<>count($n)){
		 echo "Error: no coincide fiels/names";
		}else{
		$ceesta = Load::model('ceesta');
		
		for($i=0;$i<count($f);$i++){
		 	$campo[$i]=ProfesoresHelper::str_campo($f[$i]);
		 }

	     $sql=$ceesta->find_all_by_sql("select ".$fields." from ".$models." ".$conditions);
		 $page = Paginator::consginate($sql,$page,$top); 
		 $notas = $page->items;
		
		 $code="<div></div><table width='90%' border='1' align='center'>";
		 $code .="<tr>";
			 for($c=0;$c<count($n);$c++){
				if(count($n)>1){
					if($c==0){
						$width=15;
					}else{$width=70/(count($n)-1);}
				}
			 $code .="<td  width='".$width."%'><b>".$n[$c]."</b></td>";
			 }
			 $code .="</tr>" ;
		 foreach($notas as $c):
		 	$code .="<tr>";
			 for($i=0;$i<count($campo);$i++){
				 $code .="<td>".$c->$campo[$i]."</td>";
			 }
			 $code .="</tr>";
		 endforeach;
		 $code .="</table>";
		 echo $code;
		 }
	}
		
	public static function str_campo($cadena){
		 	$f = explode('.',$cadena);
				if(count($f)==1){
					$fiels=$f[0];
				}else{
					$fiels=$f[1];
				}
		 	return $fiels;
		}
		
	public static function edad($fecnac=0)
		{ 	
			if ($fecnac==""){$fecnac=Date("Y-m-d");}
			//fecha actual
			$dia=Date("d");
			$mes=Date("m");
			$ano=Date("Y");
			 
			//fecha de nacimiento
			$fecha = explode('-', $fecnac); 
			$dianaz=trim($fecha[2]);
			$mesnaz=trim($fecha[1]);
			$anonaz=trim($fecha[0]);
			 
			 
			//si el mes es el mismo pero el día inferior aun no ha cumplido años, le quitaremos un año al actual
			 
			if (($mesnaz == $mes) && ($dianaz > $dia)) {
			$ano=($ano-1); }
			 
			 
			//si el mes es superior al actual tampoco habrá cumplido años, por eso le quitamos un año al actual
			 
			if ($mesnaz > $mes) {
			$ano=($ano-1);}
			 
			 
			//ya no habría mas condiciones, ahora simplemente restamos los años y mostramos el resultado como su edad
			 
			$edad=($ano-$anonaz);
			 
			echo $edad." años";
		}
		
		public static function ordenarSelect($id, $value=null)
		{
		$code = "<select name=\"$id\" id=\"$id\">";
		if($value=="0")
			{$code .= "<option value=\"0\">Seleccione...</option>";
			 $code .= "<option value=\"1\">Programa</option>";
			 $code .= "<option value=\"2\">Sede</option>";}
		if($value=="1")
			{$code .= "<option value=\"1\">Programa</option>";
			 $code .= "<option value=\"2\">Sede</option>";}
		if($value=="2")
			{$code .= "<option value=\"2\">Sede</option>";
			 $code .= "<option value=\"1\">Programa</option>";}
		$code .= "</select>";
		echo $code; 
		}	
	}
?>