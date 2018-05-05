<?php
class Ceprse extends ActiveRecord{

	public function initialize (){
        $this->primary_key=array('numced', 'codsed', 'tiphor', 'codniv');
    }

 	public function datos($id){
        return $this->find_first("numced='$id'");
    }
}
?>
