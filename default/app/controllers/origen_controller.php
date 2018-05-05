<?php

/**
 * Controller datapers: maestro de datos personales
 * 
 */
class OrigenController extends AppController
{
	
	public function estado($pais_id='0'){
 		View::template(NULL); 
 		$this->pais_id=$pais_id;
     }

     public function ciudades($entidad_id='0'){
 		View::template(NULL); 
 		$this->entidad_id=$entidad_id;
     }

      public function municipio($entidad_id='0'){
 		View::template(NULL); 
 		$this->entidad_id=$entidad_id;
     }

      public function parroquia($municipio_id='0'){
 		View::template(NULL); 
 		$this->municipio_id=$municipio_id;
     }
	 
}