<?PHP
/*************************************************************************
* Software: JLPDF, based on FPDF                                         *
* Version:  1.00                                                         *
* Date:     2007-06-23                                                   *
* Author:   elticus & JL group                                           *
* License:  Freeware                                                     *
* Web Page: http://elticus.com/jlpdf/                                    *
*                                                                        *
* You may use and modify this code freely.                               *
**************************************************************************/

class Conests
{
	
	static function email($email,$title,$body,$nombre="estudiante")
		{
		$mail 	  	      = new phpmailer();
		$mail->SMTPAuth   = true;
		$mail->SMTPSecure = "ssl";
		$mail->Mailer 	  = "smtp";			
		$mail->Host 	  = "smtp.gmail.com";	
		$mail->Port 	  = 465;
		$mail->SMTPAuth   = true;			
		$mail->Username   = "soporte@correo.unefm.edu.ve"; 
		$mail->Password   = "unefm*2009";			
		$mail->From       = "soporte@correo.unefm.edu.ve";
		$mail->FromName   = "Soporte Control de Estudios UNEFM";			
		$mail->Timeout    = 30;
		$mail->AddAddress(trim($email));		
		$mail->Subject    = $title;
		$mail->Body       = "<h3>Hola, ".$nombre." Bienvenido(a) a la UNEFM.</h3><br><b>".$body."</b><br><br>Dudas y Sugerencias envia un Correo Electronico a: <b>soporte@correo.unefm.edu.ve</b> o por el Teléfono: <b>0268-2502505</b><br><br><br><br>'Las naciones marchan hacia el t&eacute;rmino de su grandeza,<br>con el mismo paso que camina la educaci&oacute;n...'<br><b>Sim&oacute;n Bol&iacute;var</b><br>Potos&iacute;, Octubre de 1825";			
		$mail->AltBody    = "Mensaje solo Text";			
		$exito = $mail->Send();			
		$intentos = 1;
		$errores = 1;
		while ((!$exito) && ($intentos < 5)) 
			{sleep(3);
			 //echo $mail->ErrorInfo;
			 $exito = $mail->Send();
			 $intentos = $intentos+1;
		}
		if($exito){
			Flash::success("Noticia: Revise su correo Eelectronico");
		}else{
			Flash::error("Error: Por favor Contacte soporte@correo.unefm.edu.ve");
		}
		
		return $exito;
		
	}
	/***************************************************************/
	public static function get_dat($params)
    {
		$params = explode(';', $params);
		$data = array();
		foreach($params as $p) {
			$match = explode(':', $p, 2);
			$data[$match[0]] = $match[1];
		}
		return $data;
    }

	/***************************************************************/

    public static function un_dat($input,$output,$data,$value)
    {
    	$dat=Load::model($data)->find_first("conditions: $input='$value'");
    	if($dat){
    		$value=$dat->$output;
    	}
    	return $value;
    }

    /**********************************************************************/

    public static function mes($mes){
		switch($mes){
			case '01': return "Enero";break;
			case '02': return "Febrero";break;
			case '03': return "Marzo";break;
			case '04': return "Abril";break;
			case '05': return "Mayo";break;
			case '06': return "Junio";break;
			case '07': return "Julio";break;
			case '08': return "Agosto";break;
			case '09': return "Septiembre";break;
			case '10': return "Octubre";break;
			case '11': return "Noviembre";break;
			case '12': return "Diciembre";break;
		}//fin function mes
	}

	/*****************************funtions calcularedad***************
	*devuelve la edad  
	* 
	*$fecha: fecha de nacimiento
	*ejemplo: Conests::calcularedad($b->fecnac)
	***************************************************************/
	
	static function edad($fecnac=0,$fecgra){
		$fechag = explode('-', $fecnac); 
		$dia=trim($fechag[2]);
		$mes=trim($fechag[1]);
		$ano=trim($fechag[0]);
			$fecha = explode('-', $fecnac); 
			$dianaz=trim($fecha[2]);
			$mesnaz=trim($fecha[1]);
			$anonaz=trim($fecha[0]);
 				if (($mesnaz == $mes) && ($dia < $dianaz)) {
					$ano=($ano-1); }
 				if ($mes < $mesnaz) {
					$ano=($ano-1);}
 			$edad=($ano-$anonaz);	
		return($edad);
	}

	/*****************************funtions conditions***************
	*genera una condicion para una consulta sql 
	* 
	*$fields: parametros que tendra la condicion
	*ejemplo: Conests::conditions("numcar=>numced","apeest=>apellido")
	*donde: numcar,apeest son los campos de la tabla y 
	*		numced,apellido son los datos
	***************************************************************/
	
	static function conditions($fields){
		$g = explode(',',$fields);
		$f = explode(':',$g[0]);
			if(count($g)!=0){
					if(strlen($f[1])==0){
						for($i=1;$i<count($g);$i++){
							$f = explode(':',$g[$i]);
							if(strlen($f[1])!=0 and $f[1]!="0"){
								if(isset($criterio) and $criterio==1){
									$busqueda .= " and translate(".$f[0].",'áéíóúÁÉÍÓÚäëïöüÄËÏÖÜ','aeiouAEIOUaeiouAEIOU') like translate('".$f[1]."%','áéíóúÁÉÍÓÚäëïöüÄËÏÖÜ','aeiouAEIOUaeiouAEIOU')";
								}else{
						 			$busqueda = "translate(".$f[0].",'áéíóúÁÉÍÓÚäëïöüÄËÏÖÜ','aeiouAEIOUaeiouAEIOU') like translate('".$f[1]."%','áéíóúÁÉÍÓÚäëïöüÄËÏÖÜ','aeiouAEIOUaeiouAEIOU')";
						 			$criterio=1;
								}
							}
						}
					}else{
						$busqueda = $f[0]." = '".$f[1]."'";
						$criterio=1;
					}
				if(isset($criterio) and $criterio==1){
					return strtoupper($busqueda);
				}
			}else{
				return ("cedrep='0'");
			} 
	
	}


	/*****************************funtions conditions***************
	*genera una validacion de varios campos  
	* 
	*$fields: parametros que tendra la condicion
	*ejemplo: Conests::validate("cedula=>numced","apellidos=>apellido")
	*donde: cedula,apellidos son los nombres del campo
	*		numced,apellido son los datos
	***************************************************************/
	static function validate($fields){
		$g = explode(',',$fields);
		//$f = explode('=>',$g[0]);
		$e = 0;
			if(count($g)!=0){
						for($i=0;$i<count($g);$i++){
							$f = explode('=>',$g[$i]);
							if(strlen($f[1])==0 or $f[1]=="0" or $f[1]==""){
								$e=$f[0];
								$i=count($g);
							}
						}
					return ($e);
					
			}else{
				return (count($g));
			} 
	
	}
	
	/*
	*$fecha: fecha de nacimiento
	*ejemplo: Conests::calcularedad($b->fecnac)
	***************************************************************/
	
	static function calcularedad($fecnac=0){
		$dia=Date("d");
		$mes=Date("m");
		$ano=Date("Y");
			$fecha = explode('-', $fecnac); 
			$dianaz=trim($fecha[2]);
			$mesnaz=trim($fecha[1]);
			$anonaz=trim($fecha[0]);
 				if (($mesnaz == $mes) && ($dia < $dianaz)) {
					$ano=($ano-1); }
 				if ($mes < $mesnaz) {
					$ano=($ano-1);}
 			$edad=($ano-$anonaz);	
		return($edad);
	}

	
	
	/****************************elimina blancos por ceros****************************/
	static function sinblan($campo="0"){
		$c="0";
 			if($campo!="" and $campo!="0"){
				$c=$campo;
			}
			return $c;
	} 
	
	static function valid_todate($campo="0"){
		$c = explode('-', $campo); 
		$r=0;
		if(count($c)!=3){
			$r=1;
		}else{
			$dia=trim($c[0]);
			$mes=trim($c[1]);
			$ano=trim($c[2]);
			if((!is_numeric($dia)) or (!is_numeric($mes)) or (!is_numeric($ano)) or ($ano==0) or ($dia>31) or ($mes>12) or ($dia<1) or ($mes<1) ){
				$r=1;
			}else{
				$r=$ano;
			}
		}
		return $r;
	} 
	
	
	static function sincoma($campo="0"){
		$c="";
		for($i=0;$i<=strlen($campo);$i++){
			if($campo[$i]!=','){
			 $c .=$campo[$i];
			}else{
				$c .=' ';
			}
		}
			return $c;
	} 
	
	

}