<?php
Load::lib('auth2');
class Ceestpt extends ActiveRecord
	{
	public function initialize ()
    	{$this->primary_key=array('numcar');}

 	public function login($usuario, $password)
    	{
        
        $auth = Auth2::factory('model');
        $auth->setLogin('usuario');
        $auth->setPass('palabra'); 
        $auth->setModel('ceestpt');
        $auth->setFields(array('numcar','usuario','control'));
        if($auth->identify($usuario, $password,'auth'))  
        	{
        	if(Session::get('control')!=4)
        		{Flash::error('Registro Incompleto ');
        		 return false;}	
        	else
        		{
                $numcar = Session::get('numcar');

                if($datos_sesion = Load::model('ceestp')->datos($numcar))
                    { 
                    foreach($datos_sesion as $ds) { };
                    $su = array('numcar' => $ds->numcar,
                                'codcar' => $ds->codcar,
                                'tiphor' => $ds->tiphor,
                                'possrt' => $ds->possrt,
                                'condac' => $ds->condac,
                                'codpln' => $ds->codpln,
                                'codsed' => $ds->codsed,
								'indsig' => $ds->indsig,
								'numano' => $ds->numano,
								'numper' => $ds->numper);   
                    Session::set('su', $su);

                   //print_r($su);
                    return true;
                    }
                else
                    {return false;} 
                }                         	
                return true;
        	}
        else 
	        {//Flash::error($auth->getError());        
             return false;}
    	}

  	public function logout()
    	{
        if(Session::get('su'))
             Session::delete('su');
        if(Session::get('numcar'))
            Session::delete('numcar');
        if(Session::get('usuario'))
            Session::delete('usuario');
        if(Session::get('control'))
            Session::delete('control');
        Auth2::factory('model')->logout();
        }	

	public function logged()
    	{
        if(Session::has('numcar') and Session::has('control'))
            return true;
        else
            return false;
        }
	

    public function busca_uno($id){
        return $this->find_first("numcar='$id'");
    }

    public function modificar($numcar,$idpais,$idents,$idcius,$idmuns,$idpars,$correo=""){
         if($correo==""){
			 $correo=Input::request("correo"); 
		 }
	     if($idpais==232){
            $idcius=substr($idcius,strlen($idents)+1,strlen($idcius));
            $idmuns=substr($idmuns,strlen($idents)+1,strlen($idmuns));
         }
         return $this->find_all_by_sql("update ceestpt set correo='$correo',codpai='$idpais',codent='$idents',
         codciu='$idcius',codmun='$idmuns',codpar='$idpars',control='4'  where numcar='$numcar'");
    }
	
	public function actualizaControl($numcar,$control){
         return $this->find_all_by_sql("update ceestpt set control=$control where numcar='$numcar'");
    }
}
?>
