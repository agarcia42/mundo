<?php
class Ceesta extends ActiveRecord{
	
	
	public function initialize (){
        $this->primary_key=array('numcar', 'codcar');
    }
		
	public function busca_uno($id,$co){
			if($co=="0")
				return $this->find_first("conditions: numcar = '$id'","order: status asc");
			else
				return $this->find_first("conditions: numcar = '$id' and codcar='$co'","order: status asc");
	}
	
	public function busca_cads($id){
				return $this->find("conditions: numcar = '$id'","order: status asc");
	}

	public function creditos_maximos($numcar='', $codcar='')
      {
      $sql = ("SELECT obtener_creditos_maximos_unefm as creditos from public.obtener_creditos_maximos_unefm('$numcar','$codcar')");
      $a = $this->find_all_by_sql($sql);
      foreach ($a as $k)
         {return $k->creditos;}
      }  
	
}
?>
