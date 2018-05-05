<?php
Load::lib('auth2');
class Usuarios extends ActiveRecord
	{
	public function initialize ()
    	{$this->primary_key=array('cedusu');}

 	public function login($usuario, $password){
        $auth = Auth2::factory('model');
        $auth->setLogin('login');
        $auth->setPass('password'); 
        $auth->setModel('usuarios');
        $auth->setFields(array('cedusu','login'));
        $password=sha1($password);
        if($auth->identify($usuario, $password,'auth'))  
        	{
                $cedusu = Session::get('cedusu');
                return true;
            }else{
                return false;
            } 
    }                         	   
    
  	public function logout(){
        Auth2::factory('model')->logout();
    }	

	public function logged()  {
        if(Session::has('cedusu'))
            return true;
        else
            return false;
    }
	

    public function busca_uno($id){
        return $this->find_first("cedusu='$id'");
    }

}
?>
