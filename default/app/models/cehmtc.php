<?php
class Cehmtc extends ActiveRecord 
	{
	public function initialize ()
    {
        $this->primary_key=array('numcar', 'codcar', 'codsed', 'tiphor', 'codmat', 'indsig', 'numper', 'numano', 'indmat');
    
	}

	public function bus_rep ($codcar,$numcar)
    { //funcion para buscar repitencias del estudiante
		$rep=$this->find_all_by_sql("select codmat,nommat,count(codmat) from cehmtc where codcar='$codcar' and numcar='$numcar' and indmat!='RT' and numcar||codcar||codmat not in(select numcar||codcar||codmat from cehmtc where codcar='$codcar' and numcar='$numcar' and indnrp in('AP','EQ')) group by codmat,nommat having count(codmat)>=5");
		return $rep;
    
	}
	
	public function busca_notas($numcar,$codcar,$page=1,$perpage=25){
		return $this->paginate("page: $page","per_page: $perpage","conditions: numcar='$numcar' and codcar='$codcar'","order: numano asc,numper asc,codmat");
		//$this->find("conditions: numcar='$numcar' and codcar='$codcar'","order: numano asc,numper asc,codmat");
	}
	
}	
?>
