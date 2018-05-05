<?php

/** Controller Registro **/

class RegistroController extends AppController
{
	
	public function index($v=0){
		View::template(null);
		if(Input::hasPost("ceestema")){
			$numced = Input::request("numced");
		 	$email  = Input::request("email");
			if($numced=="" or $email==""){
				Flash::error("Debe completar todos los campos para el Registro.");
			}else{
				if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                	Flash::error("Dirección de Correo Electrónico No Válida");
                }else{
                	if($ctpt=Load::model('ceestpt')->find_first("numcar=$numced")){ //Regular
                		if($ctpt->control==0){
                			unset($_POST["registrarme"]); 
                			return Redirect::route_to("controller: registro", "action: regular", "parameters: $numced/$email");
                		}else{
                			Flash::error("Existe un estudiante registrado con ese Correo Electrónico");
                		}	
                	}elseif($ctmp=Load::model('ceestemp')->find_first("numced=$numced")){
                		if($ctmp->control==0){
                			Input::delete("ceestema"); 
                			return Redirect::route_to("controller: registro", "action: registro", "parameters: $numced/$email");
                		}else{
                			Flash::error("Error: El estudiante está registrado en el sistema....");
                		}
                	}else{
                			Flash::error("Usted no ha sido seleccionado aun....");
                	}
                }		
			}
		}Input::delete("ceestema");
	
	}



  	
	
	/****************************************Registro Nuevo Ingreso****************************************/	
	public function registro($numced=0,$email="02")
    	{
		View::template(NULL);
		
		if(Input::hasPost("ceestemp")){
			
			/*Datos Personales*/
			$numced   = Input::request("numced"); // echo $numced." numced <br>";
		 	$correcto  = Input::request("correcto"); //echo $correcto."<br>";
			if($correcto==2)
			{
				$conomest = Input::request("conomest"); //echo $conomest."<br>";
				$coapeest = Input::request("coapeest"); //echo $coapeest."<br>";
			}else{
				$conomest = "";
				$coapeest = "";
			}
			$codsex = Input::request("codsex"); //echo $codsex."<br>";
			$estciv = Input::request("estciv"); //echo $estciv."<br>";
			$idnac  = Input::request("idnac"); //echo $idnac."<br>";
			$etnia  = Input::request("etnia"); //echo $etnia."<br>";
			$fecnac = Input::request("fecnac"); //echo $fecnac."<br>";
			
			/*Lugar de Nacimiento*/
			$pais = Input::request("pais"); //echo $pais."<br>";
			if($pais=='232')
				{
				$entidad = Input::request("entidades"); //echo $entidad."<br>";
				$ciudad = Input::request("ciudades"); //echo $ciudad."<br>";
				$municipio = Input::request("municipio"); //echo $municipio."<br>";
				$parroquia = Input::request("parroquia");  //echo $parroquia."<br>";
				$lugnac="";
				}else{
				$lugnac = Input::request("lugnac"); //echo $lugnac."<br>";
				$entidad = '0'; 
				$ciudad = '0'; 
				$municipio = '0'; 
				$parroquia = '0'; 
				}
			
			/*Direccion de Habitacion*/
			$telef1 = Input::request("telef1"); //echo $telef1."<br>";
			$codpos = Input::request("codpos"); //echo $codpos."<br>";
			$direc1  = Input::request("direc1"); //echo $direc1."<br>";
			$telef2  = Input::request("telef2"); //echo $telef2."<br>";
			$direc2 = Input::request("direc2"); //echo $direc2."<br>";
			
			/*Datos de Procedencia*/
			$plantel = Input::request("plantel"); //echo $plantel."<br>";
			$anogra = Input::request("anogra"); //echo $anogra."<br>";
			$promed = Input::request("promed"); //echo $promed."<br>";
			
			/*Confirmar Correo*/
			$correo1 = Input::request("correo1"); //echo $correo1."<br>";
			$correo2 = Input::request("correo2"); //echo $correo2."<br>";
			
			if($numced=="" or $numced==0 or $correcto=="0" or $codsex=="0" or $estciv=="0" or $idnac=="0" or $fecnac=="" or $pais=="0" or $telef1=="" or $codpos=="" or $direc1=="" or $correo1=="" or $correo2=="")
			{
				Flash::error("Debe llenar todos los campos para completar el registro.");
			}else{
				if($correcto==2 and ($conomest=="" or $coapeest=="")){
					Flash::error("Debe escribir la corrección de sus Nombres y Apellidos.");
				}else{
					if(($pais=='232' and ($entidad=="0" or $ciudad=="0" or $municipio=="0" or $parroquia=="0")) or ($pais!='232' and $lugnac=="")){
						Flash::error("Debe completar todos los datos de su Lugar de Nacimiento.");
					}else{
						if($correo1!=$correo2){
							Flash::error("El correo electrónico de confirmación no coincide con el incial.");
						}else{
							/*Guardar Datos del Registro*/
							$pre_planilla = Load::model('ceestemp')->nroregistros();
							$planilla = "MUN".date('dmY').($pre_planilla+1);
							if($idnac=='111'){$codnac='V';}else{$codnac='E';}
							$fechaa = getdate();
							Load::model('ceestemp')->actualiza($numced,$planilla,$correcto,$conomest,$coapeest,$codnac,$idnac,$etnia,$fecnac,$codsex,$estciv,$pais,$entidad,$ciudad,$municipio,$parroquia,$lugnac,$fechaa[0],$codpos,$direc1,$telef1,$direc2,$telef2,$plantel,$anogra,$promed,$correo2);
							$this->correonuevoin($numced,$correo2);
							//Flash::success("Registro Completado Satisfactoriamente. Presione ".Html::link("", "aquí", "class='card-action-red'")." para ir a Inicio."); 
							/*Fin Guardar Datos*/
						}//Fin validacion correos
					}//Fin else validacion lugar de nacimiento
				}//Fin else validacion correcion nombres
			}//Fin else validacion de campos
		unset($_POST["registrarme"]); 
		}  

		$this->numced=$numced;
		$this->email=$email;
		$this->cees=Load::model('ceestemp')->find_first("numced=$numced");
   	}
	/*********************************************** Registro Regular ******************************************/
	public function regular($numcar="0",$email="")
    	{
		View::template(null);
		
		$this->email=$email;
		$this->cees=Load::model('ceestp')->find_first("numcar=$numcar and status='A'");
		$this->vista=1;
		
		if(Input::hasPost("ceestp")){
			
			View::template(NULL);
			$this->vista=0;
			
			/*Datos Personales*/
			$numcar = Input::request("numcar");	//echo $numcar." numced <br>";
			//$codsex = Input::request("codsex"); //echo $codsex."<br>";
			//$estciv = Input::request("estciv"); //echo $estciv."<br>";
			//$idnac  = Input::request("idnac"); 	//echo $idnac."<br>";
			//$fecnac = Input::request("fecnac"); //echo $fecnac."<br>";
			
			/*Lugar de Nacimiento*/
			$pais = Input::request("pais"); //echo $pais."<br>";
			if($pais=='232'){
				$entidad = Input::request("entidades"); //echo $entidad."<br>";
				$ciudad = Input::request("ciudades"); //echo $ciudad."<br>";
				$municipio = Input::request("municipio"); //echo $municipio."<br>";
				$parroquia = Input::request("parroquia");  //echo $parroquia."<br>";
				$lugnac="";
			}else{
				$lugnac = Input::request("lugnac"); //echo $lugnac."<br>";
				$entidad = '0'; 
				$ciudad = '0'; 
				$municipio = '0'; 
				$parroquia = '0'; 
			}
			
			/*Datos Actuales*/
			//$telef1 = Input::request("telef1"); //echo $telef1."<br>";
			//$direc1  = Input::request("direc1"); //echo $direc1."<br>";
			//$telef2  = Input::request("telef2"); //echo $telef2."<br>";
			//$direc2 = Input::request("direc2"); //echo $direc2."<br>";
			
			/*Confirmar Correo*/
			$correo1 = Input::request("correo1"); //echo $correo1."<br>";
			$correo2 = Input::request("correo2"); //echo $correo2."<br>";
			
			if($numcar=="" or $numcar==0 /*or $codsex=="0" or $estciv=="0" or $idnac=="0" or $fecnac==""*/ or $pais=="0" /*or $telef1=="" or $direc1=="" or $correo1=="" or $correo2==""*/){
				//echo $numcar,$codsex,$estciv,$idnac,$fecnac,$pais,$telef1,$direc1,$correo1,$correo2;				
				Flash::error("Debe llenar todos los campos para completar el registro.");
			}else{
				if(($pais=='232' and ($entidad=="0" or $ciudad=="0" or $municipio=="0" or $parroquia=="0")) or ($pais!='232' and $lugnac=="")){
					Flash::error("Debe completar todos los datos de su Lugar de Nacimiento.");
				}else{
					if($correo1!=$correo2){
						Flash::error("El correo electrónico de confirmación no coincide con el incial.");
					}else{
						/*Guardar Datos del Registro*/
						//if($idnac=='111'){$codnac='V';}else{$codnac='E';}
						//Load::model('ceestp')->actualiza($numcar,$codnac,$fecnac,$codsex,$estciv,$direc1,$telef1,$direc2,$telef2,$correo2);
						Load::model('ceestpt')->modificar($numcar,$pais,$entidad,$ciudad,$municipio,$parroquia,$correo2);
						$this->correoregular($numcar,$correo2);
						//Flash::success("Registro Completado Satisfactoriamente. Presione ".Html::link("", "aquí", "class='card-action-red'")." para ir a Inicio."); 
						/*Fin Guardar Datos*/
					}//Fin validacion correos
				}//Fin else validacion lugar de nacimiento
			}//Fin else validacion de campos
		}
		unset($_POST["registrarme"]); 
	}
	
	/**************************************Funcion Correcion de Nombres***************************************/
	public function correccion($correc=0){
 		View::template(NULL); 
 		$this->correc=$correc; 
     }	 
	 
	/***************************************Enviar Correo a Regular *******************************************/
	
	public function correoregular($numcar,$correo)
		{
		$cpt=Load::model('ceestpt')->busca_uno($numcar);
		$cp=Load::model('ceestp')->busca_uno($numcar);
		$usuario	= $cpt->usuario;
		$palabra	= $cpt->palabra;
		$nombre	= $cp->nomest." ".$cp->apeest;
			
		$mail 	  	 	  = new phpmailer();
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
		$mail->AddAddress(trim($correo));		
		$mail->Subject    = "Datos de Confirmacion Inscripcion en la UNEFM";
		$mail->Body       = "<h3>Hola, ".$nombre." Bienvenido(a) a la UNEFM.</h3><br><b>Nombre de Usuario.:</b> ".$usuario."<br><b>Contrase&#241;a Inicial.:</b> ".$palabra." (Puedes cambiarla una vez que ingreses al Portal.)<br><br>Dudas y Sugerencias envia un Correo Electronico a: <b>soporte@correo.unefm.edu.ve</b><br><br><br><br>'Las naciones marchan hacia el t&eacute;rmino de su grandeza,<br>con el mismo paso que camina la educaci&oacute;n...'<br><b>Sim&oacute;n Bol&iacute;var</b><br>Potos&iacute;, Octubre de 1825";			
		$mail->AltBody    = "Mensaje solo Text";			
		$exito = $mail->Send();			
		$intentos = 1;
		$errores = 1;
		while ((!$exito) && ($intentos < 5)) 
			{sleep(3);
			 $exito = $mail->Send();
			 $intentos = $intentos+1;
		}
		if($exito){
			Load::model('ceestpt')->actualizaControl($numcar,4);
			Flash::success("Registro Completado Satisfactoriamente. Sus datos de Ingreso fueron enviados a su Correo Electrónico. Presione ".Html::link("principal/index", "aquí", "class='card-action-red'")." para ir a Inicio.");
		}else{
			Flash::error("Error: Por favor Contacte soporte@correo.unefm.edu.ve");
		}
		return $exito;
	}

	/***************************************Enviar Nuevo Ingreso*******************************************/
	
	public function correonuevoin($numcar,$correo)
		{
		$cp=Load::model('ceestemp')->find_first("numced='$numcar'");
		$nombre	= $cp->nomest." ".$cp->apeest;
			
		$mail 	  	 	  = new phpmailer();
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
		$mail->AddAddress(trim($correo));		
		$mail->Subject    ="Datos de Confirmacion Inscripcion en la UNEFM";
		$mail->Body       = "<h3>Hola, ".$nombre." Bienvenido(a) a la UNEFM.</h3> Tu registro fue procesado exitosamente.<br>En la pagina web de la unefm <b>www.unefm.edu.ve</b> estan publicadas la fechas de inscripci&oacute;n y recepci&oacute;n de documentos. <br>Despues que tus datos sean validados por la Direcci&oacute;n de Control de Estudios, te enviaremos un nuevo correo; con el usuario y la contraseña con la que podras ingresar al sistema en linea. <b>Gracias </b><br><br>Dudas y Sugerencias envia un Correo Electronico a: <b>soporte@correo.unefm.edu.ve</b> o comunicate al telefono: 0268-2502505<br><br><br><br>'Las naciones marchan hacia el t&eacute;rmino de su grandeza,<br>con el mismo paso que camina la educaci&oacute;n...'<br><b>Sim&oacute;n Bol&iacute;var</b><br>Potos&iacute;, Octubre de 1825";			
		$exito = $mail->Send();			
		$intentos = 1;
		$errores = 1;
		while ((!$exito) && ($intentos < 5)) 
			{sleep(3);
			 $exito = $mail->Send();
			 $intentos = $intentos+1;
		}
		if($exito){
			Load::model('ceestemp')->actualizaControl($numcar,2);
			Flash::success("Registro Completado Satisfactoriamente. Presione ".Html::link("principal/index", "aquí", "class='card-action-red'")." para ir a Inicio.");
		}else{
			Flash::error("Error: Por favor Contacte soporte@correo.unefm.edu.ve");
		}
		return $exito;
	}
}

