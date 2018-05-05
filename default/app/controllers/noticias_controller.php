<?php

/*** Controller Noticias: maestro de noticias ***/

class NoticiasController extends AppController
{
	
    public function actualizacion($idnot=0){
		$this->open=1;
		$this->idnot=$idnot;
		View::template('areadenoticias');
	}
	
	public function todas($idtab=0){
		$this->open=0;
		$this->idtab=$idtab;
		View::template('areadenoticias');
	}
}