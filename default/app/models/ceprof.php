<?php
Load::lib('auth2');
class Ceprof extends ActiveRecord
	{
	public function initialize ()
    	{$this->primary_key=array('numced');}

 	public function login($usuario, $password)
    	{
        
        $auth = Auth2::factory('model');
        $auth->setLogin('login');
        $auth->setPass('password'); 
        $auth->setModel('ceprof');
        $auth->setFields(array('numced','login','control'));
        $password=sha1($password);
        if($auth->identify($usuario, $password,'auth'))  
        	{
        	if(Session::get('control')!=5)
        		{Flash::error('Registro Incompleto ');
        		 return false;}	
        	else
        		{
                $numced = Session::get('numced');

                if($ds = Load::model('ceprse')->datos($numced)){ 
                    $su = array('numced' => $ds->numced,
                                'codsed' => $ds->codsed,
                                'tiphor' => $ds->tiphor,
                                'codniv' => $ds->codniv,
                                'aclp'   => $ds->aclp);   
                    Session::set('su', $su);
                    return true;
                    }else{return false;} 
                }                         	
                return true;
        }else{return false;}
    }

  	public function logout()
    	{
        if(Session::get('su'))
             Session::delete('su');
        if(Session::get('numced'))
            Session::delete('numced');
        if(Session::get('login'))
            Session::delete('login');
        if(Session::get('control'))
            Session::delete('control');
        Auth2::factory('model')->logout();
        }	

	public function logged()
    	{
        if(Session::has('numced') and Session::has('control'))
            return true;
        else
            return false;
        }
	

    public function busca_uno($id){
        return $this->find_first("numced='$id'");
    }

   
	public function actualizaControl($numced,$control){
         return $this->find_all_by_sql("update ceprof set control=$control where numced='$numced'");
    }
}
?>
