<?php

/**
 * Controller por defecto si no se usa el routes
 * 
 */
class IndexController extends AppController
{
	
	
  	public function index(){
		View::template('principal');
		if(isset($_POST["aceptar"])){
			$usuario   = $_POST["login"];
		 	$password  = $_POST["password"];
			if(strlen($usuario)==0)
	 			{flash::error("Debes Colocar tu Nombre de Usuario");}
		 	elseif(strlen($password)==0)
	 			{flash::error("Debes Colocar tú Password");}
		 	else{
        		if(Load::model('usuarios')->login($usuario, $password)){
        				return Redirect::route_to("controller: mensaje", "action: msg", "id: 1");
        		}else{
        			flash::error("Acceso Incorrecto!");
        		}
			}
			unset($_POST["aceptar"]); 
		}        
	    Load::model('usuarios')->logout();

    }

    public function logout(){
    	View::select(null);
    	echo "<script type='text/javascript'> 
    	window.location.href='". PUBLIC_PATH ."'; 
    	</script>";
    }	

   
}

